<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <style>
        .hero-specialites{
    width:100%;
    min-height:320px;
    background:linear-gradient(#0f172a);
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:40px 20px;
    color:#fff;
    margin-bottom:60px;
}

.hero-content{
    max-width:800px;
    
}

.hero-content h1{
    font-size:52px;
    font-weight:700;
    margin-bottom:20px;
}

.hero-content p{
    font-size:22px;
    line-height:1.8;
    opacity:.95;
}

.services-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(330px,1fr));
    gap:30px;
    margin:50px auto;
}

.service-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,.12);
    transition:.4s;
}

.service-card:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 35px rgba(0,0,0,.2);
}

.service-card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.service-content{
    padding:25px;
}

.service-content h2{
    color: #0a7c6d;
    margin-bottom:10px;
}

.price{
    font-size:28px;
    color:#00a86b;
    font-weight:bold;
    margin:15px 0;
}

.service-content p{
    color:#555;
    line-height:1.6;
}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background: #0a7c6d;
    color:#fff;
    text-decoration:none;
    border-radius:50px;
    font-weight:bold;
    transition:.3s;
}

.btn:hover{
    background:#084298;
}
    </style>
</head>
<body>
    <nav class="navbar">
    <div class="logo-container">
        <img src="images/logo3.png" alt="Clinique Guenin" class="logo">
        <span class="logo-text">Clinique Guenin</span>
    </div>

    <ul class="menu">
        <li><a href="index.php">Accueil</a></li>
         <li><a href="service.php">Services</a></li>
        <li><a href="Rendez-vous.php">Rendez-vous</a></li>
        <li><a href="contacts.php">Contact</a></li>
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

<section class="hero-specialites"  data-aos="fade-up">
    <div class="hero-content">
        <h1>Nos Spécialités Médicales</h1>
        <p>Une équipe pluridisciplinaire pour une prise en charge globale de votre santé.</p>
    </div>
</section>

<div class="services-container"  data-aos="fade-up">

    <div class="service-card">
        <img src="images/dentiste.jpg" alt="Dentisterie">
        <div class="service-content">
            <h2>🦷 Dentisterie</h2>
            <p class="price"><strong>20 000 FCFA</strong></p>
            <p>Soins dentaires complets : détartrage, traitement des caries, blanchiment et orthodontie.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

    <div class="service-card">
        <img src="images/cardio.jpg" alt="Cardiologie">
        <div class="service-content">
            <h2>❤️ Cardiologie</h2>
            <p class="price"><strong>30 000 FCFA</strong></p>
            <p>Diagnostic et suivi des maladies cardiovasculaires avec des équipements modernes.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

    <div class="service-card">
        <img src="images/pediatrie.jpg" alt="Pédiatrie">
        <div class="service-content">
            <h2>👶 Pédiatrie</h2>
            <p class="price"><strong>15 000 FCFA</strong></p>
            <p>Consultations pédiatriques, vaccinations et suivi médical des nourrissons et enfants.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

    <div class="service-card">
        <img src="images/neurone.jpg" alt="Neurologie">
        <div class="service-content">
            <h2>🧠 Neurologie</h2>
            <p class="price"><strong>35 000 FCFA</strong></p>
            <p>Diagnostic et traitement des maladies du cerveau, de la moelle épinière et des nerfs.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

    <div class="service-card">
        <img src="images/gyneco.jpg" alt="Gynécologie">
        <div class="service-content">
            <h2>👩‍⚕️ Gynécologie</h2>
            <p class="price"><strong>25 000 FCFA</strong></p>
            <p>Suivi de la santé de la femme, grossesse, dépistage et consultations gynécologiques.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

    <div class="service-card">
        <img src="images/pneun.jpg" alt="Pneumologie">
        <div class="service-content">
            <h2>🫁 Pneumologie</h2>
            <p class="price"><strong>25 000 FCFA</strong></p>
            <p>Prise en charge des maladies respiratoires comme l'asthme, les infections et les allergies.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

    <div class="service-card">
        <img src="images/imagerie.jpg" alt="Radiologie">
        <div class="service-content">
            <h2>🩻 Imagerie & Radiologie</h2>
            <p class="price"><strong>40 000 FCFA</strong></p>
            <p>Radiographie, échographie, scanner et autres examens d'imagerie médicale.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

    <div class="service-card">
        <img src="images/gene.jpg" alt="Médecine Générale">
        <div class="service-content">
            <h2>🩺 Médecine Générale</h2>
            <p class="price"><strong>10 000 FCFA</strong></p>
            <p>Consultations médicales générales, prévention, diagnostic et orientation vers un spécialiste.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

    <div class="service-card">
        <img src="images/chirur.jpg" alt="Chirurgie Générale">
        <div class="service-content">
            <h2>🏥 Chirurgie Générale</h2>
            <p class="price"><strong>50 000 FCFA</strong></p>
            <p>Interventions chirurgicales courantes et suivi préopératoire et postopératoire.</p>
            <a href="rendez-vous.php" class="btn">Prendre rendez-vous</a>
        </div>
    </div>

</div>

<footer class="footer"  data-aos="fade-up">
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
        <li><a href="#">Accueil</a></li>
        <li><a href="#">Rendez-vous</a></li>

      </ul>
    </div>

    <div class="footer-section">
      <h3>Contact</h3>
      <p>📍 Pointe-Noire, Congo Brazzaville</p>
      <p>📞 <a href="tel:+242055756773">+242 05 575 6773</a></p>
      <p>📧 <a href="mailto:andrechebouetoussa@gmail.com">cliniqueguenin@gmail.com</a></p>
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
    <p>© 2026 Clinique Guenin | Tous droits réservés</p>
  </div>
</footer>
<script src="script.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({
    duration: 1000, // durée de l’animation en ms
    once: true, // l’animation se fait une seule fois
  });
</script>
</body>
</html>