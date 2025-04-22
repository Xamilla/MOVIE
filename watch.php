<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['login_in']) || $_SESSION['login_in'] !== 'yes') {
    header("Location: index.php?page=login&message=Please log in to watch movies");
    exit;
}

// Check if movie_id is provided
if (!isset($_GET['movie_id'])) {
    header("Location: index.php?page=home&message=No movie selected");
    exit;
}

$movie_id = $_GET['movie_id'];
$user_id = $_SESSION['id'];

include 'database/moviesdb.php';
$movie_db = new Database();
$conn = $movie_db->dbconnection;

// Check if user has purchased this movie
$purchase_check = "SELECT id FROM purchases WHERE user_id = ? AND movie_id = ? LIMIT 1";
$check_stmt = $conn->prepare($purchase_check);
$check_stmt->bind_param("ii", $user_id, $movie_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();
$already_purchased = ($check_result->num_rows > 0);
$check_stmt->close();

if (!$already_purchased) {
    header("Location: index.php?page=error&message=You haven't purchased this movie");
    exit;
}

// Get movie details
$movie_sql = "SELECT movie_name, movie_picture, categories FROM movies WHERE movie_id = ?";
$movie_stmt = $conn->prepare($movie_sql);
$movie_stmt->bind_param("i", $movie_id);
$movie_stmt->execute();
$movie_result = $movie_stmt->get_result();
$movie = $movie_result->fetch_assoc();
$movie_stmt->close();
$conn->close();

// If movie doesn't exist
if (!$movie) {
    header("Location: index.php?page=error&message=Movie not found");
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch: <?php echo htmlspecialchars($movie['movie_name']); ?></title>
    <link rel="icon" href="images/logo/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/watch.css">

</head>

<body>
    <?php include "asset/navbar.php"; ?>

    <div class="watch-container">
        <h1 class="movie-title">Now Playing: <?php echo htmlspecialchars($movie['movie_name']); ?></h1>

        <div class="video-container">
            <div class="video-placeholder">
                <i class="fas fa-play-circle"></i>
                <p>Movie playback would start here</p>
                <p><small>This is a demonstration. In a real application, video streaming would be implemented here.</small></p>
                <?php if (!empty($movie['movie_picture'])): ?>
                    <img src="<?php echo "../MOVIE/images/" . htmlspecialchars($movie['categories']) . "/" . htmlspecialchars($movie['movie_picture']); ?>"
                        alt="<?php echo htmlspecialchars($movie['movie_name']); ?>" style="opacity: 0.3;">
                <?php endif; ?>
            </div>
        </div>

        <a href="index.php?page=<?php echo htmlspecialchars($movie['categories']); ?>" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to <?php echo ucfirst(htmlspecialchars($movie['categories'])); ?> Movies
        </a>
    </div>

    <?php include "asset/footer.php"; ?>
</body>

</html>