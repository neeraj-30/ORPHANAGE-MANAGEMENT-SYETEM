<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: /orphanage/auth/login.php");
    exit();
}

include("../database/dbconnect.php");

// Get adoption ID safely
$id = intval($_GET['id']);

// Delete adoption record
mysqli_query($conn, "DELETE FROM adoptions WHERE id = $id");

// Redirect back to adoption page
header("Location: adoptions.php");
exit();
?>
