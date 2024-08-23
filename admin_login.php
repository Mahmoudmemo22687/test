<?php
session_start();

if (isset($_POST['submit'])) {
    $admin_username = "youssef";
    $admin_password = "123456"; // Hashed password in a real-world scenario

    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    if ($input_username == $admin_username && $input_password == $admin_password) {
        $_SESSION['admin'] = true;
        header("Location: admin_panel.php");
        exit();
    } else {
        $error_message = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" type="image/x-icon" href="logo.png">

    <link rel="stylesheet" href="log3.css">

</head>
<body>
    <h2>Admin Login</h2>

    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
