<?php
session_start();
$_SESSION['user_role'] = 'user';
?>
<?php include 'includeformainpages/header.php'?>
<?php include 'config/config.php'?>

<?php 
if (isset($_SESSION['user_name'])){
    $loggedInUserEmail = $_SESSION['user_name'];
    
    $select = "SELECT * FROM users WHERE email = '$loggedInUserEmail'";
    $result = $db->query($select);
}

if ($result && $result->rowCount() > 0) {
    $userData = $result->fetch();

} else {
    echo "User profile data not found.";
}

if (isset($_GET['Procedure_ID'])){
    $Procedure_ID = $_GET['Procedure_ID'];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $user_id = $_SESSION['user_id'];
        
    }
}

//code to push reservation to database
try{
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $selectedTime = $_POST["procedureTime"];

        $user_id = $userData['user_id'];

        //data inserting
        $stmt = $db->prepare("INSERT INTO orders (Time, user_id) Values (:selectedTime, '$user_id')");
        $stmt->bindParam(':selectedTime', $selectedTime);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-3'>Procedure scheduled for: $selectedTime</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: Unable to insert data</div>";
        }
    }
}catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
} finally {
    // Close the database connection
    $conn = null;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Procedure Time Selection</title>
</head>
<body>

  <div class="container">
    <h1 class="mt-5">Select Procedure Time</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Process the form data (you can replace this with your logic)
      $selectedTime = $_POST["procedureTime"];
      echo "<div class='alert alert-success mt-3'>Procedure scheduled for: $selectedTime</div>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label for="procedureTime" class="form-label">Select Time:</label>
        <select class="form-select" id="procedureTime" name="procedureTime" required>
          <option value="" selected disabled>Select a time</option>
          <option value="09:00:00">09:00 AM</option>
          <option value="10:00 AM">10:00 AM</option>
          <option value="11:00 AM">11:00 AM</option>
          <!-- Add more options as needed -->
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <!-- Bootstrap JS (optional, if you need some Bootstrap features) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
