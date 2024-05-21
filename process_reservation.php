<?php

session_start();

include 'config/config.php';

// Check if the user is logged in and retrieve user information
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

// Check if the user ID is present in the session
if (isset($_SESSION['user_id'])){
    $userID = $_SESSION['user_id'];

    // Check if the user exists in the users table
    $checkUser = "SELECT * FROM users WHERE user_id = :user_id";
    $stmtCheckUser = $db->prepare($checkUser);
    $stmtCheckUser->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $stmtCheckUser->execute();

    if ($stmtCheckUser->rowCount() == 0) {
        // User does not exist, handle accordingly (redirect or show an error message)
        echo 'User not found';
        exit();
    }
} else {
    // User ID not found in the session, handle accordingly (redirect or show an error message)
    echo 'User ID not found in the session';
    var_dump($_SESSION);
    var_dump($userData);
    exit();
}

//i
// Validate the form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationTime = $_POST['reservationTime'];
    $procedureID = $_POST['Procedure_ID'];
    $price = $_POST['price'];
    $userID = $_POST['user_id'];
    $reservationDate = $_POST['reservationDate'];

    // Validate and sanitize the inputs if needed

    try {
        // Begin a transaction
        $db->beginTransaction();

        // Delete the selected time from procedure_times
        $deleteSQL = "
        DELETE FROM procedure_times 
        WHERE procedure_id = :procedureID AND time = :reservationTime AND date = :reservationDate";
        $stmtDelete = $db->prepare($deleteSQL);
        $stmtDelete->bindParam(':procedureID', $procedureID, PDO::PARAM_INT);
        $stmtDelete->bindParam(':reservationTime', $reservationTime, PDO::PARAM_STR);
        $stmtDelete->bindParam(':reservationDate', $reservationDate, PDO::PARAM_STR);
        $stmtDelete->execute();

        // Insert reservation data into the database
        $insertReservation = "
        INSERT INTO orders (Procedure_ID, Time, price, user_id, Date)
        VALUES (:Procedure_ID, :Time, :price, :user_id, :date)
        ";
        $stmtInsertReservation = $db->prepare($insertReservation);
        $stmtInsertReservation->bindParam(':Procedure_ID', $procedureID, PDO::PARAM_INT);
        $stmtInsertReservation->bindParam(':Time', $reservationTime, PDO::PARAM_STR);
        $stmtInsertReservation->bindParam(':price', $price, PDO::PARAM_STR);
        $stmtInsertReservation->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmtInsertReservation->bindParam(':date', $reservationDate, PDO::PARAM_STR);
        $stmtInsertReservation->execute();

        // Commit the transaction
        $db->commit();

        // Reservation successful, you can redirect or display a success message
        header('Location: reservation_success.php');
        exit();
    } catch (Exception $e) {
        // Roll back the transaction if something failed
        $db->rollBack();
        echo "Failed to create reservation: " . $e->getMessage();
    }
}
?>