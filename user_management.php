<?php
@include 'config.php';
session_start();
$_SESSION['user_role'] = 'admin';

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])) {
    header('location:login.php');
    exit();
}


if (isset($_SESSION['admin_name']) && $_SESSION['user_role'] !== 'admin') {
    // Redirect to another page or display an error message
    header('location:access_denied.php');
    exit();
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
                        <a class="nav-link" href="procedures_adding.php">Procedures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reviews_control.php">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    
                    
                </ul>
            </div>
        </div>
    </nav>
    <?php $sql = "SELECT * FROM users";
        $stmtselect = $db->prepare($sql);
    if ($stmtselect->execute()) {
        $users = $stmtselect->fetchAll();
    } else {
        echo 'there were errors saving data';
} ?>

    <div class="d-flex flex-row">
        <?php foreach ($users as $users) : ?>
        <div class="p-2">Flex item 1</div>
    </div>