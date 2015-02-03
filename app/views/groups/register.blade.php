@extends('layout')
@section('head')
    <title>IsoConnect | Register Group</title>
@stop



@section('body')

<div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="well bs-component">
                        {{ Form::open(array('url' => 'group/register' , 'class' => 'form-horizontal')) }}
                        <fieldset>
                                <legend>Group | Register</legend>

                                <!-- if there are login errors , show them here -->

                               
                                   @if(($errors->first()))
                                    <div class="form-group alert alert-warning">
                                        <tr class="warning">
                                            <ul>
                                                @if(($errors->has('name')))
                                                    <li><td>{{ $errors->first('name')}}</td></li>
                                                @endif
                                                 @if(($errors->has('about_group')))
                                                    <li><td>{{ $errors->first('about_group')}}</td></li>
                                                @endif
                                                 @if(($errors->has('g-recaptcha-response')))
                                                    <li><td>{{ $errors->first('g-recaptcha-response')}}</td></li>
                                                @endif
                                            </ul>
                                        </tr>
                                    </div>
                                @endif
                                

                                <div class="form-group">
                                    {{ Form::label('name' , 'Group Name'  , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-10">
                                        {{ Form::text('name' , Input::old('name'),array('placeholder' => 'eg:Pulchowk Campus' ,'class'=>'form-control')) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('about_group' , 'About'  , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-10">
                                        {{ Form::textarea('about_group' , Input::old('about_group'),array('placeholder' => 'eg:Engineering Institution' ,
                                        'class'=>'form-control',
                                        'rows' => '2'
                                        )) }}
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