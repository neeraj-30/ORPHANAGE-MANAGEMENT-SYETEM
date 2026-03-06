<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM staff WHERE id=$id");
$staff = mysqli_fetch_assoc($result);

// Fetch staff names for datalist
$name_query = mysqli_query($conn, "SELECT name FROM staff ORDER BY name ASC");
$staff_names = [];
while($row = mysqli_fetch_assoc($name_query)){
    $staff_names[] = $row['name'];
}

// Fetch UNIQUE positions for datalist
$position_query = mysqli_query($conn, "SELECT DISTINCT position FROM staff ORDER BY position ASC");
$position_names = [];
while($row = mysqli_fetch_assoc($position_query)){
    $position_names[] = $row['position'];
}

$error = "";
$success = "";

if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $join_date = $_POST['join_date'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $salary = $_POST['salary'];

    $query = "UPDATE staff SET 
                name='$name', 
                position='$position', 
                role='$role', 
                phone='$phone', 
                email='$email', 
                join_date='$join_date', 
                address='$address', 
                salary='$salary' 
              WHERE id=$id";

    if(mysqli_query($conn, $query)){
        header("Location: staff.php");
        exit();
    } else {
        $error = "Failed to update staff!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Staff</title>
    <link rel="stylesheet" href="/orphanage/staff/staff.css">
</head>
<body>
<div class="form-container">
    <h2>Edit Staff</h2>

    <?php if($error != "") echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">

        <!-- Staff Name Auto Suggest -->
        <label>Staff Name:</label>
        <input type="text" 
               name="name" 
               list="staff_names_list" 
               placeholder="Full Name"
               value="<?= htmlspecialchars($staff['name']) ?>" 
               required>

        <datalist id="staff_names_list">
            <?php foreach($staff_names as $name): ?>
                <option value="<?= htmlspecialchars($name) ?>"></option>
            <?php endforeach; ?>
        </datalist>


        <!-- Position Auto Suggest -->
        <label>Position:</label>
        <input type="text" 
               name="position" 
               list="position_names_list" 
               placeholder="Position"
               value="<?= htmlspecialchars($staff['position']) ?>" 
               required>

        <datalist id="position_names_list">
            <?php foreach($position_names as $pos): ?>
                <option value="<?= htmlspecialchars($pos) ?>"></option>
            <?php endforeach; ?>
        </datalist>


        <!-- Role -->
        <label>Role:</label>
        <input type="text" 
               name="role" 
               value="<?= htmlspecialchars($staff['role']) ?>"
               placeholder="Role" 
               required>

        <!-- Phone -->
        <label>Phone:</label>
        <input type="text" 
               name="phone" 
               value="<?= htmlspecialchars($staff['phone']) ?>"
               placeholder="Phone Number" 
               required>

        <!-- Email -->
        <label>Email:</label>
        <input type="email" 
               name="email" 
               value="<?= htmlspecialchars($staff['email']) ?>"
               placeholder="Email" 
               required>

        <!-- Join Date -->
        <label>Join Date:</label>
        <input type="date" 
               name="join_date" 
               value="<?= $staff['join_date'] ?>" 
               required>

        <!-- Address -->
        <label>Address:</label>
        <textarea name="address" required><?= htmlspecialchars($staff['address']) ?></textarea>

        <!-- Salary -->
        <label>Salary:</label>
        <input type="number" 
               step="0.01" 
               name="salary" 
               value="<?= htmlspecialchars($staff['salary']) ?>"
               placeholder="Salary" 
               required>

        <button type="submit" name="update">Update Staff</button>
    </form>

    <div class="back-btn-wrapper">
        <a href="staff.php"><button>Back to List</button></a>
    </div>

</div>
</body>
</html>
