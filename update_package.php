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

    echo "Package updated successfully.";
}
?>
