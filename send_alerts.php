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

// Fetch distinct blood groups for dropdown
$blood_groups_query = "SELECT DISTINCT blood_group FROM donors";
$blood_groups_result = $conn->query($blood_groups_query);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Initialize
$blood_group_filter = isset($_POST['blood_group']) ? $_POST['blood_group'] : "";
$message_data = [];
$email_feedback = "";

// If "Send Mail" button is clicked
if (isset($_POST['send_mail'])) {
    $donor_name  = $_POST['donor_name'];
    $donor_email = $_POST['donor_email'];
    $donor_group = $_POST['donor_group'];

    $subject = "Urgent Blood Requirement - {$donor_group}";
    $body = "Dear {$donor_name},<br><br>"
          . "We urgently need your blood group ({$donor_group}).<br>"
          . "Please contact us immediately if available.<br><br>"
          . "Thank you for your support!";

    $mail = new PHPMailer(true);
    try {
        // SMTP config
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '22b01a4610@svecw.edu.in'; 
        $mail->Password = 'rjvpngzifrqognmf'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('22b01a4610@svecw.edu.in', 'Blood Donation Team');
        $mail->addAddress($donor_email, $donor_name);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        $email_feedback = "✅ Email successfully sent to {$donor_name} ({$donor_email})";
    } catch (Exception $e) {
        $email_feedback = "❌ Email to {$donor_name} failed: {$mail->ErrorInfo}";
    }
}

// Fetch donors if filter is applied
if ($blood_group_filter) {
    $query = "SELECT name, email, blood_group FROM donors WHERE blood_group = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $blood_group_filter);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $message_data[] = $row;
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
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #f4f4f4; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Send Alerts</h1>
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>

    <?php if ($email_feedback): ?>
        <p class="<?php echo (strpos($email_feedback, '✅') !== false) ? 'success' : 'error'; ?>">
            <?php echo $email_feedback; ?>
        </p>
    <?php endif; ?>

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

    <?php if (!empty($message_data)): ?>
        <h2>Eligible Donors</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Blood Group</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach ($message_data as $donor): ?>
                <tr>
                    <td><?php echo $donor['name']; ?></td>
                    <td><?php echo $donor['blood_group']; ?></td>
                    <td><?php echo $donor['email']; ?></td>
                    <td>
                        <form method="POST" action="send_alerts.php">
                            <input type="hidden" name="donor_name" value="<?php echo $donor['name']; ?>">
                            <input type="hidden" name="donor_email" value="<?php echo $donor['email']; ?>">
                            <input type="hidden" name="donor_group" value="<?php echo $donor['blood_group']; ?>">
                            <input type="hidden" name="blood_group" value="<?php echo $blood_group_filter; ?>">
                            <button type="submit" name="send_mail">Send Mail</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($blood_group_filter): ?>
        <p>No donors found for this blood group.</p>
    <?php endif; ?>
</div>
</body>
</html>
