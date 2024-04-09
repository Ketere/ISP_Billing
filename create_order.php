<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php'; // Ensure you have a db_connect.php file for database connection
require 'functions.php'; // Ensure you have a functions.php file with your custom functions

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_POST['clientId'];
    $packageId = $_POST['packageId'];
    $pppoeName = $_POST['pppoeName'];
    $pppoePassword = generatePassword(); // Assuming you have a function to generate a password

    // Fetch package details to calculate subtotal
    $stmt = $conn->prepare("SELECT * FROM packages WHERE package_id = ?");
    $stmt->bind_param("i", $packageId);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();

    // Check if the package was found and has an amount
    if (empty($package) || !isset($package['amount'])) {
        die("Package not found or amount is missing.");
    }

    $subtotal = $package['amount']; // Correctly using 'amount' for the package price

    // Insert the order and invoice
    $stmt = $conn->prepare("INSERT INTO orders (client_id, package_id, subtotal, status) VALUES (?, ?, ?, 'unpaid')");
    $stmt->bind_param("iid", $clientId, $packageId, $subtotal);
    $stmt->execute();
    $orderId = $conn->insert_id;

    // Insert PPPoE credentials
    $stmt = $conn->prepare("INSERT INTO pppoe_credentials (client_id, package_id, pppoe_name, pppoe_password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $clientId, $packageId, $pppoeName, $pppoePassword);
    $stmt->execute();

    // Redirect to view_client.php or a success page
    header("Location: view_client.php?id=$clientId");
    exit;
}
?>
