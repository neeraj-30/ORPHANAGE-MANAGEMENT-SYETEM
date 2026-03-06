<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

// Fetch donors
$donors = mysqli_query($conn, "SELECT * FROM donors ORDER BY name ASC");

$error = "";
$success = "";

if(isset($_POST['add'])){
    $donor_id = $_POST['donor_id'];
    $amount = $_POST['amount'];
    $donation_date = $_POST['donation_date'];
    $donation_type = mysqli_real_escape_string($conn, $_POST['donation_type']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    $query = "INSERT INTO donations (donor_id, amount, donation_date, donation_type, notes) 
              VALUES ('$donor_id', '$amount', '$donation_date', '$donation_type', '$notes')";

    if(mysqli_query($conn, $query)){
        $success = "Donation added successfully!";
    } else {
        $error = "Failed to add donation! " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Donation</title>
    <link rel="stylesheet" href="/orphanage/donations/donations-style.css">
</head>
<body>
<div class="form-container">
    <h2>Add New Donation</h2>

    <?php if($error != "") echo "<p class='error'>$error</p>"; ?>
    <?php if($success != "") echo "<p class='success'>$success</p>"; ?>

    <form method="POST" action="save.php">
        <label>Donor</label>
        <select name="donor_id" required>
            <option value="">-- Select Donor --</option>
            <?php while($donor = mysqli_fetch_assoc($donors)) { ?>
                <option value="<?= $donor['id'] ?>"><?= htmlspecialchars($donor['name']) ?></option>
            <?php } ?>
        </select>

        <label>Amount</label>
        <input type="number" step="0.01" name="amount" value="" required>

        <label>Date</label>
        <input type="date" name="donation_date" value="" required>

        <label>Type</label>
        <input type="text" name="donation_type" value="">

        <label>Notes</label>
        <textarea name="notes"></textarea>

        <button type="submit" name="add">Add Donation</button>
    </form>

    <div class="back-btn-wrapper">
        <a href="donations.php"><button type="button">Back to List</button></a>
    </div>
</div>
</body>
</html>
