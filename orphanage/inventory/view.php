<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = $_GET['id'];
$item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventory WHERE id=$id"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item Details</title>
    <link rel="stylesheet" href="inventory.css">
</head>
<body>
<div class="form-container">

<h2>Inventory Item Details</h2>

<p><strong>Item Name:</strong> <?= $item['item_name'] ?></p>
<p><strong>Quantity:</strong> <?= $item['quantity'] ?></p>
<p><strong>Unit:</strong> <?= $item['unit'] ?></p>
<p><strong>Received Date:</strong> <?= $item['received_date'] ?></p>
<p><strong>Description:</strong> <?= $item['description'] ?></p>
<p><strong>Added On:</strong> <?= $item['created_at'] ?></p>

<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="inventory.php"><button>Back to List</button></a>
</div>
</div>
</body>
</html>
