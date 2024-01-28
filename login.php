<?php
include 'config/config.php';
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = ($_POST['password']);

    $select = "SELECT * FROM users WHERE email = '$email' && password='$password'";
    
    $result = $db->query($select);

    

    

    if ($result) {
        if ($result->rowCount() > 0) {
            $row = $result->fetch();
            $user_type = $row['type'];

            if ($user_type == 'admin') {
                $_SESSION['admin_name'] = $row['email'];
                header('Location: admin_page.php');
                exit();
            } elseif ($user_type == 'user') {
                $_SESSION['user_name'] = $row['email'];
                header('Location: index.php');
                exit();
            } else {
                $error[] = 'Incorrect email or password';
            }
        } else {
            $error[] = 'No rows found for the given credentials';
        }
    } else {
        // Log the SQL error for debugging
        error_log("SQL Error: " . $db->error);
        $error[] = 'Database query error. Please try again later.';
    }
}
?>

<?php include 'includeformainpages/header.php' ?>



<!--begins main part for form-->
<section class="mh-100" style="background-color: #82216f;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="pictures\login_thumblane.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-6 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <form action="" method="POST">

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <span class="h1 fw-bold mb-0">Danielas Beauty</span>
                                    </div>

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                                    <div class="form-outline mb-4">
                                        <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                        <label class="form-label">Email address</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                                        <label class="form-label">Password</label>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="rememberme" class="custom-control-input" id="customControlInline">
                                            <label class="custom-control-label mb-3" for="customControlInline">Remember me </label>
                                        </div>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block" name="submit" id="login" type="submit">Login</button>
                                    </div>


                                    <a class="small text-muted" href="index.html">Back to home page</a>
                                    <br>
                                    <a class="small text-muted" href="#!">Forgot password?</a>
                                    <p class="pb-lg-5" style="color: #393f81;">Don't have an account? <a href="register.php" style="color: #393f81;">Register here</a></p>


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Includes scripts that are needed-->
<?php include 'loginandregisterneeded/scriptsincluded.php' ?>


</body>

</html>