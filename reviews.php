<?php include 'includeformainpages/header.php'?>
<?php include 'config/config.php'?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5 text-center">Add your reviews</h1>

    <!-- Review Form -->
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <form>
                <div class="form-group">
                    <label for="reviewerName">Your Name</label>
                    <input type="text" class="form-control" id="reviewerName" placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label for="reviewContent">Your Review</label>
                    <textarea class="form-control" id="reviewContent" rows="3" placeholder="Write your review here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>

    <!-- Existing Reviews -->
    <div class="row mt-4">
        <!-- Display existing reviews here (you can use the same card structure as before) -->
        <div class="container">
    <h1 class="mt-5 text-center">Customer Reviews</h1>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <img src="reviewer1.jpg" class="card-img-top" alt="Reviewer 1">
                <div class="card-body">
                    <h5 class="card-title">John Doe</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer luctus.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="reviewer2.jpg" class="card-img-top" alt="Reviewer 2">
                <div class="card-body">
                    <h5 class="card-title">Jane Smith</h5>
                    <p class="card-text">Vivamus eget nisl et metus facilisis finibus. Proin sit amet quam quis ex varius.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="reviewer3.jpg" class="card-img-top" alt="Reviewer 3">
                <div class="card-body">
                    <h5 class="card-title">Mike Johnson</h5>
                    <p class="card-text">Aenean tempus, justo et facilisis aliquam, quam elit accumsan odio.</p>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<!-- Include Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
