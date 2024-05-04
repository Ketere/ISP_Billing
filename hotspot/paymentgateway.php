session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
include 'navbar.php';

<form action="save_mpesa_details.php" method="POST">
    <label for="consumerKey">M-PESA Consumer Key:</label>
    <input type="text" id="consumerKey" name="consumerKey" required>
    
    <label for="consumerSecret">M-PESA Consumer Secret:</label>
    <input type="text" id="consumerSecret" name="consumerSecret" required>
    
    <label for="businessShortCode">M-PESA Business Shortcode:</label>
    <input type="text" id="businessShortCode" name="businessShortCode" required>
    
    <label for="passKey">M-PESA Passkey:</label>
    <input type="text" id="passKey" name="passKey" required>
    
    <button type="submit">Save Details</button>
</form>
