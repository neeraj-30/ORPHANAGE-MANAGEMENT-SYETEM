<?php
session_start();
include("../database/dbconnect.php");

// If already logged in, redirect to dashboard
if(isset($_SESSION['admin_id'])){
 header("Location: /orphanage/dashboard/dashboard.php");
    exit();
}

$error = "";

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);

        // Verify hashed password
        if(password_verify($password, $user['password'])){
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
         header("Location: /orphanage/dashboard/dashboard.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Orphanage Management System</title>
    <link rel="stylesheet" href="/orphanage/auth/login.css">
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    
    <?php if($error != "") { echo "<p style='color:red; text-align:center;'>$error</p>"; } ?>
    
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
        <!-- Signup Button -->
    <a href="/orphanage/auth/register.php" class="signup-btn">Create Admin Account</a>
    </form>
</div>

</body>
</html>
