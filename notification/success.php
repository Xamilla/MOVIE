<?php
$previous_page = $_SERVER['HTTP_REFERER'] ?? 'index.php';
?>
<div class="success-container">
    <div class="success-message">
        <h2>Purchase Successful!</h2>
        <p><?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Your purchase has been completed successfully.'; ?></p>
        <a href="<?= $previous_page ?>" class="home-btn">RETURN</a>
    </div>
</div>