<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
      
    </style>
</head>
<body>
    <div class="container">
        <h1>Secure Payment</h1>
        <form action="" method="POST">
            <label for="card_name">Cardholder Name:</label>
            <input type="text" id="card_name" name="card_name" required><br>

            <label for="card_number">Card Number:</label>
            <input type="text" id="card_number" name="card_number" required><br>

            <label for="expiry_date">Expiry Date:</label>
            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" required><br>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" required><br>

            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" required><br>

            <label for="country">Country:</label>
            <select id="country" name="country" required>
                <option value="">Select Country</option>
                <option value="USA">United States</option>
                <option value="UK">United Kingdom</option>
                <!-- Add more countries as needed -->
            </select><br>

            <label for="address">Billing Address:</label>
            <textarea id="address" name="address" rows="4" required></textarea><br>

            <input type="submit" value="Pay Now">
            
        </form>
        
    </div>



</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve payment details from the form
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $amount = $_POST['amount'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Perform validation (you can add your validation logic here)

    // Integration with PaymentGateway API (example)
    $payment_gateway_url = "https://paymentgateway.com/process_payment"; // Example API endpoint
    $api_key = "YOUR_API_KEY"; // Your API key

    $data = array(
        'card_name' => $card_name,
        'card_number' => $card_number,
        'expiry_date' => $expiry_date,
        'cvv' => $cvv,
        'amount' => $amount,
        'country' => $country,
        'address' => $address,
        'api_key' => $api_key
    );

    // Send payment data to PaymentGateway API using cURL or other HTTP client
    // Example:
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $payment_gateway_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Handle API response
    if ($response === false) {
        // Error handling
        echo "Error processing payment. Please try again later.";
    } else {
        // Payment successful
        echo "Payment successful! Thank you for your purchase.";
    }
} else {
    // Redirect the user back to the payment page if the request method is not POST
    header("Location: payment.php");
    exit();
}
?>
