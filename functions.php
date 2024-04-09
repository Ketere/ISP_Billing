<?php
require 'db_connect.php';

// Function to add a new client
function addClient($name, $email, $phone, $address) {
    global $conn;
    $sql = "INSERT INTO clients (name, email, phone, address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $address);
    $stmt->execute();
    $stmt->close();
}

// Function to edit an existing client
function editClient($id, $name, $email, $phone, $address) {
    global $conn;
    $sql = "UPDATE clients SET name=?, email=?, phone=?, address=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
    $stmt->execute();
    $stmt->close();
}

// Function to delete a client
function deleteClient($id) {
    global $conn;
    $sql = "DELETE FROM clients WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

//funtion to generate pppoe password
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-={}[]|?/';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}
// Add similar functions for managing invoices and PPPoE credentials
?>
