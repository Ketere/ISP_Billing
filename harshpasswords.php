<?php
require 'db_connect.php';

$sql = "SELECT user_id, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $hashedPassword = password_hash($row['password'], PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("si", $hashedPassword, $row['user_id']);
        $stmt->execute();
    }
    echo "Passwords updated to hashed values.";
} else {
    echo "No users found.";
}
?>
