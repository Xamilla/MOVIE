<?php
session_start();
include "../MOVIE/database/moviesdb.php";

$movie_db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $movie_db->dbconnection->real_escape_string($_POST['username']);
    $password = $movie_db->dbconnection->real_escape_string($_POST['password']);
    $captcha = $_POST['captcha'];

    // Debugging: Check CAPTCHA values (remove in production)
    error_log("Session CAPTCHA: " . ($_SESSION['captcha'] ?? "Not Set"));
    error_log("User Entered CAPTCHA: " . $captcha);

    // Validate CAPTCHA
    if (!isset($_SESSION['captcha']) || (string)$_SESSION['captcha'] !== (string)$captcha) {
        $_SESSION['error_msg'] = "Invalid CAPTCHA.";
        header("Location: index.php?page=login");
        exit;
    }

    // Query to check username, password, and role
    $query = "SELECT id, username, role FROM accounts WHERE username = ? AND password = ?";
    $stmt = $movie_db->dbconnection->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Store role in session
            $_SESSION['login_in'] = 'yes';

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php"); // Admin page
            } else {
                header("Location: index.php"); // User page
            }
            exit;
        } else {
            $_SESSION['error_msg'] = "Incorrect Username or Password.";
        }
    } else {
        $_SESSION['error_msg'] = "Database error occurred.";
    }

    header("Location: index.php?page=login");
    exit;
}