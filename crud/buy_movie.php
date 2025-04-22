<?php
session_start();
include "../database/moviesdb.php";

// Check if user is logged in
if (!isset($_SESSION['login_in']) || $_SESSION['login_in'] !== 'yes') {
    // Redirect to login page if not logged in
    header("Location: ../index.php?page=login&message=Please log in to purchase movies");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];

    // Get quantity from form, default to 1 if not specified
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // Make sure quantity is at least 1
    if ($quantity < 1) {
        $quantity = 1;
    }

    $movie_db = new Database();
    $conn = $movie_db->dbconnection;

    // Fetch the current quantity and price
    $sql = "SELECT movie_quantity, price, movie_name FROM movies WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if enough stock is available
    if ($row['movie_quantity'] >= $quantity) {
        // Start transaction to ensure data consistency
        $conn->begin_transaction();

        try {
            // Update the quantity
            $new_quantity = $row['movie_quantity'] - $quantity;
            $update_sql = "UPDATE movies SET movie_quantity = ? WHERE movie_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ii", $new_quantity, $movie_id);
            $update_stmt->execute();

            // Calculate total price
            $total_price = $row['price'] * $quantity;

            // Record the purchase in the purchases table
            $user_id = $_SESSION['id'];
            $purchase_sql = "INSERT INTO purchases (user_id, movie_id, purchase_date, quantity, total_price) 
                            VALUES (?, ?, NOW(), ?, ?)";
            $purchase_stmt = $conn->prepare($purchase_sql);
            $purchase_stmt->bind_param("iiid", $user_id, $movie_id, $quantity, $total_price);
            $purchase_stmt->execute();

            // Commit the transaction
            $conn->commit();

            // Redirect back with success message
            $message = "Successfully purchased " . $quantity . " copy/copies of '" . $row['movie_name'] . "'!";
            header("Location: ../index.php?page=success&message=" . urlencode($message));
            exit;
        } catch (Exception $e) {
            // Roll back the transaction if something failed
            $conn->rollback();
            header("Location: ../index.php?page=error&message=Transaction failed: " . $e->getMessage());
            exit;
        }
    } else {
        // Redirect back with error message
        $message = "Sorry, only " . $row['movie_quantity'] . " copies available";
        header("Location: ../index.php?page=error&message=" . urlencode($message));
        exit;
    }

    $stmt->close();
    $conn->close();
}
