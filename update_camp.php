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
$password = "Bhavani@2005";
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
            margin: 50px auto;
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
        .form-group textarea {
            height: 100px;
        }
        .form-group .time-group {
            display: flex;
            justify-content: space-between;
        }
        .form-group .time-group input[type="time"] {
            width: 70%;
        }
        .form-group .time-group select {
            width: 28%;
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
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
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
                <div class="time-group">
                    <input type="time" id="camp_time_from" name="camp_time_from" required>
                    <select name="time_from_period" id="time_from_period">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="camp_time_to">To (Time):</label>
                <div class="time-group">
                    <input type="time" id="camp_time_to" name="camp_time_to" required>
                    <select name="time_to_period" id="time_to_period">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn">Save Donation Details</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>