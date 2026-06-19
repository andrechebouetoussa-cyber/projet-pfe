<?php
session_start();
include 'connexion.php';

$id = $_SESSION['user_id'];

$old = $_POST['old_password'];
$new = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

$sql = "SELECT password FROM utilisateurs WHERE id_user = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([':id'=>$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user && password_verify($old, $user['password'])){

    $sql2 = "UPDATE utilisateurs 
             SET password = :new 
             WHERE id_user = :id";

    $stmt2 = $conn->prepare($sql2);

    $stmt2->execute([
        ':new'=>$new,
        ':id'=>$id
    ]);

    header("Location: profile.php?success=1");

} else {
    echo "Ancien mot de passe incorrect";
}
?>