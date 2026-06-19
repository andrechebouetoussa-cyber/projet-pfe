<?php
session_start();
include 'connexion.php';

$sql = "
SELECT 
    r.id_rdv,
    r.date_rdv,
    r.heure_rdv,
    r.motif,
    r.statut,
    u.nom AS patient_nom,
    u.prenom AS patient_prenom,
    m.nom AS medecin_nom,
    m.prenom AS medecin_prenom
FROM rendez_vous r

JOIN utilisateurs u ON r.id_patient = u.id_user
JOIN utilisateurs m ON r.id_medecin = m.id_user

WHERE TRIM(r.statut) = 'en_attente'
ORDER BY r.date_rdv ASC, r.heure_rdv ASC
";

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
    

<h2>📥 RDV en attente de validation</h2>

<?php foreach($rdvs as $r): ?>

<div class="card">

    <p>
        👤 Patient : <?= htmlspecialchars($r['patient_prenom']." ".$r['patient_nom']); ?>
    </p>

    <p>
        👨‍⚕️ Médecin : Dr <?= htmlspecialchars($r['medecin_prenom']." ".$r['medecin_nom']); ?>
    </p>

    <p>
        📅 <?= $r['date_rdv']; ?> - 🕒 <?= $r['heure_rdv']; ?>
    </p>

    <p>
        📝 <?= htmlspecialchars($r['motif']); ?>
    </p>

    <!-- ACTIONS -->
    <div style="margin-top:10px;">

        <a href="valider_rdv.php?id=<?= $r['id_rdv']; ?>"
           style="color:green; margin-right:10px;">
            ✔ Confirmer
        </a>

        <a href="refuser_rdv.php?id=<?= $r['id_rdv']; ?>"
           style="color:red;">
            ❌ Refuser
        </a>

    </div>

</div>

<?php endforeach; ?>

</body>
</html>