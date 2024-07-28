<!-- resources/views/verify-email.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1{
           color: #f71b1b
        }
        .container {
            text-align: center;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        button {
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            background-color: #f71b1b;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 id="message"> PULSE.Freelancer</h1>
        <button id="redirectBtn" style="display: none;" onclick="redirectToLogin()">Go to Login</button>
    </div>
    <script>
        (function() {
            const message = "{{ $message }}";
            const messageElement = document.getElementById('message');
            const redirectBtn = document.getElementById('redirectBtn');

            if (message === "Email verified successfully") {
                messageElement.textContent = message;
              
                redirectBtn.style.display = 'block';
            } else {
                messageElement.textContent = message;
            }
        })();

        function redirectToLogin() {
            window.location.href = "http://localhost:4200/login";
        }
    </script>
</body>
</html>
