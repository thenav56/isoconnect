@extends('layout')

@section('head')
	<title>Isoconnect Search</title>
@stop

@section('body')

<div class="container-fluid">
        <div class="row">
             
            <div class="col-md-12 col-md-offset-5">
                    <form class="navbar-form navbar-left" role="search" method="get" action="">
                        <div class="form-group">
                            <input class="form-control typeaheadInput" placeholder="Search for Users" type="text" id="user" name="user_name" autocomplete="off" >
                            <button type="submit"  style="display: none;" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </form>
            </div>
                 <div class="row">
                    <div class="col-md-5 col-md-offset-4">
             @if($title == 'Users')
                      @if($title == 'Users')

                      @if($lists->count()<1)
                                <h5>No Users Found with "{{{Input::get('user_name')}}}"</h5>
                            @endif
                                @foreach($lists as $list)
                              <a href='<?php echo asset('user/') ;?>/{{$list->id}}' >
                                    <div class="well bs-component">
                                        <div class='row'>
                                          <div class='col-md-2'>
                                            <img class='img-circle img-responsive img-center' src='{{asset('profile_pic/low/crop/'.$list->profile_pic)}}' >
                                          </div>
                                          <div class='col-md'>
                                            <h6><strong>{{$list->name}}</strong></h6>
                                          </div>
                                            @if($list->id == Group::find($group_id)->admin_id )
                                                Admin
                                            @else
                                                 <?php $user_relation = GroupsController::userRelation($list->id,$group_id); ?>
                                                    @if(!$user_relation)
                                                        {{ Form::open(array('url' => 'group/send_request')) }}
                                                            <button type="submit" value='request_from_admin' class="btn btn-sm btn-primary">
                                                            Add
                                                            </button>
                                                          <input type='hidden' name='group_id' value="<?php echo $group_id ; ?>">
                                                          <input type='hidden' name='request_user_id' value="<?php echo $list->id ; ?>">
                                                          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        {{ Form::close() }}
                                                    @elseif($user_relation->active == 1 )
                                                        {{ Form::open(array('url' => 'group/handle_request')) }}
                                                            <button type="submit" id='button_submit' name='button_submit' value='delete' class="btn btn-warning btn-xs">
                                                            Remove
                                                            </button>
                                                            <button id='button_submit' name='button_submit' value ='block' type="submit" class="btn btn-danger btn-xs ">
                                                            Block
                                                            </button>
                                                            <input type='hidden' name='group_id' value="<?php echo $group_id ; ?>">
                                                            <input type='hidden' name='request_user_id' value="<?php echo $list->id ; ?>">
                                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        {{ Form::close() }}
                                                    @elseif($user_relation->active == 0 )
                                                        {{ Form::open(array('url' => 'group/handle_request')) }}
                                                                <button type="submit" id='button_submit' name='button_submit' value='accept' class="btn btn-success btn-xs">
                                                                Accept Request
                                                                </button>
                                                                <button id='button_submit' name='button_submit' value ='delete' type="submit" class="btn btn-danger btn-xs ">
                                                                Delete Request
                                                                </button>
                                                                <input type='hidden' name='group_id' value="<?php echo $group_id ; ?>">
                                                                <input type='hidden' name='request_user_id' value="<?php echo $list->id ; ?>">
                                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        {{ Form::close() }}

                                                    @elseif($user_relation->active == 2 )
                                                                 {{ Form::open(array('url' => 'group/handle_request')) }}
                                                                    <button type="submit" id='button_submit' name='button_submit' value='unblock' class="btn btn-success btn-xs">
                                                                    Unblock Request
                                                                    </button><button id='button_submit' name='button_submit' value ='delete' type="submit" class="btn btn-danger btn-xs ">
                                                                    Delete Request
                                                                    </button>
                                                                    <input type='hidden' name='group_id' value="<?php echo $group_id ; ?>">
                                                                    <input type='hidden' name='request_user_id' value="<?php echo $list->id ; ?>">
                                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                                 {{ Form::close() }}
                                                    @elseif($user_relation->active == 3 )
                                                        {{ Form::open(array('url' => 'group/handle_request')) }}
                                                                <button type="submit" class="btn btn-success btn-xs" disabled="true">
                                                                Request Pending
                                                                </button>
                                                                <button id='button_submit' name='button_submit' value ='delete' type="submit" class="btn btn-danger btn-xs ">
                                                                Delete Request
                                                                </button>
                                                                <input type='hidden' name='group_id' value="<?php echo $group_id ; ?>">
                                                                <input type='hidden' name='request_user_id' value="<?php echo $list->id ; ?>">
                                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        {{ Form::close() }}
                                                    @endif
                                                @endif
                                      </div>
                                  </div>
                              </a>
                                
                                @endforeach 
                      @endif
                       <?php echo  $lists->appends(Request::except('page'))->links() ; ?>
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
