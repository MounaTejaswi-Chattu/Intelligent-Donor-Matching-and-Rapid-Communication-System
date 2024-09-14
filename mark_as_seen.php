<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $messageId = $_POST['id'];

    $stmt = $conn->prepare("UPDATE thank_you_messages SET is_seen = TRUE WHERE id = ?");
    $stmt->bind_param("i", $messageId);

    if ($stmt->execute()) {
        echo "Message marked as seen.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
