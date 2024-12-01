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

// Fetch user's rental history
$user_id = $_SESSION['user_id'];
$sql = "SELECT dresses.dress_name, rentals.rent_date, rentals.return_date 
        FROM rentals
        JOIN dresses ON rentals.dress_id = dresses.id
        WHERE rentals.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <ul>
            <li><a href="ind.php">Home</a></li>
            <li><a href="browse.php">Browse Dresses</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="signout.php">Logout</a></li>
        </ul>
    </nav>

    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

    <h2>Your Rental History</h2>
    <table border="1">
        <tr>
            <th>Dress Name</th>
            <th>Rent Date</th>
            <th>Return Date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['dress_name']}</td>
                        <td>{$row['rent_date']}</td>
                        <td>" . ($row['return_date'] ? $row['return_date'] : 'Not Returned') . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>You haven't rented any dresses yet.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
  