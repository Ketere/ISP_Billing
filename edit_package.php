<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $packageName = $_POST['packageName'];
    $speedLimit = $_POST['speedLimit'];
    $dataLimit = $_POST['dataLimit'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("UPDATE packages SET package_name = ?, speed_limit = ?, data_limit = ?, amount = ? WHERE id = ?");
    $stmt->bind_param("siddi", $packageName, $speedLimit, $dataLimit, $amount, $id);
    $stmt->execute();

    header("Location: list_packages.php");
    exit;
} else {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Package</h2>
        <form action="edit_package.php" method="post">
            <input type="hidden" name="id" value="<?= $package['id'] ?>">
            <div class="form-group">
                <label for="packageName">Package Name:</label>
                <input type="text" id="packageName" name="packageName" value="<?= $package['package_name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="speedLimit">Speed Limit (Mbps):</label>
                <input type="number" id="speedLimit" name="speedLimit" value="<?= $package['speed_limit'] ?>" required>
            </div>
            <div class="form-group">
                <label for="dataLimit">Data Limit (GB):</label>
                <input type="number" id="dataLimit" name="dataLimit" value="<?= $package['data_limit'] ?>" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" step="0.01" id="amount" name="amount" value="<?= $package['amount'] ?>" required>
            </div>
            <button type="submit">Update Package</button>
        </form>
    </div>
</body>
</html>
