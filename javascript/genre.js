document.addEventListener("DOMContentLoaded", function () {
  // Debug the admin status at startup
  console.log("Initial admin status check:", window.isAdminUser);

  // Get existing modal elements
  const movieItems = document.querySelectorAll(".movie-item");
  const modal = document.getElementById("movieModal");
  const modalImage = document.getElementById("modalImage");
  const modalTitle = document.getElementById("modalTitle");
  const modalCast = document.getElementById("modalCast");
  const modalRelease = document.getElementById("modalRelease");
  const modalDuration = document.getElementById("modalDuration");
  const modalPrice = document.getElementById("modalPrice");
  const modalDirector = document.getElementById("modalDirector");
  const modalQuantity = document.getElementById("modalQuantity");
  const modalSummary = document.getElementById("modalSummary");
  const closeModal = document.getElementById("closeModal");
  const modalActionButton = document.getElementById("modalActionButtons");

  // Function to setup movie item listeners
  function setupMovieItemListeners() {
    movieItems.forEach((item) => {
      item.addEventListener("click", function (e) {
        // Skip if clicking on form elements
        if (
          e.target.tagName === "BUTTON" ||
          e.target.tagName === "A" ||
          e.target.tagName === "SELECT" ||
          e.target.tagName === "LABEL" ||
          e.target.closest("form")
        ) {
          return;
        }

        // Display modal
        modal.style.display = "flex";

        // Set image source
        modalImage.src = this.querySelector("img").src;

        // Set movie title
        modalTitle.innerText = this.querySelector("h2").innerText;

        // Handle details with specific formatting
        const releaseDate = this.querySelector(".release-date");
        modalRelease.innerText = releaseDate
          ? releaseDate.innerText.replace("Release-Date:", "").trim()
          : "Not available";

        const cast = this.querySelector(".cast");
        modalCast.innerText = cast
          ? cast.innerText.replace("Cast:", "").trim()
          : "Cast not available";

        const duration = this.querySelector(".duration");
        modalDuration.innerText = duration
          ? duration.innerText.replace("Duration:", "").trim()
          : "Not specified";

        const price = this.querySelector(".price");
        modalPrice.innerText = price
          ? price.innerText.replace("Price:", "").trim()
          : "Price not set";

        const director = this.querySelector(".director");
        modalDirector.innerText = director
          ? director.innerText.replace("Director:", "").trim()
          : "Not specified";

        // Get quantity and properly parse it
        // Current problematic code
        const quantity = this.querySelector(".Qty-on-hand");
        if (quantity && quantity.innerHTML.includes("Out of Stock")) {
          modalQuantity.innerHTML = '<span class="out-of-stock">Out of Stock</span>';
        } else if (quantity) {
          modalQuantity.innerHTML = '<span class="in-stock">' + quantity.innerText.trim() + '</span>';
        } else {
          modalQuantity.innerHTML = '<span class="out-of-stock">Out of Stock</span>';
        }
        
        // Get summary
        const summary = this.querySelector(".summary");
        modalSummary.innerText =
          summary && summary.innerText
            ? summary.innerText
            : "No summary available for this movie.";

        // Clear previous action buttons
        modalActionButton.innerHTML = "";

        // Log admin status in console for debugging
        console.log(
          "Admin check before modal button creation:",
          window.isAdminUser
        );

        // Check if user is admin and add admin buttons if needed
        if (window.isAdminUser === true) {
          console.log("Admin user detected, creating admin buttons");

          const movieId = this.querySelector("input[name='movie_id']")?.value;

          if (movieId) {
            // Create update button form
            const updateForm = document.createElement("form");
            updateForm.method = "POST";
            updateForm.action = "?page=update";
            updateForm.className = "update-form";

            const updateInput = document.createElement("input");
            updateInput.type = "hidden";
            updateInput.name = "movie_id";
            updateInput.value = movieId;

            const updateBtn = document.createElement("button");
            updateBtn.type = "submit";
            updateBtn.className = "modal-update-btn";
            updateBtn.innerText = "Update";

            updateForm.appendChild(updateInput);
            updateForm.appendChild(updateBtn);

            // Create delete button form
            const deleteForm = document.createElement("form");
            deleteForm.method = "POST";
            deleteForm.action = "?page=delete";
            deleteForm.className = "delete-form";

            const deleteIdInput = document.createElement("input");
            deleteIdInput.type = "hidden";
            deleteIdInput.name = "movie_id";
            deleteIdInput.value = movieId;

            const deleteActionInput = document.createElement("input");
            deleteActionInput.type = "hidden";
            deleteActionInput.name = "delete";
            deleteActionInput.value = "true";

            const deleteBtn = document.createElement("button");
            deleteBtn.type = "submit";
            deleteBtn.className = "modal-delete-btn";
            deleteBtn.innerText = "Delete";

            deleteForm.appendChild(deleteIdInput);
            deleteForm.appendChild(deleteActionInput);
            deleteForm.appendChild(deleteBtn);

            // Append both forms to modal action button area
            modalActionButton.appendChild(updateForm);
            modalActionButton.appendChild(deleteForm);
          }
        }
      });
    });
  }

  // Close modal functionality
  closeModal.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Setup listeners
  setupMovieItemListeners();
});
function openDeleteOverlay(movieId, movieName) {
  document.getElementById("movieToDeleteId").value = movieId;
  document.getElementById("movieToDeleteName").textContent = movieName;
  document.getElementById("deleteOverlay").style.display = "flex";
}

function closeDeleteOverlay() {
  document.getElementById("deleteOverlay").style.display = "none";
}
