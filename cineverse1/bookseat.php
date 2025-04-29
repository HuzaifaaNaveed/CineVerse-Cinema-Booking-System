<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cineverse";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showtime_id = isset($_GET['showtime_id']) ? $_GET['showtime_id'] : 0;

if ($showtime_id) {
    $sql = "SELECT seat.seat_id, seat.seat_name, ss.status 
            FROM seat 
            JOIN seat_showtime ss ON seat.seat_id = ss.seat_id
            WHERE ss.showtime_id = $showtime_id";
    $result = $conn->query($sql);
} else {
    echo "Invalid showtime ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['customer_id'])) {
        header("Location: userlogin.php");
        exit();
    }

    if (isset($_POST['selected_seats'])) {
        $selected_seats = $_POST['selected_seats'];
        $customer_id = $_SESSION['customer_id'];
        $created_at = date("Y-m-d H:i:s");

        $insert_cart_sql = "INSERT INTO cart (customer_id, showtime_id, created_at) 
                            VALUES ('$customer_id', '$showtime_id', '$created_at')";
        
        if ($conn->query($insert_cart_sql) === TRUE) {
            $cart_id = $conn->insert_id; 

            foreach ($selected_seats as $seat_id) {
                $update_sql = "UPDATE seat_showtime SET status = 'booked' WHERE seat_id = $seat_id AND showtime_id = $showtime_id";
                $conn->query($update_sql); 

                $insert_cart_detail_sql = "INSERT INTO cart_details (cart_id, seat_id) 
                                           VALUES ('$cart_id', '$seat_id')";
                if (!$conn->query($insert_cart_detail_sql)) {
                    echo "Error adding seat to cart details: " . $conn->error;
                }
            }
            echo "Seats booked successfully and added to cart.";
        } else {
            echo "Error creating cart: " . $conn->error;
        }
    } else {
        echo "Please select seats.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats | Cineverse</title>
    <link rel="stylesheet" href="assets/css/bookseat.css"> 
</head>
<body>
    <header>
        <div class="logo">
        <img src="assets/images/logo4.png" alt="logo" class="logo-image" />
        </div>
        <nav>
            <ul>
                <li><a href="cart.php">CART</a></li>
                <li><a href="index.php">HOME</a></li>
                
            </ul>
        </nav>
    </header>

    <div class="book-seat-container">
        <h1>Select Your Seats</h1>

        <form method="POST">
            <div class="seat-grid">
                <?php
                if ($result && $result->num_rows > 0) {
                    $rowCount = 0;
                    while ($row = $result->fetch_assoc()) {
                        $seat_class = '';
                        if ($row['status'] == 'booked') {
                            $seat_class = 'booked';
                        } else {
                            $seat_class = 'available';
                        }
                        echo '<label class="seat ' . $seat_class . '">
                                <input type="checkbox" name="selected_seats[]" value="' . $row["seat_id"] . '" ' . ($row['status'] == 'booked' ? 'disabled' : '') . '>
                                <span class="seat-number">' . $row["seat_name"] . '</span>
                            </label>';
                        $rowCount++;
                        if ($rowCount % 10 == 0) {
                            echo '<br>';
                        }
                    }
                } else {
                    echo "No available seats for this showtime.";
                }
                ?>
            </div>
            <button type="submit" 
                class="book-btn-red"
                style="background-color: #f00; color: white; padding: 15px 30px; font-size: 18px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease; width: 200px; margin-top: 30px; margin-bottom: 30px; display: block; margin-left: auto; margin-right: auto; text-align: center;">
                Confirm Booking
            </button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 CineVerse. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
