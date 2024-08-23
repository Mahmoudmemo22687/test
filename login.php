<?php include 'nav.php'; ?>

<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id, $hashed_password);

        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
            exit();
        } else {
            // Invalid credentials
            $error_message = "Invalid username or password.";
        }
    } catch (Exception $e) {
        // Handle database errors
        $error_message = "An error occurred. Please try again later.";
    } finally {
        $stmt->close();
    }
}

$conn->close();
?>

<section class="section1">
    <style>.section1{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 730px;
    background-color: #7c9646;
}
.form1{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 700px;
    height: 500px;
    border: 2px solid black;
    /* backdrop-filter: blur(15px); */
    -tw-text-opacity: 1;
    background-color: rgba(255, 255, 255, 0.3) ;

    box-shadow: 10px 10px 10px  black;
    border-radius: 5px;

}
input{
    width: 400px;
    padding: 10px;
    border-radius: 7px;
}
.talk1{
    font-size: larger;
    text-align: center;
    margin-bottom: 10px;
    color: white;
}
.btn1{
    background-color: #17c964;
    color: white;
    font-size: x-large;
}
.talk11{
    margin-top: 10px;
    font-size: 20px;
    text-align: center;
}
.take4{
   text-align: end;
    font-size: 20px;
    color: white;
}</style>

        <form action="" class="form1">
            <fieldset>
                <legend  class="talk1"> يسعدنا عودتك </legend>
                <!-- <h1 class="talk1">يسعدنا عودتك </h1> -->
                <h1 class="talk1">قم بتسجيل الدخول لكى تتمكن من متابعة متجرك</h1>
                <h1 class="take4"> البريد الاكتروني</h1>
                <input type="email" name="email" id="" required value="">
                <br>
                <br>
                <h1 class="take4"> كلمه المرور</h1>
                <input type="password" name="bassword" id="" value="">
                <br>
                <br>
                <input  class="btn1" type="submit" name="" id=""  value="تسجيل دخول" >
                <div>
                    <h1 class="talk11">لا تمتلك حساب ؟<a href="register.php"> مستخدم جديد </a></h1>
                </div>
            </fieldset>
        </form>
    </section>
<?php include 'footer.php'; ?>
