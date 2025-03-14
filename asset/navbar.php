<link rel="stylesheet" href="style/navbar.css">
<header>
    <nav id="desktop-nav" class="navbar-blur">
        <div class="nav-logo">
            <img src="images/logo/logo.png">
        </div>
        <div class="logo">SCREEN SAGA</div>
        <div>
            <ul class="nav-links">
                <li><a href="?page=home">HOME</a></li>
                <li><a href="?page=comedy">COMEDY</a></li>
                <li><a href="?page=fantasy">FANTASY</a></li>
                <li><a href="?page=superhero">SUPERHERO</a></li>
                <?php if (isset($_SESSION['profile'])): ?>
                    <div class="user-info">
                        <div class="user-avatar">
                            <?php
                                // Assuming you have a database connection established
                                $userId = $_SESSION['profile'];
                                $query = "SELECT avatar FROM users WHERE id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $userId);
                                $stmt->execute();
                                $stmt->bind_result($avatar);
                                $stmt->fetch();
                                $stmt->close();
                            ?>
                            <img src="uploads/avatars/<?php echo htmlspecialchars($avatar); ?>" alt="User Avatar">
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['login_in']) && $_SESSION['login_in'] === 'yes'): ?>
                    <li><a href="logout.php">LOGOUT</a></li>
                <?php else : ?>
                    <li><a href="?page=login">LOGIN</a></li>
                    <li><a href="?page=signup">SIGN UP</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>