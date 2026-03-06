<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$result = mysqli_query($conn, "SELECT * FROM inventory ORDER BY created_at ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
    <link rel="stylesheet" href="inventory.css">
   
</head>
<body>
<div class="container">
    <h1>Inventory</h1>
    <div class="btn-center">
        <a href="add.php" class="btn">Add Items</a>
                <a href="/orphanage/dashboard/dashboard.php"><button>Back to Dashboard</button></a>

    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Received Date</th>
            <th>Description</th>
            <th>Created Date</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['item_name'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['unit'] ?></td>
            <td><?= $row['received_date'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <a href="view.php?id=<?= $row['id'] ?>">View</a>|
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>|
                <a onclick="return confirm('Delete?')" href="delete.php?id=<?= $row['id'] ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
