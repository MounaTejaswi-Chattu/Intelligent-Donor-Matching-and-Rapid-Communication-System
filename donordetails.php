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
    </style>
</head>
<body>
    <h1>Entering the donated details of the donor</h1>
    <form id="registrationForm" action="ddex.php" method="POST">
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

        <label for="district">District:</label>
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

        <label for="camp_area">Camp Area:</label>
        <input type="text" id="camp_area" name="camp_area" required><br>

        <label for="camp_date">Camp Date:</label>
        <input type="text" id="camp_date" name="camp_date" required><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
