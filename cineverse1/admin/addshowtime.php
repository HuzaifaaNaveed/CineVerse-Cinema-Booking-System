<?php
include '../includes/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theater_id = $_POST['theater_id'];
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $query = "INSERT INTO showtime (theater_id, movie_id, show_date, start_time, end_time) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$theater_id, $movie_id, $show_date, $start_time, $end_time]);

    echo "Showtime added successfully!";
}

$stmt = $pdo->query("SELECT movie_id, title FROM movie WHERE is_deleted=FALSE");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Showtime</title>
    <link rel="stylesheet" href="assets2/addshowtime.css">
</head>
<body>
    <form method="POST">
        <label>Movie:</label>
        <select name="movie_id" required>
            <?php foreach ($movies as $movie) { ?>
                <option value="<?php echo $movie['movie_id']; ?>"><?php echo $movie['title']; ?></option>
            <?php } ?>
        </select><br>

        <label>Theater ID:</label> 
        <input type="text" name="theater_id" required><br>

        <label>Date:</label>
        <input type="date" name="show_date" required><br>

        <label>Start Time:</label>
        <input type="time" name="start_time" required><br>

        <label>End Time:</label>
        <input type="time" name="end_time" required><br>

        <div class="button-container">
        <button type="submit">Add Showtime</button>   
            <a href="dashboard.php">
                <button type="button" class="back-btn">Back to Dashboard</button>
            </a>
        </div>
    </form>
</body>
</html>
