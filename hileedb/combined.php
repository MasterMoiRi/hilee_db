<!DOCTYPE html>
<html lang="en">
<head>
    <title>HiLєє - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
</head>
<body>

<?php
include 'db.php';

// LOGIN SECTION
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $successMessage = "Login successful!";
        // Redirect to a dashboard or home page
        header("Location: account.php"); // Change to your dashboard page
        exit();
    } else {
        $errorMessage = "Invalid username or password.";
    }
}

// SIGNUP SECTION
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup-name'])) {
    $name = $_POST['signup-name'];
    $email = $_POST['signup-email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['create-password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$name, $email, $username, $password])) {
        $successMessage = "Account created successfully!";
    } else {
        $errorMessage = "Please fill out all fields correctly!";
    }
}

// RESET PASSWORD SECTION
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset-email'])) {
    $email = $_POST['reset-email'];
    $oldPassword = $_POST['reset-password'];
    $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($oldPassword, $user['password'])) {
        $updateSql = "UPDATE users SET password = ? WHERE email = ?";
        $updateStmt = $pdo->prepare($updateSql);
        if ($updateStmt->execute([$newPassword, $email])) {
            $successMessage = "Password reset successfully!";
        } else {
            $errorMessage = "Error resetting password.";
        }
    } else {
        $errorMessage = "Invalid email or old password.";
    }
}
?>

    <div class="container" id="login-page">
        <div class="logo">
            <img src="hilee logo.png" alt="Logo" width="80px" height="50px">
            <h1>HiLєє</h1>
        </div>
        <h2>WELCOME!</h2>
        <?php if (isset($errorMessage)) { echo "<p>$errorMessage</p>"; } ?>
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
            <div class="create-text">Create</div> 
            <p class="signin-text">Don't have an account?
            <a href="signup.php">SignUp</a>
            </p>
        </form>
        <div class="sparkle sparkle-top-right"></div>
        <div class="sparkle sparkle-bottom-left"></div>
        <div class="sparkle sparkle-top-left"></div>
        <div class="sparkle sparkle-bottom-right"></div>
    </div>

    <div class="container" id="Sign-Up-page" style="display: none;">
        <div class="logo">
            <img src="hilee logo.png" alt="Logo" width="40px" height="50px">
            <h1>HiLєє</h1>
        </div>
        <h2>Sign Up</h2>
        <?php if (isset($successMessage)) { echo "<div class='success-message'>$successMessage</div>"; } ?>
        <?php if (isset($errorMessage)) { echo "<p>$errorMessage</p>"; } ?>
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

    <div class="container" id="Sign-Up-page" style="display: none;">
        <div class="logo">
            <img src="hilee logo.png" alt="Logo" width="40px" height="50px">
            <h1>HiLєє</h1>
        </div>
        <h2>Reset Password</h2>
        <?php if (isset($successMessage)) { echo "<div class='success-message'>$successMessage</div>"; } ?>
        <?php if (isset($errorMessage)) { echo "<p>$errorMessage</p>"; } ?>
        <form action="reset_password.php" method="POST">
            <div class="input-group">
                <input type="password" id="reset-password" name="reset-password" placeholder="Enter old Password" required>
                <i class="fas fa-lock toggle-icon" onclick="togglePassword('reset-password', this)"></i>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" id="reset-email" name="reset-email" required>
            </div>
            <button type="submit">Reset</button>
        </form>
        <p class="signin-text">Already have an account? <a href="index.php">Login</a></p>
    </div> 
    <script src="script.js"></script>
</body>
</html>
