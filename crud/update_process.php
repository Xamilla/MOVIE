<?php
$update_previous_page = $_SERVER['HTTP_REFERER'] ?? 'index.php';
require_once '../database/moviesdb.php';
$movie_db = new Database();

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update_movie'])) {
    $movie_id = $_POST['movie_id'];
    $movie_name = $_POST['movie_name'];
    $movie_director = $_POST['movie_director'];
    $cast = $_POST['cast'];
    $released = $_POST['released'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $movie_quantity = $_POST['movie_quantity'];
    $movie_summary = $_POST['movie_summary'];
    $movie_categories = $_POST['categories'];

    $picture_path = null;
    if (isset($_FILES['movie_picture']) && $_FILES['movie_picture']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../MOVIE/images/comdey/";
        $target_name = basename($_FILES['movie_picture']['name']);
        $target_file = $target_dir . uniqid() . '_' . $target_name;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES['movie_picture']['tmp_name'], $target_file)) {
                $picture_path = $target_file;
            }
        }
    }

    if ($picture_path) {
        $query = "UPDATE movies SET 
            movie_name = ?, movie_director = ?, cast = ?, released = ?, 
            duration = ?, price = ?, movie_quantity = ?, 
            movie_summary = ?, movie_picture = ?, categories = ? 
            WHERE movie_id = ?";
        $stmt = $movie_db->dbconnection->prepare($query);
        $stmt->bind_param("sssssdisssi", $movie_name, $movie_director, $cast, $released, $duration, $price, $movie_quantity, $movie_summary, $picture_path, $movie_categories, $movie_id);
    } else {
        $query = "UPDATE movies SET 
            movie_name = ?, movie_director = ?, cast = ?, released = ?, 
            duration = ?, price = ?, movie_quantity = ?, 
            movie_summary = ?, categories = ? 
            WHERE movie_id = ?";
        $stmt = $movie_db->dbconnection->prepare($query);
        $stmt->bind_param("sssssdissi", $movie_name, $movie_director, $cast, $released, $duration, $price, $movie_quantity, $movie_summary, $movie_categories, $movie_id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: ../index.php?page=success&message=Movie updated successfully&previous_page=$update_previous_page");
        exit();
    } else {
        echo "Something went wrong: " . $stmt->error;
    }
}
