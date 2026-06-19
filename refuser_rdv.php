<?php
include 'connexion.php';

$id = $_GET['id'];

$conn->prepare("
UPDATE rendez_vous 
SET statut = 'annule'
WHERE id_rdv = ?
")->execute([$id]);

header("Location: dashboardsecretaire.php");
exit();
?>