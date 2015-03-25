
@extends('layout')
@section('head')
<title>IsoConnect-Edit post</title>
@stop

@section('body')
<?php $post = Post::find($postid) ;
 ?>
    <div class="col-lg-6   col-md-offset-3">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="/post/edit" autocomplete="off" >
                <fieldset>
                    <legend>Edit post</legend>
                    @if(($errors->first()))
                    <div class="form-group alert alert-warning">
                                <tr class="danger"><ul>
                                   @if(($errors->has('post_body')))
                                        <li><td>{{ $errors->first('post_body')}}</td></li>
                                    @endif
                                </ul></tr>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="inputpost_body" class="col-lg-2 control-label">Edit</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="post_body" id="post_body" 
                             type="text" rows="15">{{$post->post_body}}</textarea>
                        </div>
                    </div>
 
  
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                   
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_postid" value="<?php echo $post->id ?>">
                </fieldset>
            </form>
        </div>
    </div>

 
@stop