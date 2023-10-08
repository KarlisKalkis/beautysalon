<?php
session_start();
require_once('config/config.php');



$email = $_POST['email'];
$password = $_POST['password'];


$sql = "SELECT * FROM users WHERE email= ? AND password= ? LIMIT 1";
$stmtselect = $db->prepare($sql);
$result = $stmtselect->execute([$email, $password]);

if($result){
    $user = $stmtselect->fetch(PDO::FETCH_ASSOC);
    if($stmtselect->rowCount() > 0){
        $_SESSION['userLogin'] = $user;
        echo 'Welcome back! We are glad to see you back';
    }else{
        echo 'There isnt user with that info';
    }

}else{
    echo 'there were errors connecting to database';
}