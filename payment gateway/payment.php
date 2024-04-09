<?php

if (isset($_POST['paynow'])) {
    include 'accessToken.php';
    $amount = $_POST["amount"];
    $accountnumber = $_POST['accountnumber'];
    $phone  = $_POST['phone'];
    date_default_timezone_set('Africa/Nairobi');
    $processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $callbackurl = 'https://1c95-105-161-14-223.ngrok-free.app/MPEsa-Daraja-Api/callback.php';
    $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
    $BusinessShortCode = '174379';
    $Timestamp = date('YmdHis');
    // ENCRIPT  DATA TO GET PASSWORD
    $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
    //$phone = $phone; //phone number to receive the stk push
    $money = $amount;
    $PartyA = $phone;
    $PartyB = '254721661608';
    $AccountReference = $accountnumber;
    $TransactionDesc = 'stkpush test';
    $Amount = $money;
    $stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];
    //INITIATE CURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader); //setting custom header
    $curl_post_data = array(
        //Fill in the request parameters with valid values
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $callbackurl,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    echo $curl_response = curl_exec($curl);
    //ECHO  RESPONSE
    $data = json_decode($curl_response);
    $CheckoutRequestID = $data->CheckoutRequestID;
    $ResponseCode = $data->ResponseCode;
    if ($ResponseCode == "0") {
        echo "<script>window.location.href='payment.php?success=Please Enter Your Mpesa Pin To Complete Transaction'</script>";
    }else{
        echo "script>window.location.href='payment.php?error=Please try  again later'<";//redirect to failed page
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="payment-container">
        <h2>Payment Page</h2>
        <form action="#" method="POST">
            <?php
            if(isset($_GET['success'])){
                echo "<p style='color:green'>".$_GET['success']."<p>";
            }elseif(isset($_GET['error'])){
                echo "<p style='color:red'>".$_GET['error']."<p>";
            }
            ?>
            <div class="form-group">
                <label for="phoneNumber">Phone Number:</label>
                <input type="number" id="phoneNumber" name="phone" required>
                <small>Enter your 10-digit phone number</small>
            </div>
            <div class="form-group">
                <label for="account">Account:</label>
                <input type="number" id="accountnumber" name="accountnumber" min="1" required>
                <small>Enter account</small>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" min="1" required>
                <small>Enter the amount to be deducted</small>
            </div>
            <button type="submit" class="submit-btn" name="paynow">Pay Now</button>
        </form>
    </div>
</body>

</html>