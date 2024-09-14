<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <main>
        <section>
            <h2>Donor Login</h2>
            <form action="login.php" method="post">
                <input type="hidden" name="user_type" value="donor">
                <label for="donor-username">Username:</label>
                <input type="text" id="donor-username" name="username" required>
                <label for="donor-password">Password:</label>
                <input type="password" id="donor-password" name="password" required>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="donor-register.php">Register here</a></p>
        </section>
           <section>
            <h2>Admin Login</h2>
            <form action="admin-login.php" method="post">
                <input type="hidden" name="user_type" value="admin">
                <label for="admin-username">Username:</label>
                <input type="text" id="admin-username" name="username" required>
                <label for="admin-password">Password:</label>
                <input type="password" id="admin-password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </section>
    </main>

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
            die("Connection failed: " . $conn->connect_error);
        }

        $user_type = $_POST['user_type'];
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];

        if ($user_type == "donor") {
            $stmt = $conn->prepare("SELECT password FROM donors WHERE name = ?");
        } else {
            $stmt = $conn->prepare("SELECT password FROM admin2 WHERE name = ?");
        }
        $stmt->bind_param("s", $input_username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hash);
            $stmt->fetch();

            if (password_verify($input_password, $hash)) {
                echo "<p>Login successful!</p>";
                // Set session and redirect to the appropriate dashboard
                $_SESSION['username'] = $input_username;
                if ($user_type == "donor") {
                    // header("Location: donor_dashboard.php");
                } else {
                    // header("Location: admin_dashboard.php");
                }
                exit();
            } else {
                echo "<p>Invalid password.</p>";
            }
        } else {
            echo "<p>No user found with that username.</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
