<?php
session_start();
include 'connexion.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user_id'];

/* données */
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$telephone = $_POST['telephone'];
$adresse = $_POST['adresse'];
$specialite = $_POST['specialite'] ?? null;

/* photo */
$photo = null;

if(!empty($_FILES['photo']['name'])){

    $photo = time() . "_" . $_FILES['photo']['name'];

    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "uploads/" . $photo
    );

    $sql = "UPDATE utilisateurs 
            SET nom=:nom, prenom=:prenom, telephone=:telephone,
                adresse=:adresse, photo=:photo
            WHERE id_user=:id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':nom'=>$nom,
        ':prenom'=>$prenom,
        ':telephone'=>$telephone,
        ':adresse'=>$adresse,
        ':photo'=>$photo,
        ':id'=>$id
    ]);

} else {

    $sql = "UPDATE utilisateurs 
            SET nom=:nom, prenom=:prenom, telephone=:telephone,
                adresse=:adresse
            WHERE id_user=:id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':nom'=>$nom,
        ':prenom'=>$prenom,
        ':telephone'=>$telephone,
        ':adresse'=>$adresse,
        ':id'=>$id
    ]);
}

/* spécialité médecin */
if($specialite){

    $sql2 = "UPDATE medecin 
             SET specialite=:specialite 
             WHERE id_user=:id";

    $stmt2 = $conn->prepare($sql2);

    $stmt2->execute([
        ':specialite'=>$specialite,
        ':id'=>$id
    ]);
}

header("Location: profil.php");
exit();
?>