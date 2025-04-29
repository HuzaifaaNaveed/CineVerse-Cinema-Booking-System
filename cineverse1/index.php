<?php 
include('includes/db_connect.php');
session_start();

if (isset($_SESSION['customer_id']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $username=strtoupper($username); 
} else {
    $username = 'USER'; 
}

$searchQuery = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : '%';

$query = "SELECT * FROM movie WHERE title LIKE :search_query AND is_deleted=FALSE";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':search_query', $searchQuery, PDO::PARAM_STR);
$stmt->execute();

$movies = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Movie Search</title>
</head>

<body>
<header>
    <div class="logo">
        <img src="assets/images/logo4.png" alt="logo" class="logo-image" />
    </div>
    <div class="right-header">
        <nav>
            <ul>
                <?php if (isset($_SESSION['customer_id']) && isset($_SESSION['username'])): ?>
                    <li><a href="cart.php" class="red-button">CART</a></li>
                    <li><a href="bookings.php" class="red-button">BOOKINGS</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                <?php else: ?>
                    <li><a href="userlogin.php" class="red-button">LOGIN</a></li>
                    <li><a href="admin/login.php" class="red-button"> ADMIN </a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Enter A Movie Name" class="search-input" 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>
    </div>
</header>


<main>
    <div class="movies-container">
        <?php if (isset($_GET['search']) && $_GET['search'] != ''): ?>
            <a href="index.php" class="back-btn"> Back To All Movies </a>
        <?php endif; ?>

        <?php if (count($movies) > 0): ?>
            <div class="movies">
                <?php foreach ($movies as $movie): ?>
                    <div class="movie">
                        <img src="<?php echo htmlspecialchars($movie['photo_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                        <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                        <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <p>Price: Rs.<?php echo number_format($movie['price'], 2); ?></p>
                        <a href="details.php?movie_id=<?php echo $movie['movie_id']; ?>" class="details-btn"> Details </a>
                        <a href="booknow.php?movie_id=<?php echo $movie['movie_id']; ?>" class="book-now-btn"> Book Now </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p> No movies found matching your search criteria. </p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>&copy; 2024 CineVerse</p>
</footer>

<script src="assets/js/scripts.js"></script> 
</body>
</html>
