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

if (!isset($_SESSION['member_logged_in'])) {
    header("location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir= "rtl">
<head>
    <link rel="icon" type="image/x-icon" href="../Images/Logo_nobg.png">
    <link rel="stylesheet" href="../fonts.css">
    <link rel="stylesheet" href="../media.css">
    <script src="https://kit.fontawesome.com/e167ba4721.js"></script>
    <link rel= "stylesheet" href="payment.css">
    <title>فاکتور خرید</title>
</head>

<body>
    <section id= "container">
        <div class="factor">
            <h1>پرداخت موفقیت آمیز بود <i class="fa-solid fa-circle-check"></i> </h1>
            <p>#کد پیگیری : <?php echo $_SESSION['code'] ?></p>
            <?php
                unset($_SESSION['price']);
                unset($_SESSION['code']);
            ?>
            <a href='index.php'>بازگشت به خانه</a>
        </div>
    </section>
</body>
</html>