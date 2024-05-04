<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

function generateRandomPassword($length = 5) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password.= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parentAccountId = $_POST['parentAccount'];
    $csvFile = $_FILES['csvFile'];

    if ($csvFile['error'] == UPLOAD_ERR_OK) {
        $file = fopen($csvFile['tmp_name'], 'r');
        // Skip the header row
        fgetcsv($file);
        while (($data = fgetcsv($file))!== FALSE) {
            $name = $data[0];
            $phone = $data[1];
            $house_number = $data[2];
            $password = generateRandomPassword(); // Generate a random password of length 5

            $sql = "INSERT INTO sub_accounts (name, phone, house_number, password, master_account_id) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $name, $phone, $house_number, $password, $parentAccountId);

            if ($stmt->execute()) {
                echo "Sub-account added successfully.<br>";

                // Prepare the message content
                $messageContent = "Dear $name, your username is +254$phone and password is $password. Regards, NTN.";

                // Redirect to the SMS sending script with the necessary parameters
                header("Location: send_sms_notification.php?phone=$phone&message=$messageContent");
                exit;
            } else {
                echo "Error adding sub-account: ". $stmt->error. "<br>";
            }

            $stmt->close();
        }
        fclose($file);
    } else {
        echo "Error uploading CSV file.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Sub-Accounts</title>
</head>
<body>
    <h1>Add Sub-Accounts</h1>
    <form action="add_sub_accounts.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="parentAccount" value="<?php echo $_GET['parentAccount']; ?>">
        <label for="csvFile">CSV File:</label>
        <input type="file" id="csvFile" name="csvFile" accept=".csv" required><br>
        <input type="submit" value="Upload CSV">
    </form>
</body>
</html>
