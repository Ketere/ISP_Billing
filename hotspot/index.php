<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'db_connect.php';
include 'navbar.php';

// Fetch data for all time
$sql_all_time = "SELECT SUM(amount) AS total_all_time FROM transactions";
$result_all_time = $conn->query($sql_all_time);

// Initialize variable to hold the fetched data
$total_all_time = 0;

// Check if there are any rows returned and fetch the data
if ($result_all_time->num_rows > 0) {
    $row_all_time = $result_all_time->fetch_assoc();
    $total_all_time = $row_all_time['total_all_time'];
} else {
    $total_all_time = 0; // Default to 0 if no transactions found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <style>
      body {
          background-image: url('path/to/your/background/image.jpg'); /* Replace with your image path */
          background-size: cover;
          background-position: center;
      }
     .card-container {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 80vh; /* Adjust as needed */
      }
     .card {
          width: 90%; /* Adjust as needed */
          max-width: 500px; /* Adjust as needed */
          margin: auto;
          padding: 20px;
          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-container">
                    <div class="card">
                        <div class="chart-container">
                            <canvas id="totalTransactionsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('totalTransactionsChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Transactions'],
                datasets: [{
                    label: 'Total Amount',
                    data: [<?php echo $total_all_time;?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
