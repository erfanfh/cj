<?php

session_start();
if (!isset($_SESSION['member_logged_in'])) {
    header("location: ../index.php");
    exit();
} else {
    if (!$_SESSION['member_logged_in']) {
        header("location: ../index.php");
        exit();
    } else {
        unset($_SESSION['member_logged_in']);
        unset($_SESSION['cart_num']);
        unset($_SESSION['using_off']);
        unset($_SESSION['total_price']);
        header("location: ../index.php");
        exit();
    }
}