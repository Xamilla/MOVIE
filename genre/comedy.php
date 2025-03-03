<link rel="stylesheet" href="style/genre.css">
<div class="comedy-container">
        <h1>Comedy Movies</h1>
        <div class="movie-grid">
            <?php
            // Example data for movies
            $movies = [
                ["title" => "Movie 1", "price" => "$10", "author" => "Author 1", "image" => "images/comedy/accepted.jpg", "video" => "videos/comedy/movie1.mp4", "summary" => "Summary of Movie 1"],
                ["title" => "Movie 2", "price" => "$12", "author" => "Author 2", "image" => "images/comedy/movie2.jpg", "video" => "videos/comedy/movie2.mp4", "summary" => "Summary of Movie 2"],
                ["title" => "Movie 3", "price" => "$15", "author" => "Author 3", "image" => "images/comedy/movie3.jpg", "video" => "videos/comedy/movie3.mp4", "summary" => "Summary of Movie 3"],
                ["title" => "Movie 4", "price" => "$8", "author" => "Author 4", "image" => "images/comedy/movie4.jpg", "video" => "videos/comedy/movie4.mp4", "summary" => "Summary of Movie 4"],
                ["title" => "Movie 5", "price" => "$20", "author" => "Author 5", "image" => "images/comedy/movie5.jpg", "video" => "videos/comedy/movie5.mp4", "summary" => "Summary of Movie 5"],
                ["title" => "Movie 6", "price" => "$10", "author" => "Author 6", "image" => "images/comedy/movie6.jpg", "video" => "videos/comedy/movie6.mp4", "summary" => "Summary of Movie 6"],
                ["title" => "Movie 7", "price" => "$12", "author" => "Author 7", "image" => "images/comedy/movie7.jpg", "video" => "videos/comedy/movie7.mp4", "summary" => "Summary of Movie 7"],
                ["title" => "Movie 8", "price" => "$15", "author" => "Author 8", "image" => "images/comedy/movie8.jpg", "video" => "videos/comedy/movie8.mp4", "summary" => "Summary of Movie 8"],
                ["title" => "Movie 9", "price" => "$8", "author" => "Author 9", "image" => "images/comedy/movie9.jpg", "video" => "videos/comedy/movie9.mp4", "summary" => "Summary of Movie 9"],
                ["title" => "Movie 10", "price" => "$20", "author" => "Author 10", "image" => "images/comedy/movie10.jpg", "video" => "videos/comedy/movie10.mp4", "summary" => "Summary of Movie 10"],
            ];

            foreach ($movies as $movie) {
                echo '<div class="movie-item">';
                echo '<div class="movie-image">';
                echo '<img src="' . $movie["image"] . '" alt="' . $movie["title"] . '">';
                echo '<video src="' . $movie["video"] . '" muted></video>';
                echo '<div class="summary">' . $movie["summary"] . '</div>';
                echo '</div>';
                echo '<h2>' . $movie["title"] . '</h2>';
                echo '<p>Price: ' . $movie["price"] . '</p>';
                echo '<p>Author: ' . $movie["author"] . '</p>';
                echo '<button>Buy It</button>';
                echo '</div>';
            }
            ?>
        </div>
    </div>