<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Account Active</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
	</style>
</head>
<body>
	<div class="welcome">
		<h1>Dear {{$name}}</h1>
		<a href="<?php echo asset('');?>" title="Isoconnect"><img src="" alt="Isoconnect"></a>
		<h1>You have successfully activated your account Please <a href="<?php echo asset('');?>" title="Isoconnect">Login in</a>  .</h1>
	</div>
</body>
</html>
