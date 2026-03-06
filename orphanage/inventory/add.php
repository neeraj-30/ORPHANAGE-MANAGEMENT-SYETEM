<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

if(isset($_POST['add'])){
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $received_date = $_POST['received_date'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn, "
        INSERT INTO inventory (item_name, quantity, unit, received_date, description)
        VALUES ('$item_name', '$quantity', '$unit', '$received_date', '$description')
    ");

    header("Location: inventory.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Inventory Item</title>
    <link rel="stylesheet" href="inventory.css">
</head>
<body>
<div class="form-container">

<h2>Add Inventory Item</h2>

<form method="POST" action="save.php">
    <label>Item Name:</label>
    <input type="text" name="item_name" placeholder="Item Name" required>

        <label>Quantity:</label>
    <input type="number" name="quantity" placeholder="Quantity" required>


        <label>Unit:</label>
    <input type="text" name="unit" placeholder="Unit (kg, litre, pcs, etc.)" required>

       <label>Recevied Date:</label>
    <input type="date" name="received_date">

        <label>descriptionS:</label>

    <textarea name="description" placeholder="Description"></textarea>

    <button type="submit" name="save">Add Item</button>

</form>
 <!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="inventory.php"><button>Back to List</button></a>
</div>
</div>

</body>
</html>
