<!DOCTYPE html>
<html lang="en">
<head>
    <title>404 Error</title>
    <link rel="shortcut icon" href="{{asset('assests/icon/icon.ico')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{ HTML::style( asset('assests/css/bootstrap.min.css') ) }}

    <!--{{HTML::style('http://localhost:8080/assests/css/bootstrap.min.css')}}

    --><style>

        body{
            padding-top: 70px;
               /*background: url('http://newcavern.org/wp-content/themes/jupiter/images/box-warning-icon.png') repeat scroll 50% 0;*/
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


<style>
     .error-template {
            padding: 40px 15px;text-align: center;
            
                }
        .error-actions {
            margin-top:15px;margin-bottom:15px;
            
        }
        .error-actions .btn {
         margin-right:10px; 
         
        }

</style>
        
</head>
<body>


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
                     
                   <a class="navbar-brand pull-right"  >{{$name}} ERROR</a>

                </div><!-- /.navbar-collapse -->
            </div>
        </nav>

    </div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
            <img src="{{$pic}}" class="img-rounded" alt="Cinque Terre" width="304" height="236"> 
                 <div style="<!-- background-color: #66FF99 -->">
                <h1 >
                    Oops!</h1>
                <h2>
                    {{$name}} {{$title}} </h2>
                <div class="error-details">
                    {{$message}}
                </div>
                <div>
                	<h6>Check URL and Try Again!</h6>
                </div>
                </div>
                <div class="error-actions">
                    <a href="<?php echo asset(''); ?> " class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                        Take Me Home </a><a href="<?php echo asset('support'); ?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
                </div>
                
            </div>
        </div>
    </div>
</div>

 </body>