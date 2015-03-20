
@extends('layout')
@section('head')
<title>IsoConnect-Login</title>


@stop
<style>
    .heading{
        text-align: center;
        font-size: 3.5em;
        font-weight: 700;
    }
</style>
@section('body')
<div class="row">
<div class="col-md-5">
<br> 
        {{ HTML::image( asset('img/icon_front.png'), 'a picture', 
        array('class' => 'img-responsive img-center' ,)) }}
        <div class="col-md-12 col-md-offset-1">
            <h1><a>Iso</a>lation With <a>Connect</a>ion</h1>
           <!--  <h3>Visit the demo at </h3><h1><a>isoconnect.bugs3.com</a></h1>
            <h4>Feedback at /support</h4>
            <h1><a>isoconnect.tk</a></h1> -->

            
        </div>
        </div>
    <div class="col-md-6">
    <br> 
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="">
                <fieldset>
                    <legend>Login</legend>
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
                        <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-10">
                            <input class="form-control" name="password" id="password" placeholder="Password" type="password">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" id="remember" checked="true"> Remember Me
                                </label>
                                <label>
                                   <a href="password_reset">Forget Password</a>
                                </label>
                            </div>
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
        </div>
<!-- <h1 class="heading"><a>isoconnect.bugs3.com</a></h1>
            <h1 class="heading"><a>isoconnect.tk</a></h1> -->
        </div>
</div>
    

 
@stop