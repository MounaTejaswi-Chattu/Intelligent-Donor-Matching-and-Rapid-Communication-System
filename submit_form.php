<?php

require_once "config.php";
$servername = "localhost";
$username = "root";
$password = "Bhavani@2005";
$dbname = "donor_registration1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " .$conn->connect_error);
}

// Get the form data
$name = $_POST['name'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$weight = $_POST['weight'];
$blood_group = $_POST['blood-group'];
$state = $_POST['state'];
$district = $_POST['district'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$whatsapp = $_POST['whatsapp'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if a donor with the same name already exists
$sql = "SELECT * FROM donors WHERE name = '$name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "A donor with the same name already exists.";
} else {
    // Insert data into the database
    $sql = "INSERT INTO donors (name, gender, dob, weight, blood_group, state, district, phone, email, whatsapp, password) 
            VALUES ('$name', '$gender', '$dob', '$weight', '$blood_group', '$state', '$district', '$phone', '$email', '$whatsapp', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Successfully Registered";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<html>
    <body>
    <p>Back to login <a href="signin.php">Click here</a></p>
</body>
    </html>