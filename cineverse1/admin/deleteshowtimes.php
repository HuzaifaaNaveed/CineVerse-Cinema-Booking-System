<?php
include '../includes/db_connect.php'; 

$movies = []; 
$showtimes = []; 
$selected_movie_id = null;

$stmt = $pdo->prepare("SELECT movie_id, title FROM movie WHERE is_deleted=FALSE");
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['select_movie'])) {
        $selected_movie_id = $_POST['movie_id'];

        $stmt = $pdo->prepare("SELECT showtime_id, start_time FROM showtime WHERE movie_id = ? AND is_deleted=FALSE");
        $stmt->execute([$selected_movie_id]);
        $showtimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$showtimes) {
            $error = "No active showtimes found for the selected movie!";
        }
    }

    if (isset($_POST['delete_showtime'])) {
        $showtime_id = $_POST['showtime_id'];

        $stmt = $pdo->prepare("UPDATE showtime SET is_deleted = TRUE WHERE showtime_id = ?");
        $stmt->execute([$showtime_id]);

        $success = "Showtime deleted successfully!";
        $showtimes = []; 
        $selected_movie_id = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Showtime</title>
    <link rel="stylesheet" href="assets2/deleteshowtime.css">
</head>
<body>
    <div class="container">
        <h1>DELETE SHOWTIME</h1>

        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form method="POST">
            <label for="movie_id">Select Movie:</label>
            <select name="movie_id" id="movie_id" required>
                <option value="">-- Select Movie --</option>
                <?php foreach ($movies as $movie): ?>
                    <option value="<?php echo $movie['movie_id']; ?>" <?php if ($selected_movie_id == $movie['movie_id']) echo 'selected'; ?>>
                        <?php echo $movie['title']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="select_movie">Select Movie</button>
        </form>

        <?php if ($selected_movie_id && $showtimes): ?>
            <form method="POST">
                <input type="hidden" name="movie_id" value="<?php echo $selected_movie_id; ?>">

                <label for="showtime_id">Select Showtime:</label>
                <select name="showtime_id" id="showtime_id" required>
                    <option value="">-- Select Showtime --</option>
                    <?php foreach ($showtimes as $showtime): ?>
                        <option value="<?php echo $showtime['showtime_id']; ?>">
                            <?php echo $showtime['start_time']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="delete_showtime">Delete Showtime</button>
            </form>
        <?php endif; ?>

        <a href="dashboard.php" class="back-btn">BACK TO DASHBOARD</a>
    </div>
</body>
</html>
