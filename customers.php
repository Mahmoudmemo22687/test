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

// Search functionality
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
}

$sql = "SELECT DISTINCT customer_name, whatsapp_number
        FROM orders
        WHERE customer_name LIKE '%$search%' OR whatsapp_number LIKE '%$search%'
        ORDER BY customer_name";
$result = $conn->query($sql);

// Handle banning
if (isset($_GET['ban_number'])) {
    $ban_number = $conn->real_escape_string($_GET['ban_number']);
    $sql_ban = "INSERT INTO banned_buyers (whatsapp_number, created_at)
                VALUES ('$ban_number', NOW())";
    $conn->query($sql_ban);

    // Redirect to avoid re-submission
    header("Location: customers.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <title>لوحة التحكم - العملاء</title>
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
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #036E18;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #025a0b;
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
        .ban-btn {
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
        <a href="index.php">الرئيسية</a>
        <a href="ordardash.php">الطلبات</a>
        <a href="products.php">المنتجات</a>
        <a href="customers.php">العملاء</a>
        <a href="banned_buyers.php">المشترين المحظورين</a>
        <a href="dis.php"> الخصومات</a>

        <a href="comp.php">شكاوي المشتري</a>
        <a href="templates.php">الخروج</a>
    </div>
    <div class="container">
        <h1>لوحة التحكم - العملاء</h1>
        <form method="GET" action="customers.php">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="ابحث عن عميل...">
            <button type="submit">بحث</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>اسم العميل</th>
                    <th>رقم الواتس</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['whatsapp_number']); ?></td>
                            <td>
                                <a href="?ban_number=<?php echo htmlspecialchars($row['whatsapp_number']); ?>" class="ban-btn" onclick="return confirm('هل أنت متأكد أنك تريد حظر هذا العميل؟');">حظر</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">لا توجد بيانات لعرضها</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
