<?php
$password = 'admin123'; // Replace with your desired password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;
?>
