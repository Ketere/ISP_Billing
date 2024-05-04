<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
// Include your database connection script
include 'db_connect.php';
include 'navbar.php';

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
        <label for="nas_id">NAS Identifier:</label><br>
        <select id="nas_id" name="nas_id" required>
            <!-- Populate this dropdown with NAS IDs from your NAS table -->
            <option value="1">Daystar</option>
            <option value="2">NAS 2</option>
            <!-- Add more options as needed -->
        </select><br>

        <input type="submit" value="Add Package">
    </form>
</body>

</html>