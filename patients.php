<?php
session_start();
require_once "connexion.php";

/* 1. utilisateur connecté */
if (!isset($_SESSION['user_id'])) {
    die("Non connecté");
}

$user_id = $_SESSION['user_id'];

/* récupérer le rôle correctement */
$stmtUser = $conn->prepare("
    SELECT role 
    FROM utilisateurs 
    WHERE id_user = :id
");
$stmtUser->execute([':id' => $user_id]);

$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable");
}

$user_role = $user['role'];

/* ADMIN + SECRETAIRE => tous les patients */
if ($user_role == 'admin' || $user_role == 'secretaire') {

    $stmt = $conn->prepare("
        SELECT 
            id_user,
            nom,
            prenom,
            email,
            telephone,
            adresse
        FROM utilisateurs
        WHERE role = 'patient'
    ");

    $stmt->execute();

/* MEDECIN => seulement ses patients via rendez-vous */
} elseif ($user_role == 'medecin') {

    $stmt = $conn->prepare("
        SELECT DISTINCT
            u.id_user,
            u.nom,
            u.prenom,
            u.email,
            u.telephone,
            u.adresse
        FROM utilisateurs u
        JOIN rendez_vous r ON r.id_patient = u.id_user
        WHERE u.role = 'patient'
        AND r.id_medecin = :medecin_id
    ");

    $stmt->execute([
        ':medecin_id' => $user_id
    ]);

} else {
    die("Accès refusé");
}

$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* dashboard */
if ($user_role == 'medecin') {
    $dashboard = "dashboardmedecin.php";
} elseif ($user_role == 'secretaire') {
    $dashboard = "dashboardsecretaire.php";
} else {
    $dashboard = "dashboardadmin.php";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <nav class="navbar">
    <div class="logo-container">
        <img src="images/logo.png" alt="Clinique Atlas Care" class="logo">
        <span class="logo-text">Clinique Atlas Care</span>
    </div>
</nav>
    <h1>👤 Liste des patients</h1>

<table border="1" cellpadding="10">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Email</th>
      <th>Téléphone</th>
      <th>Adresse</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($patients as $ligne): ?>
    <tr>
      <td><?= $ligne['nom'] ?></td>
      <td><?= $ligne['prenom'] ?></td>
      <td><?= $ligne['email'] ?></td>
      <td><?= $ligne['telephone'] ?></td>
      <td><?= $ligne['adresse'] ?></td>

      <td>
        <a href="edit_patients.php?id=<?= $ligne['id_user'] ?>" name="mod">Modifier</a>
        <a href="delete_patients.php?id=<?= $ligne['id_user'] ?>" onclick="return confirm('Supprimer ?')" name="supp">Supprimer</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a class="btn" href="<?= $dashboard; ?>">Retour au dashboard</a>

</body>
<script src="script.js"></script>
</html>