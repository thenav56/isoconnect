<?php

class GroupsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /groups
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /groups/create
	 *
	 * @return Response
	 */
	public function showcreateGroup()
	{
			return View::make('groups.register') ;
	}

	public function createGroup()
	{
		//custom message
		$messages = array(
   		 'g-recaptcha-response.required' => 'We need to know if you are a human!',
   		 'about_group.required' => 'There must be something about the group' ,
   		 'name.required' => 'A group must have a Name' , 
		);

		$rules = array(
			'name' => 'required|alpha_num_dashes|Unique:groups|min:4|max:32' , 
			'g-recaptcha-response' => 'required|recaptcha' , 
			'about_group' => 'required|min:4|max:300'
			) ;

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all() ,$rules, $messages) ;

			if($validator->fails()){
				return Redirect::to('group/register')
				->withErrors($validator)
				->withInput(Input::all()) ;
			}else{
		 
				$newGroup = Group::create([
					'admin_id' => Auth::id() ,
					'name' => htmlentities(Input::get('name')),
					'about' => htmlentities(Input::get('about_group')) ,
					]);

				if($newGroup){
					return Redirect::to('group/'.$newGroup->id)
					->with('flash_notice' , 'Successfully created You Group');
				}

				return Redirect::to('group/register')
				->withInput(Input::all())
				->with('flash_error' , 'Cannt Process Your Request::	Please Try Again Later');
		}

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /groups
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /groups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */


	public function handleGroupRequest()
	{

		$user_id = Input::get('request_user_id') ;

		switch (Input::get('button_submit')) {
			case 'accept':
				$result = UserGroup::where('user_id', '=', $user_id )->update(array('active' => 1));
				$message = User::where('id' , '=' , $user_id)->first()->name.' has been sucessfully added to the Group' ;
					break;

			case 'reject':
				$result = UserGroup::where('user_id', '=', $user_id )->delete();
				$message = User::where('id' , '=' , $user_id)->first()->name.' request has been rejected' ;
					break;

			case 'delete':
				$result = UserGroup::where('user_id', '=', $user_id )->where('active', '=', 1 )->delete();
				$message = User::where('id' , '=' , $user_id)->first()->name.' has been sucessfully deleted from the Group' ;
					break;

			case 'block':
			$result = UserGroup::where('user_id', '=', $user_id )->update(array('active' => 2));
			 $message = User::where('id' , '=' , $user_id)->first()->name.' has been sucessfully blocked in this Group' ;
					break;
		}
		
		if($result){
			return Redirect::back()->
			with('flash_notice' , $message ) ;
		}else{
			return Redirect::back()->
			with('flash_error' , 'Request was not Successfull:: Try Aagin later' ) ;
		}
	}

	public function sendGroupRequest()
	{

		$user_id = Auth::id() ; 
		$group_id = Input::get('group_id') ;
		$UserGroups =  UserGroup::where('user_id' , '=' , Auth::id() )->where('group_id' , '=' , $group_id)->get() ;
		if($UserGroups->count()){

			}else{
			$status = UserGroup::create([
				 'user_id'	 => $user_id ,
				 'group_id'	 => $group_id ,
				 'active'    => 0
				]);
			if($status){
						return Redirect::back()->with('flash_notice' , 'Request Has Been Send!') ;
			}else{
						return Redirect::back()->with('flash_error' , 'Request Failed')	;
			}
		}

	}


	public function createGroupPost()
	{
		
		$rand = Session::get('rand_id_generate') ;
		 
		$randhash = hash('md4' , Input::get('post_group_id').$rand) ;
		
		$hashed_token = Input::get('post_group_id_token') ;
		
		if($randhash === $hashed_token){
			$rules = array(
				'user_post' => 'required|max:250' , 
				'post_group_id' => 'exists:groups,id'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all() ,$rules) ;

			//if the validator fails, redirect back to the form
			if($validator->fails()) {
				return Redirect::back()
					->withErrors($validator) ; //send back all errors to the
			}else{
				$userPost = htmlentities(Input::get('user_post')) ;
				$group_id = Input::get('post_group_id') ;
				$user_id = Auth::id() ;
				$status = Post::create([
						'user_id'	=> $user_id ,
						'post_body' => $userPost,
						'like'		=>  0,
						'dislike'	=>  0,
						'group_id'	=> $group_id,
					]);

				if($status){
					return Redirect::back()->with('flash_notice' , 'Successfully Posted') ;
				}else{
					echo Redirect::back()->with('flash_error' , 'Post Failed Try Again!') ;	
				}
			}
		}else{
			return Redirect::back()->with('flash_error' , 'Post Failed Try Again!!')  ;
		}

	}


	public function showGroup($group_id)
	{
		//authticatoin for group_id
		$rand = mt_rand() ;

		Session::put('rand_id_generate',  $rand) ;

		//if user is the admin	
		$admin = (Group::where('id' , '=' ,$group_id)->first()->admin_id == Auth::id()) ? true : false ;

		//if user is blocked active = 2
		$block = (UserGroup::where('group_id' , '=' ,$group_id)->where('user_id' , '=' , Auth::id() )->where('active' , '=' , 2 )->get()->count() ) ? true : false ;

		//Group joined by the user
		$UserGroups =  UserGroup::where('user_id' , '=' , Auth::id() )->where('group_id' , '=' , $group_id)->get() ;

		$pending = false ;
		$active = false ;

		if(!$block){
			if(!$admin){	//normal user
				//if the user is in the list(i.e request may or may not be accepted)
				if($UserGroups->count()){

						if($UserGroups->first()->active){
							//post related to the groups
							$GroupPosts = Post::where('group_id' , '=' ,$group_id)->orderBy('id' , 'desc')->simplePaginate(10) ;

							$active = true ;

							return View::make('groups.show')->with('group_id' , $group_id)->with('active' , $active )
							->with('posts',$GroupPosts)->with('rand' , $rand)->with('pending' , $pending)
							->with('admin' , $admin )->with('block' , $block) ;
						}else{
							$pending = true ;
						}
				}else{
					$active = false ;
				}

			}else{ //group admin
				Paginator::setPageName('page') ;
				$GroupPosts = Post::where('group_id' , '=' ,$group_id)->orderBy('id' , 'desc')->simplePaginate(10) ;

				$active = true ;

				Paginator::setPageName('userspending') ;
				$usersPending = UserGroup::where('group_id' , '=' , $group_id)->where('active',  '=' , '0' )->orderBy('id' , 'desc')->simplePaginate(5) ;

				Paginator::setPageName('activeusers') ;
				$activeUsers = UserGroup::where('group_id' , '=' , $group_id)->where('active',  '=' , '1' )->orderBy('id' , 'desc')->simplePaginate(5) ;
				

				return View::make('groups.show')->with('group_id' , $group_id)->with('active' , $active )
				->with('posts',$GroupPosts)->with('rand' , $rand)->with('pending' , $pending)
				->with('admin' , $admin )->with('usersPending' , $usersPending)
				->with('activeUsers' , $activeUsers)->with('block' , $block) ;
			}
		}else{
			//for blocked users
			return View::make('groups.show')->with('block' , $block)->with('group_id' , $group_id)
			->with('admin' , false ) ;
		}
		return View::make('groups.show')->with('group_id' , $group_id)->with('active' , $active )
		->with('pending' , $pending)->with('admin' , $admin )->with('block' , $block) ;
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /groups/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /groups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /groups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}