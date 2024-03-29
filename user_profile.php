<?php
session_start();
$_SESSION['user_role'] = 'user';
?>
<?php include 'config/config.php' ?>

<?php include 'includeformainpages/header.php' ?>

<?php
if (isset($_SESSION['user_name'])) {
	$loggedInUserEmail = $_SESSION['user_name'];

	$select = "SELECT * FROM users WHERE email = '$loggedInUserEmail'";
	$result = $db->query($select);



	if ($result && $result->rowCount() > 0) {
		$userData = $result->fetch();
		$userID = $_SESSION['user_id'];

		$usersReservations = "SELECT 
	p.name,
	o.Date,
	o.Time,
	o.price,
	o.user_id
	
	FROM orders o
	JOIN procedures p ON o.Procedure_ID = p.Procedure_ID
	JOIN users u ON o.user_id = u.user_id
	WHERE o.Procedure_ID is NOT NULL AND o.user_id IS NOT NULL AND o.user_id = '$userID'
	";
		$stmtselect = $db->prepare($usersReservations);
		if ($stmtselect->execute()) {
			$usersReservations = $stmtselect->fetchAll();
		} else {
		}
	} else {
		echo "User profile data not found.";
	}

	// Show that no user found in database
	$error[] = 'No rows found for the given credentials';
} else {
	// Redirect the user to the login page if not logged in
	header('Location: login.php');
	exit();
}


var_dump($usersReservations);

?>

<div class="container mt-3">
	<div class="main-body">
		<div class="row">
			<div class="col-lg-4">
				<div class="card">
					<div class="card-body">
						<div class="d-flex flex-column align-items-center text-center">
							<img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="user-photo" class="rounded-circle p-1 bg-primary" width="110">
							<div class="mt-3">
								<h4><?php echo $userData['firstname'] . $userData['lastname'] ?></h4>
								<p class="text-secondary mb-1"><?php echo $userData['type'] ?></p>
							</div>
						</div>
						<hr class="my-4">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe me-2 icon-inline">
										<circle cx="12" cy="12" r="10"></circle>
										<line x1="2" y1="12" x2="22" y2="12"></line>
										<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
									</svg>Email</h6>
								<span class="text-secondary"><?php echo $userData['email'] ?></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github me-2 icon-inline">
										<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
									</svg>First name</h6>
								<span class="text-secondary"><?php echo $userData['firstname'] ?></span>
							</li>

						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<div class="row mb-3">
							<div class="col-sm-3">
								<h6 class="mb-0">First Name</h6>
							</div>
							<div class="col-sm-9 text-secondary">
								<input type="text" class="form-control" value="<?php echo $userData['firstname'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-3">
								<h6 class="mb-0">Last Name</h6>
							</div>
							<div class="col-sm-9 text-secondary">
								<input type="text" class="form-control" value="<?php echo $userData['lastname'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-3">
								<h6 class="mb-0">Email</h6>
							</div>
							<div class="col-sm-9 text-secondary">
								<input type="text" class="form-control" value="<?php echo $userData['email'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-3">
								<h6 class="mb-0">Phone</h6>
							</div>
							<div class="col-sm-9 text-secondary">
								<input type="text" class="form-control" value="<?php echo $userData['phonenumber'] ?>">
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-3">
								<h6 class="mb-0">Address</h6>
							</div>
							<div class="col-sm-9 text-secondary">
								<input type="text" class="form-control" value="Bay Area, San Francisco, CA">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3"></div>
							<div class="col-sm-9 text-secondary">
								<input type="button" class="btn btn-primary px-4 mt-2" value="Save Changes">
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>



<?php foreach ($usersReservations as $usersReservations) : ?>
	<section style="background-color: #eee;">
		<div class="container py-3">
			<div class="row justify-content-left mb-3">
				<div class="col-md-6">
					<div class="card shadow-0 border rounded-3">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 col-lg-3 col-xl-6 mb-2 mb-lg-0">
									<h4><?php echo $usersReservations['name']?></h2>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-xl-6">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="mb-2 text-muted small">
                                    Procedure placed: <?php echo $usersReservations['Date'] ?>
                                </div>
                                <div class="mb-2 text-muted small">
                                    Your reservation time : <?php echo $usersReservations['Time'] ?>
                                </div>
                            </div>									

								</div>
							</div>
							<div class="col-md-6 col-lg-3 col-xl-6 ms-3 border-sm-start-none border-start">
								<div class="d-flex flex-row align-items-center mb-1">
									<h4 class="mb-1 me-1"><?php echo $usersReservations['price']?> EIRO</h4>
								</div>
								<div class="d-flex flex-column mt-4">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach ?>