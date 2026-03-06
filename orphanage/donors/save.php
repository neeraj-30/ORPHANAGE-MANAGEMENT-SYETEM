<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

include "../database/dbconnect.php";

if(isset($_POST['name'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $donation_amount = floatval($_POST['donation_amount']);
    $donation_date = $_POST['donation_date'];

    $query = "INSERT INTO donors (name, phone, email, address, donation_amount, donation_date) 
              VALUES ('$name', '$phone', '$email', '$address', '$donation_amount', '$donation_date')";

    if(mysqli_query($conn, $query)){
        // Redirect to donors list after successful save
        header("Location: donors.php");
        exit();
    } else {
        echo "Failed to add donor: " . mysqli_error($conn);
    }
} else {
    // Redirect back if form not submitted
    header("Location: add_donor.php");
    exit();
}
?>
