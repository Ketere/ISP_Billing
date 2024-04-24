<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_POST['clientId'];
    $productName = $_POST['productName'];

    // Insert the new product
    $stmt = $conn->prepare("INSERT INTO products (client_id, product_name) VALUES (?, ?)");
    $stmt->bind_param("is", $clientId, $productName);
    $stmt->execute();

    // Redirect to manage_products.php
    header("Location: manage_products.php?id=$clientId");
    exit;
}
?>
