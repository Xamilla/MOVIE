<?php
// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/MOVIE/database/moviesdb.php';
$movie_db = new Database();

$movie_name = '';
$movie_id = '';
$error_message = '';
$success_message = '';
$previous_page = $_SERVER['HTTP_REFERER'] ?? 'index.php';

// Process delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete']) && isset($_POST['movie_id'])) {
    $movie_id = (int)$_POST['movie_id'];

    // Fetch the movie name for logging purposes
    $name_stmt = $movie_db->dbconnection->prepare("SELECT movie_name FROM movies WHERE movie_id = ?");
    $name_stmt->bind_param("i", $movie_id);
    $name_stmt->execute();
    $result = $name_stmt->get_result();
    $movie = $result->fetch_assoc();
    $movie_name = $movie['movie_name'] ?? 'Unknown movie';
    $name_stmt->close();

    // Delete the movie
    $stmt = $movie_db->dbconnection->prepare("DELETE FROM movies WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);

    // Get the return URL
    $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : $previous_page;

    if ($stmt->execute()) {
        $success_message = "Movie deleted successfully.";

        // Close the database connection before redirecting
        $stmt->close();
        $movie_db->dbconnection->close();

        // Redirect to the previous page with success message
        header("Location: " . $return_url);
        exit;
    } else {
        $error_message = "Error deleting movie: " . $stmt->error;
        $stmt->close();
    }
} else {
    // Only run this if movie_id is set in GET
    if (isset($_GET['movie_id']) && is_numeric($_GET['movie_id'])) {
        $movie_id = (int)$_GET['movie_id'];

        // Fetch the movie name for confirmation display
        $stmt = $movie_db->dbconnection->prepare("SELECT movie_name FROM movies WHERE movie_id = ?");
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $movie = $result->fetch_assoc();
            $movie_name = $movie['movie_name'];
        } else {
            $error_message = "Movie not found.";
        }
        $stmt->close();
    } else {
        // Only trigger this if POST and GET are both empty (real invalid access)
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error_message = "Invalid movie ID.";
        }
    }
}

?>

<body>
    <link rel="stylesheet" href="../style/delete_movie.css">

    <?php if (!empty($error_message)): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($error_message); ?></p>
            <a href="<?php echo htmlspecialchars($previous_page); ?>" class="cancel-delete-btn">Return</a>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
        <!-- Delete Confirmation Overlay -->
        <div id="deleteOverlay" class="overlay" style="display: flex;">
            <div class="overlay-content">
                <h2>Are you sure you want to delete <span id="movieToDeleteName"><?php echo htmlspecialchars($movie_name); ?></span>?</h2>
                <form method="POST" action="">
                    <input type="hidden" name="movie_id" id="movieToDeleteId" value="<?php echo htmlspecialchars($movie_id); ?>">
                    <input type="hidden" name="confirm_delete" value="1">
                    <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($previous_page); ?>">
                    <div class="overlay-buttons">
                        <button type="submit" class="confirm-delete-btn">Yes, Delete</button>
                        <a href="<?php echo htmlspecialchars($previous_page); ?>" class="cancel-delete-btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const overlay = document.getElementById("deleteOverlay");
            if (overlay) {
                overlay.style.display = "flex";
            }
        });
    </script>

</body>