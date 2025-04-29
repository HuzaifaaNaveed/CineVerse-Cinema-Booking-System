<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cineverse";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT customer_id,name, password FROM customer WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($customer_id, $username, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['customer_id'] = $customer_id;
                $_SESSION['username'] = $username; 

                header('Location: index.php');
                exit;
            } else {
                $error = "Incorrect password. Please try again.";
            }
        } else {
            $error = "No account found with that email.";
        }
        $stmt->close();
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
    <title>User Login | Cineverse </title>
    <link rel="stylesheet" href="assets/css/userlogin.css">
</head>
<body>
    <div class="login-container">
        <h1>LOGIN</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <p class="signup-link">Don't have an account? <a href="usersignup.php">Sign Up</a></p>
    </div>
</body>
</html>
