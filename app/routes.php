<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::pattern('post_id', '[0-9]+');
Route::pattern('group_id', '[0-9]+');
Route::pattern('user_id', '[0-9]+');
Route::pattern('aspect_ratio', '[0-9]+');
Route::pattern('photo_id', '[0-9]+');



//Sample use of Intervention/image
// Route::get('/pic', function()
// {
//     $img = Image::make(asset('assests/icon/iso_logo.png'))->resize(200, 200);

//     return $img->response('jpg');
// });


//http response for image with original quality
Route::get('profile_pic/{aspect_ratio}/{image_name?}' , function($image_name = NULL,$aspect_ratio){
		if($image_name){ 
			$img = Image::make('store/photo/original/'.$image_name)
			->resize(null, $aspect_ratio, function ($constraint) {
					 $constraint->aspectRatio();
			});
		}else{
			$img = Image::make('store/photo/lowsize_image/default.png');
		}
	return $img->response('jpg');
}) ;
 
//with crop width is halfed
Route::get('profile_pic/crop/{image_name?}' , function($image_name = NULL ){
	if($image_name){
		$img = Image::make('store/photo/original/'.$image_name)
		->resize(null, 200, function ($constraint) {
				 $constraint->aspectRatio();
		});
		$width = $img->width() ;
		$height = $img->height();
		$img->crop($width - $width/4, $height ,round($width/6), 0) ;
	}else{
			$img = Image::make('store/photo/lowsize_image/default.png');
	}
	return $img->response('jpg');
}) ;

//http response for image with original quality
Route::get('profile_pic/{image_name?}' , function($image_name = null){
	if($image_name)
	$img = Image::make('store/photo/original/'.$image_name);
	else
		$img = Image::make('store/photo/lowsize_image/default.png');
	return $img->response('jpg');
}) ;


//with crop width is halfed low
Route::get('profile_pic/low/crop/{image_name?}' , function($image_name = NULL ){
	if($image_name){
		$img = Image::make('store/photo/original/'.$image_name) ;
		// ->resize(null, 200, function ($constraint) {
		// 		 $constraint->aspectRatio();
		// });
		// $width = $img->width() ;
		// $height = $img->height();
		// $img->crop($width - round($width/3), $height ,round($width/6), 0) ;

		//$img->fit(600, 360);

		// crop the best fitting 1:1 ratio (200x200) and resize to 200x200 pixel
		$img->fit(100);
	}else{
			$img = Image::make('store/photo/lowsize_image/default.png')->fit(100);
	}
	return $img->response('jpg');
}) ;

//http response for image with lowsize_image quality
Route::get('profile_pic/low/{image_name?}' , function($image_name = null){
	if($image_name)
	$img = Image::make('store/photo/lowsize_image/'.$image_name);
	else
		$img = Image::make('store/photo/lowsize_image/default.png');
	return $img->resize(100,100)->response('jpg');
}) ;


Route::get('user/photo/'  , array('uses' => 'UserController@showPhoto'))->before('auth') ;
Route::get('user/photo/set/{photo_id}'  , array('uses' => 'UserController@setProfilePhoto'))->before('auth') ;

Route::get('user/photo/show/{photo_id}' ,array('uses' => 'UserController@showPhotoById'))->before('auth');

//about us
Route::get('about', function()
{
	return View::make('isoconnect.about');
}) ;

Route::get('post/pic/crop/{photo_id}' , function($photo_id = null) {
	$photo = Post::find($photo_id) ;
	
	if($photo->source_type == 'post'){
		if($photo_id){
			$img = Image::make('store/photo/original/'.$photo->location);
			return $img->resize(100,100)->response('jpg');
		}
	}
	$img = Image::make('store/photo/lowsize_image/default.png');
	return $img->resize(100,100)->response('jpg');
})->before('auth');
Route::get('post/pic/{photo_id}' ,array('uses' => 'UserController@showPostPhotoById'))->before('auth');




//dynamic chatting route
Route::post('messenger' , array('uses' => 'MessagesController@messengerHandler'))->before('auth') ;








Route::get('/', function()
{
	return Redirect::to('home');
})->before('auth') ;

//for reporting
Route::get('support', function()
{
	return View::make('emails.support');
})  ;

Route::post('support', array('before' => 'csrf' , 'uses' => 'HomeController@doSubmitReport'))  ;

//group 0 is home
Route::get('group/0', function()
{
	return Redirect::to('home');
})->before('auth') ;

//group edit 
Route::get('group/edit/{group_id}', function($group_id)
{
	$permission = Auth::user()->isadmin($group_id);
	if($permission){
		$group = Group::find($group_id);
		return View::make('groups.edit')->with('group',$group);
	}
	return Redirect::to('home')->with('flash_error','Permission Access Denied');
})->before('auth') ;
 
Route::post('group/edit/{group_id}' , ['before' => 'csrf', 'uses' => 'GroupsController@edit'])->before('auth');


//home handler
Route::get('home' , array('uses' => 'HomeController@showPost'))->before('auth') ;

//post view handler
Route::get('post/{post_id}' , array('uses' => 'PostsController@showPostId'))->before('auth') ;

//post delete handler
Route::get('post/delete/{post_id}' , array('uses' => 'PostsController@delete'))->before('auth') ;

