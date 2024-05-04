<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
include 'db_connect.php';

if (isset($_POST['accountId'])) {
    $accountId = $_POST['accountId'];

    $sql = "SELECT name, phone, password FROM sub_accounts WHERE master_account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $accountId);
    $stmt->execute();
    $result = $stmt->get_result();

    $subaccounts = array();
    while ($row = $result->fetch_assoc()) {
        $subaccounts[] = $row;
    }

    echo json_encode($subaccounts);
}
?>
