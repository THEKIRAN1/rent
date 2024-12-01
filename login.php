<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rentdress";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    // Query to find the user
    $sql = "SELECT * FROM users WHERE email = '$user_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($user_password, $row['password'])) {
          // Correct password, log in
          $_SESSION['user_id'] = $row['id'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['email'] = $row['email'];  // Store role for role-based access
      
          // Redirect based on role
          if ($row['role'] === 'admin') {
              header("Location: admin_panel.php");
              exit;
          } else {
              header("Location: ind.php");
              exit;
          }
      } else {
          echo "Invalid password!";
      }
      
    } else {
        echo "User not found!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1ebeb;
    }

    h1 {
      text-align: center;
      color: #000000;
      padding-top: 20px;
    }
    p {
      text-align: center;
      color: #000000;
      padding-top: 20px;
    }
    

    form {
      width: 500px;
       background-color: #2c3e50;
      padding: 50px;
      margin: auto;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      height: 300px;
    }

    label {
      display: block;
      margin-top: 20px;
      color: #ffffff;
      margin: 20;
    }

    input[type="text"],
    input[type="password"],
    input[type="number"],
    input[type="tel"],
    input[type="email"],
    textarea,
    select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-top: 4px;
      margin-bottom: 12px;
    }


    input[type="submit"] {
      background-color: #a41e1e;
      color: white;
      padding: 15px;
      border: 1px;
      font-size: 16px;
      border-radius: 4px;
      width: 100%;
      cursor: pointer;
      height: 50px;
      margin-top: 20px;
    }

    input[type="submit"]:hover {
      background-color: #7e190b;
    }
  </style>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="">
    
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Submit">
    
  </form>
</body>
</html>
    <p>Don't have an account? <a href="signup.php">Sign Up here</a></p>
</body>
</html>
