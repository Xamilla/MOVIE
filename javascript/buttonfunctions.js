// Movie Buy Button Functionality
document.addEventListener("DOMContentLoaded", function () {
  // Get all "Buy Now" buttons
  const buyButtons = document.querySelectorAll(
    ".movie-item .movie-buttons button"
  );
  const modalBuyButton = document.querySelector(".modal-buttons button");

  // Add click event to all buy buttons
  buyButtons.forEach((button) => {
    button.addEventListener("click", handleBuyButtonClick);
  });

  // Add click event to modal buy button if it exists
  if (modalBuyButton) {
    modalBuyButton.addEventListener("click", handleModalBuyButtonClick);
  }

  // Function to handle buy button click on movie cards
  function handleBuyButtonClick(e) {
    const movieItem = e.target.closest(".movie-item");
    const movieId = movieItem.getAttribute("data-movie-id");
    const movieName = movieItem.querySelector(".movie-title").textContent;

    processPurchase(movieId, movieName, e.target);
  }

  // Function to handle buy button click in modal
  function handleModalBuyButtonClick() {
    const modalTitle = document.getElementById("modalTitle").textContent;
    const movieId = document
      .getElementById("modalImage")
      .getAttribute("data-movie-id");

    processPurchase(movieId, modalTitle, modalBuyButton);
  }

  // Function to process the purchase
  function processPurchase(movieId, movieName, buttonElement) {
    // Check if user is logged in
    checkLoginStatus()
      .then((isLoggedIn) => {
        if (isLoggedIn) {
          // Process the purchase with AJAX
          return purchaseMovie(movieId);
        } else {
          // Redirect to login page
          showLoginPrompt();
          return Promise.reject("Not logged in");
        }
      })
      .then((response) => {
        if (response.success) {
          // Show success message
          showSuccessMessage(movieName);

          // Update quantity displayed on the page
          updateQuantityDisplay(movieId, response.newQuantity);

          // Convert button to "Play Now"
          convertToPLayButton(buttonElement, movieId);

          // If this was triggered from a movie card, also update the modal if it's open
          const openModal = document.getElementById("movieModal");
          if (openModal && openModal.style.display === "block") {
            const modalButton = openModal.querySelector(
              ".modal-buttons button"
            );
            convertToPLayButton(modalButton, movieId);
          }
        } else {
          // Show error message
          showErrorMessage(response.message || "Failed to complete purchase");
        }
      })
      .catch((error) => {
        if (error !== "Not logged in") {
          showErrorMessage("An error occurred. Please try again.");
          console.error("Purchase error:", error);
        }
      });
  }

  // Function to check if user is logged in
  function checkLoginStatus() {
    return new Promise((resolve) => {
      // Use AJAX to check login status on the server
      fetch("check_login_status.php")
        .then((response) => response.json())
        .then((data) => {
          resolve(data.isLoggedIn);
        })
        .catch(() => {
          // In case of error, assume not logged in
          resolve(false);
        });
    });
  }

  // Function to show login prompt
  function showLoginPrompt() {
    // Store current page URL to redirect back after login
    sessionStorage.setItem("redirectAfterLogin", window.location.href);

    // Redirect to login page
    window.location.href = "login.php";
  }

  // Function to purchase movie via AJAX
  function purchaseMovie(movieId) {
    return new Promise((resolve) => {
      // Create form data
      const formData = new FormData();
      formData.append("movie_id", movieId);
      formData.append("action", "purchase");

      // Send purchase request to server
      fetch("process_purchase.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          resolve(data);
        })
        .catch((error) => {
          console.error("Purchase request error:", error);
          resolve({ success: false, message: "Network error" });
        });
    });
  }

  // Function to show success message
  function showSuccessMessage(movieName) {
    // Create message element
    const messageElement = document.createElement("div");
    messageElement.className = "success-message";
    messageElement.textContent = `Successfully purchased "${movieName}"!`;
    messageElement.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 10000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        `;

    // Add to body
    document.body.appendChild(messageElement);

    // Remove after 3 seconds
    setTimeout(() => {
      messageElement.style.opacity = "0";
      messageElement.style.transition = "opacity 0.5s";
      setTimeout(() => {
        document.body.removeChild(messageElement);
      }, 500);
    }, 3000);
  }

  // Function to show error message
  function showErrorMessage(message) {
    // Create message element
    const messageElement = document.createElement("div");
    messageElement.className = "error-message";
    messageElement.textContent = message;
    messageElement.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #F44336;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 10000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        `;

    // Add to body
    document.body.appendChild(messageElement);

    // Remove after 3 seconds
    setTimeout(() => {
      messageElement.style.opacity = "0";
      messageElement.style.transition = "opacity 0.5s";
      setTimeout(() => {
        document.body.removeChild(messageElement);
      }, 500);
    }, 3000);
  }

  // Function to update quantity display
  function updateQuantityDisplay(movieId, newQuantity) {
    // Update in movie card
    const movieCards = document.querySelectorAll(
      `.movie-item[data-movie-id="${movieId}"]`
    );
    movieCards.forEach((card) => {
      const quantityElement = card.querySelector(".movie-quantity");
      if (quantityElement) {
        quantityElement.textContent = `Quantity: ${newQuantity}`;
      }
    });

    // Update in modal if open
    const modalQuantity = document.getElementById("modalQuantity");
    if (modalQuantity) {
      modalQuantity.textContent = `Quantity: ${newQuantity}`;
    }
  }

  // Function to convert Buy button to Play button
  function convertToPLayButton(buttonElement, movieId) {
    if (!buttonElement) return;

    // Change button text and style
    buttonElement.textContent = "Play Now";
    buttonElement.classList.add("play-button");
    buttonElement.classList.remove("buy-button");

    // Remove old event listeners by cloning the node
    const newButton = buttonElement.cloneNode(true);
    buttonElement.parentNode.replaceChild(newButton, buttonElement);

    // Add new event listener for play functionality
    newButton.addEventListener("click", function () {
      playMovie(movieId);
    });
  }

  // Function to play movie
  function playMovie(movieId) {
    // Find the movie container
    const movieContainer = document.querySelector(
      `.movie-item[data-movie-id="${movieId}"]`
    );
    const modalImage = document.getElementById("modalImage");

    if (movieContainer) {
      // Replace image with video in movie card
      const imageElement = movieContainer.querySelector(".movie-image img");
      if (imageElement) {
        const videoElement = createVideoPlayer(movieId);
        imageElement.parentNode.replaceChild(videoElement, imageElement);
      }
    }

    // If modal is open, also replace image with video there
    if (modalImage && modalImage.getAttribute("data-movie-id") === movieId) {
      const videoElement = createVideoPlayer(movieId);
      modalImage.parentNode.replaceChild(videoElement, modalImage);
    }
  }

  // Function to create video player
  function createVideoPlayer(movieId) {
    const videoElement = document.createElement("video");
    videoElement.className = "movie-video";
    videoElement.controls = true;
    videoElement.autoplay = true;
    videoElement.style.width = "100%";
    videoElement.style.height = "100%";
    videoElement.style.objectFit = "cover";

    // Set video source (you'll need to provide the actual video path)
    const videoSource = document.createElement("source");
    videoSource.src = `videos/movie_${movieId}.mp4`; // Adjust path as needed
    videoSource.type = "video/mp4";

    videoElement.appendChild(videoSource);

    // Add fallback content
    const fallbackText = document.createElement("p");
    fallbackText.textContent = "Your browser does not support HTML video.";
    videoElement.appendChild(fallbackText);

    return videoElement;
  }
}); // Movie Buy Button Functionality
document.addEventListener("DOMContentLoaded", function () {
  // Get all "Buy Now" buttons
  const buyButtons = document.querySelectorAll(
    ".movie-item .movie-buttons button"
  );
  const modalBuyButton = document.querySelector(".modal-buttons button");

  // Add click event to all buy buttons
  buyButtons.forEach((button) => {
    button.addEventListener("click", handleBuyButtonClick);
  });

  // Add click event to modal buy button if it exists
  if (modalBuyButton) {
    modalBuyButton.addEventListener("click", handleModalBuyButtonClick);
  }

  // Function to handle buy button click on movie cards
  function handleBuyButtonClick(e) {
    const movieItem = e.target.closest(".movie-item");
    const movieId = movieItem.getAttribute("data-movie-id");
    const movieName = movieItem.querySelector(".movie-title").textContent;

    processPurchase(movieId, movieName, e.target);
  }

  // Function to handle buy button click in modal
  function handleModalBuyButtonClick() {
    const modalTitle = document.getElementById("modalTitle").textContent;
    const movieId = document
      .getElementById("modalImage")
      .getAttribute("data-movie-id");

    processPurchase(movieId, modalTitle, modalBuyButton);
  }

  // Function to process the purchase
  function processPurchase(movieId, movieName, buttonElement) {
    // Check if user is logged in
    checkLoginStatus()
      .then((isLoggedIn) => {
        if (isLoggedIn) {
          // Process the purchase with AJAX
          return purchaseMovie(movieId);
        } else {
          // Redirect to login page
          showLoginPrompt();
          return Promise.reject("Not logged in");
        }
      })
      .then((response) => {
        if (response.success) {
          // Show success message
          showSuccessMessage(movieName);

          // Update quantity displayed on the page
          updateQuantityDisplay(movieId, response.newQuantity);

          // Convert button to "Play Now"
          convertToPLayButton(buttonElement, movieId);

          // If this was triggered from a movie card, also update the modal if it's open
          const openModal = document.getElementById("movieModal");
          if (openModal && openModal.style.display === "block") {
            const modalButton = openModal.querySelector(
              ".modal-buttons button"
            );
            convertToPLayButton(modalButton, movieId);
          }
        } else {
          // Show error message
          showErrorMessage(response.message || "Failed to complete purchase");
        }
      })
      .catch((error) => {
        if (error !== "Not logged in") {
          showErrorMessage("An error occurred. Please try again.");
          console.error("Purchase error:", error);
        }
      });
  }

  // Function to check if user is logged in
  function checkLoginStatus() {
    return new Promise((resolve) => {
      // Use AJAX to check login status on the server
      fetch("check_login_status.php")
        .then((response) => response.json())
        .then((data) => {
          resolve(data.isLoggedIn);
        })
        .catch(() => {
          // In case of error, assume not logged in
          resolve(false);
        });
    });
  }

  // Function to show login prompt
  function showLoginPrompt() {
    // Store current page URL to redirect back after login
    sessionStorage.setItem("redirectAfterLogin", window.location.href);

    // Redirect to login page
    window.location.href = "login.php";
  }

  // Function to purchase movie via AJAX
  function purchaseMovie(movieId) {
    return new Promise((resolve) => {
      // Create form data
      const formData = new FormData();
      formData.append("movie_id", movieId);
      formData.append("action", "purchase");

      // Send purchase request to server
      fetch("process_purchase.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          resolve(data);
        })
        .catch((error) => {
          console.error("Purchase request error:", error);
          resolve({ success: false, message: "Network error" });
        });
    });
  }

  // Function to show success message
  function showSuccessMessage(movieName) {
    // Create message element
    const messageElement = document.createElement("div");
    messageElement.className = "success-message";
    messageElement.textContent = `Successfully purchased "${movieName}"!`;
    messageElement.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 10000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        `;

    // Add to body
    document.body.appendChild(messageElement);

    // Remove after 3 seconds
    setTimeout(() => {
      messageElement.style.opacity = "0";
      messageElement.style.transition = "opacity 0.5s";
      setTimeout(() => {
        document.body.removeChild(messageElement);
      }, 500);
    }, 3000);
  }

  // Function to show error message
  function showErrorMessage(message) {
    // Create message element
    const messageElement = document.createElement("div");
    messageElement.className = "error-message";
    messageElement.textContent = message;
    messageElement.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #F44336;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 10000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        `;

    // Add to body
    document.body.appendChild(messageElement);

    // Remove after 3 seconds
    setTimeout(() => {
      messageElement.style.opacity = "0";
      messageElement.style.transition = "opacity 0.5s";
      setTimeout(() => {
        document.body.removeChild(messageElement);
      }, 500);
    }, 3000);
  }

  // Function to update quantity display
  function updateQuantityDisplay(movieId, newQuantity) {
    // Update in movie card
    const movieCards = document.querySelectorAll(
      `.movie-item[data-movie-id="${movieId}"]`
    );
    movieCards.forEach((card) => {
      const quantityElement = card.querySelector(".movie-quantity");
      if (quantityElement) {
        quantityElement.textContent = `Quantity: ${newQuantity}`;
      }
    });

    // Update in modal if open
    const modalQuantity = document.getElementById("modalQuantity");
    if (modalQuantity) {
      modalQuantity.textContent = `Quantity: ${newQuantity}`;
    }
  }

  // Function to convert Buy button to Play button
  function convertToPLayButton(buttonElement, movieId) {
    if (!buttonElement) return;

    // Change button text and style
    buttonElement.textContent = "Play Now";
    buttonElement.classList.add("play-button");
    buttonElement.classList.remove("buy-button");

    // Remove old event listeners by cloning the node
    const newButton = buttonElement.cloneNode(true);
    buttonElement.parentNode.replaceChild(newButton, buttonElement);

    // Add new event listener for play functionality
    newButton.addEventListener("click", function () {
      playMovie(movieId);
    });
  }

  // Function to play movie
  function playMovie(movieId) {
    // Find the movie container
    const movieContainer = document.querySelector(
      `.movie-item[data-movie-id="${movieId}"]`
    );
    const modalImage = document.getElementById("modalImage");

    if (movieContainer) {
      // Replace image with video in movie card
      const imageElement = movieContainer.querySelector(".movie-image img");
      if (imageElement) {
        const videoElement = createVideoPlayer(movieId);
        imageElement.parentNode.replaceChild(videoElement, imageElement);
      }
    }

    // If modal is open, also replace image with video there
    if (modalImage && modalImage.getAttribute("data-movie-id") === movieId) {
      const videoElement = createVideoPlayer(movieId);
      modalImage.parentNode.replaceChild(videoElement, modalImage);
    }
  }

  // Function to create video player
  function createVideoPlayer(movieId) {
    const videoElement = document.createElement("video");
    videoElement.className = "movie-video";
    videoElement.controls = true;
    videoElement.autoplay = true;
    videoElement.style.width = "100%";
    videoElement.style.height = "100%";
    videoElement.style.objectFit = "cover";

    // Set video source (you'll need to provide the actual video path)
    const videoSource = document.createElement("source");
    videoSource.src = `videos/movie_${movieId}.mp4`; // Adjust path as needed
    videoSource.type = "video/mp4";

    videoElement.appendChild(videoSource);

    // Add fallback content
    const fallbackText = document.createElement("p");
    fallbackText.textContent = "Your browser does not support HTML video.";
    videoElement.appendChild(fallbackText);

    return videoElement;
  }
});
