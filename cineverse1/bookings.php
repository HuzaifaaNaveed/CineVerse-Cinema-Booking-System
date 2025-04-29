<?php
include 'db_connect.php'; 
session_start();

$user_id = $_SESSION['customer_id']; 

$query = "SELECT b.booking_id, b.booking_date, b.total_amount, p.payment_id, m.title, s.show_date, s.start_time 
          FROM booking b
          JOIN payment p ON p.customer_id=b.customer_id
          JOIN showtime s ON b.showtime_id = s.showtime_id 
          JOIN movie m ON s.movie_id = m.movie_id 

          WHERE b.customer_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Bookings</title>
    <link rel="stylesheet" href="assets/css/bookings.css">
</head>
<body>
    <div class="container">
        <h1>YOUR BOOKINGS</h1>

        <?php if (count($bookings) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Movie</th>
                        <th>Show Date</th>
                        <th>Showtime</th>
                        <th>Booking Date</th>
                        <th>Total Amount</th>
                        <th>Payment ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['booking_id']; ?></td>
                            <td><?php echo $booking['title']; ?></td>
                            <td><?php echo $booking['show_date']; ?></td>
                            <td><?php echo $booking['start_time']; ?></td>
                            <td><?php echo $booking['booking_date']; ?></td>
                            <td><?php echo $booking['total_amount']; ?></td>
                            <td><?php echo $booking['payment_id']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no bookings at the moment.</p>
        <?php endif; ?>

        <a href="index.php" class="back-btn">Back to Home</a>
    </div>
</body>
</html>
