<?php
include 'config/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $info = $_POST["info"];
    $price = $_POST["price"];

    $sql = "INSERT INTO procedures (name, info, price) VALUES ('$name', '$info','$price')";
    $result = $db->prepare($sql);


    $result->execute();
}
?>