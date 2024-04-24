<?php
// Include your database connection script
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $area = $_POST['area'];

    // Prepare an SQL statement
    $sql = "INSERT INTO packages (name, description, price, area) VALUES (?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssd", $name, $description, $price, $area);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New package added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Package</title>
</head>
<body>
    <h2>Add New Package</h2>
    <form action="add_package.php" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" step="0.01" required><br>
        <label for="area">Area:</label><br>
        <input type="text" id="area" name="area" required><br>
        <input type="submit" value="Add Package">
    </form>
</body>
</html>
