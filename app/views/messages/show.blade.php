@extends('layout')

@section('head')
<title>Isoconnect | MessageBox ({{$otherUser->name}})</title>

<style> 
div.new_message {
    -webkit-animation: myfirst 5s; /* Chrome, Safari, Opera */
    animation: myfirst 5s;
}

/* Chrome, Safari, Opera */
@-webkit-keyframes myfirst {
    from {background: #2c3e50;}
    to {background: #18bc9c;}
}

/* Standard syntax */
@keyframes myfirst {
    from {background: #2c3e50;}
    to {background: #18bc9c;}
}
</style>
 

@stop

@section('body')

 <?php 
   	 $conversation = Conversation::find($conversation_id) ;
   	 $canChat  = false ; //can chat
   	 $hasoff = false ; //you have closed
   	 $gotoff = false ; //another user has closed
   	 if($conversation->user1_id == Auth::id() ){
   	 	if($conversation->user1active == 1 ){
   	 		if($conversation->user2active == 1){
	   	 		$canChat = true ;
	   	 	}else{
	   	 		$gotoff = true ;
	   	 	}
   	 	}else{
   	 		$hasoff = true ;
   	 		}

   	  }else{
   	 	 if($conversation->user2active == 1 ){
	   	 		if($conversation->user1active == 1){
		   	 		$canChat = true ;
		   	 	}else{
		   	 		$gotoff = true; 
		   	 	}
   	 	}else{
   	 		$hasoff = true ;
   	 		}
  
   	  }



   	 ?>


<div class="row">
		<div class="col-md-6 col-md-offset-3">
		 <div class="panel">
									  <div class="panel-heading">
									    
  <div class="container-fluid">
					 <legend><h4>MessageBOx with {{$otherUser->name}}
					  @if(!$hasoff)
						<div class="row"> 
							<div class="col-md-12"> 
								<span  class="pull-right"><a href="/user/message/enable/{{$conversation_id}}" class="btn btn-sm btn-danger">Disable Chat</a></span>
							</div>
						</div>
						@endif
						@if($hasoff)
						<div class="row"> 
							<div class="col-md-12"> 
								<span  class="pull-right"><a href="/user/message/enable/{{$conversation_id}}" class="btn btn-sm btn-success">Enable Chat</a></span>
							</div>
						</div>
						@endif</h4></legend>
						@if($gotoff)
						<div class="row"> 
							<div class="col-md-6 col-md-offset-3"> 
							<div class="alert alert-info"> 
								<span class=""><p>Other user has not enable the chat</p></span>
							</div>
							</div>
						</div>
						@endif
						<div class="col-md-offset-3 ">
	 <?php  echo  $messages->appends(Request::except('page'))->links() ?>
		</div>
			<?php $messageNU= 0 ; ?>
			@foreach($Updownmessage as $message)
			<div class="row"> <?php $messageNU++ ; ?>
				@if($message->user_id == Auth::id())
		           	 <div class="bg-primary col-md-6 col-md-offset-5" >
		           	 <div class="text-right ">
		           	  <div class="alert alert-block"> 
		           	   		{{{$message->message}}}<br>
						 		@if($message->seen == 1)
						 			 <span class="text-muted pull-right">{{'(seen)'}} </span>
						 		@endif
						 		<span class="text-muted pull-right">{{$message->created_at->diffForHumans()}}</span>
						    
						    </div>
		           	 </div>
		             </div>
		        @else 
		       		 <div class="bg-success col-md-6 col-md-offset-2">
		           	 <div class="text-left ">
		           	     <div class="alert alert-block">
		           	     	 <a class="btn btn-success" href="{{asset('user/'.$otherUser->id)}}"> {{$otherUser->name}}</a> 
						 		{{{$message->message}}}<br>
						 		<span class="text-muted pull-right">{{$message->created_at->diffForHumans()}}</span>
						 		<?php $message->update(['seen' => 1])?>
						    </div>
		       		</div>
		       		 </div>
		        @endif
		        </div>
				<br>
			@endforeach
			 @if(!$messageNU)
   	 	<div class="row"> 
			<div class="col-md-6 col-md-offset-3"> 
			<div class="alert alert-warning"> 
				<span class=""><p>Enter chat invitation message</p></span>
			</div>
			</div>
		</div>
   	 	@endif
		 
	  <div id="chat-wrap" class="chat-area"><div id="chat-area"></div></div>
      
		</div>	
   	 </div>
   	
   	 	@if($canChat || !$messageNU)

   	 	
		<div class="panel-body">
									  <div class="row"> 
									  <div class="col-md-9"> 
										     {{ Form::open(array('url' => '/user/message/handler')) }}
			       						 
	                                    {{ Form::textarea('user_message' ,'' ,  array(
	                                    'placeholder'   => 'Send Message!' , 
	                                    'class'         => 'form-control'   ,
	                                    'rows'          => '2' ,
	                                   	'autofocus'			=>'true',
	                                    )) }}
			 						</div>
				<br>{{ Form::submit('Send Message!' , array(
                                    'class' => 'btn btn-sm btn-primary'
                                    )) }}
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="otherUserId" value="<?php echo $otherUser->id ; ?>">
                <input type="hidden" name="conversation" value="<?php echo $conversation_id ; ?>">
               {{ Form::close() }}
									  </div>
									  </div>
				@endif
				
				
				
				</div>
		            </div>     
		            </div>
         

        	 
         

@stop

@section('javascript')
@include('messages.chatJavascript')
@stop