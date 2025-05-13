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
$password = "lucky2@@9";
$dbname = "donor_registration1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize a variable to store the popup message
$message = "";

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
        $message = "Camp details updated successfully!";
    } else {
        $message = "Error updating camp details: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Camp Details</title>
    <script>
        // Display popup if a message is set
        document.addEventListener("DOMContentLoaded", function () {
            const message = "<?php echo addslashes($message); ?>";
            if (message) {
                alert(message);
                // Redirect to the admin dashboard after showing the alert
                window.location.href = "admin_dashboard.php";
            }
        });
    </script>
</head>
<body>
</body>
</html>
