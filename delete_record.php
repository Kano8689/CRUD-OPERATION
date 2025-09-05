<?php
include "DB.php"; // database connection

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "DELETE FROM $tablename WHERE id = $id";
    if(mysqli_query($conn, $sql)){
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    // Redirect back
    header("Location: show_records.php");
    exit;
} else {
    header('location: index.php');
}
?>
