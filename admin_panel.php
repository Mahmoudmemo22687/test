<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="icon" type="image/x-icon" href="logo.png">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            position: relative;
            background: linear-gradient(to right, #7c9646, #009331);
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #555;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            background-color: #444;
        }

        nav a:hover {
            background-color: #666;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>

    <nav>
        <a href="admincomp.php">شكاوى العملاء</a>
        <a href="user.php">اضافة مستخدمين</a>
        <a href="add.php">اضافة عملاء</a>
        <a href="ordardash.php">طلبات المتاجر </a>
        <a href="admin.php"> لوحة الارباح </a>
        <a href="admin_login.php">Logout</a>
    </nav>

    <div class="container">
        <!-- Your content goes here -->
        <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
        <p>This is your admin panel. Feel free to manage products and orders.</p>
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> Admin Panel
    </footer>
</body>
</html>
