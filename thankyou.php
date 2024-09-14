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
    $donorName = $_POST['donor_name'];
    $message = " $donorName!,Thank you for donating your blood you saved a life.";

    $stmt = $conn->prepare("INSERT INTO thank_you_messages (donor_name, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $donorName, $message);

    if ($stmt->execute()) {
        echo "Thank you message sent.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<html>
    <body>
    <a class="btn" href="donatedd.php">Back</a>
</body>
    </html>
