<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قوائم - أنشئ متجرك الإلكتروني</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="images\logo.png">
    <style>
        body {
            background: url('متجر\ dashboard\ discounts\ Rectangle 31.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Roboto', sans-serif; /* تغيير نوع الخط */
        }
        .container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 30px 30px rgba(0, 0, 0, 0.1);
            background-color: #5DAD02;
        }
        .menu-button {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border: none;
            background: transparent;
            font-size: 16px;
            text-align: left;
            width: 100%;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
            text-align:center;

        }
        .menu-button:last-child {
            border-bottom: none;
        }
        .icon {
            font-size: 20px;
            color: #8ac443;
        }
        .text {
            font-weight: bold;
            
        }
        .menu-button:hover {
            background-color: #035212;
        }
        button {
          
            text-align:center;

          
            
            background-color: #036D06;
            box-shadow: 0px 30px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            font-size: 30px;

            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 50%;
            height: 50%;
            margin-top: 20px;
        }
        button:hover {
            opacity: 0.8;
        }
        .new {
            display: inline-block;
            background-color: #ff4d4d;
            color: #fff;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 12px;
            margin-left: 10px;
        }
        .nav-logo{
            display: flex;
            align-items:center;
        }
    </style>
</head>
<body>
    <div class="container">
             <div class="icon">
                    <img src="images/logo.png" alt="Your Logo">
                </div>
        <button class="menu-button">
            <span class="icon">🏠</span>
            <span class="text">الصفحة الرئيسية</span>
        </button>
        <button class="menu-button">
            <span class="icon">☰</span>
            <span class="text">الطلبات</span>
        </button>
        <button class="menu-button">
            <span class="icon">🚫</span>
            <span class="text">الخصومات</span>
        </button>
        <button class="menu-button">
            <span class="icon">🚫</span>
            <span class="text">حظر مشتري</span>
        </button>
        <button class="menu-button">
            <span class="icon">📍</span>
            <span class="text">التوصيل</span>
        </button>
        <button class="menu-button">
            <span class="icon">📥</span>
            <span class="text">شكاوي المشتري</span>
        </button>
        <button class="menu-button">
            <span class="icon">📤</span>
            <span class="text">تواصل مع Targ</span>
        </button>
        <button class="menu-button">
            <span class="icon">💲</span>
            <span class="text">تغيير خطة الأسعار</span>
        </button>
        <button class="menu-button">
            <span class="icon">💳</span>
            <span class="text">طرق الدفع</span>
        </button>
        <button class="menu-button">
            <span class="icon">👥</span>
            <span class="text">فريق عملك</span>
        </button>
        <button class="menu-button">
            <span class="icon">👛</span>
            <span class="text">المصروفات <span class="new">جديد</span></span>
        </button>
        <button>متجرك</button>
    </div>
</body>
</html>
