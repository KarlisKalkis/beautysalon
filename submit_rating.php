<?php
$db_user = "root";
$db_pass = "";
$db_name = "beautysalon";

$connect = new PDO('mysql:host=localhost;dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_name'], $_POST['user_review'])) {
        $user_name = $_POST['user_name'];
        $user_review = $_POST['user_review'];

        //code to push reviews to database
        $query = "INSERT INTO reviews(reviewer_name, review) VALUES (:user_name, :user_review)";

        $statement = $connect->prepare($query);
        $statement->bindParam(':user_name', $user_name);
        $statement->bindParam(':user_review', $user_review);

        try {
            $statement->execute();
            echo json_encode(array('status' => 'success', 'message' => 'Review submitted successfully.'));
        } catch (PDOException $e) {
            echo json_encode(array('status' => 'error', 'message' => 'Error submitting review: ' . $e->getMessage()));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Incomplete data received.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request.'));
}
?>
