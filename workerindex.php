<?php
include 'config/config.php';
include 'config/reviewsgetting.php';
session_start();
$_SESSION['user_role'] = 'worker';

if (!isset($_SESSION['worker_name'])) {
    header('location:login_form.php');
}

// Check if the admin is logged in
if (!isset($_SESSION['worker_name']) && !isset($_SESSION['user_name'])) {
    header('location:login.php');
    exit(); // Stop further execution to prevent displaying the worker page content
}

// Check if the user has admin privileges
if (isset($_SESSION['worker_name']) && $_SESSION['user_role'] !== 'worker') {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
</head>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Danielas Beauty</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">


                <li class="nav-item">
                    <a class="nav-link" href="procedures_times.php">Procedure Time Adding</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="employee_procedures.php">Your procedure</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="employee_reviews_control.php">Your Procedure Reviews</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>


            </ul>
        </div>
    </div>
</nav>

<body>
    <div class="container mt-5">
        <h1>Employee index page </h1>
    </div>

    <div class="container mt-5">
        <a href="employee_procedures.php">Your procedures</a>
        <a href="procedures_times.php">Add procedure times</a>
    </div>