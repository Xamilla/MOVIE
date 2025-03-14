<link rel="stylesheet" href="style/genre.css">
<div class="comedy-container">
    <h1>Superhero Movie</h1>
    <div class="movie-grid">
        <?php
        include 'database/moviesdb.php';
        $movie_db = new Database();
        // Fetch movies from the database
        $sql = "SELECT movie_name, price,movie_director, movie_summary,movie_picture,movie_quantity,duration FROM movies WHERE categories = 'superheros'";
        $result = $movie_db->dbconnection->query($sql);
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="movie-item">';
                echo '<div class="movie-image">';
                echo '<img src="../MOVIE/images/superheros/' . $row["movie_picture"] . '" alt="' . $row["movie_picture"] . '">';
                // echo '<video src="' . $row["video"] . '" muted></video>';
                echo '<div class="summary">' . $row["movie_summary"] . '</div>';
                echo '</div>';
                echo '<h2>' . $row["movie_name"] . '</h2>';
                echo '<p>Duratin: ' . $row["duration"] . '</p>';
                echo '<p>Price: &#8369;' . $row["price"] . '</p>';
                echo '<p>Director: ' . $row["movie_director"] . '</p>';
                echo '<p>Quantity: ' . $row["movie_quantity"] . '</p>';
                echo '<button>Buy It</button>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }

        $movie_db->dbconnection->close();
        ?>
    </div>
</div>