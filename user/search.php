<?php include(__DIR__ . '/section/header.php'); ?>
<section id="search-results" class="section-p1">
    <?php $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : ''; ?>
    <h3>Search Results for "<?php echo htmlspecialchars($search); ?>"</h3>
    <div class="pro-container">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM tbl_product WHERE (title LIKE '%$search%' OR description LIKE '%$search%') AND stock > 0");
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
                    <h4>Rs <?php echo $row['price']; ?></h4>
                    <a href="/furniture&Decor/user/add-to-cart.php?product_id=<?php echo $row['id']; ?>">
                        <i id="cart" class="fa-solid fa-cart-shopping"></i>
                    </a>
                </div>
        <?php }
        } else {
            echo "<div class='error'>No products found.</div>";
        } ?>
    </div>
</section>
<?php include(__DIR__ . '/section/footer.php'); ?>
