<?php
session_start();
include 'connexion.php';

require 'vendor/autoload.php';
use Dompdf\Dompdf;

if (!isset($_GET['id_consultation'])) {
    die("Ordonnance introuvable");
}

$id_consultation = $_GET['id_consultation'];

/* =========================
   CONSULTATION + ORDONNANCE
========================= */
$sql = "
SELECT 
    c.id_consultation,
    c.symptomes,
    c.diagnostic,
    c.traitement,

    o.medicament,
    o.dosage,
    o.duree,
    o.instructions,
    o.date_prescription,

    u.nom AS medecin_nom,
    u.prenom AS medecin_prenom

FROM consultation c
JOIN rendez_vous r ON c.id_rdv = r.id_rdv
JOIN utilisateurs u ON r.id_medecin = u.id_user
LEFT JOIN ordonnance o ON o.id_consultation = c.id_consultation

WHERE c.id_consultation = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_consultation]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Consultation introuvable");
}

/* =========================
   GENERER PDF
========================= */
if (isset($_POST['download_pdf'])) {

    $html = "
    <h2>Ordonnance Médicale</h2>
    <hr>

    <p><b>Médecin :</b> Dr {$data['medecin_prenom']} {$data['medecin_nom']}</p>
    <p><b>Date :</b> {$data['date_prescription']}</p>

    <hr>

    <h3>Consultation</h3>
    <p><b>Symptômes :</b> {$data['symptomes']}</p>
    <p><b>Diagnostic :</b> {$data['diagnostic']}</p>
    <p><b>Traitement :</b> {$data['traitement']}</p>

    <hr>

    <h3>Ordonnance</h3>
    <p><b>Médicament :</b> {$data['medicament']}</p>
    <p><b>Dosage :</b> {$data['dosage']}</p>
    <p><b>Durée :</b> {$data['duree']}</p>
    <p><b>Instructions :</b> {$data['instructions']}</p>
    ";

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("ordonnance.pdf", ["Attachment" => true]);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordonnance</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body{
            font-family: Arial;
            background:#f4f7fb;
        }

        .box{
            max-width:700px;
            margin:auto;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            color:#0f766e;
        }

        h3{
            color:#333;
        }

        button{
            background:#0a7c6d;
            color:white;
            padding:10px 15px;
            border:none;
            border-radius:8px;
            cursor:pointer;
        }

        p{
            line-height:1.6;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>💊 Ordonnance Médicale</h2>

    <p><b>Médecin :</b> Dr <?= $data['medecin_prenom']." ".$data['medecin_nom']; ?></p>
    <p><b>Date :</b> <?= $data['date_prescription'] ?? 'Non définie'; ?></p>

    <hr>

    <h3>🩺 Consultation</h3>
    <p><b>Symptômes :</b> <?= htmlspecialchars($data['symptomes']); ?></p>
    <p><b>Diagnostic :</b> <?= htmlspecialchars($data['diagnostic']); ?></p>
    <p><b>Traitement :</b> <?= htmlspecialchars($data['traitement']); ?></p>

    <hr>

    <h3>💊 Ordonnance</h3>
    <p><b>Médicament :</b> <?= htmlspecialchars($data['medicament'] ?? 'Non défini'); ?></p>
    <p><b>Dosage :</b> <?= htmlspecialchars($data['dosage'] ?? ''); ?></p>
    <p><b>Durée :</b> <?= htmlspecialchars($data['duree'] ?? ''); ?></p>
    <p><b>Instructions :</b><br>
       <?= nl2br(htmlspecialchars($data['instructions'] ?? '')); ?>
    </p>

    <hr>

    <form method="POST">
        <button type="submit" name="download_pdf">
            📥 Télécharger PDF
        </button>
    </form>

</div>

</body>
</html>