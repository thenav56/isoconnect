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
                        //if user is the memeber of the group i.e not the admin
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


               @if($posts->count())
                      @foreach($posts as $post)
                      <?php // print_r($post) ; ?>
                          <div class="well bs-component">
                          <div class="row">
                           <?php $user =  User::find($post->user_id); ?>  
                                    <div class="col-md-2"> 
                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                            array('class' => 'img-circle  img-responsive img-center' ,
                                            'url' => 'slkadjf'
                                            )) }}</a>
                                        </div>
                                        <div class="col-md">
                                             <strong><a href="/user/<?php echo $post->user_id ?>">{{$user->name }}</a></strong> <span class="text-muted pull-right">{{$post->created_at->diffForHumans()}}</span>
                                        </div>
                                    </div>
                              <h4>Posted to 
                                  @if(($gpid=Post::find($post->id)->group_id) != 0)
                                  {{Group::find($gpid)['name']}}
                                  @else
                                  {{'Public'}}
                                  @endif
                                  </h4>
                              <h5>{{$post->created_at->diffForHumans()}}</h5>
                              <h5>{{ Str::limit(e($post->post_body),170)}}<a  href='/post/{{$post->id}}'>Read More&#8594;</a></h5>
                              <p> <?php $comment = Post::find($post->id)->Comment() ; ?>
                                   <?php  
                                   $like = Like::where('user_id','=',Auth::id())->where('post_id','=',$post->id)->first(); 

                                    if($like){
                                        $liked = ($like->liked == 1) ? true : false ;
                                    }else
                                        $liked = false ;
                                    ?>
                                   <div class="panel-heading">
                                                @if(!$liked)
                                                  <div class="btn btn-primary"><a href="/post/{{$post->id}}/like"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a></div>
                                                @else
                                                  <div class="btn btn-primary"><a href="/post/{{$post->id}}/like"><span class="glyphicon glyphicon-thumbs-down"></span> UnLike</a></div>
                                                @endif
                                                  <span class="text-muted pull-right">{{$post->like}} people liked</span>
                                 
                                   </div><!-- /panel panel-default -->
                              <!--comment -->
                              <div class="comment_update" >
                                      {{ Form::open(array('url' => 'user/comment')) }}
                                      <!-- if there are login errors , show them here -->
                                      @if (Session::has('flash_error'))
                                          <div id="flash_error" >{{ Session::get('flash_error') }}</div>
                                      @endif

                                       <div class="form-group">
                                                      <tr class="danger">
                                                          {{$errors->first('user_comment')}}
                                                      </tr>
                                              </div>
                                      <p> <?php $comment = Post::find($post->id)->Comment() ; ?>
                                          @if($comment->count())
                                          <a><h5>--Recent Comment--</h5></a>
                                              <a href="<?php echo asset('/user/'.$comment->orderBy('id','desc')->get()->first()->user_id); ?>">{{User::find($comment->orderBy('id','desc')->get()->first()->user_id)->name}}</a><br>
                                               {{e($comment->get()->first()->comment_body)}}<br><br>
                                         @else
                                          <a><h5>Be the first to comment</h5></a><br><br>
                                         @endif
                                          {{ Form::label('user_comment' , 'Comment!') }} ({{$comment->count()}})
                                          {{ Form::textarea('user_comment' ,'' ,  array(
                                          'placeholder'   => 'Have Some Comment!' , 
                                          'class'         => 'form-control'   ,
                                          'rows'          => '2'
                                          )) }}
                                      </p>
                                      <p>{{ Form::submit('Comment!' , array(
                                          'class' => 'btn btn-primary'
                                          )) }}</p>
                                      <input type="hidden" name="comment_post_id"  autocomplete="off" value="<?php echo $post->id; ?>">
                                      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                      {{ Form::close() }}
                              </div>
                          </div>
                      @endforeach
                      <?php  
                        Paginator::setPageName('page') ;
                        echo  $posts->appends(Request::except('page'))->links() 
                        ?>
                      </div>
                  @else
                  <div class="well bs-component">
                          <h3>{{'Be the First To Post'}}</h3>
                  </div>
                  @endif
                
                <div class="col-md-3 ">
                   <div class="well bs-component" >
                      <h3>Notice Board</h3>
                  </div>
                </div>


                 		@else
                      @if(!$pending)
                        <h2>Join This Group By Sending Request</h2>
                        {{ Form::open(array('url' => 'group/send_request')) }}
                            <button type="submit" class="btn btn-primary">
                            Send Request
                            </button>
                          <input type='hidden' name='group_id' value="<?php echo $group->id ; ?>">
                          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        {{ Form::close() }}
                      @elseif($pending)
                        <button  class="btn btn-success" disabled>
                            Request Pending 
                            </button>
                      @endif
                    
            
            </div>                    
          </div> 

          @endif
@stop