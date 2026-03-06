<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM donations WHERE id=$id");
$donation = mysqli_fetch_assoc($result);

$donors = mysqli_query($conn, "SELECT * FROM donors ORDER BY name ASC");

$error = "";

if(isset($_POST['update'])){
    $donor_id = $_POST['donor_id'];
    $amount = $_POST['amount'];
    $donation_date = $_POST['donation_date'];
    $donation_type = mysqli_real_escape_string($conn, $_POST['donation_type']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    $query = "UPDATE donations 
              SET donor_id='$donor_id', amount='$amount', donation_date='$donation_date', donation_type='$donation_type', notes='$notes'
              WHERE id=$id";

    if(mysqli_query($conn, $query)){
        header("Location: donations.php");
        exit();
    } else {
        $error = "Failed to update donation!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Donation</title>
    <link rel="stylesheet" href="/orphanage/donations/donations-style.css">
</head>
<body>
<div class="form-container">
    <h2>Edit Donation</h2>

    <?php if($error != "") echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <label>Donor</label>
        <select name="donor_id" required>
            <?php while($donor = mysqli_fetch_assoc($donors)) { ?>
                <option value="<?= $donor['id'] ?>" <?= $donation['donor_id']==$donor['id']?'selected':'' ?>><?= $donor['name'] ?></option>
            <?php } ?>
        </select>

        <label>Amount</label>
        <input type="number" step="0.01" name="amount" value="<?= $donation['amount'] ?>" required>

        <label>Date</label>
        <input type="date" name="donation_date" value="<?= $donation['donation_date'] ?>" required>

        <label>Type</label>
        <input type="text" name="donation_type" value="<?= $donation['donation_type'] ?>">

        <label>Notes</label>
        <textarea name="notes"><?= $donation['notes'] ?></textarea>

        <button type="submit" name="update">Update Donation</button>
    </form>
<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="donations.php"><button>Back to List</button></a>
</div></div>
</body>
</html>
