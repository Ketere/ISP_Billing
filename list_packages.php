<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Packages List</h2>
        <a href="create_package.php">Add New Package</a>
        <table>
            <tr>
                <th>Package Name</th>
                <th>Speed Limit (Mbps)</th>
                <th>Data Limit (GB)</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
            <?php
            require 'db_connect.php';
            $result = $conn->query("SELECT * FROM packages");
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['package_name'] ?></td>
                    <td><?= $row['speed_limit'] ?></td>
                    <td><?= $row['data_limit'] ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td>
                        <a href="edit_package.php?id=<?= $row['id'] ?>">Edit</a> | 
                        <a href="delete_package.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
