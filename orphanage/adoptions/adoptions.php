<?php
include "../database/dbconnect.php";
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

// Fetch adoptions along with child names
$query = mysqli_query($conn, "SELECT adoptions.*, children.name AS child_name 
                              FROM adoptions 
                              JOIN children ON adoptions.child_id = children.id
                              ORDER BY adoptions.id ASC");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Adoption List</title>
    <link rel="stylesheet" href="adopt.css">
</head>
<body>

<div class="container">
    <h1>All Adoption Records</h1>
    <div class="btn-center">
        <a href="add.php" class="btn">Add Adoption</a>
        <a href="/orphanage/dashboard/dashboard.php"><button>Back to Dashboard</button></a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Child</th>
            <th>Adopter Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Adoption Date</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($query)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['child_name']) ?></td>
            <td><?= htmlspecialchars($row['adopter_name']) ?></td>
            <td><?= htmlspecialchars($row['adopter_phone']) ?></td>
            <td><?= htmlspecialchars($row['adopter_address']) ?></td>
            <td><?= htmlspecialchars($row['adoption_date']) ?></td>
            <td>
                <a href="view.php?id=<?= $row['id'] ?>">View</a> |
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete record?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
