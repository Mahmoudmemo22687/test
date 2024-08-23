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

// تحديد معرف المتجر المناسب
$store_id = 1; // استبدله بالمعرف الصحيح للمتجر

// استعلام لجلب بيانات المتجر
$stmt = $conn->prepare("SELECT template_id FROM stores WHERE id=?");
$stmt->bind_param("i", $store_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $store = $result->fetch_assoc();
    $template_id = $store['template_id'];

    if ($template_id) {
        // استعلام لجلب بيانات القالب
        $stmt = $conn->prepare("SELECT * FROM templates WHERE id=?");
        $stmt->bind_param("i", $template_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $template = $result->fetch_assoc();
            echo "<h1>القالب المختار: " . htmlspecialchars($template['name']) . "</h1>";
            echo "<p>" . htmlspecialchars($template['description']) . "</p>";
        } else {
            echo "لم يتم العثور على القالب.";
        }
    } else {
        echo "لم يتم اختيار قالب بعد.";
    }

    $stmt->close();
} else {
    echo "لم يتم العثور على المتجر.";
}

$conn->close();
?>
