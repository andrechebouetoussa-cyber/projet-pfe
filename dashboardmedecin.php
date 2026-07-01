<?php
require_once "connexion.php";
session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}

/* 📊 STATISTIQUES */
$patients = $conn->query("
    SELECT COUNT(*) 
    FROM utilisateurs 
    WHERE role = 'patient'
")->fetchColumn();

/* RDV aujourd’hui */
$rendezvous = $conn->query("
    SELECT COUNT(*) 
    FROM rendez_vous 
    WHERE date_rdv = CURDATE()
")->fetchColumn();

/* 🔥 PROCHAIN RENDEZ-VOUS (le plus proche aujourd’hui) */
$prochainRdv = $conn->query("
    SELECT heure_rdv
    FROM rendez_vous
    WHERE date_rdv = CURDATE()
    AND heure_rdv >= CURTIME()
    ORDER BY heure_rdv ASC
    LIMIT 1
")->fetchColumn();

/* 👨‍⚕️ PATIENTS CONSULTÉS AUJOURD’HUI */
$patientsConsultes = $conn->query("
    SELECT COUNT(*)
    FROM consultation c
    JOIN rendez_vous r ON c.id_rdv = r.id_rdv
    WHERE r.date_rdv = CURDATE()
    AND c.statut = 'consulte'
")->fetchColumn();

/* 🔔 NOTIFICATIONS */
$notifications = $conn->query("
    SELECT COUNT(*) 
    FROM notification 
    WHERE is_read = 0
")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Médecin</title>

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

.user {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}/* STATS */
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
  box-shadow:0 5px 15px rgba(0,0,0,0.08);
  text-align:center;
}

.mini-card h3{
  font-size:14px;
  color:#64748b;
}

.mini-card p{
  font-size:22px;
  font-weight:bold;
  margin-top:10px;
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Espace <br><span>Medecin</span></h2>
  <ul>
    <li><a href="dashboard.php">🏠 Dashboard</a></li>
    <li><a href="RDV1.php">📅 Rendez-vous</a></li>
    <li><a href="patients.php">👤 Patients</a></li>
    <li><a href="notification.php">🔔 Notifications</a></li>
    <li><a href="logout.php">🚪 Déconnexion</a></li>
  </ul>
</div>

<!-- MAIN -->
<div class="main">

  <div class="topbar">
    👤 <?= htmlspecialchars($_SESSION['nom'] ?? 'Médecin') ?>
  </div>

 
 <!-- CONTENT -->
  <div class="content">
    <h1><center> Clinique Guenin</center></h1>
    <h1>Bonjour 👋 <?php echo htmlspecialchars($_SESSION['nom']); ?></h1>
    <p>Effectuez vos actions en toute sécurité</p>

  <div class="stats-grid">

    <!-- RDV aujourd’hui -->
    <div class="mini-card">
      <h3>Rendez-vous aujourd’hui</h3>
      <p><?= $rendezvous ?></p>
    </div>

    <!-- PROCHAIN RDV -->
    <div class="mini-card">
      <h3>Prochain rendez-vous</h3>
      <p>
        <?= $prochainRdv ? $prochainRdv : "Aucun RDV" ?>
      </p>
    </div>

    <!-- PATIENTS CONSULTÉS -->
    <div class="mini-card">
      <h3>Patients consultés</h3>
      <p><?= $patientsConsultes ?></p>
    </div>

    <!-- NOTIFICATIONS -->
    <div class="mini-card">
      <h3>Notifications</h3>
      <p><?= $notifications ?></p>
    </div>

  </div>

</div>

</body>
</html>