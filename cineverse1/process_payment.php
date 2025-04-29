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

$sql_cart = "SELECT cart_id, amount FROM cart WHERE customer_id = $customer_id AND payment_id IS NULL";
$result_cart = $conn->query($sql_cart);

if ($result_cart->num_rows > 0) {
    $cart_ids = [];
    $total_amount = 0;
    
    while ($row = $result_cart->fetch_assoc()) {
        $cart_ids[] = $row['cart_id'];
        $total_amount += $row['amount']; 
    }

    $payment_date = date('Y-m-d H:i:s');
    $status = "pending";

    $sql_payment = "INSERT INTO payment (payment_date, total_amount, payment_status, customer_id)
                    VALUES ('$payment_date', $total_amount, '$status', $customer_id)";

    if ($conn->query($sql_payment) === TRUE) {
        $payment_id = $conn->insert_id;

        $cart_ids_list = implode(",", $cart_ids); 
        $sql_update_cart = "UPDATE cart SET payment_id = $payment_id WHERE cart_id IN ($cart_ids_list) AND customer_id = $customer_id";
        
        if ($conn->query($sql_update_cart) === TRUE) {
            header("Location: payment_confirmation.php?payment_id=$payment_id");
            exit();
        } else {
            echo "Error updating cart with payment ID: " . $conn->error;
            exit();
        }
    } else {
        echo "Error creating payment: " . $conn->error;
        exit();
    }
} else {
    echo "No active cart found for the user.";
}

$conn->close();
?>
