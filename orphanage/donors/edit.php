<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM donors WHERE id=$id");
$donor = mysqli_fetch_assoc($result);

// Fetch donor names for datalist
$name_query = mysqli_query($conn, "SELECT name FROM donors ORDER BY name ASC");
$donor_names = [];
while($row = mysqli_fetch_assoc($name_query)){
    $donor_names[] = $row['name'];
}

$error = "";

if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $donation_amount = $_POST['donation_amount'];
    $donation_date = $_POST['donation_date'];

    $query = "UPDATE donors SET 
                name='$name', 
                phone='$phone', 
                email='$email', 
                address='$address', 
                donation_amount='$donation_amount', 
                donation_date='$donation_date' 
              WHERE id=$id";

    if(mysqli_query($conn, $query)){
        header("Location: donors.php");
        exit();
    } else {
        $error = "Failed to update donor!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Donor</title>
    <link rel="stylesheet" href="/orphanage/donors/donor.css">
</head>
<body>
<div class="form-container">
    <h2>Edit Donor</h2>

    <?php if($error != "") echo "<p class='error'>$error</p>"; ?>

    <form method="POST">

        <!-- Donor Name with Auto-Suggest -->
        <label>Donor Name:</label>
        <input type="text" name="name" list="donor_names" placeholder="Full Name" value="<?= htmlspecialchars($donor['name']) ?>" required>
        <datalist id="donor_names">
            <?php foreach($donor_names as $name): ?>
                <option value="<?= htmlspecialchars($name) ?>"></option>
            <?php endforeach; ?>
        </datalist>

        <!-- Phone -->
        <label>Phone:</label>
        <input type="text" name="phone" placeholder="Phone" value="<?= htmlspecialchars($donor['phone']) ?>">

        <!-- Email -->
        <label>Email:</label>
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($donor['email']) ?>">

        <!-- Address -->
        <label>Address:</label>
        <textarea name="address" placeholder="Address"><?= htmlspecialchars($donor['address']) ?></textarea>

        <!-- Donation Amount -->
        <label>Amount:</label>
        <input type="number" step="0.01" name="donation_amount" placeholder="Donation Amount" value="<?= htmlspecialchars($donor['donation_amount']) ?>" required>

        <!-- Donation Date -->
        <label>Date:</label>
        <input type="date" name="donation_date" value="<?= htmlspecialchars($donor['donation_date']) ?>" required>

        <button type="submit" name="update">Update Donor</button>
    </form>

    <div class="back-btn-wrapper">
        <a href="donors.php"><button>Back to List</button></a>
    </div>
</div>
</body>
</html>
