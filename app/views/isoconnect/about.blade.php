
@extends('layout')
@section('head')
<title> AboutUs</title>

<style>
    .img-center {
    margin: 0 auto;
}

</style>
@stop

@section('body')
     <!-- Page Content -->
    <div class="container">

        <!-- Introduction Row -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">About Us
                    <small>It's Nice to Meet You!</small>
                </h1>
                <p>Proudly developing with <a href="http://www.laravel.com" target="_blank">Laravel</a> &<a href="http://getbootstrap.com" target="_blank"> Bootstrap</a></p>
            </div>
        </div>

        <!-- Team Members Row -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Our Team</h2>
            </div>
            <div class="col-lg-4 col-sm-6 text-center">
                <img class="img-circle img-responsive img-center" src="https://dl.dropboxusercontent.com/s/he5g425enhide63/photo_nav.png?dl=0" alt="NavinIR">
                <h3>NavinIR
                     
            </div>
            <div class="col-lg-4 col-sm-6 text-center">
                <img class="img-circle img-responsive img-center" src="https://dl.dropboxusercontent.com/s/kp9u33634dcbpnv/photo_pro.png?dl=0" alt="">
                <h3>PramodMn
                    
            </div>
            <div class="col-lg-4 col-sm-6 text-center">
                <img class="img-circle img-responsive img-center" src="https://dl.dropboxusercontent.com/s/yo7jvtdyapboj20/photo_prab.png?dl=0" alt="">
                <h3>PrabeshPthk
                   <!--  <small>Job Title</small>
                </h3>
                <p>What does this team member to? Keep it short! This is also a great spot for social links!</p> -->
            </div>
        </div>
  
    </div>
    <!-- /.container -->


 
@stop