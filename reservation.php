<?php
session_start();

include 'config/config.php';
include 'includeformainpages/header.php';

// Check if the user is logged in as a user
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





if (isset($_GET['Procedure_ID'])) {
    $procedureId = $_GET['Procedure_ID'];

    // Fetch procedure details and available times based on Procedure_ID
    $sql = "
    SELECT p.*, rt.start_time
    FROM procedures p
    LEFT JOIN reservation_times rt ON p.Procedure_ID = rt.procedure_id
    WHERE p.Procedure_ID = :procedureId
    ";
    $stmtselect = $db->prepare($sql);
    $stmtselect->bindParam(':procedureId', $procedureId, PDO::PARAM_INT);

    if ($stmtselect->execute()) {
        $procedure = $stmtselect->fetch(PDO::FETCH_ASSOC);

        // Now you have the details of the selected procedure in the $procedure variable
        // You can use this information to display the reservation details or process the reservation
    } else {
        echo 'There were errors fetching procedure data';
    }
} else {
    // Redirect to the page where procedure selection is done if Procedure_ID is not provided
    header('Location: procedures.php');
    exit();
}



?>



<!-- HTML RESERVATION DETAILS -->
<div class="container mt-1 pt-5">
    <div class="row d-flex">
        <div class="col-md-12 text-center">
            <h2 class="navbar-brand">Reservation Details</h2>
        </div>
    </div>
</div>

<div class="row pt-5 p-4">
    <div class="col-md-6 pb-2 d-flex ml-4 p-3">
        <!-- Display reservation details based on $procedure variable -->
        <div class="card col-sm-10 ml-4 p-3" style="max-width: 300px;">
            <!-- Display procedure information -->
            <h5 class="card-title"><?php echo $procedure['name'] ?></h5>
            <p class="card-text"><?php echo $procedure['info'] ?></p>
            <p class="card-text text-danger"><?php echo $procedure['price'] ?> EIRO</p>
        </div>
    </div>

    <div class="col-md-6 pb-2 d-flex ml-4 p-3">
        <!-- Display reservation times -->
        <p class="card-text">Reservation Times: <?php echo $procedure['start_time']; ?></p>

        <!-- Additional reservation form or details can be added here -->

        <!-- Time Picker for choosing reservation time -->
        <form action="process_reservation.php" method="post">
            <div class="form-group">
                <label for="reservationTime">Choose Reservation Time:</label>
                <input type="time" class="form-control" id="reservationTime" name="reservationTime" required>
            </div>
            <!-- Hidden input for passing information about procedure and passing user_id -->
            <input type="hidden" name="Procedure_ID" value="<?php echo $procedure['Procedure_ID']; ?>">
            <input type="hidden" name="price" value="<?php echo $procedure['price']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <button type="submit" class="btn btn-primary">Reserve</button>
        </form>
    </div>
</div>


<?php
// Include Bootstrap JS and jQuery

?>