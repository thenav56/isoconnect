@extends('users.profile.profile_layout')
@section('profile_body')

<div class="container-fluid">
        <div class="row">
             <div class="col-md-12">
                <div class="well bs-component">
				
                {{ Form::open(array('url' => '/user/profile/edit','method' => 'post' , 'class' => 'form-horizontal' , 'files'=>true)) }}                
                <fieldset>
                   
                    <legend>Edit Profile</legend>            

                <h4><pre>BASIC INFO</h4>
            
                    

                                <!-- if there are login errors , show them here -->

                               
                                @if( $errors->has('name') || $errors->has('dob') || $errors->has('profile_pic')) 
                                    <div class="form-group alert alert-warning">
                                        <tr class="warning">
                                            <ul>
                                                @if(($errors->has('name')))
                                                    <li><td>{{ $errors->first('name')}}</td></li>
                                                @endif
                                                @if(($errors->has('dob')))
                                                    <li><td>{{ $errors->first('dob')}}</td></li>
                                                @endif
                                                 @if(($errors->has('profile_pic')))
                                                    <li><td>{{ $errors->first('profile_pic')}}</td></li>
                                                @endif
                                            </ul>
                                        </tr>
                                    </div>
                                @endif
                            
                                <div class="form-group">
                                    {{ Form::label('name' , 'Name' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-8">
                                        {{ Form::text('name' , Input::has('name') ? Input::old('name') : Auth::user()->name,array('placeholder' => ' ' , 'class'=>'form-control' )) }}
                                    </div>
                               </div>


                                <div class="form-group">
                                    {{ Form::label('dob','Date of Birth' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-8">
                                    {{-- This one without FORM --}}<input type="date"  name="dob" placeholder="YYYY-MM-DD" class= 'form-control' min= '1950-08-14'
                                        max="<?php echo date("Y-m-d") ?>" value="{{Input::has('dob') ? Input::old('dob') : '1990-08-14'}}" >

                                    </div>
                                </div> 

                               <div class="form-group">
                                    {{ Form::label('profile_pic','Profile Picture' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-8">
                                      {{Form::file('profile_pic')}}
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    {{ Form::label('gender','Gender' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-10">
                                    <?php
                                     $male = (Auth::user()->gender == 'Male') ? true : false ;
                                    ?>
                                        {{ Form::radio('gender', 'Male',$male )}}
                                        {{ Form::label('gender', 'Male') }}
                                        {{ Form::radio('gender', 'Female',!$male) }} 
                                        {{ Form::label('gender', 'Female') }}
                                    </div>
                                </div>


                            <h4><pre>CONTACT INFO</h4>
                            @if(($errors->has('address')))
                                    <div class="form-group alert alert-warning">
                                        <tr class="warning">
                                            <ul>  
                                                <li><td>{{ $errors->first('address')}}</td></li>
                                            </ul>
                                        </tr>
                                    </div>
                               @endif
                               @if(($errors->has('contact')))
                                    <div class="form-group alert alert-warning">
                                        <tr class="warning">
                                            <ul>  
                                                <li><td>{{ $errors->first('contact')}}</td></li>
                                            </ul>
                                        </tr>
                                    </div>
                               @endif
                                <div class="form-group">
                                    {{ Form::label('address' , 'Lives In' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-8">
                                        {{ Form::text('address' , Input::has('address') ? Input::old('address') : Auth::user()->address ,array('placeholder' => ' ' , 'class'=>'form-control' )) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('contact' , 'Contact' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-8">
                                        {{ Form::text('contact' , Input::has('contact') ? Input::old('contact') : Auth::user()->contact,array('placeholder' => ' ' , 'class'=>'form-control' )) }}
                                    </div>
                               </div>

                            <h4><pre>OTHERS </h4>  
                            @if(($errors->has('company')))
                                    <div class="form-group alert alert-warning">
                                        <tr class="warning">
                                            <ul>  
                                                <li><td>{{ $errors->first('company')}}</td></li>
                                            </ul>
                                        </tr>
                                    </div>
                               @endif  
                                <div class="form-group">
                                    {{ Form::label('company' , 'Work OR Academy' , array( 'class'=>'col-lg-2 control-label')) }}
                                    <div class="col-lg-8">
                                        {{ Form::text('company' , Input::has('company') ? Input::old('company') : Auth::user()->company,array('placeholder' => 'Company OR School ' , 'class'=>'form-control' )) }}
                                    </div>
                               </div>
                                
                                    <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <p>{{ Form::submit('Save' , array('class'=>'btn btn-primary')) }}</p>
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