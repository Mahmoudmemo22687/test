<?php
require 'vendor/autoload.php'; // Include this if using any libraries

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

// Fetch products from the database
$sql = "SELECT p.id, p.name, p.price, p.quantity, p.description, p.created_at, p.updated_at, s.store_name AS store_name
        FROM products p
        LEFT JOIN stores s ON p.store_id = s.id
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <title>لوحة التحكم - المنتجات</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif; /* تغيير نوع الخط */
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
        width: 280px; /* Slightly wider sidebar */
        background-color: #7c9646; /* Darker, elegant blue-gray background */
        color: white; /* White text color */
        height: 100vh; /* Full viewport height */
        position: fixed; /* Fixed position */
        top: 0;
        right: 0; /* Align to the right */
        padding: 30px 20px; /* More padding for a balanced look */
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2); /* Stronger shadow for depth */
        display: flex;
        flex-direction: column;
        align-items: center; /* Centered items */
        border-top-left-radius: 15px; /* Rounded top-left corner */
        border-bottom-left-radius: 15px; /* Rounded bottom-left corner */
}

.sidebar h2 {
    text-align: center; /* Centered heading */
    margin-bottom: 30px; /* More space below heading */
    font-size: 24px; /* Larger font size */
    letter-spacing: 1.5px; /* Spacing between letters for a modern look */
}

.sidebar a {
    color: white; /* White text color */
    text-decoration: none; /* No underline */
    display: block; /* Block level link */
    padding: 15px; /* More padding for larger clickable area */
    margin-bottom: 15px; /* More space between links */
    border-radius: 8px; /* Rounded corners */
    width: 100%; /* Full width */
    text-align: center; /* Centered text */
    background-color: #526825; /* Slightly darker background */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transitions */
}

.sidebar a:hover {
    background-color: #1abc9c; /* Stylish teal on hover */
    transform: scale(1.05); /* Slight zoom effect */
}
        .container {
            margin-right: 290px; /* Adjusted to leave space for the sidebar */
            width: calc(100% - 270px);
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #7c9646;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="logo.png" alt="Logo"> <!-- Replace with the path to your logo image -->
        <h2>لوحة التحكم</h2>
        <a href="#">الرئيسية</a>
        <a href="ordardash.php">الطلبات</a>
        <a href="products.php">المنتجات</a>
        <a href="customers.php">العملاء</a>
        <a href="banned_buyers.php">المشترين المحظورين</a>
        <a href="dis.php"> الخصومات</a>
        <a href="comp.php">شكاوي المشتري</a>
        <a href="templates.php">الخروج</a>
    </div>
    <div class="container">
        <h1>لوحة التحكم - المنتجات</h1>
        <table>
            <thead>
                <tr>
                    <th>رقم المنتج</th>
                    <th>اسم المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>الوصف</th>
                    <th>تاريخ الإضافة</th>
                    <th>تاريخ التحديث</th>
                    <th>اسم المتجر</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                            <td><?php echo htmlspecialchars($row['store_name']); ?></td>
                            <td><a href="edit_product.php?id=<?php echo htmlspecialchars($row['id']); ?>">تعديل</a></td>
                            <td><a href="delete_product.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">حذف</a></td>
                            <td><a href="add_product.php?id=<?php echo htmlspecialchars($row['id']); ?>">اضافة</a></td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">لا توجد منتجات لعرضها</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>
