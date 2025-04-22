function showUserInfo() {
  const modal = document.getElementById("user-info-modal");
  modal.style.display = "flex";
}

function closeUserInfo() {
  document.getElementById("user-info-modal").style.display = "none";
}

document.addEventListener("click", function (event) {
  const modal = document.getElementById("user-info-modal");
  const userAvatar = document.querySelector(".user-avatar");

  if (
    modal.style.display === "flex" &&
    !modal.contains(event.target) &&
    !userAvatar.contains(event.target)
  ) {
    closeUserInfo();
  }
});
// Mobile Menu Functions
function toggleMobileMenu() {
  const hamburgerIcon = document.querySelector(".hamburger-icon");
  const mobileMenu = document.querySelector(".mobile-menu");

  hamburgerIcon.classList.toggle("active");
  mobileMenu.classList.toggle("active");
}

// Close mobile menu when clicking outside
document.addEventListener("click", function (event) {
  const mobileMenu = document.querySelector(".mobile-menu");
  const hamburgerIcon = document.querySelector(".hamburger-icon");

  if (
    mobileMenu &&
    mobileMenu.classList.contains("active") &&
    !mobileMenu.contains(event.target) &&
    !hamburgerIcon.contains(event.target)
  ) {
    mobileMenu.classList.remove("active");
    hamburgerIcon.classList.remove("active");
  }
});

// Close mobile menu when window resizes above mobile breakpoint
window.addEventListener("resize", function () {
  if (window.innerWidth > 768) {
    const mobileMenu = document.querySelector(".mobile-menu");
    const hamburgerIcon = document.querySelector(".hamburger-icon");

    if (mobileMenu && mobileMenu.classList.contains("active")) {
      mobileMenu.classList.remove("active");
      hamburgerIcon.classList.remove("active");
    }
  }
});

// Add scroll event for navbar background effect
window.addEventListener("scroll", function () {
  const navbar = document.getElementById("desktop-nav");
  if (window.scrollY > 50) {
    navbar.classList.add("navbar-blur");
  } else {
    navbar.classList.remove("navbar-blur");
  }
});
