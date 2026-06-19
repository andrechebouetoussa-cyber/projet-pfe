<?php
session_start();
require_once "connexion.php";

if (isset($_POST['ajouter'])) {

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $telephone = trim($_POST['telephone']);
    $adresse = trim($_POST['adresse']);

    // Vérification champs
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($telephone) || empty($adresse)) {
        die("❌ Tous les champs sont obligatoires");
    }

    // Email valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Email invalide");
    }

    try {

        // Vérifier email existant
        $check = $conn->prepare("SELECT id_user FROM utilisateurs WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            die("❌ Email déjà utilisé");
        }

        $conn->beginTransaction();

        // 1. insertion utilisateur
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, password, telephone, adresse, role)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            $nom,
            $prenom,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $telephone,
            $adresse,
            'secretaire'
        ]);

        // 2. récupérer id_user
        $id_user = $conn->lastInsertId();

        // 3. insertion table secretaire
        $sql2 = "INSERT INTO secretaire (id_user) VALUES (?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([$id_user]);

        $conn->commit();

        header("Location: secretaires.php");
        exit();

    } catch (Exception $e) {

        $conn->rollBack();
        die("❌ Erreur : " . $e->getMessage());
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


<h2><center>Remplir le formulaire afin d ajouter un secretaire</center></h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
  Nom*
  <input type="text" name="nom" placeholder="Nom" required>
  Prénom*
  <input type="text" name="prenom" placeholder="Prénom" required>
  Email*
  <input type="email" name="email" placeholder="Email" required>
  Password*
       <div class="password-container">
       <input type="password" placeholder="mot de passe*" name="password" id="password" required>
        <span id="togglePassword">🙈</span>
      </div>
      Téléphone* 
  <input type="text" name="telephone" placeholder="Téléphone" required>
  Adresse*
  <input type="text" name="adresse" placeholder="Adresse" required>


  <!-- ROLE caché -->
  <input type="hidden" name="role" value="secretaire">

  <button type="submit" name="ajouter">Ajouter Secrétaire</button>
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










<script>
const password = document.getElementById("password");
const toggle = document.getElementById("togglePassword");

toggle.addEventListener("click", function() {
  if (password.type === "password") {
    password.type = "text";
    toggle.textContent = "👁️";
  } else {
    password.type = "password";
    toggle.textContent = "🙈";
  }
});
</script>
<script src="script.js"></script>
</body>
</html>