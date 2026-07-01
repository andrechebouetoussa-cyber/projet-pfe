<?php
require_once "connexion.php";

$stmt = $conn->prepare("
SELECT utilisateurs.id_user, utilisateurs.nom, utilisateurs.prenom, utilisateurs.email, utilisateurs.telephone,
utilisateurs.adresse, medecin.specialite
FROM utilisateurs 
JOIN medecin  ON utilisateurs.id_user = medecin.id_user
WHERE utilisateurs.role = 'medecin'
");

$stmt->execute();
$medecin = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <img src="images/logo3.png" alt="Clinique Guenin" class="logo">
        <span class="logo-text">Clinique Guenin</span>
    </div>
</nav>
<h1>👨‍⚕️ Liste des médecins</h1>

<table border="1" cellpadding="10">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Email</th>
      <th>Téléphone</th>
      <th>Adresse</th>
      <th>Spécialité</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($medecin as $items): ?>
    <tr>
      <td><?= $items['nom'] ?></td>
      <td><?= $items['prenom'] ?></td>
      <td><?= $items['email'] ?></td>
      <td><?= $items['telephone'] ?></td>
      <td><?= $items['adresse'] ?></td>
      <td><?= $items['specialite'] ?></td>
<td>
    <a href="edit_medecins.php?id=<?= $items['id_user'] ?>" class="btn-edit">
        ✏️ Modifier
    </a>

    <a href="delete_medecins.php?id=<?= $items['id_user'] ?>" 
       class="btn-delete"
       onclick="return confirm('Voulez-vous vraiment supprimer ce médecin ?')">
        ❌ Supprimer
    </a>
</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>


      <button><a href="dashboardadmin.php" class="login-btn">Retournez au dashboard</a></button>
      <button class="btn" onclick="window.location.href='ajoutdoc'">+ Ajouter Médecin</button>
    <button class="btn green" onclick="window.location.href='ajoutsec'">+ Ajouter Secrétaire</button>
 
</body>
<script src="script.js"></script>
</html>