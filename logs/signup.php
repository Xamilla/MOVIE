<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "database/moviesdb.php"; // Corrected the path if needed

$movie_db = new Database();

// Initialize error variables
$error_message = "";
$form_data = [
    'username' => '',
    'email' => ''
];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $movie_db->dbconnection->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $email = $movie_db->dbconnection->real_escape_string($_POST['email']);

    $form_data['username'] = $username;
    $form_data['email'] = $email;

    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        $check_query = "SELECT * FROM accounts WHERE username = ? OR email = ?";
        $check_stmt = $movie_db->dbconnection->prepare($check_query);
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['username'] == $username) {
                $error_message = "Username already taken!";
            } else {
                $error_message = "Email already registered!";
            }
        } else {
            // Process profile picture
            $profile_picture_path = NULL;

            if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] == 0) {
                $upload_dir = "../images/profile_pictures/";

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $file_name = $_FILES['profile-picture']['name'];
                $file_tmp = $_FILES['profile-picture']['tmp_name'];
                $file_size = $_FILES['profile-picture']['size'];

                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                $max_file_size = 2 * 1024 * 1024; // 2MB

                if (!in_array($file_ext, $allowed_ext)) {
                    $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed!";
                } elseif ($file_size > $max_file_size) {
                    $error_message = "File size must be less than 2MB!";
                } else {
                    $new_file_name = uniqid('', true) . '.' . $file_ext;
                    $file_path = $upload_dir . $new_file_name;

                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $profile_picture_path = $file_path;
                    } else {
                        $error_message = "Failed to upload profile picture!";
                    }
                }
            }

            if (empty($error_message)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $insert_query = "INSERT INTO accounts (username, email, password, profile_picture) VALUES (?, ?, ?, ?)";
                $stmt = $movie_db->dbconnection->prepare($insert_query);
                $stmt->bind_param("ssss", $username, $email, $hashed_password, $profile_picture_path);

                if ($stmt->execute()) {
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $stmt->insert_id;

                    // ✅ Correct redirect here
                    header("Location: ../index.php?page=login");
                    exit();
                } else {
                    $error_message = "Registration failed: " . $movie_db->dbconnection->error;
                }
            }
        }
    }

    $_SESSION['error_signup'] = $error_message;
    $_SESSION['form_data'] = $form_data;
}

// Load previous errors if any
$error_message = $_SESSION['error_signup'] ?? '';
$form_data = $_SESSION['form_data'] ?? ['username' => '', 'email' => ''];

unset($_SESSION['error_signup']);
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style/signup.css">
</head>

<body>
    <div class="signup-container">
        <h1>Sign Up</h1>

        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($form_data['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($form_data['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>

            <div class="form-group">
                <label for="profile-picture">Profile Picture</label>
                <input type="file" id="profile-picture" name="profile-picture" accept="image/*">
            </div>

            <button type="submit" class="signup-btn">Sign Up</button>

            <div class="social-login">
                <p>Or sign up with:</p>
                <div class="social-buttons">
                    <a href="#" class="social-btn facebook">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a href="#" class="social-btn google">
                        <i class="fab fa-google"></i> Google
                    </a>
                </div>
            </div>

            <div class="login-link">
                Already have an account? <a href="../MOVIE/index.php?page=login">Log In</a>
            </div>
        </form>
    </div>
</body>

</html>
