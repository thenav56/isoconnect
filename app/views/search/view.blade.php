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
            	@if(!$title)
                    <h1>{{'User Some More Character Please!'}}</h1>
                @endif
                @if($title && $title != 'query')
            	<h1>{{$title}}</h1>
            	<ul>
                @if($title == 'Groups')
                    @if($lists->count()<1)
                                <h5>No Groups Found with "{{{Input::get('group_name')}}}"</h5>
                    @endif
	            	@foreach($lists as $list)
	            			<li><h4><a href="<?php echo asset('group/'.$list->id.'') ?>">{{{$list->name}}}</a></h4>
	            				<h6>{{{$list->about}}}</h6></li>
	            			@endforeach 
                      @endif
                      
                      @if($title == 'Users')

                      @if($lists->count()<1)
                                <h5>No Users Found with "{{{Input::get('user_name')}}}"</h5>
                            @endif
                                @foreach($lists as $list)
	            				<li><h4><a href="<?php echo asset('user/'.$list->id.'/profile') ?>">{{{$list->name}}}</a></h4></li>
	            				@endforeach 
	            	  @endif
                       <?php echo  $lists->appends(Request::except('page'))->links() ; ?>
                @endif
	            		@if($title == 'query')
                            <h3>Users</h3>
                            @if($users->count()<1)
                                <h5>No Users Found with "{{{Input::get('query')}}}"</h5>
                            @else
                            @foreach($users as $list)
                            <li><h4><a href="<?php echo asset('user/'.$list->id.'') ?>">{{{$list->name}}}</a></h4>
                                <h6>{{{$list->about}}}</h6></li>
                            @endforeach
                            <?php  
                                Paginator::setPageName('users') ;
                            echo  $users->appends(Request::except('page'))->links() ?>
                            @endif
                            <h3>Groups</h3>
                            @if($groups->count()<1)
                                <h5>No Groups Found with "{{{Input::get('query')}}}"</h5>
                            @else
                            @foreach($groups as $list)
                                <li><h4><a href="<?php echo asset('group/'.$list->id) ?>">{{{$list->name}}}</a></h4></li>
                                @endforeach
                            <?php 
                                Paginator::setPageName('groups') ;
                             echo  $groups->appends(Request::except('page'))->links()  ;
                             ?>
                             @endif
                        @endif
	            		
                   
	       			
       			</ul>
            </div>
         </div>
</div>
@stop