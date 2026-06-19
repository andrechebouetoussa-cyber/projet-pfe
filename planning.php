<?php

include 'connexion.php';


$sql = "SELECT r.*, u.nom, u.prenom
        FROM rendez_vous r
        JOIN utilisateurs u ON r.id_patient = u.id_user
        WHERE r.statut = 'en_attente'
        ORDER BY r.date_rdv ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php foreach($rdvs as $r): ?>

<div class="card">

    <h3><?= $r['prenom']." ".$r['nom']; ?></h3>

    <p><?= $r['date_rdv']." ".$r['heure_rdv']; ?></p>

    <p><?= $r['motif']; ?></p>

    <a href="valider.php?id=<?= $r['id_rdv']; ?>">✔ Confirmer</a>
    <a href="refuser.php?id=<?= $r['id_rdv']; ?>">❌ Refuser</a>
    <a href="reporter.php?id=<?= $r['id_rdv']; ?>">⏳ Reporter</a>

</div>

<?php endforeach; ?>
    
</body>
</html>
