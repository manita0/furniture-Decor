<?php
include(__DIR__ . '/section/header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /furniture&Decor/user/signin.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// handle order placement
if (isset($_POST['place_order'])) {
    $res_cart = mysqli_query($conn, "SELECT tbl_cart.*, tbl_product.title, tbl_product.price
        FROM tbl_cart JOIN tbl_product ON tbl_cart.product_id = tbl_product.id
        WHERE tbl_cart.user_id = '$user_id'");

    $user_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_users WHERE id='$user_id'"));

    if (mysqli_num_rows($res_cart) > 0 && $user_row) {
        $order_ids = [];
        $total_items = 0;
        $total_price = 0;

        while ($row = mysqli_fetch_assoc($res_cart)) {
            $product_name = mysqli_real_escape_string($conn, $row['title']);
            $price = $row['price'];
            $qty = $row['quantity'];
            $total_item_price = $price * $qty;
            $customer_name = mysqli_real_escape_string($conn, $user_row['name']);
            $customer_email = mysqli_real_escape_string($conn, $user_row['email']);
            $customer_address = mysqli_real_escape_string($conn, $user_row['address']);
            $customer_phone = mysqli_real_escape_string($conn, $user_row['phone'] ?? '');

            $sql = "INSERT INTO tbl_order (user_id, product_name, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address)
                    VALUES ('$user_id', '$product_name', '$price', '$qty', '$total_item_price', NOW(), 'ordered', '$customer_name', '$customer_phone', '$customer_email', '$customer_address')";

            if (mysqli_query($conn, $sql)) {
                $order_ids[] = mysqli_insert_id($conn);
                $total_items += $qty;
                $total_price += $total_item_price;
                mysqli_query($conn, "UPDATE tbl_product SET stock = stock - $qty WHERE id = '{$row['product_id']}'");
            }
        }

        mysqli_query($conn, "DELETE FROM tbl_cart WHERE user_id = '$user_id'");
        header('Location: /furniture&Decor/user/order-confirmation.php?order_ids=' . implode(',', $order_ids) . '&total_items=' . $total_items . '&total_price=' . $total_price);
        exit;
    }
}

$res = mysqli_query($conn, "SELECT tbl_cart.*, tbl_product.title, tbl_product.price, tbl_product.image_name
    FROM tbl_cart JOIN tbl_product ON tbl_cart.product_id = tbl_product.id
    WHERE tbl_cart.user_id = '$user_id'");
?>
<section id="cart">
    <h3>Your Cart</h3>
    <?php
    if (isset($_SESSION['out_of_stock'])) { echo "<div class='error'>".$_SESSION['out_of_stock']."</div>"; unset($_SESSION['out_of_stock']); }
    if (isset($_SESSION['item_exists']))  { echo "<div class='error'>".$_SESSION['item_exists']."</div>";  unset($_SESSION['item_exists']); }
    ?>
    <table>
        <thead>
            <tr><td>SN</td><td>Image</td><td>Product</td><td>Price</td><td>Quantity</td><td>Total</td><td>Action</td></tr>
        </thead>
        <tbody>
        <?php
        $grand_total = 0;
        if (mysqli_num_rows($res) > 0) {
            $sn = 1;
            mysqli_data_seek($res, 0);
            while ($row = mysqli_fetch_assoc($res)) {
                $item_total = $row['price'] * $row['quantity'];
                $grand_total += $item_total;
        ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><img src="/furniture&Decor/image/<?php echo $row['image_name']; ?>" alt=""></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td>Rs <?php echo $row['price']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td>Rs <?php echo $item_total; ?></td>
                <td class="action-buttons">
                    <form method="POST" action="/furniture&Decor/user/update-quantity.php">
                        <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="quantity" value="<?php echo $row['quantity'] + 1; ?>">
                        <button type="submit">+</button>
                    </form>
                    <form method="POST" action="/furniture&Decor/user/<?php echo $row['quantity'] > 1 ? 'update-quantity.php' : 'remove-from-cart.php'; ?>">
                        <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="quantity" value="<?php echo max(0, $row['quantity'] - 1); ?>">
                        <button type="submit">-</button>
                    </form>
                </td>
            </tr>
        <?php }
        } else {
            echo "<tr><td colspan='7' class='error'>Your cart is empty.</td></tr>";
        } ?>
        </tbody>
        <?php if (mysqli_num_rows($res) > 0): ?>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">Grand Total</td>
                <td>Rs <?php echo $grand_total; ?></td>
                <td></td>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>

    <?php if (mysqli_num_rows($res) > 0): ?>
    <form method="POST" action="">
        <input type="submit" name="place_order" value="Proceed to Payment" class="btn">
    </form>
    <?php endif; ?>
</section>
<?php include(__DIR__ . '/section/footer.php'); ?>
