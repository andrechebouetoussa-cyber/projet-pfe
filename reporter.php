<?php
include 'connexion.php';

$id = $_GET['id'];

$sql = "UPDATE rendez_vous 
        SET statut = 'reporte' 
        WHERE id_rdv = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([':id'=>$id]);

header("Location: planning.php");
exit();
?>