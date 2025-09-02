<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin-login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username   = "root";
$password   = "lucky2@@9";
$dbname     = "donor_registration1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// PHPMailer import (must be at top level, not inside if)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donorId   = $_POST['donor_id'];
    $donorName = $_POST['donor_name'];

    // Retrieve donor details
    $stmt = $conn->prepare("SELECT * FROM donorsdetails WHERE id = ?");
    $stmt->bind_param("i", $donorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $donor   = $result->fetch_assoc();
        $message = "$donorName, thank you for donating your blood! You saved a life.";

        // --- PHPMailer setup ---
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = '22b01a4610@svecw.edu.in'; // Sender Gmail
            $mail->Password   = 'rjvpngzifrqognmf';        // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('22b01a4610@svecw.edu.in', 'Blood Donation Team');
            $mail->addAddress($donor['email'], $donor['name']); // Donor email

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Thank You for Donating Blood!";
            $mail->Body    = "<p>Dear {$donor['name']},</p>
                              <p>{$message}</p>
                              <p>Regards,<br>Your Organization</p>";

            $mail->send();

            // --- Update donor record as thanked ---
            $updateStmt = $conn->prepare("UPDATE donorsdetails SET thanked = 1 WHERE id = ?");
            $updateStmt->bind_param("i", $donorId);
            $updateStmt->execute();

            // --- Save to history ---
            $historyStmt = $conn->prepare(
                "INSERT INTO history (donor_id, name, phone, blood_group, district, camp_area, camp_date) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $historyStmt->bind_param(
                "issssss",
                $donor['id'],
                $donor['name'],
                $donor['phone'],
                $donor['blood_group'],
                $donor['district'],
                $donor['camp_area'],
                $donor['camp_date']
            );
            $historyStmt->execute();

            // --- Save thank-you message ---
            $messageStmt = $conn->prepare(
                "INSERT INTO thank_you_messages (donor_name, message) VALUES (?, ?)"
            );
            $messageStmt->bind_param("ss", $donorName, $message);
            $messageStmt->execute();

            echo "<p>Email has been sent successfully to {$donor['email']}</p>";

            // Close statements
            $updateStmt->close();
            $historyStmt->close();
            $messageStmt->close();

        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<p>Error: Donor not found.</p>";
    }

    $stmt->close();
}
$conn->close();
?>
