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

if (!isset($_GET['id'])) {
    header("location: ../index.php");
    exit();
}

$result = $conn->prepare("DELETE FROM cart WHERE (status = '0' AND user_id = ? AND product_id = ?)");
$result->bindValue(1, $_SESSION['user_id']);
$result->bindValue(2, $_GET['id']);

if ($result -> execute()) {
    header("location: index.php");
    exit();
}