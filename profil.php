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
    utilisateurs.prenom,  utilisateurs.email,
    utilisateurs.telephone, utilisateurs.adresse,
    utilisateurs.role, medecin.specialite
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



if($user['role'] == 'patient'){
    $dashboard = "dashboardpatient.php";
}
elseif($user['role'] == 'medecin'){
    $dashboard = "dashboardmedecin.php";
}
elseif($user['role'] == 'secretaire'){
    $dashboard = "dashboardsecretaire.php";
}
else{
    $dashboard = "dashboardadmin.php";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon Profil</title>
<link rel="stylesheet" href="style.css">
<style>
    .avatar{
    text-align:center;
    margin-bottom:15px;
}

.avatar img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #2563eb;
}

/* boutons */
.actions{
    margin-top:20px;
    display:flex;
    justify-content:center;
    gap:15px;
}

.btn{
    padding:10px 15px;
    background: #0a7c6d;
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
}

.btn:hover{
    background:#08695c;
}


h1{
    text-align:center;
    color: #0a7c6d;
}

.box{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-top:20px;
}

.item{
    background:#f8fafc;
    padding:15px;
    border-radius:10px;
}

.item b{
    color: #0a7c6d;
}

.btn{
    margin-top:20px;
    display:inline-block;
    padding:10px 15px;
    background:#0a7c6d;
    color:white;
    text-decoration:none;
    border-radius:8px;
}

</style>
</head>
<body>

<nav class="navbar">
    <div class="logo-container">
        <img src="images/logo.png" alt="Clinique Atlas Care" class="logo">
        <span class="logo-text">Clinique Atlas Care</span>
    </div>
</nav>
<div class="container">

<div class="avatar">
    <img src="uploads/<?= $user['photo'] ?? 'default.png' ?>" alt="Avatar">
</div>

<!-- 4. TITRE -->
<h1>Mon Profil </h1>

<!-- 5. INFOS COMMUNES -->
<div class="box">

    <div class="item">
        <b>Nom :</b> <?= $user['nom']; ?>
    </div>

    <div class="item">
        <b>Prénom :</b> <?= $user['prenom']; ?>
    </div>

    <div class="item">
        <b>Email :</b> <?= $user['email']; ?>
    </div>

    <div class="item">
        <b>Téléphone :</b> <?= $user['telephone']; ?>
    </div>

    <div class="item">
        <b>Adresse :</b> <?= $user['adresse']; ?>
    </div>

    <?php if($user['role'] != 'patient'): ?>

    <div class="item">
        <b>Spécialité :</b> <?= $user['specialite']; ?>
    </div>

    <?php endif; ?>

</div>

<a class="btn" href="edit_profile.php">Modifier Profil</a>
<a class="btn" href="change_password.php">Changer mot de passe</a>
<a class="btn" href="<?= $dashboard; ?>">Retour au dashboard</a>
</div>

</body>
<script src="script.js"></script>
</html>