<?php
include 'connexion.php';

$id = $_GET['id'];

$sql = "UPDATE rendez_vous 
        SET statut = 'refuse' 
        WHERE id_rdv = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

/* notif */
$sql2 = "SELECT patient_id FROM rendez_vous WHERE id_rdv = :id";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([':id'=>$id]);

$rdv = $stmt2->fetch(PDO::FETCH_ASSOC);

$sql3 = "INSERT INTO notifications (user_id, message)
         VALUES (:id, 'Votre rendez-vous a été refusé')";

$stmt3 = $conn->prepare($sql3);
$stmt3->execute([':id'=>$rdv['patient_id']]);

header("Location: planning.php");
exit();
?>