<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

include "../database/dbconnect.php";

if(isset($_POST['name'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = intval($_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    $query = "INSERT INTO children (name, age, gender) VALUES ('$name', '$age', '$gender')";

    if(mysqli_query($conn, $query)){
        // Redirect to children list after successful save
        header("Location: children.php");
        exit();
    } else {
        // Show error if insertion fails
        echo "Failed to add child: " . mysqli_error($conn);
    }
} else {
    // Redirect back if form not submitted
    header("Location: add_child.php");
    exit();
}
?>
