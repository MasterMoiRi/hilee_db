<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HiLєє - Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
</head>
<body>

    <div class="container" id="reset-password-page">
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