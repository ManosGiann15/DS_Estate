<?php
  include 'config.php'; 

  // Directory containing the images
  $imageDirectory = "listings/";

  // Get all image files from the directory
  $imageFiles = glob($imageDirectory . "*");

  // Fetch listings from the database
  $sql = "SELECT * FROM listings";
  $result = mysqli_query($conn, $sql);

  if ($result->num_rows > 0) {
      // Output data of each row
      while($row = $result->fetch_assoc()) {
          // Access data using $row['column_name']
          $title = $row['title'];
          $rooms = $row['rooms'];
          $address = $row['address'];
          $price = $row['price'];
      }
  } else {

      // If there are no results, delete all images from the directory
      foreach($imageFiles as $file) {
        if(is_file($file)) {
            unlink($file);
        }
      }
  }
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>DS Estate</title>
    <link rel="stylesheet" type="text/css" target="_blank" href="feed.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <nav>
      <div class="logo">
        <img src="images/ds_estate(1).png" alt="logo"/>
        <h1>DS Estate</h1>
      </div>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="feed.php">Feed</a></li>
        <li><a href="create_listing.php">Create Listing</a></li>
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
        <li><a href="create_listing.php">Create Listing</a></li>
        <?php if (isLoggedIn()): ?>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Log In / Register</a></li>
        <?php endif; ?>
      </ul>
    </div>


    <div class="container">
    <div class="cards">
      <section class="card">
        <figure>
          <div class="img-overlay hot-home">
            <img src="images\Asheville-home1.webp" alt="Trulli">
            <?php if (isLoggedIn()): ?>
              <div class="overlay">
              <a href="book.php?title=Villa%20in%20Athens&address=Greece,%20Athens&rooms=3&price=2100">Book property</a>
              </div>
            <?php endif; ?>
            
          </div>
          <figcaption>Villa in Athens</figcaption>
        </figure>
        <div class="card-content">
          <p>Greece, Athens</p>

          <section class="icons-home">
            <div class="name-icon">
              <span>bedrooms</span>
              <div class="icon">
                <i class="fas fa-bed"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>bathrooms</span>
              <div class="icon">
                <i class="fas fa-sink"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>area</span>
              <div class="icon">
                <i class="fas fa-vector-square"></i>
                <span>4300</span>
              </div>
            </div>
          </section>
          <section class="price">
          <span>$2,100</span></br>
            <span>/night</span>
          </section>
        </div>

      </section>

      <!-- card two -->
      <section class="card">
        <figure>
          <div class="img-overlay hot-home">
            <img src="images\house.jpg" alt="Trulli">
            <?php if (isLoggedIn()): ?>
              <div class="overlay">
              <a href="book.php?title=Villa%20in%20Alexandria&address=Egypt,%20Alexandria&rooms=3&price=2750">Book property</a>
              </div>
            <?php endif; ?>
          </div>
          <figcaption>villa in alexandria</figcaption>
        </figure>
        <div class="card-content">

          <p>Egypt, Alexandria</p>

          <section class="icons-home">
            <div class="name-icon">
              <span>bedrooms</span>
              <div class="icon">
                <i class="fas fa-bed"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>bathrooms</span>
              <div class="icon">
                <i class="fas fa-sink"></i>
                <span>3.5</span>
              </div>
            </div>
            <div class="name-icon">
              <span>area</span>
              <div class="icon">
                <i class="fas fa-vector-square"></i>
                <span>3500</span>
              </div>
            </div>
          </section>
          <section class="price">
          <span>$2,750</span></br>
            <span>/night</span>
          </section>
        </div>
      </section>

      <!-- card three -->
      <section class="card">
        <figure>
          <div class="img-overlay">
            <img src="images\imagereader.png" alt="Trulli">
            <?php if (isLoggedIn()): ?>
              <div class="overlay">
              <a href="book.php?title=Villa%20in%20Cairo&address=Egypt,%20Cairo&rooms=3&price=1350">Book property</a>
              </div>
            <?php endif; ?>
            

          </div>
          <figcaption>Villa on Cairo</figcaption>
        </figure>
        <div class="card-content">
          <p>Egypt, Cairo</p>

          <section class="icons-home">
            <div class="name-icon">
              <span>bedrooms</span>
              <div class="icon">
                <i class="fas fa-bed"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>bathrooms</span>
              <div class="icon">
                <i class="fas fa-sink"></i>
                <span>2</span>
              </div>
            </div>
            <div class="name-icon">
              <span>area</span>
              <div class="icon">
                <i class="fas fa-vector-square"></i>
                <span>1800</span>
              </div>
            </div>
          </section>
          <section class="price">
          <span>$1,350</span></br>
            <span>/night</span>
          </section>
      </section>
      <section class="card">
        <figure>
          <div class="img-overlay">
            <img src="images\img_8041.jpg" alt="Trulli">
            <?php if (isLoggedIn()): ?>
              <div class="overlay">
              <a href="book.php?title=Villa%20in%20Surrey&address=United Kingdom,%20Surrey&rooms=3&price=2000">Book property</a>
              </div>
            <?php endif; ?>
            
          </div>
          <figcaption>Villa in Surrey</figcaption>
        </figure>
        <div class="card-content">
          <p>United Kingdom, Surrey</p>

          <section class="icons-home">
            <div class="name-icon">
              <span>bedrooms</span>
              <div class="icon">
                <i class="fas fa-bed"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>bathrooms</span>
              <div class="icon">
                <i class="fas fa-sink"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>area</span>
              <div class="icon">
                <i class="fas fa-vector-square"></i>
                <span>4300</span>
              </div>
            </div>
          </section>
          <section class="price">
          <span>$2,000</span></br>
            <span>/night</span>
          </section>
        </div>

      </section>
      <section class="card">
        <figure>
          <div class="img-overlay">
            <img src="images\mesa-expensive-homes-1.webp" alt="Trulli">
            <?php if (isLoggedIn()): ?>
              <div class="overlay">
              <a href="book.php?title=Villa%20in%20Dublin&address=Ireland,%20Dublin&rooms=3&price=1500">Book property</a>
              </div>
            <?php endif; ?>
            <div class="cont">
              <div class="icons-img">
              </div>
            </div>
          </div>
          <figcaption>Villa in Dublin</figcaption>
        </figure>
        <div class="card-content">
          <p>Ireland, Dublin</p>

          <section class="icons-home">
            <div class="name-icon">
              <span>bedrooms</span>
              <div class="icon">
                <i class="fas fa-bed"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>bathrooms</span>
              <div class="icon">
                <i class="fas fa-sink"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>area</span>
              <div class="icon">
                <i class="fas fa-vector-square"></i>
                <span>4300</span>
              </div>
            </div>
          </section>
          <section class="price">
          <span>$1,500</span></br>
            <span>/night</span>
          </section>
        </div>

      </section>
      <section class="card">
        <figure>
          <div class="img-overlay">
            <img src="images\southhampton.jpeg" alt="Trulli">
            <?php if (isLoggedIn()): ?>
              <div class="overlay">
              <a href="book.php?title=Villa%20in%20Barcelona&address=Spain,%20Barcelona&rooms=3&price=4300">Book property</a>
              </div>
            <?php endif; ?>
          </div>
          <figcaption>Villa in Barcelona</figcaption>
        </figure>
        <div class="card-content">
          <p>Spain, Barcelona</p>

          <section class="icons-home">
            <div class="name-icon">
              <span>bedrooms</span>
              <div class="icon">
                <i class="fas fa-bed"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>bathrooms</span>
              <div class="icon">
                <i class="fas fa-sink"></i>
                <span>3</span>
              </div>
            </div>
            <div class="name-icon">
              <span>area</span>
              <div class="icon">
                <i class="fas fa-vector-square"></i>
                <span>4300</span>
              </div>
            </div>
          </section>
          <section class="price">
            <span>$1,000</span></br>
            <span>/night</span>
          </section>
        </div>

      </section>

     

      <?php foreach ($imageFiles as $imageFile): ?>
        <?php

        // Directory containing the images
        $imageDirectory = "listings/";

        // Get all image files from the directory
        $imageFiles = glob($imageDirectory . "*");

        // Fetch listings from the database
        $sql = "SELECT * FROM listings";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Access data using $row['column_name']
                $title = $row['title'];
                $rooms = $row['rooms'];
                $address = $row['address'];
                $price = $row['price'];
            }
        } 

        ?>
                <section class="card">
                    <figure>
                        <div class="img-overlay">
                            <img src="<?php echo $imageFile; ?>" alt="Property Image">
                            <?php if (isLoggedIn()): ?>
                              <div class="overlay">
                                <a href="book.php?title=<?php echo $title?>%20&address=<?php echo $address?>%20&rooms=<?php echo $rooms?>&price=<?php echo $price?>">Book property</a>
                                </div>
                            <?php endif; ?>
                        </div>
                            
                        <figcaption><?php echo $title; ?></figcaption>
                    </figure>
                    <div class="card-content">
                    <p><?php echo $address; ?></p>
                      <section class="icons-home">
                          <div class="name-icon">
                              <span>Rooms</span>
                              <div class="icon">
                                  <i class="fas fa-sink"></i>
                                  <span><?php echo $rooms; ?></span>
                              </div>
                          </div>
                      </section>
                      <section class="price">
                          <span>$<?php echo $price; ?></span><br>
                          <span>/night</span>
                      </section>
                    </div>
                </section>
            <?php endforeach; ?>
      


      
    </div>

  </div>
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