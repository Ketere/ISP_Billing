<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    deleteClient($id);

    // Redirect back to the main page or display a success message
    header('Location: index.php');
    exit;
}
?>
