@extends(layout)


@foreach($find_like as $check)
				dd($check->user_id);
				@if($check->user_id == Auth::user()->id)
				{
					return Redirect::back();
				}
				@endif
@endforeach

<?php $like->post_id = $post->id;
		$like->user_id = Auth::user()->id;
		$post->like += 1;
		
		$like->save();
		$post->save();
?>
		
		return Redirect::back();