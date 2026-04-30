<?php
include(__DIR__ . '/section/header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /furniture&Decor/user/signin.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM tbl_order WHERE user_id = '$user_id' ORDER BY order_date DESC");
?>
<div class="order-history">
    <h3>Your Order History</h3>
    <?php if (mysqli_num_rows($res) > 0):
        while ($row = mysqli_fetch_assoc($res)): ?>
        <div class="order">
            <p><strong>Order ID:</strong> <?php echo $row['id']; ?></p>
            <p><strong>Product:</strong> <?php echo htmlspecialchars($row['product_name']); ?></p>
            <p><strong>Price:</strong> Rs <?php echo $row['price']; ?></p>
            <p><strong>Quantity:</strong> <?php echo $row['qty']; ?></p>
            <p><strong>Total:</strong> Rs <?php echo $row['total']; ?></p>
            <p><strong>Order Date:</strong> <?php echo $row['order_date']; ?></p>
            <p class="order-status"><strong>Status:</strong> <?php echo ucfirst($row['status']); ?></p>
        </div>
    <?php endwhile;
    else: ?>
        <p>You have no orders.</p>
    <?php endif; ?>
</div>
<?php include(__DIR__ . '/section/footer.php'); ?>
