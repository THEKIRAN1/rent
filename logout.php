<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

session_abort();

// Redirect to the index page
header("Location: ind.php"); // Adjust this path if your index.php is in a different folder
exit();
?>
