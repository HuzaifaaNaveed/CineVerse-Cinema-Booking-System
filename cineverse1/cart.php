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

$sql = "SELECT c.cart_id, c.showtime_id, c.created_at, s.movie_id, m.title, m.photo_url, m.price
        FROM cart c
        JOIN showtime s ON c.showtime_id = s.showtime_id
        JOIN movie m ON s.movie_id = m.movie_id
        WHERE c.customer_id = $customer_id";

$result = $conn->query($sql);
if ($result->num_rows == 0) {
    header("Location: empty_cart.php");
    exit();
}

if ($result->num_rows > 0) {
    $total = 0;
    $cart_items = []; 
    while ($cart = $result->fetch_assoc()) {
        $cart_id = $cart['cart_id'];
        $movie_name = $cart['title'];
        $movie_photo = $cart['photo_url'];
        $showtime_id = $cart['showtime_id'];
        $created_at = $cart['created_at'];
        $movie_price = $cart['price'];

        $seat_sql = "SELECT seat.seat_name
                     FROM cart_details cd
                     JOIN seat seat ON cd.seat_id = seat.seat_id
                     WHERE cd.cart_id = $cart_id";
        $seat_result = $conn->query($seat_sql);

        $seats_count = $seat_result->num_rows; 
        $total += $seats_count * $movie_price;
        $total1 =  $seats_count * $movie_price;
        $sql_update = "UPDATE cart SET amount = ? WHERE cart_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->execute([$total1, $cart_id]);
        $cart_items[] = [
            'cart_id' => $cart_id,
            'movie_name' => $movie_name,
            'movie_photo' => $movie_photo,
            'showtime_id' => $showtime_id,
            'created_at' => $created_at,
            'seats' => $seat_result->fetch_all(MYSQLI_ASSOC), 
            'total_for_movie' => $seats_count * $movie_price
        ];
    }
} else {
    echo "Your cart is empty.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | Cineverse</title>
    <link rel="stylesheet" href="assets/css/cart.css"> 
</head>
<body>
    <header>
        <div class="logo">
        <img src="assets/images/logo4.png" alt="logo" class="logo-image" />
        </div>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </nav>
    </header>

    <div class="cart-container">
        <h1>Your Cart</h1>

        <?php
        foreach ($cart_items as $cart_item) {
        ?>
            <div class="movie-details">
                <div class="movie-photo">
                    <img src=<?php echo $cart_item['movie_photo']; ?> alt="Movie Photo">
                </div>
                <div class="movie-info">
                    <h2><?php echo $cart_item['movie_name']; ?></h2>
                    <p>Booked At: <?php echo $cart_item['created_at']; ?></p>
                </div>
            </div>

            <div class="seat-details">
                <h3>Booked Seats:</h3>
                <ul>
                    <?php
                    if (count($cart_item['seats']) > 0) {
                        foreach ($cart_item['seats'] as $seat) {
                            echo '<li>' . $seat['seat_name'] . '</li>';
                        }
                    } else {
                        echo "<li>No seats selected.</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="total-price">
                <h3>Total: $<?php echo number_format($cart_item['total_for_movie'], 2); ?></h3>
            </div>
            <div class="checkout-btn">
                <form action="remove.php" method="POST">
                    <input type="hidden" name="cart_id" value="<?php echo $cart_item['cart_id']; ?>">
                    <button type="submit" name="remove" value="<?php echo $cart_item['showtime_id']; ?>" class="remove-btn-red">
                        Remove from Cart
                    </button>
                </form>
            </div>

            <hr>
        <?php } ?>

        <div class="total-price">
            <h3>Grand Total: $<?php echo number_format($total, 2); ?></h3>
        </div>

        <div class="checkout-btn">
            <form action="checkout.php" method="POST">
                <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                <button type="submit" class="checkout-btn-red">
                    Proceed to Checkout
                </button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CineVerse. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
