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

if (!isset($_SESSION['customer_id'])) {
    header("Location: userlogin.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

if (isset($_POST['cart_id']) && isset($_POST['remove'])) {
    $cart_id = $_POST['cart_id'];
    $showtime_id = $_POST['remove'];

    $seat_sql = "SELECT seat_id FROM cart_details WHERE cart_id = $cart_id";
    $seat_result = $conn->query($seat_sql);

    if ($seat_result->num_rows > 0) {
        while ($seat = $seat_result->fetch_assoc()) {
            $seat_id = $seat['seat_id'];

            $update_seat_sql = "UPDATE seat_showtime SET status = 'empty' WHERE seat_id = $seat_id AND showtime_id = $showtime_id";
            $conn->query($update_seat_sql);
        }

        $delete_cart_details_sql = "DELETE FROM cart_details WHERE cart_id = $cart_id";
        $conn->query($delete_cart_details_sql);

        $remaining_items_sql = "SELECT * FROM cart_details WHERE cart_id = $cart_id";
        $remaining_items_result = $conn->query($remaining_items_sql);

        if ($remaining_items_result->num_rows === 0) {
            $delete_cart_sql = "DELETE FROM cart WHERE cart_id = $cart_id";
            $conn->query($delete_cart_sql);
        }
    }

    header("Location: cart.php");
    exit();
}
?>
