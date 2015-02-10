<!-- app/views/home.blade.php -->
@extends('layout')
@section('head')
    <title>IsoConnect-Home</title>
@stop

@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 ">
                <h1>Home</h1>
                    <ul>
                    <li><p>Welcome({{ Auth::user()->name }})</p></li>
                    <li><p><a href="/user/profile">{{ Auth::user()->email }}</a></p></li>
                    </ul>

                <h1>Your Group</h1>
                    @if($groups)
                    <ul>
                        @foreach($groups as $key => $value)
                    <p><li><a href='/group/{{$value->id}}'>
                    @if($value->admin_id == Auth::id())
                        (Admin)
                    @endif
                    {{ e($value->name) }}
                    </a></li></p>
                        @endforeach
                    </ul>
                    @else
                        <ul><p>You are not connected to any Group Use search to search</p></ul>
                    @endif
                <p><li><a href='/group/register'>Create Your Own Group</a></li></p>

            </div>
      
            <div class="col-md-6 ">
                <div class="status_update" >
                {{ Form::open(array('url' => 'user/post')) }}
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
                    {{ Form::label('user_post' , 'Write Here DUDE!') }}
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
                {{ Form::close() }}
            </div>

            <div class="ViewPost">

            @if($posts->count())
                @foreach($posts as $post)
                <?php // print_r($post) ; ?>

                                  
                                           
<!-- 
                                            <div class="col-sm-1">
                                              <div class="thumbnail">
                                                <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                              </div> 
                                            </div>  -->

                                             
                                              <div class="panel panel-default">
                                                <div class="panel-heading">
                                                  <strong><a href="/user/<?php echo $post->user_id ?>">{{ User::find($post->user_id)->name }}</a></strong> <span class="text-muted pull-right">{{$post->created_at->diffForHumans()}}</span>
                                                </div> 
                                                <div class="panel-heading">Posted to 
                                                    @if(($gpid=Post::find($post->id)->group_id) != 0)
                                                        <a href='group/<?php echo $gpid ; ?>'>{{Group::find($gpid)->name}}</a>
                                                    @else
                                                        {{'Public'}}
                                                    @endif
                                                    </div>
                                                <div class="panel-body">
                                                    {{ Str::limit(e($post->post_body),170)}}......<br><a href='/post/{{$post->id}}'>Read More&#8594;</a>
                                                </div><!-- /panel-body -->
                                            
                                           
                        <div class="well bs-component" >
                        
                        <!--comment -->
                        <div class="comment_update" >
                                {{ Form::open(array('url' => 'user/comment')) }}
                                 
                                <p> <?php $comment = Post::find($post->id)->Comment() ; ?>
                                    <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                    @if($comment->count())
                                    <a><h5>--Recent Comment--</h5></a>
                                    <?php $recent_commenter = User::find($comment->orderBy('id','desc')->get()->first()->user_id); ?>
                                        <a href="/user/{{$recent_commenter->id}}/profile">{{$recent_commenter->name}}</a><br>
                                         {{e($comment->get()->first()->comment_body)}}<br><br>
                                   @else
                                    <a><h5>Be the first to comment</h5></a><br><br>
                                   @endif
                                   </div>
                                   </div><!-- /panel panel-default -->
                                   </div>
                                    {{ Form::label('user_comment' , 'Comment!') }} ({{$comment->count()}})
                                    {{ Form::textarea('user_comment' ,'' ,  array(
                                    'placeholder'   => 'Have Some Comment!' , 
                                    'class'         => 'form-control'   ,
                                    'rows'          => '2' ,
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
            @else
            <div class="well bs-component">
                    <h3>{{'no post here'}}</h3>
            </div>
            @endif
            </div>
            <?php  echo  $posts->appends(Request::except('page'))->links() ?>
        </div>
    </div>
</div>

@stop
