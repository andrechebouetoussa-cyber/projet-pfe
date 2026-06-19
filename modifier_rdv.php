<?php
include 'connexion.php';


$id = $_GET['id'];


if(isset($_POST['update'])){

    $stmt = $conn->prepare("
        UPDATE rendez_vous 
        SET date_rdv = ?, heure_rdv = ?, motif = ?
        WHERE id_rdv = ? AND id_patient = ?
    ");

    $stmt->execute([
        $_POST['date_rdv'],
        $_POST['heure_rdv'],
        $_POST['motif'],
        $id,
        $_SESSION['user_id']
    ]);

    header("Location: historique.php");
    exit();
}

$sql = "SELECT * FROM rendez_vous WHERE id_rdv = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$rdv = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier RDV</title>
<link rel="stylesheet" href="style.css">
<style>
body{
    font-family:Arial;
    background:#f1f5f9;
}

.container{
    width:40%;
    margin:50px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

input, textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    background:#2563eb;
    color:white;
    padding:10px 15px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}
</style>

</head>

<body>

<div class="container">

<h2>✏️ Modifier votre rendez-vous</h2>

<form action="<?= $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST">

    <label>Date :</label>
    <input type="date" name="date_rdv" value="<?= $rdv['date_rdv']; ?>" required>

    <label>Heure :</label>
    <input type="time" name="heure_rdv" value="<?= $rdv['heure_rdv']; ?>" required>

    <label>Motif :</label>
    <textarea name="motif" required><?= $rdv['motif']; ?></textarea>

    <button type="submit" name="update">Modifier</button>

</form>

</div>

</body>
</html>