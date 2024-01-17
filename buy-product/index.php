<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="Images/Logo_nobg.png">
    <title>خرید محصول</title>
</head>

<body>
    <script>
        $(document).ready(function() {
            $(".gallery-container").on("swipeleft", function(event) {
                event.preventDefault();
                $(this).animate({
                    scrollLeft: "-=200px"
                }, "slow");
            });

            $(".gallery-container").on("swiperight", function(event) {
                event.preventDefault();
                $(this).animate({
                    scrollLeft: "+=200px"
                }, "slow");
            });
        });
    </script>
    <section id="navbar">
        <ul class="navbarList">
            <li class="navbatIteme"><a href="../index.php">خانه</a></li>
            <li class="navbatIteme"><a href="#">محصولات</a></li>
            <li class="navbatIteme"><a href="#">پیگیری خرید</a></li>
            <li class="navbatIteme"><a href="#">شعب</a></li>
            <li class="navbatIteme"><a href="#">درباره ما</a></li>
            <li class="navbatIteme"><a href="#">تماس با ما</a></li>
            <li class="navbatIteme"><a class="navbarLogin" href="#">ورود/ثبت نام</a></li>
        </ul>
        <a href="index.php"><img src="../Images/Logo_text-nobg_small.png" alt="coffee jack logo"></a>
    </section>
</body>
</html>