<?php
ob_start();
session_start();
require_once "connexion.php";

if (isset($_POST['inscrire'])) {

  $nom = trim($_POST['nom']);
  $prenom = trim($_POST['prenom']);
  $email = trim($_POST['email']);
  $telephone = trim($_POST['telephone']);
   $adresse = trim($_POST['adresse']);
  $password = trim($_POST['password']);
  $conf_password = trim($_POST['conf_password']);

  // Vérification les champs si vides
  if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($adresse)|| empty($password) || empty($conf_password)) {
    echo "❌ Veuillez remplir tous les champs.";
    exit;
  }

  // Email valide
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "❌ Email invalide.";
    exit;
  }

  // Vérifier email existant
  $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
  $stmt->execute([$email]);

  if ($stmt->rowCount() > 0) {
    echo "❌ Cet email existe déjà.";
    exit;
  }

  // Mots de passe identiques
  if ($password !== $conf_password) {
    echo "❌ password non identiques.";
    exit;
  }

  // Hasher le password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

$result= $stmt = $conn->prepare("
INSERT INTO utilisateurs (nom, prenom, email, telephone, password, adresse, role)
VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([$nom,$prenom,$email,$telephone,$hashed_password,$adresse,'patient'
]);
  // Vérification insertion
  if ($result) {
    ob_end_clean();
    header("Location: login.php");
    exit;
  } else {
    echo "❌ Erreur lors de l'inscription. Erreur: " . json_encode($stmt->errorInfo());
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
    <style>/* ===== Style général ===== */

/* ===== Boite du formulaire ===== */
.login-box{
    width: 400px;
    background: white;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.login-box h2{
    text-align: center;
    color:  #0a7c6d;
    margin-bottom: 10px;
    font-size: 30px;
}

.login-box h3{
    text-align: center;
    color:  #0a7c6d;
    margin-bottom: 25px;
    font-size: 16px;
    font-weight: normal;
}

/* ===== Formulaire ===== */
form{
    display: flex;
    flex-direction: column;
}

form label{
    margin-bottom: 5px;
    color: #333;
    font-weight: bold;
}

form input{
    width: 100%;
    padding: 14px;
    margin-top: 5px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 10px;
    outline: none;
    font-size: 15px;
    transition: 0.3s;
}

form input:focus{
    border-color:  #0a7c6d;
    box-shadow: 0 0 8px rgba(79,70,229,0.3);
}

/* ===== Password ===== */
.password-container{
    position: relative;
    width: 100%;
}

.password-container input{
    padding-right: 45px;
}

.password-container span{
    position: absolute;
    right: 15px;
    top: 35%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 18px;
}

/* ===== Boutons ===== */
button{
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: #0a7c6d;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
}

button:hover{
    background:  #0a7c6d;
    transform: scale(1.02);
}

/* ===== Texte ===== */
p{
    text-align: center;
    margin-top: 18px;
    color:black;
}

/* ===== Lien ===== */
a{
    text-align: center;
    margin-top: 18px;
    text-decoration: none;
    color:black;
    font-weight: bold;
    transition: 0.3s;
}

a:hover{
    color: #0a7c6d;
}

/* ===== Responsive ===== */
@media(max-width: 450px){
    .login-box{
        width: 90%;
        padding: 25px;
    }
}

    /* =========================
   PROGRESS BAR
========================= */

.progress-container{
    width:100%;
    display:flex !important;
    flex-direction:row !important;
    align-items:center !important;
    justify-content:center !important;
    margin:30px 0;
}

/* ETAPES */

.progress-step{
    display:flex !important;
    flex-direction:column !important;
    align-items:center !important;
}

/* CERCLES */

.progress-step span{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;

    min-width:45px;
    width:45px;
    height:45px;

    border-radius:50%;

    background:#dcdcdc;
    color:#555;

    font-size:18px;
    font-weight:bold;

    line-height:45px;

    flex-shrink:0;
}

/* TEXTES */

.progress-step p{
    margin-top:8px;
    font-size:13px;
    color:#777;
    text-align:center;
}

/* LIGNES */

.progress-line{
    width:80px;
    height:4px;
    background:#dcdcdc;
    margin:0 10px;
    border-radius:20px;
}

/* ACTIVE */

.progress-step.active span{
    background:#0d9488;
    color:#fff;
}

.progress-step.active p{
    color:#0d9488;
    font-weight:bold;
}

.progress-line.active{
    background:#0d9488;
}
</style>
</head>
<body>

  <nav class="navbar">
    <div class="logo-container">
        <img src="images/logo3.png" alt="Clinique Guenin" class="logo">
        <span class="logo-text">Clinique Guenin</span>
    </div>

</nav>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

<h2>Créer votre compte</h2>

<!-- BARRE DE PROGRESSION -->
<div class="progress-container">

    <div class="progress-step active" id="prog1">
        <span>1</span>
        <p>Identité</p>
    </div>

    <div class="progress-line" id="line1"></div>

    <div class="progress-step" id="prog2">
        <span>2</span>
        <p>Contact</p>
    </div>

    <div class="progress-line" id="line2"></div>

    <div class="progress-step" id="prog3">
        <span>3</span>
        <p>Sécurité</p>
    </div>

</div>

<!-- STEP 1 -->
<div id="step1">

    <h3>Informations personnelles</h3>

    <input type="text" name="nom" placeholder="Votre nom*" required>

    <input type="text" name="prenom" placeholder="Votre prénom*" required>

    <button type="button" onclick="next1()">Suivant</button>

</div>

<!-- STEP 2 -->
<div id="step2" style="display:none;">

    <h3>Coordonnées</h3>

    <input type="email" name="email" placeholder="Votre email*" required>

    <input type="tel" name="telephone" placeholder="Votre numéro de téléphone*" required>

    <input type="text" name="adresse" placeholder="Votre adresse*" required>

    <button type="button" onclick="prev1()">Retour</button>
    <button type="button" onclick="next2()">Suivant</button>

</div>

<!-- STEP 3 -->
<div id="step3" style="display:none;">

    <h3>Sécurité du compte</h3>

    <div class="password-container">
        <input type="password"
               name="password"
               id="password"
               placeholder="Mot de passe*"
               required>
        <span class="togglePassword">🙈</span>
    </div>

    <div class="password-container">
        <input type="password"
               name="conf_password"
               id="conf-password"
               placeholder="Confirmer le mot de passe*"
               required>
        <span class="togglePassword">🙈</span>
    </div>

    <button type="button" onclick="prev2()">Retour</button>

    <button type="submit" name="inscrire" value="inscrire">
        S'inscrire
    </button>

</div>

<a href="index.php">Retour à l'accueil</a>

</form>




</body>
</html>

<script src="script.js"></script>


<script>
document.querySelectorAll(".togglePassword").forEach(toggle => {

    toggle.addEventListener("click", function() {

        const input = this.previousElementSibling;

        if (input.type === "password") {
            input.type = "text";
            this.textContent = "👁️";
        } else {
            input.type = "password";
            this.textContent = "🙈";
        }

    });

});


function openPopup() {
  document.getElementById("popup").style.display = "flex";
}

function closePopup() {
  document.getElementById("popup").style.display = "none";
}
</script>
<script>

function next1() {
    document.getElementById("step1").style.display = "none";
    document.getElementById("step2").style.display = "block";

    document.getElementById("prog2").classList.add("active");
    document.getElementById("line1").classList.add("active");
}

function prev1() {
    document.getElementById("step2").style.display = "none";
    document.getElementById("step1").style.display = "block";

    document.getElementById("prog2").classList.remove("active");
    document.getElementById("line1").classList.remove("active");
}

function next2() {
    document.getElementById("step2").style.display = "none";
    document.getElementById("step3").style.display = "block";

    document.getElementById("prog3").classList.add("active");
    document.getElementById("line2").classList.add("active");
}

function prev2() {
    document.getElementById("step3").style.display = "none";
    document.getElementById("step2").style.display = "block";

    document.getElementById("prog3").classList.remove("active");
    document.getElementById("line2").classList.remove("active");
}

</script>