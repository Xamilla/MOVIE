<?php
require_once '../database/moviesdb.php';
$movie_db = new Database();

if (isset($_POST['confirm_delete']) && isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];

    $stmt = $movie_db->dbconnection->prepare("DELETE FROM movies WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);

    if ($stmt->execute()) {
        // Optional: add flash message logic here
        header("Location: ../admin_dashboard.php?status=deleted");
        exit;
    } else {
        echo "Error deleting movie: " . $stmt->error;
    }

    $stmt->close();
    $movie_db->dbconnection->close();
} else {
    header("Location: ../admin_dashboard.php");
    exit;
}
