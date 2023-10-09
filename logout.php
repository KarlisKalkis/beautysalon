<?php
session_start();

// Destroy all session variables
session_destroy();

// Redirect the user to the login page or any other desired page
header("Location: index.php");
exit();
?>