<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config/config.php'; 

session_start();
$_SESSION['user_role'] = 'worker';

if (!isset($_SESSION['worker_name'])) {
    header('location:login_form.php');
}

// Check if the user is logged in as a worker 
if (!isset($_SESSION['worker_name'])) {
    header('location:login.php');
    exit(); 
}


if ($_SESSION['user_role'] !== 'worker') {
    
    header('location:access_denied.php');
    exit(); 
}

// Adding time for procedure function
function addProcedureTime($procedure_id, $date, $time)
{
    global $db; //database insertion

    // Data sending
    $stmt = $db->prepare("INSERT INTO procedure_times (procedure_id, date, time) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $procedure_id);
    $stmt->bindParam(2, $date);
    $stmt->bindParam(3, $time);
    $success = $stmt->execute();

    return $success;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $procedure_id = $_POST["procedure"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    // Function calling to do the function
    addProcedureTime($procedure_id, $date, $time);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Procedure Time</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Danielas Beauty</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        <h1>Add Procedure Time</h1>
        <form method="POST">
            <div class="form-group">
                <label for="procedure">Select Procedure:</label>
                <select id="procedure" name="procedure" class="form-control" required>
                    <?php
                    // Select procedure name and id
                    $query = $db->query("SELECT * FROM procedures");
                    $procedures = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($procedures as $procedure) {
                        echo '<option value="' . $procedure['Procedure_ID'] . '">' . $procedure['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Add Time</button>
        </form>
    </div>
</body>

</html>
