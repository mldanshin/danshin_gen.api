<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <form method="POST" action="{{ route('login.auth') }}">
            @csrf
            <div>
                <label for="identifier"></label>
                <input type="text" name="email" id="identifier" required autofocus autocomplete="off">
            </div>
            <div class="mt-4">
                <label for="password"></label>
                <input type="password" name="password" id="password" required autocomplete="current-password">
            </div>
            <input type="submit" value="">
        </form>
    </body>
</html>