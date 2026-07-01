
<?php
session_start();
include 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "rechercher") {

    $patient_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $motif = $_POST['motif'];
    $service_id = $_POST['service_id'];

    $sql = "SELECT u.id_user AS user_id, u.nom, u.prenom
            FROM medecin m
            JOIN utilisateurs u ON u.id_user = m.id_user
            WHERE m.specialite= :service_id
            AND m.id_user NOT IN (
                SELECT id_medecin FROM rendez_vous
                WHERE date_rdv = :date AND heure_rdv = :heure
            )
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':service_id' => $service_id,
        ':date' => $date,
        ':heure' => $heure
    ]);

    $medecin = $stmt->fetch();

    if ($medecin) {

        echo "
        <h2>Médecin proposé</h2>
        <p><strong>Dr " . $medecin['nom'] . " " . $medecin['prenom'] . "</strong></p>

        <form method='POST'>
            <input type='hidden' name='medecin_id' value='".$medecin['user_id']."'>
            <input type='hidden' name='date' value='$date'>
            <input type='hidden' name='heure' value='$heure'>
            <input type='hidden' name='motif' value='$motif'>

            <button type='submit' name='action' value='confirmer'>
                Confirmer le rendez-vous
            </button>
        </form>
        ";

    } else {
        echo "Aucun médecin disponible.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "confirmer") {

    $sql = "INSERT INTO rendez_vous
    (id_patient, id_medecin, date_rdv, heure_rdv, motif, statut)
    VALUES
    (:patient_id, :medecin_id, :date, :heure, :motif, 'en_attente')";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':patient_id' => $_SESSION['user_id'],
        ':medecin_id' => $_POST['medecin_id'],
        ':date' => $_POST['date'],
        ':heure' => $_POST['heure'],
        ':motif' => $_POST['motif']
    ]);

    header("Location: historique.php");
    exit();
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

    <ul class="menu">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="Rendez-vous.php">Rendez-vous</a></li>
    </ul>
    <div class="btn">
     <a href="login.php" class="login-btn">Login</a>
    </div>
</nav>




<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

  
  <div id="step1">
  <h2>Étape 1 : Vos informations</h2>

  <input type="text" name="nom" placeholder="Nom complet" required>
  <input type="text" name="prenom" placeholder="Prenom complet" required>
  <input type="tel" name="tel" placeholder="Téléphone" required>
  <input type="text" name="email" placeholder="Email valide" required>
  

  <button type="button" onclick="next1()">Suivant</button>
  </div>

 <div id="step2" style="display:none;">

  <h2>Étape 2 : Choisir la spécialité</h2>

 <select name="service_id" required>
  <option value="">-- Choisir --</option>
  <option value="cardio">Cardiologie</option> 
  <option value="pediatrie">Pédiatrie</option> 
   <option value="neurologie">Neurologie</option> 
   <option value="Chirurgie Générale">Chirurgie Générale</option> 
  <option value="gynecologie">Gynécologie</option>
  <option value="pneumologie">Pneumologie</option>
  <option value="radiologie">Imagerie - Radiologie</option>
  <option value="dentaire">Dentisterie</option> 
  <option value="general">Médecine générale</option>
</select>

  <button type="button" onclick="prev1()">Retour</button>
  <button type="button" onclick="next2()">Suivant</button>

</div>

  <div id="step3" style="display:none;">

  <h2>Étape 3 : Rendez-vous</h2>

  <input type="date" name="date" required>
 <input type="hidden" name="heure_rdv" id="heure_rdv">

<div id="heures">
    <button type="button" onclick="selectHeure('09:00')">09:00</button>
    <button type="button" onclick="selectHeure('10:00')">10:00</button>
</div>
<input type="hidden" name="heure" id="heure">

  <textarea name="motif" placeholder="Motif de consultation"></textarea>

  <button type="button" onclick="prev2()">Retour</button>

<button type="submit" name="action" value="rechercher">
    Rechercher médecin
</button>

</div>
</form>


 <button><a href="reservations.php" class="login-btn">retour</a></button>

<footer class="footer">
  <div class="footer-container">

    <div class="footer-section">
      <h2>Clinique Guenin</h2>
      <p>
        Découvrez un établissement médical où les besoins et le bien-être des patients sont prioritaires, sous la supervision d'une équipe de médecins qualifiés et expérimentés.
      </p>
    </div>

    <div class="footer-section">
      <h3>Liens rapides</h3>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="Rendez-vous.php">Rendez-vous</a></li>
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
function next1(){
  let nom = document.querySelector("input[name='nom']").value;
  let prenom = document.querySelector("input[name='prenom']").value;
  let tel = document.querySelector("input[name='tel']").value;
  let email = document.querySelector("input[name='email']").value;

  if(!nom || !prenom || !tel || !email){
    alert("Remplis tous les champs");
    return;
  }

  document.getElementById("step1").style.display = "none";
  document.getElementById("step2").style.display = "block";
}

function next2(){
  let service = document.querySelector("select[name='service_id']");

  if(!service || service.value === ""){
    alert("Choisis une spécialité");
    return;
  }

  document.getElementById("step2").style.display = "none";
  document.getElementById("step3").style.display = "block";
}

function prev1(){
  document.getElementById("step2").style.display = "none";
  document.getElementById("step1").style.display = "block";
}

function prev2(){
  document.getElementById("step3").style.display = "none";
  document.getElementById("step2").style.display = "block";
}

function selectHeure(h){
  document.getElementById("heure").value = h;
}
</script>
<script>
function selectHeure(heure) {
    document.getElementById("heure_rdv").value = heure;

    let buttons = document.querySelectorAll("#heures button");
    buttons.forEach(btn => btn.classList.remove("active"));

    event.target.classList.add("active");
}
</script>
</body>
</html>







if($_SESSION['role'] != 'secretaire'){
    die("Accès refusé");
}









