<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Clients</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>View Clients</h1>

    <div class="form-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
            </tr>
            <?php
            require 'db_connect.php';

            $sql = "SELECT * FROM clients";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td><a href='view_client.php?id=" . $row['id'] . "'>" . $row['name'] . "</a></td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No clients found.</td></tr>";
            }
            ?>
        </table>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
