<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file for styling -->

    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

  .return-button {
            display: block;
            margin-top: 20px;
            text-align: center;
        }


        
        select {
            height: 40px;
        }

        textarea {
            resize: none;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
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
            <!-- Ajout des liens pour payer en ligne et hors ligne -->
            <input type="submit" value="Payer en ligne">
            <a href="offline_payment.php">Payer hors ligne</a>
            <!-- Fin des liens -->
             <a href="../home.php" class="return-button">Retour à la page d'accueil</a>
        </form>
    </div>
<?php

function getClientIPAddress() {  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    } else {  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  
// Debugging to see the contents of $_POST
var_dump($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve payment details from the form
    $card_name = isset($_POST['card_name']) ? $_POST['card_name'] : '';
    $card_number = isset($_POST['card_number']) ? $_POST['card_number'] : '';
    $expiry_date = isset($_POST['expiry_date']) ? $_POST['expiry_date'] : '';
    $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : '';
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

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
        
        echo "Payment successful! Thank you for your purchase.";
        // Function to delete all items from the cart
// Function to clear the cart
function clearCart($con) {
    $ipAddress = getClientIPAddress();
    $query = "DELETE FROM `cart_detailles` WHERE ip_adresse='$ipAddress'";
    $result = mysqli_query($con, $query);
    if($result) {
        echo "<script>alert('Cart cleared successfully');</script>";
        echo "<script>window.open('home.php','_self');</script>";
    } else {
        echo "<script>alert('Failed to clear cart');</script>";
        echo "<script>window.open('home.php','_self');</script>";
    }
}

// Call the clearCart function with the $con variable as an argument
clearCart($con);


    }
}
?>

</body>
</html>
