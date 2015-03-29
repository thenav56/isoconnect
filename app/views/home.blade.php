<!-- app/views/home.blade.php -->
@extends('layout')
@section('head')
    <title>IsoConnect-Home</title>
 
@stop

@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                @include('users.profile.user_profile_sidebar') 
            </div>
   
            <div class="col-md-6 sidebar">
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
                 
                <div class="">
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
                                <span class="input-group-btn  ">
                                    <span class="btn btn-primary btn-file">
                                        Browse&hellip; {{Form::file('photos[]' , array('multiple' => true))}}
                                    </span>
                                </span>
                                <input type="text" class="form-control" placeholder="upload photo" readonly>
                            </div>
                           
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
<div class="col-md-3 sidebar">
    @include('flash_notice')
    <div class="list-group">
         <a class="list-group-item list-group-item-success">
                    <h5>People You May Know</h5>
        </a>
                    <?php 
                    $user_list = User::where('confirmed' ,'=' ,1)->orderBy('created_at','desc')->simplePaginate(5) ;
                    ?>
                <div class="list-group">
                    @foreach($user_list as $user)
                    @if($user->id != Auth::id())
                    <a href='<?php echo asset('user/') ;?>/{{$user->id}}' 
                    class="list-group-item list-group-item-">    <br>
                        <div class='row'>
                              <div class='col-md-3'>
                              <img class='img-circle img-responsive img-center' src='<?php echo asset('profile_pic/low/crop/') ;?>/{{$user->profile_pic}}' >
                              </div>
                              <div class='col-md'>
                              <h6><strong>{{$user->name}}</strong></h6>
                              </h6><h6>{{$user->company}}</h6></h6>
                              </div>
                              </div>
                    </a>
                    @endif
                    @endforeach
            </div>
    </div>
<div class="list-group">
         <a class="list-group-item list-group-item-success">
                    <h5>Group You May Know</h5>
        </a>
                    <?php 
                    Paginator::setPageName('grouplist') ;                    
                    $group_list = Group::orderBy('created_at','desc')->simplePaginate(8) ;
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
                    <a href='<?php echo asset('group/') ;?>/{{$group->id}}' class="list-group-item list-group-item-">
                        <br>
                        <div class='row'>
                              <div class='col-md-11'>
                              <h6><strong>{{$group->name}}</strong></h6>
                              <h6>{{$group->about}}</h6>
                              </div>
                              </div>
                    </a>
                    @endif
                    @endforeach
                    <?php  
                    // Paginator::setPageName('grouplist') ;
                    // echo  $group_list->appends(Request::except('grouplist'))->links() 
                    ?>
                    </div>


    </div>

@stop
