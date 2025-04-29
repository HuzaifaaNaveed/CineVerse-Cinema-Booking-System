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

$sql = "SELECT c.cart_id, c.amount, c.showtime_id, s.movie_id, m.title, m.price
        FROM cart c
        JOIN showtime s ON c.showtime_id = s.showtime_id
        JOIN movie m ON s.movie_id = m.movie_id
        WHERE c.customer_id = $customer_id";

$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "No cart found.";
    exit();
}

$total_amount = 0;
$cart_details = [];

while ($cart = $result->fetch_assoc()) {
    $total_amount += $cart['amount']; 
    $cart_details[] = $cart;
}

$sql_user = "SELECT * FROM customer WHERE customer_id = $customer_id";
$user_result = $conn->query($sql_user);
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Cineverse</title>
    <link rel="stylesheet" href="assets/css/checkout.css"> 
</head>
<body>
    <header>
        <div class="logo">
        <img src="assets/images/logo4.png" alt="logo" class="logo-image" />
        </div>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="cart.php">CART</a></li>
                <li><a href="userlogout.php">LOGOUT</a></li>
            </ul>
        </nav>
    </header>

    <div class="checkout-container">
        <h1>Checkout</h1>

        <section class="billing-info">
            <h2>Billing Information</h2>
            <div class="user-details">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            </div>
        </section>

        <section class="cart-summary">
            <h3>Your Cart Items</h3>
            <div class="cart-items">
                <?php foreach ($cart_details as $cart) : ?>
                    <div class="cart-item-card">
                        <div class="cart-item-header">
                            <h4><?php echo htmlspecialchars($cart['title']); ?></h4>
                            <span class="price">$<?php echo number_format($cart['price'], 2); ?></span>
                        </div>
                        <div class="cart-item-body">
                            <p><strong>Showtime ID:</strong> <?php echo htmlspecialchars($cart['showtime_id']); ?></p>
                            <p><strong>Amount:</strong> $<?php echo number_format($cart['amount'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="total-amount">
                <p><strong>Total Amount:</strong> $<?php echo number_format($total_amount, 2); ?></p>
            </div>
        </section>

        <section class="payment-info">
            <h3>Payment Details</h3>
            <form action="process_payment.php" method="POST">
                <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">

                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" required placeholder="Enter your card number">
                </div>

                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" required placeholder="Enter CVV">
                </div>

                <div class="form-group">
                    <button type="submit" class="pay-button">Proceed to Pay</button>
                </div>
            </form>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 Cineverse. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
