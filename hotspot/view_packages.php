<?php
// Include your database connection script
include 'db_connect.php';

// Prepare an SQL statement
$sql = "SELECT id, name, description, price, area FROM packages";

// Execute the statement
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Description: " . $row["description"]. " - Price: " . $row["price"]. " - Area: " . $row["area"]. "<br>";
    }
} else {
    echo "No packages found.";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Packages</title>
</head>
<body>
    <h2>Packages</h2>
    <?php include 'view_packages.php'; ?>
</body>
</html>
