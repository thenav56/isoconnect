@extends('layout')
@section('head')
    <title>IsoConnect-Profile</title>
@stop


@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-md-3">
                {{ HTML::image('profile_pic/'.$user->profile_pic, 'a picture', array('class' => 'img-rectangle img-responsive img-center')) }}
                <b><h1>PROFILE</h1></b>
                    <ul>
                    <li><p>({{ $user->name }})</p></li>
                    <li><p>{{ $user->email }}</p></li>
                    <li><p><a href='/user/<?php echo $user->id ?>/profile/'>{{ 'Profile' }}</a></p></li>
                    </ul>       

                <h1>Joined Group</h1>
                    @if($groups)
                    <ul>
                        @foreach($groups as $key => $value)
                    <p><li><a href='/group/{{$value->id}}'>
                    @if($value->admin_id == $user->id)
                        (Admin)
                    @endif
                    {{ e($value->name) }}
                    </a></li></p>
                        @endforeach
                    </ul>
               @endif

            </div>

            <div class="col-md-6 ">
               
               <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ">
                <div class="well bs-component">
                {{ HTML::image('profile_pic/'.$user->profile_pic, 'a picture', array('class' => 'img-rectangle img-responsive img-center')) }}
                        
                <h4><pre>BASIC INFO</h4>
                <h5>Name: {{ $user->name }}<br>
                    Birth date: {{ $user->dob }}<br>
                    Gender: {{ $user->gender}}<br>
                </h5>
                <br>
                <h4><pre>CONTACT INFO</h4>
                <h5>Lives in: {{ $user->address }}<br>
                    Contact no: {{ $user->contact }}<br>
                    E-mail : {{ $user->email }}<br>
                </h5><br>
                <h4><pre>OTHERS</h4>
                <h5>Work OR Academy: {{ $user->company }} </h5>
                </div>
        </div>
</div>
</div>

            </div>    
            </div>
    </div>

@stop