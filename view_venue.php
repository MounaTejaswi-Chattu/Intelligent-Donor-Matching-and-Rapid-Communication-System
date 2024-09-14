<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Donation Camp Venues</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
            position: relative;
        }
        h1 {
            text-align: center;
            color: #d9534f;
        }
        .logout-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .logout-container form {
            display: inline;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            font-weight: bold;
            margin-right: 10px;
        }
        select, button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #d9534f;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #c9302c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #d9534f;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .register-button {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>Blood Donation Camp Venues</h1>
    <form method="post">
        <label for="district">Select District:</label>
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
        <button type="submit" name="view_venue">View Venues</button>
        <a class="btn" href="index.php">Logout</a>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>District</th>
                <th>Camp Area</th>
                <th>Camp Date</th>
                <th>Camp Time From</th>
                <th>Camp Time To</th>
                <th>Register</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_POST['view_venue'])) {
                $selected_district = $_POST['district'];

                // Include database configuration file
                include 'config.php';

                // Get current date and time
                $current_date = date('Y-m-d');
                $current_time = date('H:i:s');

                // Fetch data from the database excluding past events
                if ($selected_district == 'Select' || $selected_district == '') {
                    $sql = "SELECT * FROM camp_details WHERE (camp_date > CURDATE()) OR (camp_date = CURDATE() AND camp_time_to > CURTIME())";
                } else {
                    $sql = "SELECT * FROM camp_details WHERE district = ? AND ((camp_date > CURDATE()) OR (camp_date = CURDATE() AND camp_time_to > CURTIME()))";
                }

                if ($stmt = $conn->prepare($sql)) {
                    if ($selected_district != 'Select' && $selected_district != '') {
                        $stmt->bind_param("s", $selected_district);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['district']}</td>";
                            echo "<td>{$row['camp_area']}</td>";
                            echo "<td>{$row['camp_date']}</td>";
                            echo "<td>{$row['camp_time_from']}</td>";
                            echo "<td>{$row['camp_time_to']}</td>";
                            echo "<td>
                                <form action='eligibility.php' method='POST'>
                                    <input type='hidden' name='district' value='{$row['district']}'>
                                    <input type='hidden' name='camp_area' value='{$row['camp_area']}'>
                                    <input type='hidden' name='camp_date' value='{$row['camp_date']}'>
                                    <button type='submit' class='register-button'>Register</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    $stmt->close();
                }
                $conn->close();
            }
            ?>
        </tbody>
    </table>
</body>
</html>
