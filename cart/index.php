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

$result = $conn->prepare("SELECT * FROM cart WHERE (status = '0' AND user_id = ?)");
$result->bindValue(1, $_SESSION['user_id']);
$result->execute();
$count = $result->rowCount();
$fetch = $result->fetchAll();

$query = $conn->prepare("SELECT * FROM cart WHERE user_id = ? && status = '0' ");
$query->bindValue(1, $_SESSION['user_id']);
$query->execute();
$row = $query->rowCount();
$_SESSION['cart_num'] = $row;

require '../search.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سبد خرید</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../fonts.css">
    <link rel="icon" type="image/x-icon" href="../Images/Logo_nobg.png">
    <script src="https://kit.fontawesome.com/e167ba4721.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="../media.css">

</head>

<body>
    <section id="navbar">
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbarList navbarListDesk">
            <li class="navbatIteme"><a href="../index.php">خانه</a></li>
            <li class="navbatIteme"><a href="#">پیگیری خرید</a></li>
            <li class="navbatIteme"><a href="#">شعب</a></li>
            <li class="navbatIteme"><a href="#">درباره ما</a></li>
            <li class="navbatIteme"><a href="#">تماس با ما</a></li>
            <?php
            if (isset($_SESSION['member_logged_in'])) {
                if (isset($_SESSION['member_name'])) {
            ?>
                    <li class="navbatIteme">
                        <a class="cartIcon" href="index.php">
                            <i class="fa-solid fa-cart-shopping"><span><?php echo $_SESSION['cart_num'] ?></span></i>
                        </a>
                    </li>
                    <li class="navbatIteme">
                        <div class="dropdown">
                            <button class="dropbtn" onclick="toggleDropdown()"><i class="fa-solid fa-caret-down"></i><?php echo " " . $_SESSION['member_name'] ?>
                            </button>
                            <div class="dropdown-content" id="dropdownOptions">
                                <a href="#">حساب کابری</a>
                                <a href="#"><i class="fa-solid fa-right-from-bracket"></i> خروج </a>
                            </div>
                        </div>
                    </li>
            <?php
                } else {
                    echo "<li class='navbatIteme'><a class='navbarLogin' href='../members/index.php'>ورود/ثبت نام</a></li>";
                }
            } else {
                echo "<li class='navbatIteme'><a class='navbarLogin' href='../members/index.php'>ورود/ثبت نام</a></li>";
            }
            ?>
        </ul>
        <ul class="navbarList navbarListMobile">
            <li class="navbatIteme"><a href="#">نوشیدنی گرم</a></li>
            <li class="navbatIteme"><a href="#">نوشیدنی سرد</a></li>
            <li class="navbatIteme"><a href="#">کیک</a></li>
            <li class="navbatIteme"><a href="#">شعب</a></li>
            <li class="navbatIteme"><a href="#">درباره ما</a></li>
            <li class="navbatIteme"><a href="#">تماس با ما</a></li>
            <?php
            if (isset($_SESSION['member_logged_in'])) {
                if (isset($_SESSION['member_name'])) {
            ?>
                    <li class="navbatIteme">
                        <a class="cartIcon" href="index.php">
                            <i class="fa-solid fa-cart-shopping"><span><?php echo $_SESSION['cart_num'] ?></span></i>
                        </a>
                    </li>
            <?php
                } else {
                    echo "<li class='navbatIteme'><a class='navbarLogin' href='../members/index.php'>ورود/ثبت نام</a></li>";
                }
            } else {
                echo "<li class='navbatIteme'><a class='navbarLogin' href='../members/index.php'>ورود/ثبت نام</a></li>";
            }
            ?>
        </ul>
        <form action="" method="post">
            <ul id="search-results"></ul>
            <input type="text" name="query" id="query" placeholder="انگلیسی سرچ کنید مثل espresso ..." autocomplete="off">
            <!-- <button type="submit" name="search_btn"><i class="fa-solid fa-magnifying-glass"></i></button> -->
        </form>
        <a href="index.php"><img src="../Images/Logo_nobg.png" alt="coffee jack logo"></a>
    </section>
    <section id="mobile_navbar">
        <ul>
            <li>
                <a href="../index.php">
                    <i class="fa-solid fa-house"></i>
                    <p>خانه</p>
                </a>
            </li>
            <li>
                <a href="../index.php">
                    <i class="fa-solid fa-shop"></i>
                    <p>فروشگاه</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa-solid fa-headset"></i>
                    <p>پیگیری</p>
                </a>
            </li>
            <li>
                <?php
                if (isset($_SESSION['member_logged_in'])) {
                ?>
                    <a href="index.php">
                        <i class="fa-solid fa-cart-shopping">
                            <?php
                            if (isset($_SESSION['cart_num'])) {
                                echo '<span style= "font-size: small; color: red">' . $_SESSION['cart_num'] . '</span>';
                            }
                            ?>
                        </i>
                        <p>سبد خرید</p>
                    </a>
                <?php
                } else {
                ?>
                    <a href="../members/index.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>سبد خرید</p>
                    </a>
                <?php
                }
                ?>
            </li>
            <li>
                <?php
                if (isset($_SESSION['member_logged_in'])) {
                ?>
                    <a href="index.php">
                        <i class="fa-solid fa-user"></i>
                        <p>حساب</p>
                    </a>
                <?php
                } else {
                ?>
                    <a href="../members/index.php">
                        <i class="fa-solid fa-user"></i>
                        <p>حساب</p>
                    </a>
                <?php
                }
                ?>
            </li>
        </ul>
    </section>
    <section id="cart-sec">
        <div class="right-cart-sec">
            <?php
            if ($fetch) {
                $total_price = 0;
                foreach ($fetch as $item) {
                    switch ($item['product_id']) {
                        case '100':
                            $product_name = 'اسپرسو';
                            $product_price = '55000';
                            $product_image = 'espresso.webp';
                            break;
                        case '101':
                            $product_name = 'دبل اسپرسو';
                            $product_price = '55000';
                            $product_image = 'espresso_2.jpg';
                            break;
                        case '102':
                            $product_name = 'کاپوچینو';
                            $product_price = '60000';
                            $product_image = 'cappuccino.webp';
                            break;
                        case '103':
                            $product_name = 'هات چاکلت';
                            $product_price = '70000';
                            $product_image = 'hot_chocolate.jpg';
                            break;
                        case '104':
                            $product_name = 'موکا';
                            $product_price = '60000';
                            $product_image = 'mocha.jpg';
                            break;
                        case '100':
                            $product_name = 'اسپرسو';
                            $product_price = '60000';
                            $product_image = 'espresso.webp';
                            break;
                        case '105':
                            $product_name = 'لته';
                            $product_price = '65000';
                            $product_image = 'latte.webp';
                            break;
                        case '106':
                            $product_name = 'آفوگاتو';
                            $product_price = '80000';
                            $product_image = 'affogato_coffee.jpg';
                            break;
                        case '107':
                            $product_name = 'ماکیاتو';
                            $product_price = '65000';
                            $product_image = 'macchiato.webp';
                            break;
                        case '108':
                            $product_name = 'کارامل ماکیاتو';
                            $product_price = '60000';
                            $product_image = 'caramel_macchiato.jpg';
                            break;
                        case '109':
                            $product_name = 'آمریکانو';
                            $product_price = '60000';
                            $product_image = 'americano_coffee.jpg';
                            break;
                    }
                    $total_price += $product_price * $item['quantity'] ;
            ?>
                    <div class="buy-item">
                        <div>
                            <div>
                                <?php
                                echo "<div class='buy-item-pic' style='background-image: url(\"../buy-product/Images/" . $product_image . "\");'></div>";
                                ?>
                            </div>
                            <div>
                                <h2><a href="#"><?php echo $product_name ?></a></h2>
                                <p><?php echo " تعداد : " . $item['quantity'] ?></p>
                            </div>
                        </div>
                        <div>
                            <div>
                                <h3><?php echo number_format($product_price * $item['quantity'], 0, '.', ',') ?> تومن </h3>
                            </div>
                            <div>
                                <a href="delete_product.php?id=<?php echo $item['product_id'] ?>" ><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    
                <?php
                }
                ?>
            <?php
            } else {
                echo "<img src='../Images/empty-cart.png' alt='empty cart'>";
            }
            ?>
        </div>
        <div class="left-cart-sec">
            <h2>اطلاعت پرداخت</h2>
            <div>
                <?php
                if (isset($_POST['set_discount'])) {
                    if ($_POST['discount'] == "14dey") {
                        $dicount = 0;
                        $discount = $total_price;
                        $old_price = $total_price;
                        $total_price *= 0.8;
                        $dicount = $discount - $total_price;
                        $_SESSION['discount_done'] = 'کد تخفیف با موفقیت اعمال شد';
                    }
                    if ($_POST['discount'] != '14dey') {
                        $_SESSION['discount_wrong'] = 'کد تخفیف اشتباه می باشد';
                    }
                }

                ?>
                <form class="discount" method = 'post'>
                    <input type = "text" name = "discount" placeholder= "کد تخفیف">
                    <button type="submit" name="set_discount">اعمال</button>
                </form>
                <?php
                if (isset($total_price)) {
                    $_SESSION['price'] = $total_price;
                }
                if (isset($_SESSION['discount_done'])) {
                    echo "<p style= 'color: green'>" . $_SESSION['discount_done'] . "</p>";
                    unset($_SESSION['discount_done']);
                }
                if (isset($_SESSION['discount_wrong'])) {
                    echo "<p style= 'color: red'>" . $_SESSION['discount_wrong'] . "</p>";
                    unset($_SESSION['discount_wrong']);
                }
                ?>
            </div>
            <hr style='border: 1px solid #e9e9e9'>
            <div>
                <div>
                    <p>جمع کل</p>
                    <p>
                    <?php
                        if (isset($old_price)) {
                            echo number_format($old_price, 0, '.', ',') . " تومان " ;                            
                        } else {
                            echo number_format($total_price, 0, '.', ',') . " تومان " ;
                        }
                    ?>
                    </p>
                </div>
                <div>
                    <p>موجودی کیف پول</p>
                    <p style= 'color: red'>0 تومن</p>
                </div>
                <div>
                    <p>تخفیف</p>
                    <p style= 'color: red'><?php echo number_format($dicount, 0, '.', ',') ?> تومن</p>
                </div>
            </div>
            <hr style='border: 1px solid #e9e9e9'>
            <div>
                <div>
                    <p>مبلغ قابل پرداخت</p>
                    <p><?php echo number_format($total_price, 0, '.', ',') . " تومان " ?></p>
                </div>
            </div>
            <div>
                <form action="payment.php" class="payment" method= "post">
                    <button type="submit" name="submit">پرداخت</button>
                </form>
            </div>
        </div>
    </section>
    <section id="footer">
        <div class="column1">
            <p>درباره ما</p>
            <div>
                <p>
                    ما یک کافه با 3 شعبه در تهران هستیم که همواره سعی کردیم بهترین هارا برای شما آماده کنیم، در کافه ما فروش
                    به صورت حضوری و اینترنتی انجام میشود که روش اینترنتی بیشتر پیشنهادمیشود.
                </p>
            </div>
        </div>
        <div class="column2">
            <p>دسترسی سریع</p>
            <ul>
                <li><a href="journeyWay.html"><i class="fa-solid fa-angle-left"></i> خرید</a></li>
                <li><a href="findMovie.html"><i class="fa-solid fa-angle-left"></i> پیگیری خرید</a></li>
                <li><a href="index.html"><i class="fa-solid fa-angle-left"></i> شعب</a></li>
                <li><a href="boxOffice.html"><i class="fa-solid fa-angle-left"></i> درباره ما</a></li>
                <li><a href="awards.html"><i class="fa-solid fa-angle-left"></i> تماس با ما</a></li>
            </ul>
        </div>
        <div class="column3">
            <p>نماد ها</p>
            <ul>
                <li><a style="width: 50%;" href="#"><img src="../Images/zarinpal.svg" alt="zarinpal logo"></a>
                </li>
                <li><a style="width: 50%;" href="#"><img style="width: 100%;" src="../Images/enamad2.png" alt="enamad logo"></a></li>
            </ul>
        </div>

    </section>
    <div>
        <div class="footerContainer">
            <hr class="footerHr" data-content="کافه جک">
        </div>
    </div>
    <section id="copyRight">
        <p>تمامی حقوق این وبسایت متعلق به کافه جک می باشد &copy;</p>
        <div>
            <ul>
                <li><a href="#" title="Instagram"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="#" title="Telegram"><i class="fa-brands fa-telegram"></i></a></li>
                <li><a href="#" title="Twitter"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="#" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
            </ul>
        </div>
    </section>
    <script src="../navbar.js"></script>
    <script src="../search.js"></script>
    <script src="../dropdown-navbar.js"></script>
</body>

</html>