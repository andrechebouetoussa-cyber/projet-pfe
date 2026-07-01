<?php
require_once "connexion.php";

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

/* 📊 STATISTIQUES */
$patients = $conn->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'patient'")->fetchColumn();

$secretaires = $conn->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'secretaire'")->fetchColumn();

$medecins = $conn->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'medecin'")->fetchColumn();

$rendezvous = $conn->query("SELECT COUNT(*) FROM rendez_vous")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Administrateurs</title>
<link rel="stylesheet" href="style.css">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

html, body{
    background:#f4f6f9;
    height:100%;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#1e293b;
    color:white;
    height:100vh;
    padding:20px;
    position:fixed;
    top:0;
    left:0;
    overflow-y:auto;
    transition:0.3s;
    z-index:1000;
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
    margin-left:260px;
    min-height:100vh;
}

/* TOPBAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 25px;
    background:white;
    border-bottom:1px solid #ddd;
}

/* USER */
.user{
    display:flex;
    align-items:center;
    gap:10px;
}

/* MENU BUTTON */
.menu-toggle{
    display:none;
    font-size:28px;
    background:none;
    border:none;
    cursor:pointer;
}

/* OVERLAY */
.overlay{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    z-index:900;
}

/* CONTENT */
.content{
    padding:25px;
}

/* STATS */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-top:20px;
}

.mini-card{
    background:white;
    padding:20px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* RESPONSIVE */
@media (max-width:768px){

    .menu-toggle{
        display:block;
    }

    .sidebar{
        transform:translateX(-100%);
    }

    .sidebar.active{
        transform:translateX(0);
    }

    .main{
        margin-left:0;
    }

    .overlay.active{
        display:block;
    }
}
</style>
</head>

<body>

<!-- OVERLAY -->
<div class="overlay" onclick="toggleMenu()"></div>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>Espace <br><span>Administrateurs</span></h2>

  <ul>
    <li class="active"><a href="dashboard.php">🏠 Mon Dashboard</a></li>
    <li><a href="patients.php">👤 Patients</a></li>   
    <li><a href="medecins.php">👤Médecins</a></li>
    <li><a href="secretaires.php">👤Sécrétaires</a></li>
    <li><a href="disponibilites.php">🟢 Disponibilités</a></li>
    <li><a href="services.php">🛠️Services</a></li>
    <li><a href="statistiques.php">📊Statistiques Globales</a></li>
    <li><a href="notification.php">🔔 Notifications</a></li>
    <li><a href="profil.php">👤 Mon profil</a></li>
    <li class="logout"><a href="logout.php">🚪 Déconnexion</a></li>
  </ul>
</div>

<!-- MAIN -->
<div class="main">

  <!-- TOPBAR -->
  <div class="topbar">

    <button class="menu-toggle" onclick="toggleMenu()">☰</button>

    <div class="user">
      👤
      <span><?= isset($_SESSION['email']) ? $_SESSION['email'] : 'Administrateur'; ?></span>
    </div>

  </div>

  <!-- CONTENT -->
  <div class="content">

  <h1><center>Clinique Guenin</center></h1>
  <h1>Bonjour 👋 <?= htmlspecialchars($_SESSION['nom']); ?></h1>
  <p>Gérez tout le système</p>

  <div class="stats-grid">

    <div class="mini-card">
      👨‍⚕️ <h3>Médecins</h3>
      <p><?= $medecins ?></p>
    </div>

    <div class="mini-card">
      🧑‍🤝‍🧑 <h3>Patients</h3>
      <p><?= $patients ?></p>
    </div>

    <div class="mini-card">
      👩‍💼 <h3>Secrétaires</h3>
      <p><?= $secretaires ?></p>
    </div>

    <div class="mini-card">
      📅 <h3>Rendez-vous</h3>
      <p><?= $rendezvous ?></p>
    </div>

  </div>

  </div>
</div>

<script>
function toggleMenu(){
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.overlay').classList.toggle('active');
}
</script>

</body>
</html>