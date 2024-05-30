<?php
session_start();

// Destroy all session variables
unset($_SESSION["userLogin"]);
session_destroy();

// Redirecting to index page when user loged out
header("Location: index.php");
exit();
?>