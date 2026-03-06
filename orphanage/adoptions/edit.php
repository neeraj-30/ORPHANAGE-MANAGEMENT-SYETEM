<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);

// Fetch current adoption record
$result = mysqli_query($conn, "SELECT * FROM adoptions WHERE id=$id");
$adoption = mysqli_fetch_assoc($result);

// Fetch all adopter names for datalist
$name_query = mysqli_query($conn, "SELECT adopter_name FROM adoptions GROUP BY adopter_name ORDER BY adopter_name ASC");
$adopter_names = [];
while($row = mysqli_fetch_assoc($name_query)){
    $adopter_names[] = $row['adopter_name'];
}

// Fetch all adopter phone numbers for datalist
$phone_query = mysqli_query($conn, "SELECT adopter_phone FROM adoptions GROUP BY adopter_phone ORDER BY adopter_phone ASC");
$adopter_phones = [];
while($row = mysqli_fetch_assoc($phone_query)){
    $adopter_phones[] = $row['adopter_phone'];
}

$error = "";
$success = "";

if(isset($_POST['update'])){
    $adopter_name = mysqli_real_escape_string($conn, $_POST['adopter_name']);
    $adopter_phone = mysqli_real_escape_string($conn, $_POST['adopter_phone']);
    $adopter_address = mysqli_real_escape_string($conn, $_POST['adopter_address']);
    $adoption_date = mysqli_real_escape_string($conn, $_POST['adoption_date']);

    $query = "UPDATE adoptions 
              SET adopter_name='$adopter_name', 
                  adopter_phone='$adopter_phone', 
                  adopter_address='$adopter_address',
                  adoption_date='$adoption_date' 
              WHERE id=$id";

    if(mysqli_query($conn, $query)){
        header("Location: adoptions.php");
        exit();
    } else {
        $error = "Failed to update adoption record!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Adoption Record</title>
    <link rel="stylesheet" href="adopt.css">
</head>
<body>
<div class="form-container">

<h2>Edit Adoption Record</h2>

<?php if($error != "") echo "<p class='error-msg'>$error</p>"; ?>

<form method="POST" action="">
    <input type="hidden" name="id" value="<?= $adoption['id'] ?>">

    <!-- Adopter Name with Auto Suggest -->
    <label>Adopter Name:</label>
    <input type="text" 
           name="adopter_name" 
           list="adopter_name_list"
           value="<?= htmlspecialchars($adoption['adopter_name']) ?>" 
           placeholder="Adopter Name" 
           required>
    <datalist id="adopter_name_list">
        <?php foreach($adopter_names as $name): ?>
            <option value="<?= htmlspecialchars($name) ?>"></option>
        <?php endforeach; ?>
    </datalist>

    <!-- Adopter Phone with Auto Suggest -->
    <label>Phone Number:</label>
    <input type="text" 
           name="adopter_phone" 
           list="adopter_phone_list"
           value="<?= htmlspecialchars($adoption['adopter_phone']) ?>" 
           placeholder="Phone Number" 
           required>
    <datalist id="adopter_phone_list">
        <?php foreach($adopter_phones as $phone): ?>
            <option value="<?= htmlspecialchars($phone) ?>"></option>
        <?php endforeach; ?>
    </datalist>

    <!-- Adopter Address -->
    <label>Address:</label>
    <textarea name="adopter_address" placeholder="Adopter Address" required><?= htmlspecialchars($adoption['adopter_address']) ?></textarea>

    <!-- Adoption Date -->
    <label>Adoption Date:</label>
    <input type="date" 
           name="adoption_date" 
           value="<?= $adoption['adoption_date'] ?>" 
           required>

    <button type="submit" name="update">Update Adoption</button>
</form>

<div class="back-btn-wrapper">
    <a href="adoptions.php"><button>Back to List</button></a>
</div>

</div>
</body>
</html>
