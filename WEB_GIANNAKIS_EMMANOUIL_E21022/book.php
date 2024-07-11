<?php
include 'config.php';

// Fetch the logged-in user's surname from the database
$surname = '';
if (isLoggedIn()) {
    $userId = $_SESSION['user_id'];
    $query = "SELECT Surname FROM users WHERE Name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $surname = $user['Surname'];
    }
    $stmt->close();
}

$listing = [
    'title' => isset($_GET['title']) ? $_GET['title'] : 'N/A',
    'address' => isset($_GET['address']) ? $_GET['address'] : 'N/A',
    'rooms' => isset($_GET['rooms']) ? $_GET['rooms'] : 'N/A',
    'price' => isset($_GET['price']) ? $_GET['price'] : 'N/A',
];

// Function to calculate number of nights between two dates
function calculateNights($checkin, $checkout) {
    $checkin_date = new DateTime($checkin);
    $checkout_date = new DateTime($checkout);
    $interval = $checkin_date->diff($checkout_date);
    return $interval->days;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'reserve') {
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $title = $_POST['title'];
        $surname = $user['Surname']; // Assuming $user is correctly fetched and $surname is set

        // Convert dates to appropriate format if necessary
        $checkin = date('Y-m-d', strtotime($checkin));
        $checkout = date('Y-m-d', strtotime($checkout));

        // Validate check-in and check-out dates
        if ($checkout <= $checkin || $checkin < date('Y-m-d')) {
            $availability_message = "Invalid date range.";
        } else {
            // Calculate number of nights
            $numberOfNights = calculateNights($checkin, $checkout);

            // Calculate the initial payment amount (price per night * number of nights)
            $pricePerNight = floatval($listing['price']);
            $initialPayment = $pricePerNight * $numberOfNights;

            // Generate a random discount percentage between 10% and 30%
            $discountPercentage = mt_rand(10, 30) / 100;

            // Calculate the final price after applying the discount
            $finalPrice = $initialPayment - ($initialPayment * $discountPercentage);

            // Query to check if the dates are already reserved
            $query = "SELECT * FROM reservations WHERE (`check-in` < ? AND `check-out` > ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $checkout, $checkin);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if any rows are returned
            if ($result->num_rows > 0) {
                // Dates are already reserved
                $availability_message = "The dates are already reserved.";
            } else {
                // Dates are available, insert the reservation
                $insert_query = "INSERT INTO reservations (title, `check-in`, `check-out`, price, surname) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param('sssss', $title, $checkin, $checkout, $finalPrice, $surname);
                if ($insert_stmt->execute()) {
                    header('Location: index.php');
                    $availability_message = "Reservation made successfully!";
                } else {
                    $availability_message = "Error in making reservation.";
                }
                $insert_stmt->close();
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'check_availability') {
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];

        // Convert dates to appropriate format if necessary
        $checkin = date('Y-m-d', strtotime($checkin));
        $checkout = date('Y-m-d', strtotime($checkout));

        // Validate check-in and check-out dates
        if ($checkout <= $checkin || $checkin < date('Y-m-d')) {
            echo json_encode(['status' => 'invalid']);
            exit;
        }

        // Query to check if the dates are already reserved
        $query = "SELECT * FROM reservations WHERE (`check-in` < ? AND `check-out` > ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $checkout, $checkin);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Dates are already reserved
            echo json_encode(['status' => 'reserved']);
        } else {
            // Calculate the number of nights
            $numberOfNights = calculateNights($checkin, $checkout);

            // Calculate the initial payment amount (price per night * number of nights)
            $pricePerNight = floatval($listing['price']);
            $initialPayment = $pricePerNight * $numberOfNights;

            // Generate a random discount percentage between 10% and 30%
            $discountPercentage = mt_rand(10, 30) / 100;

            // Calculate the final price after applying the discount
            $finalPrice = $initialPayment - ($initialPayment * $discountPercentage);

            // Return availability status and final price
            echo json_encode(['status' => 'available', 'finalPrice' => $finalPrice]);
        }

        $stmt->close();
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DS Estate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="book.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#check-availability-btn').click(function(e) {
            e.preventDefault();

            var checkin = $('#check-in').val();
            var checkout = $('#check-out').val();

            $.ajax({
                type: 'POST',
                url: '',
                data: {
                    action: 'check_availability',
                    checkin: checkin,
                    checkout: checkout
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'reserved') {
                        alert('The dates are already reserved.');
                    } else if (result.status === 'available') {
                        var finalPrice = result.finalPrice;
                        alert('The dates are available. Final Price: ' + finalPrice);

                    }
                }
            });
        });
    });
</script>


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
    <!-- Content starts here -->
    <div class="model">
        <div class="payment">
            <div class="receipt-box">
                <h3>Summary:</h3>
                <?php if (isset($availability_message)) { echo "<p>$availability_message</p>"; } ?>
                <form method="POST" action="">
                    <table class="table">
                        <tr>
                            <td>Title: <?php echo htmlspecialchars($listing['title']); ?></td>
                        </tr>
                        <tr>
                            <td>Address: <?php echo htmlspecialchars($listing['address']); ?></td>
                        </tr>
                        <tr>
                            <td>Rooms: <?php echo htmlspecialchars($listing['rooms']); ?></td>
                        </tr>
                        <tr>
                            <td>Surname</td>
                            <td><?php echo htmlspecialchars($surname); ?></td>
                        </tr>
                        <tr>
                            <td>Check-in</td>
                            <td><input type="date" id="check-in" name="checkin" required /></td>
                        </tr>
                        <tr>
                            <td>Check-out</td>
                            <td><input type="date" id="check-out" name="checkout" required /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="button" id="check-availability-btn">Check Availability and Price</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" name="action" value="reserve">Reserve</button>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($listing['title']); ?>" />
                </form>
            </div>
        </div>
    </div>
    <!-- Content ends here -->
</body>
</html>