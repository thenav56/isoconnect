<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Dear {{{$name}}}</h1>
        <h2>Password Changed</h2>

        <div>
            Your password has been changed 
            Ignore this message if you have changed the password <br>
            Otherwise Please check
            <a href="{{ URL::to('/') }}">Isoconnect</a>
            {{ URL::to('/') }}<br/>

        </div>

    </body>
</html>
