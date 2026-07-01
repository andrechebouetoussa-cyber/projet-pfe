
<?php
require_once"connexion.php";


session_start();
if(!isset($_SESSION["user_id"])){
  header("Location: login.php");
  exit;
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Stagiaires</title>
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

.card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  transition: 0.3s;
}

.card:hover {
  transform: translateY(-5px);
}

.card .icon {
  font-size: 30px;
  margin-bottom: 10px;
}

.card h3 {
  margin-bottom: 10px;
}

.card p {
  font-size: 14px;
  color: #555;
  margin-bottom: 15px;
}

.btn {
  display: inline-block;
  padding: 10px 15px;
  background: #38bdf8;
  color: white;
  border-radius: 8px;
  text-decoration: none;
}

.btn.green {
  background: #22c55e;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>Espace <br><span>Patients</span></h2>

  <ul>
    <li class="active"><a href="dashboard.php">🏠 Mon Tableau de Bord</a></li>
    <li><a href="historique.php">📁 Historique</a></li>
    <li><a href="reservations.php">🏥 Cliniques et Rendez-vous</a></li>
    <li><a href="profil.php">👤 Mon profil</a></li>
    <li><a href="notification.php">🔔 Notifications</a></li>
    <li class="logout"><a href="logout.php">🚪 Déconnexion</a></li>
  </ul>
</div>

<!-- MAIN -->
<div class="main">

  <!-- TOPBAR -->
  <div class="topbar">
    <div class="user">
      👤
      <span>email@gmail.com</span>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="content">
    <h1><center> Clinique Guenin</center></h1>
    <h1>Bonjour 👋 <?php echo htmlspecialchars($_SESSION['nom']); ?></h1>
    <p>Effectuez vos actions en toute sécurité</p>

    <div class="cards-container">

      <div class="card">
        <div class="icon">🏥</div>
         <h3>Clinique Guenin</h3>
        <p>Explorez notre clinique , la santé, au coeur de l innovation</p>
        <a href="Rendez-vous.php" class="btn">Prendre rendez-vous</a>
        <a href="index.php" class="btn">voir plus</a>

              
  
      </div>


    
    </div>

  </div>
</div>

</body>
</html>