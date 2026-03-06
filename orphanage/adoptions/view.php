<?php
include "../database/dbconnect.php";
session_start();

$id = $_GET['id'];
$query = mysqli_query($conn, 
    "SELECT adoptions.*, children.name AS child_name 
     FROM adoptions 
     JOIN children ON adoptions.child_id = children.id
     WHERE adoptions.id = $id"
);
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Adoption Details</title>
    <link rel="stylesheet" href="adopt.css">
</head>
<body>
<div class="container">

<h2>Adoption Details</h2>

<p><strong>Child Name:</strong> <?= $data['child_name'] ?></p>
<p><strong>Adopter Name:</strong> <?= $data['adopter_name'] ?></p>
<p><strong>Phone:</strong> <?= $data['adopter_phone'] ?></p>
<p><strong>Address:</strong> <?= $data['adopter_address'] ?></p>
<p><strong>Adoption Date:</strong> <?= $data['adoption_date'] ?></p>

<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="adoptions.php"><button>Back to List</button></a>
</div>
</div>
</body>
</html>
