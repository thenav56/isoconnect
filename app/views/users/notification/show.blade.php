@extends('layout')
@section('head')
    <title>IsoConnect-Notification</title>
@stop

@section('body')

    <div class="container-fluid">
    	<div class="well bs-component">
	        <div class="row">
	            <div class="col-md-6 col-md-offset-3">
	            <legend><a>Notifications</a></legend>
	            <ul>
	            @foreach($notifications as $notification)
	            	<div class="well bs-component">
		            	@if(!$notification->seen)
		            		<div class="form-group alert alert-warning">
		            	@else
			            	<div class="form-group">
			            @endif
			            		<li><h4><?php 
			            		/*
														//for comment		  
									'activity_type' => $activity_type, //comment
									'source_id' => $source_id,		  //comment id
									'parent_id' => $postid,			 //post id
									'parent_type' => $parent_type,  //post
									'seen' => '0',
								*/
									$activity_type =$notification->activity_type;
			            			 switch ($activity_type) {
			            				case 'groupPost': //post
			            					$Lastuser = User::find(Post::find($notification->source_id)->user_id);
			            					$userlink = asset('user/'.$Lastuser->id.'/profile');
			            					echo '<a href="'.$userlink.'">'.$Lastuser->name.'</a>  <a href="'.asset('post/'.$notification->source_id).'">posted</a> in Group <a href="'.asset('group/'.$notification->parent_id).'">'.Group::find($notification->parent_id)->name.'</a>' ;
			            					break;
			            				
			            				case 'comment': //comment
			            					$Lastuser = User::find(Comment::find($notification->source_id)->user_id);
			            					$userlink = asset('user/'.$Lastuser->id.'/profile');
			            					$comments = Comment::distinct()->groupBy('user_id')->where('post_id','=',$notification->parent_id)->get() ;
			            					$x = $comments->count() ;
			            					$post = Post::find($notification->parent_id) ;
			            						if($post->user_id == Auth::id())
			            							$yours = 'yours' ;
			            						else 
			            							$yours = User::find($post->user_id)->name.'\'s ' ; 

			            					if(!($x-1))
			            						echo '<a href="'.$userlink.'">'.$Lastuser->name.'</a> has commented in '.$yours.' <a href="'.asset('post/'.$notification->parent_id).'?comment_number='.$notification->source_id.'">post</a><p>"'.Str::limit(e($post->post_body),20).'"</p>' ;
			            					else
			            						echo '<a href="'.$userlink.'">'.$Lastuser->name.'</a> and '.($x-1).' more has commented in '.$yours.' <a href="'.asset('post/'.$notification->parent_id).'?comment_number='.$notification->source_id.'">Post</a><p>"'.Str::limit(e($post->post_body),20).'"</p>' ;	
			            					break;

			            				case 'like': //like
			            					$like = Like::find($notification->source_id) ;
			            					$Lastuser = User::find($like->user_id);
			            					$userlink = asset('user/'.$Lastuser->id.'/profile');
			            					$likes = Like::where('post_id','=',$notification->parent_id)->get() ;
			            					$x = $likes->count() ;
			            					$post = Post::find($notification->parent_id) ;
			            						if($post->user_id == Auth::id())
			            							$yours = 'yours' ;
			            						else 
			            							$yours = User::find($post->user_id)->name.'\'s ' ; 

			            					if(!($x-1))
			            						echo '<a href="'.$userlink.'">'.$Lastuser->name.'</a> has liked '.$yours.' <a href="'.asset('post/'.$notification->parent_id).'">post</a><p>"'.Str::limit(e($post->post_body),20).'"</p>' ;
			            					else
			            						echo '<a href="'.$userlink.'">'.$Lastuser->name.'</a> and '.($x-1).' more has liked '.$yours.' <a href="'.asset('post/'.$notification->parent_id).'">Post</a><p>"'.Str::limit(e($post->post_body),20).'"</p>' ;	
			            					
			            					break;

			            				case 'dislike': //dislike
			            					# code...
			            					break;


			            				case 'User_group_status':
			            					$UserGroup = UserGroup::find($notification->source_id) ;
			            	
			            					if(!$UserGroup)
			            						$status = 'Rejected' ;
			            					elseif($UserGroup->active == '1')
			            						$status = 'Accepted' ;
			            					elseif($UserGroup->active == '2')
			            						$status = 'Blocked' ;
			            					elseif($UserGroup->active == '3')
			            						$status = 'pending to be Accepted by you' ;
			            					else
			            						$status = 'Unknown Status' ;
			            					echo 'You member status in the Group <a href="'.asset('group/'.$notification->parent_id).'">"'.Group::find($notification->parent_id)->name.'"</a> is '.$status ;
			            					break ;
			            			}

			            			echo '<br>'.$notification->updated_at->diffForHumans() ;
			            		?></h4></li>
			            	</div>
	            	</div>
	            	<?php   
	            		Notification::find($notification->id)->update(array('seen' => 1)) ;
	            	?>
	            @endforeach
	            </ul>
	            <?php  echo  $notifications->appends(Request::except('page'))->links() ?>
	            </div>
	        </div>
   		</div>
   </div>



@stop