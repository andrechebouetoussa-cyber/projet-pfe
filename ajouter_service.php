<?php
session_start();
require_once "connexion.php";

if (isset($_POST['ajouter'])) {

    $nom_service = trim($_POST['nom_service']);
    $description = trim($_POST['description']);

    if (empty($nom_service) || empty($description)) {
        die("❌ Tous les champs sont obligatoires");
    }

    try {

        $sql = "INSERT INTO service (nom_service, description)
                VALUES (?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            $nom_service,
            $description
        ]);

        header("Location: services.php");
        exit();

    } catch (PDOException $e) {

        echo "❌ Erreur d'insertion : " . $e->getMessage();

    }
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
        <img src="images/logo3.png" alt="Clinique Guenin" class="logo">
        <span class="logo-text">Clinique Guenin</span>
    </div>
</nav>


<h2><center>Remplir le formulaire afin d ajouter un service</center></h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
  Nom*
  <input type="text" name="nom_service" placeholder="Nom" required>
  descripion*

<textarea
    name="description"
    rows="4"
    placeholder="Description du service"
    required>
</textarea>
 



  <button type="submit" name="ajouter">Ajouter service</button>
</form>






</body>
</html>