<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
include 'db_connect.php';

function checkAndUpdateQuota($account_id, $usage) {
    global $conn;
    $today = date('Y-m-d');

    // Check if there's an entry for today
    $sql = "SELECT * FROM daily_usage WHERE account_id = ? AND date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $account_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentUsage = $row['usage'];
        $newUsage = $currentUsage + $usage;

        // Check if the new usage exceeds the daily quota
        $sql = "SELECT daily_quota FROM sub_accounts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $dailyQuota = $row['daily_quota'];

        if ($newUsage > $dailyQuota) {
            return false; // Quota exceeded
        } else {
            // Update the usage
            $sql = "UPDATE daily_usage SET usage = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $newUsage, $row['id']);
            $stmt->execute();
            return true; // Quota not exceeded
        }
    } else {
        // Insert a new entry for today
        $sql = "INSERT INTO daily_usage (account_id, date, usage) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $account_id, $today, $usage);
        $stmt->execute();
        return true; // Quota not exceeded
    }

    $stmt->close();
}
?>
