<?php
include '../includes/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $created_at = date('Y-m-d H:i:s');

    $query = "INSERT INTO admin (username, password_hash, created_at) 
              VALUES (?, ?, ?)";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $password_hash, $created_at]);

    echo "Admin added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="assets2/addadmin.css">
</head>
<body>
    <div class="container">
        <h1>Add New Admin</h1>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Add Admin</button>
        </form>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
