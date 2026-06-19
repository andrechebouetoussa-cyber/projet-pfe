<?php
include 'connexion.php';

$id = $_GET['id'];

/* 1. update statut */
$sql = "UPDATE rendez_vous 
        SET statut = 'confirme' 
        WHERE id_rdv = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

/* 2. récupérer patient */
$sql2 = "SELECT id_patient FROM rendez_vous WHERE id_rdv = :id";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([':id'=>$id]);

$rdv = $stmt2->fetch(PDO::FETCH_ASSOC);

/* 3. notification */
$sql3 = "INSERT INTO notifications (user_id, message)
         VALUES (:id, 'Votre rendez-vous a été confirmé')";

$stmt3 = $conn->prepare($sql3);
$stmt3->execute([':id'=>$rdv['id_patient']]);

header("Location: planning.php");
exit();
?>