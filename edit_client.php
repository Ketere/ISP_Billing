<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    editClient($id, $name, $email, $phone, $address);

    // Redirect back to the main page or display a success message
    header('Location: index.php');
    exit;
}
?>
