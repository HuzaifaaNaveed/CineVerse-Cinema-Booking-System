<?php
include '../includes/db_connect.php'; 

$movies = [];

$stmt = $pdo->query("SELECT movie_id, title FROM movie WHERE is_deleted = FALSE");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['movie_id'])) {
        $movie_id = $_POST['movie_id'];

        $stmt = $pdo->prepare("UPDATE movie SET is_deleted = TRUE WHERE movie_id = ?");
        $stmt->execute([$movie_id]);

        $success = "Movie deleted successfully!";
        
        $stmt = $pdo->query("SELECT movie_id, title FROM movie WHERE is_deleted = FALSE");
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Movie</title>
    <link rel="stylesheet" href="assets2/deletemovie.css">
</head>
<body>
    <div class="container">
        <h1>DELETE MOVIE</h1>

        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form method="POST">
            <label for="movie_id">Select Movie:</label>
            <select name="movie_id" id="movie_id" required>
                <option value="">-- Choose a Movie --</option>
                <?php foreach ($movies as $movie): ?>
                    <option value="<?php echo $movie['movie_id']; ?>"><?php echo $movie['title']; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Delete Movie</button>
        </form>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
