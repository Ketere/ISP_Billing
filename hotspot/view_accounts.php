<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
include 'db_connect.php';
include 'navbar.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT id, name, phone, email FROM accounts WHERE id LIKE ? OR name LIKE ? OR phone LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = "%" . $search . "%";
$stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td><button onclick='showSubaccounts(" . $row['id'] . ")'>Show Subaccounts</button> <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addSubaccountModal' data-account-id='" . $row['id'] . "'>Add Subaccount</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No accounts found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Modal for adding subaccounts -->
    <div class="modal fade" id="addSubaccountModal" tabindex="-1" role="dialog" aria-labelledby="addSubaccountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubaccountModalLabel">Add Subaccount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addSubaccountForm" action="add_sub_accounts.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="parentAccount" id="parentAccount">
                        <div class="form-group">
                            <label for="csvFile">CSV File:</label>
                            <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitAddSubaccountForm()">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for displaying subaccounts -->
    <div class="modal fade" id="subaccountsModal" tabindex="-1" role="dialog" aria-labelledby="subaccountsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subaccountsModalLabel">Subaccounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="subaccounts-container">
                    <!-- Subaccounts table will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSubaccounts(accountId) {
            $.ajax({
                url: 'fetch_subaccounts.php',
                type: 'POST',
                data: {
                    accountId: accountId
                },
                success: function(response) {
                    var subaccounts = JSON.parse(response);
                    var subaccountsTable = "<table class='table'><tr><th>Name</th><th>Phone</th><th>Password</th></tr>";
                    $.each(subaccounts, function(index, subaccount) {
                        subaccountsTable += "<tr><td>" + subaccount.name + "</td><td>" + subaccount.phone + "</td><td>" + subaccount.password + "</td></tr>";
                    });
                    subaccountsTable += "</table>";
                    $('#subaccounts-container').html(subaccountsTable);
                    $('#subaccountsModal').modal('show'); // Show the modal with the subaccounts
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error fetching subaccounts:", errorThrown);
                }
            });
        }

        function submitAddSubaccountForm() {
            var formData = new FormData($('#addSubaccountForm')[0]);
            $.ajax({
                url: 'add_sub_accounts.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Display success notification
                    var notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + response + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $('#addSubaccountModal .modal-body').prepend(notification);
                    // Fade out notification after 5 seconds
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 5000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Display error notification
                    var notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error uploading CSV file.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $('#addSubaccountModal .modal-body').prepend(notification);
                    // Fade out notification after 5 seconds
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 5000);
                }
            });
        }

        // Set the parentAccount value when the modal is shown
        $('#addSubaccountModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var accountId = button.data('account-id'); // Extract info from data-* attributes
            $('#parentAccount').val(accountId);
        });
    </script>
</body>

</html>

