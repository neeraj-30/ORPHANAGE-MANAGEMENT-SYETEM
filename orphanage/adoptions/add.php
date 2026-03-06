<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}


include "../database/dbconnect.php";

// Fetch children list
$children = mysqli_query($conn, "SELECT id, name FROM children");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Adoption Record</title>
    <link rel="stylesheet" href="adopt.css">
</head>
<body>
<div class="form-container">

<h2>Add New Adoption Record</h2>

<form method="POST" action="save.php">

    <label>Select Child:</label>
    <select name="child_id" required>
        <option value="">-- Select Child --</option>
        <?php while($row = mysqli_fetch_assoc($children)) { ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php } ?>
    </select>

    <label>Adopter Name:</label>
    <input type="text" name="adopter_name" required>

    <label>Phone:</label>
    <input type="text" name="adopter_phone" required>

    <label>Address:</label>
    <input type="text" name="adopter_address" required>

    <label>Adoption Date:</label>
    <input type="datetime-local" name="adoption_date" required>

    <button type="submit">Save</button>

</form>
<!-- Add this wrapper around Back to List -->
<div class="back-btn-wrapper">
    <a href="adoptions.php"><button>Back to List</button></a>
</div>
</div>
</body>
</html>
