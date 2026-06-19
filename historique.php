<?php
session_start();
include 'connexion.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['user_id'];

$sql = "
SELECT 
    rendez_vous.id_rdv,
    rendez_vous.date_rdv,
    rendez_vous.heure_rdv,
    rendez_vous.statut,
    rendez_vous.motif,
    utilisateurs.nom AS medecin_nom,
    utilisateurs.prenom AS medecin_prenom
FROM rendez_vous

JOIN utilisateurs 
    ON rendez_vous.id_medecin = utilisateurs.id_user

WHERE rendez_vous.id_patient = :id
ORDER BY rendez_vous.date_rdv DESC, rendez_vous.heure_rdv DESC
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $patient_id, PDO::PARAM_INT);
$stmt->execute();

$rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historique</title>
<link rel="stylesheet" href="style.css">

<style>

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
.container{
    width:70%;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

/* card */
.card{
    background:#f8fafc;
    padding:15px;
    margin-bottom:10px;
    border-radius:10px;
    border-left:5px solid #2563eb;
}

/* statut */
.status{
    padding:5px 10px;
    border-radius:5px;
    font-size:12px;
    color:white;
}

.confirmé{
    background:#10b981;
}

.annulé{
    background:#ef4444;
}

.terminé{
    background:#6366f1;
}

.date{
    color:gray;
    font-size:13px;
}
</style>

</head>

<body>
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

<div class="container">

<h2>📋 Mon historique de rendez-vous</h2>

<?php if(empty($rdvs)): ?>

    <p style="text-align:center;">Aucun rendez-vous</p>

<?php else: ?>

    <?php foreach($rdvs as $r): ?>

       <div class="card">

    <p>
        👨‍⚕️ Dr <?= htmlspecialchars($r['medecin_prenom'] . " " . $r['medecin_nom']); ?>
    </p>

    <p class="date">
        📅 <?= htmlspecialchars($r['date_rdv']); ?> - 🕒 <?= htmlspecialchars($r['heure_rdv']); ?>
    </p>

    <p>
        📝 <?= htmlspecialchars($r['motif']); ?>
    </p>

    <span class="status <?= strtolower($r['statut']); ?>">
        <?= htmlspecialchars($r['statut']); ?>
    </span>

    <div style="margin-top:10px;">
        
        <!-- ANNULER -->
        <a href="annuler_rdv.php?id=<?= $r['id_rdv']; ?>" 
           onclick="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')"
           style="color:red; margin-right:10px;">
            ❌ Annuler
        </a>

        <!-- MODIFIER -->
        <a href="modifier_rdv.php?id=<?= $r['id_rdv']; ?>" 
           style="color:blue;">
            ✏️ Modifier
        </a>

    </div>

</div>
    <?php endforeach; ?>

<?php endif; ?>

</div>

</body>
</html>