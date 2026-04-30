<?php include('section/menu.php'); ?>
<div class="maincontent">
    <div class="wrapper">
        <h1>Manage Orders</h1>
        <br><br>

        <?php
        // Display success or error messages (if any)
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        ?>
        <br><br>

        <!-- Filter Buttons -->
        <a href="?status=all" class="btn-primary">All</a>
        <a href="?status=pending" class="btn-primary"><i class="fa-solid fa-plane-circle-exclamation"></i></a>
        <a href="?status=shipped" class="btn-primary"><i class="fa-solid fa-plane-departure"></i></a>
        <a href="?status=delivered" class="btn-primary"><i class="fa-solid fa-plane-arrival"></i></a>
        <a href="?status=cancelled" class="btn-primary"><i class="fa-solid fa-plane-slash"></i></a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Customer Details</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php
            // Get the selected status from the URL
            $status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';

            // Modify the SQL query based on the selected status
            if ($status_filter == 'all') {
                $sql = "SELECT o.*, u.phone AS customer_phone FROM tbl_order o LEFT JOIN tbl_users u ON o.user_id = u.id ORDER BY o.order_date DESC";
            } else {
                $sql = "SELECT o.*, u.phone AS customer_phone FROM tbl_order o LEFT JOIN tbl_users u ON o.user_id = u.id WHERE o.status = '$status_filter' ORDER BY o.order_date DESC";
            }

            $res = mysqli_query($conn, $sql);

            if ($res) {
                $count = mysqli_num_rows($res);
                $sn = 1; // Serial Number Counter

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $product_name = $row['product_name'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $customer_details = $row['customer_name'] . "<br>" . $row['customer_phone'] . "<br>" . $row['customer_email'] . "<br>" . $row['customer_address'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $product_name; ?></td>
                            <td>Rs <?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td>Rs <?php echo $total; ?></td>
                            <td><?php echo $customer_details; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td><?php echo ucfirst($status); ?></td>
                            <td>
                                <a href="update-order.php?order_id=<?php echo $id; ?>" class="btn-secondary"><i class="fa-solid fa-gear"></i></a>
                                <a href="delete-order.php?order_id=<?php echo $id; ?>" class="btn-danger" onclick="return confirm('Are you sure you want to delete this order?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "<tr><td colspan='9'><div class='error'>No Orders Found</div></td></tr>";
                }
            } else {
                echo "<tr><td colspan='9'><div class='error'>Failed to fetch data from the database.</div></td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include('section/footer.php'); ?>
