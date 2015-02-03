@extends('layout')

@section('head')
<title>Isoconnect | MessageBox ({{$otherUser->name}})</title>
@stop

@section('body')
					<div class="container-fluid">
						<div class="well bs-component" >
					 <legend><h4>MessageBOx with {{$otherUser->name}}</h4></legend>
						
						<div class="col-md-offset-6 ">
						        <div class="panel panel-success">
									  <div class="panel-heading">
									    <h3 class="panel-title">Message BOx</h3>
									  </div>
									  <div class="panel-body">
									     {{ Form::open(array('url' => '/user/message/handler')) }}
		       						 {{ Form::label('user_message' , 'Message!') }} 
                                    {{ Form::textarea('user_message' ,'' ,  array(
                                    'placeholder'   => 'Send Message!' , 
                                    'class'         => 'form-control'   ,
                                    'rows'          => '2' ,
                                    )) }}
				
				{{ Form::submit('Send Message!' , array(
                                    'class' => 'btn btn-primary'
                                    )) }}
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="otherUserId" value="<?php echo $otherUser->id ; ?>">
               {{ Form::close() }}
									  </div>
				</div>
		                
         </div>
	@foreach($messages as $message)
	<div class="row"> 
		@if($message->user1_id == Auth::id())
           	 <div class="bg-primary col-md-6 col-md-offset-6" >
           	 <div class="text-right ">
           	  <div class="alert alert-block">
				 		{{{$message->message}}}<br>
				    </div>
           	 </div>
             </div>
        @else 
       		 <div class="bg-success col-md-6 ">
           	 <div class="text-left ">
           	     <div class="alert alert-block">
				 		{{{$message->message}}}<br>
				    </div>
       		</div>
       		 </div>
        @endif
        </div>
	@endforeach
		<div class="col-md-offset-5 ">
	 <?php  echo  $messages->appends(Request::except('page'))->links() ?>
		</div>
		
        </div>
        	</div>
         

@stop