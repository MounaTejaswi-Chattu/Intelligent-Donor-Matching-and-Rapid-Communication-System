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
$username = "root"; // Change as needed
$password = "Bhavani@2005"; // Change as needed
$dbname = "donor_registration1"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch latest unseen message for the logged-in donor
$loggedInDonorName = $_SESSION['username']; // Assuming the donor's name is stored in the session
$sql = "SELECT id, message FROM thank_you_messages WHERE donor_name = ? AND is_seen = FALSE ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInDonorName);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    echo "Error in SQL query: " . $conn->error;
} elseif ($result->num_rows > 0) {
    // Output the message
    $row = $result->fetch_assoc();
    $messageId = $row['id'];
    $messageContent = $row['message'];
    $messageDiv = "<div id='thank-you-message' class='thank-you-message'>";
    $messageDiv .= "<p>$messageContent</p>";
    $messageDiv .= "<button class='btn' onclick='markAsSeen($messageId)'>OK</button>";
    $messageDiv .= "</div>";

    // JavaScript to mark the message as seen
    echo $messageDiv;
    echo "
    <script>
    function markAsSeen(messageId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'mark_as_seen.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('thank-you-message').style.display = 'none';
            }
        };
        xhr.send('id=' + messageId);
    }
    </script>
    ";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Eligibility</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
        }
        .btn-eligibility {
            background-color: #28a745;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .rules {
            margin-bottom: 20px;
        }
        .rule {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f1f1f1;
        }
        .thank-you-message {
            max-width: 500px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #e9f7ef;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            text-align: center;
        }
        .thank-you-message p {
            margin: 10px 0;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blood Donation Eligibility</h1>
        <div class="rules">
            <div class="rule">1. Age should be between 18-65 years.</div>
            <div class="rule">2. Weigh at least 50 kg.</div>
            <div class="rule">3. Hemoglobin level should be above 12.5 g/dL for females and 13.5 g/dL for males.</div>
            <div class="rule">4. No history of infectious diseases like HIV, Hepatitis B or C, etc.</div>
            <div class="rule">5. Should not have consumed alcohol 24 hours before donation.</div>
            <div class="rule">6. Should not have taken any antibiotics in the last 2 weeks.</div>
            <div class="rule">7. Free of any serious heart or lung conditions.</div>
            <div class="rule">8. Blood pressure should be within the range of 90/60 to 180/100 mmHg.</div>
            <div class="rule">9. Should not have undergone major surgery in the past six months.</div>
            <div class="rule">10. Should not be pregnant or breastfeeding.</div>
            <div class="rule">11. Should not have had a tattoo or piercing in the last 6 months.</div>
            <div class="rule">12. Should not have a history of cancer or other serious illnesses.</div>
            <div class="rule">13. Must be well-rested and hydrated before donating blood.</div>
            <div class="rule">14. Should not have donated blood in the last 12 weeks (for whole blood). Plasma or platelets have different intervals.</div>
            <div class="rule">15. Should not have been treated with blood products in the past year.</div>
        </div>
        <a href="view_venue.php" class="btn btn-back">View Venue</a>
        <a class="btn" href="index.php">Logout</a>
    </div>
</body>
</html>
