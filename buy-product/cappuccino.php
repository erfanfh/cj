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

$result = $conn->prepare("SELECT * FROM cart WHERE product_id = '102' && user_id = ? && status = '0' ");
$result->bindValue(1, $_SESSION['user_id']);
$result->execute();
$num = $result->fetchAll();
foreach ($num as $link) {
    $product_num = $link['quantity'];
}

$query = $conn->prepare("SELECT * FROM cart WHERE user_id = ? && status = '0' ");
$query->bindValue(1, $_SESSION['user_id']);
$query->execute();
$row = $query->rowCount();
$_SESSION['cart_num'] = $row;

include '../search.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="buy.css">
    <link rel="stylesheet" href="../fonts.css">
    <link rel="stylesheet" href="../media.css">
    <link rel="icon" type="image/x-icon" href="../Images/Logo_nobg.png">
    <script src="https://kit.fontawesome.com/e167ba4721.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>خرید محصول</title>
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
                        <a class="cartIcon" href="../cart/index.php">
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
                        <a class="cartIcon" href="../cart/index.php">
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
        <a href="../index.php"><img src="../Images/Logo_nobg.png" alt="coffee jack logo"></a>
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
                    <a href="../cart/index.php">
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
                    <a href="../cart/index.php">
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
    <section id="buy-container">
        <section class="rightBar">
            <div class="column1" style="background-image: url(Images/cappuccino.webp)" ;>
            </div>
            <div class="column2">
                <div>
                    <h3>کاپوچینو</h3>
                    <p>محتویات : قهوه اسپرسو + شیر بخار زده + فوم شیر</p>
                    <div class="description">
                        <p>
                            کاپوچینو Cappuccino یک نوشیدنی گرم ایتالیایی است که بر پایه اسپرسو
                            تهیه می‌شود. طرز تهیه کاپوچینو در جاهای مختلف جهان
                            متفاوت است. ایتالیایی‌ها آن را با دبل اسپرسو و فوم 
                            یر تهیه می‌کنند اما این تنها طرز تهیه این نوشیدنی
                            نمی باشد و روش های مختلف دیگری وجود دارد
                            که یکی از این موارد کاپوچینوی تر می باشد که
                            در آن مقدار شیر بیشتر از فوم یا کف می باشد
                            که فوم نوشیدنی بیشتر از شیر آن می باشد.
                            در حالی که اگر در آماده کردن این نوشیدنی شیر 
                            اضافه نکنیم و روی قهوه فقط فوم شیر باشد در اصطلاح به آن کاپوچینوی خشک گفته می شود.
                        </p>
                    </div>
                    <div class="star">
                        <p>امتیاز : </p>
                        <i class="fa-regular fa-star-half-stroke"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <?php
                    if (isset($_SESSION['member_logged_in'])) {
                        if ($product_num != 0) {
                            echo '<p>قیمت نهایی: <span>' . $product_num * 60 . ' هزار تومن</span></p>';
                        } else {
                            echo '<p>قیمت : <span>55 هزار تومن</span></p>';
                        }
                    } else {
                        echo '<p>قیمت : <span>55 هزار تومن</span></p>';
                    }
                    ?>
                </div>
            </div>
            <div class="column3">
                <form method="post" action="add-product.php?product_id=102" class="buy-product">
                    <div>
                        <label for="select-nums">تعداد : </label>
                        <select name="select-quantity" class="select-nums">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div>
                        <label for="select-nums">نوع : </label>
                        <select name="select-type" class="select-nums">
                            <option value="1">ساده</option>
                        </select>
                    </div>
                    <?php
                    if ($_SESSION['member_logged_in']) {
                        if ($product_num) {
                    ?>
                            <div>
                                <input class="add-more" type="submit" name="delete" value="-"></input>
                                <?php
                                echo '<p>' . $product_num . '</p>';
                                ?>
                                <input class="add-more" type="submit" name="more" value="+"></input>
                            </div>
                    <?php
                        } else {
                            echo '<input class="add-to-cart" type="submit" name="add" value="خرید"></input>';
                        }
                    } else {
                        echo '<a href="../members/index.php" class="add-to-cart">خرید</a>';
                    }
                    ?>
                </form>
            </div>
        </section>
        <section class="leftBar">
            <h3>پرفروش ترین ها</h3>
            <div class="suggestion-box">
                <div class="item">
                    <div class="item-img">
                        <a href="#"></a>
                    </div>
                    <div class="item-text">
                        <h3><a href="#">هات چاکلت</a></h3>
                        <p>قیمت : <span>55 هزار تومن</span></p>
                    </div>
                </div>
                <div class="item">
                    <div class="item-img">
                        <a href="#"></a>
                    </div>
                    <div class="item-text">
                        <h3><a href="#">هات چاکلت</a></h3>
                        <p>قیمت : <span>55 هزار تومن</span></p>
                    </div>
                </div>
                <div class="item">
                    <div class="item-img">
                        <a href="#"></a>
                    </div>
                    <div class="item-text">
                        <h3><a href="#">هات چاکلت</a></h3>
                        <p>قیمت : <span>55 هزار تومن</span></p>
                    </div>
                </div>
                <div class="item">
                    <div class="item-img">
                        <a href="#"></a>
                    </div>
                    <div class="item-text">
                        <h3><a href="#">هات چاکلت</a></h3>
                        <p>قیمت : <span>55 هزار تومن</span></p>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <svg style="background-color: var(--dark-color);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#f3f3f3" fill-opacity="1" d="M0,64L10.4,96C20.9,128,42,192,63,192C83.5,192,104,128,125,106.7C146.1,85,167,107,188,122.7C208.7,139,230,149,250,149.3C271.3,149,292,139,313,133.3C333.9,128,355,128,376,138.7C396.5,149,417,171,438,197.3C459.1,224,480,256,501,261.3C521.7,267,543,245,563,224C584.3,203,605,181,626,149.3C647,117,668,75,689,69.3C709.6,64,730,96,751,96C772.2,96,793,64,814,69.3C834.8,75,856,117,877,149.3C897.4,181,918,203,939,218.7C960,235,981,245,1002,250.7C1022.6,256,1043,256,1064,218.7C1085.2,181,1106,107,1127,69.3C1147.8,32,1169,32,1190,37.3C1210.4,43,1231,53,1252,74.7C1273,96,1294,128,1315,149.3C1335.7,171,1357,181,1377,154.7C1398.3,128,1419,64,1430,32L1440,0L1440,0L1429.6,0C1419.1,0,1398,0,1377,0C1356.5,0,1336,0,1315,0C1293.9,0,1273,0,1252,0C1231.3,0,1210,0,1190,0C1168.7,0,1148,0,1127,0C1106.1,0,1085,0,1064,0C1043.5,0,1023,0,1002,0C980.9,0,960,0,939,0C918.3,0,897,0,877,0C855.7,0,835,0,814,0C793,0,772,0,751,0C730.4,0,710,0,689,0C667.8,0,647,0,626,0C605.2,0,584,0,563,0C542.6,0,522,0,501,0C480,0,459,0,438,0C417.4,0,397,0,376,0C354.8,0,334,0,313,0C292.2,0,271,0,250,0C229.6,0,209,0,188,0C167,0,146,0,125,0C104.3,0,83,0,63,0C41.7,0,21,0,10,0L0,0Z"></path>
    </svg>
    <section id="footer">
        <div class="column1">
            <p>درباره ما</p>
            <div>
                <p>
                    ما یک کافه با 3 شعبه در تهران هستیم که همواره سعی کردیم بهترین هارا برای شما آماده کنیم، در کافه ما فروش به صورت حضوری و اینترنتی انجام میشود که روش اینترنتی بیشتر پیشنهادمیشود.
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
                <li><a style="width: 50%;" href="journeyWay.html"><img src="../Images/zarinpal.svg" alt="zarinpal logo"></a></li>
                <li><a style="width: 50%;" href="journeyWay.html"><img style="width: 100%;" src="../Images/enamad2.png" alt="enamad logo"></a></li>
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
    <script src="../navbar.js"></script>
    <script>
        $(document).ready(function () {
            $('#query').on('input', function () {
                var query = $(this).val();

                if (query.length >= 2) {
                    // Make an AJAX request for live search
                    $.ajax({
                        url: 'affogato.php',
                        type: 'GET',
                        data: { query: query },
                        dataType: 'json',
                        success: function (data) {
                            displayResults(data);
                        }
                    });
                } else {
                    $('#search-results').empty();
                }
            });

            function displayResults(results) {
                var resultList = $('#search-results');
                resultList.empty();

                if (results.length > 0) {
                    results.forEach(function (result) {
                        resultList.append('<li><a href=buy-product/' + result.url +'>' + result.title + ' ' + result.icon + '</a></li>');
                    });
                } else {
                    resultList.append('<li>محصولی یافت نشد</li>');
                }
            }
        });
    </script>
</body>

</html>