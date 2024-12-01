<?php
session_start();

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
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

// Check if a dress ID is provided for deletion
if (isset($_GET['id'])) {
    $dress_id = $_GET['id'];

    // Delete dress from database
    $sql = "DELETE FROM dresses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dress_id);

    if ($stmt->execute()) {
        echo "<p>Dress deleted successfully! <a href='admin_panel.php'>Back to Admin Dashboard</a></p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p>No dress ID provided for deletion.</p>";
}

$conn->close();
?>
