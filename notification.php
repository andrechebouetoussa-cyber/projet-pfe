<?php 
session_start();
include 'connexion.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   USER ROLE
========================= */
$stmtUser = $conn->prepare("
    SELECT role 
    FROM utilisateurs 
    WHERE id_user = ?
");
$stmtUser->execute([$user_id]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if(!$user){
    session_destroy();
    header("Location: login.php");
    exit();
}

$role = $user['role'];

/* =========================
   NOTIFICATIONS
========================= */

if ($role == 'patient') {

    $stmt = $conn->prepare("
        SELECT *
        FROM notification
        WHERE id_user = ?
        ORDER BY created_at DESC
    ");
    $stmt->execute([$user_id]);

} elseif ($role == 'secretaire') {

    $stmt = $conn->prepare("
        SELECT *
        FROM notification
        ORDER BY created_at DESC
    ");
    $stmt->execute();

} elseif ($role == 'medecin') {

    /* IMPORTANT :
       on récupère via id_user du médecin + id_rdv obligatoire
    */
    $stmt = $conn->prepare("
        SELECT n.*
        FROM notification n
        JOIN medecin m ON m.id_user = n.id_user
        WHERE m.id_user = ?
        ORDER BY n.created_at DESC
    ");
    $stmt->execute([$user_id]);

} else {

    $stmt = $conn->prepare("
        SELECT *
        FROM notification
        ORDER BY created_at DESC
    ");
    $stmt->execute();
}

$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   DASHBOARD
========================= */
$dashboard = match($role) {
    'patient' => "dashboardpatient.php",
    'medecin' => "dashboardmedecin.php",
    'secretaire' => "dashboardsecretaire.php",
    default => "dashboardadmin.php"
};
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Notifications</title>
<link rel="stylesheet" href="style.css">

<style>

.container{
    width:60%;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
}

.notification{
    padding:15px;
    margin-bottom:10px;
    border-radius:10px;
    background:#f8fafc;
    border-left:5px solid #2563eb;
}

.unread{
    background:#dbeafe;
    font-weight:bold;
}

.date{
    font-size:12px;
    color:gray;
    display:block;
    margin-top:5px;
}

.empty{
    text-align:center;
    color:gray;
}
</style>
</head>
<body>

<div class="navbar">
    🏥 Clinique Atlas Care
</div>

<div class="container">

<h2>🔔 Notifications</h2>

<?php if(empty($notifications)): ?>

    <p class="empty">Aucune notification</p>

<?php else: ?>

    <?php foreach($notifications as $n): ?>

        <div class="notification <?= $n['is_read'] == 0 ? 'unread' : '' ?>">

            <p><?= htmlspecialchars($n['message']); ?></p>

            <span class="date">
                <?= htmlspecialchars($n['created_at']); ?>
            </span>

        </div>

    <?php endforeach; ?>

<?php endif; ?>

</div>

<a href="<?= $dashboard; ?>" style="display:block;text-align:center;margin:20px;">
    🔙 Retour dashboard
</a>

</body>
<script src="script.js"></script>
</html>