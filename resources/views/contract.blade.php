<!DOCTYPE html>
<html>
<head>
    <title>Nouveau Contrat</title>
</head>
<body>
    <h1>Nouveau Contrat</h1>
    <p>Bonjour,</p>
    <p>Un nouveau contrat a été créé avec les détails suivants :</p>

    <p><strong>Titre:</strong> {{ $contract->title }}</p>

    <p><strong>Description du projet:</strong> {{ $contract->project_description }}</p>

    <p><strong>Date de début:</strong> 
        {{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') : 'Non spécifiée' }}
    </p>

    <p><strong>Date de fin:</strong> 
        {{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') : 'Non spécifiée' }}
    </p>

    <p>Merci!</p>
</body>
</html>

