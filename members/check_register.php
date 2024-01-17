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



if (isset($_SESSION['register_check'])) {
    $result = $conn->prepare("SELECT * FROM users where username = ? ");
    $result->bindValue(1, $_SESSION['user_username']);
    $result->execute();
    $num = $result->fetch();
    $_SESSION['user_id'] = $num['id'];
    $_SESSION['member_logged_in'] = true;
    unset($_SESSION['register_check']);
    header("location: ../index.php");
    exit();
} else {
    header("location: register.php");
    exit();
}