@extends('layout')
@section('head')
<title>IsoConnect-Registration</title>
@stop
@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="well bs-component">
                        {{ Form::open(array('url' => 'register' , 'class' => 'form-horizontal')) }}
                        <fieldset>
                                <legend>Register</legend>

                                <!-- if there are login errors , show them here -->

                               
                                @if(($errors->first()))
                                    <div class="form-group alert alert-warning">
                                        <tr class="warning">
                                            <ul>
                                                @if(($errors->has('email')))
                                                    <li><td>{{ $errors->first('email')}}</td></li>
                                                @endif
                                                 @if(($errors->has('name')))
                                                    <li><td>{{ $errors->first('name')}}</td></li>
                                                @endif
                                                 @if(($errors->has('password')))
                                                    <li><td>{{ $errors->first('password')}}</td></li>
                                                @endif
                                                @if(($errors->has('password_confirmation')))
                                                    <li><td>{{ $errors->first('password_confirmation')}}</td></li>
                                                @endif
                                                @if(($errors->has('g-recaptcha-response')))
                                                    <li><td>{{ $errors->first('g-recaptcha-response')}}</td></li>
                                                @endif
                                            </ul>
                                        </tr>
                                    </div>
                                @endif
                            
                                <div class="form-group">
                                    {{ Form::label('email' , 'Email' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-10">
                                        {{ Form::text('email' , Input::old('email'),array('placeholder' => 'example@example.com' , 'class'=>'form-control' )) }}
                                    </div>
                               </div>

                                <div class="form-group">
                                    {{ Form::label('name' , 'Name'  , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-10">
                                        {{ Form::text('name' , Input::old('name'),array('placeholder' => 'John Smith' ,'class'=>'form-control')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('password','Password' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-10">
                                        {{ Form::password('password'  , array('class'=>'form-control'))}}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('password_confirmation','R-Password' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-10">
                                        {{ Form::password('password_confirmation'  , array('class'=>'form-control'))}}
                                    </div>
                                </div>

                               <div class="form-group">
                                    {{ Form::label('gender','Gender' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-10">
                                     
                                        {{ Form::radio('gender', 'Male',true)}}
                                        {{ Form::label('gender', 'Male') }}
                                        {{ Form::radio('gender', 'Female' ) }} 
                                        {{ Form::label('gender', 'Female') }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        {{Form::captcha()}}
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <p>{{ Form::submit('Submit!' , array('class'=>'btn btn-primary')) }}</p>
                                    </div>
                                </div>

                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        
                        </fieldset>
                        {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop
