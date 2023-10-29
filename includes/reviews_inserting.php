<?php 
require_once('config/config.php');
?>

<?php

if (isset($_POST)) {
    $reviewer_name          = $_POST['reviewer_name'];
    $review                 = $_POST['review'];


   $sql = "INSERT INTO reviews (reviewer_name , review) VAlUES(?,?)";
   $stmtinsert = $db->prepare($sql);
   $result = $stmtinsert->execute([$reviewer_name, $review]);
   
}else{
    echo 'No data';
}