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
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $join_date = $_POST['join_date'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $salary = $_POST['salary'];

    $query = "INSERT INTO staff (name, position, role, phone, email, join_date, address, salary) 
              VALUES ('$name', '$position', '$role', '$phone', '$email', '$join_date', '$address', '$salary')";

    if(mysqli_query($conn, $query)){
        $success = "Staff added successfully!";
    } else {
        $error = "Failed to add staff!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Staff</title>
    <link rel="stylesheet" href="/orphanage/staff/staff.css">
</head>
<body>
<div class="form-container">
    <h2>ADD NEW STAFF</h2>

    <?php if($error != "") echo "<p style='color:red;'>$error</p>"; ?>
    <?php if($success != "") echo "<p style='color:green;'>$success</p>"; ?>

    <form method="POST" action="save.php">
        <label>Staff Name:</label>
        <input type="text" name="name" placeholder="Full Name" required>

        <label>Position:</label>
        <input type="text" name="position" placeholder="Position" required>

        <label>Role:</label>
        <input type="text" name="role" placeholder="Role" required>

        <label>Phone:</label>
        <input type="text" name="phone" placeholder="Phone Number" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Email" required>

        <label>Join Date:</label>
        <input type="date" name="join_date" placeholder="Join Date" required>

        <label>Address:</label>
        <textarea name="address" placeholder="Address" required></textarea>

        <label>Salary:</label>
        <input type="number" step="0.01" name="salary" placeholder="Salary" required>
        <button type="submit" name="save">Add Staff</button>
    </form>
  <!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="staff.php"><button>Back to List</button></a>
</div>
</div>
</body>
</html>
