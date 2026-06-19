<?php
session_start();
require_once "connexion.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* Bloquer l'accès à la secretaire,au patient et au medecin*/
if($_SESSION['role']  !== 'admin'){
    header("Location: login.php");
    exit();
}


/* 📊 STATISTIQUES */
$patients = $conn->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'patient'")->fetchColumn();

$secretaires = $conn->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'secretaire'")->fetchColumn();

$medecins = $conn->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'medecin'")->fetchColumn();

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
     
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    display:flex;
    background:#f4f6f9;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#1e293b;
    color:white;
    height:100vh;
    padding:20px;

    position: fixed;
    top: 0;
    left: 0;

    overflow-y: auto;
}


.sidebar h2{
    font-size:20px;
    margin-bottom:20px;
}

.sidebar span{
    color:#38bdf8;
}

.sidebar ul{
    list-style:none;
}

.sidebar li{
    padding:12px;
    margin:6px 0;
    border-radius:8px;
}

.sidebar li a{
    color:white;
    text-decoration:none;
    display:block;
}

.sidebar li:hover{
    background:#334155;
}

.sidebar .active{
    background:#38bdf8;
}

.logout{
    margin-top:20px;
}

/* MAIN */
.main{
    flex:1;
    margin-left:260px;
}


/* TOPBAR */
.topbar{
    position: sticky;
    top: 0;
    z-index: 100;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    padding:15px 25px;
    background:white;
    border-bottom:1px solid #ddd;
}



.cards{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

/* CARD STYLE */
.card{
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

/* HOVER EFFECT */
.card:hover{
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* TITRE */
.card h3{
    font-size: 16px;
    color: black;
    margin-bottom: 10px;
}

/* VALEUR */
.card p{
    font-size: 28px;
    font-weight: bold;
    color: #0f172a;
}

/* PETITE BARRE COLORÉE */
.card::before{
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #38bdf8, #6366f1);
}

/* COULEUR PAR CARD (optionnel) */
.card:nth-child(1)::before{
    background: linear-gradient(90deg, #38bdf8, #0ea5e9);
}

.card:nth-child(2)::before{
    background: linear-gradient(90deg, #38bdf8, #0ea5e9);
}

.card:nth-child(3)::before{
    background: linear-gradient(90deg, #38bdf8, #0ea5e9);
}

    </style>
</head>
<body>
    <!-- SIDEBAR -->
<div class="sidebar">
  <h2>Espace <br><span>Administrateurs</span></h2>

  <ul>
    <li class="active"><a href="dashboard.php">🏠 Mon Dashboard</a></li>
    <li><a href="patients.php">👤 Patients</a></li>   
    <li><a href="medecins.php">👤Médecins</a></li>
    <li><a href="secretaires.php">👤Sécrétaires</a></li>
     <li><a href="disponibilites.php">🟢 Disponibilités</a></li>
    <li>  <a href="services.php">🛠️Services</a></li>
    <li> <a href="statistiques.php">📊Statistiques Globales</a></li>
    <li><a href="notification.php">🔔 Notifications</a></li>
       <li><a href="profil.php">👤 Mon profil</a></li>
    <li class="logout"><a href="logout.php">🚪 Déconnexion</a></li>
  </ul>
</div>

<!-- MAIN -->
<div class="main">

  <!-- TOPBAR -->
  <div class="topbar">
    <div class="user">
      👤
      <span><?= isset($_SESSION['email']) ? $_SESSION['email'] : 'Administrateur'; ?></span>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="content">

  <h1><center> Clinique Atlas Care</center></h1>
  <h1>Bonjour 👋 <?php echo htmlspecialchars($_SESSION['nom']); ?></h1>
  <p>Gérez tout le système</p>

<h1>📊 Statistiques</h1>

<div class="cards">

    <div class="card">
        <h3>👥 patients</h3>
        <p><?= $patients ?></p>
    </div>

    <div class="card">
        <h3> 👥secretaires</h3>
        <p><?= $secretaires ?></p>
    </div>

    <div class="card">
        <h3> 👥medecins</h3>
        <p><?= $medecins ?></p>
    </div>

  

</div>



</body>
</html>