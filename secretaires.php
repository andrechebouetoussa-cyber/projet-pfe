<?php
session_start();
require_once "connexion.php";

/* 🔐 sécurité admin */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

/* 🔎 récupérer les secrétaires */
$stmt = $conn->prepare("
    SELECT id_user, nom, prenom, email, telephone, adresse
    FROM utilisateurs
    WHERE role = 'secretaire'
");

$stmt->execute();
$secretaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des secrétaires</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>👩‍💼 Liste des secrétaires</h1>

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
        <?php if(count($secretaires) > 0): ?>
            <?php foreach($secretaires as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['nom']) ?></td>
                    <td><?= htmlspecialchars($s['prenom']) ?></td>
                    <td><?= htmlspecialchars($s['email']) ?></td>
                    <td><?= htmlspecialchars($s['telephone']) ?></td>
                    <td><?= htmlspecialchars($s['adresse']) ?></td>

                    <td>
                        <a href="edit_secretaire.php?id=<?= $s['id_user'] ?>">✏️ Modifier</a> |
                        <a href="delete_secretaire.php?id=<?= $s['id_user'] ?>"
                           onclick="return confirm('Voulez-vous vraiment supprimer ?')">❌ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Aucun secrétaire trouvé</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<br>

<!-- 🔘 Boutons admin -->
<button onclick="window.location.href='dashboardadmin.php'">
    Retour dashboard
</button>

<button onclick="window.location.href='ajoutdoc.php'">
    + Ajouter Médecin
</button>

<button onclick="window.location.href='ajoutsec.php'">
    + Ajouter Secrétaire
</button>

</body>
</html>