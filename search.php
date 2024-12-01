<?php
// Start the session
session_start();

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

// Check if a search query is provided
$search_query = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

$sql = "SELECT * FROM dresses WHERE dress_name LIKE '%$search_query%' OR size LIKE '%$search_query%' OR price LIKE '%$search_query%'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="browse.php">Browse Dresses</a></li>
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    
    <h1>Search Results</h1>
    <?php if ($result && $result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Size</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['dress_name'] ?></td>
                    <td><?= $row['size'] ?></td>
                    <td>$<?= $row['price'] ?></td>
                    <td><?= $row['is_rented'] ? "Rented" : "Available" ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No results found for "<?= htmlspecialchars($search_query) ?>"</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
