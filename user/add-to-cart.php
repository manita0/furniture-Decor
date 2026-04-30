<?php
include(__DIR__ . '/../config/constants.php');

if (isset($_GET['product_id']) && isset($_SESSION['user_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];

    $check = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE user_id='$user_id' AND product_id='$product_id'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['item_exists'] = "Item already in your cart.";
        header('Location: /furniture&Decor/user/furniture.php');
        exit;
    } else {
        $stock_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stock FROM tbl_product WHERE id='$product_id'"));
        if ($stock_row['stock'] > 0) {
            mysqli_query($conn, "UPDATE tbl_product SET stock=stock-1 WHERE id='$product_id'");
            mysqli_query($conn, "INSERT INTO tbl_cart (user_id, product_id, quantity) VALUES ('$user_id','$product_id',1)");
            header('Location: /furniture&Decor/user/cart.php');
        } else {
            $_SESSION['out_of_stock'] = "Sorry, this product is out of stock.";
            header('Location: /furniture&Decor/user/furniture.php');
            exit;
        }
    }
} else {
    header('Location: /furniture&Decor/user/signin.php');
}
?>
