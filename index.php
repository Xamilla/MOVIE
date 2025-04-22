<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camille T. Barola</title>
    <link rel="icon" href="images/logo/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/section.css">
    <link rel="stylesheet" href="style/genre.css">
    <link rel="stylesheet" href="style/watch.css">
    <link rel="stylesheet" href="style/notification.css">
</head>

<body>
    <?php
    include "asset/navbar.php";

    if (isset($_GET['page'])) {
        $page = $_GET['page'];

        if ($page == 'home') {
            include "asset/section.php";
        } else if ($page == 'comedy') {
            include "genre/comedy.php";
        } else if ($page == 'fantasy') {
            include "genre/fantasy.php";
        } else if ($page == "superhero") {
            include "genre/superheros.php";
        } else if ($page == 'signup') {
            include "logs/signup.php";
        } else if ($page == 'login') {
            include "logs/login.php";
        } else if ($page == 'success') {
            include "notification/success.php";
        } else if ($page == 'error') {
            include "notification/error.php";
        } else if ($page == 'addmovie') {
            include "crud/addmovie.php";
        } else if ($page == 'update'){
            include "crud/update.php";
        } else if ($page =='delete'){
            include "crud/delete_movie.php";
        }else {
            include "asset/section.php";
        }
    } else {
        include "asset/section.php";
    }
    ?>

    <?php
    include "asset/footer.php"
    ?>
    <script src="javascript/section.js"></script>
    <script src="javascript/footer.js"></script>
    <script src="../MOVIE/javascript/genre.js"></script>
    <script src="../MOVIE/javascript/navbar.js"></script>
</body>

</html>