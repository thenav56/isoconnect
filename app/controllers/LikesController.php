<?php

class LikesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /likes
	 *
	 * @return Response
	 */


	public function LikePost($id)
	{
		$post = Post::find($id);
		$groupList = User::find(Auth::id())->group_lists();
		$permision = false ;
		foreach ($groupList as $groupId) {
			if($groupId == $post->group_id){
				$permision = true;
				break;
			}
		}
		if(!$permision)
			return Redirect::to('home')->with('flash_error' , 'Authentication Failed<br>Permision Denied By the Group');

		$like = Like::where('user_id','=',Auth::id())->where('post_id','=',$id)->first();
		

		if($like){
			$liked = ($like->liked == 1)?0:1 ;
			$like->update([
				'liked' => $liked ,
				]);


			$post->like += ($liked == 0)?-1:1;
			$post->save();
			if(Auth::id() != $post->user_id )
				if($liked == 1)
				Notification::send('like',$like);

		}else{
			$like = Like::create([
				'user_id' =>  Auth::id() ,
				'post_id' =>  $id,
				'liked' =>   1,
				]);

			$post->like += 1;
			$post->save();
			if(Auth::id() != $like->user_id )
				Notification::send('like',$like);
		}
		//
		
		
		return Redirect::back();
		
	}

	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /likes/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /likes
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /likes/{id}
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
	 * GET /likes/{id}/edit
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
	 * PUT /likes/{id}
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
	 * DELETE /likes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}