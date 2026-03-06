<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM staff WHERE id=$id");

header("Location: staff.php");
exit();
