<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection settings
    $servername = "localhost";
    $username = "root";
    $password = "Bhavani@2005";
    $dbname = "donor_registration1";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    $query = "SELECT password FROM donors WHERE name =?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $input_username);
        $stmt->execute();
    
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hash);
            $stmt->fetch();

            if (password_verify($input_password, $hash)) {
                // Set session and redirect to the donor dashboard
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $input_username;
                header("location: donor_dashboard.php");
            } else {
                echo "<p>Invalid.</p>";
            }
        } else {
            echo "<p>No user found with that username.</p>";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }

    $conn->close();
}
?>