<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin-login.php");
    exit;
}

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
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

// Fetch donor registration details
$query = "SELECT name, gender, dob, weight, blood_group, state, district, phone, email, whatsapp FROM donors";
$result = $conn->query($query);

// Fetch blood donation registration details sorted by district
$blood_donation_query = "SELECT district, name, phone, blood_group, camp_area, camp_date FROM registrations ORDER BY district";
$blood_donation_result = $conn->query($blood_donation_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <div class="buttons">
                <a class="btn" href="update_camp.php">Update Camp Details</a>
                <a class="btn" href="donordetails.php">Enter Donated Donor Details</a>
                <a class="btn" href="donatedd.php">Donated</a>
            <a class="btn" href="send_alerts.php">Send Alerts</a>
                <form action="admin_dashboard.php" method="post" class="logout-form">
                    <button type="submit" name="logout" class="btn btn-logout">Logout</button>
                </form>
            </div>
        </div>

        <h2>Donor Registration Details</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Weight</th>
                <th>Blood Group</th>
                <th>State</th>
                <th>District</th>
                <th>Phone</th>
                <th>Email</th>
                <th>WhatsApp</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['dob']}</td>
                            <td>{$row['weight']}</td>
                            <td>{$row['blood_group']}</td>
                            <td>{$row['state']}</td>
                            <td>{$row['district']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['whatsapp']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No donors found.</td></tr>";
            }
            ?>
        </table>

        <h2>Blood Donation Registration Details</h2>
        <table>
            <tr>
                <th>District</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>Camp Area</th>
                <th>Camp Date</th>
            </tr>
            <?php
            if ($blood_donation_result->num_rows > 0) {
                while ($row = $blood_donation_result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['district']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['blood_group']}</td>
                            <td>{$row['camp_area']}</td>
                            <td>{$row['camp_date']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No registration details found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>