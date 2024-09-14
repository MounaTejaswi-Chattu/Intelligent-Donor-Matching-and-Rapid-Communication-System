<?php
// Include config file
require_once "config.php";

// Initialize variables to store form data
$name = $gender = $dob = $weight = $blood_group = $state = $district = $phone = $email = $whatsapp = $password = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $gender = htmlspecialchars($_POST['gender']);
    $dob = htmlspecialchars($_POST['dob']);
    $weight = htmlspecialchars($_POST['weight']);
    $blood_group = htmlspecialchars($_POST['blood-group']);
    $state = htmlspecialchars($_POST['state']);
    $district = htmlspecialchars($_POST['district']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $whatsapp = htmlspecialchars($_POST['whatsapp']);
    $password = htmlspecialchars($_POST['password']);

    // Example of inserting data into a database (using prepared statements for security)
    $sql = "INSERT INTO donors (name, gender, dob, weight, blood_group, state, district, phone, email, whatsapp, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssssssssss", $name, $gender, $dob, $weight, $blood_group, $state, $district, $phone, $email, $whatsapp, $password);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Registration successful
            echo "Registration successful!";
            // Redirect to a success page or do further processing
            // header("location: success.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>Donor Registration</h1>
    </header>

    <main>
        <div class="form-container">
            <form id="registration-form" action="submit_form.php" method="post">
                <div class="form-row">
                    <div class="form-field">
                        <label for="donor-name">Name:</label>
                        <input type="text" id="donor-name" name="name" required>
                    </div>
                    <div class="form-field">
                        <label for="donor-gender">Gender:</label>
                        <select id="donor-gender" name="gender" required>
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label for="donor-dob">Date of Birth:</label>
                        <input type="date" id="donor-dob" name="dob" required>
                    </div>
                    <div class="form-field">
                        <label for="donor-weight">Weight (kg):</label>
                        <input type="number" id="donor-weight" name="weight" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label for="donor-blood-group">Blood Group:</label>
                        <select id="donor-blood-group" name="blood-group" required>
                            <option value="">Select</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="donor-state">State:</label>
                        <select id="donor-state" name="state" required>
                            <option value="andhra-pradesh">Andhra Pradesh</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label for="donor-district">District:</label>
                        <select id="donor-district" name="district" required>
                        <option value="">Select</option>
<option value="alluri-sitharama-raju">Alluri Sitharama Raju</option>
<option value="anakapalli">Anakapalli</option>
<option value="anantapur">Anantapur</option>
<option value="annamayya">Annamayya</option>
<option value="bapatla">Bapatla</option>
<option value="chittoor">Chittoor</option>
<option value="dr-b-r-ambedkar-konaseema">Dr. B.R. Ambedkar Konaseema</option>
<option value="east-godavari">East Godavari</option>
<option value="eluru">Eluru</option>
<option value="guntur">Guntur</option>
<option value="kadapa">Kadapa</option>
<option value="kakinada">Kakinada</option>
<option value="konaseema">Konaseema</option>
<option value="krishna">Krishna</option>
<option value="kurnool">Kurnool</option>
<option value="manyam">Manyam</option>
<option value="nandyal">Nandyal</option>
<option value="nellore">Nellore</option>
<option value="ntr">NTR</option>
<option value="parvathipuram-manyam">Parvathipuram Manyam</option>
<option value="prakasam">Prakasam</option>
<option value="sri-sathya-sai">Sri Sathya Sai</option>
<option value="srikakulam">Srikakulam</option>
<option value="tirupati">Tirupati</option>
<option value="visakhapatnam">Visakhapatnam</option>
<option value="vizianagaram">Vizianagaram</option>
<option value="west-godavari">West Godavari</option>

                        </select>
                    </div>
                    <div class="form-field">
                        <label for="donor-phone">Phone Number:</label>
                        <input type="tel" id="donor-phone" name="phone" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label for="donor-email">Email:</label>
                        <input type="email" id="donor-email" name="email" required>
                    </div>
                    <div class="form-field">
                        <label for="donor-whatsapp">WhatsApp Number:</label>
                        <input type="tel" id="donor-whatsapp" name="whatsapp" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label for="donor-password">Password:</label>
                        <input type="password" id="donor-password" name="password" required>
                        <button type="button" onclick="togglePasswordVisibility('donor-password')">Show</button>
                    </div>
                    <div class="form-field">
                        <label for="donor-confpassword">Confirm Password:</label>
                        <input type="password" id="donor-confpassword" name="confpassword" required>
                    </div>
                </div>
                <div class="form-row buttons">
                    <button type="submit" class="register-button">Register</button>
                </div>
                <div class="form-row buttons">
                    <p>Back to login <a href="signin.php">Click here</a></p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>