<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    <h1>Dear {{$name}}</h1>
        <h2>Verify Your Email Address</h2>

        <div>
            Thanks for creating an account with Us 'IsoConnect'.
            Please follow the link below to verify your email address<br>
            <a href="{{ URL::to('register/verify/' . $confirmation_code) }}">Activate</a>
            {{ URL::to('register/verify/' . $confirmation_code) }}<br/>

        </div>

    </body>
</html>
