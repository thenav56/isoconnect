@extends('layout')

@section('head')
<title>IsoConnect | Post </title>
<style> 

div.new_message {
    -webkit-animation: myfirst 5s; /* Chrome, Safari, Opera */
    animation: myfirst 5s;
}

/* Chrome, Safari, Opera */
@-webkit-keyframes myfirst {
    from {background: #18bc9c;}
    to {background: #ffffff;}
}

/* Standard syntax */
@keyframes myfirst {
    from {background: #18bc9c;}
    to {background: #ffffff;}
}
</style>

@stop

@section('body')



          <div class="container ">
              <div class="row">
                      <div class="col-md-7 col-md-offset-3">
                @if($active) 
                       <div class="container">
                                          <div class="row">

                                             

                                            <div class="col-md-6">
                                              <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    
                                                    <div class="col-md-2"> 
                                                      <?php  $user = User::find($post->user_id) ; ?>
                                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                                            array('class' => 'img-circle  img-responsive img-center' ,
                                                             
                                                            )) }}</a>
                                                        </div>
                                                       <!--  <div class="row">
                                                          <div class="col-md">
                                                            <div class="panel-heading"> -->
                                                             <strong><a href="/user/<?php echo $post->user_id ?>">{{$user->name }}</a></strong> <span class="text-muted pull-right">Posted To (<a href="{{asset('group/'.$post->group_id)}}">{{($post->group_id == 0)?'Public':(Group::find($post->group_id)->name)}}</a>) {{$post->created_at->diffForHumans()}}</span>
                                                            <!-- </div>
                                                        </div>
                                                    </div> -->
                                                </div> 
                                                <div class="panel-body">
                                                    {{Post::handleText($post->post_body)}}
                                                </div><!-- /panel-body -->
                                                <div class="panel-heading">
                                                @if(!$liked)
                                                  <div class="btn btn-primary"><a href="/post/{{$post->id}}/like"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a></div>
                                                @else
                                                  <div class="btn btn-primary"><a href="/post/{{$post->id}}/like"><span class="glyphicon glyphicon-thumbs-down"></span> UnLike</a></div>
                                                @endif
                                                  <span class="text-muted pull-right"><a class="btn btn-danger" href="{{asset('post/delete/'.$post->id)}}">Delete</a></span>
                                                  <span class="text-muted  ">{{$post->like}} people liked</span>
                                                  </div>

                                            </div><!-- /panel panel-default -->
                                          </div><!-- /col-sm-5 -->

                                      </div><!-- /row-->
                                      </div><!-- /container -->
 
                            
                            <!-- comment portion here -->
                         

                            <div class="row">
                                <div class="well bs-component col-lg-11">
                                    <div class="list-group">
                                @foreach($comments as $comment => $_comment)
                                      <div class="container">
                                          <div class="row">
<!-- 
                                            <div class="col-sm-1">
                                              <div class="thumbnail">
                                                <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                              </div> 
                                            </div>  -->

                                            <div class="col-md-6" id="<?php echo $_comment->id ?>">
                                              <div class="panel panel-default">
                                                <div class="panel-heading">
                                                <div class="col-md-2"> 
                                                      <?php  $user = User::find($_comment->user_id) ; ?>
                                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" >
                                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                                            array('class' => 'img-circle  img-responsive img-center' ,
                                                             
                                                            )) }}</a>
                                                        </div>
                                                  <strong><a href="/user/<?php echo $post->user_id ?>">{{ $user->name }}</a></strong> <span class="text-muted pull-right">{{$_comment->created_at->diffForHumans()}}</span>
                                                </div>
                                                <div class="panel-body <?php 
                                            if(Input::has('comment_number'))  
                                                if($_comment->id == Input::get('comment_number')) 
                                                  echo 'new_message' ;
                                              ?>">
                                                    {{e($_comment->comment_body)}}
                                                </div><!-- /panel-body -->
                                            </div><!-- /panel panel-default -->
                                          </div><!-- /col-sm-5 -->

                                      </div><!-- /row-->
                                      </div><!-- /container -->
                                 @endforeach                 
                                    
                                         
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
                               </div>             	
                        @else

                            You dont have the permission to view this content
                        @endif
                 </div>
            </div>
		</div>

@stop

@section('javascript')

@if(Input::has('comment_number'))
<script>
  $(document).ready(function(){
              var el = document.getElementById({{Input::get('comment_number')}}) ;
               el.scrollIntoView(true);
            });
</script>
@endif

@stop