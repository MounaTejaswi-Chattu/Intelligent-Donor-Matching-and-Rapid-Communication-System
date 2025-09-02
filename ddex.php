<?php
// Database connection settings
$servername = "localhost";
$username   = "root";
$password   = "lucky2@@9";
$dbname     = "donor_registration1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name        = $_POST['name'];
    $email       = $_POST['email'];  // ✅ new field
    $phone       = $_POST['phone'];
    $blood_group = $_POST['blood_group'];
    $district    = $_POST['district'];
    $camp_area   = $_POST['camp_area'];
    $camp_date   = $_POST['camp_date'];

    // Convert camp_date to a valid format (YYYY-MM-DD)
    $camp_date = date('Y-m-d', strtotime($camp_date));

    // ✅ Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO donorsdetails 
        (name, phone, email, blood_group, district, camp_area, camp_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $phone, $email, $blood_group, $district, $camp_area, $camp_date);

    if ($stmt->execute()) {
        echo "<p>Donor record added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close statement & connection
    $stmt->close();
    $conn->close();
}
?>
