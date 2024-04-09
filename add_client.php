<?php
require 'db_connect.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO clients (name, email, phone, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $address);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the ID of the last inserted row
        $clientId = $conn->insert_id;
        // Redirect to view_client.php with the client ID
        header("Location: view_client.php?id=$clientId");
        exit;
    } else {
        echo "Error adding client.";
    }
}
?>
