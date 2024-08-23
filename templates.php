<?php include 'nav.php'; ?>
<section class="section1">
    <style>
        .section1 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            background-color: #7c9646;
            flex-wrap: wrap;
        }

        .template-card {
            border: 2px solid black;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 5px 5px 10px black;
            border-radius: 5px;
            width: 200px;
            margin: 15px;
            text-align: center;
            padding: 10px;
        }

        .template-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .template-card button {
            background-color: #17c964;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>

    <h1 style="color: white; text-align: center;">اختر قالب متجرك</h1>

    <form action="save_template.php" method="POST">
    <?php
    // تفاصيل الاتصال بقاعدة البيانات
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "data";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM templates";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="template-card">';
            echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . " Image'>";
            echo ' ' . htmlspecialchars($row['name']) . '';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '<button type="submit" name="template" value="' . htmlspecialchars($row['id']) . '">اختر هذا القالب</button>';
            echo '</div>';
        }
    } else {
        echo "لا توجد تيمبلتات متاحة.";
    }

    $conn->close();
    ?>
</form>


</section>
<?php include 'footer.php'; ?>
