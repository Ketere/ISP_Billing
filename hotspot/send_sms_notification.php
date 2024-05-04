<?php
require_once 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;

// Fetch Africa's Talking credentials from the database
include 'db_connect.php';
$sql = "SELECT username, apiKey, senderId FROM aft_credentials LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $apiKey = $row['apiKey'];
    $senderId = $row['senderId'];
} else {
    echo "No Africa's Talking credentials found.";
    exit;
}

// Initialize the Africa's Talking SDK
try {
    $AT = new AfricasTalking($username, $apiKey);

    // Get the SMS service
    $sms = $AT->sms();

    // Prepare the SMS message
    $message = $_GET['message'];

    // Prepend the phone number with "+254"
    $phoneNumber = "+254". $_GET['phone'];

    // Send the SMS
    $result = $sms->send([
        'to'      => $phoneNumber,
        'message' => $message,
        'from'    => $senderId
    ]);

    // Print the result
    print_r($result);
} catch (Exception $e) {
    // Catch and handle any exceptions
    echo "Error: ". $e->getMessage();
}
