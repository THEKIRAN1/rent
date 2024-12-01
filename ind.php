<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentDress</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="browse.php">Browse Dresses</a></li>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
            <?php else: ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="home.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <header>
        <h1>Welcome to RentDress</h1>
        <p>Your one-stop destination to rent the most stylish dresses for any occasion!</p>
        <?php if (isset($_SESSION['username'])): ?>
            <p>Hello, <?php echo $_SESSION['username']; ?>! <a href="browse.php">Browse Dresses</a></p>
        <?php endif; ?>
    </header>
</body>
</html>