//group view handler
Route::get('group/{group_id}' , array('uses' => 'GroupsController@showGroup'))->before('auth') ;

//Profile
//Route::get('user/profile' , array('uses' => 'HomeController@showProfile', 'as' => 'user.profile'))->before('auth') ;


//Register
// route to show the register form
Route::get('register' , array('uses' => 'HomeController@showRegister'))->before('guest') ;

// route to process the form
Route::post('register' , array('before' => 'csrf' , 'uses' => 'HomeController@doRegister')) ;

//Login
// route to show the login form
Route::get('login' , array('uses' => 'HomeController@showLogin'))->before('guest') ;

// route to process the form
Route::post('login' , array('before' => 'csrf' , 'uses' => 'HomeController@doLogin')) ;

//Logout
// route to the logout process
Route::get('logout' , array('uses' => 'HomeController@doLogout'))->before('auth') ;



//message count for javascript
Route::get('user/message/count', array('uses' => 'HomeController@unreadmessage'))->before('auth') ;
//notification count for javascript
Route::get('user/notification/count', array('uses' => 'HomeController@unreadnotification'))->before('auth') ;

//post_handler
Route::post('user/post' , array('before' => 'csrf' , 'uses' => 'PostsController@createPost'))->before('auth') ; 

//comment handler
Route::post('user/comment' , array('before' => 'csrf' , 'uses' => 'PostsController@createComment' ))->before('auth') ; 

//group post handler
Route::post('group/post' , array( 'before' => 'csrf' , 'uses' => 'GroupsController@createGroupPost'))->before('auth') ;

//send group request
Route::post('group/send_request' , array( 'before' => 'csrf' , 'uses' => 'GroupsController@sendGroupRequest'))->before('auth') ;

//handle group request
Route::post('group/handle_request' , array( 'before' => 'csrf' , 'uses' => 'GroupsController@handleGroupRequest'))->before('auth') ;

//show notification
Route::get('/user/notification/show' , array( 'uses' => 'NotificationsController@showNotification'))->before('auth') ;

//show message
Route::get('/user/message/show' , array('uses' => 'MessagesController@showMessagelist'))->before('auth') ;

//show message from another specific user
Route::get('/user/message/{user_id}' , array('uses' => 'MessagesController@showMessage'))->before('auth') ;

//message handler
Route::post('/user/message/handler' , array('before' => 'csrf' , 'uses' => 'MessagesController@messagehandler'))->before('auth') ;

//create a group
Route::get('group/register' , array('uses' => 'GroupsController@showcreateGroup'))->before('auth') ;
Route::post('group/register' , array('before' => 'csrf' ,'uses' => 'GroupsController@createGroup'))->before('auth') ;

//Profile pramod
Route::get('user/profile' , array('uses' => 'UserController@showProfile', 'as' => 'user.profile'))->before('auth') ;

Route::get('user/{user_id}',function($user_id){
	return Redirect::to('user/'.$user_id.'/profile');
});

//Profile info pramod
Route::get('user/profile/info' , array('uses' => 'UserController@showProfileInfo', 'as' => 'user.profile.info'))->before('auth') ;

//Profile edit pramod
Route::get('user/profile/edit' , array('uses' => 'UserController@editProfileInfo'))->before('auth') ;

Route::post('user/profile/edit' , array('before' => 'csrf' , 'uses' => 'UserController@doEditProfile' ))->before('auth') ; 

Route::get('user/{id}/profile' , array('uses' => 'UserController@showPublicProfile'))->before('auth') ;

Route::get('user/{id}/profile/info' , array('uses' => 'UserController@showPublicProfileInfo'))->before('auth') ;

Route::get('post/{id}/like' , array('uses' => 'LikesController@LikePost'))->before('auth') ;

//change password
Route::get('user/password' , function(){
	return View::make('users.password') ;
})->before('auth') ;

Route::post('user/password' , array('before' => 'csrf' , 'uses' => 'UserController@changePassword' ))->before('auth') ; 





//using mail stuff
//email verification
Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'HomeController@confirm'
]);

//resend verification
Route::get('resend_confirm' ,function(){
	return View::make('emails.resend_verfication');
})->before('guest');

Route::post('resend_confirm' ,array('before' => 'csrf' , 'uses' => 'HomeController@resend_confirm'))->before('guest');

Route::get('search/query' , array('uses' => 'HomeController@search'))->before('auth') ;

Route::get('search' ,array('uses' => 'HomeController@showsearch'))->before('auth');

Route::get('search/group/{group_id}/user/' , array('uses' => 'GroupsController@showSearch'))->before('auth') ;

//Password Reset
Route::get('password_reset' ,function(){
	return View::make('emails.password_reset');
})->before('guest');

Route::post('password_reset' , array('before' => 'csrf' ,'uses' => 'HomeController@password_reset'))->before('guest');

//reset form
Route::get('password_reset/{confirmationCode}' , function($confirmationCode){
	return View::make('emails.reset_password')->with('confirmationCode',$confirmationCode);
})->before('guest');

Route::post('password_reset/{confirmationCode}' , array('before' => 'csrf' ,'uses' => 'HomeController@password_reset_withCode'))->before('guest');



