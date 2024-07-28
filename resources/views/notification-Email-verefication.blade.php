<!-- resources/views/emails/verify-email.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header, .footer {
            text-align: center;
            padding: 10px 0;
        }
        .content {
            text-align: center;
            padding: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #6983fa;
            color: #f5eeec;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #ff0d04;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 id="message"> PULSE.Freelancer</h1>
        </div>
        <div class="content">
            <h2>Hello, {{ $name }}!</h2>
            <p>Thank you for registering with our application. To complete the registration process, please click the button below to verify your email address.</p>
            <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
            <p>If you did not create an account, no further action is required.</p>
        </div>
        <div class="footer">
            <p>Thank you for using our application!</p>
            <p>Best regards,<br>PULSE.freelancer Team</p>
        </div>
    </div>
</body>
</html>
