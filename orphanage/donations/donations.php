<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$result = mysqli_query($conn, "
    SELECT d.*, dn.name as donor_name 
    FROM donations d 
    JOIN donors dn ON d.donor_id = dn.id
    ORDER BY d.donation_date ASC
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donations List</title>
    <link rel="stylesheet" href="/orphanage/donations/donations-style.css">
</head>
<body>
<div class="container">
    <h1>Donations List</h1>
    <div class="btn-center">
    <a href="add.php"><button>Add Donation</button></a>
            <a href="/orphanage/dashboard/dashboard.php"><button>Back to Dashboard</button></a>
</div>
    <table>
        <tr>
            <th>ID</th>
            <th>Donor</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Type</th>
            <th>Notes</th>
            <th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['donor_name'] ?></td>
            <td><?= $row['amount'] ?></td>
            <td><?= $row['donation_date'] ?></td>
            <td><?= $row['donation_type'] ?></td>
            <td><?= $row['notes'] ?></td>
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
