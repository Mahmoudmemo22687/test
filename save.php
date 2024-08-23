<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $store_name = $_POST['store_name'];
    $store_description = $_POST['store_description'];
    $business_activity = $_POST['business_activity'];
    $domain = $_POST['domain'];
    $whatsapp_number = $_POST['whatsapp_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Database connection details
    $servername = "localhost";
    $username = "root"; // Replace with your DB username
    $password_db = ""; // Replace with your DB password
    $dbname = "data"; // Replace with your DB name

    // Create connection
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to insert data into the stores table
    $sql = "INSERT INTO stores (whatsapp_number, email, store_name, domain, description, business_type, created_at)
    VALUES ('$whatsapp_number', '$email', '$store_name', '$domain', '$store_description', '$business_activity', NOW())";

    // Execute query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "Store created successfully!";
        // Redirect to the next page after successful submission
        header("Location: templates.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
