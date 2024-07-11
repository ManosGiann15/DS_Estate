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
?>
