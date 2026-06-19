<?php
include 'connexion.php';

$date = $_GET['date'];
$specialite = $_GET['specialite'];

/* convertir date → jour */
$jour_en = date('l', strtotime($date));

$jours = [
    "Monday" => "Lundi",
    "Tuesday" => "Mardi",
    "Wednesday" => "Mercredi",
    "Thursday" => "Jeudi",
    "Friday" => "Vendredi",
    "Saturday" => "Samedi",
    "Sunday" => "Dimanche"
];

$jour = $jours[$jour_en];

/* récupérer disponibilité */
$sql = "SELECT d.id_medecin, d.heure_debut, d.heure_fin
        FROM disponibilite d
        JOIN medecin m ON m.id_user = d.id_medecin
        WHERE m.specialite = ?
        AND d.jour = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$specialite, $jour]);

$data = $stmt->fetchAll();

/* aucun médecin */
if(empty($data)){
    echo "<p>Aucun medecin disponible pour ce jour.</p>";
    exit();
}

/* générer créneaux */
foreach($data as $d){

    $start = strtotime($d['heure_debut']);
    $end = strtotime($d['heure_fin']);

    while($start < $end){

        $time = date("H:i", $start);

        /* vérifier réservation */
        $check = $conn->prepare("
            SELECT * FROM rendez_vous
            WHERE date_rdv = ?
            AND heure_rdv = ?
            AND id_medecin = ?
        ");

        $check->execute([
            $date,
            $time,
            $d['id_medecin']
        ]);

        /* libre */
        if($check->rowCount() == 0){

            echo "
            <button type='button'
            onclick=\"selectHeure('$time', '".$d['id_medecin']."')\">
                $time
            </button>
            ";

        }

        $start = strtotime("+30 minutes", $start);
    }
}
?>