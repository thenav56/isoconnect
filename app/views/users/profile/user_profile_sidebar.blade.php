<div class="list-group" >
                    <div class="list-group-item active">
                        <div class="row">
                            <div class="col-md-6">
                             @if(isset($user))
                             Profile
                             @else   
                                Welcome-Home
                             @endif
                            </div>
                             @if(!isset($user))
                            <div class="col-md-6">
                                <span class="pull-right" >(<a href="/user/profile/edit">Edit Profile</a>)</span>
                            </div>
                            @endif
                        </div>
                    </div>
                        <div class="row">
                                <div class="col-md-12">
                                        <?php 
                                                        if(isset($user)){
                                                            $profile_pic = $user->profile_pic ;
                                                            $name = $user->name ;
                                                            $email = $user->email ;
                                                            $id = $user->id ;
                                                        }else{
                                                            $profile_pic = Auth::user()->profile_pic ;
                                                            $name = Auth::user()->name ;
                                                            $email = Auth::user()->email ;
                                                            $id = Auth::user()->id ;
                                                        }
                                                    ?>
                                    <div class="list-group-item">
                                      <a title="Your Profile" href="<?php echo asset('user/'.$id) ; ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{ HTML::image('profile_pic/'.$profile_pic, 'a picture', 
                                                array('class' => 'img-center',
                                                'width'         => '128' ,
                                                'height'        => '128'
                                                )) }}
                                            </div>
                                            <div class="col-md-6"> 
                                                {{$name}} 
                                            </div>
                                        </div>
                                      </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12">
                                        <div class="list-group-item"> 
                                            {{$email}}
                                        </div>
                                        @if(isset($user))
                                        <a class="list-group-item" href='/user/<?php echo $user->id ?>/profile/info'>{{ 'Profile Info' }}</a>
                                        <a class="list-group-item list-group-item-info"  href="{{asset('/user/message/'.$user->id)}}">Start Conversation</a>
                                        @else
                                        <a class="list-group-item" 
                                        href="<?php echo asset('user/photo') ; ?>">Manage Profile Picture
                                        </a>
                                        <a class="list-group-item list-group-item-info"
                                         href='/user/profile/info'>{{ 'Profile Info' }}
                                         </a>
                                         @endif
                                </div>
                        </div>
                </div>  
                    
                <div class="list-group" >
                 <a class="list-group-item list-group-item-success">
                    @if(isset($user))
                        <h5>Joined Group</h5>
                    @else
                        <h5>Your Group</h5>
                    @endif
                </a>
                            @if($groups)
                                @foreach($groups as $key => $value)
                            <a class="list-group-item" href='/group/{{$value->id}}'>
                            @if($value->admin_id == $id)
                                (Admin)
                            @endif
                            {{ e($value->name) }}
                            </a>
                                @endforeach
                            @else
                                @if(isset($user))
                                    <div class="list-group-item"> 
                                        {{$name." hasnt joined any group at the moment"}} 
                                    </div>
                                @else
                                    <div class="list-group-item"> 
                                        You are not connected to any Group Use search to search
                                    </div>    
                                @endif
                            @endif
                         @if(!isset($user))
                                <a class="list-group-item list-group-item-info"href='/group/register'>Create Your Own Group</a>
                         @endif
                </div>