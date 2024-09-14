<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de l'email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table {
            border-spacing: 0;
            width: 100%;
        }
        td {
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding: 20px 0;
        }
        .email-body {
            padding: 20px;
            color: #333333;
            text-align: center;
        }
        .email-body h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .email-body a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f53c36;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777777;
        }
        .email-footer a {
            color: #fa4545;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <table role="presentation" width="100%">
        <tr>
            <td>
                <div class="email-container">
                    <!-- Header -->
                    <div class="email-header">
                        <h1>PULSE.Freelancer</h1>
                    </div>

                    <!-- Body -->
                    <div class="email-body">
                        <h2>Bonjour, {{ $name }}!</h2>
                        <p>Merci de vous être inscrit à notre application. Pour compléter votre inscription, veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email.</p>
                        <a href="{{ $verificationUrl }}" class="button">Vérifier l'adresse email</a>
                        <p>Si vous n'avez pas créé de compte, aucune action supplémentaire n'est requise.</p>
                    </div>

                    <!-- Footer -->
                    <div class="email-footer">
                        <p>Merci d'utiliser notre application !</p>
                        <p>Cordialement,<br>L'équipe PULSE.freelancer</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
