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

$query = $conn->prepare("SELECT * FROM cart WHERE user_id = ? && status = '0' ");
$query->bindValue(1, $_SESSION['user_id']);
$query->execute();
$row = $query->rowCount();
$_SESSION['cart_num'] = $row;

require 'search.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P1JWF5P649"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-P1JWF5P649');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کافه جک</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="Images/Logo_nobg.png">
    <link rel="stylesheet" href="fonts.css">
    <script src="https://kit.fontawesome.com/e167ba4721.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="media.css">

</head>

<body>
    <section id="navbar">
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbarList navbarListDesk">
            <li class="navbatIteme"><a href="index.php">خانه</a></li>
            <li class="navbatIteme"><a href="#">پیگیری خرید</a></li>
            <li class="navbatIteme"><a href="#">شعب</a></li>
            <li class="navbatIteme"><a href="#">درباره ما</a></li>
            <li class="navbatIteme"><a href="#">تماس با ما</a></li>
            <?php
            if (isset($_SESSION['member_logged_in'])) {
                if (isset($_SESSION['member_name'])) {
            ?>
                    <li class="navbatIteme">
                        <a class="cartIcon" href="cart/index.php">
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
                    echo "<li class='navbatIteme'><a class='navbarLogin' href='members/index.php'>ورود/ثبت نام</a></li>";
                }
            } else {
                echo "<li class='navbatIteme'><a class='navbarLogin' href='members/index.php'>ورود/ثبت نام</a></li>";
            }
            ?>
        </ul>
        <ul class="navbarList navbarListMobile">
            <li class="navbatIteme"><a href="index.php">نوشیدنی گرم</a></li>
            <li class="navbatIteme"><a href="index.php">نوشیدنی سرد</a></li>
            <li class="navbatIteme"><a href="index.php">کیک</a></li>
            <li class="navbatIteme"><a href="#">شعب</a></li>
            <li class="navbatIteme"><a href="#">درباره ما</a></li>
            <li class="navbatIteme"><a href="#">تماس با ما</a></li>
            <?php
            if (isset($_SESSION['member_logged_in'])) {
                if (isset($_SESSION['member_name'])) {
            ?>
                    <li class="navbatIteme">
                        <a class="cartIcon" href="cart/index.php">
                            <i class="fa-solid fa-cart-shopping"><span><?php echo $_SESSION['cart_num'] ?></span></i>
                        </a>
                    </li>
            <?php
                } else {
                    echo "<li class='navbatIteme'><a class='navbarLogin' href='members/index.php'>ورود/ثبت نام</a></li>";
                }
            } else {
                echo "<li class='navbatIteme'><a class='navbarLogin' href='members/index.php'>ورود/ثبت نام</a></li>";
            }
            ?>
        </ul>
        <form action="" method="post">
            <ul id="search-results"></ul>
            <input type="text" name="query" id="query" placeholder="انگلیسی سرچ کنید مثل espresso ..." autocomplete="off">
            <!-- <button type="submit" name="search_btn"><i class="fa-solid fa-magnifying-glass"></i></button> -->
        </form>
        <a href="index.php"><img src="Images/Logo_nobg.png" alt="coffee jack logo"></a>
    </section>
    <section id="mobile_navbar">
        <ul>
            <li>
                <a href="index.php">
                    <i class="fa-solid fa-house"></i>
                    <p>خانه</p>
                </a>
            </li>
            <li>
                <a href="index.php">
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
                    <a href="cart/index.php">
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
                    <a href="members/index.php">
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
                    <a href="#">
                        <i class="fa-solid fa-user"></i>
                        <p>حساب</p>
                    </a>
                <?php
                } else {
                ?>
                    <a href="members/index.php">
                        <i class="fa-solid fa-user"></i>
                        <p>حساب</p>
                    </a>
                <?php
                }
                ?>
            </li>
        </ul>
    </section>
    <section id="header">
        <div class="rside">
            <div class="headerText">
                <h3><a href="#">خرید محصولات از طریق وبسایت و تحویل حضوری آن در کمتر از 15 دقیقه!</a></h3>
                <p>فروش به صورت حضوری نیز صورت میگیرد اما برای سهولت روش خرید اینترنتی پیشنهاد میشود</p>
            </div>
        </div>
        <div class="lside">
            <div class="lsideImg">
                <div class="headerText">
                    <h3><a href="#">خرید وبسایت و تحویل حضوری آن در کمتر از 15 دقیقه!</a></h3>
                    <p>فروش به صورت حضوررای سهولت روش خرید اینترنتی پیشنهاد میشود</p>
                </div>
            </div>
            <div class="lsideImg">
                <div class="headerText">
                    <h3><a href="#">خرید محصولات از طریق وبسایتر کمتر از 15 دقیقه!</a></h3>
                    <p>فروش به صورت حضوری نیز صورت لت روش خرید اینترنتی پیشنهاد میشود</p>
                </div>
            </div>
        </div>
    </section>
    <section id="products">
        <h2 class="section-header">محصولات (قهوه)</h2>
        <div class="productsList">
            <div class="gallery-container1">
                <div class="product" style="background-image: url(buy-product/Images/espresso.webp)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/espresso.php">
                                <h4>اسپرسو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/espresso_2.jpg)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/douespresso.php">
                                <h4>دبل اسپرسو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/cappuccino.webp)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/cappuccino.php">
                                <h4>کاپوچینو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 60 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/latte.webp);">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/latte.php">
                                <h4>لته <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 65 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/affogato_coffee.jpg)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/affogato.php">
                                <h4>آفوگاتو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 80 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/hot_chocolate.jpg)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/hot-chocolate.php">
                                <h4>هات چاکلت <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 70 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/caramel_macchiato.jpg)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/cramel-macchiato.php">
                                <h4>کارامل ماکیاتو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 60 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/americano_coffee.jpg)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/americano.php">
                                <h4>آمریکانو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 60 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/mocha.jpg)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/mocha.php">
                                <h4>موکا <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 60 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product" style="background-image: url(buy-product/Images/macchiato.webp)">
                    <div class="product-text">
                        <div>
                            <a href="buy-product/macchiato.php">
                                <h4>ماکیاتو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 65 هزار تومن</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="products">
        <h2 class="section-header">محصولات (کیک)</h2>
        <div class="productsList">
            <div class="gallery-container2">
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>اسپرسو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>هات چاکلت <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>کاپوچینو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>کارامل ماکیاتو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>لته <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h3>خرید <i class="fa-solid fa-cart-shopping"></i></h3>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h3>خرید <i class="fa-solid fa-cart-shopping"></i></h3>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h3>خرید <i class="fa-solid fa-cart-shopping"></i></h3>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section id="products">
        <h2 class="section-header">محصولات (نوشیدنی سرد)</h2>
        <div class="productsList">
            <div class="gallery-container3">
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>اسپرسو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>هات چاکلت <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>کاپوچینو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>کارامل ماکیاتو <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h4>لته <i class="fa-solid fa-cart-shopping"></i></h4>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h3>خرید <i class="fa-solid fa-cart-shopping"></i></h3>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h3>خرید <i class="fa-solid fa-cart-shopping"></i></h3>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>
                <div class="product">
                    <div class="product-text">
                        <div>
                            <a href="#">
                                <h3>خرید <i class="fa-solid fa-cart-shopping"></i></h3>
                            </a>
                            <p>قیمت : 55 هزار تومن</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#f3f3f3" fill-opacity="1" d="M0,96L16,90.7C32,85,64,75,96,101.3C128,128,160,192,192,181.3C224,171,256,85,288,69.3C320,53,352,107,384,133.3C416,160,448,160,480,176C512,192,544,224,576,202.7C608,181,640,107,672,80C704,53,736,75,768,122.7C800,171,832,245,864,234.7C896,224,928,128,960,122.7C992,117,1024,203,1056,202.7C1088,203,1120,117,1152,74.7C1184,32,1216,32,1248,42.7C1280,53,1312,75,1344,96C1376,117,1408,139,1424,149.3L1440,160L1440,0L1424,0C1408,0,1376,0,1344,0C1312,0,1280,0,1248,0C1216,0,1184,0,1152,0C1120,0,1088,0,1056,0C1024,0,992,0,960,0C928,0,896,0,864,0C832,0,800,0,768,0C736,0,704,0,672,0C640,0,608,0,576,0C544,0,512,0,480,0C448,0,416,0,384,0C352,0,320,0,288,0C256,0,224,0,192,0C160,0,128,0,96,0C64,0,32,0,16,0L0,0Z"></path>
    </svg>
    <section id="location-container">
        <h2 class="section-header">شعب</h2>
        <div class="location">
            <div class="location-detail">
                <h3>شعبه سعادت آباد</h3>
                <div class="address-box">
                    <p>تهران، سعادت آباد، میدان کاج، خیابان آهو، جنت پاساژ پارسیان</p>
                    <div class="apps-box">
                        <div class="navigate-apps">
                            <a href="#">Google Map <i class="fa-solid fa-location-dot"></i></a>
                        </div>
                        <div class="navigate-apps">
                            <a href="#">Waze <i class="fa-brands fa-waze"></i></a>
                        </div>
                        <div class="navigate-apps">
                            <a href="#">Neshan <i class="fa-regular fa-compass"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="location-detail">
                <h3>شعبه صادقیه</h3>
                <div class="address-box">
                    <p>تهران، صادقیه، بلوار فردوس، جنت خیابان تقدیدی</p>
                    <div class="apps-box">
                        <div class="navigate-apps">
                            <a href="#">Google Map <i class="fa-solid fa-location-dot"></i></a>
                        </div>
                        <div class="navigate-apps">
                            <a href="#">Waze <i class="fa-brands fa-waze"></i></a>
                        </div>
                        <div class="navigate-apps">
                            <a href="#">Neshan <i class="fa-regular fa-compass"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="location-detail">
                <h3>شعبه جنت آباد</h3>
                <div class="address-box">
                    <p>تهران، جنت آباد جنوبی، لاله غربی، جنت پاساژ سمرقند</p>
                    <div class="apps-box">
                        <div class="navigate-apps">
                            <a href="#">Google Map <i class="fa-solid fa-location-dot"></i></a>
                        </div>
                        <div class="navigate-apps">
                            <a href="#">Waze <i class="fa-brands fa-waze"></i></a>
                        </div>
                        <div class="navigate-apps">
                            <a href="#">Neshan <i class="fa-regular fa-compass"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#f3f3f3" fill-opacity="1" d="M0,64L16,90.7C32,117,64,171,96,197.3C128,224,160,224,192,218.7C224,213,256,203,288,181.3C320,160,352,128,384,149.3C416,171,448,245,480,272C512,299,544,277,576,256C608,235,640,213,672,186.7C704,160,736,128,768,117.3C800,107,832,117,864,154.7C896,192,928,256,960,256C992,256,1024,192,1056,138.7C1088,85,1120,43,1152,53.3C1184,64,1216,128,1248,133.3C1280,139,1312,85,1344,69.3C1376,53,1408,75,1424,85.3L1440,96L1440,320L1424,320C1408,320,1376,320,1344,320C1312,320,1280,320,1248,320C1216,320,1184,320,1152,320C1120,320,1088,320,1056,320C1024,320,992,320,960,320C928,320,896,320,864,320C832,320,800,320,768,320C736,320,704,320,672,320C640,320,608,320,576,320C544,320,512,320,480,320C448,320,416,320,384,320C352,320,320,320,288,320C256,320,224,320,192,320C160,320,128,320,96,320C64,320,32,320,16,320L0,320Z"></path>
    </svg>
    <section id="track-container">
        <h2 class="section-header">پیگیری خرید</h2>
        <div class="track-box">
            <h2>شماره موبایل خود را وارد کنید...</h2>
            <form method="post">
                <input placeholder="09xxxxxxxxx" type="tel" name="mobile">
                <input type="submit" name="submit" value="پیگیری">
            </form>
        </div>
    </section>
    <svg style="background-color: var(--dark-color);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#f3f3f3" fill-opacity="1" d="M0,64L10.4,96C20.9,128,42,192,63,192C83.5,192,104,128,125,106.7C146.1,85,167,107,188,122.7C208.7,139,230,149,250,149.3C271.3,149,292,139,313,133.3C333.9,128,355,128,376,138.7C396.5,149,417,171,438,197.3C459.1,224,480,256,501,261.3C521.7,267,543,245,563,224C584.3,203,605,181,626,149.3C647,117,668,75,689,69.3C709.6,64,730,96,751,96C772.2,96,793,64,814,69.3C834.8,75,856,117,877,149.3C897.4,181,918,203,939,218.7C960,235,981,245,1002,250.7C1022.6,256,1043,256,1064,218.7C1085.2,181,1106,107,1127,69.3C1147.8,32,1169,32,1190,37.3C1210.4,43,1231,53,1252,74.7C1273,96,1294,128,1315,149.3C1335.7,171,1357,181,1377,154.7C1398.3,128,1419,64,1430,32L1440,0L1440,0L1429.6,0C1419.1,0,1398,0,1377,0C1356.5,0,1336,0,1315,0C1293.9,0,1273,0,1252,0C1231.3,0,1210,0,1190,0C1168.7,0,1148,0,1127,0C1106.1,0,1085,0,1064,0C1043.5,0,1023,0,1002,0C980.9,0,960,0,939,0C918.3,0,897,0,877,0C855.7,0,835,0,814,0C793,0,772,0,751,0C730.4,0,710,0,689,0C667.8,0,647,0,626,0C605.2,0,584,0,563,0C542.6,0,522,0,501,0C480,0,459,0,438,0C417.4,0,397,0,376,0C354.8,0,334,0,313,0C292.2,0,271,0,250,0C229.6,0,209,0,188,0C167,0,146,0,125,0C104.3,0,83,0,63,0C41.7,0,21,0,10,0L0,0Z"></path>
    </svg>
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
                <li><a style="width: 50%;" href="journeyWay.html"><img src="Images/zarinpal.svg" alt="zarinpal logo"></a>
                </li>
                <li><a style="width: 50%;" href="journeyWay.html"><img style="width: 100%;" src="Images/enamad2.png" alt="enamad logo"></a></li>
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
                <li><a href="index.html" title="Instagram"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="index.html" title="Telegram"><i class="fa-brands fa-telegram"></i></a></li>
                <li><a href="index.html" title="Twitter"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="index.html" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
            </ul>
        </div>
    </section>
    <script src="gallery.js"></script>
    <script src="navbar.js"></script>
    <script src="search.js"></script>
    <script src="dropdown-navbar.js"></script>
</body>

</html>