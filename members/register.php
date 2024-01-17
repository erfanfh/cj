<?php

session_start();
try {
    $hostname     = "";
    $dbname       = "";
    $hostusername = "";
    $hostpassword = "";
    $conn         = new PDO("mysql:host=$hostname;dbname=$dbname", $hostusername, $hostpassword);
    $useDb        = $conn->query("use ");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo $exception;
    exit();
}

function hasRequiredCharacters($text)
{
    return preg_match('/[A-Z]/', $text) && preg_match('/[a-z]/', $text) && preg_match('/[0-9]/', $text) && preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $text) && strlen($text) >= 8;
}


if (isset($_POST['submit'])) {
    $name                      = trim(htmlspecialchars(addslashes($_POST['name'])));
    $_SESSION['user_name']     = $name;
    $username                  = trim(htmlspecialchars(addslashes($_POST['username'])));
    $_SESSION['user_username'] = $username;
    $email                     = trim(htmlspecialchars(addslashes($_POST['email'])));
    $_SESSION['user_email']    = $email;
    $mobile                    = trim(htmlspecialchars(addslashes($_POST['mobile'])));
    $_SESSION['user_mobile']   = $mobile;
    $password                  = trim(htmlspecialchars(addslashes($_POST['password'])));
    $_SESSION['user_password'] = $password;
    $_SESSION['member_name']   = $name;
    if (empty($username) || empty($password) || empty($email) || empty($mobile) || empty($name)) {
        $_SESSION['error_message'] = "کادری خالی می باشد";
    } else {
        $result = $conn->prepare("SELECT * FROM users where username = ?");
        $result->bindValue(1, $username);
        $result->execute();
        $num = $result->fetchColumn();
        if ($num) {
            $_SESSION['error_message'] = "نام کاربری تکراری می باشد";
        } else {
            $stmt = $conn->prepare("SELECT * FROM users where mobile = ?");
            $stmt->bindValue(1, $mobile);
            $stmt->execute();
            $pass = $stmt->fetchColumn();
            if ($pass) {
                $_SESSION['error_message'] = "شماره موبایل تکراری می باشد";
            } else {
                if (!hasRequiredCharacters($password)) {
                    $_SESSION['error_message'] = "رمز عبور مناسب نمی باشد";
                } else {
                    if ($_POST['captcha'] != $_SESSION['captcha_code']) {
                        $_SESSION['error_message'] = "کد امنیتی اشتباه وارد شده است";
                    } else {
                        $_SESSION['send_code'] = true;
                        header("location: send_code.php");
                        exit;
                    }
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام</title>
    <script src="https://kit.fontawesome.com/e167ba4721.js"></script>
    <link rel="icon" type="image/x-icon" href="../Images/Logo_nobg.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../fonts.css">
    <link rel="stylesheet" href="../media.css">
</head>



<body>

    <section class="loginPage registerPage">
        <div class="box">
            <div class="formHeader">
                <h4>ثبت نام</h4>
            </div>
            <div class="formBox">
                <form method="post">
                    <label for="name">نام و نام خانوادگی: </label>
                    <input type="text" name="name" id="name" placeholder="حروف فارسی مثال : امیر کدخدا">
                    <br><br>
                    <label for="username">نام کاربری: </label>
                    <input type="text" name="username" id="username" placeholder="حروف انگلیسی مثال : Amir Kadkhoda">
                    <br><br>
                    <label for="email">ایمیل: </label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com">
                    <br><br>
                    <label for="mobile">شماره موبایل: </label>
                    <input type="text" name="mobile" id="mobile" placeholder="09xxxxxxxxx">
                    <br><br>
                    <label for="password">رمزعبور: </label>
                    <div class="password-box">
                        <input type="password" name="password" id="password">
                        <i class="toggle-password fa-regular fa-eye-slash" onclick="togglePasswordVisibility()"></i>
                    </div>
                    <p class="reqiure_pass">رمز عبور باید شامل حداقل : <br> * 1 حرف بزرگ <br> * 1 حرف کوچک <br> * 1 عدد <br> * و 1 حرف خاص باشد</p>
                    <br>
                    <div class="captcha_section">
                        <input type="text" name="captcha" id="captcha" placeholder="کد امنیتی">
                        <div>
                            <img id="captchaImage" src="generate_captcha.php" alt="Captcha Image">
                            <button class="regenarate_btn" type="button" onclick="regenerateCaptcha()"><i class="fa-solid fa-rotate-right"></i></button>
                        </div>
                    </div>
                    <br>
                    <input type="submit" id="submit" name="submit" value="ثبت نام">
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
                <a href="index.php">حساب کاربری دارید؟ وارد شوید</a>
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

    <script>
        function regenerateCaptcha() {
            var captchaLength = 6;
            fetch('generate_captcha.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'captcha_length=' + captchaLength,
                })
                .then(response => {
                    // Reload the captcha image
                    document.getElementById('captchaImage').src = 'generate_captcha.php';
                });
        }
    </script>

</body>
</html>