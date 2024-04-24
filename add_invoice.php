<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'functions.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Attempt to add the client
    $result = addClient($name, $email, $phone, $address);

    // Check if the client was added successfully
    if ($result) {
        // Redirect back to the main page or display a success message
        header('Location: index.php');
        exit;
    } else {
        // Handle the error, e.g., display an error message
        echo "Failed to add client. Please try again.";
    }
}
?>
