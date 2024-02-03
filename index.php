<?php
session_start();
$_SESSION['user_role'] = 'user';

var_dump($_SESSION);
?>

<?php include 'includeformainpages/header.php'?>

<body>
    

    <!-- Header Section -->
    <header>
        <h1>Welcome to Danielas Beauty</h1>
        <p>Your Ultimate Beauty Experience Awaits</p>
    </header>
    
    <!-- About Us Section -->
    <section id="about" class="container text-center">
        <h2 class="section-title">About Us</h2>
        <div class="section-content">
            <p>Danielas Beauty is more than just a beauty salon; it's a place where you can transform yourself and enhance your natural beauty. Our team of skilled professionals is dedicated to providing you with the finest beauty treatments and products. Come and experience luxury and relaxation like never before.</p>
        </div>
    </section>
    
    <!-- Procedures Section -->
    <section id="procedures" class="container text-center">
        <h2 class="section-title">Our Procedures</h2>
        <div class="section-content">
            <p>Indulge in a wide range of beauty services, including facials that rejuvenate your skin, luxurious manicures and pedicures, hair styling that matches your unique personality, and waxing that leaves you feeling smooth and confident. Discover the beauty in every detail.</p>
        </div>
    </section>
    
    <!-- Products Section -->
    <section id="products" class="container text-center">
        <h2 class="section-title">Shop Beauty Products</h2>
        <div class="section-content">
            <p>Explore our exclusive collection of beauty products carefully curated to meet your skincare and haircare needs. From premium skincare essentials to haircare wonders, we offer the best products to keep you looking and feeling your best, even at home.</p>
        </div>
    </section>
    
    <!-- Footer Section -->


    <!-- Include Bootstrap JS and jQuery -->
    <?php include 'loginandregisterneeded/scriptsincluded.php'?>
</body>
</html>
