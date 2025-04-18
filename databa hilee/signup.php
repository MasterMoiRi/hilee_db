<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['signup-name'];
    $email = $_POST['signup-email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['create-password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$name, $email, $username, $password])) {
        $successMessage = "Account created successfully!";
    } else {
        $errorMessage = "Error creating account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HiLєє - Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
</head>
<body>

    <div class="container" id="Sign-Up-page">
        <div class="logo">
            <img src="hilee logo.png" alt="Logo" width="40px" height="50px">
            <h1>HiLєє</h1>
        </div>
        <h2>Sign Up</h2>
        <?php if (isset($successMessage)) { echo "<div class='success-message'>$successMessage</div>"; } ?>
        <?php if (isset($errorMessage)) { echo "<p style='color: red;'>$errorMessage</p>"; } ?>
        <form action="register.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Name" id="signup-name" name="signup-name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" id="signup-email" name="signup-email" required>
            </div>
            <div class="input-group">
                <input type="password" id="create-password" placeholder="Password" name="create-password" required>
                <i class="fas fa-lock toggle-icon" onclick="togglePassword('create-password', this)"></i>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <p class="signin-text">Already have an account? <a href="index.php">Login</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>