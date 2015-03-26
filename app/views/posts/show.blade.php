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



          <div class="container-fluid">
              <div class="row">
                      <div class="col-md-12 col-md-offset-1">
                @if($active) 
                       <!-- <div class="container"> -->
                                          <div class="row">

                                             

                                            <div class="col-md-10">
                                              <div class="panel panel-default">
                                                <div class="panel-heading boder-bold">
                                                    
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
                                                    {{nl2br(Post::handleText($post->post_body))}}
                                                    <?php 
                                                                   $post_photos  = Photo::where('source_type','=','post')
                                                                   ->where('source_id','=',$post->id)->get() ;
                                                                  ?>
                                                                  @if($post_photos->count())
                                                                    @foreach($post_photos as $photo)
                                                                  <div class="row">
                                                                    <div class="col-md-12">
                                                                    <hr>
                                                                         <a href="<?php echo asset('user/photo/show/'.$photo->id) ; ?>" >
                                                                            {{ HTML::image('profile_pic/'.$photo->location, 'a picture', 
                                                                            array('class' => 'img-responsive ' 
                                                                        )) }}</a>
                                                                      </div>
                                                                  </div>  
                                                                    @endforeach  
                                                                @endif
                                                </div><!-- /panel-body -->
                                                <div class="panel-heading  boder-bold">
                                                <div class="btn btn-primary btn-sm"><a href="/post/{{$post->id}}/like">
                                                @if(!$liked)
                                                  <span class="glyphicon glyphicon-thumbs-up"></span> Like</a>
                                                @else
                                                  <span class="glyphicon glyphicon-thumbs-down"></span> UnLike</a>
                                                @endif
                                                </div>
                                                @if(Auth::id() == $post->user_id)
                                                  <span class="text-muted pull-right"><a class="btn btn-sm btn-danger" href="{{asset('post/delete/'.$post->id)}}">Delete</a></span>
                                                  <span class="text-muted pull-right"><a class="btn btn-sm btn-default" href="{{asset('post/edit/'.$post->id)}}">Edit</a></span>
                                                 @endif
                                                  <span class="text-muted  pull-right">{{$post->like}} people (<span class="glyphicon glyphicon-thumbs-up">)</span>
                                                  </div>

                                            </div><!-- /panel panel-default -->
                                          </div><!-- /col-sm-5 -->

                                      </div><!-- /row-->
                                      <!-- </div>/container -->
 
                            
                            <!-- comment portion here -->
                         

                            <div class="row">
                                <div class="bs-component col-md-8 col-md-offset-1">
                                    <div class="">
                                @foreach($comments as $comment => $_comment)
                                          <div class="row" id="<?php echo $_comment->id ?>">
<!-- 
                                            <div class="col-sm-1">
                                              <div class="thumbnail">
                                                <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                              </div> 
                                            </div>  -->

                                            <div class="col-md-10 col-md-offset-1" >
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
                                                    {{nl2br(Post::handleText($_comment->comment_body))}}
                                                </div><!-- /panel-body -->
                                            </div><!-- /panel panel-default -->
                                          </div><!-- /col-sm-5 -->

                                      </div><!-- /row-->
                                 @endforeach                 
                                    
                                         
                                 </div>
                             

                             <!-- comment -->
                                 <div class="well comment_update col-md-10 col-md-offset-1" >
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
                                        'class' => 'btn btn-sm btn-primary'
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
		 

@stop

@section('javascript')

@if(Input::has('comment_number'))
<script>
  $(document).ready(function(){
               var comment_position = $('#{{Input::get('comment_number')}}').position() ;
               window.scrollTo( parseInt($(window).scrollLeft()) ,comment_position.top  ) ;
            });
</script>
@endif

@stop