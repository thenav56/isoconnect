<?php

class GroupsController extends \BaseController {

	 
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

	 


	public function handleGroupRequest()
	{

		$user_id = Input::get('request_user_id') ;
		$group_id = Input::get('group_id') ;
		$permission = User::find(Auth::id())->isadmin($group_id) ;
		
		if($permission){
			switch (Input::get('button_submit')) {
				case 'accept':
					$result = UserGroup::where('user_id', '=', $user_id )->where('group_id', '=', $group_id )->first() ;
					$status = $result->update(array('active' => 1));					
					$message = User::find($user_id)->name.' has been sucessfully added to the Group' ;
						break;

				case 'delete':
					$result = UserGroup::where('user_id', '=', $user_id )->where('group_id', '=', $group_id )->first() ;
					$status = $result->delete();
					$message = User::find($user_id)->name.' request has been rejected' ;
						break;
 

				case 'block':
				$result = UserGroup::where('user_id', '=', $user_id )->where('group_id', '=', $group_id )->first() ;
				$status = $result->update(array('active' => 2));
				 $message = User::find($user_id)->name.' has been sucessfully blocked in this Group' ;
						break;

				case 'unblock':
				$result = UserGroup::where('user_id', '=', $user_id )->where('group_id', '=', $group_id )->first() ;
				$status = $result->update(array('active' => 1));
				$message = User::find($user_id)->name.' has been sucessfully unblocked in this Group' ;
						break;
			}
			
			if($status){
				Notification::send("User_group_status" , $result );
				return Redirect::back()->
				with('flash_notice' , $message ) ;
			}else{
				return Redirect::back()->
				with('flash_error' , 'Request was not Successfull:: Try Aagin later' ) ;
			}
		}else{
				return Redirect::back()->
				with('flash_error' , 'Request was not Successfull:: Try Aagin later!!' ) ;
			}
	}


