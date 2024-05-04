<?php
// Ensure the Composer autoloader is included at the very beginning of your script
require_once 'vendor/autoload.php';

// Use the correct namespace for the Africa's Talking SDK
use AfricasTalking\SDK\AfricasTalking;

// Your API credentials
$username = 'sandbox'; // Use 'sandbox' for development in the test environment
$apiKey   = 'c4b94089af18787af7b80d145618328fa45223485eabefeed8a3168e1c508175'; // Use your sandbox app API key for development in the test environment

// Initialize the Africa's Talking SDK
try {
    $AT = new AfricasTalking($username, $apiKey);

    // Get the SMS service
    $sms = $AT->sms();

    // Prepare the SMS message
    $message = [
        'to'      => '+254720698866', // Recipient's phone number
        'message' => 'Hello!' // Your message
    ];

    // Send the SMS
    $result = $sms->send($message);

    // Print the result
    print_r($result);
} catch (Exception $e) {
    // Catch and handle any exceptions
    echo "Error: ". $e->getMessage();
}
