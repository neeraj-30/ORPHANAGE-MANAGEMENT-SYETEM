<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

include "../database/dbconnect.php";

if(isset($_POST['donor_id'])){
    $donor_id = intval($_POST['donor_id']);
    $amount = floatval($_POST['amount']);
    $donation_date = $_POST['donation_date'];
    $donation_type = mysqli_real_escape_string($conn, $_POST['donation_type']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    $query = "INSERT INTO donations (donor_id, amount, donation_date, donation_type, notes)
              VALUES ('$donor_id', '$amount', '$donation_date', '$donation_type', '$notes')";

    if(mysqli_query($conn, $query)){
        // Redirect to donations list after successful save
        header("Location: donations.php");
        exit();
    } else {
        // Show error if insertion fails
        echo "Failed to add donation: " . mysqli_error($conn);
    }
} else {
    // Redirect back if form not submitted
    header("Location: add_donation.php");
    exit();
}
?>
