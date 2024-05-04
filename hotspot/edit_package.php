<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
include 'db_connect.php';
include 'navbar.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $area = $_POST['area'];

    // Prepare an SQL statement
    $sql = "UPDATE packages SET name = ?, description = ?, price = ?, area = ? WHERE id = ?";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssdsi", $name, $description, $price, $area, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Package updated successfully.";
    } else {
        echo "Error updating package: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Fetch the package details
$id = $_GET['id'];
$sql = "SELECT * FROM packages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$package = $result->fetch_assoc();

// Close statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Package</title>
</head>
<body>
    <h2>Edit Package</h2>
    <form action="edit_package.php" method="post">
        <input type="hidden" name="id" value="<?php echo $package['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $package['name']; ?>" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $package['description']; ?></textarea><br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo $package['price']; ?>" step="0.01" required><br>
        <label for="area">Area:</label>
        <input type="text" id="area" name="area" value="<?php echo $package['area']; ?>" required><br>
        <input type="submit" value="Update Package">
    </form>
</body>
</html>
