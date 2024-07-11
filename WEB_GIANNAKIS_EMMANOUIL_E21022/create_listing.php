<?php
session_start();

$servername = "localhost";
$username = "root"; // replace with your MySQL username
$password = ""; // replace with your MySQL password
$dbname = "ds_estate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the necessary fields are set and not empty
    if (isset($_POST['title'], $_POST['address'], $_POST['rooms'], $_POST['price']) && isset($_FILES['listing_image'])) {
        $title = $_POST['title'];
        $address = $_POST['address'];
        $rooms = $_POST['rooms'];
        $price = $_POST['price'];

        // Handle the image upload
        $target_dir = "listings/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the listings directory if it doesn't exist
        }
        $target_file = $target_dir . basename($_FILES["listing_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["listing_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (limit to 5MB)
        if ($_FILES["listing_image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "webp" ) {
            echo "Sorry, only JPG, JPEG, PNG & WEBP files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["listing_image"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars(basename($_FILES["listing_image"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Check if the listing already exists in the database
        $checkSql = "SELECT * FROM listings WHERE title = ? AND address = ?";
        $checkStmt = $conn->prepare($checkSql);
        if ($checkStmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $checkStmt->bind_param("ss", $title, $address);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            echo "This listing has already been submitted.";
        } else {
            // Insert data into the database
            $sql = "INSERT INTO listings (title, address, rooms, price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param("ssii", $title, $address, $rooms, $price);

            if ($stmt->execute()) {
                // Redirect to feed.php after successful submission
                header("Location: feed.php");
                exit(); // Ensure no further code is executed after redirection
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $checkStmt->close();
    } else {
        echo "All fields are required.";
    }
}

$conn->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>DS Estate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="create_listing.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
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

    <section>
        <div class="container">
            <form method="POST" action="" id="form2" enctype="multipart/form-data">
            <div class="step step-1 active">
                <div class="file-upload">
                    <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger('click')">Add Image</button>
                    <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' name="listing_image" onchange="readURL(this);" accept="image/*" />
                        <div class="drag-text">
                            <h3>Drag and drop a file or select add Image</h3>
                        </div>
                    </div>
                    <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image"/>
                        <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                        </div>
                    </div>
                </div>
                <button type="button" class="next-btn">Next</button>
                </div>
                <div class="step step-2">
                    <div class="form-group">
                        <label for="title">House Title</label>
                        <input type="text" id="title" name="title" placeholder="Title" required />
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Address" required />
                    </div>
                    <div class="form-group">
                        <label for="rooms">Rooms</label>
                        <input type="number" id="rooms" name="rooms" placeholder="Rooms" required />
                    </div>
                    <button type="button" class="previous-btn">Prev</button>
                    <button type="button" class="next-btn">Next</button>
                </div>
                <div class="step step-3">
                    <div class="form-group">
                        <label for="price">Price / Night</label>
                        <input type="number" id="price" name="price" placeholder="Price" required />
                    </div>
                    <button type="button" class="previous-btn">Prev</button>
                    <button type="submit" id="submit-listing" class="submit-btn" onclick="Submit()">Create Listing</button>
                </div>
            </form>

        </div>
    </section>
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
