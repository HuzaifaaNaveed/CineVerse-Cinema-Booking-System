<?php
include '../includes/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_date = $_POST['release_date'];
    $duration = $_POST['duration'];
    $intro = $_POST['intro'];
    $trailer_link = $_POST['trailer_link'];
    $photo_url = $_POST['photo_url'];
    $price = $_POST['price'];


    $query = "INSERT INTO movie (title, genre, release_date, duration, intro, trailer_link, photo_url, price) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $genre, $release_date, $duration, $intro, $trailer_link, $photo_url, $price]);

    echo "Movie added successfully!";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <link rel="stylesheet" href="assets2/addmovie.css">
</head>
<body>
    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" required><br>
        
        <label>Genre:</label>
        <input type="text" name="genre" required><br>
        
        <label>Release Date:</label>
        <input type="date" name="release_date" required><br>
        
        <label>Duration (in minutes):</label>
        <input type="number" name="duration" required><br>
        
        <label>Intro (Short introduction):</label>
        <textarea name="intro" required></textarea><br>
        
        <label>Trailer Link:</label>
        <input type="text" name="trailer_link" required><br>
        
        <label>Photo URL:</label>
        <input type="text" name="photo_url" required><br>
        
        <label>Price:</label>
        <input type="number" step="0.01" name="price" required><br>
        
        <div class="button-container">
            <button type="submit">Add Movie</button>
            <a href="dashboard.php">
                <button type="button" class="back-btn">Back to Dashboard</button>
            </a>
        </div>
    </form>    
</body>
</html>
