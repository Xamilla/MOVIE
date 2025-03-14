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
    <link rel="stylesheet" href="style/section.css">
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
        } else {
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
</body>

</html>