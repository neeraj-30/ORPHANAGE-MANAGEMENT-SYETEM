<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

include "../database/dbconnect.php";

if(isset($_POST['item_name'])){

    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $quantity = intval($_POST['quantity']);
    $unit = mysqli_real_escape_string($conn, $_POST['unit']);
    $received_date = $_POST['received_date'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO inventory (item_name, quantity, unit, received_date, description)
              VALUES ('$item_name', '$quantity', '$unit', '$received_date', '$description')";

    if(mysqli_query($conn, $query)){
        // Redirect to inventory list after successful save
        header("Location: inventory.php");
        exit();
    } else {
        // Show error message if insertion fails
        echo "Failed to add item: " . mysqli_error($conn);
    }
} else {
    // Redirect back if form not submitted
    header("Location: add_inventory.php");
    exit();
}
?>
