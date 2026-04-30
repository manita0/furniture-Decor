<?php
include(__DIR__ . '/../config/constants.php');

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $cart_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_id, quantity FROM tbl_cart WHERE id='$cart_id'"));
    $stock_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stock FROM tbl_product WHERE id='{$cart_row['product_id']}'"));

    mysqli_query($conn, "UPDATE tbl_product SET stock=stock+{$cart_row['quantity']} WHERE id='{$cart_row['product_id']}'");
    mysqli_query($conn, "DELETE FROM tbl_cart WHERE id='$cart_id'");
}
header('Location: /furniture&Decor/user/cart.php');
?>
