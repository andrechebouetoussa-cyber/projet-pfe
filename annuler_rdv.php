<?php
include 'connexion.php';

$id = $_GET['id'];

$sql = "UPDATE rendez_vous SET statut = 'annule' WHERE id_rdv = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

header("Location: historique.php");
exit();
?>