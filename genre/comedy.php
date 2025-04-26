<?php

use function PHPSTORM_META\map;

require_once 'database/moviesdb.php';
$movie_db = new Database();
// Fetch movies from the database
$sql = "SELECT movie_id, movie_name, price, movie_director, movie_summary, movie_picture, movie_quantity, duration, released, cast
        FROM movies WHERE categories = 'comedy'";
$result = $movie_db->dbconnection->query($sql);
$update_previous_page = $_SERVER['HTTP_REFERER'] ?? 'index.php';

// Add JavaScript to set admin status
if (isset($_SESSION['login_in']) && $_SESSION['login_in'] === 'yes') {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            window.isAdminUser = " . (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'true' : 'false') . ";
            console.log('Admin status:', window.isAdminUser);
        });
    </script>";
}
?>

<div class="movie-container">
    <!-- <h1>Comedy Movies</h1> -->
    <div class="movie-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $movie_id = $row["movie_id"];
                $already_purchased = false;

                // Add default values for missing data
                $movie_name = !empty($row["movie_name"]) ? $row["movie_name"] : "Untitled Movie";
                $director = !empty($row["movie_director"]) ? $row["movie_director"] : "Director not specified";
                $cast = !empty($row["cast"]) ? $row["cast"] : "Cast not available";
                $released = !empty($row["released"]) ? $row["released"] : "Release date unknown";
                $duration = !empty($row["duration"]) ? $row["duration"] : "Duration not specified";
                $price = !empty($row["price"]) ? $row["price"] : "0.00";
                $quantity = isset($row["movie_quantity"]) ? $row["movie_quantity"] : 0;
                $summary = !empty($row["movie_summary"]) ? $row["movie_summary"] : "No summary available for this movie.";
                $picture = !empty($row["movie_picture"]) ? $row["movie_picture"] : "default.jpg";

                // Check if user is logged in and has purchased this movie
                if (isset($_SESSION['login_in']) && $_SESSION['login_in'] === 'yes') {
                    $user_id = $_SESSION['id'];
                    $purchase_check = "SELECT id FROM purchases WHERE user_id = ? AND movie_id = ? LIMIT 1";
                    $check_stmt = $movie_db->dbconnection->prepare($purchase_check);
                    $check_stmt->bind_param("ii", $user_id, $movie_id);
                    $check_stmt->execute();
                    $check_result = $check_stmt->get_result();
                    $already_purchased = ($check_result->num_rows > 0);
                    $check_stmt->close();
                }

                echo '<div class="movie-item">';
                echo '<div class="movie-image">';
                echo '<img src="../MOVIE/images/comedy/' . $picture . '" alt="' . $movie_name . '">';
                echo '</div>';

                echo '<h2>' . $movie_name . '</h2>';

                echo '<div class="details">';
                echo '<p class="director">' . $director . '</p>';
                echo '<p class="cast">' . $cast . '</p>';
                echo '<p class="release-date">' . $released . '</p>';
                echo '<p class="duration">' . $duration . '</p>';
                echo '<p class="price">&#8369;' . number_format($price, 2, ".", ",") . '</p>';

                // Updated quantity display - Show "Out of Stock" when quantity is 0
                $quantityDisplay = $quantity > 0 ? $quantity : '<span class="out-of-stock">Out of Stock</span>';
                echo '<p class="Qty-on-hand">' . $quantityDisplay . '</p>';

                echo '</div>';

                // Store summary for modal
                echo '<div class="summary" style="display:none;">' . $summary . '</div>';

                // Handle button display based on login status and user role
                if (isset($_SESSION['login_in']) && $_SESSION['login_in'] === 'yes') {
                    echo '<div class="action-buttons">';

                    // Admin controls
                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                        echo '<div class="admin-controls">';

                        // Update Button
                        echo '<form method="POST" action="?page=update" class="update-form">';
                        echo '<input type="hidden" name="movie_id" value="' . $movie_id . '">';
                        echo '<input type="hidden" name="update" value="1">';
                        echo '<button type="submit" class="update-btn" data-movie-id="' . $movie_id . '" data-movie-name="' . htmlspecialchars($movie_name) . '">Update</button>';
                        echo '</form>';

                        // Delete Button
                        // Replace this in your movie container page where you have the delete button
                        echo '<a href="crud/delete_movie.php?movie_id=' . $movie_id . '" class="delete-btn">Delete</a>';
                        echo '</div>'; // Close admin-controls div
                    } else {
                        // Regular user buttons
                        // Watch button for those who already purchased
                        if ($already_purchased) {
                            echo '<a href="watch.php?movie_id=' . $movie_id . '" class="watch-btn">Watch Now</a>';

                            // Only show Buy Again if quantity available
                            if ($quantity > 0) {
                                echo '<form method="POST" action="../MOVIE/crud/buy_movie.php" class="buy-again-form">';
                                echo '<input type="hidden" name="movie_id" value="' . $movie_id . '">';
                                echo '<button type="submit" class="buy-again-btn" data-movie-id="' . $movie_id . '" data-movie-name="' . htmlspecialchars($movie_name) . '" data-max-qty= "' . $quantity . '">Buy Again</button>';
                                echo '</form>';
                            }
                        } elseif ($quantity > 0) {
                            // First time purchase with Buy button
                            // For Buy button
                            echo '<form method="POST" action="../MOVIE/crud/buy_movie.php">';
                            echo '<input type="hidden" name="movie_id" value="' . $movie_id . '">';
                            echo '<button type="submit" class="buy-btn" data-movie-id="' . $movie_id . '" data-movie-name="' . htmlspecialchars($movie_name) . '" data-max-qty="' . $quantity . '">Buy Now</button>';
                            echo '</form>';

                            // Similarly for other buttons
                        } else {
                            echo '<button disabled class="out-of-stock-btn">Out of Stock</button>';
                        }
                    }

                    echo '</div>'; // Close action-buttons div
                } else {
                    // User not logged in
                    echo '<a href="?page=login" class="login-required-btn">Buy Now</a>';
                }

                echo '</div>'; // Close movie-item
            }
        } else {
            echo '<div class="no-movies"><p>No comedy movies available at this time.</p></div>';
        }

        $movie_db->dbconnection->close();
        ?>
    </div>
</div>

<div id="movieModal" class="movie-modal">
    <div class="modal-content">
        <button id="closeModal" class="close-modal">&times;</button>
        <div class="modal-left">
            <img id="modalImage" src="" alt="Movie Poster">
        </div>
        <div class="modal-right">
            <h2 id="modalTitle"></h2>

            <div class="modal-details">
                <p class="director">Director: </p>
                <span id="modalDirector"></span>
                <br>

                <p class="cast"> Cast: </p>
                <div id="modalCast" class="modal-cast-content"></div>
                <br>

                <p class="release">Release-Date:</p>
                <span id="modalRelease"></span>
                <br>

                <p class="duration">Duration:</p>
                <span id="modalDuration"></span>
                <br>

                <p class="price">Price: </p>
                <span id="modalPrice"></span>
                <br>

                <p class="Qty-on-hand">Qty on hand</p>
                <span class="out-of-stock" id="modalQuantity"></span>
                <br>

            </div>

            <div class="modal-summary-container">
                <h3>Summary</h3>
                <p id="modalSummary" class="modal-summary"></p>
            </div>
            <div id="modalActionButtons" class="modal-buttons"></div>
        </div>
    </div>
</div>