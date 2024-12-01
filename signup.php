<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Insert user data into database
    $sql = "INSERT INTO users (username, email, password) VALUES ('$user_name', '$user_email', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Sign Up successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
      height: 400px;
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
    <h1>Sign Up</h1>
    <form method="POST" action="">

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required><br>
    
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
     
        
    

    <!-- <label for="age">AGE:</label>
    <input type="number" id="age" name="age" required> -->
    <!-- <label for="Resaon">Reason:</label> -->
    <!-- <select id="text" id="Reason" name="Reason" required>
      <option value="Accdient">Accident</option>
      <option value="Reserve">Reserve</option> -->
    </select>


    <input type="submit" value="Submit">
    
  </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
    