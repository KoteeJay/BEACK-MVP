<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Platform!</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}! 🎉</h1>
    <p>Thank you for joining our platform. We’re excited to have you on board!</p>
    <p>Feel free to explore and reach out if you need any help.</p>
    <br>
    <p>Best Regards,</p>
    <p><strong>{{ config('app.name') }}</strong></p>
</body>
</html>
