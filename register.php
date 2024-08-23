<?php include 'nav.php'; ?>
<section class="section1">
    <style>
        .section1 {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 730px;
            background-color: #7c9646;
        }

        .form1 {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 500px;
            height: auto;
            border: 2px solid black;
            background-color: rgba(255, 255, 255, 0.3);
            box-shadow: 10px 10px 10px black;
            border-radius: 5px;
            padding: 10px;
        }

        input, textarea {
            width: 300px;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 8px;
        }

        textarea {
            height: 20px;
        }

        .talk1 {
            font-size: medium;
            text-align: center;
            margin-bottom: 8px;
            color: white;
        }

        .btn1 {
            background-color: #17c964;
            color: white;
            font-size: medium;
            padding: 5px 10px;
        }

        .take4 {
            text-align: end;
            font-size: 18px;
            color: white;
        }
    </style>

    <form action="save.php" method="POST" class="form1">
        <fieldset>
            <legend class="talk1">أنشئ متجرك</legend>
            <h1 class="talk1">قم بملء النموذج حتى تتمكن من إنشاء متجرك</h1>

            <h1 class="take4">اسم متجرك</h1>
            <input type="text" name="store_name" required>

            <h1 class="take4">وصف المتجر</h1>
            <textarea name="store_description" rows="2" required></textarea>

            <h1 class="take4">ما هو مجال نشاطك التجاري؟</h1>
            <input type="text" name="business_activity" required>

            <h1 class="take4">حدد دومنك</h1>
            <input type="text" name="domain" required>

            <h1 class="take4">رقم واتس</h1>
            <input type="tel" name="whatsapp_number" required>

            <h1 class="take4">البريد الإلكتروني</h1>
            <input type="email" name="email" required>

            <h1 class="take4">كلمة المرور</h1>
            <input type="password" name="password" required>

            <br>
            <input class="btn1" type="submit" value="الذهاب إلى تحديد نموذج للمتجر">
        </fieldset>
    </form>
</section>
<?php include 'footer.php'; ?>
