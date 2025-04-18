<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $successMessage = "Login successful!";
        // Redirect to a dashboard or home page
        header("Location: dashboard.php"); // Change to your dashboard page
        exit();
    } else {
        $errorMessage = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HiLєє - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
</head>
<body>

    <div class="container" id="login-page">
        <div class="logo">
            <img src="hilee logo.png" alt="Logo" width="80px" height="50px">
            <h1>HiLєє</h1>
        </div>
        <h2>WELCOME!</h2>
        <?php if (isset($errorMessage)) { echo "<p style='color: red;'>$errorMessage</p>"; } ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock toggle-icon" onclick="togglePassword('password', this)"></i>
            </div>  
            <button class="login-btn" type="submit">Login</button> 
            <a href="reset_password.php">Forgot password?</a>
            <button class="create-text">Create</button> 
            <p class="signin-text">Don't have an account?
            <a href="signup.php">SignUp</a>
            </p>
        </form>
        <div class="sparkle sparkle-top-right"></div>
        <div class="sparkle sparkle-bottom-left"></div>
        <div class="sparkle sparkle-top-left"></div>
        <div class="sparkle sparkle-bottom-right"></div>
    </div>
    </div>
<script src="script.js"></script>
</body>
</html>
