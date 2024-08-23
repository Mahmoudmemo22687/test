<?php
// Include required libraries
require 'vendor/autoload.php'; // For Stripe and PayPal libraries

// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your database username
$password_db = ""; // Replace with your database password
$dbname = "data"; // Replace with your database name

// Create connection to the database
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $store_id = isset($_POST['store_id']) ? intval($_POST['store_id']) : 0;
    $whatsapp_number = isset($_POST['whatsapp_number']) ? $_POST['whatsapp_number'] : '';
    $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';

    // Validate inputs
    if (empty($store_id) || empty($whatsapp_number) || empty($customer_name) || !is_numeric($amount)) {
        die("All fields are required.");
    }

    // Generate unique invoice number and get current date
    $invoice_number = uniqid('INV-');
    $order_date = date('Y-m-d');
    $is_completed = 0; // Initially, the order is not completed

    // Save order to database
    $stmt = $conn->prepare("INSERT INTO orders (store_id, whatsapp_number, invoice_number, customer_name, order_date, is_completed, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("issssi", $store_id, $whatsapp_number, $invoice_number, $customer_name, $order_date, $is_completed);
    $stmt->execute();
    $stmt->close();

    // Process payment and redirect
    switch ($payment_method) {
        case 'stripe':
            \Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => "Invoice #$invoice_number"],
                        'unit_amount' => $amount * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://yourdomain.com/success.php',
                'cancel_url' => 'http://yourdomain.com/cancel.php',
            ]);
            header("Location: " . $session->url);
            break;

        case 'paymob':
            $apiKey = 'YOUR_PAYMOB_API_KEY';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.paymob.com/your_endpoint");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'amount' => $amount,
                'currency' => 'EGP'
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            if ($response['status'] == 'success') {
                header("Location: " . $response['payment_link']);
            } else {
                echo "Paymob Payment Failed!";
            }
            break;

        case 'paypal':
            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    'YOUR_PAYPAL_CLIENT_ID',
                    'YOUR_PAYPAL_CLIENT_SECRET'
                )
            );
            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');
            $amountObj = new \PayPal\Api\Amount();
            $amountObj->setTotal($amount);
            $amountObj->setCurrency('USD');
            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amountObj);
            $transaction->setDescription("Invoice #$invoice_number");
            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $redirectUrls->setReturnUrl('http://yourdomain.com/execute_payment.php?success=true')
                         ->setCancelUrl('http://yourdomain.com/execute_payment.php?success=false');
            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions([$transaction])
                    ->setRedirectUrls($redirectUrls);
            try {
                $payment->create($apiContext);
                header("Location: " . $payment->getApprovalLink());
            } catch (Exception $ex) {
                echo "PayPal Payment Failed!";
            }
            break;

        case 'myfawrah':
            $apiKey = 'YOUR_MYFAWRAH_API_KEY';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.myfawrah.com/your_endpoint");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'amount' => $amount,
                'currency' => 'EGP'
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            if ($response['status'] == 'success') {
                header("Location: " . $response['payment_link']);
            } else {
                echo "MyFawrah Payment Failed!";
            }
            break;

        default:
            echo "Invalid Payment Method";
            break;
    }

    // Close database connection
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الدفع</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        /* Container */
        .container {
            width: 80%;
            margin: 0 auto;
            max-width: 1200px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="number"], input[type="text"], select {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="number"]:focus, input[type="text"]:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Stripe Elements */
        #card-element {
            background: white;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>صفحة الدفع</h1>
        <form action="" method="POST">
            <label for="store">اختر المنتج:</label>
            <select id="store_id" name="store_id" required>
                <option value="">-- اختر منتجاً --</option>
                <?php
                // Fetch products from database
                $result = $conn->query("SELECT id, name, price FROM products");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"{$row['id']}\" data-price=\"{$row['price']}\">{$row['name']} - {$row['price']} جنيه</option>";
                }
                ?>
            </select>

            <label for="whatsapp_number">رقم واتس:</label>
            <input type="text" id="whatsapp_number" name="whatsapp_number" required>

            <label for="customer_name">اسم العميل:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="amount">المبلغ (جنيه):</label>
            <input type="number" id="amount" name="amount" step="0.01" required readonly>

            <label for="payment_method">طريقة الدفع:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="stripe">Stripe</option>
                <option value="paymob">Paymob</option>
                <option value="paypal">PayPal</option>
                <option value="myfawrah">MyFawrah</option>
            </select>

            <button type="submit">دفع</button>
        </form>
    </div>

    <script>
        function updateAmount() {
            const product = document.getElementById('store_id');
            const amountField = document.getElementById('amount');
            const selectedOption = product.options[product.selectedIndex];
            amountField.value = selectedOption.getAttribute('data-price');
        }

        document.getElementById('store_id').addEventListener('change', updateAmount);
    </script>
</body>
</html>
