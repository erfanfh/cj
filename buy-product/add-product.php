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

if (isset($_POST['add'])) {
    $query = $conn->prepare("SELECT * FROM users where username = ?");
    $query->bindValue(1, $_SESSION['user_username']);
    $query->execute();
    $num = $query->fetchAll();
    foreach ($num as $item) {
        $_SESSION['user_id'] = $item['id'];
    }
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];
    $pruduct_quantity = $_POST['select-quantity'];
    $product_type = $_POST['select-type'];
    $result = $conn->prepare("INSERT INTO cart VALUES (NULL, ?, ?, ?, ?, ?, NULL, NULL)");
    $result->bindValue(1, $product_id);
    $result->bindValue(2, $user_id);
    $result->bindValue(3, '0');
    $result->bindValue(4, $pruduct_quantity);
    $result->bindValue(5, $product_type);
    $stmt = $result->execute();
    if ($stmt) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

if (isset($_POST['more'])) {
    $query = $conn->prepare("SELECT * FROM users where username = ?");
    $query->bindValue(1, $_SESSION['user_username']);
    $query->execute();
    $num = $query->fetchAll();
    foreach ($num as $item) {
        $_SESSION['user_id'] = $item['id'];
    }
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];
    $pruduct_quantity = $_POST['select-quantity'];
    $product_type = $_POST['select-type'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE (product_id = ? AND user_id = ?)");
    $stmt->bindValue(1, $product_id);
    $stmt->bindValue(2, $user_id);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach ($rows as $link) {
        $old_pruduct_quantity = $link['quantity'];
    }
    $new_pruduct_quantity = $old_pruduct_quantity + $pruduct_quantity;
    $result = $conn->prepare("UPDATE `cart` SET `quantity` = ? WHERE ( `cart`.product_id = ? AND `cart`.user_id = ?)");
    $result->bindValue(1, $new_pruduct_quantity);
    $result->bindValue(2, $product_id);
    $result->bindValue(3, $user_id);
    $last = $result->execute();
    if ($last) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

if (isset($_POST['delete'])) {
    $query = $conn->prepare("SELECT * FROM users where username = ?");
    $query->bindValue(1, $_SESSION['user_username']);
    $query->execute();
    $num = $query->fetchAll();
    foreach ($num as $item) {
        $_SESSION['user_id'] = $item['id'];
    }
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];
    $pruduct_quantity = $_POST['select-quantity'];
    $product_type = $_POST['select-type'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE (product_id = ? AND user_id = ?)");
    $stmt->bindValue(1, $product_id);
    $stmt->bindValue(2, $user_id);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach ($rows as $link) {
        $old_pruduct_quantity = $link['quantity'];
    }
    $new_pruduct_quantity = $old_pruduct_quantity - $pruduct_quantity;
    $result = $conn->prepare("UPDATE `cart` SET `quantity` = ? WHERE ( `cart`.product_id = ? AND `cart`.user_id = ?)");
    $result->bindValue(1, $new_pruduct_quantity);
    $result->bindValue(2, $product_id);
    $result->bindValue(3, $user_id);
    $last = $result->execute();
    if ($last) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

if (isset($_POST['add-one'])) {
    $query = $conn->prepare("SELECT * FROM users where username = ?");
    $query->bindValue(1, $_SESSION['user_username']);
    $query->execute();
    $num = $query->fetchAll();
    foreach ($num as $item) {
        $_SESSION['user_id'] = $item['id'];
    }
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE (product_id = ? AND user_id = ?)");
    $stmt->bindValue(1, $product_id);
    $stmt->bindValue(2, $user_id);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach ($rows as $link) {
        $old_pruduct_quantity = $link['quantity'];
    }
    $new_pruduct_quantity = $old_pruduct_quantity + 1;
    $result = $conn->prepare("UPDATE `cart` SET `quantity` = ? WHERE ( `cart`.product_id = ? AND `cart`.user_id = ?)");
    $result->bindValue(1, $new_pruduct_quantity);
    $result->bindValue(2, $product_id);
    $result->bindValue(3, $user_id);
    $last = $result->execute();
    if ($last) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

if (isset($_POST['delete-one'])) {
    $query = $conn->prepare("SELECT * FROM users where username = ?");
    $query->bindValue(1, $_SESSION['user_username']);
    $query->execute();
    $num = $query->fetchAll();
    foreach ($num as $item) {
        $_SESSION['user_id'] = $item['id'];
    }
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE (product_id = ? AND user_id = ?)");
    $stmt->bindValue(1, $product_id);
    $stmt->bindValue(2, $user_id);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach ($rows as $link) {
        $old_pruduct_quantity = $link['quantity'];
    }
    $new_pruduct_quantity = $old_pruduct_quantity - 1;
    $result = $conn->prepare("UPDATE `cart` SET `quantity` = ? WHERE ( `cart`.product_id = ? AND `cart`.user_id = ?)");
    $result->bindValue(1, $new_pruduct_quantity);
    $result->bindValue(2, $product_id);
    $result->bindValue(3, $user_id);
    $last = $result->execute();
    if ($new_pruduct_quantity == 0) {
        $comnd = $conn -> prepare("DELETE FROM `cart` WHERE ( `cart`.product_id = ? AND `cart`.user_id = ?)");
        $comnd->bindValue(1, $product_id);
        $comnd->bindValue(2, $user_id);
        $comnd->execute();
    }
    if ($last) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}