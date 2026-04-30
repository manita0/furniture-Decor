<?php include(__DIR__ . '/section/header.php'); ?>
<section id="main1">
    <br><br>
    <h2>Make your</h2>
    <h2 class="teal-heading">Home Feel</h2>
    <h2>Comfortable</h2><br><br>
    <button>SHOP NOW</button>
</section>

<?php
$toast_msg = '';
$toast_type = '';
if (isset($_SESSION['item_exists'])) {
    $toast_msg = $_SESSION['item_exists'];
    $toast_type = 'toast-warning';
    unset($_SESSION['item_exists']);
}
if (isset($_SESSION['out_of_stock'])) {
    $toast_msg = $_SESSION['out_of_stock'];
    $toast_type = 'toast-error';
    unset($_SESSION['out_of_stock']);
}
?>

<?php if ($toast_msg): ?>
<div class="toast <?php echo $toast_type; ?>" id="toast">
    <i class="fa-solid <?php echo $toast_type === 'toast-warning' ? 'fa-cart-shopping' : 'fa-circle-exclamation'; ?>"></i>
    <?php echo $toast_msg; ?>
</div>
<script>
    setTimeout(() => {
        const t = document.getElementById('toast');
        if (t) t.classList.add('toast-hide');
    }, 3000);
</script>
<?php endif; ?>

<section id="product1" class="section-p1">
    <h3>Featured Collections</h3>
    <div class="pro-container">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM tbl_product WHERE stock > 0 AND featured = 'yes' LIMIT 50");
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) { ?>
                <div class="pro">
                    <?php if ($row['image_name']): ?>
                        <img src="/furniture&Decor/image/<?php echo $row['image_name']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php else: ?>
                        <div class="error">Image Not Available.</div>
                    <?php endif; ?>
                    <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                    <h6 class="pro-desc"><?php echo htmlspecialchars($row['description']); ?></h6>
                    <div class="stock-row"><span>Stock: <?php echo $row['stock']; ?></span></div>
                    <div class="price-row"><span>Rs <?php echo $row['price']; ?></span></div>
                    <a href="/furniture&Decor/user/add-to-cart.php?product_id=<?php echo $row['id']; ?>">
                        <i id="cart" class="fa-solid fa-cart-shopping"></i>
                    </a>
                </div>
        <?php }
        } else {
            echo "<div class='error'>No featured furniture available.</div>";
        } ?>
    </div>
</section>

<?php include(__DIR__ . '/section/footer.php'); ?>
