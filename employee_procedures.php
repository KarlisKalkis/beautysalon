<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config/config.php'; 


session_start();
$_SESSION['user_role'] = 'worker';

if (!isset($_SESSION['worker_name'])) {
    header('location:login_form.php');
}

// Checks if worker is inside session
if (!isset($_SESSION['worker_name'])) {
    header('location:login.php');
    exit(); 
}


if ($_SESSION['user_role'] !== 'worker') {
    
    header('location:access_denied.php');
    exit(); 
}

$sql = "SELECT 
p.name,
u.firstname, 
u.lastname, 
u.phonenumber, 
o.Order_ID, 
o.Date, 
o.Time, 
o.price 
FROM orders o 
LEFT JOIN users u ON u.user_id = o.user_id
LEFT JOIN procedures p ON p.Procedure_ID = o.Procedure_ID
WHERE o.Procedure_ID IS NOT NULL
AND o.Date >= CURDATE()
AND (o.Date >= CURDATE() OR o.Date IS NULL)
AND (o.Time >= CURRENT_TIME() OR o.Time IS NULL);";

$stmtselect = $db->prepare($sql);
if ($stmtselect->execute()) {
    $orders = $stmtselect->fetchAll();
} else {
    echo 'there were errors saving data';
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

<div class="container">
        <h1 class="mt-5 text-center">Your upcoming procedures</h1>
        <?php foreach ($orders as $order) : ?>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Procedure name: <?php echo $order['name'] ?></h5>
                            <p class="card-text">Contact number for client:  <?php echo $order['phonenumber'] ?></p>
                            <p class="card-text">First name: <?php echo $order['firstname'] ?></p>
                            <p class="card-text">Last name: <?php echo $order['lastname'] ?></p>
                            <p class="card-text">Procedure price: <?php echo $order['price'] ?></p>
                            <p class="card-text">Date: <?php echo $order['Date']?></p>
                            <p class="card-text">Time: <?php echo $order['Time']?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

