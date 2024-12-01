<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rentdress";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a dress ID is provided for renting
if (isset($_GET['rent_id'])) {
    $dress_id = intval($_GET['rent_id']);  // Ensuring dress_id is an integer
    $user_id = $_SESSION['user_id'];

    // Check if the dress is already rented
    $sql = "SELECT is_rented FROM dresses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dress_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['is_rented'] == 1) {
            echo "This dress is already rented.";
        } else {
            // Rent the dress
            $rent_date = date("Y-m-d");
            $update_sql = "UPDATE dresses SET is_rented = 1 WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $dress_id);
            $update_stmt->execute();

            // Record the rental in the rentals table
            $insert_sql = "INSERT INTO rentals (dress_id, user_id, rent_date) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iis", $dress_id, $user_id, $rent_date);

            if ($insert_stmt->execute()) {
                echo "Dress rented successfully! <a href='browse.php'>Back to Browse</a>";
            } else {
                echo "Error renting dress: " . $insert_stmt->error;
            }
        }
    } else {
        echo "Invalid dress ID.";
    }
}

$conn->close();
?>
