<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config/config.php'; 

session_start();
$_SESSION['user_role'] = 'worker';

if (!isset($_SESSION['worker_name'])) {
    header('location:login_form.php');
}

// Check if the user is logged in as a worker or admin
if (!isset($_SESSION['worker_name'])) {
    header('location:login.php');
    exit(); 
}


if ($_SESSION['user_role'] !== 'worker') {
    
    header('location:access_denied.php');
    exit(); 
}
?>
