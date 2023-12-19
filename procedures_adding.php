<?php
include 'config/config.php';
include 'procedure_control.php';
session_start();
$_SESSION['user_role'] = 'admin';

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])) {
    header('location:login.php');
    exit(); // Stop further execution to prevent displaying the admin page content
}

// Check if the user has admin privileges
if (isset($_SESSION['admin_name']) && $_SESSION['user_role'] !== 'admin') {
    // Redirect to another page or display an error message
    header('location:access_denied.php');
    exit(); // Stop further execution to prevent displaying the admin page content
}

//using for procedure adding
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $info = $_POST["info"];
    $price = $_POST["price"];

    // Perform validation if the procedure doesn't already exist in the database
    $sql_check = "SELECT * FROM procedures WHERE name = :name";
    $result_check = $db->prepare($sql_check);
    $result_check->bindParam(':name', $name);
    $result_check->execute();

    if ($result_check->rowCount() == 0) {
        $sql_insert = "INSERT INTO procedures (name, info, price) VALUES (:name, :info, :price)";
        $result_insert = $db->prepare($sql_insert);
        $result_insert->bindParam(':name', $name);
        $result_insert->bindParam(':info', $info);
        $result_insert->bindParam(':price', $price);
        $result_insert->execute();
    }
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
                    <a class="nav-link" href="reviews.php">Reviews</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>


            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Add Procedure</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">Procedure Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="info">Procedure Description:</label>
            <textarea class="form-control" id="info" name="info" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" min="1" step="any" class="form-control" id="price" name="price" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Procedure</button>
    </form>
</div>