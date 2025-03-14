<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$error = isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : '';
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

        <button type="submit" title="login">Login</button>
    </form>
    <div style="font-size: 15px; color:#FF8C42; margin-top:10px;"><?php echo $error; ?></div>
</div>

<script>
    function reloadCaptcha() {
        document.getElementById('imgcap').src = 'cap/captcha.php?' + Date.now();
    }
</script>