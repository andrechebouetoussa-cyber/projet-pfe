<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link rel="stylesheet" href="style.css">
<style>.slider{
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}

.slide{
    position: absolute;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0;

    animation: slideAnimation 15s infinite;
}

.slide:nth-child(1){
    animation-delay: 0s;
}

.slide:nth-child(2){
    animation-delay: 5s;
}

.slide:nth-child(3){
    animation-delay: 10s;
}

@keyframes slideAnimation {
    0% { opacity: 0; }
    10% { opacity: 1; }
    33% { opacity: 1; }
    43% { opacity: 0; }
    100% { opacity: 0; }
}</style>

</head>
<body>
    <nav class="navbar">
    <div class="logo-container">
        <img src="images/logo.png" alt="Clinique Atlas Care" class="logo">
        <span class="logo-text">Clinique Atlas Care</span>
    </div>

    <ul class="menu">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="Rendez-vous.php">Rendez-vous</a></li>
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


<div class="slider">
  <div class="slide" style="background-image: url('images/im1.jpg');"></div>
  <div class="slide" style="background-image: url('images/im2.jpg');"></div>
  <div class="slide" style="background-image: url('images/im3.jpg');"></div>

  <div class="slider-text">
    <h1>Clinique ATlas Care, votre santé, au coeur de l'innovation</h1>
    <p>Réservez vos consultations en ligne avec nos spécialistes en quelques clics.</p>
      <a href="rendez-vous.php" class="login-btn">Prendre rendez-vous</a>
  </div>
</div>


<section class="about">
<div class="about-container">
    <div class="about-text">
        <h2>À propos de nous</h2>
    <p> <strong> La Clinique Atlas Care</strong>,un établissement médical privé dédié à offrir des soins de qualité à tous nos patients.
Nous mettons à disposition une équipe de médecins qualifiés et expérimentés dans plusieurs spécialités médicales.
Notre objectif est d’assurer un suivi personnalisé et un service rapide grâce à une organisation moderne et efficace.       
 </p>
    
    </div>
      <div class="about-image">
        <!-- Image about section -->
           <img src="images/logo.png" >
      </div>
</div>
</section>

<h1>Nos Services Médicaux</h1>

    <div class="services-container">

        <div class="service-card">
            <h2>🦷 Dentisterie</h2>
            <p>Soins dentaires complets : détartrage, caries, blanchiment et orthodontie.</p>
            <button onclick="location.href='rendez-vous.php'">Prendre rendez-vous</button>
        </div>

        <div class="service-card">
            <h2>❤️ Cardiologie</h2>
            <p>Diagnostic et suivi des maladies du cœur avec équipements modernes.</p>
            <button onclick="location.href='rendez-vous.php'">Prendre rendez-vous</button>
        </div>

        <div class="service-card">
            <h2>👶 Pédiatrie</h2>
            <p>Suivi médical des enfants, vaccinations et consultations spécialisées.</p>
            <button onclick="location.href='rendez-vous.php'">Prendre rendez-vous</button>
        </div>

        <div class="service-card">
            <h2>🧠 Neurologie</h2>
            <p>Prise en charge des troubles du système nerveux.</p>
            <button onclick="location.href='rendez-vous.php'">Prendre rendez-vous</button>
        </div>

<div class="service-card">
    <h2>👩‍⚕️ Gynécologie</h2>
    <p>Suivi de la santé féminine, grossesse, consultations et dépistages.</p>
    <button onclick="location.href='rendez-vous.php'">Prendre rendez-vous</button>
</div>

<div class="service-card">
    <h2>🫁 Pneumologie</h2>
    <p>Diagnostic et traitement des maladies respiratoires (asthme, infections, etc.).</p>
    <button onclick="location.href='rendez-vous.php'">Prendre rendez-vous</button>
</div>

<div class="service-card">
    <h2>🩻 Imagerie & Radiologie</h2>
    <p>Examens médicaux : radiographie, échographie et imagerie avancée.</p>
    <button onclick="location.href='rendez-vous.php'">Prendre rendez-vous</button>
</div>

<div class="service-card">
    <h2>🩺 Médecine Générale</h2>
    <p>Consultations générales, diagnostic initial et orientation vers spécialistes.</p>
    <button onclick="location.href='rrendez-vous.php'">Prendre rendez-vous</button>
</div>

<div class="service-card">
    <h2>🏥 Chirurgie Générale</h2>
    <p>Interventions chirurgicales courantes : appendicite, hernies, chirurgie digestive et soins post-opératoires.</p>
    <button onclick="location.href='rendez-vous.php'">
        Prendre rendez-vous
    </button>
</div>

    </div>

       <a href="rendez-vous.php" class="login-btn">Prendre rendez-vous</a>


