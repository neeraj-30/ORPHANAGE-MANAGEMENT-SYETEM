<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$result = mysqli_query($conn, "SELECT * FROM staff");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff List</title>
    <link rel="stylesheet" href="/orphanage/staff/staff.css">
</head>
<body>
<div class="container">
    <h1>STAFF LIST</h1>
<div class="btn-center">
    <a href="add.php" class="btn">Add Staff</a>
            <a href="/orphanage/dashboard/dashboard.php"><button>Back to Dashboard</button></a>

</div>
<table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>Role</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Join Date</th>
            <th>Address</th>
            <th>Salary</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['position'] ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['join_date'] ?></td>
            <td><?= $row['address'] ?></td>
            <td><?= $row['salary'] ?></td>
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
