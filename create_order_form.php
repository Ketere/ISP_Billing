<?php
require 'db_connect.php'; // Ensure you have a db_connect.php file for database connection

// Fetch packages for the dropdown
$sql = "SELECT package_id, package_name, amount FROM packages";
$result = $conn->query($sql);
$packages = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .form-container {
            width: 80%;
            max-width: 500px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="create_order.php" method="post">
            <input type="hidden" name="clientId" value="CLIENT_ID_HERE">
            <div class="form-group">
                <label for="packageId">Select Package:</label>
                <select name="packageId" id="packageId">
                    <?php foreach ($packages as $package): ?>
                        <option value="<?= $package['id'] ?>"><?= $package['package_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="pppoeName">PPPoE Name:</label>
                <input type="text" name="pppoeName" id="pppoeName" required>
            </div>
            <button type="submit">Create Order</button>
        </form>
    </div>
</body>
</html>
