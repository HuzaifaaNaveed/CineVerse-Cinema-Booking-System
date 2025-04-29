<?php
session_start();
include('includes/db_connect.php'); 

$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : null;

if ($movie_id) {
    $query = "SELECT * FROM movie WHERE movie_id = :movie_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['movie_id' => $movie_id]);
    $movie = $stmt->fetch();
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo htmlspecialchars($movie['title']); ?> - CineVerse</title>
    <link rel="stylesheet" href="assets/css/styles1.css">
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
                <li><a href="admin/login.php">ADMIN</a></li>

            </ul>
        </nav>
    </header>

    <main>
        <div class="movie-details-container">
            <div class="movie-photo">
                <img src="<?php echo htmlspecialchars($movie['photo_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
            </div>
            <div class="movie-info">
                <h2><?php echo $movie['title']; ?></h2>
                <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
                <p><strong>Introduction:</strong> <?php echo nl2br(htmlspecialchars($movie['intro'])); ?></p>
                <p><strong>Release Date:</strong> <?php echo date("F j, Y", strtotime($movie['release_date'])); ?></p>
                <p><strong>Duration:</strong> <?php echo $movie['duration']; ?> minutes</p>
                <p><strong>Trailer:</strong> <a href="<?php echo htmlspecialchars($movie['trailer_link']); ?>" target="_blank">Watch Trailer</a></p>
                <a href="booknow.php?movie_id=<?php echo $movie['movie_id']; ?>" class="book-now-btn">Book Now</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 CineVerse</p>
    </footer>

    <script src="assets/js/scripts.js"></script>
</body>
</html>
