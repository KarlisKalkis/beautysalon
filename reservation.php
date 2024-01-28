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

echo $Procedure_ID; 
echo 'User' . $userData['firstname'];?>