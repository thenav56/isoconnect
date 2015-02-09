@extends('layout')

@section('head')
<title>IsoConnect | Post </title>
@stop

@section('body')

		<div class="row">
            <div class="col-md-6 col-md-offset-3">
             <div class="well bs-component">
                <div class="panel panel-default">
                @if($active) 
                       
                          <div class="panel-heading"> 
                          <h4><a>{{ User::find($post->user_id)['name'] }}</a></h4>
                             <h5>{{$post->created_at->diffForHumans()}}</h5>
                          </div>
                          <div class="panel-body">
                                                
                        <h5>{{e($post->post_body)}}</h5><br>
                           
                            <h5>{{ $post->like}}<a href="/post/{{$post->id}}/like">{{ 'Vote up' }}</a></h5>

                            <!-- comment portion here -->
                         

                            <div class="row">
                                <div class="well bs-component">
                                    <div class="list-group">
                                @foreach($comments as $comment => $_comment)
                                      <a class="list-group-item">
                                            <h4 class="list-group-item-heading">{{ User::find($_comment->user_id)['name'] }}
                                            <h5>{{$_comment->created_at->diffForHumans()}}</h5></h4>
                                            <p class="list-group-item-text">{{e($_comment->comment_body)}}</p>
                                        </a>
                                 @endforeach                 
                                    </div>
                                         
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
                                <input type="hidden" name="comment_post_id"  autocomplete="off" value="<?php echo $post->id; ?>">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    {{ Form::close() }}
                                </div>
                                
                        </div>  
                               </div>             	
                        @else

                            You dont have the permission to view this content
                        @endif
                 </div>
            </div>
		</div>

@stop