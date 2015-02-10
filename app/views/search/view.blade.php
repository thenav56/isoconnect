@extends('layout')

@section('head')
	<title>Isoconnect Search</title>
@stop

@section('body')

<div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            	<form class="navbar-form navbar-left" role="search" method="get" action="">
                        <div class="form-group">
                            <input class="form-control" placeholder="Search for Group" type="text" id="users" name="group_name" autocomplete="off" >
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </form>
                    <form class="navbar-form navbar-left" role="search" method="get" action="">
                        <div class="form-group">
                            <input class="form-control" placeholder="Search for Users" type="text" id="users" name="user_name" autocomplete="off" >
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </form>
            	@if($title)
            	<h1>{{$title}}</h1>
            	<ul>
	            	@foreach($lists as $list)
	            			@if($title == 'Groups')
	            				<li><h4><a href="<?php echo asset('group/'.$list->id.'') ?>">{{{$list->name}}}</a></h4>
	            				<h6>{{{$list->about}}}</h6>
	            			@else
	            				<li><h4><a href="<?php echo asset('user/'.$list->id.'/profile') ?>">{{{$list->name}}}</a></h4>
	            				
	            			@endif
	            		</li>
	            		@endforeach	
                    <?php  echo  $lists->appends(Request::except('page'))->links() ?>
	       			@endif
       			</ul>
            </div>
         </div>
</div>
@stop