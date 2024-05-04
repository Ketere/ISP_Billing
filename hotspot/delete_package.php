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

    // Prepare an SQL statement
    $sql = "DELETE FROM packages WHERE id = ?";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Package deleted successfully.";
    } else {
        echo "Error deleting package: " . $stmt->error;
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
    <title>Delete Package</title>
</head>
<body>
    <h2>Delete Package</h2>
    <p>Are you sure you want to delete the package: <?php echo $package['name']; ?>?</p>
    <form action="delete_package.php" method="post">
        <input type="hidden" name="id" value="<?php echo $package['id']; ?>">
        <input type="submit" value="Yes, Delete">
    </form>
</body>
</html>
