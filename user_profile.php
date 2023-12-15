
<?php
session_start();
$_SESSION['user_role'] = 'user';


?>
<?php include 'config/config.php'?>

<?php include 'includeformainpages/header.php'?>

<?php 
if (isset($_SESSION['user_name'])){
$loggedInUserEmail = $_SESSION['user_name'];

$select = "SELECT * FROM users WHERE email = '$loggedInUserEmail'";
$result = $db->query($select);



if ($result && $result->rowCount() > 0) {
    $userData = $result->fetch();

    // Display user profile information test to show that it works

    //echo "<h2>Welcome, " . $userData['firstname'] . "!</h2>";
    //echo "<p>Email: " . $userData['email'] . "</p>";
    // Display other profile information as needed
} else {
    echo "User profile data not found.";
}

// Show that no user found in database
$error[] = 'No rows found for the given credentials';
}
else {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit();
}?>

