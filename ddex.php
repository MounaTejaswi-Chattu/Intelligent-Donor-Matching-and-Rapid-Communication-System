<?php
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $blood_group = $_POST['blood_group'];
    $district = $_POST['district'];
    $camp_area = $_POST['camp_area'];
    $camp_date = $_POST['camp_date'];

    // Validate and sanitize input
    $name = $conn->real_escape_string($name);
    $phone = $conn->real_escape_string($phone);
    $blood_group = $conn->real_escape_string($blood_group);
    $district = $conn->real_escape_string($district);
    $camp_area = $conn->real_escape_string($camp_area);
    $camp_date = $conn->real_escape_string($camp_date);

    // Convert camp_date to a valid date format
    $camp_date = date('Y-m-d', strtotime($camp_date));

    // Insert data into the database
    $sql = "INSERT INTO donorsdetails (name, phone, blood_group, district, camp_area, camp_date)
            VALUES ('$name', '$phone', '$blood_group', '$district', '$camp_area', '$camp_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close connection
    $conn->close();
}
?>
