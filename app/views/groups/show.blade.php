@extends('layout')

@section('head')
<title>IsoConnect | Group </title>
@stop

@section('body')
 
		<div class="row">
            <div class="col-md-12">
            	<div class="well bs-component">   
            			<?php $group = Group::find($group_id) ?>
                       	<h2>{{{$group->name}}}</h2>
                       	<h4>Created {{$group->created_at->diffForHumans()}} on {{$group->created_at}}</h4>
                        <h4>Created by :: {{ User::where('id','=',$group->admin_id )->first()->name}}</h4>
                        <h4>ABOUT :: {{{$group->about}}}</h4>
                        @if($admin)
                          <a href='/group/edit/<?php echo $group_id; ?>'>Edit</a>
                        @endif
              </div>
            </div>
    </div>
    @if($block)
    <div class="row">
          <div class="col-md-6 col-md-offset-3">
           <div class="well bs-component" >
              <button  class="btn btn-lg btn-danger" disabled>
                  >>>>>>>>>>>>You Are Blocked From This Group<<<<<<<<<<<< 
              </button>
          </div>
        </div>
      </div>
                          
    @elseif($active)
                    		
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
           <div class="well bs-component" >
                     @if($admin)
                     <div class="row">
                        <div class="col-md-4">
                                <form class="navbar-form navbar-left" role="search" method="get" action="/search/group/{{$group_id}}/user">
                                    <div class="form-group">
                                        <input class="form-control typeaheadInput" placeholder="Search for Users" type="text" id="user" name="user_name" autocomplete="off" >
                                        <button type="submit"  style="display: none;" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                                    </div>
                                </form>
                        </div>
                    </div>
                    <h2>Pending Users</h2>
                      @if($usersPending->count())
                      <ul>
                         @foreach($usersPending as $users)
                         
                            <li><div class="row">
                           <?php $user =  User::find($users->user_id); ?>  
                                    <div class="col-md-4"> 
                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                            array('class' => 'img-circle  img-responsive img-center' ,
                                             
                                            )) }}</a>
                                        </div>
                                        <div class="col-md">
                                             <strong><a href="/user/<?php echo $user->id ?>">{{$user->name }}</a></strong> 
                                        </div>
                                    </div></li>
                            
                            {{ Form::open(array('url' => 'group/handle_request')) }}
                            <button type="submit" id='button_submit' name='button_submit' value='accept' class="btn btn-success btn-xs">
                            Accept Request
                            </button><button id='button_submit' name='button_submit' value ='delete' type="submit" class="btn btn-danger btn-xs ">
                            Delete Request
                            </button>
                            <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                            <input type='hidden' name='request_user_id' value="<?php echo $users->user_id ; ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            {{ Form::close() }}

                         @endforeach
                    </ul>
                    
                    <?php  
                    Paginator::setPageName('userspending') ;
                    echo  $usersPending->appends(Request::except('userspending'))->links() 
                    ?>
                    @else
                      No Pending At The Moment
                    @endif
                    

                     <h2>Active Users</h2>
                      @if($activeUsers->count())
                      <ul>
                         @foreach($activeUsers as $users)
                         
                           <li><div class="row">
                           <?php $user =  User::find($users->user_id); ?>  
                                    <div class="col-md-4"> 
                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                            array('class' => 'img-circle  img-responsive img-center' ,
                                             
                                            )) }}</a>
                                        </div>
                                        <div class="col-md">
                                             <strong><a href="/user/<?php echo $user->id ?>">{{$user->name }}</a></strong> 
                                        </div>
                                    </div></li>

                            {{ Form::open(array('url' => 'group/handle_request')) }}
                            <button type="submit" id='button_submit' name='button_submit' value='delete' class="btn btn-warning btn-xs">
                            Remove
                            </button><button id='button_submit' name='button_submit' value ='block' type="submit" class="btn btn-danger btn-xs ">
                            Block
                            </button>
                            <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                            <input type='hidden' name='request_user_id' value="<?php echo $users->user_id ; ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            {{ Form::close() }}

                         @endforeach
                    </ul>
                    
                   <?php  
                   Paginator::setPageName('activeusers') ;
                   echo  $activeUsers->appends(Request::except('activeusers'))->links() 
                   ?>
                   @else
                      No Member In The Group At The Moment
                    @endif

                    <h2>Blocked Users</h2>
                      @if($blockedUsers->count())
                      <ul>
                         @foreach($blockedUsers as $users)
                         
                            <li><div class="row">
                           <?php $user =  User::find($users->user_id); ?>  
                                    <div class="col-md-4"> 
                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                            array('class' => 'img-circle  img-responsive img-center' ,
                                             
                                            )) }}</a>
                                        </div>
                                        <div class="col-md">
                                             <strong><a href="/user/<?php echo $user->id ?>">{{$user->name }}</a></strong> 
                                        </div>
                                    </div></li>

                                    
                            {{ Form::open(array('url' => 'group/handle_request')) }}
                            <button type="submit" id='button_submit' name='button_submit' value='unblock' class="btn btn-success btn-xs">
                            Unblock Request
                            </button><button id='button_submit' name='button_submit' value ='delete' type="submit" class="btn btn-danger btn-xs ">
                            Delete Request
                            </button>
                            <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                            <input type='hidden' name='request_user_id' value="<?php echo $users->user_id ; ?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            {{ Form::close() }}

                         @endforeach
                    </ul>
                    
                    <?php  
                    Paginator::setPageName('blockedusers') ;
                    echo  $blockedUsers->appends(Request::except('blockedusers'))->links() 
                    ?>
                    @else
                      No Blocked Users At The Moment
                    @endif
                   

                     @else
                         {{ Form::open(array('url' => 'group/send_request')) }}
                            <button type="submit" name="button_submit" value= "cancle" class="btn btn-danger">
                            Leave This Group
                            </button>
                          <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        {{ Form::close() }}
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

                <div class="col-md-3 ">
                   <div class="well bs-component" >

                      <h4>Notice Board</h4>
                  @if($admin)
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
                @endif
                 <?php 
                 $notices = GroupNotice::where('group_id','=',$group->id)->orderBy('created_at','desc')->get() ;
                 ?>
                  @foreach($notices as $notice)
                <div class="well bs-component">
                <div class="group_notice">
                    <p>{{$notice->post_body}}</p>
                </div>
                </div>
                  @endforeach
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
                            Cancle Request
                            </button>
                          <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        {{ Form::close() }}
                        </div>
                        </div>
                      @endif
                     
                    
            
            </div>                    
          </div> 

          @endif
@stop