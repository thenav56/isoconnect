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
			            	<div class="form-group alert alert-success">
			            @endif
			            		<li><?php 
			            		/*
															  
									'activity_type' => $activity_type, //comment
									'source_id' => $source_id,		  //comment id
									'parent_id' => $postid,			 //post id
									'parent_type' => $parent_type,  //post
									'seen' => '0',
								*/
									$activity_type =$notification->activity_type;
			            			 switch ($activity_type) {
			            				case 'post': //post
			            					# code...
			            					break;
			            				
			            				case 'comment': //comment
			            					$Lastuser = User::find(Comment::find($notification->source_id)->user_id);
			            					$userlink = asset('user/'.$Lastuser->id.'/profile');
			            					$x = Comment::distinct()->groupBy('user_id')->where('post_id','=',$notification->parent_id)->count() ;
			            					if(!($x-1))
			            					echo '<a href="'.$userlink.'">'.$Lastuser->name.'</a> has commented in your <a href="'.asset('post/'.$notification->parent_id).'">post</a>' ;
			            					else
			            					echo '<a href="'.$userlink.'">'.$Lastuser->name.'</a> and '.($x-1).' more has commented in your <a href="'.asset('post/'.$notification->parent_id).'">post</a>' ;	
			            					break;

			            				case 'like': //like
			            					# code...
			            					break;

			            				case 'dislike': //dislike
			            					# code...
			            					break;
			            			}
			            		?></li>
			            	
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