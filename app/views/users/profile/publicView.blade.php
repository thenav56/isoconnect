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
                    <li><p><a href='/user/<?php echo $user->id ?>/profile/info'>{{ 'Profile Info' }}</a></p></li>
                    <li><p><a href="{{asset('/user/message/'.$user->id)}}">Start Conversation</a></li>
                    </ul>

                <h1>Joined Group</h1>
                    <ul>
                    @if($groups)
                        @foreach($groups as $value)
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
                <div class="ViewPost">

            @if($posts->count())
               @include('posts.default')
            @else
            <div class="well bs-component">
                    <h3>{{($user->gender == 'Male')?'He':'She'}} has not posted yet!</h3>
            </div>
            @endif
            </div>
            </div>    
       		</div>
    </div>

@stop