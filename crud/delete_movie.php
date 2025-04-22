<link rel="stylesheet" href="style/delete_movie.css">
<?php
require_once 'database/moviesdb.php';
$movie_db = new Database();

if (isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];

    $stmt = $movie_db->dbconnection->prepare("SELECT movie_name FROM movies WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();
    $stmt->close();
}
?>

<div class="modal-overlay">
    <div class="delete-container">
        <h2>Confirm Delete</h2>
        <p>Are you sure you want to delete the movie: <strong><?= htmlspecialchars($movie['movie_name']) ?></strong>?</p>

        <form method="POST" action="crud/delete_process.php">
            <input type="hidden" name="movie_id" value="<?= $movie_id ?>">
            <button type="submit" name="confirm_delete" class="delete-btn">Yes, Delete</button>
            <a href="admin_dashboard.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</div>