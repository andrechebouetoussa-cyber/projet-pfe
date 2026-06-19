<?php
session_start();
include 'connexion.php';

$medecin_id = $_SESSION['user_id'];

$sql = "
SELECT 
    r.id_rdv,
    r.date_rdv,
    r.heure_rdv,
    r.motif,
    u.nom AS patient_nom,
    u.prenom AS patient_prenom
FROM rendez_vous r
JOIN utilisateurs u ON r.id_patient = u.id_user
WHERE r.id_medecin = ?
AND LOWER(TRIM(r.statut)) = 'confirme'
ORDER BY r.date_rdv ASC, r.heure_rdv ASC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$medecin_id]);
$rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>👨‍⚕️ Rendez-vous confirmés</h2>

<?php if (empty($rdvs)): ?>
    <p>Aucun rendez-vous confirmé</p>
<?php else: ?>

<table border="1" cellpadding="10" cellspacing="0"
style="width:100%; border-collapse: collapse; text-align:center;">

    <thead style="background:#f2f2f2;">
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Motif</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($rdvs as $r): ?>
            <tr>

                <td><?= $r['id_rdv']; ?></td>

                <td>
                    <?= htmlspecialchars($r['patient_prenom']." ".$r['patient_nom']); ?>
                </td>

                <td><?= htmlspecialchars($r['date_rdv']); ?></td>

                <td><?= htmlspecialchars($r['heure_rdv']); ?></td>

                <td><?= htmlspecialchars($r['motif']); ?></td>

                <td style="color:green; font-weight:bold;">
                    ✔ Confirmé
                </td>

                <td>
                <button style="background:#0a7c6d; color:white; border:none; padding:10px 15px; border-radius:8px; cursor:pointer;">
    <a href="consultation.php?id_rdv=<?= $r['id_rdv']; ?>" class="login-btn" style="color:white; text-decoration:none;">Consulter</a>
  </button>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
  <button style="background:#0a7c6d; color:white; border:none; padding:10px 15px; border-radius:8px; cursor:pointer;">
    <a href="dashboardmedecin.php" class="login-btn" style="color:white; text-decoration:none;">Retournez au dashboard</a>
  </button>
<?php endif; ?>