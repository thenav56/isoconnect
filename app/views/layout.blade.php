
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"></meta>
<!-- for chrome for now -->
<meta  name="theme-color" content="#149C82"></meta>
    @yield('head')
    <link rel="shortcut icon" href="{{asset('assests/icon/icon.ico')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{ HTML::style( asset('assests/css/bootstrap.min.css') ) }}
    {{ HTML::style( asset('assests/css/autosuggest.css') ) }}

    <!--{{HTML::style('http://localhost:8080/assests/css/bootstrap.min.css')}}

    --><style>
        body{
            padding-top: 70px;
            background-image: url({{asset("img/notebook.png")}});
            background-repeat: repeat-y repeat-x;
            background-attachment: fixed ;
        }

        .navbar-xs { min-height:28px; height: 45px; }

        .label-as-badge {
    border-radius: 1em;
      }

        .input-mysize {   
   height: 33px;
   width: 200px; }

.sidebar{
    margin-top: 0px;
}

nav {
    word-spacing: 2px;
}
.save_button {
    min-width: 80px;
    max-width: 600px;
}
.boder-bold,
.panel ,
.list-group,
.well {
  border: none;
  border-radius: 2px;
  -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
  }

/*post with photo*/
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
input[readonly] {
  background-color: white !important;
  cursor: text !important;
}
    </style>

   
        
</head>
 
 <body>
 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" title="ISOCONNECT" href="/"><img alt="Isoconnect" class="img-circle" src="{{asset('assests/icon/iso_logo.png')}}" width="30" height="30"></a>
                    <a class="navbar-brand" href="/">IsoConnect</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                     
                     @if (Auth::check())                    
                    <!-- <ul class="nav navbar-nav navbar">
                     <li><div class="btn-group"> -->
                               <form class="navbar-form navbar-left" role="search" method="get" action="<?php echo asset('search') ; ?>">
                                <div class="form-group">
                                  <input class="form-control search typeaheadInput" placeholder="Search" type="text" id="users" name="query" autocomplete="off" >
                                   <button type="submit" style="display: none;" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                              </form>
                          <!-- </div></li>
                    </ul> -->

                    <ul class="nav navbar-nav navbar-right">
                    <?php 
                    $notificationNu = Auth::user()->NotificationUnseen()->count() ;
                    $messageNu = User::unreadmessage() ;

                    $messageBadgeColor = 'label-default'  ;
                    $notificationBadgeColor = 'label-default';
                    if($notificationNu)
                      $notificationBadgeColor = 'label-warning';
                    if($messageNu)
                      $messageBadgeColor = 'label-warning';
                   
                    Session::put('messageNu', $messageNu);
                    $messageNu = ' <span class="label '.$messageBadgeColor.' label-as-badge">'.$messageNu.'</span>' ;
                    
                    Session::put('notificationNu', $notificationNu);
                    $notificationNu =  ' <span class="label '.$notificationBadgeColor.' label-as-badge">'.$notificationNu.'</span>' ;


                    ?>                                                                                                                                     
                              <li><a href="/user/message/show" title="New Message" >Messages<span  id="nav-mess">{{$messageNu}}</span></a></li>
                              <li><a href="/user/notification/show" title="New Notification" >Notifications<span id="nav-noti" >{{$notificationNu}}</span></a></li> 
                                <li><a class="dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">{{ Auth::user()->name }}<span class="caret"></span></a>
                                  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/user/profile">View Profile</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/user/profile/edit">Edit Profile</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/user/password">Account Setting</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/logout">Log Out</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/about">About Us</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/help">Help</a></li>
                                 </ul></li>
                    </ul>
                        @else
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/login">Login</a></li>
                            <li><a href="/register">Sign Up</a></li>
                           </ul> 
                        @endif
                    
                    

                </div><!-- /.navbar-collapse -->
            </div>
        </nav>

  

    <div class="container-fluid">
        
       
    @yield('body')
    </div>


        <!-- Footer -->
       
        <footer>
         <div class="container"><hr>
            <div class="row">
                <div class="col-lg-12">
                    <p><!-- Copyright &copy;  -->I-so-Connect 2015-<?php echo date("Y") ; ?><span class="text-muted pull-right" ><a href="<?php echo asset('about') ;?>">About Us</a></span></p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            </div>
        </footer>
        
  
<!--         
<footer class="footer">
      <div class="container">
       <h4><div class="btn">I-so-Connect 2015-<?php echo date("Y") ; ?></div><span class="text-muted pull-right" ><a class='btn' href="<?php echo asset('about') ;?>">About Us</a></span></h4>
      </div>
</footer>
 -->


@show
</body>
</html>



       {{HTML::script(asset('assests/js/jquery.min.js'))}}
       {{HTML::script(asset('assests/js/typeahead.js'))}}
       {{HTML::script(asset('assests/js/bootstrap.min.js'))}}
       {{HTML::script(asset('assests/js/autoscroll.js'))}}
        {{HTML::script(asset('assests/js/handlebars-v3.0.0.js'))}}
       @include('javascript')   
  @yield('javascript')
  
<?php

//glyphicon glyphicon-thumbs-down
//glyphicon glyphicon-thumbs-up 

?>


