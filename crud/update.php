<?php
require_once 'database/moviesdb.php';

$movie_db = new Database();
if (!isset($_POST['redirect_page'])) {
    $current = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    if (!str_contains($current, 'page=update')) {
        $_SESSION['redirect_page'] = $current;
    }
}
$redirect_url = $_SESSION['redirect_page'] ?? 'index.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id']) && !isset($_POST['update_movie'])) {
    $_SESSION['update_movie_id'] = $_POST['movie_id'];
}

$movie_id = $_SESSION['update_movie_id'] ?? null;
if (!$movie_id) {
    echo "Invalid movie ID.";
    exit;
}

$sql = "SELECT * FROM movies WHERE movie_id = ?";
$stmt = $movie_db->dbconnection->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "Movie not found.";
    exit;
}

$update_successful = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_movie'])) {
    $movie_name = $_POST['movie_name'];
    $price = $_POST['price'];
    $director = $_POST['movie_director'];
    $summary = $_POST['movie_summary'];
    $quantity = $_POST['movie_quantity'];
    $duration = $_POST['duration'];
    $released = $_POST['released'];
    $cast = $_POST['cast'];

    $query = "UPDATE movies SET movie_name=?, price=?, movie_director=?, movie_summary=?, movie_quantity=?, duration=?, released=?, cast=? WHERE movie_id=?";
    $stmt = $movie_db->dbconnection->prepare($query);
    $stmt->bind_param("sdssisssi", $movie_name, $price, $director, $summary, $quantity, $duration, $released, $cast, $movie_id);

    if ($stmt->execute()) {
        $update_successful = true;
    }
}
?>
<link rel="stylesheet" href="style/update.css">
<div class="form-container">
    <h1>Update Movie</h1>
    <form method="post">
        <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">

        <div class="form-group">
            <label for="movie_name">Movie Name:</label>
            <input type="text" name="movie_name" value="<?= htmlspecialchars($movie['movie_name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" value="<?= $movie['price'] ?>" required>
        </div>

        <div class="form-group">
            <label for="movie_director">Director:</label>
            <input type="text" name="movie_director" value="<?= htmlspecialchars($movie['movie_director']) ?>" required>
        </div>

        <div class="form-group">
            <label for="cast">Cast:</label>
            <input type="text" name="cast" value="<?= htmlspecialchars($movie['cast']) ?>" required>
        </div>

        <div class="form-group">
            <label for="released">Released:</label>
            <input type="date" name="released" value="<?= $movie['released'] ?>" required>
        </div>

        <div class="form-group">
            <label for="duration">Duration:</label>
            <input type="text" name="duration" value="<?= htmlspecialchars($movie['duration']) ?>" required>
        </div>

        <div class="form-group">
            <label for="movie_quantity">Quantity:</label>
            <input type="number" name="movie_quantity" value="<?= $movie['movie_quantity'] ?>" required>
        </div>

        <div class="form-group">
            <label for="movie_summary">Summary:</label>
            <textarea name="movie_summary" required><?= htmlspecialchars($movie['movie_summary']) ?></textarea>
        </div>

        <div class="form-group" style="grid-column: 1 / -1; display: flex; gap: 15px; justify-content: center;">
            <button type="submit" name="update_movie" class="submit-btn">Update Movie</button>
            <a href="<?= htmlspecialchars($_SESSION['redirect_page'] ?? 'index.php') ?>" class="cancel-btn-add">Cancel</a>
        </div>
    </form>
</div>

<!-- Success Overlay -->
<div class="success-overlay" style="display: <?= $update_successful ? 'flex' : 'none' ?>;">
    <div class="success-box">
        <h2>🎉 Movie Updated Successfully!</h2>
        <a href="<?= htmlspecialchars($_SESSION['redirect_page'] ?? 'index.php') ?>" class="return-btn">Return</a>
    </div>
</div>