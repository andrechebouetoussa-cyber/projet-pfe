<?php
session_start();
require_once "connexion.php";



/* 🔎 Récupération des services */
$stmt = $conn->prepare("
    SELECT id_service, nom_service, description
    FROM service
    ORDER BY nom_service
");

$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des Services</title>
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


.content{
    padding:25px;
}

.content h1{
    margin-bottom:10px;
}

/* SERVICES */
.services-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    padding:20px;
}

.service-card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.service-card h2{
    margin-bottom:10px;
    color:#1e293b;
}

.service-card p{
    color:#555;
}

/* ACTIONS RAPIDES */
.quick-actions{
    padding:20px;
}

.action-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.action-card{
    display:block;
    text-decoration:none;
    background:#38bdf8;
    color:white;
    padding:20px;
    border-radius:12px;
    transition:0.3s;
}

.action-card:hover{
    transform:translateY(-3px);
}

.action-card h3{
    margin-bottom:10px;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>Espace <br><span>Administrateur</span></h2>

    <ul>
        <li><a href="dashboard.php">🏠 Mon Dashboard</a></li>
        <li><a href="patients.php">👤 Patients</a></li>
        <li><a href="medecins.php">👨‍⚕️ Médecins</a></li>
        <li><a href="secretaires.php">👩‍💼 Secrétaires</a></li>
        <li><a href="disponibilites.php">🟢 Disponibilités</a></li>
        <li class="active"><a href="services.php">🛠️ Services</a></li>
        <li><a href="statistiques.php">📊 Statistiques Globales</a></li>
        <li><a href="notification.php">🔔 Notifications</a></li>
        <li><a href="profil.php">👤 Mon Profil</a></li>
        <li class="logout"><a href="logout.php">🚪 Déconnexion</a></li>
    </ul>

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        👤 <?= htmlspecialchars($_SESSION['email'] ?? 'Administrateur'); ?>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <h1 style="text-align:center;">Clinique Atlas Care</h1>

        <h2>
            Bonjour 👋
            <?= htmlspecialchars($_SESSION['nom'] ?? 'Administrateur'); ?>
        </h2>

        <p>Gérez les services médicaux de la clinique.</p>

    </div>

    <div style="padding:20px;">
        <h1>🛠️ Nos Services Médicaux</h1>
    </div>

    <!-- SERVICES -->
    <div class="services-container">

        <?php if(count($services) > 0): ?>

            <?php foreach($services as $service): ?>

                <div class="service-card">

                    <h2>
                        <?= htmlspecialchars($service['nom_service']); ?>
                    </h2>

                    <p>
                        <?= htmlspecialchars($service['description']); ?>
                    </p>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="service-card">
                <h2>Aucun service</h2>
                <p>Aucun service n'est enregistré pour le moment.</p>
            </div>

        <?php endif; ?>

    </div>

    <!-- ACTIONS RAPIDES -->
    <div class="quick-actions">

        <h2>⚡ Actions Rapides</h2>

        <div class="action-grid">

            <a href="ajouter_service.php" class="action-card">
                <h3>➕ Ajouter un service</h3>
                <p>Créer un nouveau service médical</p>
            </a>

        </div>

    </div>

</div>

</body>
</html>