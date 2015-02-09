<?php

class Notification extends \Eloquent {
	protected $fillable = ['seen' , 'user_id' ,'activity_type','source_id','parent_id','parent_type'];

	

	public static function send($field , $event) {
	//event can be post , group , comment , etc
		
			switch ($field) {
				
				case 'comment':
					
					$postid = $event->post_id  ; //$event is Comment::find(id) ;
					$PrimaryUserid = Post::find($postid)->user_id ; 
					$source_id = $event->id ; 		//comment id			 

					$users = Post::find($postid)->userlist() ;
			            					
					foreach($users as $user){
						if($user->id == Auth::id())
								continue ;
						$notification = Notification::
						where('user_id','=',$user->id)
						->where('activity_type','=','comment') //comment
						->where('parent_id','=',$postid)		 //post id
						->update(['seen' => 0 , 'source_id' => $source_id]);
						
						if(!$notification){

							$notification = Notification::create([
								'user_id' =>  $user->id ,
								'activity_type' => 'comment', //comment
								'source_id' => $source_id,		  //comment id
								'parent_id' => $postid,			 //post id
								'parent_type' => 'post',  //post
								'seen' => '0'
								]);

						}
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
					$source_id = $event->id  ; //$event is Post::find(id) ; 
					$parent_id = $event->group_id ; 		//group id	
					$users = Group::find($parent_id)->users() ;
						 

					foreach($users as $user){
						if($user->id == Auth::id())
							continue ;
						$notification = Notification::
						where('user_id','=',$user->id)
						->where('activity_type','=','groupPost') //groupPost
						->where('parent_id','=',$parent_id)		 //Group id
						->update(['seen' => 0 , 'source_id' => $source_id]);
						// print_r($notification);
						// die();
						if(!$notification){

							$notification = Notification::create([
								'user_id' =>  $user->id ,
								'activity_type' => 'groupPost', 
								'source_id' => $source_id,		  //post id
								'parent_id' => $parent_id,			 //Group id
								'parent_type' => 'group',  
								'seen' => '0'
								]);

						}
					}
					break;

				case 'User_group_status':
					$source_id = $event->id  ; //$event is UserGroup::find(id) ; 
					$parent_id = $event->group_id ; 		//group id	
					
					$notification = Notification::
						where('user_id','=',$event->user_id)
						->where('activity_type','=','User_group_status') 
						->where('parent_id','=',$parent_id)		 //Group id
						->update(['seen' => 0 , 'source_id' => $source_id]);
						// print_r($notification);
						// die();
						if(!$notification){

							$notification = Notification::create([
								'user_id' => $event->user_id ,
								'activity_type' => 'User_group_status', 
								'source_id' => $source_id,		  //UserGroup::id()
								'parent_id' => $parent_id,			 //Group id
								'parent_type' => 'group',  
								'seen' => '0'
								]);

						}
					
					break;
			}

	}

}