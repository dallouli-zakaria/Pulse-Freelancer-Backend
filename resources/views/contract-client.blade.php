<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulse Contrat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .header {
            background-color: #c0392b;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .content {
            background-color: #f2f2f2;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        p {
            margin: 10px 0;
        }

        strong {
            color: #c0392b;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Nouveau Contrat</h1>
    </div>
    <div class="container">
        <div class="content">
            <p>Bonjour,</p>
            <p class="text-center">Un nouveau contrat a été créé avec les détails suivants :</p>
            <p class="text-center mb-10"><strong>Titre:</strong> {{ $contract->title }}</p>
            <p class="mb-10"><strong>Description du projet:</strong> {{ $contract->project_description }}</p>
            <p class="mb-10"><strong>Date de début:</strong> {{ $contract->formatted_start_date }}</p>
            <p class="mb-10"><strong>Date de fin:</strong> {{ $contract->formatted_end_date }}</p>
            
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 Pulse Digital</p>
    </div>
</body>

</html>
