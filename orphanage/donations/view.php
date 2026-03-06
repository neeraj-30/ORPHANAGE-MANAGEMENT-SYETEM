<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "
    SELECT d.*, dn.name as donor_name 
    FROM donations d 
    JOIN donors dn ON d.donor_id = dn.id
    WHERE d.id=$id
");
$donation = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Donation</title>
    <link rel="stylesheet" href="/orphanage/donations/donations-style.css">
</head>
<body>
<div class="container">
    <h2>Donation Details</h2>
    <p><strong>ID:</strong> <?= $donation['id'] ?></p>
    <p><strong>Donor:</strong> <?= $donation['donor_name'] ?></p>
    <p><strong>Amount:</strong> <?= $donation['amount'] ?></p>
    <p><strong>Date:</strong> <?= $donation['donation_date'] ?></p>
    <p><strong>Type:</strong> <?= $donation['donation_type'] ?></p>
    <p><strong>Notes:</strong> <?= $donation['notes'] ?></p>

<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="donations.php"><button>Back to List</button></a>
</div></div>
</body>
</html>
