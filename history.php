<?php
// Start session
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

// Fetch donor history
$query = "SELECT name, phone, blood_group, district, camp_area, camp_date FROM history ORDER BY camp_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #ff3333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="back-btn" href="admin_dashboard.php">Back</a>
        <h1>Donor History</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>District</th>
                <th>Camp Area</th>
                <th>Camp Date</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['blood_group']}</td>
                            <td>{$row['district']}</td>
                            <td>{$row['camp_area']}</td>
                            <td>{$row['camp_date']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No history found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>