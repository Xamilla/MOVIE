<?php
// Start the session 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$error = isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : '';

// direct to the previous page not the login page 
if (!isset($_SESSION['redirect_page'])) {
    $current = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    if (!str_contains($current, 'page=login')) {
        $_SESSION['redirect_url'] = $current;
    }
}
$redirect_url = $_SESSION['redirect_url'] ?? 'index.php';
?>

<link rel="stylesheet" href="style/login.css">
<div class="login-container">
    <h1>Login</h1>
    <form action="check_account.php" method="POST">
        <label for="username">Username</label>
        <input placeholder="Enter your username" type="username" id="username" name="username" required>

        <label for="password">Password</label>
        <input placeholder="Enter password" type="password" id="password" name="password" required>

        <label for="captcha">Captcha</label>
        <img src="cap/captcha.php" alt="CAPTCHA" id="imgcap" onclick="reloadCaptcha();" style="width: 100px; height: 30px; vertical-align: middle; cursor: pointer; margin-bottom:10px; border-radius:5px">
        <input placeholder="Enter captcha" type="captcha" id="captcha" name="captcha" required>

        <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($redirect_url); ?>">

        <button type="submit" title="login">Login</button>
    </form>
    <div style="font-size: 15px; color:#FF8C42; margin-top:10px;"><?php echo $error; ?></div>

    <!-- Add signup link -->
    <div class="signup-link">
        Don't have an account? <a href="index.php?page=signup">Sign Up</a>
    </div>
</div>

<script>
    function reloadCaptcha() {
        document.getElementById('imgcap').src = 'cap/captcha.php?' + Date.now();
    }
</script>