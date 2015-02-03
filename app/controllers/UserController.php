<?php

class UserController extends BaseController {

	public function showProfile() 
	{
		$groups = User::find(Auth::id())->groups()->get() ;

		//for user_posts
		$posts = Post::where('user_id','=', Auth::user()->id)->orderBy('id','desc')->simplePaginate(10);

		return View::make('users.profile.view' , compact('posts', 'groups'));
	}

	public function showProfileInfo() 
	{
		//for user_posts
		
		$groups = User::find(Auth::id())->groups()->get() ;
		return View::make('users.profile.info', compact('groups'));
	}

	public function editProfileInfo() 
	{
		//for user_posts
		
		$groups = User::find(Auth::id())->groups()->get() ;
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
			'contact' => 'digits_between:5,12'
			
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
			User::find(Auth::id())->update($data);
			return Redirect::to('/user/profile/info');
			}

			
		}

		public function showPublicProfile($id) 
	{

		$groups = User::find($id)->groups()->get() ;

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
		

		

}