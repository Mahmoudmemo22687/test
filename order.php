<?php
// تفاصيل الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root"; // استبدله باسم المستخدم المناسب
$password_db = ""; // استبدله بكلمة المرور المناسبة
$dbname = "data"; // استبدله باسم قاعدة البيانات المناسبة

// إنشاء الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password_db, $dbname);

// تحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// التحقق من أن معرف المنتج قد تم إرساله عبر الرابط
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // استعلام لجلب بيانات المنتج
    $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("المنتج غير موجود.");
    }
} else {
    die("لم يتم تحديد المنتج.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب منتج</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px #aaa;
            border-radius: 5px;
        }
        .product-details {
            text-align: center;
        }
        .product-details h1 {
            margin-bottom: 20px;
        }
        .product-details img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .product-details p {
            font-size: 18px;
            margin: 10px 0;
        }
        .order-form {
            margin-top: 30px;
        }
        .order-form input, .order-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .order-form button {
            background-color: #17c964;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="product-details">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price">السعر: <?php echo htmlspecialchars($product['price']); ?> جنيه</p>
        </div>
        <div class="order-form">
            <h2>قم بملء التفاصيل لطلب المنتج</h2>
                        <form action="process_order.php" method="POST">
                <input type="hidden" name="store_id" value="1"> <!-- Make sure store_id is correct -->
                
                <label for="whatsapp_number">WhatsApp Number:</label>
                <input type="tel" id="whatsapp_number" name="whatsapp_number" required>
                
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" required>
                
                <input type="submit" value="Place Order">
            </form>
        </div>
    </div>
</body>
</html>
