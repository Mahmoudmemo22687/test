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

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM Users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE Users SET email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $email, $password, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
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
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .form-container {
            margin-top: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], input[type="password"] {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>إدارة المستخدمين</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>البريد الإلكتروني</th>
                    <th>تاريخ الإنشاء</th>
                    <th>تاريخ التحديث</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                            <td class="actions">
                                <a href="manage_users.php?edit=<?php echo $row['id']; ?>">تعديل</a>
                                <a href="manage_users.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا المستخدم؟')">حذف</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">لا توجد بيانات لعرضها</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="form-container">
            <h2>إضافة مستخدم جديد</h2>
            <form method="POST" action="manage_users.php">
                <input type="hidden" name="add">
                <label for="email">البريد الإلكتروني:</label>
                <input type="text" id="email" name="email" required>
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="إضافة مستخدم">
                <a href="admin_panel.php"  > are you want back to dashboard</a>

            </form>
        </div>

        <?php if (isset($_GET['edit'])): ?>
            <?php
            $edit_id = intval($_GET['edit']);
            // Reconnect to get user data for editing
            $conn = new mysqli($servername, $username, $password_db, $dbname);
            $stmt = $conn->prepare("SELECT * FROM Users WHERE id = ?");
            $stmt->bind_param("i", $edit_id);
            $stmt->execute();
            $user_result = $stmt->get_result();
            $user = $user_result->fetch_assoc();
            $stmt->close();
            $conn->close();
            ?>

            <div class="form-container">
                <h2>تعديل المستخدم</h2>
                <form method="POST" action="manage_users.php">
                    <input type="hidden" name="update">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <label for="email">البريد الإلكتروني:</label>
                    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    <label for="password">كلمة المرور:</label>
                    <input type="password" id="password" name="password" required>
                    <input type="submit" value="تحديث مستخدم">
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
