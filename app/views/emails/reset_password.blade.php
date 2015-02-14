
@extends('layout')
@section('head')
<title>IsoConnect-Reset Password</title>
@stop

@section('body')
<?php //here the password is reset ?>
    <div class="col-lg-6   col-md-offset-3">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="">
                <fieldset>
                    <legend>Forget Password</legend>
                    @if(($errors->first()))
                    <div class="form-group alert alert-warning">
                                <tr class="danger"><ul>
                                    @if(($errors->has('password')))
                                        <li><td>{{ $errors->first('password')}}</td></li>
                                    @endif
                                     @if(($errors->has('password_confirmation')))
                                        <li><td>{{ $errors->first('password_confirmation')}}</td></li>
                                    @endif
                                </ul></tr>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-10">
                            <input class="form-control" name="password" id="password" placeholder="Password" type="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword" class="col-lg-2 control-label">RePassword</label>
                        <div class="col-lg-10">
                            <input class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password confirmation" type="password">
                        </div>
                    </div>

                    <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                        {{Form::captcha()}}
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