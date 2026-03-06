<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

include "../database/dbconnect.php";

if(isset($_POST['name'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $join_date = $_POST['join_date'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $salary = floatval($_POST['salary']);

    $query = "INSERT INTO staff (name, position, role, phone, email, join_date, address, salary) 
              VALUES ('$name', '$position', '$role', '$phone', '$email', '$join_date', '$address', '$salary')";

    if(mysqli_query($conn, $query)){
        // Redirect to staff list after successful save
        header("Location: staff.php");
        exit();
    } else {
        echo "Failed to add staff: " . mysqli_error($conn);
    }
} else {
    // Redirect back if form not submitted
    header("Location: add_staff.php");
    exit();
}
?>
