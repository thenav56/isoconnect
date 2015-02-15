@extends('layout')

@section('head')
<title>{{Auth::user()->name}}</title>

<style>
.center {
    margin-left: auto;
    margin-right: auto;     
}


</style>

@stop
@section('body')
		
<div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bs-component">
                    {{ HTML::image('profile_pic/'.$photo->location, 'a picture', array('class' => 'center  thumbnail  img-rectangle img-responsive')) }}
                <span class="pull-right">
                        <a class="btn btn-success" href="{{asset('user/photo/set/'.$photo->id)}}">Set this as profile picture</a>
                    </span>
                    <br>
                </div>
            </div>
          </div>
</div>



            






@stop