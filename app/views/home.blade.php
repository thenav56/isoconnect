<!-- app/views/home.blade.php -->
@extends('layout')
@section('head')
    <title>IsoConnect-Home</title>
@stop

@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 ">
                <div class="container-fluid well bs-component ">
                    <h4>Home</h4>
                        <ul>
                        <li><p>Welcome({{ Auth::user()->name }})</p></li>
                        <li><p><a href="/user/profile">{{ 'Profile' }}</a></p></li>
                        </ul>

                        <h4>Your Group</h4>
                            @if($groups)
                            <ul>
                                @foreach($groups as $key => $value)
                            <p><li><a href='/group/{{$value->id}}'>
                            @if($value->admin_id == Auth::id())
                                (Admin)
                            @endif
                            {{ e($value->name) }}
                            </a></li></p>
                                @endforeach
                            </ul>
                            @else
                                <ul><p>You are not connected to any Group Use search to search</p></ul>
                            @endif
                        <p><li><a href='/group/register'>Create Your Own Group</a></li></p>
                </div>
            </div>
   
            <div class="col-md-6 ">
                <div class="status_update" >
                {{ Form::open(array('url' => 'user/post' , 'files' => true)) }}
                <!-- if there are login errors , show them here -->
                @if($errors->first())
                    <div class="form-group alert alert-warning">
                                <tr class="danger">
                                    <ul> 
                                        @if($errors->has('user_post'))
                                        <li><td>{{ $errors->first('user_post') }}</td></li> 
                                        @endif
                                        @if($errors->has('photos'))
                                        <li><td>{{ $errors->first('photos') }}</td></li> 
                                        @endif
                                    </ul>
                                </tr>
                        </div>
                    @endif 
                 
                <p>
                    {{ Form::label('user_post' , 'Write Here! ') }}<!-- ((Auth::user()->gender == 'Male')?'DUDE!':'DUDETTE!')  -->
                    {{ Form::textarea('user_post' ,'' ,  array(
                    'placeholder'   => 'Want To Share Something!(Public Post)' , 
                    'class'         => 'form-control'   ,
                    'rows'          => '2'
                    )) }}
                </p>
                <div class="row">
                <div class="col-md-2">
                <p>{{ Form::submit('Submit!' , array(
                    'class' => 'btn btn-primary'
                    )) }}
                    </div>
                    <div class="col-md-5">
                    <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        Browse&hellip; {{Form::file('photos[]' , array('multiple' => true))}}
                                    </span>
                                </span>
                                <input type="text" class="form-control" placeholder="upload photo" readonly>
                            </div>
                           
                        </div>
                   
                </p>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                {{ Form::close() }}
            </div>

            <div class="post">
            @include('posts.default')
            </div>

    </div>
</div>
<div class="col-md-3">
    <br>
    <br>
    
    <div class="well bs-component">
                    <h4>People You May Know</h4>

                    <?php 
                    $user_list = User::where('confirmed' ,'=' ,1)->orderBy('created_at','desc')->simplePaginate(5) ;
                    ?>
                    @foreach($user_list as $user)
                    @if($user->id != Auth::id())
                        <br>
                        <div class='row'>
                              <a href='<?php echo asset('user/') ;?>/{{$user->id}}' >
                              <div class='col-md-3'>
                              <img class='img-circle img-responsive img-center' src='<?php echo asset('profile_pic/low/crop/') ;?>/{{$user->profile_pic}}' >
                              </div>
                              <div class='col-md'>
                              <h6><strong>{{$user->name}}</strong></h6>
                              </a>
                              </h6><h6>{{$user->company}}</h6></h6>
                              </div>
                              </div>
                    @endif
                    @endforeach
            </div>

    <div class="well bs-component">
                    <h4>Group You May Know</h4>

                    <?php 
                    Paginator::setPageName('gouplist') ;                    
                    $group_list = Group::orderBy('created_at','desc')->simplePaginate(5) ;
                    $already_in = false ;
                    ?>
                    @foreach($group_list as $group)
                    @if($group->user_id != Auth::id())
                        <?php $already_in = false ; ?>
                        @if($groups)
                        @foreach($groups as $_group)
                            @if($group->id == $_group->id)
                                <?php $already_in = true ; 
                                    continue
                                ?>
                            @endif
                        @endforeach
                        @endif
                        <?php if($already_in)
                            continue
                        ?>

                        <br>
                        <div class='row'>
                              <a href='<?php echo asset('group/') ;?>/{{$group->id}}' >
                               
                              <div class='col-md-11'>
                              <h6><strong>{{$group->name}}</strong></h6>
                              </a>
                              </h6><h6>{{$group->about}}</h6></h6>
                              </div>
                              </div>
                    @endif
                    @endforeach
                    {{Paginator::setPageName('gouplist')}}
                    <?php  echo  $posts->appends(Request::except('page'))->links() ?>


            </div>

    </div>

@stop
