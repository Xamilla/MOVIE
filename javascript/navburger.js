document.addEventListener("DOMContentLoaded", function () {
    const hamburgerIcon = document.querySelector(".hamburger-icon");
    const menuLinks = document.querySelector(".menu-links");
    const menuItems = document.querySelectorAll(".menu-links a");
  
    function toggleMenu() {
      menuLinks.classList.toggle("active");
      hamburgerIcon.classList.toggle("active"); // Animate the icon
    }
  
    if (hamburgerIcon && menuLinks) {
      hamburgerIcon.addEventListener("click", toggleMenu);
      if (menuItems.length > 0) {
        menuItems.forEach((item) => {
        });
      }
    }
    menuItems.forEach((item) => {
      item.addEventListener("click", toggleMenu);
    });
  
    window.addEventListener("resize", function () {
      if (window.innerWidth > 768) {
        menuLinks.classList.remove("active");
        hamburgerIcon.classList.remove("active"); // Reset icon state
      }
    });
  });
  