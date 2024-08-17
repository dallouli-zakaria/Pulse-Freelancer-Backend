<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Contrat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #1758e4;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .content {
            background-color: #fdfff6;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }
        .text-center {
            text-align: center;
        }
        .mb-10 {
            margin-bottom: 10px;
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
            <p>Merci!</p>
        </div>
    </div>
</body>
</html>