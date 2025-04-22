<link rel="stylesheet" href="style/update.css">
<?php
require_once 'database/moviesdb.php';
$movie_db = new Database();

if (isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];

    $stmt = $movie_db->dbconnection->prepare("SELECT * FROM movies WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();
    $stmt->close();
}
$previous_page =$_SERVER['HTTP_REFERER'] ?? 'index.php';
?>
<div class="update-container">
    <h1>Update Movie</h1>
    <form method="POST" action="crud/update_process.php" enctype="multipart/form-data" class="update-form">

        <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">

        <div class="form-group">
            <label>Movie Name</label>
            <input type="text" name="movie_name" value="<?= htmlspecialchars($movie['movie_name']) ?>" required>
        </div>

        <div class="form-group">
            <label>Director</label>
            <input type="text" name="movie_director" value="<?= htmlspecialchars($movie['movie_director']) ?>">
        </div>

        <div class="form-group">
            <label>Cast</label>
            <textarea name="cast"><?= htmlspecialchars($movie['cast']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Released</label>
            <input type="date" name="released" value="<?= $movie['released'] ?>">
        </div>

        <div class="form-group">
            <label>Duration</label>
            <input type="text" name="duration" value="<?= htmlspecialchars($movie['duration']) ?>">
        </div>

        <div class="form-group">
            <label>Price (₱)</label>
            <input type="number" step="0.01" name="price" value="<?= $movie['price'] ?>">
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="movie_quantity" value="<?= $movie['movie_quantity'] ?>">
        </div>

        <div class="form-group">
            <label>Summary</label>
            <textarea name="movie_summary"><?= htmlspecialchars($movie['movie_summary']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Change Picture</label>
            <input type="file" name="movie_picture">
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="categories">
                <option value="comedy" <?= $movie['categories'] === 'comedy' ? 'selected' : '' ?>>Comedy</option>
                <option value="fantasy" <?= $movie['categories'] === 'fantasy' ? 'selected' : '' ?>>Fantasy</option>
                <option value="superhero" <?= $movie['categories'] === 'superhero' ? 'selected' : '' ?>>Superhero</option>
                <!-- Add more categories as needed -->
            </select>
        </div>

        <div class="button-group">
            <button type="submit" name="update_movie" class="update-btn">Update Movie</button>
            <a href="<?= $previous_page ?>" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>