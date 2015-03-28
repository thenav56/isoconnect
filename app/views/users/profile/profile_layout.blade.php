@extends('layout')
@section('head')
    <title>IsoConnect-Profile</title>
@stop


@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-md-3 well">
                {{ HTML::image('profile_pic/'.Auth::user()->profile_pic, 'a picture', array('class' => 'img-rectangle img-responsive img-center')) }}
                <h1>Profile</h1> 
                    <ul>
                    <li><p>Welcome({{ Auth::user()->name }})</p></li>
                    <li><p>{{ Auth::user()->email }}</p></li>
                    <li><p><a href='/user/profile/info'>{{ 'Profile Info' }}</a></p></li>
                    <li><a href="<?php echo asset('user/photo') ; ?>">Manage Profile Picture</a></li>
                    </ul>

                <h1>Your Group</h1>
                    <ul>@if($groups)
                        @foreach($groups as $value)
                    <p><li><a href='/group/{{$value->id}}'>
                    @if($value->admin_id == Auth::id())
                        (Admin)
                    @endif
                    {{ e($value->name) }}
                    </a></li></p>
                        @endforeach
                        @else
                            Add New Group Search!
                        @endif
                    </ul>
                <p><li><a href='/group/register'>Create Your Own Group</a></li></p>

            </div>
      
            <div class="col-md-6 ">
                @yield('profile_body')
            </div>    
       		</div>
    </div>

@stop