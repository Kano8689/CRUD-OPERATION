<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rdbms";
$tablename = "students";

//Connection
$conn = new mysqli($servername, $username, $password, $dbname);

	//Create Table
	$create = "CREATE TABLE IF NOT EXISTS $tablename (
	    id INT AUTO_INCREMENT PRIMARY KEY,
	    name VARCHAR(50) NOT NULL,
	    enroll_no VARCHAR(15),
	    degree VARCHAR(50),
	    prev_degree VARCHAR(50),
	    prev_clg VARCHAR(100),
	    mo_no VARCHAR(15),
	    hostel BOOLEAN
	)";
	mysqli_query($conn, $create);

	//Alter Table
	// $alter = "ALTER TABLE $tablename ADD COLUMN city VARCHAR(50) AFTER prev_clg, ADD COLUMN state VARCHAR(50) AFTER city";
	// mysqli_query($conn, $alter);

?>
