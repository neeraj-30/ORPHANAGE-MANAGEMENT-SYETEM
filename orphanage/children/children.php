<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$result = mysqli_query($conn, "SELECT * FROM children");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Children List</title>
    <link rel="stylesheet" href="/orphanage/children/child.css">
</head>
<body>
<div class="container">
    <h1>Children List</h1>
    <div class="btn-center">
    <a href="add.php"><button>Add New Child</button></a>
        <a href="/orphanage/dashboard/dashboard.php"><button>Back to Dashboard</button></a>
</div>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['age'] ?></td>
            <td><?= $row['gender'] ?></td>
            <td>
                <a href="view.php?id=<?= $row['id'] ?>">View</a> |
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
