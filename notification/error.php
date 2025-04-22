<div class="error-container">
    <div class="error-message">
        <h2>Oops! Something went wrong</h2>
        <p><?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'An error occurred during your purchase.'; ?></p>
        <a href="?page=home" class="home-btn">Return to Home</a>
    </div>
</div>