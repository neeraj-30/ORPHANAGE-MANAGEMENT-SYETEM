<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$result = mysqli_query($conn, "SELECT * FROM donors ORDER BY created_at ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donors List</title>
    <link rel="stylesheet" href="/orphanage/donors/donor.css">
</head>
<body>
<div class="container">
    <h1>Donors List</h1>
    <div class="btn-center">
    <a href="add.php"><button>Add New Donor</button></a>
            <a href="/orphanage/dashboard/dashboard.php"><button>Back to Dashboard</button></a>
</div>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Donation Amount</th>
            <th>Donation Date</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['address'] ?></td>
            <td><?= $row['donation_amount'] ?></td>
            <td><?= $row['donation_date'] ?></td>
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
