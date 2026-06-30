<?php
// Database configuration
$servername = "localhost";   
$username   = "root";        
$password   = "";          
$dbname     = "car_rental_system"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->set_charset("utf8");

?>
