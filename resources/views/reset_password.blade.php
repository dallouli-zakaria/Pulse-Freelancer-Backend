<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
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
        .email-header img {
            max-width: 150px;
            height: auto;
        }
        .email-body {
            padding: 20px;
            color: #333333;
            text-align: center;
        }
        .email-body h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #0a0a0a; /* Couleur verte pour le titre */
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .email-body a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f53c36; /* Couleur verte pour le bouton */
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
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
                    <!-- Body -->
                    <div class="email-body">
                        <h1>Réinitialisez votre mot de passe</h1>
                        <p>Vous recevez cet email parce que nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
                        <a href="{{ $resetUrl }}">Réinitialiser le mot de passe</a>
                        <p>Si vous n'avez pas demandé la réinitialisation du mot de passe, aucune action supplémentaire n'est requise.</p>
                        <p>Cordialement,<br>PULSE.freelancer</p>
                    </div>

                    <!-- Footer -->
                    <div class="email-footer">
                        <p>Si vous avez des questions, n'hésitez pas à <a href="mailto:jhaidasse@gmail.com">nous contacter</a>.</p>
                        <p>&copy; 2024 PULSE.freelancer.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
