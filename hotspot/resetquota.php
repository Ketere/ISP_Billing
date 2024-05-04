<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
include 'db_connect.php';

function resetDailyQuotas() {
    global $conn;
    $today = date('Y-m-d');

    // Reset usage for all accounts
    $sql = "UPDATE daily_usage SET usage = 0 WHERE date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $today);
    $stmt->execute();

    $stmt->close();
}
?>
