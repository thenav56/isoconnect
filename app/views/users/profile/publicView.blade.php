@extends('layout')
@section('head')
    <title>IsoConnect-Profile</title>
@stop


@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-md-3">
                {{ HTML::image('profile_pic/'.$user->profile_pic, 'a picture', array('class' => 'img-rectangle img-responsive img-center')) }}
                <b><h1>PROFILE</h1></b>
                    <ul>
                    <li><p>({{ $user->name }})</p></li>
                    <li><p>{{ $user->email }}</p></li>
                    <li><p><a href='/user/<?php echo $user->id ?>/profile/info'>{{ 'Profile Info' }}</a></p></li>
                    </ul>

                <h1>Joined Group</h1>
                    <ul>
                    @if($groups->count())
                        @foreach($groups as $value)
                    <p><li><a href='/group/{{$value->id}}'>
                    @if($value->admin_id == $user->id)
                        (Admin)
                    @endif
                    {{ e($value->name) }}
                    </a></li></p>
                        @endforeach
                    </ul>
               @endif

            </div>
      
            <div class="col-md-6 ">
                <div class="ViewPost">

            @if($posts->count())
                @foreach($posts as $post)
                <?php // print_r($post) ; ?>
                    <div class="well bs-component">
                        <h4><a href="/user/<?php echo $post->user_id ?>/profile">{{ User::find($post->user_id)['name'] }}</a></h4>
                        <h5>Posted to 
                            @if(($gpid=Post::find($post->id)->group_id) != 0)
                            {{Group::find($gpid)['name']}}
                            @else
                            {{'Public'}}
                            @endif
                            </h5>
                        <h5>{{$post->created_at->diffForHumans()}}</h5>
                        <h5>{{ Str::limit(e($post->post_body),170)}}<a  href='/post/{{$post->id}}'><br>Read More&#8594;</a></h5>
                        
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
                                        <a>{{User::find($comment->orderBy('id','desc')->get()->first()->user_id)->name}}</a><br>
                                         {{e($comment->get()->first()->comment_body)}}<br><br>
                                   @else
                                    <a><h5>Be the first to comment</h5></a><br>
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
            @else
            <div class="well bs-component">
                    <h3>{{'no post here'}}</h3>
            </div>
            @endif
            </div>
            </div>    
       		</div>
    </div>

@stop