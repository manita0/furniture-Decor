<?php 
include('section/menu.php'); 
?>

<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from the database
    $sql = "SELECT o.*, u.phone AS customer_phone FROM tbl_order o LEFT JOIN tbl_users u ON o.user_id = u.id WHERE o.id='$order_id'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $product_name = $row['product_name'];
        $price = $row['price'];
        $qty = $row['qty'];
        $total = $row['total'];
        $customer_name = $row['customer_name'];
        $customer_phone = $row['customer_phone'];
        $customer_email = $row['customer_email'];
        $customer_address = $row['customer_address'];
        $order_date = $row['order_date'];
        $status = $row['status'];
    } else {
        $_SESSION['error'] = "<div class='error'>Failed to fetch order details. Please try again.</div>";
        header('Location: order.php');
        exit();
    }
} else {
    $_SESSION['error'] = "<div class='error'>Unauthorized access!</div>";
    header('Location: order.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the status in the database
    $sql = "UPDATE tbl_order SET status='$status' WHERE id='$order_id'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // Status updated successfully
        $_SESSION['update'] = "<div class='success'>Order status updated successfully!</div>";
    } else {
        // Failed to update status
        $_SESSION['error'] = "<div class='error'>Failed to update order status. Please try again.</div>";
    }

    // Redirect back to the orders page
    header('Location: order.php');
    exit();
}
?>

<div class="maincontent">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <form method="POST" action="">
            <table class="tbl-30">
                <tr>
                    <td>Product Name</td>
                    <td><b><?php echo $product_name; ?></b></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><b>Rs <?php echo $price; ?></b></td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td><b><?php echo $qty; ?></b></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><b>Rs <?php echo $total; ?></b></td>
                </tr>
                <tr>
                    <td>Customer Name</td>
                    <td><b><?php echo $customer_name; ?></b></td>
                </tr>
                <tr>
                    <td>Customer Contact</td>
                    <td><b><?php echo $customer_phone; ?></b></td>
                </tr>
                <tr>
                    <td>Customer Email</td>
                    <td><b><?php echo $customer_email; ?></b></td>
                </tr>
                <tr>
                    <td>Customer Address</td>
                    <td><b><?php echo $customer_address; ?></b></td>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td><b><?php echo $order_date; ?></b></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status" class="dropdown">
                            <option value="ordered" <?php if ($status == 'ordered' || $status == 'Ordered') echo 'selected'; ?>>Ordered</option>
                            <option value="pending" <?php if ($status == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="shipped" <?php if ($status == 'shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="delivered" <?php if ($status == 'delivered') echo 'selected'; ?>>Delivered</option>
                            <option value="cancelled" <?php if ($status == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <input type="submit" value="Update" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('section/footer.php'); ?>
