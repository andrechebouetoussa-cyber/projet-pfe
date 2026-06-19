<?php
include 'connexion.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if($id <= 0){
    die("ID invalide");
}

/* =======================
   RECUPERER MEDECIN
======================= */
$sql = "SELECT u.*, m.specialite
        FROM utilisateurs u
        JOIN medecin m ON m.id_user = u.id_user
        WHERE u.id_user = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$medecin = $stmt->fetch();

if(!$medecin){
    die("Médecin introuvable");
}

/* =======================
   UPDATE
======================= */
if(isset($_POST['update'])){

    // table utilisateurs
    $sql1 = "UPDATE utilisateurs 
             SET nom=?, prenom=?, email=?, telephone=?, adresse=? 
             WHERE id_user=?";

    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['telephone'],
        $_POST['adresse'],
        $id
    ]);

    // table medecin
    $sql2 = "UPDATE medecin SET specialite=? WHERE id_user=?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([
        $_POST['specialite'],
        $id
    ]);

    header("Location: medecins.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier médecin</title>
<link rel="stylesheet" href="style.css">
<style>
body{
    font-family:Arial;
    background:#f1f5f9;
    padding:30px;
}

form{
    max-width:500px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

input,select{
    width:100%;
    padding:10px;
    margin:8px 0;
}

button{
    width:100%;
    padding:10px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:8px;
}
</style>
</head>

<body>

<h2 style="text-align:center;">Modifier Médecin</h2>

<form method="POST">

    <input type="text" name="nom" value="<?= htmlspecialchars($medecin['nom']) ?>" required>
    <input type="text" name="prenom" value="<?= htmlspecialchars($medecin['prenom']) ?>" required>
    <input type="email" name="email" value="<?= htmlspecialchars($medecin['email']) ?>" required>
    <input type="text" name="telephone" value="<?= htmlspecialchars($medecin['telephone']) ?>" required>
    <input type="text" name="adresse" value="<?= htmlspecialchars($medecin['adresse']) ?>" required>

    <input type="text" name="specialite" value="<?= htmlspecialchars($medecin['specialite']) ?>" required>

    <button type="submit" name="update">Modifier</button>

</form>

</body>
</html>