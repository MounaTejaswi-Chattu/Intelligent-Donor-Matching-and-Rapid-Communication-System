<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin-login.php");
    exit;
}

// Database connection settings
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Donation Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #ff3333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"], .form-group input[type="date"], .form-group textarea, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            background-color: #28a745;
        }
        .btn-secondary {
            background-color: #007bff;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="back-btn" href="admin_dashboard.php">Back</a>
        <h1>Update Donation Details</h1>
        <form method="POST" action="save_camp_details.php">
            <div class="form-group">
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
            <div class="form-group">
                <label for="camp_area">Donation Area:</label>
                <textarea id="camp_area" name="camp_area" required></textarea>
            </div>
            <div class="form-group">
                <label for="camp_date">Donation Date:</label>
                <input type="date" id="camp_date" name="camp_date" required>
            </div>
            <div class="form-group">
                <label for="camp_time_from">From (Time):</label>
                <input type="time" id="camp_time_from" name="camp_time_from" required>
            </div>
            <div class="form-group">
                <label for="camp_time_to">To (Time):</label>
                <input type="time" id="camp_time_to" name="camp_time_to" required>
            </div>
            <button type="submit" class="btn">Save Donation Details</button>
        </form>
        <a href="camp_details_history.php" class="btn btn-secondary">Camp History</a>
    </div>
</body>
</html>

<?php
$conn->close();
?><?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin-login.php");
    exit;
}

// Database connection settings
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

// Check if the form is submitted and data is saved successfully
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save data to the database (you should validate and sanitize input data here)
    $district = $_POST['district'];
    $camp_area = $_POST['camp_area'];
    $camp_date = $_POST['camp_date'];
    
    // Convert time from 12-hour format to 24-hour format
    $camp_time_from = $_POST['camp_time_from'];
    $camp_time_to = $_POST['camp_time_to'];

    // Convert '12:00 PM' to 24-hour format using DateTime
    $camp_time_from_24hr = DateTime::createFromFormat('h:i A', $camp_time_from)->format('H:i:s');
    $camp_time_to_24hr = DateTime::createFromFormat('h:i A', $camp_time_to)->format('H:i:s');

    // Insert the data into the database
    $sql = "INSERT INTO camp_details (district, camp_area, camp_date, camp_time_from, camp_time_to) 
            VALUES ('$district', '$camp_area', '$camp_date', '$camp_time_from_24hr', '$camp_time_to_24hr')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Donation details updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Donation Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(''); /* You can add a background image here */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #ff3333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            background-color: #28a745;
        }
        .btn-secondary {
            background-color: #007bff;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="back-btn" href="admin_dashboard.php">Back</a>
        <h1>Update Donation Details</h1>
        
        <!-- Success and Error Alerts -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <script>
                alert("<?php echo $_SESSION['success_message']; ?>");
            </script>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <script>
                alert("<?php echo $_SESSION['error_message']; ?>");
            </script>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Donation Form -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="donor-district">District:</label>
                <select id="donor-district" name="district" required>
                    <option value="">Select</option>
                    <!-- Add the rest of your district options here -->
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
            <div class="form-group">
                <label for="camp_area">Donation Area:</label>
                <textarea id="camp_area" name="camp_area" required></textarea>
            </div>
            <div class="form-group">
                <label for="camp_date">Donation Date:</label>
                <input type="date" id="camp_date" name="camp_date" required>
            </div>
            <div class="form-group">
                <label for="camp_time_from">From (Time):</label>
                <input type="text" id="camp_time_from" name="camp_time_from" class="timepicker" required>
            </div>
            <div class="form-group">
                <label for="camp_time_to">To (Time):</label>
                <input type="text" id="camp_time_to" name="camp_time_to" class="timepicker" required>
            </div>
            <button type="submit" class="btn">Save Donation Details</button>
        </form>
        <a href="camp_details_history.php" class="btn btn-secondary">Camp History</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('.timepicker', {
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K", // AM/PM format
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>