<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $packageName = $_POST['packageName'];
    $speedLimit = $_POST['speedLimit'];
    $dataLimit = $_POST['dataLimit'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("INSERT INTO packages (package_name, speed_limit, data_limit, amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sidd", $packageName, $speedLimit, $dataLimit, $amount);
    $stmt->execute();

    header("Location: list_packages.php");
    exit;
}
?>
