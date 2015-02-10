@extends('layout')

@section('head')

<title>404 Error</title>
<style>
	 .error-template {
			padding: 40px 15px;text-align: center;
				}
		.error-actions {
			margin-top:15px;margin-bottom:15px;
		}
		.error-actions .btn {
		 margin-right:10px; 
		}

</style>
@stop

@section('body')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oops DUDE!</h1>
                <h2>
                    404 Not Found</h2>
                <div class="error-details">
                    Sorry, an error has occured, Requested page not found!
                </div>
                <div>
                	<h6>Check URL and Try Again!</h6>
                </div>
                <div class="error-actions">
                    <a href="<?php echo asset(''); ?> " class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                        Take Me Home </a><a href="<?php echo asset('support'); ?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop