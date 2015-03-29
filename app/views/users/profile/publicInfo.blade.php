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

            <div class="col-md-9">
               <div class="container-fluid">
                    @include('users.profile.detail_info')
                </div>
            </div>    
        </div>
    </div>

@stop