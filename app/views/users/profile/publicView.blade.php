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