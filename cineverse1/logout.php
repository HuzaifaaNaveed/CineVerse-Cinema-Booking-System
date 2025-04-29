<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <link rel="stylesheet" href="assets/css/logout.css">
</head>
<body>
<div class="logout-container">
    <p class="logout-message">You have successfully logged out!</p>
    <a href="index.php" class="logout-button">Return to Home</a>
</div>
</body>
</html>
