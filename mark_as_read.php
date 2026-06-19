<?php
session_start();
include 'connexion.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql = "UPDATE notifications SET is_read = 1 WHERE id = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header("Location: notifications.php");
exit();
?>