<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: userlogin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empty Cart | Cineverse</title>
    <link rel="stylesheet" href="assets/css/empty_cart.css"> 
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/images/logo4.png" alt="Cineverse Logo" class="logo-image">
        </div>
        <div class="right-header">
            <nav>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="empty-cart">
        <h3>YOUR CART IS EMPTY.</h3>
        <a href="index.php" class="browse-link">Browse Movies</a>
    </div>

    <footer>
        <p>&copy; 2024 CineVerse. All rights reserved.</p>
    </footer>
</body>
</html>
