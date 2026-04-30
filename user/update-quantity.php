<?php
include(__DIR__ . '/../config/constants.php');

if (isset($_POST['cart_id'], $_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];

    $cart_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_id, quantity FROM tbl_cart WHERE id='$cart_id'"));
    $stock_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stock FROM tbl_product WHERE id='{$cart_row['product_id']}'"));

    $available = $stock_row['stock'] + $cart_row['quantity'];
    if ($quantity > 0 && $quantity <= $available) {
        mysqli_query($conn, "UPDATE tbl_cart SET quantity='$quantity' WHERE id='$cart_id'");
        $new_stock = $available - $quantity;
        mysqli_query($conn, "UPDATE tbl_product SET stock='$new_stock' WHERE id='{$cart_row['product_id']}'");
    } else {
        $_SESSION['out_of_stock'] = "Product is out of stock.";
    }
}
header('Location: /furniture&Decor/user/cart.php');
?>
