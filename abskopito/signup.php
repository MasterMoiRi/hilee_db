<?php
session_start();

// CONNECT TO DATABASE
$conn = new mysqli("localhost", "root", "", "hdb"); // Update 'hdb' if your database has a different name
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = '';
$errorMessage = '';

// IF FORM SUBMITTED
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $name = $_POST['signup-name'];
    $email = $_POST['signup-email'];
    $username = $_POST['signup-username'];
    $password = password_hash($_POST['create-password'], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        $errorMessage = "Username or email already exists!";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $username, $password);

        if ($stmt->execute()) {
            $successMessage = "Account created successfully!";
        } else {
            $errorMessage = "Signup failed. Try again.";
        }

        $stmt->close();
    }

    $checkUser->close();
    $conn->close();
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

        <!-- Display Success/Error Message -->
        <?php if (!empty($successMessage)) { echo "<div class='success-message'>$successMessage</div>"; } ?>
        <?php if (!empty($errorMessage)) { echo "<div class='error-message'>$errorMessage</div>"; } ?>

        <!-- Sign Up Form -->
        <form action="" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Name" name="signup-name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" name="signup-email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Username" name="signup-username" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="create-password" required>
                <i class="fas fa-lock toggle-icon"></i>
            </div>
            <button type="submit" name="signup">Sign Up</button>
        </form>
        <p class="signin-text">Already have an account? <a href="index.php">Login</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>
