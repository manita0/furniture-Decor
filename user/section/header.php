<?php include(__DIR__ . '/../../config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture & Decor</title>
    <link rel="icon" href="/furniture&Decor/image/f_icon.jpg" type="image/jpg">
    <link rel="stylesheet" href="/furniture&Decor/css/furniture.css">
    <link rel="stylesheet" href="/furniture&Decor/css/user.css">
    <link rel="stylesheet" href="/furniture&Decor/icon/all.min.css">
</head>
<body>
<section id="header">
    <li class="logo"><a href="/furniture&Decor/user/furniture.php">Furniture & Decor</a></li>
    <div>
        <ul id="navbar">
            <li><a href="/furniture&Decor/user/furniture.php">Home</a></li>
            <li><a href="/furniture&Decor/user/about.php">About Us</a></li>
            <li><a href="/furniture&Decor/user/contact.php">Contact Us</a></li>
            <li><a href="/furniture&Decor/user/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <li><a href="/furniture&Decor/user/order-history.php"><i class="fa-solid fa-clock-rotate-left"></i></a></li>
            <li>
                <form action="/furniture&Decor/user/search.php" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search for products...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </li>
            <li>
                <?php if (isset($_SESSION['user_name'])): ?>
                    <a class="user-name"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                    <a href="/furniture&Decor/user/logout.php" class="logout-btn">Logout</a>
                <?php else: ?>
                    <a href="/furniture&Decor/user/signin.php"><i class="fa-solid fa-user"></i> Sign In</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</section>
