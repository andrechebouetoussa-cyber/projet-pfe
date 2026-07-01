<?php
session_start();
include 'connexion.php';

/* Vérifier id_rdv */
if (!isset($_GET['id_rdv'])) {
    die("Rendez-vous introuvable");
}

$id_rdv = $_GET['id_rdv'];

/* Récupérer infos RDV + patient */
$sql = "
SELECT 
    r.id_rdv,
    r.id_patient,
    r.id_medecin,
    r.date_rdv,
    r.heure_rdv,
    r.motif,
    u.nom,
    u.prenom,
    u.telephone,
    u.email
FROM rendez_vous r
JOIN utilisateurs u ON r.id_patient = u.id_user
WHERE r.id_rdv = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_rdv]);
$rdv = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rdv) {
    die("Rendez-vous introuvable");
}

/* =========================
   DISPONIBILITÉ MÉDECIN
========================= */
$sql = "
SELECT heure_debut, heure_fin 
FROM disponibilite 
WHERE id_medecin = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$rdv['id_medecin']]);
$dispo = $stmt->fetch(PDO::FETCH_ASSOC);

/* Générer créneaux (30 min) */
function genererCreneaux($debut, $fin) {
    $creneaux = [];

    if (!$debut || !$fin) return $creneaux;

    $start = strtotime($debut);
    $end = strtotime($fin);

    for ($t = $start; $t < $end; $t += 1800) { // 30 minutes
        $creneaux[] = date("H:i", $t);
    }

    return $creneaux;
}

$creneaux = [];

if ($dispo) {
    $creneaux = genererCreneaux($dispo['heure_debut'], $dispo['heure_fin']);
}

/* Heures déjà prises */
$heures_prises = [];

$sql = "
SELECT heure_rdv 
FROM rendez_vous 
WHERE date_rdv = ? 
AND id_medecin = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$rdv['date_rdv'], $rdv['id_medecin']]);

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $h) {
    $heures_prises[] = $h['heure_rdv'];
}

/* =========================
   ENREGISTREMENT CONSULTATION
========================= */
if (isset($_POST['enregistrer'])) {

    $symptomes = $_POST['symptomes'];
    $diagnostic = $_POST['diagnostic'];
    $traitement = $_POST['traitement'];

    $insert = "
    INSERT INTO consultation (symptomes, diagnostic, traitement, id_rdv)
    VALUES (?, ?, ?, ?)
    ";

    $stmt = $conn->prepare($insert);
    $stmt->execute([$symptomes, $diagnostic, $traitement, $id_rdv]);

    $id_consultation = $conn->lastInsertId();

    /* RDV DE CONTRÔLE */
    if (!empty($_POST['date_controle']) && !empty($_POST['heure_controle'])) {

        $insert_rdv = "
        INSERT INTO rendez_vous 
        (id_patient, id_medecin, date_rdv, heure_rdv, motif, statut)
        VALUES (?, ?, ?, ?, ?, 'confirme')
        ";

        $stmt = $conn->prepare($insert_rdv);
        $stmt->execute([
            $rdv['id_patient'],
            $rdv['id_medecin'],
            $_POST['date_controle'],
            $_POST['heure_controle'],
            "Rendez-vous de contrôle"
        ]);
    }

    header("Location: RDV1.php?id_rdv=$id_rdv&ok=1&id_consultation=$id_consultation");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Consultation</title>
<link rel="stylesheet" href="style.css">
<style>
body{background:#f4f7fb;font-family:Arial;}

.navbar{
    background:white;
    padding:15px;
    font-weight:bold;
    text-align:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

h2{text-align:center;color:#0f766e;}
h3{color:#333;margin-top:20px;}

p{
    background:white;
    padding:15px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
}

form{
    background:white;
    padding:20px;
    border-radius:12px;
    max-width:900px;
    margin:auto;
}

textarea,input,select{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
}

button{
    background:#0a7c6d;
    color:white;
    padding:12px;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

.btn-ordonnance{
    display:inline-block;
    margin-top:15px;
    background:green;
    color:white;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
}
</style>
</head>

<body>

<nav class="navbar"> Clinique Guenin</nav>

<h2>🩺 Consultation médicale</h2>

<hr>

<h3>👤 Patient</h3>
<p>
    <?= htmlspecialchars($rdv['prenom']." ".$rdv['nom']); ?><br>
    📞 <?= htmlspecialchars($rdv['telephone']); ?><br>
    📧 <?= htmlspecialchars($rdv['email']); ?>
</p>

<h3>📅 Rendez-vous</h3>
<p>
    Date : <?= $rdv['date_rdv']; ?> <br>
    Heure : <?= $rdv['heure_rdv']; ?> <br>
    Motif : <?= htmlspecialchars($rdv['motif']); ?>
</p>

<hr>

<h3>📝 Consultation</h3>

<form method="POST">

<label>Symptômes</label>
<textarea name="symptomes" required></textarea>

<label>Diagnostic</label>
<textarea name="diagnostic" required></textarea>

<label>Traitement</label>
<textarea name="traitement" required></textarea>

<hr>

<h3>📅 Rendez-vous de contrôle</h3>

<label>Date</label>
<input type="date" name="date_controle">

<label>Heure</label>
<select name="heure_controle">
    <option value="">-- Choisir une heure --</option>
    <?php foreach ($creneaux as $c): ?>
        <?php if (!in_array($c, $heures_prises)): ?>
            <option value="<?= $c; ?>"><?= $c; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>

<button type="submit" name="enregistrer">
    💾 Enregistrer la consultation
</button>

</form>

<?php if (isset($_GET['ok']) && isset($_GET['id_consultation'])): ?>
    <div style="text-align:center; margin-top:20px;">
        <a class="btn-ordonnance" href="ordonnance.php?id_consultation=<?= $_GET['id_consultation']; ?>">
            💊 Prescrire ordonnance
        </a>
    </div>
<?php endif; ?>

</body>
<script src="script.js"></script>
</html>"
