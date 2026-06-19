<?php
session_start();
include 'connexion.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Changer mot de passe</title>
<link rel="stylesheet" href="style.css">
<style>
body {
  display: flex;
  background: #f4f6f9;
}



.container{
    width:40%;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:12px;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
}

button{
    width:100%;
    padding:12px;
    background:#ef4444;
    color:white;
    border:none;
    border-radius:8px;
}
</style>
</head>

<body>

<div class="container">

<h2>Changer mot de passe</h2>

<form action="update_password.php" method="POST">

    <input type="password" name="old_password" placeholder="Ancien mot de passe" required>

    <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>

    <button type="submit">Modifier</button>

</form>

</div>

</body>
</html>