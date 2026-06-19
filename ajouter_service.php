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
        <img src="images/logo.png" alt="Clinique Atlas Care" class="logo">
        <span class="logo-text">Clinique Atlas Care</span>
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


<footer class="footer">
  <div class="footer-container">

    <div class="footer-section">
      <h2>Clinique Atlas Care</h2>
      <p>
        Découvrez un établissement médical où les besoins et le bien-être des patients sont prioritaires, sous la supervision d'une équipe de médecins qualifiés et expérimentés.
      </p>
    </div>

    <div class="footer-section">
      <h3>Liens rapides</h3>
      <ul>
        <li><a href="#">Accueil</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Rendez-vous</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h3>Contact</h3>
      <p>📍 Meknès, Maroc</p>
      <p>📞 <a href="tel:+212707237182">+212 707 237 182</a></p>
      <p>📧 <a href="mailto:andrechebouetoussa@gmail.com">andrechebouetoussa@gmail.com</a></p>
    </div>

    <div class="footer-section">
      <h3>Newsletter</h3>
      <p>Inscrivez-vous pour recevoir nos conseils et actualités.</p>

      <form>
        <input type="email" placeholder="Entrez votre email" required>
        <button type="submit">S'inscrire</button>
      </form>
    </div>

  </div>

  <div class="footer-bottom">
    <p>© 2026 Clinique Atlas Care | Tous droits réservés</p>
  </div>
</footer>







</body>
</html>