<?php 
@include 'config.php';
session_start();
$_SESSION['user_role'] = 'admin';

if (!isset($_SESSION['admin_name'])){
    header('location:login_form.php');
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])){
    header('location:login_form.php');
    exit(); // Stop further execution to prevent displaying the admin page content
}

// Check if the user has admin privileges
if (isset($_SESSION['admin_name']) && $_SESSION['user_role'] !== 'admin') {
    // Redirect to another page or display an error message
    header('location:access_denied.php');
    exit(); // Stop further execution to prevent displaying the admin page content
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">

        <div class="content">
            <h3>hi, <span>admin</span></h3>
            <h1>Welcome back <span></span></h1>
            <p>This is admin page</p>
            <a href="logout.php">logout</a>
        </div>
    </div>
</body>