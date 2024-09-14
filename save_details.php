<?php
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "Bhavani@2005";  // Replace with your database password
$dbname = "donor_registration1";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$updateSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $district = $conn->real_escape_string($_POST['district']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $bloodGroup = $conn->real_escape_string($_POST['bloodGroup']);
    $sql = "INSERT INTO donorsd (name, district, phone, blood_group) VALUES ('$name', '$district', '$phone', '$bloodGroup')";

    if ($conn->query($sql) === TRUE) {
        $updateSuccess = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Registration</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .button {
            display: block;
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function showAlert() {
            alert('Details updated successfully');
        }
    </script>
</head>
<body>
    <!--<div class="container">
        <h2>Donor Registration Form</h2>
        <form method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            <label for="district">District:</label><br>
            <input type="text" id="district" name="district" required><br><br>
            <label for="phone">Phone:</label><br>
            <input type="text" id="phone" name="phone" required><br><br>
            <label for="bloodGroup">Blood Group:</label><br>
            <input type="text" id="bloodGroup" name="bloodGroup" required><br><br>
            <input type="submit" value="Submit">
        </form><!-->
        <?php
        if ($updateSuccess) {
            echo '<script>showAlert();</script>';
            echo '<a href="view_venue.php" class="button">View Venue</a>';
        }
        ?>
    </div>
</body>
</html>