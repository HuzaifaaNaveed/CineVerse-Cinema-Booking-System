<?php
include '../includes/db_connect.php'; 

$movies = []; 
$movie = null;

$stmt = $pdo->prepare("SELECT movie_id, title FROM movie WHERE is_deleted=FALSE");
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['check_movie'])) {
        $movie_id = $_POST['movie_id'];

        $stmt = $pdo->prepare("SELECT * FROM movie WHERE movie_id = ? AND is_deleted=FALSE");
        $stmt->execute([$movie_id]);
        $movie = $stmt->fetch();

        if (!$movie) {
            $error = "Selected movie does not exist!";
        }
    }

    if (isset($_POST['update_movie']) && isset($_POST['movie_id'])) {
        $movie_id = $_POST['movie_id'];
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $release_date = $_POST['release_date'];
        $duration = $_POST['duration'];
        $intro = $_POST['intro'];
        $trailer_link = $_POST['trailer_link'];
        $photo_url = $_POST['photo_url'];
        $price = $_POST['price'];

        $query = "UPDATE movie SET title = ?, genre = ?, release_date = ?, duration = ?, intro = ?, trailer_link = ?, photo_url = ?, price = ? WHERE movie_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $genre, $release_date, $duration, $intro, $trailer_link, $photo_url, $price, $movie_id]);

        $success = "Movie details updated successfully!";
        $movie = null; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Movie</title>
    <link rel="stylesheet" href="assets2/updatemovie.css">
</head>
<body>
    <div class="container">
        <h1>UPDATE MOVIE</h1>

        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>

        <?php if (!$movie): ?>
            <form method="POST">
                <label for="movie_id">Select Movie:</label>
                <select name="movie_id" id="movie_id" required>
                    <option value="">-- Select Movie --</option>
                    <?php foreach ($movies as $movieOption): ?>
                        <option value="<?php echo $movieOption['movie_id']; ?>">
                            <?php echo $movieOption['title']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="check_movie">Check Movie</button>
            </form>
        <?php endif; ?>

        <?php if ($movie): ?>
            <form method="POST">
                <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">

                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $movie['title']; ?>" required>

                <label for="genre">Genre:</label>
                <input type="text" name="genre" id="genre" value="<?php echo $movie['genre']; ?>" required>

                <label for="release_date">Release Date:</label>
                <input type="date" name="release_date" id="release_date" value="<?php echo $movie['release_date']; ?>" required>

                <label for="duration">Duration (in minutes):</label>
                <input type="number" name="duration" id="duration" value="<?php echo $movie['duration']; ?>" required>

                <label for="intro">Intro (Short introduction):</label>
                <textarea name="intro" id="intro" required><?php echo $movie['intro']; ?></textarea>

                <label for="trailer_link">Trailer Link:</label>
                <input type="text" name="trailer_link" id="trailer_link" value="<?php echo $movie['trailer_link']; ?>" required>

                <label for="photo_url">Photo URL:</label>
                <input type="text" name="photo_url" id="photo_url" value="<?php echo $movie['photo_url']; ?>" required>

                <label for="price">Price:</label>
                <input type="number" step="0.01" name="price" id="price" value="<?php echo $movie['price']; ?>" required>

                <button type="submit" name="update_movie">Update Movie</button>
            </form>
        <?php endif; ?>

        <a href="dashboard.php" class="back-btn">BACK TO DASHBOARD</a>
    </div>
</body>
</html>
