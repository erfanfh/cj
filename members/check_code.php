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

if (!isset($_SESSION['check_code'])) {
    header("location: ../index.php");
    exit();
} else {
    if (isset($_POST['submit'])) {
        $valid_code = $_SESSION['valid_code'];
        $entered_code = $_POST['code'];
        $name = $_SESSION['user_name'];
        $username = $_SESSION['user_username'];
        $email = $_SESSION['user_email'];
        $mobile = $_SESSION['user_mobile'];
        $password = $_SESSION['user_password'];

        if ($entered_code == $valid_code) {
            $query = $conn->prepare("INSERT INTO users VALUES (NULL, ?, ?, ?, ?, ?)");
            $query->bindValue(1, $name);
            $query->bindValue(2, $username);
            $query->bindValue(3, $email);
            $query->bindValue(4, $mobile);
            $query->bindValue(5, $password);
            $stmt = $query->execute();
            $_SESSION['register_check'] = true;

            if ($stmt) {
                unset($_SESSION['user_password']);
                header("location: check_register.php");
                exit;
            }
            header("");
            exit();
        } else {
            $_SESSION['error_message'] = "کد تایید اشتباه است";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کد تایید</title>
    <script src="https://kit.fontawesome.com/e167ba4721.js"></script>
    <link rel="icon" type="image/x-icon" href="../Images/Logo_nobg.png">
    <link rel="stylesheet" href="../members/style.css">
    <link rel="stylesheet" href="../fonts.css">
    <link rel="stylesheet" href="../media.css">
</head>

<body>
    <section class="loginPage">
        <div class="box">
            <div class="formHeader">
                <h4>تایید شماره تلفن همراه</h4>
            </div>
            <div class="formBox">
                <form method="post">
                    <label for="name">کد تایید: </label>
                    <input type="text" name="code" id="name" placeholder="123456">
                    <input style="margin-top: 1rem;" type="submit" id="submit" name="submit" value="ثبت نام">
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
        </div>
        <div class="logo">
            <a href='../index.php'>
                <img src="../Images/Logo_text-nobg_small.png" alt="Logo Coffee JAck">
            </a>
        </div>
    </section>
</body>

</html>