<?php
session_start();
$_SESSION['user_role'] = 'user';
?>
<?php include 'includeformainpages/header.php'?>
<?php include 'config/config.php'?>

<div class="container mt-1 pt-5">
    <div class="row d-flex">
        <div class="col-md-12 text-center">
            <h2 class="navbar-brand">Procedures</h2>
        </div>
    </div>
</div>

<?php $sql = "SELECT * FROM procedures";
$stmtselect = $db->prepare($sql);
if ($stmtselect->execute()) {
    $procedures = $stmtselect->fetchAll();
} else {
    echo 'there were errors saving data';
} ?>

<div class='row pt-5 p-4'>
<?php foreach ($procedures as $procedures) : ?>
<div class="col-md-6 pb-2 d-flex ml-4 p-3">
        <div class="card col-sm-10 ml-4 p-3" style="max-width: 300px;">
            <img src="<?php echo $procedures['pictureLink'] ?>" class="card-img-top" alt="Beauty procedure">
            <div class="card-body">
                <h5 class="card-title"><?php echo $procedures['name'] ?></h5>
                <p class="card-text"><?php echo $procedures['info'] ?></p>
                <p class="card-text text-danger"><?php echo $procedures['price'] ?> EIRO</p>
                <a href="reservation.php?Procedure_ID=<?php echo $procedures['Procedure_ID']?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>

        
    </div>
<?php endforeach ?>
</div>
    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
