<?php
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

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if any products were found
if ($result === false) {
    die("Error fetching products: " . $conn->error);
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المنتجات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header, .footer {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            overflow: hidden;
        }
        .main-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .product {
            background: #fff;
            padding: 20px;
            margin: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: calc(33% - 30px);
            box-sizing: border-box;
            transition: transform 0.3s;
        }
        .product:hover {
            transform: scale(1.05);
        }
        .product img {
            width: 100%;
            height: 260px;
            border-radius: 5px;
        }
        .product h2 {
            margin: 10px 0;
            font-size: 18px;
        }
        .product p {
            color: #666;
            margin: 0;
        }
        .product .price {
            color: #17c964;
            font-weight: bold;
            font-size: 16px;
        }
        .order-button {
            background-color: #17c964;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            display: block;
            text-align: center;
            text-decoration: none;
        }
        
    </style>
</head>
<body>
    <div class="header">
        <h1>عرض المنتجات</h1>
        <h1 >من هنا => <a href="products.php"> Dashborad  </a></h1>



    </div>
    <div class="container">
        <div class="main-content">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="product">
                        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="price">السعر: <?php echo htmlspecialchars($product['price']); ?> جنيه</p>
                        <a href="order.php?product_id=<?php echo $product['id']; ?>" class="order-button">طلب الآن</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>لا توجد منتجات لعرضها.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 جميع الحقوق محفوظة</p>
    </div>
</body>
</html>
