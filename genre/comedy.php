<link rel="stylesheet" href="style/genre.css">
<div class="comedy-container">
    <h1>Comedy Movies</h1>
    <div class="movie-grid">
        <?php
        include 'database/moviesdb.php';
        $movie_db = new Database();

        // Fetch movies from the database
        $sql = "SELECT movie_name, price, movie_director, movie_summary, movie_picture, movie_quantity, duration, released 
                FROM movies WHERE categories = 'comedy'";
        $result = $movie_db->dbconnection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="movie-item">';
                echo '    <div class="movie-image">';
                echo '        <img src="../MOVIE/images/comedy/' . $row["movie_picture"] . '" alt="' . $row["movie_name"] . '">';
                echo '        <div class="summary" style="display:none;">' . $row["movie_summary"] . '</div>';
                echo '    </div>';
                echo '    <h2>' . $row["movie_name"] . '</h2>';
                echo '    <p class="release-date">Release Date: ' . $row["released"] . '</p>';
                echo '    <p class="duration">Duration: ' . $row["duration"] . '</p>';
                echo '    <p class="price">Price: &#8369;' . $row["price"] . '</p>';
                echo '    <p class="director">Director: ' . $row["movie_director"] . '</p>';
                echo '    <p class="quantity">Quantity: ' . $row["movie_quantity"] . '</p>';
                echo '    <button class="buy-btn">Buy It</button>';
                echo '</div>';
            }
        } else {
            echo "<p>No comedy movies available.</p>";
        }

        $movie_db->dbconnection->close();
        ?>
    </div>
</div>

<!-- Movie Modal -->
<div id="movieModal" class="movie-modal">
    <div class="modal-content">
        <span id="closeModal" class="close-modal">&times;</span>
        <div class="modal-left">
            <img id="modalImage" src="" alt="Movie Image">
        </div>
        <div class="modal-right">
            <h2 id="modalTitle"></h2>
            <p id="modalRelease"></p>
            <p id="modalDuration"></p>
            <p id="modalPrice"></p>
            <p id="modalDirector"></p>
            <p id="modalQuantity"></p>
            <div class="modal-summary" id="modalSummary"></div>
            <div class="modal-buttons">
                <button>Buy Now</button>
            </div>
        </div>
    </div>
</div>

<script src="../javascript/genre.js"></script> <!-- External JavaScript -->