<?php
// login_process.php
session_start();

// Database connection
include 'db_connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare a select statement
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit;
        } else {
            header('Location: login.php?error=1');
            exit;
        }
    }
} else {
    header('Location: login.php?error=1');
    exit;
}

$stmt->close();
$conn->close();
?>
