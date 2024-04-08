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
    <h1>Add procedure time</h1>
    <form action="add_procedure_time.php" method="POST">
        <label for="procedure">Select procedure:</label>
        <select id="procedure" name="procedure">
        <?php
            // Select procedure name
            $query = $db->query("SELECT * FROM procedures");
            $procedures = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($procedures as $procedure) {
                echo '<option value="' . $procedure['id'] . '">' . $procedure['name'] . '</option>';
            }
            ?>
        </select><br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date"><br><br>
        <label for="time">Time:</label>
        <input type="time" id="time" name="time"><br><br>
        <button type="submit">Add Time</button>
    </form>
</body>