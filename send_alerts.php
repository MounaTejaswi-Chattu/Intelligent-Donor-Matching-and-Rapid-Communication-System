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

// Fetch distinct blood groups for the dropdown
$blood_groups_query = "SELECT DISTINCT blood_group FROM donors";
$blood_groups_result = $conn->query($blood_groups_query);

// Initialize blood group filter
$blood_group_filter = isset($_POST['blood_group']) ? $_POST['blood_group'] : "";

// Handle the WhatsApp message functionality
$message_data = [];
if ($blood_group_filter) {
    $query = "
        SELECT donors.name AS donor_name, donors.whatsapp, donors.blood_group, donors.dob,
               MAX(donorsdetails.camp_date) AS last_donation_date
        FROM donors
        LEFT JOIN donorsdetails ON donors.phone = donorsdetails.phone
        WHERE donors.blood_group = ?
        GROUP BY donors.id";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $blood_group_filter);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $last_donation_date = $row['last_donation_date'] ?? null;
        $eligible = false;
        $months_left = 0;
        $days_left = 0;

        // Check eligibility (6 months = 180 days)
        if ($last_donation_date) {
            $donation_date = new DateTime($last_donation_date);
            $current_date = new DateTime();
            $diff = $donation_date->diff($current_date);
            $days_since_last_donation = $diff->days;

            // Check if they donated in the last 6 months (180 days)
            if ($days_since_last_donation >= 180) {
                $eligible = true;
            } else {
                $days_left = 180 - $days_since_last_donation;
                $months_left = floor($days_left / 30);
                $days_left = $days_left % 30;
            }
        } else {
            // If there is no donation record, treat it as eligible
            $eligible = true;
        }

        // Prepare the data for display
        if ($eligible) {
            $message = urlencode("Dear {$row['donor_name']},\nWe urgently need your blood group ({$row['blood_group']}). Please contact us immediately if available. Thank you for your support!");
            $whatsapp_link = "https://wa.me/{$row['whatsapp']}?text={$message}";
            $message_data[] = [
                'eligible' => true,
                'name' => $row['donor_name'],
                'whatsapp_link' => $whatsapp_link,
            ];
        } else {
            $popup_message = "Donor {$row['donor_name']} is not eligible to donate. Next eligible in {$months_left} months and {$days_left} days.";
            $message_data[] = [
                'eligible' => false,
                'name' => $row['donor_name'],
                'popup_message' => $popup_message,
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Alerts</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showPopup(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Send Alerts</h1>
            <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
        </div>

        <h2>Filter Donors by Blood Group</h2>
        <form method="POST" action="send_alerts.php" class="filter-form">
            <label for="blood_group">Select Blood Group:</label>
            <select name="blood_group" id="blood_group">
                <option value="">-- All Blood Groups --</option>
                <?php
                if ($blood_groups_result->num_rows > 0) {
                    while ($row = $blood_groups_result->fetch_assoc()) {
                        $selected = ($blood_group_filter === $row['blood_group']) ? 'selected' : '';
                        echo "<option value='{$row['blood_group']}' $selected>{$row['blood_group']}</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Filter</button>
        </form>

        <h2>Send WhatsApp Alerts</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            if (!empty($message_data)) {
                foreach ($message_data as $data) {
                    if ($data['eligible']) {
                        echo "<tr>
                                <td>{$data['name']}</td>
                                <td>Eligible</td>
                                <td><a class='send-alert-btn' href='{$data['whatsapp_link']}' target='_blank'>Send Alert</a></td>
                              </tr>";
                    } else {
                        echo "<tr>
                                <td>{$data['name']}</td>
                                <td>Not Eligible</td>
                                <td><button class='btn' onclick=\"showPopup('{$data['popup_message']}')\">Send Alert</button></td>
                              </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='3'>No donors found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>