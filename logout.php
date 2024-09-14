<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .success-message {
            font-size: 18px;
            color: green;
        }
        .error-message {
            font-size: 18px;
            color: red;
        }
        .logout-button {
            background-color: #d9534f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .logout-button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registration Status</h1>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="success-message">
                <p>Registration successful! Thank you for your contribution.</p>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error' && isset($_GET['message'])): ?>
            <div class="error-message">
                <p>Error: <?php echo htmlspecialchars($_GET['message']); ?></p>
            </div>
        <?php endif; ?>
        <button class="logout-button" onclick="window.location.href='index.php'">Logout</button>
    </div>
</body>
</html>
