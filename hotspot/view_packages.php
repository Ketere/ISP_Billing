<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
// Include your database connection script
include 'db_connect.php';
include 'navbar.php';
// Prepare an SQL statement
$sql = "SELECT id, name, description, price, area FROM packages";

// Execute the statement
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Start the table
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Area</th><th>Actions</th></tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["area"] . "</td>";
        echo "<td>";
        echo "<a href='edit_package.php?id=" . $row["id"] . "'>Edit</a> | ";
        echo "<a href='delete_package.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this package?\")'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }

    // End the table
    echo "</table>";
} else {
    echo "No packages found.";
}

// Close connection
$conn->close();
?>
