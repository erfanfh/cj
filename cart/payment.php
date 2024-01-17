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

$result = $conn -> prepare("SELECT * FROM cart WHERE (user_id = ? AND status = '0') ");
$result -> bindValue(1, $_SESSION['user_id']);
$result -> execute();
$fetch = $result -> fetchAll();
$order = "";

foreach ($fetch as $item) {
    $order .= $item['product_id'] . "(" . $item['quantity'] . ")";
}

$code = rand(10000, 99999);
$_SESSION['code'] = $code;


$query = $conn->prepare("INSERT INTO payment VALUES (NULL, ?, ?, ? , ? , ?, ?)");
$query->bindValue(1, $_SESSION['user_id']);
$query->bindValue(2, $_SESSION['price']);
$query->bindValue(3, date("Y-m-d H:i:s"));
$query->bindValue(4, '1');
$query->bindValue(5, $code);
$query->bindValue(6, $order);
$query->execute();

$stmt = $conn -> prepare("UPDATE cart SET status = '1', code = ?, date = ?  WHERE (status = '0' AND user_id = ?)");
$stmt->bindValue(1, $code);
$stmt->bindValue(2, date("Y-m-d H:i:s"));
$stmt->bindValue(3, $_SESSION['user_id']);
$stmt->execute();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../Images/Logo_nobg.png">
    <link rel="stylesheet" href="../fonts.css">
    <link rel="stylesheet" href="payment.css">
    <script src="https://kit.fontawesome.com/e167ba4721.js"></script>
    <link rel="stylesheet" href="../media.css">
    <title>تکمیل خرید</title>
</head>
<body>
    <div id="loader-container">
        <div id="loading-text">تکمیل خرید ...</div>
        <div id="loader"></div>
    </div>
    <script>
        var countdownDuration = 5;

        setTimeout(function () {
            document.getElementById("loader-container").classList.add("loaded");

            setTimeout(function () {
                window.location.href = "factor.php";
            }, countdownDuration * 1000);
        }, 2000);

        setInterval(function () {
            countdownDuration--;
            document.getElementById("loading-text").innerText = "تکمیل خرید ... " + countdownDuration + " ثانیه";
        }, 1000);
    </script>

</body>
</html>