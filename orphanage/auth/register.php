<?php
session_start();
include("../database/dbconnect.php");

// If already logged in, redirect to dashboard
if(isset($_SESSION['admin_id'])){
    header("Location: /orphanage/dashboard/dashboard.php");
    exit();
}

$error = "";
$success = "";

if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    if(mysqli_num_rows($check) > 0){
        $error = "Username already taken!";
    } else {
        // Insert admin into database
        $query = "INSERT INTO admin (name, username, password) VALUES ('$name', '$username', '$password')";
        
        if(mysqli_query($conn, $query)){
            // Get inserted admin ID
            $admin_id = mysqli_insert_id($conn);
            $_SESSION['admin_id'] = $admin_id; // Log in the new admin
            $_SESSION['admin_name'] = $name;

            // Redirect to dashboard
            header("Location: /orphanage/dashboard/dashboard.php");
            exit();
        } else {
            $error = "Registration failed. Try again!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Orphanage Management System</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <h2>Admin Registration</h2>

    <?php
        if($error != "") echo "<p class='error-message'>$error</p>";
        if($success != "") echo "<p style='color:green;'>$success</p>";
    ?>

    <!-- Submit to same page -->
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
    </form>

    <p style="margin-top: 15px;">
        Already have an account?  
        <a href="login.php">Login here</a>
    </p>
</div>

</body>
</html>
