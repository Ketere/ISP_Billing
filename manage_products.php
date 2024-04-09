<?php
require 'db_connect.php';

$clientId = $_GET['id'];

// Check if there is an existing package for the client
$sql = "SELECT * FROM orders WHERE client_id = $clientId AND status = 'unpaid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Existing package found, display details
    while($row = $result->fetch_assoc()) {
        echo $row['package_id'] . "<br>";
        // Add more details as needed
    }
} else {
    // No package found, redirect to create a new order
    header("Location: create_order_form.php?id=$clientId");
    exit;
}
?>
