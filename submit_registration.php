<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $district = $_POST['district'];
    $camp_area = $_POST['camp_area'];
    $camp_date = $_POST['camp_date'];
} else {
    // Set default values or get from the URL parameters
    $district = isset($_GET['district']) ? $_GET['district'] : '';
    $camp_area = isset($_GET['camp_area']) ? $_GET['camp_area'] : '';
    $camp_date = isset($_GET['camp_date']) ? $_GET['camp_date'] : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register for Blood Donation Camp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #d9534f;
            margin-bottom: 20px;
        }
        form {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input[type="text"], select {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #d9534f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px 0 0 0;
            width: 100%;
        }
        button:hover {
            background-color: #c9302c;
        }
        .disabled-input {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <h1>Register for Blood Donation Camp</h1>
    <form id="registrationForm" action="venueregister.php" method="POST">
        <input type="hidden" name="district" value="<?php echo htmlspecialchars($district); ?>">
        <input type="hidden" name="camp_area" value="<?php echo htmlspecialchars($camp_area); ?>">
        <input type="hidden" name="camp_date" value="<?php echo htmlspecialchars($camp_date); ?>">

        <label for="district">District:</label>
        <input type="text" id="district" value="<?php echo htmlspecialchars($district); ?>" class="disabled-input" disabled><br>

        <label for="camp_area">Camp Area:</label>
        <input type="text" id="camp_area" value="<?php echo htmlspecialchars($camp_area); ?>" class="disabled-input" disabled><br>

        <label for="camp_date">Camp Date:</label>
        <input type="text" id="camp_date" value="<?php echo htmlspecialchars($camp_date); ?>" class="disabled-input" disabled><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required><br>

        <label for="blood_group">Blood Group:</label>
        <select id="blood_group" name="blood_group" required>
            <option value="">Select</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select><br>

        <button type="submit">Submit</button>
        <a class="btn" href="index.php">Logout</a>
    </form>
</body>
</html>
