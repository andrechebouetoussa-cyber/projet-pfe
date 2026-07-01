<?php
session_start();
require_once "connexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("❌ Veuillez remplir tous les champs.");
    }

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("❌ Email inexistant");
    }

    if (!password_verify($password, $user['password'])) {
        die("❌ Mot de passe incorrect");
    }

    session_regenerate_id(true);

    $_SESSION["user_id"] = $user['id_user'];
    $_SESSION["role"] = $user['role'];
    $_SESSION["nom"] = $user['nom'];
    $_SESSION["email"] = $user['email'];

    switch ($user['role']) {
        case 'admin':
            header("Location: dashboardadmin.php");
            break;

        case 'medecin':
            header("Location: dashboardmedecin.php");
            break;

        case 'secretaire':
            header("Location: dashboardsecretaire.php");
            break;

        case 'patient':
            header("Location: dashboardpatient.php");
            break;

        default:
            die("❌ Rôle inconnu");
    }

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
    <style>
    /* ===== Animations ===== */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }


    body > div {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }


    /* ===== Boite du formulaire ===== */
    .login-box {
        width: 450px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
        animation: slideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.8);
        position: relative;
    }

    /* Header avec gradient */
    .login-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }

    .login-box-content {
        padding: 50px 40px 40px 40px;
    }

    /* Icon du formulaire */
    .login-icon {
        text-align: center;
        font-size: 48px;
        margin-bottom: 15px;
        animation: fadeIn 0.8s ease-out;
    }

    .login-box h2 {
        text-align: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 8px 0;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.5px;
        color:#0a7c6d;
    }

    .login-box h3 {
        text-align: center;
        color: #0a7c6d;
        margin: 0 0 30px 0;
        font-size: 13px;
        font-weight: 400;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    /* ===== Séparateur ===== */
    .form-separator {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e0e0e0, transparent);
        margin-bottom: 30px;
    }

    /* ===== Formulaire ===== */
    form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 22px;
        position: relative;
        animation: fadeIn 0.8s ease-out 0.2s both;
    }

    .form-group label {
        display: block;
        color: #555;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        transition: color 0.3s ease;
    }

    form input {
        width: 100%;
        padding: 14px 16px 14px 45px;
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        outline: none;
        font-size: 14px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #f8f9fc;
        color: #333;
        font-weight: 500;
        position: relative;
    }

    form input::placeholder {
        color: #bbb;
        font-weight: 400;
    }

    form input:hover {
        border-color: #d0d0d0;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
    }

    form input:focus {
        border-color: #667eea;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15), 0 8px 20px rgba(102, 126, 234, 0.1);
    }

    /* Icons dans les champs */
    .form-group::before {
        content: attr(data-icon);
        position: absolute;
        left: 15px;
        top: 38px;
        font-size: 18px;
        color: #999;
        transition: color 0.3s ease;
        pointer-events: none;
    }

    .form-group:has(input:focus)::before {
        color: #667eea;
    }

    /* ===== Password ===== */
    .password-container {
        position: relative;
        width: 100%;
        margin-bottom: 22px;
        animation: fadeIn 0.8s ease-out 0.3s both;
    }

    .password-container label {
        display: block;
        color: #555;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .password-container input {
        padding-right: 45px;
    }

    .password-container::before {
        content: '🔒';
        position: absolute;
        left: 15px;
        top: 38px;
        font-size: 18px;
        color: #999;
        transition: color 0.3s ease;
        pointer-events: none;
    }

    .password-container:has(input:focus)::before {
        color: #667eea;
    }

    .password-container span {
        position: absolute;
        right: 14px;
        top: 38px;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
        user-select: none;
        color: #999;
    }

    .password-container span:hover {
        color: #667eea;
        transform: scale(1.15);
    }

    /* ===== Boutons ===== */
    .button-group {
        margin-top: 8px;
        animation: fadeIn 0.8s ease-out 0.4s both;
    }

    button {
        width: 100%;
        padding: 14px 20px;
        border: none;
        border-radius: 10px;
        background: #0a7c6d;
        color: white;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s ease;
    }

    button:hover::before {
        left: 100%;
    }

    button:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
    }

    button:active {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3);
    }

    button[type="button"] {
        background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
        color:#0a7c6d;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        font-weight: 600;
    }

    button[type="button"]:hover {
        background: linear-gradient(135deg, #e8e8e8 0%, #ddd 100%);
        color: #0a7c6d;
    }

    /* ===== Texte ===== */
    p {
        text-align: center;
        margin: 25px 0 0 0;
        color: black;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    /* ===== Lien ===== */
    a {
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        color: #0a7c6d;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 12px;
        display: block;
        letter-spacing: 0.5px;
    }

    a:hover {
        color: #0a7c6d;
        transform: translateX(-3px);
    }

    /* ===== Responsive ===== */
    @media(max-width: 480px) {
        .login-box {
            width: 96%;
        }

        .login-box-content {
            padding: 40px 25px 30px 25px;
        }

        .login-box h2 {
            font-size: 28px;
        }

        form input,
        button {
            font-size: 15px;
        }

        .login-icon {
            font-size: 40px;
        }
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

    <div class="login-box">
       
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="form-group" data-icon="📧">
                    <label for="email">Email</label>
                    <input type="email" placeholder="votre.email@exemple.com" name="email" id="email" required>
                </div>
                
                <div class="password-container">
                    <label for="password">Mot de passe</label>
                    <input type="password" placeholder="••••••••••••" name="password" id="password" required>
                    <span id="togglePassword">🙈</span>
                </div>
                
                <div class="button-group">
                    <button type="submit" value="login" name="login">Se connecter</button>
                    <p>Vous n'avez pas de compte?</p>
                    <button type="button" onclick="window.location.href='register.php'">Créer un compte</button>
                </div>
                
                <a href="index.php">← Retour à l'accueil</a>
            </form>
        </div>
    </div>


    
   
</body>
</html>

<script src="script.js"></script>
<script>
const password = document.getElementById("password");
const toggle = document.getElementById("togglePassword");

toggle.addEventListener("click", function() {
  if (password.type === "password") {
    password.type = "text";
    toggle.textContent = "🙈";
  } else {
    password.type = "password";
    toggle.textContent = "👁️";
  }
});
</script>