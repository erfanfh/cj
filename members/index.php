<?php
session_start();
try {
    $hostname = "";
    $dbname = "";
    $hostusername = "";
    $hostpassword = "";
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $hostusername, $hostpassword);
    $useDb = $conn->query("use ");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo $exception;
    exit();
}


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "نام کاربری یا پسورد خالی است";
    } else {
        $result = $conn->prepare("SELECT * FROM users where username = ? and password = ?");
        $result->bindValue(1, $username);
        $result->bindValue(2, $password);
        $result->execute();
        $num = $result->fetchColumn();

        if ($num) {
            $_SESSION['member_logged_in'] = true;
            $query = $conn->prepare("SELECT * FROM users where username = ?");
            $query->bindValue(1, $username);
            $query->execute();
            $row = $query->fetch();
            $_SESSION['member_name'] = $row['name'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['iser_username'] = $row['username'];

            header("location: ../index.php");
            exit();

        } else {
            $_SESSION['error_message'] = "اطلاعات نادرست است";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود</title>
    <script src="https://kit.fontawesome.com/e167ba4721.js"></script>
    <link rel="icon" type="image/x-icon" href="../Images/Logo_nobg.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../fonts.css">
    <link rel="stylesheet" href="../media.css">
</head>



<body>

<section class="loginPage">
    <div class="box">
        <div class="formHeader">
            <h4>ورود</h4>
        </div>
        <div class="formBox">
            <form method="post">
                <label for="username">نام کاربری: </label>
                <input type="text" name="username" id="username">
                <br><br>
                <label for="password">رمزعبور: </label>
                <div class="password-box">
                    <input type="password" name="password" id="password">
                    <i class="toggle-password fa-regular fa-eye-slash" onclick="togglePasswordVisibility()"></i>
                </div>
                <br><br>
                <input type="submit" id="submit" name="submit" value="ورود">
            </form>
            <div class="error">
                <p id="error_text">
                    <?php
                    if (isset($_SESSION['error_message'])) {
                        echo $_SESSION['error_message'];
                        $_SESSION['error_message'] = false;
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class="forget">
            <a href="#">رمز عبور را فراموش کرده اید؟</a>
        </div>
        <div class="forget">
            <a href="register.php">حساب کاربری ندارید؟ ثبت نام کنید</a>
        </div>
    </div>
    <div class="logo">
        <a href='../index.php'>
            <img src="../Images/Logo_text-nobg_small.png" alt="Logo Coffee JAck">
        </a>
    </div>
</section>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var toggleIcon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        }
    }
</script>
</body>

</html>