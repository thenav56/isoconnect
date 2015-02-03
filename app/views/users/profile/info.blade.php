@extends('users.profile.profile_layout')
@section('profile_body')
		
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ">
                <div class="well bs-component">
                        <h5><p align="right"><a href="/user/profile/edit">{{'Edit Profile'}}</a></p></h5><br><br>
                <h4><pre>BASIC INFO</h4>
                <h5>Name: {{ Auth::user()->name }}<br>
                	Birth date: {{ Auth::user()->dob }}<br>
                	Gender: {{ Auth::user()->gender}}<br>
                </h5>
                <br>
                <h4><pre>CONTACT INFO</h4>
                <h5>Lives in: {{ Auth::user()->address }}<br>
                	Contact no: {{ Auth::user()->contact }}<br>
                	E-mail : {{ Auth::user()->email }}<br>
                </h5><br>
                <h4><pre>OTHERS</h4>
                <h5>Work OR Academy: {{ Auth::user()->company }} </h5>
                </div>
        </div>
</div>
</div>



            






@stop