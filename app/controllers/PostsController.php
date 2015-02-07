<?php

class PostsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /posts
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /posts/create
	 *
	 * @return Response
	 */
	public function createPost()
	{
		$rules = array(
			'user_post' => 'required|max:250' , //make sure the email is present and is email
		);


		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all() ,$rules) ;

		//if the validator fails, redirect back to the form
		if($validator->fails()) {
			return Redirect::back()
				->withErrors($validator) ; //send back all errors to the
		}else{
			$userPost = htmlentities(Input::get('user_post')) ;
			$user_id = Auth::id() ;
			$status = Post::create([
					'user_id'	=> $user_id ,
					'post_body' => $userPost,
					'like'		=>  0,
					'dislike'	=>  0,
					'group_id'	=>  0,
				]);

			if($status){
				return Redirect::back()->with('flash_notice' , 'Post Posted Successfully')  ;
			}else{
				echo Redirect::back()->with('flash_error' , 'Post Failed Try Again!')  ;	
			}
		}

	}


	public function createComment()
	{
		$permission = false ;//permission to comment in the post
		$post_id = Input::get('comment_post_id') ;
		$Post = Post::find($post_id);
		$group_id = $Post->group_id;
		if(!$group_id){//if the post is public than has permission by default
			$permission = true ;
		}else{
			$group_list = User::find(Auth::id())->group_lists();
			foreach ($group_list as $_group_id) {
				if($_group_id == $group_id){
					$permission = true ;//check if the group_id of post equals post_group_id
					break;
					}
				}
		}


		
		if($permission){
			$rules = array(
				'user_comment' => 'required|max:250' , 
				'comment_post_id' => 'exists:posts,id'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all() ,$rules) ;

			//if the validator fails, redirect back to the form
			if($validator->fails()) {
				return Redirect::back()
					->withErrors($validator) ; //send back all errors to the
			}else{
				$userComment = htmlentities(Input::get('user_comment')) ;
				//$post_id = Input::get('comment_post_id') ;
				$user_id = Auth::id() ;
				$status = Comment::create([
						'user_id'	=> $user_id ,
						'post_id'  => $post_id ,
						'comment_body' => $userComment,
						'like'		=>  0,
						'dislike'	=>  0,
					]);

				if($status){
					if($Post->user_id != Auth::id())
					Notification::send("comment" , $status );
					return Redirect::back()->with('post_id_focus' , $post_id) ;
				}else{
					echo Redirect::back()->with('flash_error' , 'Comment Failed Try Again!') ;	
				}
			}
		}else{
			return Redirect::back()->with('flash_error' , 'Comment Failed Try Again!!') ; ;
		}

	}

	public function showPostId($post_id)
	{

		$rand = mt_rand() ;

		Session::put('rand_id_generate',  $rand) ;
		//post information group_id
		$posts = Post::where('id' , '=' , $post_id)->first();
		
		if($posts->group_id == 0){//it is public post visible to all
			$comments = Post::find($post_id)->comment ;
			$active = true ;
			return View::make('posts.show')->with('post' , $posts)
			->with('comments' , $comments)->with('active' , $active)->with('rand',$rand) ;
		}
		//group and viewing user relation
		$group_relation = UserGroup::where('user_id' , '=' , Auth::id())->where('group_id','=',$posts->group_id)->first() ;
		//what if the user is the admin
		$group_admin = Group::where('id' , '=' , $posts->group_id)->where('admin_id' , '=' , Auth::id())->first() ;
		//set active = false 
		$active = false ;
		if($group_admin){//if the user is the admin
				$active = true ;
				$comments = Post::find($post_id)->comment ;
				return View::make('posts.show')->with('post' , $posts)
				->with('comments' , $comments)->with('active' , $active)->with('rand',$rand) ;
			}
		if($group_relation){
			$active = ($group_relation->active === 1) ? true : false ;
			
			if($active){
				
				$comments = Post::find($post_id)->comment ;
				 	 
				return View::make('posts.show')->with('post' , $posts)
				->with('comments' , $comments)->with('active' , $active)->with('rand',$rand) ;
			
			}
		}
		return View::make('posts.show')->with('active' , $active) ;	
	}

	


	/**
	 * Store a newly created resource in storage.
	 * POST /posts
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /posts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /posts/{id}/edit
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
	 * PUT /posts/{id}
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
	 * DELETE /posts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}