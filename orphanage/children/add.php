<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");
$error = "";
$success = "";

if(isset($_POST['add'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];

    $query = "INSERT INTO children (name, age, gender) VALUES ('$name', '$age', '$gender')";
    if(mysqli_query($conn, $query)){
        $success = "Child added successfully!";
    } else {
        $error = "Failed to add child!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Child</title>
    <link rel="stylesheet" href="/orphanage/children/child.css">
</head>
<body>
<div class="form-container">
    <h2>Add New Child</h2>

    <?php if($error != "") echo "<p style='color:red;'>$error</p>"; ?>
    <?php if($success != "") echo "<p style='color:green;'>$success</p>"; ?>

    <form method="POST" action="save.php">
        <label>Child Name:</label>
        <input type="text" name="name" placeholder="Child Name" required>

        <label>Age:</label>
        <input type="number" name="age" placeholder="Age" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <button type="submit" name="save">Add Child</button>
    </form>
<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="children.php"><button>Back to List</button></a>
</div>
</div>
</body>
</html>
