<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script>document.querySelector('.loader').style.display = 'block';</script>";
    
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);
  
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
  
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $hashed_password);
  
        if ($stmt->execute()) {
            $success = "Registration successful. Redirecting to login page...";
            header("Refresh: 1; URL=login.php");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login_styles.css">
    <style>
    .loader {
        display: none;
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

</head>
<body>
<div class="form-box">
    <form class="form" method="POST" action="register.php" onsubmit="showLoader()">
        <span class="title">Register</span>
        <span class="subtitle">Register with your credentials</span>
        <?php if(isset($error)): ?>
            <div class='alert danger'><?= $error ?></div>
        <?php endif; ?>
        <?php if(isset($success)): ?>
            <div class='alert success'><?= $success ?></div>
        <?php endif; ?>
        <div class="form-container">
            <input type="text" class="input" name="username" placeholder="Username" required>
            <input type="email" class="input" name="email" placeholder="Email" required>
            <input type="password" class="input" name="password" placeholder="Password" required>
            <input type="password" class="input" name="confirmPassword" placeholder="Confirm Password" required>
        </div>
        <a href="login.php">Already registered?</a>
        <button type="submit">Register</button>
    </form>
</div>

<div class="loader"></div>

<script>
    function showLoader() {
        document.querySelector('.loader').style.display = 'block';
    }
</script>
</body>
</html>
