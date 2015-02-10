<?php

class UserController extends BaseController {

	public function showProfile() 
	{
		$groups = User::find(Auth::id())->groups() ;

		//for user_posts
		$posts = Post::where('user_id','=', Auth::user()->id)->orderBy('id','desc')->simplePaginate(10);

		return View::make('users.profile.view' , compact('posts', 'groups'));
	}

	public function showProfileInfo() 
	{
		//for user_posts
		
		$groups = User::find(Auth::id())->groups();
		return View::make('users.profile.info', compact('groups'));
	}

	public function editProfileInfo() 
	{
		//for user_posts
		
		$groups = User::find(Auth::id())->groups() ;
		return View::make('users.profile.edit', compact('groups'));
	}

	public function doEditProfile() 
	{
		//
		
		$messages = array(
   		 'name.required' => 'You Must Have A Name' , 
		);

		//validate the info , create rules for the inputs
		$rules = array(
			'name' => 'required|alpha_spaces|min:4|max:32',
			'address' => 'alpha_dash',
			'contact' => 'digits_between:5,12',
			'dob' => 'date',
			'company' => 'alpha_spaces'
		);


		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all() ,$rules , $messages) ;

		//if the validator fails, redirect back to the form
		if($validator->fails()) {
			return Redirect::back()
				->withErrors($validator) //send back all errors to the
				->withInput();
		}
		else{

			$data = Input::only(['name', 'address', 'gender', 'contact', 'dob', 'company']);
 
			$User = User::find(Auth::id());
			$check = $User->update($data) ;
			 
			if($check)
				return Redirect::to('/user/profile/info')->with('flash_notice','Changed Successfull')	;
			else
				return Redirect::to('/user/profile/info')->with('flash_notice','Cant Proceed At the moment Try Again');
			}

			
		}

		public function showPublicProfile($id) 
	{

		$groups = User::find($id)->groups() ;

		if($id == Auth::user()->id)
		{
			return Redirect::to('/user/profile');
		}
		$user = User::find($id);
		//for user_posts
		$posts = Post::where('user_id','=', $id)->orderBy('id','desc')->simplePaginate(10);

		return View::make('users.profile.publicView' , compact('user', 'posts', 'groups'));
	}


	public function showPublicProfileInfo($id) 
	{
		//for user_posts
		
		$groups = User::find($id)->groups()->get() ;
		$user = User::find($id);

		return View::make('users.profile.publicInfo', compact('user', 'groups'));
	}
		

	public function changePassword(){

		$messages = array(
   		 'g-recaptcha-response.required' => 'We need to know if you are a human!',
		);
		//validate the info , create rules for the inputs
		$rules = array(
			'password_current' => 'required|alphaNum',
			'password' => 'required|alphaNum|min:3|Confirmed', //password can only be alphanumeric and has to be greater than 3 characters
			'password_confirmation' => 'required' ,
			'g-recaptcha-response' => 'required|recaptcha',
		);


		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all() ,$rules,$messages ) ;

		//if the validator fails, redirect back to the form
		if($validator->fails()) {
			
			return Redirect::back()
				->withErrors($validator); //send back all errors to the
			
			}else{


				$password_current = Input::get('password_current');
				$new_password = Input::get('password');
				
				if(Hash::check($password_current,Auth::user()->password)){
					
					if($password_current == $new_password)
						 return Redirect::back()->withErrors(['password' => 'New Password is same as Old Password'])	;

					$User = User::find(Auth::id());
					$check = $User->update([
						'password' => Hash::make($new_password)
						]) ;
				 
					if($check){
						
						Mail::queue('emails.password_change_remender', array('name' => Auth::user()->name), function($message) {
			            $message->to(Auth::user()->email, Auth::user()->name)
			                ->subject('Password Changed');
						});

						return Redirect::back()->with('flash_notice','Changed Successfull')	;
					}
					else
						return Redirect::back()->with('flash_notice','Can\'t Proceed At the moment Try Again');
				}else{
					return Redirect::back()->with('flash_error','Current Password is Wrong');
				}
	 }


	}










}