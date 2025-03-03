<link rel="stylesheet" href="style/login.css">
<div class="login-container">
    <h1>Login</h1>
    <form action="process_login.php" method="POST">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="captcha">Captcha</label>
        <input type="captcha" id="captcha" name="captcha" required>

        <button type="submit">Login</button>
    </form>
</div>