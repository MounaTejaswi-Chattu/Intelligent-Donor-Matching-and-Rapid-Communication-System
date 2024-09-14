<?php
// Start the session
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

// Handle district filter
$selected_district = isset($_POST['district']) ? $_POST['district'] : '';

// Fetch unique districts for the dropdown
$district_query = "SELECT DISTINCT district FROM donorsdetails ORDER BY district";
$district_result = $conn->query($district_query);

// Fetch donor registration details based on selected district
if ($selected_district == '' || $selected_district == 'Select') {
    $query = "SELECT id, name, phone, blood_group, district, camp_area, camp_date FROM donorsdetails";
} else {
    $query = "SELECT id, name, phone, blood_group, district, camp_area, camp_date FROM donorsdetails WHERE district = ?";
}

$stmt = $conn->prepare($query);
if ($selected_district != '' && $selected_district != 'Select') {
    $stmt->bind_param("s", $selected_district);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        select, button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
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
        .btn-thank-you {
            background-color: #28a745;
            color: #fff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
        }
        .btn-thank-you:hover {
            background-color: #218838;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <form method="post">
            <label for="district">Filter by District:</label>
            <select id="district" name="district" onchange="this.form.submit()">
                <option value="">Select</option>
                <?php
                if ($district_result->num_rows > 0) {
                    while ($row = $district_result->fetch_assoc()) {
                        $selected = ($row['district'] === $selected_district) ? 'selected' : '';
                        echo "<option value='{$row['district']}' $selected>" . htmlspecialchars($row['district']) . "</option>";
                    }
                }
                ?>
            </select>
        </form>

        <h2>Donor Registration Details</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>District</th>
                <th>Camp Area</th>
                <th>Camp Date</th>
                <th>Actions</th>
            </tr>
            <a class="btn" href="admin_dashboard.php">Back</a>
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
                            <td>
                                <form action='thankyou.php' method='POST'>
                                    <input type='hidden' name='donor_name' value='{$row['name']}'>
                                    <button type='submit' class='btn btn-thank-you'>Thank You</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
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
