<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin-login.php");
    exit;
}

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

$selected_district = isset($_POST['district']) ? $_POST['district'] : '';

// Fetch unique districts for the dropdown
$district_query = "SELECT DISTINCT district FROM donorsdetails ORDER BY district";
$district_result = $conn->query($district_query);

// Fetch donors who haven't been thanked
if (empty($selected_district)) {
    $query = "SELECT id, name, phone, blood_group, district, camp_area, camp_date FROM donorsdetails WHERE thanked = 0";
} else {
    $query = "SELECT id, name, phone, blood_group, district, camp_area, camp_date FROM donorsdetails WHERE thanked = 0 AND district = ?";
}

$stmt = $conn->prepare($query);
if (!empty($selected_district)) {
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
        .back-btn {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .back-btn:hover {
            background-color: #c82333;
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
        .btn-history {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .btn-history:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <a class="back-btn" href="admin_dashboard.php">Back</a>
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
                                    <input type='hidden' name='donor_id' value='{$row['id']}'>
                                    <input type='hidden' name='donor_name' value='{$row['name']}'>
                                    <button type='submit' class='btn-thank-you'>Thank You</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </table>
        <a href="history.php" class="btn-history">View History</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>