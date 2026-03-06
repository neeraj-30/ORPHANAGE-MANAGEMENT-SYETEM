<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM staff WHERE id=$id");
$staff = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Staff</title>
    <link rel="stylesheet" href="/orphanage/staff/staff.css">
</head>
<body>
<div class="container">
    <h2>Staff Details</h2>
    <p><strong>ID:</strong> <?= $staff['id'] ?></p>
    <p><strong>Name:</strong> <?= $staff['name'] ?></p>
    <p><strong>Position:</strong> <?= $staff['position'] ?></p>
    <p><strong>Role:</strong> <?= $staff['role'] ?></p>
    <p><strong>Phone:</strong> <?= $staff['phone'] ?></p>
    <p><strong>Email:</strong> <?= $staff['email'] ?></p>
    <p><strong>Join Date:</strong> <?= $staff['join_date'] ?></p>
    <p><strong>Address:</strong> <?= $staff['address'] ?></p>
    <p><strong>Salary:</strong> <?= $staff['salary'] ?></p>

<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="staff.php"><button>Back to List</button></a>
</div>
</div>
</body>
</html>
