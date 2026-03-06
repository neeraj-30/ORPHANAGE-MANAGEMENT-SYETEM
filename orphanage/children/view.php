<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM children WHERE id=$id");
$child = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Child</title>
    <link rel="stylesheet" href="/orphanage/children/child.css">
</head>
<body>
<div class="container">
    <h2>Child Details</h2>
    <p><strong>ID:</strong> <?= $child['id'] ?></p>
    <p><strong>Name:</strong> <?= $child['name'] ?></p>
    <p><strong>Age:</strong> <?= $child['age'] ?></p>
    <p><strong>Gender:</strong> <?= $child['gender'] ?></p>

    <!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="children.php"><button>Back to List</button></a>
</div>

</div>
</body>
</html>
