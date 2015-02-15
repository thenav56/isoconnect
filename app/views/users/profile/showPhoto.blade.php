@extends('users.profile.profile_layout')
@section('profile_body')
		
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ">
                <div class="well bs-component">
                <h4><pre>Current Profile Pic</h4>
                
                {{ HTML::image('profile_pic/'.Auth::user()->profile_pic, 'a picture', array('class' => 'img-rectangle img-responsive img-center')) }}
                <h5>Name: {{ Auth::user()->name }}<br>
                	Birth date: {{ Auth::user()->dob }}<br>
                	Gender: {{ Auth::user()->gender}}<br>
                </h5>
                 
                <br>
                
                <h4><pre>Your Profile Pictures</h4>
                @foreach($photos as $photo)
                <a href="{{asset('user/photo/show/'.$photo->id)}}"> 
                {{ HTML::image('profile_pic/'.$photo->location, 'a picture', array('class' => 'img-rectangle img-responsive img-center')) }}
                </a>
                <h5>Uploaded: {{ $photo->created_at->diffForHumans() }}<br>
                <a href="{{asset('user/photo/set/'.$photo->id)}}">Set this as profile picture</a>
                </h5><br>
                @endforeach 
                </div>
        </div>
</div>
</div>



            






@stop