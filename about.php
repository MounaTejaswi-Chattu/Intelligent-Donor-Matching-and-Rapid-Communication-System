<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Helping Hand</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="signin.php">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="about">
            <h2>Our Mission</h2>
            <p>We are dedicated to saving lives by providing a safe and reliable blood supply. Our mission is to encourage voluntary blood donation and raise awareness about the importance of blood donation.</p>
            <?php
                // Example dynamic content: Display a motivational quote
                $quotes = [
                    "The blood you donate gives someone another chance at life.",
                    "To the world you may be one person, but to one person you may be the world.",
                    "The gift of blood is the gift of life.",
                    "Donating blood is a small act of kindness that can make a big difference."
                ];
                $random_quote = $quotes[array_rand($quotes)];
                echo "<p><em>$random_quote</em></p>";
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Helping Hand Blood Donation. All rights reserved.</p>
    </footer>
</body>
</html>
