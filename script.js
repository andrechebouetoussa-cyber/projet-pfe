/**
 * Menu hamburger mobile
 * Gère le toggle du menu sur mobile
 */
document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.querySelector('.menu-toggle');
  const menu = document.querySelector('.menu');

  if (menuToggle && menu) {
    menuToggle.addEventListener('click', function() {
      menuToggle.classList.toggle('active');
      menu.classList.toggle('active');
    });

    // Fermer le menu quand on clique sur un lien
    const menuLinks = menu.querySelectorAll('a');
    menuLinks.forEach(link => {
      link.addEventListener('click', function() {
        menuToggle.classList.remove('active');
        menu.classList.remove('active');
      });
    });

    // Fermer le menu en cliquant en dehors
    document.addEventListener('click', function(event) {
      const isClickInsideMenu = menu.contains(event.target);
      const isClickInsideToggle = menuToggle.contains(event.target);

      if (!isClickInsideMenu && !isClickInsideToggle) {
        menuToggle.classList.remove('active');
        menu.classList.remove('active');
      }
    });
  }
});


// =========================
// APPARITION AU SCROLL
// =========================

const hiddenElements = document.querySelectorAll(
".about, .stat-box, .service-card, .section1-card, .step, .box, .location"
);

hiddenElements.forEach((el,index)=>{

    el.classList.add("hidden");

    el.style.transitionDelay=`${index*0.12}s`;

});

const observer = new IntersectionObserver((entries)=>{

    entries.forEach(entry=>{

        if(entry.isIntersecting){

            entry.target.classList.add("show");

        }

    });

},{
    threshold:.15
});

hiddenElements.forEach(el=>observer.observe(el));


// =========================
// COMPTEUR ANIME
// =========================

const counters=document.querySelectorAll(".stat-box h2");

const counterObserver=new IntersectionObserver((entries)=>{

entries.forEach(entry=>{

if(entry.isIntersecting){

let counter=entry.target;

let text=counter.innerText;

let target=parseInt(text.replace(/\D/g,""));

let count=0;

let speed=Math.ceil(target/100);

let interval=setInterval(()=>{

count+=speed;

if(count>=target){

count=target;

clearInterval(interval);

}

if(text.includes("+")){

counter.innerHTML=count+"+";

}

else if(text.includes("/")){

counter.innerHTML=text;

}

else{

counter.innerHTML=count;

}

},20);

counterObserver.unobserve(counter);

}

});

});

counters.forEach(counter=>{

counterObserver.observe(counter);

});


// =========================
// EFFET SUR LES BOUTONS
// =========================

const buttons=document.querySelectorAll("button,.login-btn");

buttons.forEach(btn=>{

btn.addEventListener("mouseenter",()=>{

btn.style.boxShadow="0 12px 30px rgba(0,123,255,.35)";

});

btn.addEventListener("mouseleave",()=>{

btn.style.boxShadow="none";

});

});


// =========================
// NAVBAR AU SCROLL
// =========================

window.addEventListener("scroll",()=>{

const navbar=document.querySelector(".navbar");

if(window.scrollY>80){

navbar.classList.add("scroll");

}

else{

navbar.classList.remove("scroll");

}

});


// =========================
// EFFET SUR LES IMAGES
// =========================

const images=document.querySelectorAll(".section1-card img");

images.forEach(img=>{

img.addEventListener("mouseenter",()=>{

img.style.transform="scale(1.08)";

img.style.transition=".4s";

});

img.addEventListener("mouseleave",()=>{

img.style.transform="scale(1)";

});

});


// =========================
// CARTE GOOGLE
// =========================

const map=document.querySelector(".location iframe");

if(map){

map.addEventListener("mouseenter",()=>{

map.style.filter="brightness(105%)";

});

map.addEventListener("mouseleave",()=>{

map.style.filter="brightness(100%)";

});

}


// =========================
// SERVICES
// =========================

const cards=document.querySelectorAll(".service-card");

cards.forEach(card=>{

card.addEventListener("mouseenter",()=>{

card.style.background="#f5fbff";

});

card.addEventListener("mouseleave",()=>{

card.style.background="#fff";

});

});