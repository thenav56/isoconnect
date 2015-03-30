@extends('layout')

@section('head')
<title>IsoConnect | Group </title>

 
@stop

@section('body')
 
		<div class="row">
            <div class="col-md-9">
            	<div class="">   
            			<?php $group = Group::find($group_id) ?>
                       	<div class="list-group">
                              <a href="
                              @if($admin)
                                  {{'/group/edit/'.$group_id}}
                                @endif" class="list-group-item  list-group-item-success">
                                <h4>{{{$group->name}}}
                                 @if($admin)
                                  (Edit)
                                @endif
                                </h4>
                              </a>
                                <a href="/user/{{$group->admin_id}}" class="list-group-item" >
                                <h4 class="list-group-item-heading">Created by</h4>
                                <h6>{{ User::where('id','=',$group->admin_id )->first()->name}}
                                <span class="pull-right"><h6>{{$group->created_at->diffForHumans()}} on {{date('F j, Y, g:i a',strtotime($group->created_at))}}</h6></span>
                                </h6>
                                </a>
                                
                                    <a class="list-group-item">
                                      <h4 class="list-group-item-heading">About</h4>
                                      <p>{{{$group->about}}}</p>
                                </a>
                          </div>

                       
              </div>
            
    
    @if($block)
    <div class="row">
          <div class="col-md-6 col-md-offset-4">
           <div class="" >
              <button  class="btn btn-lg btn-danger" disabled>
                  You Are Blocked From This Group
              </button>
          </div>
        </div>
      </div>
                          
    @elseif($active)
                    		
    <div class="container">
        <div class="row">
          <div class="col-md-3">
           <div class="bs-component" >
                     @if($admin)
                    <div class="list-group">
                     <div class="list-group-item">
                     <div class="row">
                        <div class="col-md-4">
                                <form class="navbar-form navbar-left" role="search" method="get" action="/search/group/{{$group_id}}/user">
                                    <div class="form-group">
                                        <input class="form-control typeaheadInput" style="margin-left: -15px;" placeholder="Search for Users" type="text" id="user" name="user_name" autocomplete="off" >
                                        <button type="submit"  style="display: none;" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                                    </div>
                                </form>
                                </div>
                        </div>
                    </div>
                    </div>

                    <div class="list-group">
                    <a class="list-group-item active">Pending Users</a>
                      @if($usersPending->count())
                      
                         @foreach($usersPending as $users)
                         <div class="list-group-item">
                          <div class="row"  style="padding:5px;" > 
                             
                           <?php $user =  User::find($users->user_id); ?>  
                                    <div class="col-md-3"  > 
                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                            array('class' => 'img-circle  img-responsive img-center' ,
                                             
                                            )) }}</a>
                                        </div>
                                        <div class="col-md">
                                             <strong><a href="/user/<?php echo $user->id ?>">{{$user->name }}</a></strong> 
                                        </div>
                                  
                            
                            {{ Form::open(array('url' => 'group/handle_request')) }}
                            <button type="submit" id='button_submit' name='button_submit' value='accept' class="btn btn-success btn-xs">
                            Accept
                            </button>
                            <button id='button_submit' name='button_submit' value ='delete' type="submit" class="btn btn-danger btn-xs ">
                            Delete
                            </button>
                            <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                            <input type='hidden' name='request_user_id' value="<?php echo $users->user_id ; ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            {{ Form::close() }}
                          </div>
                          </div>
                         @endforeach
                    @else
                    <div class="list-group-item">
                      No Pending At The Moment
                    </div>
                    @endif
                    
                    </div>

                    <div style="margin-left:20px;">
                          <?php  
                          Paginator::setPageName('userspending') ;
                          echo  $usersPending->appends(Request::except('userspending'))->links() 
                          ?>
                          </div>
                          
                    <div class="list-group">

                    <a class="list-group-item active">Active Users</a>

                      @if($activeUsers->count())

                         @foreach($activeUsers as $users)
                         <div class="list-group-item">
                           <div class="row"  style="padding:5px;" > 
                           <?php $user =  User::find($users->user_id); ?>  
                                    <div class="col-md-3"> 
                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                            array('class' => 'img-circle  img-responsive img-center' ,
                                             
                                            )) }}</a>
                                        </div>
                                        <div class="col-md">
                                             <strong><a href="/user/<?php echo $user->id ?>">{{$user->name }}</a></strong> 
                                        </div>
                                    

                            {{ Form::open(array('url' => 'group/handle_request')) }}
                            <button type="submit" id='button_submit' name='button_submit' value='delete' class="btn btn-warning btn-xs">
                            Remove
                            </button>
                            <button id='button_submit' name='button_submit' value ='block' type="submit" class="btn btn-danger btn-xs ">
                            Block
                            </button>
                            <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                            <input type='hidden' name='request_user_id' value="<?php echo $users->user_id ; ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            {{ Form::close() }}
                            </div>
                            </div>
                         @endforeach
                   @else
                   <div class="list-group-item">
                      No Member In The Group At The Moment
                    </div>
                    @endif
              </div>
                    <div style="margin-left:20px;">
                      <?php  
                                       Paginator::setPageName('activeusers') ;
                                       echo  $activeUsers->appends(Request::except('activeusers'))->links() 
                                       ?>
                                       </div>
              <div class="list-group">

                    <a class="list-group-item active">Blocked Users</a>
                      @if($blockedUsers->count())
                      
                         @foreach($blockedUsers as $users)
                         <div class="list-group-item">
                           <div class="row"  style="padding:5px;" > 
                           <?php $user =  User::find($users->user_id); ?>  
                                    <div class="col-md-3"> 
                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                            array('class' => 'img-circle  img-responsive img-center' ,
                                             
                                            )) }}</a>
                                        </div>
                                        <div class="col-md">
                                             <strong><a href="/user/<?php echo $user->id ?>">{{$user->name }}</a></strong> 
                                        </div>
                                    

                                    
                            {{ Form::open(array('url' => 'group/handle_request')) }}
                            <button type="submit" id='button_submit' name='button_submit' value='unblock' class="btn btn-success btn-xs">
                            Unblock
                            </button>
                            <button id='button_submit' name='button_submit' value ='delete' type="submit" class="btn btn-danger btn-xs ">
                            Remove
                            </button>
                            <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                            <input type='hidden' name='request_user_id' value="<?php echo $users->user_id ; ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            {{ Form::close() }}
                            </div>
                            </div>
                         @endforeach
                    @else
                   <div class="list-group-item">
                      No Blocked Users At The Moment
                    </div>
                    @endif
                   </div>
                    <div style="margin-left:20px;">
                    <?php  
                          Paginator::setPageName('blockedusers') ;
                          echo  $blockedUsers->appends(Request::except('blockedusers'))->links() 
                          ?>
                    </div>
                    @endif
                     @if(!$admin)
                        <div class="list-group">
                        
                        <div class="list-group-item active">
                          <div class="row">
                            <div class="col-md-8"> 
                            Group Active Users
                            </div>
                            <div class="col-md-4"> 
                           {{ Form::open(array('url' => 'group/send_request')) }}
                              <button type="submit" name="button_submit" value= "cancle" title="Leave This Group ({{$group->name}})" class="btn btn-danger btn-xs">
                              Leave
                              </button>
                            <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                          {{ Form::close() }}
                          </div>
                         </div> 
                        </div>
                        
                        @if($activeUsers->count())
                        @foreach($activeUsers as $users)
                         <div class="list-group-item">
                           <div class="row"  style="padding:5px;" > 
                           <?php $user =  User::find($users->user_id); ?>  
                                    <div class="col-md-3"> 
                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                            array('class' => 'img-circle  img-responsive img-center' ,
                                             
                                            )) }}</a>
                                        </div>
                                        <div class="col-md">
                                             <strong><a href="/user/<?php echo $user->id ?>">{{$user->name }}</a></strong> 
                                        </div>
                            </div>
                            </div>
                         @endforeach
                         @endif
                         </div>

                         <div style="margin-left:20px;">
                      <?php  
                                       Paginator::setPageName('activeusers') ;
                                       echo  $activeUsers->appends(Request::except('activeusers'))->links() 
                                       ?>
                                       </div>
                      @endif
             </div>
          </div>

            <div class="col-md-6">

                {{ Form::open(array('url' => 'group/post')) }}
                <!-- if there are login errors , show them here -->
                @if (Session::has('flash_error'))
                    <div id="flash_error" >{{ Session::get('flash_error') }}</div>
                @endif

                 <div class="form-group">
                                <tr class="danger">
                                    {{$errors->first('user_post')}}
                                </tr>
                        </div>
                <p>
                    {{ Form::label('user_post' , 'Share in the Group!') }}
                    {{ Form::textarea('user_post' ,'' ,  array(
                    'placeholder'   => 'Want To Share Something!' , 
                    'class'         => 'form-control'   ,
                    'rows'          => '2'
                    )) }}
                </p>
                <p>{{ Form::submit('Submit!' , array(
                    'class' => 'btn btn-primary'
                    )) }}</p>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="post_group_id"  autocomplete="off" value="<?php echo  $group->id ; ?>">



                {{ Form::close() }}


                @include('posts.default')
                </div>
    </div>
    </div>
    </div>
                <div class="col-md-3 ">
                    @include('flash_notice')
                   <div class="well bs-component notice-board">

                      <h4>Notice Board</h4>
                  @if($admin)
                  <div class="row">
                    <div class="col-md-12">

                        {{ Form::open(array('url' => 'group/post_notice')) }}
                        <!-- if there are login errors , show them here -->
                        @if (Session::has('flash_error'))
                            <div id="flash_error" >{{ Session::get('flash_error') }}</div>
                        @endif

                         <div class="form-group">
                         
                                        <tr class="danger">
                                            {{$errors->first('user_post')}}
                                        </tr>
                                
                        <p>
                            {{ Form::textarea('notice_message' ,'' ,  array(
                            'placeholder'   => 'Write A Notice Here!' , 
                            'class'         => 'form-control'   ,
                            'rows'          => '1'
                            )) }}
                        </p>
                        <p>{{ Form::submit('Submit!' , array(
                            'class' => 'btn btn-success btn-sm'
                            )) }}</p>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="post_group_id"  autocomplete="off" value="<?php echo  $group->id ; ?>">
                    </div>


                        {{ Form::close() }}

 
                </div>
                </div>
                @endif
                 <?php 
                 Paginator::setPageName('group_notice');
                 $notices = GroupNotice::where('group_id','=',$group->id)->orderBy('created_at','desc')->simplePaginate(8) ;
                 ?>
                    <div class="list-group">
                      @foreach($notices as $notice)
                        <div class="">
                          <div class="list-group-item list-group-item-info">
                              <p><?php echo nl2br($notice->post_body) ;?></p>
                              @if($admin)
                                <span class="text-muted"><a class="btn btn-sm btn-default" href="{{asset('/group/post_notice/edit/'.$notice->id)}}">Edit</a></span>
                                <span class="text-muted pull-right"><a class="btn btn-sm btn-danger" href="{{asset('/group/post_notice/delete/'.$notice->id)}}">Delete</a></span>
                              @endif
                          </div>
                        </div>
                      @endforeach
                    </div>
                    <div style="margin-left:40px;"> 
                      {{Paginator::setPageName('group_notice')}}
                      {{$notices->appends(Request::except('group_notice'))->links()}}
                    </div>
                </div>
                
                </div>


                 		@else
                      @if($toaccept)
                          {{ Form::open(array('url' => 'group/send_request')) }}
                            <button type="submit" class="btn btn-primary">
                            Accept Request
                            </button>
                            <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        {{ Form::close() }}
                       
                      @elseif(!$pending)
                        <h2>Join This Group</h2>
                        
                        {{ Form::open(array('url' => 'group/send_request')) }}
                            <button type="submit" class="btn btn-primary">
                            Send Request
                            </button>
                          <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        {{ Form::close() }}
                      @elseif($pending)
                      <div class="row">
                      <div class="col-md-4 col-md-offset-10">
                         
                        {{ Form::open(array('url' => 'group/send_request')) }}
                            <button type="submit" name="button_submit" value= "cancle" class="btn btn-danger">
                            Cancel Request
                            </button>
                          <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        {{ Form::close() }}
                        </div>
                        </div>
                      @endif
                      
                    </div>
            <div class="col-md-3">
            @include('flash_notice')
            </div>
            </div>                    
          </div> 

          @endif
 
@stop