<section class="section1">
  <h2>Nos Spécialistes</h2>

  <p>
    <strong>La Clinique Atlas Care</strong> met à votre disposition une équipe de medecins spécialistes, expérimentés dans le domaine.
  </p>

  <div class="section1-grid">

  <div class="section1-card">
  <img src="images/BB.jpg" alt="Dr Ahmed">
  <h3>Dr Ahmed amine</h3>
  <p>Service de Pédiatrie</p>
</div>

  <div class="section1-card">
  <img src="images/FEMME.png" alt="Dr Sagesse">
  <h3>Dr Sagesse MALAL</h3>
  <p> Service de Cardiologie</p>
</div>


  <div class="section1-card">
  <img src="images/FEMME.png" alt="Dr Divine">
  <h3>Dr Divine MOUNIAKA</h3>
  <p>Service de Gynécologie</p>
</div>


  <div class="section1-card">
  <img src="images/general.jpg" alt="Dr Andreche">
  <h3>Dr Andreche BOUETOUSSA</h3>
  <p>Service de Médecine Géneral</p>
</div>

<div class="section1-card">
  <img src="images/general.jpg" alt="Dr Murda">
  <h3>Dr Murda ELENGA</h3>
  <p>Service de Dentisterie</p>
</div>


  <div class="section1-card">
  <img src="images/FEMME.png" alt="Dr Sanctifiée">
  <h3>Dr Sanctifiée el MOUHAMMED</h3>
  <p>Service de Pneumologie</p>
</div>


  <div class="section1-card">
  <img src="images/general.jpg" alt="Dr Emma">
  <h3>Dr Andreche Emma</h3>
  <p>Service de Chirurgie Génerale</p>
</div>


  <div class="section1-card">
  <img src="images/general.jpg" alt="Dr Grâce">
  <h3>Dr Cherina Grâce</h3>
  <p>Service de Neurologie</p>
</div>

  <div class="section1-card">
  <img src="images/HOMME.jpg" alt="Dr Ahmed">
  <h3>Dr Japhet ABDOULKARIM</h3>
  <p>Service de Traumatologie-Orthopedie</p>
</div>

<div class="section1-card">
  <img src="images/HOMME.jpg" alt="Dr Ahmed">
  <h3>Dr SAID </h3>
  <p>Service de Radiologie-Imagerie Médicales</p>
</div>
    </div>
 </section>   

       <a href="rendez-vous.php" class="login-btn">Prendre rendez-vous</a>


<section class="fonction">
  <h2>Comment ça marche ?</h2>

  <div class="steps">

    <div class="step">
      <h3>1. Créer un compte</h3>
      <p>Inscrivez-vous rapidement afin de voir nos services.</p>
    </div>

    <div class="step">
      <h3>2. Choisir un médecin</h3>
      <p>décrire votre problème et sélectionnez la spécialité ou le médecin adapté.</p>
    </div>

    <div class="step">
      <h3>3. Prendre rendez-vous</h3>
      <p>Choisissez une date et confirmez votre réservation.</p>
    </div>

    <div class="step">
      <h3>4. Consultation</h3>
      <p>Rendez-vous à la clinique pour votre consultation.</p>
    </div>
  </div>
</section>



<section class="contact-container">

  <!-- Coordonnées -->
  <div class="box">
    <h2>Nos coordonnées</h2>
    <p><strong>Adresse :</strong> pointe-noire, congo</p>
    <p><strong>Téléphone :</strong> +212 635 766 873</p>
    <p><strong>Email :</strong> andrechebouetouss@gmail.com</p>
  </div>

  <!-- Horaires -->
  <div class="box">
    <h2>Horaires</h2>
    <p>24heures/24</p>
    <p>7J/7</p>
  </div>

  <!-- Formulaire -->
  <div class="box">
    <h2>Envoyez-nous un message</h2>

    <form action="contact.php" method="POST">
      <input type="text" name="nom" placeholder="Votre nom" required>
      <input type="email" name="email" placeholder="Votre email" required>
      <input type="tel" name="tel" placeholder="Téléphone">
      <textarea name="message" placeholder="Votre message..." required></textarea>
      <button type="submit">Envoyer</button>
    </form>
  </div>

</section>

 <!-- Carte Google Maps -->
    <section>
        <h2>Nous localiser</h2>
        <iframe 
            src="https://www.google.com/maps?q=pointe-noire&output=embed"
            width="100%" 
            height="300" 
            style="border:0;">
        </iframe>
    </section>







<footer class="footer">
  <div class="footer-container">

    <div class="footer-section">
      <h2>Clinique Atlas Care</h2>
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
</body>
</html>
<script src="script.js"></script>
