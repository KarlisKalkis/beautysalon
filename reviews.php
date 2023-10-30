<?php include 'includeformainpages/header.php'?>
<?php include 'config/config.php'?>
<?php include 'config/reviewsgetting.php'?>


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
            <form action="reviews.php" method="POST">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label for="content">Your Review</label>
                    <textarea class="form-control" id="content" rows="3" placeholder="Write your review here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="create" id="submitReview">Submit Review</button>
            </form>
        </div>
    </div>

    
    <!-- Existing Reviews -->
    <div class="row mt-4">
        <!-- Display existing reviews here (you can use the same card structure as before) -->
        <div class="container">
    <h1 class="mt-5 text-center">Customer Reviews</h1>
    <?php foreach ($reviews as $reviews): ?>
        <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <img src="reviewer1.jpg" class="card-img-top" alt="Reviewer 1">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $reviews['reviewer_name'] ?></h5>
                    <p class="card-text"><?php echo $reviews['review'] ?></p>
                </div>
            </div>
        </div>
        
        
    </div>
    <?php endforeach ?>
</div>
    </div>
</div>

<?php include 'loginandregisterneeded/scriptsincluded.php'?>
<script type="text/javascript">
    $(function(){
        $('#submitReview').click(function(e){
            
            var valid = this.form.checkValidity();

            if(valid){

                var name        =   $('#name').val();
                var content       =   $('#content').val();

                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'reviews_inserting.php',
                    data: {name: name, content: content},

                    success: function(data){
                        Swal.fire({
                            'title': 'Your review is saved',
                            'text': data,
                            'icon': 'success'
                        })
                    },

                    error: function(data){
                        Swal.fire({
                            'title': 'You came to error',
                            'text': 'There were errors saving your review',
                            'icon': 'error' 
                        })
                    },
                });
            }else{
                
            }
        })
    })
    </script>
