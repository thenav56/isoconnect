<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Feedback Submitted</title>
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
		<h1>Dear Navin</h1>
		<a href="<?php echo asset('');?>" title="Isoconnect"><img src="" alt="Isoconnect"></a>
		<h1>Your feedback is Here  </h1>
		<ul>
			<li>Email:: {{$email}} </li>
			<li>Name:: {{$name}}</li>
			<li>Message:: {{$feedbackmessage}}</li>
		</ul>
	</div>
</body>
</html>
