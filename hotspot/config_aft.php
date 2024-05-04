<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $apiKey = $_POST['apiKey'];
    $senderId = $_POST['senderId']; // New field for sender ID

    // Store the credentials in the database or a configuration file
    // For demonstration, we'll store them in the database
    $sql = "INSERT INTO aft_credentials (username, apiKey, senderId) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $apiKey, $senderId); // Bind the new senderId parameter

    if ($stmt->execute()) {
        echo "Africa's Talking credentials saved successfully.";
    } else {
        echo "Error saving Africa's Talking credentials: ". $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Configure Africa's Talking</title>
</head>
<body>
    <h1>Configure Africa's Talking</h1>
    <form action="config_aft.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="apiKey">API Key:</label>
        <input type="password" id="apiKey" name="apiKey" required><br>
        <label for="senderId">Sender ID:</label>
        <input type="text" id="senderId" name="senderId" required><br>
        <input type="submit" value="Save">
    </form>
</body>
</html>
