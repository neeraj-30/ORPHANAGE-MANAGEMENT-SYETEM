<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

include "../database/dbconnect.php";

if(isset($_POST['child_id'])){

    $child_id = intval($_POST['child_id']);
    $adopter_name = mysqli_real_escape_string($conn, $_POST['adopter_name']);
    $adopter_phone = mysqli_real_escape_string($conn, $_POST['adopter_phone']);
    $adopter_address = mysqli_real_escape_string($conn, $_POST['adopter_address']); // <-- Added
    $adoption_date = $_POST['adoption_date'];

    $query = "INSERT INTO adoptions (child_id, adopter_name, adopter_phone, adopter_address, adoption_date) 
              VALUES ('$child_id', '$adopter_name', '$adopter_phone', '$adopter_address', '$adoption_date')";

    if(mysqli_query($conn, $query)){
        header("Location: adoptions.php");
        exit();
    } else {
        echo "Failed to add adoption: " . mysqli_error($conn);
    }
}
?>
