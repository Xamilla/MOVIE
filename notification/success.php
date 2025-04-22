<div class="success-container">
    <div class="success-message">
        <h2>Purchase Successful!</h2>
        <p><?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Your purchase has been completed successfully.'; ?></p>
        <a href="?page=home" class="home-btn">Return to Home</a>
    </div>
</div>