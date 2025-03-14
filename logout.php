<?php
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION = [];
header('Location: index.php');
exit();
