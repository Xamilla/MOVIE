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
</body>

</html>