<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $percentage = $_POST['percentage'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $is_global = isset($_POST['is_global']) ? 1 : 0;
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $is_unlimited = isset($_POST['is_unlimited']) ? 1 : 0;
    $max_uses = $_POST['max_uses'];

    try {
        $sql = "INSERT INTO discounts (code, percentage, start_date, end_date, is_global, product_id, is_unlimited, max_uses)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // The corrected bind_param type definition string
        $stmt->bind_param("sdsssiii", $code, $percentage, $start_date, $end_date, $is_global, $product_id, $is_unlimited, $max_uses);
        
        $stmt->execute();
        $success_message = "Discount added successfully!";
    } catch (Exception $e) {
        $error_message = "An error occurred. Please try again later.";
    } finally {
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Discount</title>
</head>
<body>
<style>
 body {
    font-family: 'Roboto', sans-serif; /* Modern font style */
    background-color: #f0f2f5; /* Soft background color */
    margin: 0;
    padding: 0;
    display: flex; /* Flexbox layout */
    justify-content: center; /* Center content horizontally */
    align-items: center; /* Center content vertically */
    height: 100vh; /* Full viewport height */
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
    margin-right: 400px; /* Leave space for the sidebar */
    width: 100px; /* Full width minus sidebar */
    padding: 30px; /* More padding */
    background: #fff; /* White background */
    border-radius: 12px; /* More rounded corners */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.15); /* Stronger shadow */
    margin-top: 40px; /* Space above container */
    max-width: 1200px; /* Max width for better readability */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
}

.container:hover {
    margin-right: 290px; /* Adjusted to leave space for the sidebar */

    transform: translateY(-10px); /* Slight lift effect on hover */
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); /* Deeper shadow on hover */
}

h1 {
    text-align: center;
    color: #333; /* Dark gray color */
    margin-bottom: 25px; /* More space below heading */
    font-size: 28px; /* Larger font size */
    font-weight: bold; /* Bold text */
    letter-spacing: 1px; /* Spacing between letters */
}

form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 500px;
    /* height: 300px; */
    max-width: 800px; /* Wider form */
    margin: 0 auto; /* Center form horizontally */
    background-color: #fff; /* White background */
    padding: 30px; /* More padding */
    border-radius: 12px; /* Rounded corners */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.15); /* Subtle shadow */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
}

/* form:hover {
    transform: translateY(-5px); /* Slight lift effect on hover */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Deeper shadow on hover */
} */

label {
    margin-bottom: 12px;
    font-weight: bold;
    color: #34495e; /* Darker gray-blue for labels */
    font-size: 16px; /* Larger font size */
    letter-spacing: 0.5px; /* Spacing between letters */
}

input[type="text"],
input[type="number"],
input[type="date"] {
    width: 100%;
    padding: 12px 15px; /* More padding for better usability */
    margin-bottom: 25px; /* More space between inputs */
    border: 1px solid #ccc; /* Light gray border */
    border-radius: 8px; /* Rounded corners */
    font-size: 16px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus {
    border-color: #1abc9c; /* Teal border on focus */
    box-shadow: 0 0 8px rgba(26, 188, 156, 0.5); /* Soft glow on focus */
    outline: none; /* Remove default outline */
}

input[type="checkbox"] {
    margin-right: 10px; /* Space between checkbox and label */
}

input[type="submit"] {
    background-color: #1abc9c; /* Teal background */
    color: white; /* White text color */
    padding: 12px 25px; /* Larger padding */
    border: none;
    border-radius: 8px; /* Rounded corners */
    font-size: 16px;
    cursor: pointer;
    align-self: flex-start; /* Align button to the left */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transitions */
}

input[type="submit"]:hover {
    background-color: #16a085; /* Darker teal on hover */
    transform: scale(1.05); /* Slight zoom effect */
}

p {
    text-align: center;
    color: #27ae60; /* Stylish green for success messages */
    font-size: 18px;
    margin-bottom: 25px;
}

</style>
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
    <h1>Add New Discount</h1>
    <?php if (isset($success_message)): ?>
        <p><?php echo $success_message; ?></p>
    <?php elseif (isset($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label for="code">Code:</label>
        <input type="text" id="code" name="code" required>

        <label for="percentage">Percentage:</label>
        <input type="number" id="percentage" name="percentage" step="0.01" required>
        

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date">

        <label for="is_global">Global Discount:</label>
        <input type="checkbox" id="is_global" name="is_global">

        <label for="product_id">Product ID (if applicable):</label>
        <input type="number" id="product_id" name="product_id">

        <label for="is_unlimited">Unlimited Uses:</label>
        <input type="checkbox" id="is_unlimited" name="is_unlimited">

        <label for="max_uses">Max Uses (if not unlimited):</label>
        <input type="number" id="max_uses" name="max_uses">

        <input type="submit" value="Add Discount">
    </form>
</body>
</html>
