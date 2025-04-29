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

if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];
    $customer_id = $_SESSION['customer_id'];

    $conn->begin_transaction();

    try {
        $sql_cart = "SELECT c.cart_id, c.showtime_id, c.amount, cd.seat_id
                     FROM cart c
                     JOIN cart_details cd ON c.cart_id = cd.cart_id
                     WHERE c.customer_id = $customer_id AND c.payment_id = $payment_id";
        $result_cart = $conn->query($sql_cart);

        if ($result_cart->num_rows > 0) {
            $total_amount = 0;
            $cart_items = [];
            while ($row = $result_cart->fetch_assoc()) {
                $cart_items[] = $row; 
                $total_amount += $row['amount']; 
            }

            $booking_date = date('Y-m-d H:i:s');
            $showtime_id = $cart_items[0]['showtime_id']; 
            $sql_booking = "INSERT INTO booking (customer_id, showtime_id, booking_date, total_amount, payment_id)
                            VALUES ($customer_id, $showtime_id, '$booking_date', $total_amount, $payment_id)";

            if ($conn->query($sql_booking) === TRUE) {
                $booking_id = $conn->insert_id; 

                foreach ($cart_items as $item) {
                    $seat_id = $item['seat_id'];
                    $sql_booking_details = "INSERT INTO booking_details (booking_id, seat_id)
                                            VALUES ($booking_id, $seat_id)";
                    if (!$conn->query($sql_booking_details)) {
                        throw new Exception("Error inserting booking details: " . $conn->error);
                    }
                }

                $sql_clear_cart_details = "DELETE FROM cart_details WHERE 1";
                $sql_clear_cart = "DELETE FROM cart WHERE 1";

                if (!$conn->query($sql_clear_cart_details) || !$conn->query($sql_clear_cart)) {
                    throw new Exception("Error clearing cart and cart details: " . $conn->error);
                }
                $sql_update_payment = "UPDATE payment SET payment_status = 'true' WHERE payment_id = $payment_id";

                if (!$conn->query($sql_update_payment)) {
                    throw new Exception("Error updating payment status: " . $conn->error);
                }

                $conn->commit();

                echo "<h3>Booking Done! Your booking has been confirmed.</h3>";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'index.php'; // Redirect to homepage
                        }, 3000); // 3-second delay
                      </script>";
                exit();
            } else {
                throw new Exception("Error creating booking: " . $conn->error);
            }
        } else {
            throw new Exception("No cart items found for this payment.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Payment ID is missing.";
}

$conn->close();
?>
