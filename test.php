<?php
session_start();
$_SESSION['user_role'] = 'user';
?>
<?php include 'config/config.php'?>
<?php 
if (isset($_SESSION['user_name'])){
$loggedInUserEmail = $_SESSION['user_name'];

$select = "SELECT * FROM users WHERE email = '$loggedInUserEmail'";
$result = $db->query($select);



if ($result && $result->rowCount() > 0) {
    $userData = $result->fetch();

    // Display user profile information test to show that it works

    
} else {
    echo "User profile data not found.";
}

// Show that no user found in database
$error[] = 'No rows found for the given credentials';
}
else {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit();
}

include 'includeformainpages/header.php'?>




<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-1">
                <div class="profile-header">
                    
                    <h1 class="pt-4"><?php echo"Welcome, " . $userData['firstname'] . $userData['lastname']?></h1>
                    <p><?php echo $userData['type']?></p>
                    <button class="btn btn-primary pt-2 mt-2 " data-toggle="modal" data-target="#editModal">Edit Profile</button>
                </div>

                <div class="profile-section mt-3">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">Your last orders and procedures</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h3>About User</h3>
                            <p>First name: <?php echo $userData['firstname']?></p>
                            <p>Last name: <?php echo $userData['lastname']?></p>
                            <p>Your email: <?php echo $userData['email']?></p>
                            <p>You created your account at: <?php echo $userData['created_at']?></p>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <h3><?php echo $userData['firstname'] . " orders and procedures" ?></h3>
                            <p>User's timeline details go here...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing user information -->
                    <form>
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" placeholder="Enter email">
                        </div>
                        <!-- Add more fields as needed for editing -->
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>