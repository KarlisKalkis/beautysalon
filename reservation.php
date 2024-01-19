<?php
session_start();
$_SESSION['user_role'] = 'user';
?>
<?php include 'includeformainpages/header.php'?>
<?php include 'config/config.php'?>

<?php 
if (isset($_GET['Procedure_ID'])){
    $Procedure_ID = $_GET['Procedure_ID'];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $user_id = $_SESSION['user_id'];
        echo $user_id;
    }
}?>