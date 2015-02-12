@extends('layout')

@section('head')
<title>Isoconnect | RecentBox </title>
@stop

@section('body')
					<div class="container-fluid">
						<div class="well bs-component" >
					 <legend><h4>Recent Conversation</h4></legend>
						
						 <div class="container">
							<div class="row">
								<div class="col-md-6">
									<div class="bg-primary col-md-12" >
									<label><h4>Recent Conversation</h4></label>	 
										@foreach($conversations as $conversation)
							 
						           	 <?php $message = $messages[$conversation->id];?>
						           	 <div class="text-right ">
						           	 <a href="<?php echo asset('user/message/'.User::find(($conversation->user1_id == Auth::id())?$conversation->user2_id:$conversation->user1_id)->id);?>" class="">
						           	  
						           	  <div class="alert alert-block <?php echo ($message->seen == 0)?'alert-warning':'alert-success' ; ?>">
										 		<label>
										 		
										 			{{User::find(($conversation->user1_id == Auth::id())?$conversation->user2_id:$conversation->user1_id)->name}}
										 		
										 		</label><br>
										 		@if($message->user_id == Auth::id())
										 			{{'You:: '}}
										 		@endif
										 		{{{Str::limit(e($message->message),170)}}} <br> <span class="text-muted pull-right">About {{$message->created_at->diffForHumans()}}</span><br>
										    
										    </div>
										    </a>
						           	 </div>
						             
						         @endforeach
						         </div>
						         <?php  
								echo  $conversations->appends(Request::except('page'))->links() 
								?>
						         </div>
						          
							</div>
							</div>
			
        </div>
        	</div>
         

@stop