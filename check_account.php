<?php
session_start();
require_once "database/moviesdb.php"; // Your database connection file

$movie_db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $movie_db->dbconnection->real_escape_string($_POST['username']);
    $password = $_POST['password']; 
    $captcha = $_POST['captcha'];
    $redirect_url = $_POST['redirect_url'] ?? './index.php';

    // Debugging (optional: you can remove this when live)
    error_log("Session CAPTCHA: " . ($_SESSION['captcha'] ?? "Not Set"));
    error_log("User Entered CAPTCHA: " . $captcha);

    // Validate CAPTCHA
    if (!isset($_SESSION['captcha']) || (string)$_SESSION['captcha'] !== (string)$captcha) {
        $_SESSION['error_msg'] = "Invalid CAPTCHA.";
        header("Location: ./index.php?page=login");
        exit;
    }

    // Fetch user info
    $query = "SELECT id, username, password, role FROM accounts WHERE username = ?";
    $stmt = $movie_db->dbconnection->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check password
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login_in'] = 'yes';

                // Admin check
                if ($user['role'] === 'admin') {
                    $_SESSION['admin'] = 'yes';
                } else {
                    unset($_SESSION['admin']);
                }

                unset($_SESSION['redirect_url']); // Optional: clear after login

                header("Location: $redirect_url");
                exit;
            } else {
                $_SESSION['error_msg'] = "Incorrect Username or Password.";
                header("Location: ./index.php?page=login");
                exit;
            }
        } else {
            $_SESSION['error_msg'] = "Incorrect Username or Password.";
            header("Location: ./index.php?page=login");
            exit;
        }
    } else {
        $_SESSION['error_msg'] = "Database error occurred.";
        header("Location: ./index.php?page=login");
        exit;
    }
}
?>
