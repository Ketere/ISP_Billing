<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $is_master = isset($_POST['is_master']) ? 1 : 0;
    $master_account_id = isset($_POST['master_account_id']) ? $_POST['master_account_id'] : NULL;
    $daily_quota = $_POST['daily_quota'] ?? 0;

    $sql = "INSERT INTO accounts (username, password, email, is_master, master_account_id, daily_quota) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiss", $username, $password, $email, $is_master, $master_account_id, $daily_quota);

    if ($stmt->execute()) {
        echo "Account created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
