<!DOCTYPE html>
<html>
<head>
    <style>
       body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #e8f5e9; /* Light green background */
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2e7d32; /* Dark green color for the heading */
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50; /* Green color for the button */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .signature {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

    </style>
</head>
<body>
    <h1>Reset Your Password</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <a href="{{ $resetUrl }}">Reset Password</a>
    <p>If you did not request a password reset, no further action is required.</p>
    
    <p>Best regards,<br>PULSE.freelancer</p>
</body>
</html>