<?php
require 'vendor/autoload.php'; // Include this if using any libraries

// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your database username
$password_db = ""; // Replace with your database password
$dbname = "data"; // Use the database name `orders`

// Create connection to the database
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    // Handle file upload
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($image);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            // File upload successful
        } else {
            die("Failed to upload image.");
        }
    }

    $sql = "INSERT INTO products (name, price, quantity, description, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsss", $name, $price, $quantity, $description, $image);
    $stmt->execute();

    header("Location: products.php");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 50%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], input[type="number"], textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        input[type="file"] {
            margin-bottom: 15px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #7c9646;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #5a7d39;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>إضافة منتج جديد</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="name">اسم المنتج:</label>
            <input type="text" id="name" name="name" required>
            <label for="price">السعر:</label>
            <input type="text" id="price" name="price" required>
            <label for="quantity">الكمية:</label>
            <input type="number" id="quantity" name="quantity" required>
            <label for="description">الوصف:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="image">الصورة:</label>
            <input type="file" id="image" name="image">
            <input type="submit" value="إضافة منتج">
        </form>
    </div>
</body>
</html>
