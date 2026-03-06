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
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $donation_amount = $_POST['donation_amount'];
    $donation_date = $_POST['donation_date'];

    $query = "INSERT INTO donors (name, phone, email, address, donation_amount, donation_date) 
              VALUES ('$name', '$phone', '$email', '$address', '$donation_amount', '$donation_date')";

    if(mysqli_query($conn, $query)){
        $success = "Donor added successfully!";
    } else {
        $error = "Failed to add donor!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Donor</title>
    <link rel="stylesheet" href="/orphanage/donors/donor.css">
</head>
<body>
<div class="form-container">
    <h2>Add New Donor</h2>

    <?php if($error != "") echo "<p class='error'>$error</p>"; ?>
    <?php if($success != "") echo "<p class='success'>$success</p>"; ?>

    <form method="POST" action="save.php">
         <label>Adopter Name:</label>
        <input type="text" name="name" placeholder="Full Name" required>
         <label>Phone:</label>
        <input type="text" name="phone" placeholder="Phone">
         <label>Email:</label>
        <input type="email" name="email" placeholder="Email">
         <label>Address:</label>
        <textarea name="address" placeholder="Address"></textarea>
         <label>Amount:</label>
        <input type="number" step="0.01" name="donation_amount" placeholder="Donation Amount" required>
         <label>Date:</label>
        <input type="date" name="donation_date" required>
        <button type="submit" name="save">Add Donor</button>
    </form>
<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="donors.php"><button>Back to List</button></a>
</div></div>
</body>
</html>
