<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Reset Your Password</h2>

        <div>
            Please follow the link below to reset your password<br>
            Password Reset Code = {{$confirmation_code}}<br>
            <a herf="{{ URL::to('password_reset/' . $confirmation_code) }}">Reset Password</a>
            <br>
            {{ URL::to('password_reset/' . $confirmation_code) }}
            <br>
            <h4>If you didnt requested this reset than delete this message</h4>

        </div>

    </body>
</html>
