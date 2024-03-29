<?php
include 'config/config.php';
include 'config/reviewsgetting.php';
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


    <!--Displaying pending reviews-->
    


    
<div class="row mt-4 ">
            <!-- Display approved reviews here (you can use the same card structure as before) -->
            <div class="container">
                <h1 class="mt-5 text-center">Customer Reviews</h1>
                <?php foreach ($reviews as $reviews) : ?>
                    <div class="row mt-4">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $reviews['reviewer_name'] ?></h5>
                                    <p class="card-text"><?php echo $reviews['review'] ?></p>
                                    <!--FORM TO do actions with reviews-->
                                    <form action="" method="POST">
                                        <input type="hidden" name="review_id" value="<?php echo $review['review_id']?>">
                                        <button type="submit" name="delete_review" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>

                <?php endforeach ?>
            </div>
        </div>