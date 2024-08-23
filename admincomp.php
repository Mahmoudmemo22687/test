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

// استعلام لجلب الشكاوى
$sql = "SELECT * FROM complaints ORDER BY created_at DESC";
$result = $conn->query($sql);

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - الشكاوى</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif; /* تغيير نوع الخط */
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #7c9646;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 20px;

        }
        .sidebar img {
            width: 100px; /* Adjust the size of the logo as needed */
            margin-bottom: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #025a0b;
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
        .unban-btn {
            color: white;
            background-color: #d9534f;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="sidebar">
        <img src="logo.png" alt="Logo"> <!-- Replace with the path to your logo image -->
        <h2>لوحة التحكم</h2>
        <a href="admincomp.php"> الشكاوى 🏠</a>
        <a href="user.php"> المستخدمين 🏠</a>
        
      
    </div>
    
    <div class="container">
        <h1>لوحة التحكم - الشكاوى</h1>
        <table>
            <thead>
                <tr>
                    <th>رقم الشكوى</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الموضوع</th>
                    <th>الرسالة</th>
                    <th>تاريخ الإرسال</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">لا توجد شكاوى لعرضها</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
