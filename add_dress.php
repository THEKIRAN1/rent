<?php
session_start();
// Check if user is logged in and if they are an admin
if (!isset($_SESSION['user_id']) || $_SESSION['username'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $dress_name = $_POST['dress_name'];
    $size = $_POST['size'];
    $price = $_POST['price'];

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

    // Insert new dress into the database
    $sql = "INSERT INTO dresses (dress_name, size, price, is_rented) VALUES ('$dress_name', '$size', '$price', 0)";
    
    if ($conn->query($sql) === TRUE) {
        echo "New dress added successfully! <a href='admin_panel.php'>Go back to Admin Dashboard</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Dress</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="admin_panel.php">Admin Dashboard</a></li>
            <li><a href="add_dress.php">Add New Dress</a></li>
            <li><a href="signout.php">Logout</a></li>
        </ul>
    </nav>

    <h1>Add New Dress</h1>
    <form method="POST" action="">
        <label for="dress_name">Dress Name:</label><br>
        <input type="text" id="dress_name" name="dress_name" required><br>

        <label for="size">Size:</label><br>
        <input type="text" id="size" name="size" required><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" required><br><br>

        <input type="submit" value="Add Dress">
    </form>
</body>
</html>
