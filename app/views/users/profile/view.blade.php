@extends('users.profile.profile_layout')
@section('profile_body')
            <div class="ViewPost">

            @if($posts->count())
                @include('posts.default')
            @else
            <div class="well bs-component">
                    <h3>{{'no post here'}}</h3>
            </div>
            @endif
            </div>
            
@stop