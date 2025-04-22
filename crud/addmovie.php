<link rel="stylesheet" href="style/addmovie.css">
<?php
// add_movie.php - Form to add a new movie

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login_in']) || $_SESSION['login_in'] !== 'yes' || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login&error=unauthorized");
    exit();
}

require_once 'database/moviesdb.php';

$error_message = '';
$success_message = '';

$movie_name = $movie_director = $movie_summary = $duration = $released = $cast = $categories = '';
$price = $movie_quantity = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_movie'])) {
    $db = new Database();

    $movie_name = trim($_POST['movie_name'] ?? '');
    $movie_director = trim($_POST['movie_director'] ?? '');
    $movie_summary = trim($_POST['movie_summary'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $movie_quantity = intval($_POST['movie_quantity'] ?? 0);
    $duration = trim($_POST['duration'] ?? '');
    $released = trim($_POST['released'] ?? '');
    $cast = trim($_POST['cast'] ?? '');
    $categories = trim($_POST['categories'] ?? '');

    if (empty($movie_name) || empty($categories)) {
        $error_message = "Movie name and category are required.";
    } else {
        $movie_picture = 'default.jpg';

        if (isset($_FILES['movie_picture']) && $_FILES['movie_picture']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "../MOVIE/images/" . $categories . "/";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES['movie_picture']['name'], PATHINFO_EXTENSION);
            $movie_picture = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $movie_picture;

            $check = getimagesize($_FILES['movie_picture']['tmp_name']);
            if ($check === false) {
                $error_message = "File is not an image.";
            } elseif ($_FILES['movie_picture']['size'] > 5000000) {
                $error_message = "File is too large. Maximum size is 5MB.";
            } elseif (!in_array($file_extension, ["jpg", "jpeg", "png", "gif"])) {
                $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
            } elseif (!move_uploaded_file($_FILES['movie_picture']['tmp_name'], $target_file)) {
                $error_message = "There was an error uploading your file.";
            }
        }

        if (empty($error_message)) {
            $sql = "INSERT INTO movies (movie_name, movie_director, movie_summary, price, movie_quantity, 
                                        duration, released, cast, categories, movie_picture) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $db->dbconnection->prepare($sql);

            if ($stmt) {
                $stmt->bind_param(
                    "sssdiissss",
                    $movie_name,
                    $movie_director,
                    $movie_summary,
                    $price,
                    $movie_quantity,
                    $duration,
                    $released,
                    $cast,
                    $categories,
                    $movie_picture
                );

                if ($stmt->execute()) {
                    $success_message = "Movie added successfully!";
                    $movie_name = $movie_director = $movie_summary = $duration = $released = $cast = $categories = '';
                    $price = $movie_quantity = 0;
                } else {
                    $error_message = "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $error_message = "Error preparing statement: " . $db->dbconnection->error;
            }
        }

        $db->dbconnection->close();
    }
}
?>
    <div class="form-container">
        <h1>Add New Movie</h1>

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- $categories = ""; i put this bec. the variable categories is undefined -->
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="movie_name">Movie Title*</label>
                <input type="text" id="movie_name" name="movie_name" value="<?php echo htmlspecialchars($movie_name ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="movie_director">Director</label>
                <input type="text" id="movie_director" name="movie_director" value="<?php echo htmlspecialchars($movie_director ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="cast">Cast</label>
                <input type="text" id="cast" name="cast" value="<?php echo htmlspecialchars($cast ?? ''); ?>" placeholder="Separate actors with commas">
            </div>

            <div class="form-group">
                <label for="categories">Category*</label>
                <select id="categories" name="categories" required>
                    <option value="">Select a category</option>
                    <option value="comedy" <?php echo ($categories === 'comedy') ? 'selected' : ''; ?>>Comedy</option>
                    <option value="fantasy" <?php echo ($categories === 'fantasy') ? 'selected' : ''; ?>>Fantasy</option>
                    <option value="superhero" <?php echo ($categories === 'superhero') ? 'selected' : ''; ?>>Superhero</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price (₱)</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($price ?? 0.00); ?>">
            </div>

            <div class="form-group">
                <label for="movie_quantity">Quantity</label>
                <input type="number" id="movie_quantity" name="movie_quantity" min="0" value="<?php echo htmlspecialchars($movie_quantity ?? 0); ?>">
            </div>

            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($duration ?? ''); ?>" placeholder="e.g., 2h 15min">
            </div>

            <div class="form-group">
                <label for="released">Release Date</label>
                <input type="text" id="released" name="released" value="<?php echo htmlspecialchars($released ?? ''); ?>" placeholder="e.g., January 15, 2024">
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label for="movie_summary">Movie Summary</label>
                <textarea id="movie_summary" name="movie_summary"><?php echo htmlspecialchars($movie_summary ?? ''); ?></textarea>
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label for="movie_picture">Movie Poster</label>
                <input type="file" id="movie_picture" name="movie_picture" accept="image/*">
                <p><small>Leave empty to use default image. Recommended size: 300x450 pixels.</small></p>
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <button type="submit" name="add_movie" class="submit-btn">Add Movie</button>
            </div>
        </form>
    </div>