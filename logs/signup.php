<link rel="stylesheet" href="style/signup.css">
<div class="signup-container">
    <h1>Sign Up</h1>
    <form action="process_signup.php" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" required>

        <label for="profile-picture">Profile</label>
        <input type="file" id="profile-picture" name="picture-picture" accept="images/*" required>

        <button type="submit">Sign Up</button>
    </form>
</div>