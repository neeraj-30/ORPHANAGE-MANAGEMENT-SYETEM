<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM donors WHERE id=$id");
$donor = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Donor</title>
    <link rel="stylesheet" href="/orphanage/donors/donor.css">
</head>
<body>
<div class="container">
    <h2>Donor Details</h2>
    <p><strong>ID:</strong> <?= $donor['id'] ?></p>
    <p><strong>Name:</strong> <?= $donor['name'] ?></p>
    <p><strong>Phone:</strong> <?= $donor['phone'] ?></p>
    <p><strong>Email:</strong> <?= $donor['email'] ?></p>
    <p><strong>Address:</strong> <?= $donor['address'] ?></p>
    <p><strong>Donation Amount:</strong> <?= $donor['donation_amount'] ?></p>
    <p><strong>Donation Date:</strong> <?= $donor['donation_date'] ?></p>

<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="donors.php"><button>Back to List</button></a>
</div></div>
</body>
</html>
