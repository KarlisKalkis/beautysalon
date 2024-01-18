<?php $sql = "SELECT * FROM reviews WHERE approved = 1";
$stmtselect = $db->prepare($sql);
if ($stmtselect->execute()) {
    $reviews = $stmtselect->fetchAll();
} else {
    echo 'there were errors saving data';
} ?>