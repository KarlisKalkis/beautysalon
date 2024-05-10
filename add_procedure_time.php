<?php
include 'config/config.php'; 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $date = $_POST["date"];
    $time = $_POST["time"];


    $sql = "INSERT INTO procedure_times (date, time) VALUES ('$date', '$time')";
    $result = $db->prepare($sql);


    $result->execute();
}

?>
