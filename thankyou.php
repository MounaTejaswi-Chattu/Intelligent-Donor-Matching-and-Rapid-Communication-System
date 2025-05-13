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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donorId = $_POST['donor_id']; // Get donor ID from POST
    $donorName = $_POST['donor_name']; // Get donor name from POST

    // Retrieve donor details
    $stmt = $conn->prepare("SELECT * FROM donorsdetails WHERE id = ?");
    $stmt->bind_param("i", $donorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $donor = $result->fetch_assoc();

        // Create thank-you message
        $message = "$donorName, thank you for donating your blood! You saved a life.";

        // WhatsApp message URL (replace with the donor's phone number)
        $whatsappMessage = urlencode($message);
        $whatsappPhone = $donor['phone']; // Assuming the donor's phone number is stored in the 'phone' column

        // Format phone number for WhatsApp (ensure no spaces or + signs)
        $whatsappPhone = preg_replace('/\D/', '', $whatsappPhone); // Remove non-numeric characters
        $whatsappUrl = "https://wa.me/$whatsappPhone?text=$whatsappMessage";

        // Mark donor as thanked in donorsdetails table
        $updateStmt = $conn->prepare("UPDATE donorsdetails SET thanked = 1 WHERE id = ?");
        $updateStmt->bind_param("i", $donorId);
        $updateStmt->execute();

        // Insert record into history table
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

        // Save thank-you message in the thank_you_messages table
        $messageStmt = $conn->prepare(
            "INSERT INTO thank_you_messages (donor_name, message) VALUES (?, ?)"
        );
        $messageStmt->bind_param("ss", $donorName, $message);
        $messageStmt->execute();

        // Close statements
        $updateStmt->close();
        $historyStmt->close();
        $messageStmt->close();
        
        // Redirect to WhatsApp using JavaScript (opens the WhatsApp app or web client)
        echo "<script>window.location.href = '$whatsappUrl';</script>";
        exit;
    } else {
        echo "<p>Error: Donor not found.</p>";
    }

    $stmt->close();
}

$conn->close();
?>