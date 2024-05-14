<?php
session_start();
$_SESSION['user_role'] = 'user';

include 'config/config.php';
include 'includeformainpages/header.php';

if (isset($_SESSION['user_name'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            $reservationID = $_POST['reservation_id'];
            $deleteReservationQRY = "DELETE FROM orders WHERE Order_ID = ?";
            $stmt = $db ->prepare($deleteReservationQRY);
            $stmt -> execute ([$reservationID]);
            header('Location: user_reservation.php');
            exit();
        
        
    }

    

    // Fetch user data from the database
    $loggedInUserEmail = $_SESSION['user_name'];
    $select = "SELECT * FROM users WHERE email = '$loggedInUserEmail'";
    $result = $db->query($select);

    if ($result && $result->rowCount() > 0) {
        $userData = $result->fetch();
        $userID = $_SESSION['user_id'];

        // Fetch user reservations
        $usersReservations = "SELECT 
            p.name,
            o.Date,
            o.Time,
            o.price,
            o.user_id,
            o.Order_ID
            FROM orders o
            JOIN procedures p ON o.Procedure_ID = p.Procedure_ID
            JOIN users u ON o.user_id = u.user_id
            WHERE o.Procedure_ID is NOT NULL AND o.user_id IS NOT NULL AND o.user_id = '$userID'";
        $stmtselect = $db->prepare($usersReservations);
        if ($stmtselect->execute()) {
            $usersReservations = $stmtselect->fetchAll();
        } else {
        }
    } else {
        echo "User profile data not found.";
    }
} else {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit();
}
?>
<h1 class="mt-5 text-center">Your reservations</h1>


<?php foreach ($usersReservations as $reservation) : ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="reservation_id" value="<?php echo $reservation['Order_ID']?>">
    <section style="background-color: #eee;">
        <div class="container py-3">
            <div class="row justify-content-left mb-3">
                <div class="col-md-6">
                    <div class="card shadow-0 border rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-3 col-xl-6 mb-2 mb-lg-0">
                                    <h4><?php echo $reservation['name']?></h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6">
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="mb-2 text-muted small">
                                        Procedure placed: <?php echo $reservation['Date'] ?>
                                    </div>
                                    <div class="mb-2 text-muted small">
                                        Your reservation time : <?php echo $reservation['Time'] ?>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 col-xl-6 ms-3 border-sm-start-none border-start">
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <h4 class="mb-1 me-1"><?php echo $reservation['price']?> EIRO</h4>
                                </div>
                                <div class="d-flex flex-column mt-4">
                                    <input type="submit" class="btn btn-danger px-4 mt-2" value="Delete reservation">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
<?php endforeach ?>
