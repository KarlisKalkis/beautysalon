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
    // Redirect to another page 
    header('location:access_denied.php');
    exit(); // Stop further execution to prevent displaying the admin page content
}

//using for procedure adding
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name']) && isset($_POST['info']) && isset($_POST['price']) ) {
    $name = $_POST["name"];
    $info = $_POST["info"];
    $price = $_POST["price"];

    
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
<!--Code to show existing procedures-->
<?php $sql = "SELECT * FROM procedures";
$stmtselect = $db->prepare($sql);
if ($stmtselect->execute()) {
    $procedures = $stmtselect->fetchAll();
} else {
    echo 'there were errors saving data';
} ?>




<!--Deleting procedure-->
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_procedure'])) {
    // Retrieves the review ID from the form
    $Procedure_ID = $_POST['Procedure_ID'];

    // Process to delete review
    $deleteProcedure = "DELETE FROM procedures WHERE Procedure_ID = ?";
    $stmt = $db->prepare($deleteProcedure);
    $stmt->execute([$Procedure_ID]);

    
    header('Location: procedures_adding.php');
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
        <a class="navbar-brand" href="admin_page.php">Danielas Beauty Admin page</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">


                <li class="nav-item">
                    <a class="nav-link" href="procedures_adding.php">Procedures</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products_adding.php">Products</a>
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

        <div class="form-group pt-3">
            <label for="price">Price:</label>
            <input type="number" min="1" step="any" class="form-control" id="price" name="price" required></textarea>
        </div>
        <br>
        <button type="submit " class="btn btn-primary">Add Procedure</button>
    </form>
</div>

<div class="container mt-5">
    <h2>Existing procedures in system</h2>
    <div class="container mt-5">
        <div class='row pt-5 p-4'>
            <?php foreach ($procedures as $procedures) : ?>
                <div class="col-md-6 pb-2 d-flex ml-4 p-3">
                    <div class="card col-sm-10 ml-4 p-3" style="max-width: 300px;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $procedures['name'] ?></h5>
                            <p class="card-text"><?php echo $procedures['info'] ?></p>
                            <p class="card-text text-danger"><?php echo $procedures['price'] ?> EIRO</p>

                            <!-- Hidden input for getting procedure id -->
                            <form method="POST">
                                <input type="hidden" name="Procedure_ID" value="<?php $procedures['Procedure_ID']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_procedure">Delete</button>
                            </form>
                        </div>
                    </div>


                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>


