<?php
session_start();
$_SESSION['user_role'] = 'user';

include 'includeformainpages/header.php' ?>
<?php include 'config/config.php' ?>
<?php include 'config/reviewsgetting.php' ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Page</title>
    <!-- Include Bootstrap CSS -->

</head>

<body>

    <div class="container">
        <h1 class="mt-5 text-center">Add your reviews</h1>

        <!-- Review Form -->
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <form action="reviews.php" method="POST">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="content">Your Review</label>
                        <textarea class="form-control" id="user_review" rows="3" placeholder="Write your review here..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create" id="submitReview">Submit Review</button>
                </form>
            </div>
        </div>


        <!-- Existing Reviews -->
        <div class="row mt-4 ">
            <div class="container">
                <h1 class="mt-5 text-center">Customer Reviews</h1>
                <?php foreach ($reviews as $reviews) : ?>
                    <div class="row mt-4">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $reviews['reviewer_name'] ?></h5>
                                    <p class="card-text"><?php echo $reviews['review'] ?></p>
                                    
                                </div>
                            </div>
                        </div>


                    </div>
                    <br>

                <?php endforeach ?>
            </div>
        </div>
    </div>

    <?php include 'loginandregisterneeded/scriptsincluded.php' ?>
    <script>
        $(document).ready(function() {
            $('#submitReview').click(function(event) {
                event.preventDefault();

                var user_name = $('#user_name').val();
                var user_review = $('#user_review').val();

                if (user_name === '' || user_review === '') {
                    alert("Please fill in both fields.");
                    return false;
                } else {
                    $.ajax({
                        url: "submit_rating.php",
                        method: "POST",
                        data: {
                            user_name: user_name,
                            user_review: user_review
                        },
                        success: function(data) {
                            alert("Your review was submitted"); // Display a success message for user
                        },
                        error: function(xhr, status, error) {
                            // Handling errors
                            console.error(xhr.responseText);
                            alert('An error occurred while submitting the review.');
                        }
                    });
                }
            });
        });
    </script>