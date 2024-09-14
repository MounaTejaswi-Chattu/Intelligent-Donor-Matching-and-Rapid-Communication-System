<?php
// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $district = $_POST['district'];
    $camp_area = $_POST['camp_area'];
    $camp_date = $_POST['camp_date'];
}

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin-login.php");
    exit;
}

// Database connection settings
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

// Initialize variables
$eligibilityMessage = "";
$isEligible = true; // Variable to check eligibility based on previous donation date

// Fetch last donation date for the logged-in donor
$loggedInDonorName = $_SESSION['username']; // Assuming the donor's name is stored in the session
$sql = "SELECT camp_date FROM donorsdetails WHERE name = ? ORDER BY camp_date DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInDonorName);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    $eligibilityMessage = "Error in SQL query: " . $conn->error;
} elseif ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastDonationDate = $row['camp_date'];
    $currentDate = new DateTime();
    $lastDonationDate = new DateTime($lastDonationDate);
    $interval = $lastDonationDate->diff($currentDate);

    // Check if the interval is less than 3 months (90 days)
    $daysInMonth = 30;
    $totalDays = ($interval->y * 12 + $interval->m) * $daysInMonth + $interval->d;
    $remainingDays = 180 - $totalDays;
    
    if ($remainingDays > 0) {
        $remainingMonths = intdiv($remainingDays, $daysInMonth);
        $remainingExtraDays = $remainingDays % $daysInMonth;
    
        $eligibilityMessage = "You are not eligible to donate blood because you donated blood $interval->m months and $interval->d days ago. You need to wait for another $remainingMonths months and $remainingExtraDays days.";
        $isEligible = false;
    } else {
        $eligibilityMessage = "You are eligible to donate blood.";
    }
    
} else {
    $eligibilityMessage = "You have not donated blood yet. You are eligible to donate blood.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
    $weight = isset($_POST['weight']) ? intval($_POST['weight']) : 0;
    $hemoglobin = isset($_POST['hemoglobin']) ? floatval($_POST['hemoglobin']) : 0;
    $alcohol = isset($_POST['alcohol']) ? $_POST['alcohol'] : '';
    $antibiotics = isset($_POST['antibiotics']) ? $_POST['antibiotics'] : '';
    $heartCondition = isset($_POST['heartCondition']) ? $_POST['heartCondition'] : '';
    $bloodPressure = isset($_POST['bloodPressure']) ? intval($_POST['bloodPressure']) : 0;
    $surgery = isset($_POST['surgery']) ? $_POST['surgery'] : '';
    $pregnant = isset($_POST['pregnant']) ? $_POST['pregnant'] : '';
    $tattoo = isset($_POST['tattoo']) ? $_POST['tattoo'] : '';
    $cancer = isset($_POST['cancer']) ? $_POST['cancer'] : '';
    $rested = isset($_POST['rested']) ? $_POST['rested'] : '';
    $donationInterval = isset($_POST['donationInterval']) ? $_POST['donationInterval'] : '';

    // Check eligibility criteria
    if ($age >= 18 && $age <= 65 &&
        $weight >= 50 &&
        $hemoglobin >= 12.5 && $hemoglobin <= 13.5 &&
        $alcohol == 'no' &&
        $antibiotics == 'no' &&
        $heartCondition == 'no' &&
        $bloodPressure >= 90 && $bloodPressure <= 180 &&
        $surgery == 'no' &&
        $pregnant == 'no' &&
        $tattoo == 'no' &&
        $cancer == 'no' &&
        $rested == 'yes' &&
        $donationInterval == 'no' &&
        $isEligible) {
        // Redirect to the registration page with parameters
        header("Location: submit_registration.php?district=" . urlencode($_POST['district']) . "&camp_area=" . urlencode($_POST['camp_area']) . "&camp_date=" . urlencode($_POST['camp_date']));
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Eligibility Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(''); /* Add background image URL if needed */
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
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        .btn-back {
            background-color: #007bff;
        }
        .btn-primary {
            background-color: #28a745;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .rules {
            margin-bottom: 20px;
        }
        .rule {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        form {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="radio"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group input[type="radio"] {
            width: auto;
        }
        .form-group .radio-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .message {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            color: #fff;
            margin-top: 20px;
        }
        .eligible {
            background-color: #28a745;
        }
        .not-eligible {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Blood Donation Eligibility Test</h1>
    <p>Please answer the following questions:</p>
    <?php if ($eligibilityMessage) { ?>
        <div class="message <?php echo $isEligible ? 'eligible' : 'not-eligible'; ?>"><?php echo $eligibilityMessage; ?></div>
    <?php } ?>
    <form method="POST">
        <input type="hidden" id="district" name="district" value="<?php echo htmlspecialchars($district); ?>"><br>
        <input type="hidden" id="camp_area" name="camp_area" value="<?php echo htmlspecialchars($camp_area); ?>"><br>
        <input type="hidden" id="camp_date" name="camp_date" value="<?php echo htmlspecialchars($camp_date); ?>"><br>
        
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required <?php echo $isEligible ? '' : 'disabled'; ?>>
        </div>
        <div class="form-group">
            <label for="weight">Weight (in kg):</label>
            <input type="number" id="weight" name="weight" required <?php echo $isEligible ? '' : 'disabled'; ?>>
        </div>
        <div class="form-group">
            <label for="hemoglobin">Hemoglobin Level:</label>
            <input type="number" step="0.1" id="hemoglobin" name="hemoglobin" required <?php echo $isEligible ? '' : 'disabled'; ?>>
        </div>
        <div class="form-group">
            <label>Do you consume alcohol?</label>
            <div class="radio-group">
                <input type="radio" id="alcohol_yes" name="alcohol" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="alcohol_yes">Yes</label>
                <input type="radio" id="alcohol_no" name="alcohol" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="alcohol_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label>Are you currently taking antibiotics?</label>
            <div class="radio-group">
                <input type="radio" id="antibiotics_yes" name="antibiotics" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="antibiotics_yes">Yes</label>
                <input type="radio" id="antibiotics_no" name="antibiotics" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="antibiotics_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label>Do you have a heart condition?</label>
            <div class="radio-group">
                <input type="radio" id="heartCondition_yes" name="heartCondition" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="heartCondition_yes">Yes</label>
                <input type="radio" id="heartCondition_no" name="heartCondition" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="heartCondition_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label for="bloodPressure">Blood Pressure:</label>
            <input type="number" id="bloodPressure" name="bloodPressure" required <?php echo $isEligible ? '' : 'disabled'; ?>>
        </div>
        <div class="form-group">
            <label>Have you had surgery in the last 6 months?</label>
            <div class="radio-group">
                <input type="radio" id="surgery_yes" name="surgery" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="surgery_yes">Yes</label>
                <input type="radio" id="surgery_no" name="surgery" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="surgery_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label>Are you pregnant?</label>
            <div class="radio-group">
                <input type="radio" id="pregnant_yes" name="pregnant" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="pregnant_yes">Yes</label>
                <input type="radio" id="pregnant_no" name="pregnant" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="pregnant_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label>Have you had a tattoo in the last 6 months?</label>
            <div class="radio-group">
                <input type="radio" id="tattoo_yes" name="tattoo" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="tattoo_yes">Yes</label>
                <input type="radio" id="tattoo_no" name="tattoo" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="tattoo_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label>Do you have a history of cancer?</label>
            <div class="radio-group">
                <input type="radio" id="cancer_yes" name="cancer" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="cancer_yes">Yes</label>
                <input type="radio" id="cancer_no" name="cancer" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="cancer_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label>Have you had adequate rest?</label>
            <div class="radio-group">
                <input type="radio" id="rested_yes" name="rested" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="rested_yes">Yes</label>
                <input type="radio" id="rested_no" name="rested" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="rested_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label>Have you had a blood donation in the last 6 months?</label>
            <div class="radio-group">
                <input type="radio" id="donationInterval_yes" name="donationInterval" value="yes" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="donationInterval_yes">Yes</label>
                <input type="radio" id="donationInterval_no" name="donationInterval" value="no" required <?php echo $isEligible ? '' : 'disabled'; ?>>
                <label for="donationInterval_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" <?php echo $isEligible ? '' : 'disabled'; ?>>Submit</button>
            <a href="donor_dashboard.php" class="btn btn-back">Back to Dashboard</a>
        </div>
    </form>
</div>
</body>
</html>
