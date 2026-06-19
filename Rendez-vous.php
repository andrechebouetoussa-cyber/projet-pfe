
<?php
session_start();
include 'connexion.php';



if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "confirmer") {

    // 1. Vérification du créneau
    $verif = $conn->prepare("
        SELECT id_rdv FROM rendez_vous
        WHERE id_medecin = ?
        AND date_rdv = ?
        AND heure_rdv = ?
    ");

    $verif->execute([
        $_POST['medecin_id'],
        $_POST['date'],
        $_POST['heure']
    ]);

    $existe = $verif->fetch();

    if ($existe) {
        die("❌ Ce créneau est déjà réservé.");
    }

    // 2. Insertion si libre
    $sql = "INSERT INTO rendez_vous
    (id_patient, id_medecin, date_rdv, heure_rdv, motif, statut)
    VALUES (?, ?, ?, ?, ?, 'en_attente')";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['medecin_id'],
        $_POST['date'],
        $_POST['heure'],
        $_POST['motif']
    ]);

    header("Location: historique.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rendez-vous</title>
<link rel="stylesheet" href="style.css">
<style>
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
        <img src="images/logo.png" alt="Clinique Atlas Care" class="logo">
        <span class="logo-text">Clinique Atlas Care</span>
    </div>

    <ul class="menu">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="Rendez-vous.php">Rendez-vous</a></li>
    </ul>
    <button class="menu-toggle" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="btn">
     <a href="login.php" class="login-btn">Login</a>
    </div>
</nav>





<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
<h2>Prenez  rendez-vous en quelques clics</h2>


<!-- BARRE DE PROGRESSION -->
<div class="progress-container">

  <div class="progress-step active" id="prog1">
    <span>1</span>
    <p>Informations</p>
  </div>

  <div class="progress-line" id="line1"></div>

  <div class="progress-step" id="prog2">
    <span>2</span>
    <p>Service</p>
  </div>

  <div class="progress-line" id="line2"></div>

  <div class="progress-step" id="prog3">
    <span>3</span>
    <p>Rendez-vous</p>
  </div>

</div>


<!-- STEP 1 -->
<div id="step1">
  <h3>Vos informations*</h3>

  <input type="text" name="nom" placeholder="votre Nom*" required>
  <input type="text" name="prenom" placeholder=" votre Prénom*" required>
  <input type="tel" name="tel" placeholder="votre numéro de téléphone*" required>
  <input type="email" name="email" placeholder="votre Email*" required>

  <button type="button" onclick="next1()">Suivant</button>
</div>

<!-- STEP 2 -->
<div id="step2" style="display:none;">
  <h3>Service concerné*</h3>

  <select name="service_id" required>
    <option value="">Choisir le service*</option>
      <option value="gynecologie">Gynécologie</option>
      <option value="cardio">Cardiologie</option> 
  <option value="pediatrie">Pédiatrie</option> 
   <option value="neurologie">Neurologie</option> 
   <option value="Chirurgie Générale">Chirurgie Générale</option> 

  <option value="pneumologie">Pneumologie</option>
  <option value="radiologie">Imagerie - Radiologie</option>
  <option value="dentaire">Dentisterie</option> 
   <option value="orthopedie">Orthopedie</option> 
  <option value="general">Médecine générale</option>
  </select>

  <button type="button" onclick="prev1()">Retour</button>
  <button type="button" onclick="next2()">Suivant</button>
</div>

<!-- STEP 3 -->
<div id="step3" style="display:none;">

  <h3>Date + créneaux*</h3>

  <input type="date" name="date" id="date_rdv" required>

  <div id="heures">
    <p>Choisir une date*</p>
  </div>

  <input type="hidden" name="heure" id="heure">
  <input type="hidden" name="medecin_id" id="medecin_id">

  <textarea name="motif" placeholder="Motif"></textarea>

  <button type="button" onclick="prev2()">Retour</button>

  <button type="submit" name="action" value="confirmer">
    Confirmer RDV
  </button>
</div>

</form>



<script>

/* =========================
   BARRE DE PROGRESSION
========================= */

function updateProgress(step){

    document.getElementById("prog1").classList.remove("active");
    document.getElementById("prog2").classList.remove("active");
    document.getElementById("prog3").classList.remove("active");

    document.getElementById("line1").classList.remove("active");
    document.getElementById("line2").classList.remove("active");

    if(step >= 1){
        document.getElementById("prog1").classList.add("active");
    }

    if(step >= 2){
        document.getElementById("prog2").classList.add("active");
        document.getElementById("line1").classList.add("active");
    }

    if(step >= 3){
        document.getElementById("prog3").classList.add("active");
        document.getElementById("line2").classList.add("active");
    }
}


/* =========================
   STEP 1
========================= */

function next1(){

    let nom = document.querySelector("input[name='nom']").value.trim();
    let prenom = document.querySelector("input[name='prenom']").value.trim();
    let tel = document.querySelector("input[name='tel']").value.trim();
    let email = document.querySelector("input[name='email']").value.trim();

    if(nom === "" || prenom === "" || tel === "" || email === ""){
        alert("Veuillez remplir tous les champs.");
        return;
    }

    document.getElementById("step1").style.display = "none";
    document.getElementById("step2").style.display = "block";

    updateProgress(2);
}


/* =========================
   STEP 2
========================= */

function next2(){

    let service = document.querySelector("select[name='service_id']").value;

    if(service === ""){
        alert("Veuillez choisir une spécialité.");
        return;
    }

    document.getElementById("step2").style.display = "none";
    document.getElementById("step3").style.display = "block";

    updateProgress(3);
}


/* =========================
   RETOUR
========================= */

function prev1(){

    document.getElementById("step2").style.display = "none";
    document.getElementById("step1").style.display = "block";

    updateProgress(1);
}

function prev2(){

    document.getElementById("step3").style.display = "none";
    document.getElementById("step2").style.display = "block";

    updateProgress(2);
}


/* =========================
   SELECTION HEURE
========================= */

function selectHeure(heure, medecin_id){

    document.getElementById("heure").value = heure;
    document.getElementById("medecin_id").value = medecin_id;

    document.querySelectorAll("#heures button").forEach(b => {
        b.classList.remove("active");
    });

    event.target.classList.add("active");
}


/* =========================
   CHARGER CRENEAUX
========================= */

document.getElementById("date_rdv").addEventListener("change", function(){

    let date = this.value;
    let specialite = document.querySelector("select[name='service_id']").value;

    fetch("get_creneaux.php?date=" + date + "&specialite=" + specialite)
    .then(res => res.text())
    .then(data => {
        document.getElementById("heures").innerHTML = data;
    });

});


/* =========================
   VALIDATION FINALE
========================= */

document.querySelector("form").addEventListener("submit", function(e){

    let date = document.getElementById("date_rdv").value;
    let heure = document.getElementById("heure").value;
    let motif = document.querySelector("textarea[name='motif']").value.trim();

    if(date === ""){
        alert("Veuillez choisir une date.");
        e.preventDefault();
        return;
    }

    if(heure === ""){
        alert("Veuillez choisir un créneau.");
        e.preventDefault();
        return;
    }

    if(motif === ""){
        alert("Veuillez entrer le motif du rendez-vous.");
        e.preventDefault();
        return;
    }

});


/* =========================
   INITIALISATION
========================= */

updateProgress(1);

</script>
<script src="script.js"></script>
</body>
</html>