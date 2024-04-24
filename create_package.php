<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New Package</h2>
        <form action="add_package.php" method="post">
            <div class="form-group">
                <label for="packageName">Package Name:</label>
                <input type="text" id="packageName" name="packageName" required>
            </div>
            <div class="form-group">
                <label for="speedLimit">Speed Limit (Mbps):</label>
                <input type="number" id="speedLimit" name="speedLimit" required>
            </div>
            <div class="form-group">
                <label for="dataLimit">Data Limit (GB):</label>
                <input type="number" id="dataLimit" name="dataLimit" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" step="0.01" id="amount" name="amount" required>
            </div>
            <button type="submit">Create Package</button>
        </form>
    </div>
</body>
</html>
