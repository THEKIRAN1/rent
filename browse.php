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

// Handle Rent and Return actions
if (isset($_GET['rent_id'])) {
    $rent_id = intval($_GET['rent_id']);  // Ensuring rent_id is an integer
    $user_id = $_SESSION['user_id'];
    $rent_date = date('Y-m-d H:i:s');

    // Check if the dress is available
    $sql_check = "SELECT is_rented FROM dresses WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $rent_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        if ($row['is_rented'] == 1) {
            echo "<p>This dress is already rented.</p>";
        } else {
            // Rent the dress
            $sql_update = "UPDATE dresses SET is_rented = 1 WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("i", $rent_id);
            $stmt_update->execute();

            // Insert rental record
            $sql_insert = "INSERT INTO rentals (dress_id, user_id, rent_date) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iis", $rent_id, $user_id, $rent_date);
            if ($stmt_insert->execute()) {
                echo "<p>Dress rented successfully!</p>";
            } else {
                echo "<p>Error renting dress: " . $conn->error . "</p>";
            }
        }
    } else {
        echo "<p>Invalid dress ID.</p>";
    }
} elseif (isset($_GET['return_id'])) {
    $return_id = intval($_GET['return_id']);  // Ensuring return_id is an integer
    $user_id = $_SESSION['user_id'];
    $return_date = date('Y-m-d H:i:s');

    // Update the dress status and rental return date
    $sql_update_dress = "UPDATE dresses SET is_rented = 0 WHERE id = ?";
    $stmt_update_dress = $conn->prepare($sql_update_dress);
    $stmt_update_dress->bind_param("i", $return_id);
    $stmt_update_dress->execute();

    $sql_update_rental = "UPDATE rentals SET return_date = ? WHERE dress_id = ? AND user_id = ? AND return_date IS NULL";
    $stmt_update_rental = $conn->prepare($sql_update_rental);
    $stmt_update_rental->bind_param("sii", $return_date, $return_id, $user_id);
    if ($stmt_update_rental->execute()) {
        echo "<p>Dress returned successfully!</p>";
    } else {
        echo "<p>Error returning dress: " . $conn->error . "</p>";
    }
}

// Fetch available dresses
$sql = "SELECT * FROM dresses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Dresses</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
    <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="ind.php">Browse Dresses</a></li>
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <h1>Available Dresses</h1>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Size</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['dress_name'] ?></td>
                    <td><?= $row['size'] ?></td>
                    <td>$<?= $row['price'] ?></td>
                    <td><?= $row['is_rented'] ? "Rented" : "Available" ?></td>
                    <td>
                        <?php if (!$row['is_rented']): ?>
                            <a href="browse.php?rent_id=<?= $row['id'] ?>">Rent</a>
                        <?php else: ?>
                            <a href="browse.php?return_id=<?= $row['id'] ?>">Return</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No dresses available.</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
