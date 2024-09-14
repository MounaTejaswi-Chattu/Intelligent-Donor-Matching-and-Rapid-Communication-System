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

    // Insert the data into the database
    $query = "INSERT INTO admin2 (name, gender, dob, weight, blood_group, state, district, phone, email, whatsapp, password) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

    if ($stmt = $conn->prepare($query)) {
        $gender_value = 'male';
        $dob = '1976-11-12';
        $weight = 56;
        $blood_group = 'A+';
        $state = 'Andhra Pradesh';
        $district = 'Krishna';
        $phone = 6302437202;
        $email = 'check@gmail.com';
        $whatsapp = 6302437202;
        $stmt->bind_param("sssssssssss", $input_username, $gender_value, $dob, $weight, $blood_group, $state, $district, $phone, $email, $whatsapp, $input_password);
        $stmt->execute();
    } else {
        echo "Failed to prepare the SQL statement.";
    }

    // Login functionality
    $query = "SELECT password FROM admin2 WHERE name =?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $input_username);
        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();

            // Verify the input password against the stored password
            if ($input_password == $stored_password) {
                // Set session and redirect to the admin dashboard
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $input_username;
                header("location: admin_dashboard.php");
                exit;
            } else {
                echo "<p>Invalid password.</p>";
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

<!-- HTML form for login -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Login">
</form>