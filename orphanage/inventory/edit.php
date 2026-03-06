<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);

// Fetch item selected for editing
$item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventory WHERE id=$id"));

// Fetch all inventory item names for suggestions
$item_name_query = mysqli_query($conn, "SELECT item_name FROM inventory GROUP BY item_name ORDER BY item_name ASC");
$item_names = [];
while($row = mysqli_fetch_assoc($item_name_query)){
    $item_names[] = $row['item_name'];
}

$error = "";
$success = "";

if(isset($_POST['update'])){
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $quantity = $_POST['quantity'];
    $unit = mysqli_real_escape_string($conn, $_POST['unit']);
    $received_date = $_POST['received_date'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "
        UPDATE inventory SET
        item_name='$item_name',
        quantity='$quantity',
        unit='$unit',
        received_date='$received_date',
        description='$description'
        WHERE id=$id
    ";

    if(mysqli_query($conn, $query)){
        header("Location: inventory.php");
        exit();
    } else {
        $error = "Failed to update inventory item!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Inventory Item</title>
    <link rel="stylesheet" href="inventory.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Inventory</h2>

    <?php if($error != "") echo "<p class='error-msg'>$error</p>"; ?>

    <form method="POST" action="">
        
        <!-- Item Name with datalist auto-suggestion -->
        <label>Item Name:</label>
        <input type="text" name="item_name" 
               list="item_names_list" 
               placeholder="Item Name" 
               value="<?= htmlspecialchars($item['item_name']) ?>" required>

        <datalist id="item_names_list">
            <?php foreach($item_names as $name): ?>
                <option value="<?= htmlspecialchars($name) ?>"></option>
            <?php endforeach; ?>
        </datalist>

        <!-- Quantity -->
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" required>

        <!-- Unit -->
        <label>Unit:</label>
        <input type="text" name="unit" value="<?= htmlspecialchars($item['unit']) ?>" required>

        <!-- Received Date -->
        <label>Received Date:</label>
        <input type="date" name="received_date" value="<?= $item['received_date'] ?>" required>

        <!-- Description -->
        <label>Description:</label>
        <textarea name="description" required><?= htmlspecialchars($item['description']) ?></textarea>

        <button type="submit" name="update">Update Item</button>
    </form>

    <div class="back-btn-wrapper">
        <a href="inventory.php"><button>Back to List</button></a>
    </div>

</div>

</body>
</html>

    
