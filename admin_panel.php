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

// Fetch rented dresses and rent history
$sql_rent_history = "SELECT dresses.id, dresses.dress_name, dresses.size, dresses.price, rentals.rent_date, rentals.return_date, users.username AS rented_by 
                     FROM rentals
                     JOIN dresses ON rentals.dress_id = dresses.id
                     JOIN users ON rentals.user_id = users.id
                     ORDER BY rentals.rent_date DESC";
$stmt_rent_history = $conn->prepare($sql_rent_history);
$stmt_rent_history->execute();
$result_rent_history = $stmt_rent_history->get_result();

// Fetch all dresses for management
$sql_dresses = "SELECT * FROM dresses";
$stmt_dresses = $conn->prepare($sql_dresses);
$stmt_dresses->execute();
$result_dresses = $stmt_dresses->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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

    <h1>Admin Dashboard</h1>

    <h2>Manage Dresses</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Dress Name</th>
            <th>Size</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result_dresses->num_rows > 0) {
            while ($dress = $result_dresses->fetch_assoc()) {
                echo "<tr>
                        <td>{$dress['id']}</td>
                        <td>{$dress['dress_name']}</td>
                        <td>{$dress['size']}</td>
                        <td>\${$dress['price']}</td>
                        <td>" . ($dress['is_rented'] ? 'Rented' : 'Available') . "</td>
                        <td>
                            <a href='edit_dress.php?id={$dress['id']}'>Edit</a> |
                            <a href='delete_dress.php?id={$dress['id']}' onclick='return confirm(\"Are you sure you want to delete this dress?\")'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No dresses found.</td></tr>";
        }
        ?>
    </table>

    <h2>Rent History</h2>
    <table border="1">
        <tr>
            <th>Dress ID</th>
            <th>Dress Name</th>
            <th>Size</th>
            <th>Price</th>
            <th>Rented By</th>
            <th>Rent Date</th>
            <th>Return Date</th>
        </tr>
        <?php
        if ($result_rent_history->num_rows > 0) {
            while ($row = $result_rent_history->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['dress_name']}</td>
                        <td>{$row['size']}</td>
                        <td>\${$row['price']}</td>
                        <td>{$row['rented_by']}</td>
                        <td>{$row['rent_date']}</td>
                        <td>" . ($row['return_date'] ? $row['return_date'] : 'Not Returned') . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No rent history found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
