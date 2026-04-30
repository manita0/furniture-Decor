<?php include('section/menu.php'); ?>
<div class="maincontent">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br><br>

        <?php
        // Fetch the number of admins
        $sql = "SELECT COUNT(*) AS count FROM tbl_admin";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $admin_count = $row['count'];

        // Fetch the number of products
        $sql = "SELECT COUNT(*) AS count FROM tbl_product WHERE stock > 0";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $product_count = $row['count'];

        // Fetch the number of orders
        $sql = "SELECT COUNT(*) AS count FROM tbl_order";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $order_count = $row['count'];

        // Calculate revenue generated from delivered products
        $sql = "SELECT SUM(total) AS revenue FROM tbl_order WHERE status='Delivered'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $revenue_generated = $row['revenue'];

        // Calculate loss from cancelled orders
        $sql = "SELECT SUM(total) AS loss FROM tbl_order WHERE status='Cancelled'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $loss_order = $row['loss'];
        ?>

        <div class="dashboard">
            <div class="col-4 text-center dashboard-item">
                <h1><?php echo $admin_count; ?></h1>
                <br />
                <p>Admins</p>
            </div>

            <div class="col-4 text-center dashboard-item">
                <h1><?php echo $product_count; ?></h1>
                <br />
                <p>Products</p>
            </div>

            <div class="col-4 text-center dashboard-item">
                <h1><?php echo $order_count; ?></h1>
                <br />
                <p>Total Orders</p>
            </div>

            <div class="col-4 text-center dashboard-item">
                <h1><?php echo $revenue_generated; ?></h1>
                <br />
                <p>Revenue Generated</p>
            </div>

            <div class="col-4 text-center dashboard-item">
                <h1><?php echo $loss_order; ?></h1>
                <br />
                <p>Loss from Cancelled Orders</p>
            </div>

            <div class="clearfix"></div>
        </div>

        <br><br>

    </div>
</div>

<?php include('section/footer.php'); ?>
