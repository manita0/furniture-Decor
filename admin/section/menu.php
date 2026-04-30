<?php 
include(__DIR__ . '/../../config/constants.php');
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    $_SESSION['no-login-message'] = "<div class='error'>Please log in to access the Admin Panel.</div>";
    header('location:' . SITEURL . 'admin/login.php');
    exit();
}
?>

<html>
    <head>
    <title>Furniture & Decor</title>
    <link rel="stylesheet" href="/furniture&Decor/css/admin.css">
    <link rel="stylesheet" href="/furniture&Decor/icon/all.min.css">
    </head>
    <body>
        <!-- menu starts -->
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="admin.php">Admin</a></li>
                    <!-- <li><a href="category.php">Category</a></li> -->
                    <li><a href="product.php">Product</a></li>
                    <li><a href="order.php">Order</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <!-- menu ends -->
</body>
</html>
