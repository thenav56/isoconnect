
<!DOCTYPE html>
<html lang="en">
<head>
    @yield('head')
    <link rel="shortcut icon" href="{{asset('assests/icon/icon.ico')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{ HTML::style( asset('assests/css/bootstrap.min.css') ) }}
    <!--{{HTML::style('http://localhost:8080/assests/css/bootstrap.min.css')}}
    --><style>
        body{
            padding-top: 70px;
        }

        .navbar-xs { min-height:28px; height: 45px; }

        .input-mysize {   
   height: 33px;
   width: 200px; }

nav {
    word-spacing: 2px;
}
.save_button {
    min-width: 80px;
    max-width: 600px;
}

    </style>
       {{HTML::script(asset('assests/js/jquery.min.js'))}}
       {{HTML::script(asset('assests/js/bootstrap.min.js'))}}
        
</head>
 
<div class="page">
    
      <div class="container-fluid">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img alt="Isoconnect" class="img-circle" src="{{asset('assests/icon/iso_logo.png')}}" width="30" height="30"></a>
                    <a class="navbar-brand" href="/">IsoConnect</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                     
                     @if (Auth::check())

                    <ul class="nav navbar-nav navbar">
                     <li><div class="btn-group ">
                              <form class="navbar-form navbar-left" role="search">
                                 <div class="input-group">
                                    <input type="text" class="form-control input-sm" placeholder="Search...">
                                    <div class = "input-group-btn">
                                      <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-search"></span></button> 
                                   </div>
                                </div>
                              </form></div></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                              <li><form action="/"><button class="btn btn-primary btn-md " type="submit" >Messages <span class="badge">0</span></button></form></li>
                              <li><form action="/user/notification/show"><button class="btn btn-primary btn-md " type="submit" >Notifications <span class="badge" >{{Auth::user()->NotificationUnseen()->count()}}</span></button></form></li> 
                                <li><button class="btn btn-primary dropdown-toggle btn-md " type="button" id="menu1" data-toggle="dropdown">{{ Auth::user()->name }}<span class="caret"></span></button>
                                  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/user/profile">View Profile</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/user/profile/edit">Edit Profile</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Account Setting</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/logout">Log Out</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">About Us</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Help</a></li>
                                 </ul></li>

                        @else
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/login">Login</a></li>
                            <li><a href="/register">Sign Up</a></li>
                        @endif
                    </ul>

                </div><!-- /.navbar-collapse -->
            </div>
        </nav>

    </div>

         
     

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                 @if(Session::has('flash_notice'))
                    <div class="form-group  alert alert-success">
                                <tr class="danger"><ul>
                                    <h4><td>{{ Session::get('flash_notice') }}</td></h4>
                                     
                                </ul></tr>
                        </div>
                    @elseif(Session::has('flash_error'))
                    <div class="form-group  alert alert-danger">
                                <tr class="danger"><ul>
                                    <h4><td>{{ Session::get('flash_error') }}</td></h4>
                                     
                                </ul></tr>
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="container-fluid">
    @yield('body')
    </div>
</div>

<footer class="footer">
      <div class="container">
       <h4>I-so-Connect 2015-<?php echo date("Y") ; ?></h4>
        
      </div>
</footer>



@show
</body>
</html>

<script>
                (function($){
                      window.onbeforeunload = function(e){    
                        var pathname = window.location.href ;
                        window.name = ' ['+pathname+'[' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString();
                        };
                      $.maintainscroll = function() {
                      if(window.name.indexOf('[') > 0)
                        {
                        var pathname = window.location.href ;
                        var parts = window.name.split('['); 
                        if(parts[1] == pathname){
                          window.name = $.trim(parts[0]);
                          window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
                          }
                        }   
                      };  
                      $.maintainscroll();
                      })(jQuery);
          </script>

<?php

//glyphicon glyphicon-thumbs-down
//glyphicon glyphicon-thumbs-up 

?>


