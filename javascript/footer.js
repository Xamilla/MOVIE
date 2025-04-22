document.getElementById("subscribeForm").addEventListener("submit", function(event) {
    event.preventDefault();
    let email = document.getElementById("emailInput").value.trim();
    let message = document.getElementById("message");

    if (email === "") {
        alert("Please enter a valid email address.");
        return;
    }

    message.style.display = "block"; // Show success message
    document.getElementById("emailInput").value = ""; // Clear input field

    // Here, you can send the email data to a server using Fetch or AJAX
});