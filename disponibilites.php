<?php
session_start();
include 'connexion.php';



if(isset($_POST['ajouter'])){

    $sql = "INSERT INTO disponibilite
    (id_medecin, jour, heure_debut, heure_fin)
    VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $_POST['id_medecin'],
        $_POST['jour'],
        $_POST['heure_debut'],
        $_POST['heure_fin']
    ]);

    echo "<p style='color:green;'>Disponibilité ajoutée 👍</p>";
}



$sql = "SELECT d.*, u.nom, u.prenom, m.specialite
        FROM disponibilite d
        JOIN medecin m ON m.id_user = d.id_medecin
        JOIN utilisateurs u ON u.id_user = m.id_user
        ORDER BY m.specialite, d.id_disponibilite DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$dispos = $stmt->fetchAll();

$grouped = [];

foreach($dispos as $d){
    $grouped[$d['specialite']][] = $d;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion disponibilités</title>
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



/* CONTENT */
.content {
    padding: 30px;
}

h1,h2 {
    text-align:center;
    color:#0a7c6d;
}

/* ================= TABLE ================= */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

thead {
    background: #0a7c6d;
    color: white;
}

th, td {
    padding: 12px;
}

tr:hover {
    background: #f1f5f9;
}

/* ================= CARDS ================= */
h3 {
    margin-top: 30px;
    color:#0a7c6d;
}

/* ================= FORM ================= */
form {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    max-width: 600px;
    margin: 30px auto;
}

label {
    font-weight: 600;
    display:block;
    margin-top:10px;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-top:5px;
    border:1px solid #cbd5e1;
    border-radius: 8px;
    outline:none;
}

input:focus, select:focus {
    border-color:#2563eb;
}

/* BUTTON */
button {
    margin-top: 15px;
    width: 100%;
    background: #0a7c6d;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background: #0a7c6d;
}
.specialite-title {
    display: flex;
    justify-content: center;
    margin: 35px 0 15px;
}

.specialite-title span {
    background: #dbeafe;
    color: #1d4ed8;
    padding: 8px 18px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
}
/* ================= RESPONSIVE ================= */
@media(max-width: 768px){
    .sidebar{
        display:none;
    }

    .main{
        margin-left:0;
        width:100%;
    }
}

</style>

</head>

<body>

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
      <span>email@gmail.com</span>
    </div>
  </div>

<div class="content">
<div class="container">

<h1>Gestion des disponibilités</h1>

<!-- ================= LISTE ================= -->
<h2>Disponibilités existantes</h2>

<?php foreach($grouped as $specialite => $items){ ?>

<div class="specialite-title">

    <h3 style="margin-top:30px; color:#0a7c6d;">

        <?= htmlspecialchars($specialite) ?>
    </h3>
</div>
    <table style="width:100%; border-collapse: collapse; background:white; border-radius:10px; overflow:hidden; margin-bottom:20px;">

        <thead style="background:#0a7c6d; color:white;">
            <tr>
                <th style="padding:12px;">Médecin</th>
                <th>Jour</th>
                <th>Heure début</th>
                <th>Heure fin</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach($items as $d){ ?>

            <tr style="text-align:center; border-bottom:1px solid #ddd;">

                <td style="padding:10px;">
                    Dr <?= htmlspecialchars($d['nom']) ?> <?= htmlspecialchars($d['prenom']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($d['jour']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($d['heure_debut']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($d['heure_fin']) ?>
                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>

<?php } ?>

<!-- ================= AJOUT ================= -->

<h2>Ajouter disponibilité</h2>

<form method="POST">

    <label>Médecin :</label>
    <select name="id_medecin" required>

        <?php foreach($medecins as $m){ ?>

            <option value="<?= $m['id_user'] ?>">
                Dr <?= $m['nom'] ?> <?= $m['prenom'] ?>
                (<?= $m['specialite'] ?>)
            </option>

        <?php } ?>

    </select>

    <label>Jour :</label>
    <select name="jour" required>
        <option>Lundi</option>
        <option>Mardi</option>
        <option>Mercredi</option>
        <option>Jeudi</option>
        <option>Vendredi</option>
    </select>

    <label>Heure début :</label>
    <input type="time" name="heure_debut" required>

    <label>Heure fin :</label>
    <input type="time" name="heure_fin" required>

    <button type="submit" name="ajouter">
        Ajouter disponibilité
    </button>

</form>

</div>


</div>
</body>
</html>