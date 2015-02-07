<?php

class Notification extends \Eloquent {
	protected $fillable = ['seen' , 'user_id' ,'activity_type','source_id','parent_id','parent_type'];

	public static function send($field , $event , $user = Null)
	{//event can be post , group , comment , etc
		
		
		if(!$user){
			switch ($field) {
				case 'comment':
					
					$postid = $event->post_id  ; //$event is Comment::find(id) ;
					$PrimaryUserid = Post::find($postid)->user_id ; 
					$source_id = $event->id ; 		//comment id			 

					$notification = Notification::
					where('user_id','=',$PrimaryUserid)
					->where('activity_type','=','comment') //comment
					->where('parent_id','=',$postid)		 //post id
					->update(['seen' => 0 , 'source_id' => $source_id]);
					// print_r($notification);
					// die();
					if(!$notification){

						$notification = Notification::create([
							'user_id' =>  $PrimaryUserid ,
							'activity_type' => 'comment', //comment
							'source_id' => $source_id,		  //comment id
							'parent_id' => $postid,			 //post id
							'parent_type' => 'post',  //post
							'seen' => '0'
							]);

					}
					break;
				
				case 'like':
					// 'user_id' =>  $x ,
					// 'activity_type' => ,
					// 'source_id' => ,
					// 'parent_id' => ,
					// 'parent_type' => 
					break;

				case 'dislike':
					# code...
					break;

				case 'groupPost':
					$user_id =  Auth::id() ;
					$user = ' <a href="http://localhost/user/'.$user_id.'/profile">'.Auth::user()->name.'</a> ' ;
					$postid = $event  ;
					$PrimaryUserid = Group::find(Post::find($postid)->user_id)->id ;

					if($user_id != $PrimaryUserid){
							$message = $user.' '.'has commented in your <a href="http://localhost/post/'.$postid.'">post</a>' ;
						 
						$notification = Notification::create([
							'user_id' =>  $PrimaryUserid  ,
							'notification' => $message ,
							]);
						}
					break;

			} 
		}else{
			switch ($field) {
					case 'accepted':
					# code...
					break;

				case 'rejected':
					# code...
					break;

				case 'deleted':
					# code...
					break;

				case 'blocked':
					# code...
					break;
				}
			 
		}


	}



}