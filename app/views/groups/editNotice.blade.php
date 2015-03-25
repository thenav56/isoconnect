
@extends('layout')
@section('head')
<title>IsoConnect-Edit Notice</title>
@stop

@section('body')
<?php $notice = GroupNotice::find($noticeid) ;
 ?>
    <div class="col-lg-6   col-md-offset-3">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="/group/post_notice/edit" autocomplete="off" >
                <fieldset>
                    <legend>Edit Notice</legend>
                    @if(($errors->first()))
                    <div class="form-group alert alert-warning">
                                <tr class="danger"><ul>
                                   @if(($errors->has('notice_message')))
                                        <li><td>{{ $errors->first('notice_message')}}</td></li>
                                    @endif
                                </ul></tr>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="inputnotice_message" class="col-lg-2 control-label">Edit</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="notice_message" id="notice_message" 
                             type="text" rows="15">{{$notice->post_body}}</textarea>
                        </div>
                    </div>
 
  
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                   
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_groupid" value="<?php echo $notice->group_id ?>">
                    <input type="hidden" name="_noticeid" value="<?php echo $notice->id ?>">
                </fieldset>
            </form>
        </div>
    </div>

 
@stop