<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotspot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch packages from the database
$packageQuery = "SELECT * FROM packages";
$packageResult = $conn->query($packageQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Hotspot</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to Student Hotspot</h1>
    </header>
    <section id="login">
        <h2>Login</h2>
        <div id="account-login">
            <h3>Account Login</h3>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
        </div>
        <div id="voucher-login">
            <h3>Voucher Login</h3>
            <form action="voucher_login.php" method="post">
                <input type="text" name="voucher_code" placeholder="Voucher Code">
                <button type="submit">Login</button>
            </form>
        </div>
    </section>
    <section id="packages">
        <h2>Choose Your Package</h2>
        <?php
        if ($packageResult->num_rows > 0) {
            // Output data of each package
            while($package = $packageResult->fetch_assoc()) {
                echo "<div class='package'>";
                echo "<h3>" . $package["name"] . "</h3>";
                echo "<p>" . $package["description"] . "</p>";
                echo "<p>Price: " . $package["price"] . "</p>";
                echo "<p>Area: " . $package["area"] . "</p>";
                echo "<form action='purchase.php' method='post'>";
                echo "<input type='hidden' name='package_id' value='" . $package["id"] . "'>";
                echo "<button type='submit'>Purchase</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No packages available.</p>";
        }
        ?>
    </section>
<!--    <footer>
        <p>&copy; 2024 Student Hotspot. All rights reserved.</p>
    </footer>
    -->
</body>
</html>
