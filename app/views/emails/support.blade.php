
@extends('layout')
@section('head')
<title>IsoConnect-Forget Password</title>
@stop

@section('body')
    <?php //here the email is taken and confirmation code is send ?>
    <div class="col-lg-6   col-md-offset-3">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="">
                <fieldset>
                    <legend>Report Problem</legend>
                    @if(($errors->first()))
                    <div class="form-group alert alert-warning">
                                <tr class="danger"><ul>
                                    @if(($errors->has('email')))
                                        <li><td>{{ $errors->first('email')}}</td></li>
                                    @endif
                                    @if(($errors->has('name')))
                                        <li><td>{{ $errors->first('name')}}</td></li>
                                    @endif
                                    @if(($errors->has('feedbackmessage')))
                                        <li><td>{{ $errors->first('feedbackmessage')}}</td></li>
                                    @endif
                                    @if(($errors->has('g-recaptcha-response')))
                                        <li><td>{{ $errors->first('g-recaptcha-response')}}</td></li>
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
                        <label for="inputName" class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input class="form-control" name="name" id="name" placeholder="John Smith" type="text"
                            value="<?php echo Input::old('name') ;?>">
                            </input>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputMessage" class="col-lg-2 control-label">Message</label>
                        <div class="col-lg-10">
                            <textarea class="form-control " name="feedbackmessage" rows="4" id="feedbackmessage" placeholder="Tell us how or why u got to this page" type="text"
                            value="<?php echo Input::old('feedbackmessage') ;?>"></textarea> 
                            </input>
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