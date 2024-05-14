<?php
session_start();
$_SESSION['user_role'] = 'user';

include 'config/config.php';
include 'includeformainpages/header.php';

if (isset($_SESSION['user_name'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Process form submission and update database
        $userID = $_SESSION['user_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];

        // Update user information in the database
        $updateUserQuery = "UPDATE users SET firstname=?, lastname=?, email=?, phonenumber=? WHERE user_id=?";
        $stmt = $db->prepare($updateUserQuery);
        $stmt->execute([$firstname, $lastname, $email, $phonenumber, $userID]);

        // Redirect back to the profile page after updating
        header('Location: user_profile.php');
        exit();
    }

    

    // Fetch user data from the database
    $loggedInUserEmail = $_SESSION['user_name'];
    $select = "SELECT * FROM users WHERE email = '$loggedInUserEmail'";
    $result = $db->query($select);

    if ($result && $result->rowCount() > 0) {
        $userData = $result->fetch();
        $userID = $_SESSION['user_id'];

        // Fetch user reservations
        $usersReservations = "SELECT 
            p.name,
            o.Date,
            o.Time,
            o.price,
            o.user_id
            FROM orders o
            JOIN procedures p ON o.Procedure_ID = p.Procedure_ID
            JOIN users u ON o.user_id = u.user_id
            WHERE o.Procedure_ID is NOT NULL AND o.user_id IS NOT NULL AND o.user_id = '$userID'";
        $stmtselect = $db->prepare($usersReservations);
        if ($stmtselect->execute()) {
            $usersReservations = $stmtselect->fetchAll();
        } else {
        }
    } else {
        echo "User profile data not found.";
    }
} else {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit();
}