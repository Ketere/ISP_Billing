<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add client</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>ISP Billing System</h1>

    <!-- Client Management -->
    <div class="form-container">
        <h2>Client Management</h2>
        <form action="add_client.php" method="post">
            <div class="form-group">
                <label for="clientName">Name:</label>
                <input type="text" id="clientName" name="name" required>
            </div>
            <div class="form-group">
                <label for="clientEmail">Email:</label>
                <input type="email" id="clientEmail" name="email" required>
            </div>
            <div class="form-group">
                <label for="clientPhone">Phone:</label>
                <input type="text" id="clientPhone" name="phone">
            </div>
            <div class="form-group">
                <label for="clientAddress">Address:</label>
                <input type="text" id="clientAddress" name="address">
            </div>
            <button type="submit">Add Client</button>
        </form>
    </div>

    <!-- Add more sections for invoices and PPPoE credentials -->

    <script src="scripts.js"></script>
</body>
</html>
