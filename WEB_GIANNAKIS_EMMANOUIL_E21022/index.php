<?php
include 'config.php'; // Include the config file to start the session and check login status

$successMessage = '';
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $successMessage = 'Your listing has been successfully added!';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>DS Estate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>

    <?php if ($successMessage): ?>
        <div class="success-message"><?php echo $successMessage; ?></div>
    <?php endif; ?>


    <nav>
      <div class="logo">
        <img src="images/ds_estate(1).png" alt="logo"/>
        <h1>DS Estate</h1>
      </div>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="feed.php">Feed</a></li>
        <?php if (isLoggedIn()): ?>
          <li><a href="create_listing.php">Create Listing</a></li>
        <?php else: ?>
          <li><a href="login.php">Create Listing</a></li>
        <?php endif; ?>


        <?php if (isLoggedIn()): ?>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Log In / Register</a></li>
        <?php endif; ?>
      </ul>
      <div class="hamburger">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </div>
    </nav>
    <div class="menubar">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="feed.php">Feed</a></li>
        <?php if (isLoggedIn()): ?>
          <li><a href="create_listing.php">Create Listing</a></li>
        <?php else: ?>
          <li><a href="login.php">Create Listing</a></li>
        <?php endif; ?>

        <?php if (isLoggedIn()): ?>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Log In / Register</a></li>
        <?php endif; ?>
      </ul>
    </div>

    <div class="eight">
      <h1>Don't Just Move In, Move Up!</h1>
    </div>
    
    <div class="container">
      <img src="images/house.jpg" alt="House Image"/>
      <img src="images/imagereader.png" alt="Image Reader"/>
      <img src="images/img_8041.jpg" alt="Image 8041"/>
      <img src="images/mesa-expensive-homes-1.webp" alt="Expensive Homes"/>
      <img src="images/Asheville-home1.webp" alt="Asheville Home">
    </div>

    

    <script src="script.js"></script>
  </body>
  <footer>
    <div class="footer">
        <div class="grid-container">
            <div class="grid-item">
                <h3>Contact Us</h3>
                <ul>
                    <li><a href="tel:+1234567890">+1 (234) 567-890</a></li>
                    <li><a href="mailto:info@dsestate.com">info@dsestate.com</a></li>
                </ul>
            </div>
            <div class="grid-item">
                <h3>Find Us</h3>
                <div class="google-map-container">
                <iframe
                  width="100%"
                  height="300"
                  frameborder="0"
                  style="border:0"
                  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDs6QIvO7VocFLcOZtr8yFfVwytRJmhe3s&q=37.94165737814998,23.652934711025868"
                  allowfullscreen>
              </iframe>
                </div>
            </div>
            <div class="grid-item">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-youtube"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                </div>
            </div>
            <div class="grid-item">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>DS Estate Copyright © 2024 - All rights reserved</p>
        </div>
    </div>
</footer>

</html>