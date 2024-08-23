<?php
require 'vendor/autoload.php';

// Database connection details
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "data"; // Replace with your database name

// Create connection to the database
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total revenue
$sql_revenue = "SELECT SUM(amount) AS total_revenue FROM transactions";
$result_revenue = $conn->query($sql_revenue);
$total_revenue = $result_revenue->fetch_assoc()['total_revenue'];

// Fetch total expenses
$sql_expenses = "SELECT SUM(amount) AS total_expenses FROM transactions WHERE amount < 0"; // Assuming expenses are stored as negative amounts
$result_expenses = $conn->query($sql_expenses);
$total_expenses = $result_expenses->fetch_assoc()['total_expenses'];

// Fetch total number of users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];

// Fetch total number of completed orders
$sql_completed_orders = "SELECT COUNT(*) AS total_completed_orders FROM orders WHERE is_completed = 1";
$result_completed_orders = $conn->query($sql_completed_orders);
$total_completed_orders = $result_completed_orders->fetch_assoc()['total_completed_orders'];

// Fetch total number of incomplete orders
$sql_incomplete_orders = "SELECT COUNT(*) AS total_incomplete_orders FROM orders WHERE is_completed = 0";
$result_incomplete_orders = $conn->query($sql_incomplete_orders);
$total_incomplete_orders = $result_incomplete_orders->fetch_assoc()['total_incomplete_orders'];

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إحصائيات الإدارة</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .stat {
            background: #7c9646;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 24%;
            text-align: center;
            margin-bottom: 20px;
        }
        .stat h2 {
            margin: 0;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>لوحة تحكم الإدارة</h1>
        <div class="stats">
            <div class="stat">
                <h2><?php echo number_format($total_revenue, 2); ?> جنيه</h2>
                <p>إجمالي الإيرادات</p>
            </div>
            <div class="stat">
                <h2><?php echo number_format($total_expenses, 2); ?> جنيه</h2>
                <p>إجمالي المصروفات</p>
            </div>
            <div class="stat">
                <h2><?php echo $total_users; ?></h2>
                <p>عدد العملاء</p>
            </div>
            <div class="stat">
                <h2><?php echo $total_completed_orders; ?></h2>
                <p>عدد الطلبات المكتملة</p>
            </div>
            <div class="stat">
                <h2><?php echo $total_incomplete_orders; ?></h2>
                <p>عدد الطلبات غير المكتملة</p>
            </div>
        </div>
    </div>
</body>
</html>
