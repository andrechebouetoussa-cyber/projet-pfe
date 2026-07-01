<?php
session_start();
require_once "connexion.php";

if(isset($_POST['ajouter'])){

    // Récupération des données
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $specialite = $_POST['specialite'];

    // Vérification champs vides
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) ||
     empty($telephone) || empty($adresse) || empty($specialite)) {
        die("❌ Tous les champs sont obligatoires");
    }

    // verifier si l Email valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Email invalide");
    }

    // Vérifier si l'email existe
    $stmt = $conn->prepare("SELECT id_user FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("❌ Email déjà utilisé");
    }

    // Hasher le password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn->beginTransaction();

        //  Insertiondans la table utilisateurs
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, password, telephone, adresse, role)
VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $hashed_password, $telephone, $adresse, 'medecin']);

        // Récupérer id_user
        $id_user = $conn->lastInsertId();

        // Insertion dans la table medecin
        $sql2 = "INSERT INTO medecin (id_user, specialite)
                 VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([$id_user, $specialite]);

    
        $conn->commit();
echo"insertion effectuée avec succès";
        header("Location: medecins.php");
        exit;

    } catch (Exception $e) {
        $conn->rollBack();
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


<h2><center>Remplir le formulaire afin d ajouter un medecin</center></h2>

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



  <select name="specialite" required>
  <option value="">-- Choisir une spécialité --</option>
  <option value="Cardiologie">Cardiologie</option>
  <option value="Dermatologie">Dermatologie</option>
  <option value="Pédiatrie">Pédiatrie</option>
  <option value="Dentisterie">Dentisterie</option>
  <option value="Neurologie">Neurologie</option>
  <option value="Pneumologie">Pneumologie</option>
  <option value="Médecin généraliste">Medecine Générale</option>
  <option value="gynecologie">Gynecologie</option>
  <option value="Chirurgie">Chirurgie</option>
  <option value="orthopedie">Orthopedie</option>
</select>

  <!-- ROLE caché -->
  <input type="hidden" name="role" value="medecin">

  <button type="submit" name="ajouter">Ajouter Médecin</button>
</form>












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