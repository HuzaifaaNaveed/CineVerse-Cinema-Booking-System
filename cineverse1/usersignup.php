<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cineverse";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']); 
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($email) && !empty($phone) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $sql = "SELECT customer_id FROM customer WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $insert_sql = "INSERT INTO customer (name, email, phone, password) VALUES (?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("ssss", $username, $email, $phone, $hashed_password);

                if ($insert_stmt->execute()) {
                    header('Location: userlogin.php');
                    exit;
                } else {
                    $error = "Error: Unable to register. Please try again.";
                }

                $insert_stmt->close();
            } else {
                $error = "An account with this email already exists.";
            }

            $stmt->close();
        } else {
            $error = "Passwords do not match.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Sign Up | Cineverse</title>
    <link rel="stylesheet" href="assets/css/usersignup.css">
</head>
<body>
    <div class="signup-container">
        <h1>SIGN UP</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username"> Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label> 
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="signup-btn"> Sign Up</button>
        </form>
        <p class="login-link"> Already have an account? <a href="userlogin.php">Login here</a></p>
    </div>
</body>
</html>
