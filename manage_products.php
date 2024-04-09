<?php
require 'db_connect.php';

$clientId = $_GET['id'];

// Fetch products for the client
$sql = "SELECT * FROM products WHERE client_id = $clientId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display products
    while($row = $result->fetch_assoc()) {
        echo $row['product_name'] . "<br>";
    }
} else {
    // No products found, provide option to add a new product
    echo "<a href='add_product.php?id=$clientId'>Add New Product</a>";
}
?>
