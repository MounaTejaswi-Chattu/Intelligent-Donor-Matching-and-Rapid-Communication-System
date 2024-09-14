<?php
// Database configuration file
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the form
    $district = $_POST['district'];
    $camp_area = $_POST['camp_area'];
    $camp_date = $_POST['camp_date'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $blood_group = $_POST['blood_group'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO registrations (district, camp_area, camp_date, name, phone, blood_group) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $district, $camp_area, $camp_date, $name, $phone, $blood_group);

    // Execute the statement
    if ($stmt->execute()) {
        // Display a success message and redirect using JavaScript
        echo "<script>
                alert('Registration successful! Thank you for your contribution.');
                window.location.href = 'logout.php';
              </script>";
    } else {
        // Display an error message
        echo "<script>
                alert('Error: " . addslashes($stmt->error) . "');
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Status</title>
</head>
<body>
</body>
</html>
