<?php
include "DB.php";

// Query to get column names
$sql = "SHOW COLUMNS FROM $tablename";
$result = mysqli_query($conn, $sql);

$columns = array(); // array to store column names

if($result){
    while($row = mysqli_fetch_assoc($result)){
        $columns[] = $row['Field']; // 'Field' contains the column name
    }
}

$_SESSION['selectedFields'] = $columns;
header("location: show_records.php");
exit;

?>
