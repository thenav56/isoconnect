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
                                             <?php  $user = User::find($post->user_id) ; ?>
                                              <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <div class="col-md-2">
                                                        @if(!$user)
                                                            {{ HTML::image('profile_pic/low/crop' , 'a picture', 
                                                            array('class' => 'img-circle  img-responsive img-center' 
                                                            )) }}</a>
                                                        @else
                                                            <a href="<?php echo asset('user/'.$user->id) ; ?>" > 
                                                            {{ HTML::image('profile_pic/low/crop/'.$user->profile_pic, 'a picture', 
                                                            array('class' => 'img-circle  img-responsive img-center' 
                                                            )) }}</a>
                                                        @endif

                                                        </div> 
  
                                                        
                                                            <!-- <div class="col-md"> -->
                                                            @if(!$user)
                                                                 <strong><a href="/user/<?php echo $post->user_id ?>">{{"Unknown"}}</a></strong><a class="pull-right" href='/post/{{$post->id}}'>Read More&#8594;</a>
                                                            @else
                                                                 <strong><a href="/user/<?php echo $post->user_id ?>">{{$user->name }}</a></strong><a class="pull-right" href='/post/{{$post->id}}'>Read More&#8594;</a>
                                                            @endif
                                                               <!--   <div class="panel-heading">--><br>Posted to  
                                                                        @if(($gpid=Post::find($post->id)->group_id) != 0)
                                                                            <a href='/group/<?php echo $gpid ; ?>'>{{Group::find($gpid)->name}}</a>
                                                                        @else
                                                                            {{'Public'}}
                                                                        @endif
                                                                 <span class="text-muted pull-right">{{$post->created_at->diffForHumans()}}</span>
                                                              <!--       </div>
                                                            </div> -->
                                                        
                                                
                                                    </div>

                                                   
                                                            <div class="panel-body">
                                                                 {{Post::handleText($post->post_body)}} <br>


                                                                 <?php 
                                                                   $post_photos  = Photo::where('source_type','=','post')
                                                                   ->where('source_id','=',$post->id)->get() ;
                                                                  ?>
                                                                  @if($post_photos->count())
                                                                    @foreach($post_photos as $photo)
                                                                         <a href="<?php echo asset('user/photo/show/'.$photo->id) ; ?>" >
                                                                            {{ HTML::image('profile_pic/'.$photo->location, 'a picture', 
                                                                            array('class' => 'img-responsive ' 
                                                                        )) }}</a>
                                                                    @endforeach    
                                                                @endif
                                                            </div><!-- /panel-body -->
                                                                                               
                                           
                        <div class="well bs-component" >
                        
                        <!--comment -->
                        <div class="comment_update" >
                                {{ Form::open(array('url' => 'user/comment')) }}
                                 
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
                                
                                    <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                    @if($comment->count())
                                    <label>Recent Comment By</label>
                                    <?php $recent_commenter = User::find($comment->orderBy('id','desc')->get()->first()->user_id); ?>
                                        <a href="/user/{{$recent_commenter->id}}/profile">{{$recent_commenter->name}}</a><br>
                                           </div>
                                           <div class="panel-body">
                                         {{e($comment->get()->first()->comment_body)}}<br><br>
                                            </div>
                                   @else
                                   </div>
                                     <div class="panel-body">
                                    <h6>Be the first to comment</h6> 
                                   </div>
                                   @endif
                                   
                                   </div><!-- /panel panel-default -->
                                   </div>
                                    {{ Form::label('user_comment' , 'Comment!') }}<a href="{{asset('/post/'.$post->id)}}">  ({{$comment->count()}})</a>
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
             
            <?php  echo  $posts->appends(Request::except('page'))->links() ?>
        </div>


