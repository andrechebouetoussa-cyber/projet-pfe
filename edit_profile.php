<?php
session_start();
include 'connexion.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user_id'];

$sql = "
SELECT 
    utilisateurs.id_user, utilisateurs.nom,
    utilisateurs.prenom, utilisateurs.telephone,
    utilisateurs.adresse, utilisateurs.role,
    medecin.specialite
FROM utilisateurs
LEFT JOIN medecin 
ON utilisateurs.id_user = medecin.id_user
WHERE utilisateurs.id_user = :id
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier Profil</title>
<link rel="stylesheet" href="style.css">
<style>
body {
  display: flex;
  background: #f4f6f9;
}
.container{
    width:50%;
    margin:40px auto;
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
    background:#2563eb;
    color:white;
    border:none;
    border-radius:8px;
}
</style>
</head>

<body>

<div class="container">

<h2>Modifier Profil</h2>

<form action="update_profile.php" method="POST" enctype="multipart/form-data">

    <input type="text" name="nom" value="<?= $user['nom'] ?>" required>

    <input type="text" name="prenom" value="<?= $user['prenom'] ?>" required>

    <input type="text" name="telephone" value="<?= $user['telephone'] ?>" required>

    <input type="text" name="adresse" value="<?= $user['adresse'] ?>" required>

    <?php if($user['role'] == 'medecin'): ?>
        <input type="text" name="specialite" value="<?= $user['specialite'] ?>">
    <?php endif; ?>

    <input type="file" name="photo">

    <button type="submit">Enregistrer</button>

</form>

</div>

</body>
</html>
