<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../MOVIE/database/moviesdb.php";

$movie_db =  new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $movie_db->dbconnection->real_escape_string($POST['username']);
    $password = $movie_db->dbconnection->real_escape_string($POST['password']);
    $email = $movie_db->dbconnection->real_escape_string($_POST['email']);
    $profile = $movie_db->dbconnection->real_escape_string($_POST['profile_picture']);
}
$query = "SELECT *  FROM  accounts WHERE email  =$email ";
$result = $movie_db($movie_db, $query);

$img_profile = [];
if (isset($_FILES['profile_picture']) && ! empty($_FILES['profile-picture']['username'][0])) {
    $upload_dir = "../MOVIE/images/profile_pictures/";
    $file_name = $_FILES['profile_picture']['name'];
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_size = $_FILES['profile_picture']['size'];
    $file_type = $_FILES['profile_picture']['type'];
    $file_error = $_FILES['profile_picture']['error'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_name = uniqid('', true) . '.' . $file_ext;
    $file_path = $upload_dir . $file_name;
    $file_size_limit = 2 * 1024 * 1024; // 2MB
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $allowed_img_type = ['image/jpeg', 'image/png', 'image/gif'];
    $allowed_img_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $allowed_img_size = 2 * 1024 * 1024; // 2MB
    $allowed_img_size_limit = 2 * 1024 * 1024; // 2MB
    $allowed_img_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $allowed_img_type = ['image/jpeg', 'image/png', 'image/gif'];
    $allowed_img_size = 2 * 1024 * 1024; // 2MB 
    $allowed_img_size_limit = 2 * 1024 * 1024; // 2MB
    $allowed_img_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $allowed_img_type = ['image/jpeg', 'image/png', 'image/gif'];





    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    $allowed_img_type = ['image/jpeg', 'image/png', 'image/gif'];
}
$stmt = $movie_db->dbconnection->prepare("INSERT INTO user (username , email , password , profile_picture) 
    VALUES (?,?,?,?)");

$stmt->bind_param("ssssssss", $username, $emial, $password, $profile);
