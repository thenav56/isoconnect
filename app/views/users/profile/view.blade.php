@extends('users.profile.profile_layout')
@section('profile_body')
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
            
@stop