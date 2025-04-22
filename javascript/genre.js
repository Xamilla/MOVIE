document.addEventListener("DOMContentLoaded", function () {
  // Debugging: Set isAdminUser globally
  window.isAdminUser = false;
  function setAdminUser(isAdmin) {
    window.isAdminUser = isAdmin;
  }

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

  // Create quantity overlay if it doesn't exist
  let quantityOverlay = document.querySelector(".quantity-overlay");

  if (!quantityOverlay) {
    quantityOverlay = document.createElement("div");
    quantityOverlay.className = "quantity-overlay";
    quantityOverlay.innerHTML = `
      <div class="quantity-popup">
        <div class="quantity-header">
          <h3>Select Quantity</h3>
          <button class="close-quantity">&times;</button>
        </div>
        <div class="quantity-content">
          <p class="movie-title"></p>
          <div class="quantity-selector-popup">
            <label for="popup-quantity">Quantity:</label>
            <select id="popup-quantity">
              <option value="1">1</option>
            </select>
          </div>
          <div class="quantity-buttons">
            <button class="confirm-quantity">Confirm Purchase</button>
            <button class="cancel-quantity">Cancel</button>
          </div>
        </div>
      </div>
    `;
    document.body.appendChild(quantityOverlay);
  }

  // Get overlay elements
  const closeQuantityBtn = document.querySelector(".close-quantity");
  const cancelQuantityBtn = document.querySelector(".cancel-quantity");
  const confirmQuantityBtn = document.querySelector(".confirm-quantity");
  const popupQuantity = document.getElementById("popup-quantity");
  const movieTitleEl = document.querySelector(".movie-title");

  // Variables to store current movie data
  let currentMovieId;
  let currentForm;
  let currentMaxQuantity;
  let isBuyAgain = false;
  let returnPage = window.location.href; // Store current page for redirection

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
        const quantity = this.querySelector(".Qty-on-hand");
        const quantityText = quantity ? quantity.innerText : "0";
        const quantityValue = parseInt(quantityText.replace(/\D/g, ""));
        modalQuantity.innerText = quantityValue;

        // Get summary
        const summary = this.querySelector(".summary");
        modalSummary.innerText =
          summary && summary.innerText
            ? summary.innerText
            : "No summary available for this movie.";

        // Clear previous action buttons
        modalActionButton.innerHTML = "";

        // Check if user is admin and add admin buttons if needed
        if (typeof window.isAdminUser !== "undefined" && window.isAdminUser) {
          const movieId = this.querySelector("input[name='movie_id']")?.value;

          if (movieId) {
            // Create update button
            const updateBtn = document.createElement("button");
            updateBtn.classList.add("update-btn");
            updateBtn.textContent = "Update";
            updateBtn.addEventListener("click", function () {
              const form = document.createElement("form");
              form.method = "POST";
              form.action = "../MOVIE/crud/crud.php";

              const movieIdInput = document.createElement("input");
              movieIdInput.type = "hidden";
              movieIdInput.name = "movie_id";
              movieIdInput.value = movieId;

              const updateInput = document.createElement("input");
              updateInput.type = "hidden";
              updateInput.name = "update";
              updateInput.value = "1";

              form.appendChild(movieIdInput);
              form.appendChild(updateInput);
              document.body.appendChild(form);
              form.submit();
            });

            // Create delete button
            const deleteBtn = document.createElement("button");
            deleteBtn.classList.add("delete-btn");
            deleteBtn.textContent = "Delete";
            deleteBtn.addEventListener("click", function () {
              if (confirm("Are you sure you want to delete this movie?")) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "../MOVIE/crud/crud.php";

                const movieIdInput = document.createElement("input");
                movieIdInput.type = "hidden";
                movieIdInput.name = "movie_id";
                movieIdInput.value = movieId;

                const deleteInput = document.createElement("input");
                deleteInput.type = "hidden";
                deleteInput.name = "delete";
                deleteInput.value = "1";

                form.appendChild(movieIdInput);
                form.appendChild(deleteInput);
                document.body.appendChild(form);
                form.submit();
              }
            });

            // Append buttons to action buttons container
            modalActionButton.appendChild(updateBtn);
            modalActionButton.appendChild(deleteBtn);
          }
        } else {
          // Handle regular user interface

          // Check for various button types in the movie item
          const watchBtn = this.querySelector(".watch-btn");
          const buyBtn = this.querySelector(".buy-btn");
          const loginBtn = this.querySelector(".login-required-btn");
          const outOfStockBtn = this.querySelector(".out-of-stock-btn");
          const buyAgainBtn = this.querySelector(".buy-again-btn");

          let actionButtonHTML = "";

          if (watchBtn) {
            // User is logged in and already purchased this movie
            const movieId = watchBtn.href.split("=")[1];
            actionButtonHTML = `<a href="watch.php?movie_id=${movieId}" class="watch-btn">Watch Now</a>`;

            // Add buy again button if available and quantity > 0
            if (buyAgainBtn && quantityValue > 0) {
              const movieId = this.querySelector(
                "input[name='movie_id']"
              ).value;
              actionButtonHTML += `<button class="buy-again-btn" data-movie-id="${movieId}" data-movie-name="${
                this.querySelector("h2").innerText
              }" data-max-qty="${quantityValue}">Buy Again</button>`;
            }
          } else if (buyBtn) {
            // User is logged in but hasn't purchased this movie
            const movieId = this.querySelector("input[name='movie_id']").value;
            actionButtonHTML = `<button class="buy-btn" data-movie-id="${movieId}" data-movie-name="${
              this.querySelector("h2").innerText
            }" data-max-qty="${quantityValue}">Buy Now</button>`;
          } else if (loginBtn) {
            // User is not logged in
            actionButtonHTML = `<a href="?page=login" class="login-required-btn">Buy Now</a>`;
          } else if (outOfStockBtn || quantityValue <= 0) {
            // Out of stock
            actionButtonHTML = `<button disabled class="out-of-stock-btn">Out of Stock</button>`;
          }

          modalActionButton.innerHTML = actionButtonHTML;
        }

        // Attach event listeners to new modal buttons
        setupModalButtons();
      });
    });
  }

  // Setup event listeners for modal buy buttons
  function setupModalButtons() {
    if (modalActionButton) {
      const buyBtn = modalActionButton.querySelector(".buy-btn");
      if (buyBtn && !buyBtn.hasAttribute("data-listener")) {
        buyBtn.setAttribute("data-listener", "true");
        buyBtn.addEventListener("click", function (e) {
          e.preventDefault();
          const movieId = this.getAttribute("data-movie-id");
          const movieName = this.getAttribute("data-movie-name");
          const maxQty = parseInt(this.getAttribute("data-max-qty"));

          // Create a temporary form
          const tempForm = document.createElement("form");
          tempForm.method = "POST";
          tempForm.action = "../MOVIE/crud/buy_movie.php";
          tempForm.innerHTML = `<input type="hidden" name="movie_id" value="${movieId}">`;

          showQuantityOverlay(movieId, movieName, tempForm, maxQty, false);
          modal.style.display = "none";
        });
      }

      const buyAgainBtn = modalActionButton.querySelector(".buy-again-btn");
      if (buyAgainBtn && !buyAgainBtn.hasAttribute("data-listener")) {
        buyAgainBtn.setAttribute("data-listener", "true");
        buyAgainBtn.addEventListener("click", function (e) {
          e.preventDefault();
          const movieId = this.getAttribute("data-movie-id");
          const movieName = this.getAttribute("data-movie-name");
          const maxQty = parseInt(this.getAttribute("data-max-qty"));

          // Create a temporary form
          const tempForm = document.createElement("form");
          tempForm.method = "POST";
          tempForm.action = "../MOVIE/crud/buy_movie.php";
          tempForm.innerHTML = `<input type="hidden" name="movie_id" value="${movieId}">`;

          showQuantityOverlay(movieId, movieName, tempForm, maxQty, true);
          modal.style.display = "none";
        });
      }
    }
  }

  // Function to setup grid buttons
  function setupGridButtons() {
    // For buy now buttons in grid
    document.querySelectorAll(".movie-item .buy-btn").forEach((btn) => {
      if (!btn.hasAttribute("data-listener")) {
        btn.setAttribute("data-listener", "true");
        btn.addEventListener("click", function (e) {
          e.preventDefault();
          e.stopPropagation(); // Stop event from bubbling up to movie-item

          const form = this.closest("form");
          const movieId = form.querySelector("input[name='movie_id']").value;
          const movieItem = this.closest(".movie-item");
          const movieName = movieItem.querySelector("h2").textContent;

          // Extract quantity and properly parse it
          const quantityEl = movieItem.querySelector(".Qty-on-hand");
          const quantityText = quantityEl ? quantityEl.textContent : "0";
          const maxQty = parseInt(quantityText.replace(/\D/g, ""));

          showQuantityOverlay(movieId, movieName, form, maxQty, false);
        });
      }
    });

    // For buy again buttons in grid
    document.querySelectorAll(".movie-item .buy-again-btn").forEach((btn) => {
      if (!btn.hasAttribute("data-listener")) {
        btn.setAttribute("data-listener", "true");
        btn.addEventListener("click", function (e) {
          e.preventDefault();
          e.stopPropagation(); // Stop event from bubbling up to movie-item

          const form = this.closest("form");
          const movieId = form.querySelector("input[name='movie_id']").value;
          const movieItem = this.closest(".movie-item");
          const movieName = movieItem.querySelector("h2").textContent;

          // Extract quantity and properly parse it
          const quantityEl = movieItem.querySelector(".Qty-on-hand");
          const quantityText = quantityEl ? quantityEl.textContent : "0";
          const maxQty = parseInt(quantityText.replace(/\D/g, ""));

          showQuantityOverlay(movieId, movieName, form, maxQty, true);
        });
      }
    });
  }

  // Function to show quantity overlay
  function showQuantityOverlay(
    movieId,
    movieName,
    form,
    maxQuantity,
    buyAgain
  ) {
    currentMovieId = movieId;
    currentForm = form;
    currentMaxQuantity = Math.min(maxQuantity || 1, 5); // Limit to 5 or max available, default to 1 if maxQuantity is invalid
    isBuyAgain = buyAgain;

    // Update movie title in popup
    movieTitleEl.textContent = movieName;

    // Update quantity options
    popupQuantity.innerHTML = "";
    for (let i = 1; i <= currentMaxQuantity; i++) {
      const option = document.createElement("option");
      option.value = i;
      option.textContent = i;
      popupQuantity.appendChild(option);
    }

    // Show overlay
    quantityOverlay.classList.add("active");

    // For debugging
    console.log(
      "Showing quantity overlay for:",
      movieName,
      "Max quantity:",
      currentMaxQuantity
    );
  }

  // Function to close quantity overlay
  function closeQuantityOverlay() {
    quantityOverlay.classList.remove("active");
  }

  // Confirm purchase button click
  confirmQuantityBtn.addEventListener("click", function () {
    // Get selected quantity
    const quantity = popupQuantity.value;

    // Create a new hidden input for quantity if it doesn't exist
    let quantityInput = currentForm.querySelector("input[name='quantity']");
    if (!quantityInput) {
      quantityInput = document.createElement("input");
      quantityInput.type = "hidden";
      quantityInput.name = "quantity"; // Changed from 'Qty-on-hand' to 'quantity'
      currentForm.appendChild(quantityInput);
    }

    // Set the quantity value
    quantityInput.value = quantity;

    // Add a hidden input for the return page
    let returnInput = currentForm.querySelector("input[name='return_page']");
    if (!returnInput) {
      returnInput = document.createElement("input");
      returnInput.type = "hidden";
      returnInput.name = "return_page";
      returnInput.value = returnPage; // Use stored return page URL
      currentForm.appendChild(returnInput);
    }

    console.log("Submitting form with quantity:", quantity);

    // Submit the form
    document.body.appendChild(currentForm);
    currentForm.submit();

    // Close overlay
    closeQuantityOverlay();
  });

  // Close overlay event listeners
  closeQuantityBtn.addEventListener("click", closeQuantityOverlay);
  cancelQuantityBtn.addEventListener("click", closeQuantityOverlay);

  // Close when clicking outside
  quantityOverlay.addEventListener("click", function (e) {
    if (e.target === quantityOverlay) {
      closeQuantityOverlay();
    }
  });

  // Close modal events
  if (closeModal) {
    closeModal.addEventListener("click", function () {
      modal.style.display = "none";
    });
  }

  window.addEventListener("click", function (e) {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });

  // Auto-hide message elements after a delay (for success/error messages)
  function setupMessageAutoHide() {
    const messageElements = document.querySelectorAll(
      ".success-message, .error-message"
    );

    messageElements.forEach(function (element) {
      setTimeout(function () {
        element.style.opacity = "0";
        setTimeout(function () {
          element.style.display = "none";
        }, 500);
      }, 5000);
    });
  }

  // Initial setup
  setupMovieItemListeners();
  setupGridButtons();
  setupMessageAutoHide();

  // For dynamic content loading (if you use AJAX to load more movies)
  document.addEventListener("DOMNodeInserted", function (e) {
    if (e.target.classList && e.target.classList.contains("movie-item")) {
      setupMovieItemListeners();
      setupGridButtons();
    }

    if (
      e.target.classList &&
      (e.target.classList.contains("success-message") ||
        e.target.classList.contains("error-message"))
    ) {
      setupMessageAutoHide();
    }
  });
});
