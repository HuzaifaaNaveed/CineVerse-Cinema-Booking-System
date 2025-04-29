<?php
include '../includes/db_connect.php'; 

$movies = []; 
$showtimes = []; 
$selected_showtime = null; 

$stmt = $pdo->prepare("SELECT movie_id, title FROM movie WHERE is_deleted=FALSE");
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['check_movie'])) {
        $movie_id = $_POST['movie_id'];

        $stmt = $pdo->prepare("SELECT * FROM showtime WHERE movie_id = ? AND is_deleted=FALSE");
        $stmt->execute([$movie_id]);
        $showtimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$showtimes) {
            $error = "No showtimes found for the selected movie!";
        }
    }

    if (isset($_POST['select_showtime'])) {
        $showtime_id = $_POST['showtime_id'];

        $stmt = $pdo->prepare("SELECT * FROM showtime WHERE showtime_id = ?");
        $stmt->execute([$showtime_id]);
        $selected_showtime = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$selected_showtime) {
            $error = "Selected showtime not found!";
        }
    }

    if (isset($_POST['update_showtime']) && isset($_POST['showtime_id'])) {
        $showtime_id = $_POST['showtime_id'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $show_date = $_POST['show_date'];

        $query = "UPDATE showtime SET start_time = ?, end_time = ?, show_date = ? WHERE showtime_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$start_time, $end_time, $show_date, $showtime_id]);

        $success = "Showtime updated successfully!";
        $selected_showtime = null; 
        $showtimes = []; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Showtime</title>
    <link rel="stylesheet" href="assets2/updateshowtime.css">
</head>
<body>
    <div class="container">
        <h1>UPDATE SHOWTIME</h1>

        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>

        <?php if (empty($showtimes) && !$selected_showtime): ?>
            <form method="POST">
                <label for="movie_id">Select Movie:</label>
                <select name="movie_id" id="movie_id" required>
                    <option value="">-- Select Movie --</option>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?php echo $movie['movie_id']; ?>"><?php echo $movie['title']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="check_movie">Check Showtimes</button>
            </form>
        <?php endif; ?>

        <?php if (!empty($showtimes) && !$selected_showtime): ?>
            <form method="POST">
                <label for="showtime_id">Select Showtime:</label>
                <select name="showtime_id" id="showtime_id" required>
                    <option value="">-- Select Showtime --</option>
                    <?php foreach ($showtimes as $show): ?>
                        <option value="<?php echo $show['showtime_id']; ?>">
                            <?php echo $show['show_date'] . " " . $show['start_time'] . " - " . $show['end_time']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="select_showtime">Select Showtime</button>
            </form>
        <?php endif; ?>

        <?php if ($selected_showtime): ?>
            <form method="POST">
                <input type="hidden" name="showtime_id" value="<?php echo $selected_showtime['showtime_id']; ?>">

                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" id="start_time" value="<?php echo $selected_showtime['start_time']; ?>" required>

                <label for="end_time">End Time:</label>
                <input type="time" name="end_time" id="end_time" value="<?php echo $selected_showtime['end_time']; ?>" required>

                <label for="show_date">Show Date:</label>
                <input type="date" name="show_date" id="show_date" value="<?php echo $selected_showtime['show_date']; ?>" required>

                <button type="submit" name="update_showtime">Update Showtime</button>
            </form>
        <?php endif; ?>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
