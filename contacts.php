<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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

.contact{
    width:90%;
    margin:60px auto;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:50px;
}

h2{
    font-size:40px;
    margin-bottom:35px;
    color: #0a7c6d;
}

.cards{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:25px;
}

.card{
    background:#fff;
    border-radius:18px;
    padding:30px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    transition:.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.icon{
    width:60px;
    height:60px;
    background:#eef4ff;
    border-radius:15px;
    display:flex;
    justify-content:center;
    align-items:center;
    color:#2166c5;
    font-size:24px;
    margin-bottom:20px;
}

.card h3{
    color: #0a7c6d;
    margin-bottom:10px;
    font-size:22px;
}

.card p{
    margin-bottom:8px;
    font-size:22px;
}

.card span{
    color:#666;
}

.right form{
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.row{
    display:flex;
    gap:20px;
}

.input-box{
    display:flex;
    flex-direction:column;
    margin-bottom:20px;
    width:100%;
}

label{
    margin-bottom:10px;
    font-weight:600;
}

input,
textarea{
    padding:18px;
    border:1px solid #ddd;
    border-radius:12px;
    outline:none;
    font-size:16px;
}

textarea{
    resize:none;
    height:180px;
}

input:focus,
textarea:focus{
    border-color:#2166c5;
}

button{
    background: #0a7c6d;
    color:white;
    padding:16px 35px;
    border:none;
    border-radius:12px;
    font-size:17px;
    cursor:pointer;
}

button:hover{
    background:#184f99;
}

@media(max-width:900px){

.contact{
    grid-template-columns:1fr;
}

.cards{
    grid-template-columns:1fr;
}

.row{
    flex-direction:column;
}

}
/* Section localisation */
.location{
    max-width: 1100px;
    margin: 60px auto;
    padding: 40px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    text-align: center;
}

.location h2{
    font-size: 2rem;
    color: #0b5ed7;
    margin-bottom: 25px;
    position: relative;
}

.location h2::after{
    content: "";
    display: block;
    width: 80px;
    height: 4px;
    background: #0b5ed7;
    margin: 12px auto 0;
    border-radius: 10px;
}

.location iframe{
    width: 100%;
    height: 400px;
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
}

.location iframe:hover{
    transform: scale(1.02);
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
        <h1>Nous contacter</h1>
        <p>Vous avez des questions ou besoin d'aide ? N'hésitez pas à nous contacter.</p>
    </div>
</section>



<section class="contact"  data-aos="fade-up">

    <div class="left">

        <h2>Nos coordonnées</h2>

        <div class="cards">

            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-phone"></i>
                </div>

                <h3>Téléphone</h3>
                <p><strong>+242 05 575 6773</strong></p>
                <span>Urgences 24h/24</span>
            </div>

            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <h3>Email</h3>
                <p><strong>cliniqueguenin@gmail.com</strong></p>
                <span>Réponse sous 24h</span>
            </div>

            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>

                <h3>Adresse</h3>
                <p><strong>Avenue Agostino Neto</strong></p>
                <span>pointe-noire, congo</span>
            </div>

            <div class="card">
                <div class="icon">
                    <i class="fa-regular fa-clock"></i>
                </div>

                <h3>Horaires</h3>
                <p><strong>Ouvert 24h/24</strong></p>
                <span>7 jours sur 7</span>
            </div>

        </div>

    </div>

    <div class="right">

        <h2>Envoyez-nous un message</h2>

        <form>

            <div class="row">
                <div class="input-box">
                    <label>Nom complet</label>
                    <input type="text" placeholder="Votre nom">
                </div>

                <div class="input-box">
                    <label>Email</label>
                    <input type="email" placeholder="votre@email.com">
                </div>
            </div>

            <div class="input-box">
                <label>Sujet</label>
                <input type="text" placeholder="Objet de votre message">
            </div>

            <div class="input-box">
                <label>Message</label>
                <textarea placeholder="Écrivez votre message ici..."></textarea>
            </div>

            <button type="submit">Envoyer</button>

        </form>

    </div>

</section>


<section class="location"  data-aos="fade-up">
    <h2>📍 Nous localiser</h2>

    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d248.49178469195598!2d11.857755467459102!3d-4.7925994999999935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a60a533b2f5f79f%3A0x16f741646e05a972!2sClinique%20Gu%C3%A9nin!5e0!3m2!1sfr!2sma!4v1782303162640!5m2!1sfr!2sma"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="strict-origin-when-cross-origin">
    </iframe>
</section>
















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