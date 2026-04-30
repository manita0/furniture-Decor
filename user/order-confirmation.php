<?php include(__DIR__ . '/section/header.php'); ?>
<div class="confirmation-message">Your order has been placed successfully!</div>
<div style="text-align:center;">
    <div class="receipt">
        <p><strong>Order ID(s):</strong> <?php echo htmlspecialchars($_GET['order_ids'] ?? ''); ?></p>
        <p><strong>Date Issued:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        <p><strong>Total Items:</strong> <?php echo htmlspecialchars($_GET['total_items'] ?? ''); ?></p>
        <p><strong>Total Price:</strong> Rs <?php echo htmlspecialchars($_GET['total_price'] ?? ''); ?></p>
    </div>
    <br>
    &nbsp;
</div>
<?php include(__DIR__ . '/section/footer.php'); ?>
