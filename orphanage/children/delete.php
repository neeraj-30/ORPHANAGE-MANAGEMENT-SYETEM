<?php
include "../database/dbconnect.php";

$id = $_GET['id'];

// Delete related adoption records first
mysqli_query($conn, "DELETE FROM adoptions WHERE child_id = $id");

// Now delete the child
mysqli_query($conn, "DELETE FROM children WHERE id = $id");

header("Location: children.php");
?>
