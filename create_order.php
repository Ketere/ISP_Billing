<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php'; // Include the database connection file

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_POST['clientId'];
    $packageId = $_POST['packageId'];

    // Validate input (e.g., check if clientId and packageId are not empty)
    if (empty($clientId) || empty($packageId)) {
        die("Client ID or Package ID is missing.");
    }

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

    $subtotal = $package['amount']; // Use the amount for the package price

    // Insert the order
    $stmt = $conn->prepare("INSERT INTO orders (client_id, package_id, subtotal, status) VALUES (?, ?, ?, 'unpaid')");
    $stmt->bind_param("iid", $clientId, $packageId, $subtotal);
    $stmt->execute();

    // Check if the order was inserted successfully
    if ($stmt->affected_rows === 0) {
        die("Failed to create order.");
    }

    // Redirect to a success page or back to the client details page
    header("Location: view_client.php?id=$clientId");
    exit;
}
?>
