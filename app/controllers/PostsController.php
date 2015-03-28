<?php

class PostsController extends \BaseController {

	 
	public function createPost()
	{
		//for array of photos
		$photos = Input::file('photos');
	 
				foreach($photos as $photo) {
					 
				 
				  // validating each photo.
				  $rules = array('photos' => 'image|max:5500'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
				  $validator = Validator::make(array('photos'=> $photo), $rules);
				  
				  if($validator->fails()){
				  	$input = Input::except('photos');
				   	return Redirect::back()->withErrors($validator)->withInput($input);
				  }  
				}
			 
	 
		$rules = array(
			'user_post' => 'required|max:2000' , 
		);


		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all() ,$rules) ;

		//if the validator fails, redirect back to the form
		if($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput(Input::except('photos')) ; //send back all errors to the
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

			$photos = array_filter($photos);
			 
			if(!empty($photos)){
				foreach ($photos as $photo) {
					    $image_name = time().$photo->getClientOriginalName();
						$img = Image::make($photo) ;
					 
					//$result = File::makeDirectory('/path/to/directory', 0775, true);
						$img->save('store/photo/original/'.$image_name);

						$img->resize(null, 200, function ($constraint) {
					    $constraint->aspectRatio();
						})->save('store/photo/lowsize_image/'.$image_name);
	  	 		
					//save to photo table
					$photo_flag = Photo::create([
						'user_id' => Auth::id() ,
						'location' => $image_name ,
						'source_id' => $status->id , //can be null ....doesnt matter for profile
						'source_type' => 'post' ,
						]);
					if(!$photo_flag)
						return Redirect::back()->with('flash_error','Something went wrong with the photos');
				}
			}
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
					
					Notification::send("comment" , $status );
					return Redirect::to(asset('post/'.$post_id.'?comment_number='.$status->id)) ;
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
 
		//post information group_id
		$posts = Post::where('id' , '=' , $post_id)->first();
		$active = false ;
		
		if($posts->group_id == 0 || Auth::id() == $posts->user_id){							//it is public post visible to all or the user is the author
			$comments = Post::find($post_id)->comment ;
			$active = true ;

			$like = Like::where('user_id','=',Auth::id())->where('post_id','=',$post_id)->first(); 

				if($like){
					$liked = ($like->liked == 1) ? true : false ;
				}else
					$liked = false ;
					
			return View::make('posts.show')->with('post' , $posts)->with('liked',$liked)
			->with('comments' , $comments)->with('active' , $active);
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

				$like = Like::where('user_id','=',Auth::id())->where('post_id','=',$post_id)->first(); 

				if($like){
					$liked = ($like->liked == 1) ? true : false ;
				}else
					$liked = false ;

				return View::make('posts.show')->with('post' , $posts)->with('liked',$liked)
				->with('comments' , $comments)->with('active' , $active) ;
			}
		if($group_relation){
			$active = ($group_relation->active == 1) ? true : false ;
			
			if($active){
				
				$comments = Post::find($post_id)->comment ;
				$like = Like::where('user_id','=',Auth::id())->where('post_id','=',$post_id)->first(); 

				if($like){
					$liked = ($like->liked == 1) ? true : false ;
				}else
					$liked = false ;

				return View::make('posts.show')->with('post' , $posts)->with('liked',$liked)
				->with('comments' , $comments)->with('active' , $active) ;
			
			}
		}
		return View::make('posts.show')->with('active' , $active)->with('groupid',$posts->group_id) ;	
	}

	 
	public function delete($id)
	{  
		$post = Post::findOrFail($id);
  
		$permission = ($post->user_id == Auth::id() )?true : false ;

	
		if($permission){

			$post->delete();
			return Redirect::to('home')->with('flash_notice','Deleted Successfully');
		}
			
		return Redirect::back()->with('flash_error','Something went wrong Try Again');
		
	}


	public function edit(){
		 	$post = Post::find(Input::get("_postid")) ;
			if($post->user_id == Auth::id()){
					 $rules = array(
					'post_body' => 'required|max:2500'
					);

				// run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all() ,$rules) ;

				//if the validator pass, 
					if(!$validator->fails()){ //'user_id' ,'post_body', 'group_id'
					 
							$postCheck = $post->update([
								'post_body' => Input::get('post_body') 
								]);

							if($postCheck){
								return Redirect::to('/post/'.$post->id)->with('flash_notice','Success');
							}else{
								return Redirect::back()->with('flash_error','No-Success');
							}
						 
					}else{
						return Redirect::back()->withInput(Input::all())->withErrors($validator);
					}
			}
		 
		return Redirect::back()->with('flash_error','Something went wrong') ;
	}
	 
 

}