	public function sendGroupRequest()
	{

		if(Input::has('button_submit'))
			if(Input::get('button_submit')== 'cancle'){
				$user_id = Auth::id();
				$group_id = Input::get('group_id') ;
				$UserGroup = UserGroup::where('user_id','=',$user_id)->where('group_id','=',$group_id)->first();
				if($UserGroup){
					$UserGroup->delete() ;
					return Redirect::back()->with('flash_notice' , 'You Leaved the Group')	;
				}
				return Redirect::back()->with('flash_error' , 'something went wrong')	;
			}
		if(Input::has('request_user_id')){
			//request is send by the admin
			$user_id = Input::get('request_user_id');
			$group_id = Input::get('group_id') ;
			if(Auth::id() != Group::find($group_id)->admin_id )
					return Redirect::back()->with('flash_error' , 'Admin can only have permission')	;
			$UserGroups =  UserGroup::where('user_id' , '=' , $user_id )->where('group_id' , '=' , $group_id)->get() ;
			if($UserGroups->count()){
					return Redirect::back()->with('flash_error' , 'Request already send')	;
				}else{
				$status = UserGroup::create([
					 'user_id'	 => $user_id ,
					 'group_id'	 => $group_id ,
					 'active'    => 3
					]);
				if($status){
					Notification::send("User_group_status" , $status );
							return Redirect::back()->with('flash_notice' , 'Request Has Been Send!') ;
				}else{
							return Redirect::back()->with('flash_error' , 'Request Failed')	;
				}
			}
		}else{//request is send by the user to the group
			$user_id = Auth::id() ; 
			$group_id = Input::get('group_id') ;
			$UserGroups =  UserGroup::where('user_id' , '=' , Auth::id() )->where('group_id' , '=' , $group_id)->get() ;
			if($UserGroups->count()){
				if($UserGroups->first()->active == 3){
					$UserGroups->first()->update(['active' => '1']);
					return Redirect::back()->with('flash_notice' , 'Welcome to the Group')	;
				}

					return Redirect::back()->with('flash_error' , 'Request already send')	;
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
	}


	public function createGroupPost()
	{
		$permission = false ;
		$group_id = Input::get('post_group_id') ;

		$group_list = User::find(Auth::id())->group_lists();
			foreach ($group_list as $_group_id) {
				if($_group_id == $group_id){
					$permission = true ;//check if the group_id of post equals post_group_id
					break;
					}
				}
		

		if($permission){
			$rules = array(
				'user_post' => 'required|max:2000' , 
				'post_group_id' => 'exists:groups,id'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all() ,$rules) ;

			//if the validator fails, redirect back to the form
			if($validator->fails()) {
				return Redirect::back()
					->withInput(Input::all())
					->withErrors($validator) ; //send back all errors to the
			}else{
				$userPost = htmlentities(Input::get('user_post')) ;
				//$group_id = Input::get('post_group_id') ;
				$user_id = Auth::id() ;
				$status = Post::create([
						'user_id'	=> $user_id ,
						'post_body' => $userPost,
						'like'		=>  0,
						'dislike'	=>  0,
						'group_id'	=> $group_id,
					]);

				if($status){
					Notification::send("groupPost" , $status );
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
	 
		//if user is the admin	
		$admin = (Group::where('id' , '=' ,$group_id)->first()->admin_id == Auth::id()) ? true : false ;

		//if user is blocked active = 2
		if(!$admin){
		$block = (UserGroup::where('group_id' , '=' ,$group_id)->where('user_id' , '=' , Auth::id() )->where('active' , '=' , 2 )->get()->count() ) ? true : false ;
		$toaccept = (UserGroup::where('group_id' , '=' ,$group_id)->where('user_id' , '=' , Auth::id() )->where('active' , '=' , 3 )->get()->count() ) ? true : false ;
		}else{
			$block = false ;
			$toaccept = false ;
		}	
		//Group joined by the user
		$UserGroups =  UserGroup::where('user_id' , '=' , Auth::id() )->where('group_id' , '=' , $group_id)->get() ;

		$pending = false ;
		$active = false ;

		if(!$block && !$toaccept ){
			if(!$admin){	//normal user
				//if the user is in the list(i.e request may or may not be accepted)
				if($UserGroups->count()){

						if($UserGroups->first()->active){
							//post related to the groups
							$GroupPosts = Post::where('group_id' , '=' ,$group_id)->orderBy('id' , 'desc')->simplePaginate(10) ;

							$active = true ;

							return View::make('groups.show')->with('group_id' , $group_id)->with('active' , $active )
							->with('posts',$GroupPosts)->with('pending' , $pending)
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
				
				Paginator::setPageName('blockedusers');
				$blockedUsers = UserGroup::where('group_id' , '=' , $group_id)->where('active',  '=' , '2' )->orderBy('id' , 'desc')->simplePaginate(5) ;

				return View::make('groups.show')->with('group_id' , $group_id)->with('active' , $active )
				->with('posts',$GroupPosts)->with('pending' , $pending)
				->with('admin' , $admin )->with('usersPending' , $usersPending)
				->with('activeUsers' , $activeUsers)->with('block' , $block)
				->with('blockedUsers' , $blockedUsers) ;
			}
		}else{
			//for blocked users
			return View::make('groups.show')->with('block' , $block)->with('toaccept' , $toaccept)
			->with('group_id' , $group_id)->with('active' , $active )
			->with('admin' , false ) ;
		}
		return View::make('groups.show')->with('group_id' , $group_id)->with('active' , $active )
		->with('toaccept' , $toaccept)->with('pending' , $pending)->with('admin' , $admin )->with('block' , $block) ;
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /groups/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($group_id)
	{
		$permission = Auth::user()->isadmin($group_id);
	if($permission){
			//custom message
			$messages = array(
	   		 'g-recaptcha-response.required' => 'We need to know if you are a human!',
	   		 'about_group.required' => 'There must be something about the group' ,
	   		 'name.required' => 'A group must have a Name' , 
			);

			$rules = array(
				'name' => 'required|alpha_num_dashes|min:4|max:32' , 
				//'g-recaptcha-response' => 'required|recaptcha' , 
				'about_group' => 'required|min:4|max:300'
				) ;

				// run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all() ,$rules, $messages) ;

				if($validator->fails()){
					return Redirect::to('group/edit/'.$group_id)
					->withErrors($validator)
					->withInput(Input::all()) ;
				}else{
			 		$group = Group::find($group_id);
					
					$newGroup = $group->update([ 
						'name' => e(Input::get('name')),
						'about' => e(Input::get('about_group')) ,
						]);

					if($newGroup){
						return Redirect::to('group/'.$group->id)
						->with('flash_notice' , 'Successfully edited You Group');
					}

					return Redirect::to('group/edit/'.$group->id)
					->withInput(Input::all())
					->with('flash_error' , 'Cannt Process Your Request::	Please Try Again Later');
			}
		}else{
			return Redirect::to('home')->with('flash_error','Permission Access Denied');
		}

	}

	 public function showSearch($group_id){

		$data = array(Input::get('user_name')) ;
		$lengths = array_map('strlen', $data);
		
		if(max($lengths) < 3)	return View::make('search.group_user')->with('title',null)->with('group_id',$group_id) ;

		if(Input::has('user_name')) {

			$users = User::select('id','name','profile_pic')->where('name','LIKE', Input::get('user_name').'%')->simplePaginate() ;

			return View::make('search.group_user')->with('lists' , $users)->with('title','Users')->with('group_id',$group_id) ;

		}else{

		} 

	}

	public static function isMember($user_id,$group_id){
		$user = UserGroup::where('user_id','=',$user_id)->where('group_id','=',$group_id)->get() ;
		if($user){
			return true ;
		}else{
			return false ;
		}
}
	public static function userRelation($user_id,$group_id){
		$user = UserGroup::where('user_id','=',$user_id)->where('group_id','=',$group_id)->first() ;
		return $user ;
	}

	public function createNotice(){
		$group = Group::find(Input::get('post_group_id')) ;
		if(Auth::id() == $group->admin_id){//is admin
			 $rules = array(
				'notice_message' => 'required|max:2500'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all() ,$rules) ;

			//if the validator pass, 
				if(!$validator->fails()){ //'user_id' ,'post_body', 'group_id'
					$notice = GroupNotice::create([
						'post_body' => Input::get('notice_message'),
						'user_id' => $group->admin_id,
						'group_id' => $group->id ,
						]);

					if($notice){
						Notification::send("groupPost" , $notice );
						return Redirect::back()->with('flash_notice','Success');
					}else{
						return Redirect::back()->with('flash_error','No-Success');
					}
				}else{
					return Redirect::back()->withInput(Input::all())->withErrors($validator);
				}
			 
		}else{
			return Redirect::back('flash_error','Request Admin');
		}
	}
	public function deleteNotice($notice_id){
			$notice = GroupNotice::find($notice_id) ;
			$group = Group::find($notice->group_id) ;
			if($group->admin_id == Auth::id()){
			 	$noticeCheck = $notice->delete();
			 	if($noticeCheck){
				return Redirect::back()->with('flash_notice','Deleted') ;
 				}
		 }
		return Redirect::back()->with('flash_error','Something went wrong') ;

	}
	

	public function editNotice(){
		if(Input::has("_groupid")){
			$group = Group::find(Input::get("_groupid")) ;
			if($group->admin_id == Auth::id()){
					 $rules = array(
					'notice_message' => 'required|max:2500'
					);

				// run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all() ,$rules) ;

				//if the validator pass, 
					if(!$validator->fails()){ //'user_id' ,'post_body', 'group_id'
						$notice = GroupNotice::find(Input::get('_noticeid')) ;
						if($notice){
							$noticeCheck = $notice->update([
								'post_body' => Input::get('notice_message') 
								]);

							if($noticeCheck){
								Notification::send("groupPost" , $notice );
								return Redirect::to('/group/'.$group->id)->with('flash_notice','Success');
							}else{
								return Redirect::back()->with('flash_error','No-Success');
							}
						}
					}else{
						return Redirect::back()->withInput(Input::all())->withErrors($validator);
					}
			}
		}
		return Redirect::back()->with('flash_error','Something went wrong') ;
	}

}