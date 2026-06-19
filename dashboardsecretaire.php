<?php
require_once"connexion.php";


session_start();
if(!isset($_SESSION["user_id"])){
  header("Location: login.php");
  exit;
}

/* 📊 STATISTIQUES */
$patients = $conn->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'patient'")->fetchColumn();
$rendezvous = $conn->query("SELECT COUNT(*) FROM rendez_vous WHERE date_rdv = CURDATE()")->fetchColumn();

$notifications = $conn->query("SELECT COUNT(*) FROM notification WHERE is_read = 0")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Sécrétaire</title>
<link rel="stylesheet" href="style.css">

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Arial', sans-serif;
}

body {
  display: flex;
  background: #f4f6f9;
}

/* SIDEBAR */
.sidebar {
  width: 260px;
  background: #1e293b;
  color: white;
  height: 100vh;
  padding: 20px;
}

.sidebar h2 {
  font-size: 20px;
  margin-bottom: 20px;
}

.sidebar span {
  color: #38bdf8;
}

.sidebar ul {
  list-style: none;
}

.sidebar li {
  padding: 12px;
  margin: 6px 0;
  border-radius: 8px;
  transition: 0.3s;
  cursor: pointer;
}

.sidebar li a {
  color: white;
  text-decoration: none;
  display: block;
}

.sidebar li:hover {
  background: #334155;
}

.sidebar .active {
  background: #38bdf8;
  color: #000;
}

.logout {
  margin-top: 20px;
  color: #f87171;
}

/* MAIN */
.main {
  flex: 1;
}

/* TOPBAR */
.topbar {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 15px 25px;
  background: white;
  border-bottom: 1px solid #ddd;
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
}

/* CONTENT */
.content {
  padding: 25px;
}

.content h1 {
  margin-bottom: 10px;
}

/* CARDS */
.cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

/* GRID STATS */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

/* MINI CARDS (stats) */
.mini-card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  text-align: center;
  transition: 0.3s;
}

.mini-card:hover {
  transform: translateY(-5px);
}

.mini-card h3 {
  margin-top: 10px;
  font-size: 16px;
  color: #0a7c6d;
}

.mini-card p {
  font-size: 22px;
  font-weight: bold;
  margin-top: 5px;
  color: black;
}


/* ACTION CARD */
.actions-card {
  margin-top: 30px;
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.actions-card h3 {
  margin-bottom: 15px;
  color: #0a7c6d;
}

/* BUTTONS */
.btn {
  padding: 10px 15px;
  border: none;
  border-radius: 8px;
  background:  #0a7c6d;
  color: white;
  margin-right: 10px;
  cursor: pointer;
}

.btn.green {
  background: #0a7c6d;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>Espace <br><span>Sécrétaire</span></h2>

  <ul>
    <li class="active"><a href="dashboard.php">🏠 Mon Dashboard</a></li>
    <li><a href="patients.php">👤 Patients</a></li> 
        <li><a href="RDV.php">🏠 nouveau rendez-vous</a></li>     
          <li><a href="rdv_confirme.php">🏠 historique des rendez-vous</a></li>    
    <li>  <a href="planning.php">🟢Planning</a></li>
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
      <span><?= isset($_SESSION['email']) ? $_SESSION['email'] : 'Sécrétaire'; ?></span>
    </div>
</div>


  <!-- CONTENT -->
  <div class="content">
    <h1><center> Clinique Atlas Care</center></h1>
  <h1>Bonjour 👋<?php echo htmlspecialchars($_SESSION['nom']); ?></h1>
  <p>voir vos notifications</p>

  <!-- GRID STATS -->
  <div class="stats-grid">

    <div class="mini-card">
      <h3>Rendez-vous du jour:</h3>
      <p><?= $rendezvous ?></p>
    </div>

    <div class="mini-card">
      <h3>Patients </h3>
      <p><?= $patients ?></p>
    </div>

    <div class="mini-card">
       <h3>Notifications</h3>
      <p><?= $notifications ?></p>
    </div>

  </div>

   <!-- ACTIONS -->
  <div class="actions-card">
    <h3>Ajouter un patient ✔️</h3>

    <button class="btn">+ Ajouter un patient</button>
  </div>
</div>
    </div>
  </div>
</div>

</body>
</html>
