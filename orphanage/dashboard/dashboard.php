<?php

session_start();
if(!isset($_SESSION['admin_id'])){
header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

// Fetch counts
$children_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM children"))['total'];
$staff_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM staff"))['total'];
$donors_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM donors"))['total'];
$donations_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM donations"))['total'];
$inventory_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM inventory"))['total'];
$adoptions_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM adoptions"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Orphanage Management System</title>
    <link rel="stylesheet" href="/orphanage/dashboard/dash.css">
  <style>
/* Global */
body {
    font-family: "Poppins", Arial, sans-serif;
    background: #eef1f6;
    margin: 0;
    padding: 0;
}

/* Navbar */
nav {
    background: #374151;
    padding: 14px 0;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}
nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    text-align: center;
}
nav ul li {
    display: inline-block;
    margin: 0 18px;
}
nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    padding: 6px 12px;
    font-size: 15px;
    border-radius: 6px;
    transition: 0.25s ease;
}
nav ul li a:hover {
    background: #374151;
    transform: translateY(-2px);
}
/* Dashboard Wrapper */
.dashboard {
    max-width: 500px;          /* keeps the grid centered */
    margin: 40px auto;
    display: grid;
    grid-template-columns: repeat(2, 1fr);   /* 2 cards per row */
    gap: 25px;                 /* equal spacing between cards */
}

.card {
    padding: 25px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.15);
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: auto;           /* FIXED */
}


.card h2 {
    margin-bottom: 5px;
    font-size: 18px;
}

.card p {
    font-size: 22px;
    margin: 0;
}
.card img {
    width: 42px;
    height: 42px;
    object-fit: contain;
    margin: 0 auto 10px auto;
    opacity: 0.9;
}


/* Navigation remains same */
nav ul {
    list-style: none;
    background: #374151;
    padding: 10px;
}

nav ul li {
    display: inline-block;
    margin-right: 20px;
}
nav ul li a {
    color: white;
    text-decoration: none;
}

</style>

<body>

<!-- NAVBAR -->
<nav>
    <ul>
        <li><a href="/orphanage/dashboard/dashboard.php">Dashboard</a></li>
      <!--  <li><a href="/orphanage/auth/register.php">Register</a></li>-->
        <li><a href="/orphanage/children/children.php">Children</a></li>
        <li><a href="/orphanage/staff/staff.php">Staff</a></li>
        <li><a href="/orphanage/donors/donors.php">Donors</a></li>
        <li><a href="/orphanage/donations/donations.php">Donations</a></li>
        <li><a href="/orphanage/inventory/inventory.php">Inventory</a></li>
        <li><a href="/orphanage/adoptions/adoptions.php">Adoptions</a></li>
        <li><a href="/orphanage/auth/logout.php">Logout</a></li>
    </ul>
</nav>

<h1 style="text-align:center; margin-top: 30px;">
    Welcome, <?= $_SESSION['admin_name']; ?>!
</h1>

<div class="dashboard">

<div class="card">
    <img src="/orphanage/icons/child.jpg">
    <h2>Children</h2>
    <p><?= $children_count ?></p>
</div>

<div class="card">
    <img src="/orphanage/icons/staff.jpg">
    <h2>Staff</h2>
    <p><?= $staff_count ?></p>
</div>

<div class="card">
    <img src="/orphanage/icons/donor.png">
    <h2>Donors</h2>
    <p><?= $donors_count ?></p>
</div>

<div class="card">
    <img src="/orphanage/icons/donation.png">
    <h2>Donations</h2>
    <p><?= $donations_count ?></p>
</div>

<div class="card">
    <img src="/orphanage/icons/inventory.png">
    <h2>Inventory</h2>
    <p><?= $inventory_count ?></p>
</div>

<div class="card">
    <img src="/orphanage/icons/adoption.png">
    <h2>Adoptions</h2>
    <p><?= $adoptions_count ?></p>
</div>

</div>



</body>
</html>
