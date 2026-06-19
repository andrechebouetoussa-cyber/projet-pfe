<?php
session_start();
require_once "connexion.php";

/* sécurité */
if (!isset($_SESSION['user_id'])) {
    die("Non connecté");
}

$user_id = $_SESSION['user_id'];

/* récupérer rôle */
$stmtUser = $conn->prepare("
    SELECT role 
    FROM utilisateurs 
    WHERE id_user = :id
");
$stmtUser->execute([':id' => $user_id]);

$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable");
}

$user_role = strtolower(trim($user['role']));

/* ADMIN + SECRETAIRE */
if ($user_role == 'admin' || $user_role == 'secretaire') {

 $stmt = $conn->prepare("
    SELECT 
        r.id_rdv,
        r.date_rdv,
        r.heure_rdv,
        r.statut,

        u.nom AS patient_nom,
        u.prenom AS patient_prenom,
        u.telephone,

        m.specialite,

        um.nom AS medecin_nom,
        um.prenom AS medecin_prenom

    FROM rendez_vous r

    JOIN utilisateurs u 
        ON r.id_patient = u.id_user

    JOIN medecin m 
        ON r.id_medecin = m.id_user

    JOIN utilisateurs um 
        ON m.id_user = um.id_user

    WHERE r.statut = 'confirme'

    ORDER BY r.date_rdv DESC
");

    $stmt->execute();

/* MEDECIN */
} elseif ($user_role == 'medecin') {

   $stmt = $conn->prepare("
    SELECT 
        r.id_rdv,
        r.date_rdv,
        r.heure_rdv,
        r.statut,

        u.nom AS patient_nom,
        u.prenom AS patient_prenom,
        u.telephone,

        m.specialite,

        um.nom AS medecin_nom,
        um.prenom AS medecin_prenom

    FROM rendez_vous r

    JOIN utilisateurs u 
        ON r.id_patient = u.id_user

    JOIN medecin m 
        ON r.id_medecin = m.id_user

    JOIN utilisateurs um 
        ON m.id_user = um.id_user

    WHERE r.statut = 'confirme'
    AND r.id_medecin = :medecin_id

    ORDER BY r.date_rdv DESC
");
  $stmt->execute([
        ':medecin_id' => $user_id
    ]);

} else {
    die("Accès refusé");
}

$rdv = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* dashboard retour */
if ($user_role == 'medecin') {
    $dashboard = "dashboardmedecin.php";
} elseif ($user_role == 'secretaire') {
    $dashboard = "dashboardsecretaire.php";
} else {
    $dashboard = "dashboardadmin.php";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rendez-vous confirmés</title>
<link rel="stylesheet" href="style.css">

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
    padding:20px;
}

h1{
    text-align:center;
    margin-bottom:30px;
}

table{
    width:100%;
    border-collapse: collapse;
    background:white;
}

table th,
table td{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

table th{
    background:#0a7c6d;
    color:white;
}

.btn{
    padding:8px 12px;
    border-radius:5px;
    color:white;
    text-decoration:none;
}

.whatsapp{
    background:green;
}

.retour{
    background:#0a7c6d;
    display:inline-block;
    margin-top:20px;
}
</style>

</head>
<body>

<div class="content">

<h1>📅 Rendez-vous confirmés</h1>

<table>
<thead>
<tr>
    <th>Patient</th>
    <th>Téléphone</th>
    <th>Date</th>
    <th>Heure</th>
    <th>Médecin</th>
    <th>Spécialité</th>
    <th>Statut</th>
    <th>WhatsApp</th>
</tr>
</thead>

<tbody>

<?php foreach($rdv as $ligne): ?>

<tr>

    <td>
        <?= $ligne['patient_nom'] . " " . $ligne['patient_prenom']; ?>
    </td>

    <td>
        <?= $ligne['telephone']; ?>
    </td>

    <td>
        <?= $ligne['date_rdv']; ?>
    </td>

    <td>
        <?= $ligne['heure_rdv']; ?>
    </td>

    <td>
        <?= $ligne['medecin_nom'] . " " . $ligne['medecin_prenom']; ?>
    </td>

    <td>
        <?= $ligne['specialite']; ?>
    </td>

    <td>
        <?= $ligne['statut']; ?>
    </td>

    <td>
<?php
$numero = preg_replace('/[^0-9]/', '', $ligne['telephone']);

/* IMPORTANT : message */
$message = "Bonjour ".$ligne['patient_nom']." ".$ligne['patient_prenom'].
", votre rendez-vous est confirmé pour le ".
$ligne['date_rdv']." à ".$ligne['heure_rdv'].
" avec Dr ".$ligne['medecin_nom']." ".$ligne['medecin_prenom'].
". Clinique Atlas Care, votre santé au cœur de l'innovation.";

/* lien WhatsApp propre */
$url = "https://wa.me/".$numero."?text=".urlencode($message);
?>

<a class="btn whatsapp" href="<?= $url ?>" target="_blank">
    WhatsApp
</a>
    </a>

    </td>

</tr>

<?php endforeach; ?>

</tbody>
</table>

<a class="btn retour" href="<?= $dashboard; ?>">
    Retour dashboard
</a>

</div>

</body>
</html>