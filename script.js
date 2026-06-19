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
