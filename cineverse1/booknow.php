<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cineverse"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : 0;

if ($movie_id) {
    $sql = "SELECT s.showtime_id, s.start_time, s.end_time, t.name, t.location 
            FROM showtime s
            JOIN theater t ON s.theater_id = t.theater_id
            WHERE s.movie_id = $movie_id AND s.is_deleted=FALSE
            ORDER BY s.start_time";

    $result = $conn->query($sql);
} else {
    echo "Invalid movie ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now | Cineverse</title>
    <link rel="stylesheet" href="assets/css/booknow.css"> 
</head>
<body>
    <header>
        <div class="logo">
        <img src="assets/images/logo4.png" alt="logo" class="logo-image" />
        </div>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="details.php?movie_id=<?php echo $movie_id; ?>">DETAILS</a></li>
            </ul>
        </nav>
    </header>

    <div class="book-now-container">
        <h1>Select Showtime</h1>

        <div class="showtime-cards">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="showtime-card">
                            <div class="showtime-header">
                                <span class="showtime-time">' . date('h:i A', strtotime($row["start_time"])) . ' - ' . date('h:i A', strtotime($row["end_time"])) . '</span>
                            </div>
                            <div class="showtime-body">
                                <p class="theater-name">' . $row["name"] . '</p>
                                <p class="location">' . $row["location"] . '</p>
                            </div>
                            <div class="showtime-footer">
                                <button class="book-seats-btn" onclick="window.location.href=\'bookseat.php?showtime_id=' . $row["showtime_id"] . '\'">Book Seats</button>
                            </div>
                        </div>';
                }
            } else {
                echo "No showtimes available for this movie.";
            }
            ?>
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
