

<?php
session_start();
$_SESSION['user_role'] = 'user';

include 'config/config.php';
include 'includeformainpages/header.php';

if (isset($_SESSION['user_name'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form submission and update database
        $userID = $_SESSION['user_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];

        // Update user information in the database
        $updateUserQuery = "UPDATE users SET firstname=?, lastname=?, email=?, phonenumber=? WHERE user_id=?";
        $stmt = $db->prepare($updateUserQuery);
        $stmt->execute([$firstname, $lastname, $email, $phonenumber, $userID]);

        // Redirect back to the profile page after updating
        header('Location: user_profile.php');
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
            o.user_id
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
<h1 class="mt-5 text-center">Your profile</h1>
<div class="container mt-3">
    <div class="main-body">
        <!-- Profile information form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">First Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="firstname" value="<?php echo $userData['firstname'] ?>">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Last Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="lastname" value="<?php echo $userData['lastname'] ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="email" value="<?php echo $userData['email'] ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Phone</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" name="phonenumber" value="<?php echo $userData['phonenumber'] ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 text-secondary">
                    <input type="submit" class="btn btn-primary px-4 mt-2" value="Save Changes">
                </div>
            </div>
        </form>
        
    </div>
</div>

<?php foreach ($usersReservations as $reservation) : ?>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endforeach ?>
