<?php
include 'connexion.php';

$id = $_GET['id'];

/* 1. récupérer médecin + patient */
$stmt = $conn->prepare("
SELECT id_medecin, id_patient 
FROM rendez_vous 
WHERE id_rdv = ?
");
$stmt->execute([$id]);
$rdv = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$rdv){
    die("Rendez-vous introuvable");
}

/* 2. confirmer RDV */
$conn->prepare("
UPDATE rendez_vous 
SET statut = 'confirme'
WHERE id_rdv = ?
")->execute([$id]);

/* 3. messages */
$message_patient = "📅 Votre rendez-vous a été confirmé.\nNe le ratez pas.\nVotre santé, au cœur de l’innovation.";
$message_medecin = "Un rendez-vous vient d’être confirmé.";

/* 4. notification patient (AVEC id_rdv) */
$conn->prepare("
INSERT INTO notification (id_user, id_rdv, message, is_read, created_at)
VALUES (?, ?, ?, 0, NOW())
")->execute([
    $rdv['id_patient'],
    $id,
    $message_patient
]);

/* 5. notification médecin (AVEC id_rdv) */
$conn->prepare("
INSERT INTO notification (id_user, id_rdv, message, is_read, created_at)
VALUES (?, ?, ?, 0, NOW())
")->execute([
    $rdv['id_medecin'],
    $id,
    $message_medecin
]);

/* 6. redirection */
header("Location: dashboardsecretaire.php");
exit();
?>