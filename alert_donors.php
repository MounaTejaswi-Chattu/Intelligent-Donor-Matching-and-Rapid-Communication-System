<?php
include 'config.php';


$blood_groups = $conn->query("SELECT DISTINCT blood_group FROM donors");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../stylesalert.css">
    <title>Send Alerts</title>
</head>
<body>
    <div class="container">
        <h1>Send WhatsApp Alerts to Donors</h1>
        <form action="send_whatsapp.php" method="post">
            <label for="blood_group">Select Blood Group:</label>
            <select id="blood_group" name="blood_group" required>
                <?php while ($row = $blood_groups->fetch_assoc()): ?>
                    <option value="<?= $row['blood_group'] ?>"><?= $row['blood_group'] ?></option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <button type="submit" class="btn">Send Alerts</button>
        </form>
    </div>
</body>
</html>
