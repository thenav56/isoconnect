<div class="row">
    <?php 
        if(!isset($user))
            $user = Auth::user() ;
    ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="list-group-item active">
                                        Profile Picture                                        
                                    </div>
                                    <div class="list-group-item">
                                            {{ HTML::image('profile_pic/'.$user->profile_pic, 'a picture', array('class' => 'img-rectangle img-responsive img-center')) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="list-group">
                                            
                                            <div class="list-group-item active">
                                                Basic Info
                                                @if(Auth::id() == $user->id)
                                                    <span class="pull-right">(<a href="/user/profile/edit" title="Edit Your Details" >Edit</a>)</span>
                                                @endif
                                            </div>
                                            <div class="list-group-item">
                                                Name: {{ $user->name }}
                                            </div>
                                            <div class="list-group-item">
                                                Birth date: {{ $user->dob }}
                                            </div>
                                            <div class="list-group-item">
                                                Gender: {{ $user->gender}}
                                            </div>

                                            <div class="list-group-item active">
                                                Contact Info
                                            </div>
                                            <div class="list-group-item">
                                                Contact no: {{ $user->contact }}
                                            </div>
                                            <div class="list-group-item">
                                                E-mail : {{ $user->email }}
                                            </div>
                                            <div class="list-group-item">
                                                Lives in: {{ $user->address }}
                                            </div>

                                            <div class="list-group-item active">
                                                Others
                                            </div>
                                            <div class="list-group-item">
                                                Work OR Academy: {{ $user->company }}
                                            </div>

                                        </div>           
                                </div>
                            </div>
                        </div>
                    </div>