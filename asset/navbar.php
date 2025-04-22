<header>
    <div class="my-name">
        <h6>CAMILLE TAN BAROLA BSIT 3-S</h6>
    </div>
    <nav id="desktop-nav" class="navbar-blur">
        <div class="nav-logo">
            <img src="images/logo/logo.png" alt="Logo">
        </div>
        <div class="logo">SCREEN SAGA</div>
        <div>
            <ul class="nav-links">
                <li><a href="?page=home">HOME</a></li>
                <li><a href="?page=comedy">COMEDY</a></li>
                <li><a href="?page=fantasy">FANTASY</a></li>
                <li><a href="?page=superhero">SUPERHERO</a></li>

                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'yes'): ?>
                    <li><a href="?page=addmovie">ADD</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['login_in']) && $_SESSION['login_in'] === 'yes'): ?>
                    <li><a href="logout.php">LOGOUT</a></li>
                <?php else: ?>
                    <li><a href="?page=login">LOGIN</a></li>
                    <li><a href="?page=signup">SIGN UP</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['id'])): ?>
                    <?php
                    require_once "../MOVIE/database/moviesdb.php";

                    $movie_db = new Database();
                    $conn = $movie_db->dbconnection;

                    $userId = $_SESSION['id'];
                    $query = "SELECT profile_picture, username, email, created_at FROM accounts WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $stmt->bind_result($avatar, $username, $email, $created_at);
                    $stmt->fetch();
                    $stmt->close();
                    ?>

                    <li>
                        <div class="user-avatar" title="<?php echo htmlspecialchars($username); ?>" onclick="showUserInfo()">
                            <?php if (!empty($avatar) && file_exists("images/profiles/" . $avatar)): ?>
                                <img src="images/profiles/<?php echo htmlspecialchars($avatar); ?>" alt="<?php echo htmlspecialchars($username); ?>">
                            <?php else: ?>
                                <div class="avatar-placeholder"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Modal Structure (Initially Hidden) -->
    <div id="user-info-modal" class="user-info-modals">
        <div class="modals-content">
            <span class="close-button" onclick="closeUserInfo()">&times;</span>

            <?php if (isset($_SESSION['id'])): ?>
                <h2>WELCOME BACK <?php echo htmlspecialchars($username); ?>😘</h2>
                <?php if (!empty($avatar) && file_exists("images/profiles/" . $avatar)): ?>
                    <img src="images/profiles/<?php echo htmlspecialchars($avatar); ?>" alt="<?php echo htmlspecialchars($username); ?>" class="user-modal-avatar">
                <?php else: ?>
                    <div class="avatar-placeholder modal-avatar"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                <?php endif; ?>

                <p id="user-info-username">Username: <?php echo htmlspecialchars($username); ?></p><br><br>
                <p id="user-info-email">Email: <?php echo htmlspecialchars($email); ?></p>
                <p id="user-info-created">Created: <?php echo htmlspecialchars($created_at); ?></p>
                <a href="logout.php" class="logout-btn">LOGOUT</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- hamburger menu -->
    <!-- Modified Mobile Navigation Structure -->
    <div class="hamburger-menu">
        <div class="hamburger-icon" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="mobile-menu">
            <div class="mobile-close" onclick="toggleMobileMenu()">✕</div>
            <div class="menu-container">
                <h2>Camille Barola</h2>
                <ul class="menu-links">
                    <li><a href="?page=home">HOME</a></li>
                    <li><a href="?page=comedy">COMEDY</a></li>
                    <li><a href="?page=fantasy">FANTASY</a></li>
                    <li><a href="?page=superhero">SUPERHERO</a></li>

                    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'yes'): ?>
                        <li><a href="addmovies.php">ADD</a></li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['login_in']) && $_SESSION['login_in'] === 'yes'): ?>
                        <li><a href="logout.php">LOGOUT</a></li>
                    <?php else: ?>
                        <li><a href="?page=login">LOGIN</a></li>
                        <li><a href="?page=signup">SIGN UP</a></li>
                    <?php endif; ?>
                </ul>

                <?php if (isset($_SESSION['id'])): ?>
                    <div class="mobile-profile">
                        <?php if (!empty($avatar) && file_exists("images/profiles/" . $avatar)): ?>
                            <img src="images/profiles/<?php echo htmlspecialchars($avatar); ?>" alt="<?php echo htmlspecialchars($username); ?>">
                        <?php else: ?>
                            <div class="avatar-placeholder"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($username); ?></h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>