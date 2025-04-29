<?php
include '../includes/db_connect.php';

$query = "SELECT p.payment_id, p.customer_id, p.customer_id, p.total_amount AS payment_amount, 
                 p.payment_status, p.payment_date, b.total_amount AS booking_amount, 
                 b.booking_date, b.booking_id
          FROM payment p
          JOIN booking b ON p.payment_id = b.payment_id ORDER BY p.payment_date DESC";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Payments</title>
    <link rel="stylesheet" href="assets2/viewpayment.css">
</head>
<body>
    <h1>ALL PAYMENTS</h1>

    <table border="1">
        <tr>
            <th>Payment ID</th>
            <th>Booking ID</th>
            <th>Customer ID</th>
            <th>Booking Amount</th>
            <th>Payment Amount</th>
            <th>Payment Status</th>
            <th>Payment Date</th>
            <th>Booking Date</th>
        </tr>
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['payment_id']; ?></td>
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['customer_id']; ?></td>
                <td>$<?php echo $row['booking_amount']; ?></td>
                <td>$<?php echo $row['payment_amount']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
                <td><?php echo $row['payment_date']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
