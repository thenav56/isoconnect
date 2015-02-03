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
		$like = new Like;
		if($post->like != "0")
		{
			//dd($post->like);
			$find_like = Like::where('post_id','=', $post->id)->get();
			
			foreach($find_like as $check => $f_like)
			{
				//dd($find_like->user_id);
				if($f_like->user_id == Auth::user()->id)
				{
					return Redirect::back();
				}
			}
			
			

		}
		
		$like->post_id = $post->id;
		$like->user_id = Auth::user()->id;
		$post->like += 1;
		
		$like->save();
		$post->save();
		
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