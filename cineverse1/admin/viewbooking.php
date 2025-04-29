<?php
include '../includes/db_connect.php';

$query = "SELECT b.booking_id, b.customer_id, b.showtime_id, m.title, s.show_date, s.start_time, b.booking_date, b.total_amount 
          FROM booking b 
          JOIN showtime s ON b.showtime_id = s.showtime_id 
          JOIN movie m ON s.movie_id = m.movie_id ORDER BY b.booking_date DESC";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
</head>
<body>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>ALL BOOKINGS</h1>
    <link rel="stylesheet" href="assets2/viewbooking.css">
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>Customer ID</th>
            <th>Movie</th>
            <th>Showtime</th>
            <th>Booked On</th>
        </tr>
        <?php 
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['customer_id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['show_date'] . " " . $row['start_time']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
