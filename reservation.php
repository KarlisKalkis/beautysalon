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
    SELECT p.*, pt.time, pt.date
    FROM procedures p
    LEFT JOIN procedure_times pt ON p.Procedure_ID = pt.procedure_id
    WHERE p.Procedure_ID = :procedureId
    and (pt.time > curdate() or pt.time is null)
    and (pt.date > curdate() or pt.date is null)
    ";
    $stmtselect = $db->prepare($sql);
    $stmtselect->bindParam(':procedureId', $procedureId, PDO::PARAM_INT);

    if($stmtselect->execute()) {
        $procedure = $stmtselect->fetch(PDO::FETCH_ASSOC);
        $stmtselect->execute();
        $availableTimes = $stmtselect->fetchAll(PDO::FETCH_ASSOC);
    }else{
        echo "There were errors fetching data";
    }

    if ($stmtselect->execute()) {
        $procedure = $stmtselect->fetch(PDO::FETCH_ASSOC);

    } else {
        echo 'There were errors fetching procedure data';
    }
} else {
    // Redirect to the page where procedure selection is done if Procedure_ID is not provided
    header('Location: procedures.php');
    exit();
}


if($_SERVER['REQUEST_METHOD'] === "POST"){
    $reservationTime = $_POST['$reservationTime'];
    $price = $_POST['price'];
    $userID = $_POST['user_id'];
    $reservationDate = $_POST['reservationDate'];

    //transaction to delete from available times to orders table in database
    $db ->beginTransaction();

    //deleting from reservationtimes table
    $deleteSQL = "DELETE FROM procedure_times where procedure_id = :procedureID AND time = :reservationTime 
    and date = :reservationDate";
    $stmtDelete = $db -> prepare($deleteSQL);
    $stmtDelete->bindParam(':procedure_id', $procedureId, PDO::PARAM_INT);
    $stmtDelete->bindParam(':reservationTime', $reservationTime, PDO::PARAM_STR);
    $stmtDelete->bindParam(':reservationDate', $reservationDate, PDO::PARAM_STR);
    $stmtDelete ->execute();

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
            <!-- Displaying procedure information -->
            <h5 class="card-title"><?php echo $procedure['name']?></h5>
            <p class="card-text"><?php echo $procedure['info'] ?></p>
            <p class="card-text text-danger"><?php echo $procedure['price'] ?> EIRO</p>
        </div>
    </div>

    <div class="col-md-6 pb-2 d-flex ml-4 p-3">
        <!-- Choosing time from available times -->
        <form action="process_reservation.php" method="post">
            <div class="form-group">
                
                <div class="form-group">
                <label for="reservationTime">Available times</label>
                <select class="form-control" id="reservationTime" name="reservationTime" required>
                    <?php foreach ($availableTimes as $time): ?>
                        <option value="<?php echo $time['time']; ?>">
                            <?php echo $time['time'];echo('  '); echo $time['date'];?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            </div>
            <!-- Hidden input for passing information about procedure and passing user_id -->
            <input type="hidden" name="Procedure_ID" value="<?php echo $procedure['Procedure_ID']; ?>">
            <input type="hidden" name="price" value="<?php echo $procedure['price']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="reservationDate" value="<?php echo $time['date']; ?>">
            <button type="submit" class="btn btn-primary">Reserve</button>
        </form>
    </div>
</div>


<?php
// Include Bootstrap JS and jQuery

?>