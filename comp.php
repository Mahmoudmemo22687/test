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

// معالجة البيانات القادمة من النموذج
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // تأمين البيانات
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $subject = $conn->real_escape_string($subject);
    $message = $conn->real_escape_string($message);

    // استعلام لإدخال الشكوى إلى قاعدة البيانات
    $sql = "INSERT INTO complaints (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        $success_message = "تم إرسال الشكوى بنجاح.";
    } else {
        $error_message = "فشل إرسال الشكوى: " . $stmt->error;
    }

    // إغلاق الاتصال بقاعدة البيانات
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إرسال شكوى</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
            width: 60%;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
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
        }
        input[type="text"], input[type="email"], textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
            height: 150px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #7c9646;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #5a7d39;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .success {
            color: #4caf50;
        }
        .error {
            color: #f44336;
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
        <a href="comp.php">شكاوي المشتري</a>
        <a href="dis.php"> الخصومات</a>
        <a href="templates.php">الخروج</a>
    </div>

    
    <div class="container">
        <h1>إرسال شكوى</h1>
        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="name">اسمك:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="subject">الموضوع:</label>
            <input type="text" id="subject" name="subject" required>
            
            <label for="message">الرسالة:</label>
            <textarea id="message" name="message" required></textarea>
            
            <input type="submit" value="إرسال الشكوى">
        </form>
    </div>
</body>
</html>
