<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin-login.php");
    exit;
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "Bhavani@2005";
$dbname = "donor_registration1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $district = $_POST['district'];
    $camp_area = $_POST['camp_area'];
    $camp_date = $_POST['camp_date'];
    $camp_time_from = $_POST['camp_time_from'];
    $time_from_period = $_POST['time_from_period'];
    $camp_time_to = $_POST['camp_time_to'];
    $time_to_period = $_POST['time_to_period'];

    // Convert time to 24-hour format
    $camp_time_from_24 = date("H:i", strtotime($camp_time_from . " " . $time_from_period));
    $camp_time_to_24 = date("H:i", strtotime($camp_time_to . " " . $time_to_period));

    $query = "INSERT INTO camp_details (district, camp_area, camp_date, camp_time_from, camp_time_to) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $district, $camp_area, $camp_date, $camp_time_from_24, $camp_time_to_24);

    if ($stmt->execute()) {
        echo "Camp details updated successfully!";
    } else {
        echo "Error updating camp details: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

// Redirect back to admin dashboard
header("location: admin_dashboard.php");
exit;
?>