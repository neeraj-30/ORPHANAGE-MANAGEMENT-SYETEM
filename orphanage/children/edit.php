<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM children WHERE id=$id");
$child = mysqli_fetch_assoc($result);

// Fetch all child names for datalist
$name_query = mysqli_query($conn, "SELECT name FROM children ORDER BY name ASC");
$child_names = [];
while($row = mysqli_fetch_assoc($name_query)){
    $child_names[] = $row['name'];
}

$error = "";
$success = "";

if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];

    $query = "UPDATE children SET name='$name', age=$age, gender='$gender' WHERE id=$id";

    if(mysqli_query($conn, $query)){
        header("Location: children.php");
        exit();
    } else {
        $error = "Failed to update child!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Child</title>
    <link rel="stylesheet" href="/orphanage/children/child.css">
</head>
<body>
<div class="form-container">
    <h2>Edit Child</h2>

    <?php if($error != "") echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" action="">

        <!-- Child Name with Auto Suggest -->
        <label>Child Name:</label>
        <input type="text" 
               name="name" 
               list="child_names_list" 
               placeholder="Full Name"
               value="<?= htmlspecialchars($child['name']) ?>" 
               required>

        <datalist id="child_names_list">
            <?php foreach($child_names as $name): ?>
                <option value="<?= htmlspecialchars($name) ?>"></option>
            <?php endforeach; ?>
        </datalist>

        <!-- Age -->
        <label>Age:</label>
        <input type="number" 
               name="age" 
               value="<?= htmlspecialchars($child['age']) ?>"
               placeholder="Age" 
               required>

        <!-- Gender -->
        <label>Gender:</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male" <?= ($child['gender'] == "Male") ? "selected" : "" ?>>Male</option>
            <option value="Female" <?= ($child['gender'] == "Female") ? "selected" : "" ?>>Female</option>
        </select>

        <button type="submit" name="update">Update Child</button>
    </form>

    <div class="back-btn-wrapper">
        <a href="children.php"><button>Back to List</button></a>
    </div>

</div>
</body>
</html>
