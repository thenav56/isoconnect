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
			            		<li>{{$notification->notification}}</li>
			            	@else
			            	<div class="form-group alert alert-success">
			            		<li>{{$notification->notification}}</li>
			            	@endif
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