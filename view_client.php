<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Client Details</h1>

    <div class="client-details">
        <?php
        require 'db_connect.php';

        $id = $_GET['id'];
        $sql = "SELECT * FROM clients WHERE id=$id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $client = $result->fetch_assoc();
            echo "<h2>Client Details</h2>";
            echo "<form action='edit_client_details.php' method='post'>";
            echo "<input type='hidden' name='id' value='$id'>";
            echo "<p>Name: <input type='text' name='name' value='" . $client['name'] . "'></p>";
            echo "<p>Email: <input type='email' name='email' value='" . $client['email'] . "'></p>";
            echo "<p>Phone: <input type='text' name='phone' value='" . $client['phone'] . "'></p>";
            echo "<p>Address: <input type='text' name='address' value='" . $client['address'] . "'></p>";
            echo "<button type='submit'>Update Client Details</button>";
            echo "</form>";

            // Navigation links for different sections
            echo "<div class='client-nav'>";
            echo "<a href='client_summary.php?id=$id'>Summary</a> | ";
            echo "<a href='client_invoices.php?id=$id'>Invoices</a>";
            echo "<a href='create_order_form.php?id=$id'>Manage Products</a>";
            echo "</div>";
        } else {
            echo "Client not found.";
        }
        ?>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
