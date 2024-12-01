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

// Handle the form submission to edit a dress
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $dress_id = $_GET['id'];
    $dress_name = $_POST['dress_name'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $is_rented = isset($_POST['is_rented']) ? 1 : 0;

    $sql = "UPDATE dresses SET dress_name = ?, size = ?, price = ?, is_rented = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $dress_name, $size, $price, $is_rented, $dress_id);

    if ($stmt->execute()) {
        echo "<p>Dress updated successfully! <a href='admin_panel.php'>Back to Admin Dashboard</a></p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Fetch the dress data to pre-populate the form for editing
if (isset($_GET['id'])) {
    $dress_id = $_GET['id'];
    $sql = "SELECT * FROM dresses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dress_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $dress = $result->fetch_assoc();
    } else {
        echo "<p>Dress not found.</p>";
        exit;
    }
} else {
    echo "<p>No dress selected for editing.</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dress</title>
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

    <h1>Edit Dress</h1>
    <form action="edit_dress.php?id=<?= $dress['id'] ?>" method="POST">
        <label for="dress_name">Dress Name:</label>
        <input type="text" name="dress_name" id="dress_name" value="<?= $dress['dress_name'] ?>" required><br>

        <label for="size">Size:</label>
        <input type="text" name="size" id="size" value="<?= $dress['size'] ?>" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" value="<?= $dress['price'] ?>" required><br>

        <label for="is_rented">Is Rented:</label>
        <input type="checkbox" name="is_rented" id="is_rented" <?= $dress['is_rented'] ? 'checked' : '' ?>><br>

        <button type="submit">Update Dress</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
