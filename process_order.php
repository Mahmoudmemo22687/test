<?php
// Debugging: Output POST data
echo '<pre>';
print_r($_POST);
echo '</pre>';

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

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign variables from POST data
    $store_id = $_POST['store_id'] ?? null;
    $whatsapp_number = $_POST['whatsapp_number'] ?? null;
    $customer_name = $_POST['customer_name'] ?? null;

    // Check if any of these variables are null
    if (is_null($store_id) || is_null($whatsapp_number) || is_null($customer_name)) {
        die("All fields are required.");
    }

    $invoice_number = uniqid('INV-'); // Generate a unique invoice number
    $order_date = date('Y-m-d');
    $is_completed = 0; // Initially, the order is not completed

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO orders (store_id, whatsapp_number, invoice_number, customer_name, order_date, is_completed, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("issssi", $store_id, $whatsapp_number, $invoice_number, $customer_name, $order_date, $is_completed);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Order placed successfully!";
        // Redirect to a thank you page or order summary
        header("Location: payment.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
