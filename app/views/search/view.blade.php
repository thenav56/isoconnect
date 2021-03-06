@extends('layout')

@section('head')
	<title>Isoconnect Search</title>
@stop

@section('body')

<div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
            	<form class="navbar-form navbar-left" role="search" method="get" action="">
                        <div class="form-group">
                            <input class="form-control search typeaheadInput" placeholder="Search for Group" type="text" id="group" name="group_name" autocomplete="off" >
                            <button type="submit"  style="display: none;" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </form>

                <div class="row">
                    <div class="col-md-12">
            @if($title == 'Groups')
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
            @endif

            @if($title == 'query')
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
                        </div>
                </div>
            </div>

            <div class="col-md-4">
                    <form class="navbar-form navbar-left" role="search" method="get" action="">
                        <div class="form-group">
                            <input class="form-control typeaheadInput" placeholder="Search for Users" type="text" id="user" name="user_name" autocomplete="off" >
                            <button type="submit"  style="display: none;" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </form>
                 <div class="row">
                    <div class="col-md-12">
             @if($title == 'Users')
                    <h1>{{$title}}</h1>
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
                @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3">
            	@if(!$title)
                    <h1>{{'Use Some More Character Please!'}}</h1>
                @endif
              
         </div>
</div>
</div>

@stop

@section('javascript')
@include('search.javascript')
@stop
