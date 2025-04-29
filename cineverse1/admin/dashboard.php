<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets2/dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, Admin</h1>
        
        <div class="bars">
            <div class="bar"><a href="addmovie.php">Add Movies</a></div>
            <div class="bar"><a href="addshowtime.php">Add Showtimes</a></div>
            <div class="bar"><a href="viewbooking.php">View Bookings</a></div>
            <div class="bar"><a href="viewpayment.php">View Payments</a></div>
            <div class="bar"><a href="addadmin.php">Add Other Admin</a></div>
            <div class="bar"><a href="updatemovie.php">Update Current Movies</a></div>
            <div class="bar"><a href="updateshowtime.php">Update Current Showtimes</a></div>
            <div class="bar"><a href="deletemovies.php">Delete Movies</a></div>
            <div class="bar"><a href="deleteshowtimes.php">Delete Showtimes</a></div>
        </div>

        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
