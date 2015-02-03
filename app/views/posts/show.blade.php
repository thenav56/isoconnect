@extends('layout')

@section('head')
<title>IsoConnect | Post </title>
@stop

@section('body')
		<div class="row">
            <div class="col-md-6 col-md-offset-3">
            	<div class="well bs-component">   
                @if($active)
                            <h4><a>{{ User::find($post->user_id)['name'] }}</a></h4>
                             <h5>{{$post->created_at->diffForHumans()}}</h5>
                            <h5>{{e($post->post_body)}}</h5><br>
                           e
                            <h5>{{ $post->like}}<a href="/post/{{$post->id}}/like">{{ 'Vote up' }}</a></h5>

                            <!-- comment portion here -->
                           
                            <div class="row">
                                 <div class="well bs-component">
                                    
                                         @foreach($comments as $comment => $_comment)
                                        
                                             <div class="alert " role="alert">
                                                 <h4><a>{{ User::find($_comment->user_id)['name'] }}</a></h4>
                                                 <h5>{{$_comment->created_at->diffForHumans()}}</h5>
                                                 <h5>{{e($_comment->comment_body)}}</h5>
                                            </div> 
                                         @endforeach
                               
                                 </div>
                             </div>

                             <!-- comment -->
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
                                    <p>
                                        {{ Form::label('user_comment' , 'Comment!') }}
                                        {{ Form::textarea('user_comment' ,'' ,  array(
                                        'placeholder'   => 'Have Some Comment!' , 
                                        'class'         => 'form-control'   ,
                                        'rows'          => '2'
                                        )) }}
                                    </p>
                                    <p>{{ Form::submit('Comment!' , array(
                                        'class' => 'btn btn-primary'
                                        )) }}</p>
                                    <input type="hidden" name="comment_post_id_token"  autocomplete="off" value="<?php echo hash('md4' ,$post->id.$rand); ?>">
                                <input type="hidden" name="comment_post_id"  autocomplete="off" value="<?php echo $post->id; ?>">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    {{ Form::close() }}
                                </div>
                                            	
                        @else

                            You dont have the permission to view this content
                        @endif
                 </div>
            </div>
		</div>

@stop