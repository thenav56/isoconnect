
@extends('layout')
@section('head')
<title>IsoConnect-Resend Confirmation</title>
@stop

@section('body')
    <div class="col-lg-6   col-md-offset-3">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="">
                <fieldset>
                    <legend>Resend Confirmation</legend>
                    @if(($errors->first()))
                    <div class="form-group alert alert-warning">
                                <tr class="danger"><ul>
                                    @if(($errors->has('email')))
                                        <li><td>{{ $errors->first('email')}}</td></li>
                                    @endif
                                    @if(($errors->has('password')))
                                        <li><td>{{ $errors->first('password')}}</td></li>
                                    @endif
                                </ul></tr>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input class="form-control" name="email" id="email" placeholder="example@example.com" type="text"
                            value="<?php echo Input::old('email') ;?>" autofocus>
                            </input>
                        </div>
                    </div>
                     
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                </fieldset>
            </form>
        </div>
    </div>

 
@stop