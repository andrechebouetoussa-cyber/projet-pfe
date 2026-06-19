<?php
include 'connexion.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if($id <= 0){
    die("ID invalide");
}

/* =======================
   SUPPRESSION medecin
======================= */

// supprimer d'abord table medecin
$sql1 = "DELETE FROM medecin WHERE id_user = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([$id]);

// supprimer utilisateur
$sql2 = "DELETE FROM utilisateurs WHERE id_user = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([$id]);

header("Location: medecins.php");
exit;
?>