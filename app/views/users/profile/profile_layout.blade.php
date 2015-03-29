@extends('layout')
@section('head')
    <title>IsoConnect-Profile</title>
@stop


@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-md-3">
                @include('users.profile.user_profile_sidebar') 
             </div>
      
            @if(isset($posts))
                <div class="col-md-6">
            @else
                <div class="col-md-9">
            @endif
                @yield('profile_body')
            </div>    
       		</div>
    </div>

@stop