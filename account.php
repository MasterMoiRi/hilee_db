<?php
include 'db.php';

// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to the home page or another appropriate page
    header("Location: index.php");
    exit;
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query to check the user's credentials
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and the password matches
    if ($user && password_verify($password, $user['password'])) {
        // Set the user's ID in the session
        $_SESSION['user_id'] = $user['id'];

        // Redirect to the home page or another appropriate page
        header("Location: index.php");
        exit;
    } else {
        // Display an error message
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

    <div class="container" id="Login-page">
        <div class="logo">
            <img src="hilee logo.png" alt="Logo" width="40px" height="50px">
            <h1>HiLєє</h1>
        </div>
        <h2>Login</h2>
        <?php if (isset($errorMessage)) { echo "<p style='color: red;'>$errorMessage</p>"; } ?>
        <form action="account.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Username" id="username" name="username" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" placeholder="Password" name="password" required>
                <i class="fas fa-lock toggle-icon" onclick="togglePassword('password', this)"></i>
            </div>
            <button type="submit">Login</button>
        </form>
        <p class="signin-text">Don't have an account? <a href="register.php">Sign Up</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>
