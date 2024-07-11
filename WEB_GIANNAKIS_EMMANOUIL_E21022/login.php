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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Registration process
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $pswd = $_POST['pswd'];
        $email = $_POST['email'];

        // Check if username exists before registration
        $sql_check = "SELECT * FROM users WHERE Username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            echo "Username already exists. Please choose a different username.";
        } else {
            

            $sql = "INSERT INTO users (Name, Surname, Username, Password, email)
                     VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $surname, $username, $pswd, $email);

            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $stmt->close();
        }
        $stmt_check->close();
    } elseif (isset($_POST['login'])) {
        // Login process
        $email = $_POST['email'];
        $pswd = $_POST['pswd'];

        $sql_login = "SELECT * FROM users WHERE email = ?";
        $stmt_login = $conn->prepare($sql_login);
        $stmt_login->bind_param("s", $email);
        $stmt_login->execute();
        $result = $stmt_login->get_result();

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          if ($pswd == $row['Password']) {
              $_SESSION['user_id'] = $row['Username'];
              header('Location: index.php');
              exit();
          } else {
              echo "Invalid password. Please try again.";
          }
        } else {
            echo "No account found with that email. Please try again.";
        }

        $stmt_login->close();
    }
}

$conn->close();

$isLoggedIn = isset($_SESSION['user_id']); // Check if the user is logged in
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Estate</title>
    <link rel="stylesheet" type="text/css" href="register.css">
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
            <?php if ($isLoggedIn): ?>
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
            <?php if ($isLoggedIn): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Log In / Register</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="main">    
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form method="post" action="">
                <input type="hidden" name="register" value="1">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="name" placeholder="Name" required>
                <input type="text" name="surname" placeholder="Surname" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="pswd" placeholder="Password" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">Sign up</button>
            </form>
        </div>

        <div class="login">
            <form method="post" action="">
                <input type="hidden" name="login" value="1">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="pswd" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
