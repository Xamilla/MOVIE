document.addEventListener("DOMContentLoaded", function () {
  const movieItems = document.querySelectorAll(".movie-item");

  movieItems.forEach((item) => {
    // Hover Effect (Temporary Expand)
    item.addEventListener("mouseenter", function () {
      if (!document.querySelector(".movie-item.active")) {
        this.style.transform = "scale(1.2)";
        this.style.zIndex = "10";
      }
    });

    item.addEventListener("mouseleave", function () {
      if (!this.classList.contains("active")) {
        this.style.transform = "scale(1)";
        this.style.zIndex = "1";
      }
    });

    // Click Effect (Expand Fully)
    item.addEventListener("click", function (event) {
      event.stopPropagation(); // Prevent event bubbling
      document
        .querySelectorAll(".movie-item")
        .forEach((m) => m.classList.remove("active")); // Close others
      this.classList.add("active");

      // Add a close button
      if (!this.querySelector(".close-btn")) {
        const closeBtn = document.createElement("button");
        closeBtn.innerHTML = "X";
        closeBtn.classList.add("close-btn");
        this.appendChild(closeBtn);

        closeBtn.addEventListener("click", function (e) {
          e.stopPropagation();
          item.classList.remove("active");
        });
      }
    });
  });

  // Click outside to close expanded movie
  document.addEventListener("click", function (e) {
    if (!e.target.closest(".movie-item.active")) {
      document
        .querySelectorAll(".movie-item")
        .forEach((m) => m.classList.remove("active"));
    }
  });
});
