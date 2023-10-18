<?php $sql = "SELECT * FROM reviews";
$stmtselect = $db->prepare($sql);
if ($stmtselect->execute()) {
    $reviews = $stmtselect->fetchAll();
} else {
    echo 'there were errors saving data';
} ?>