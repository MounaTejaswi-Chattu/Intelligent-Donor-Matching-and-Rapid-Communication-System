<?php
// Database configuration file
$servername = "localhost";
$username = "root";
$password = "lucky2@@9";
$dbname = "donor_registration1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
