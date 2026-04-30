<?php include('section/menu.php'); ?>
<div class="maincontent">
    <div class="wrapper">
        <h1>Manage Product</h1>
        <br> <br>
        <a href="<?php echo SITEURL;?>admin/add-product.php" class="btn-primary"><i class="fa-solid fa-cart-plus"></i></a>
        <br> <br> <br>

        <?php
        // Display success or error messages (if any)
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['unauthorized'])) {
            echo $_SESSION['unauthorized'];
            unset($_SESSION['unauthorized']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>

        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Stock</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>

            <?php
            // Fetch data from the database
            $sql = "SELECT * FROM tbl_product";
            $res = mysqli_query($conn, $sql);

            if ($res == true) {
                $sn = 1; // Serial Number
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    // Products available
                    while ($row = mysqli_fetch_assoc($res)) {
                        // getting the value from database and displaying it.
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $stock = $row['stock'];
                        $featured = $row['featured'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>Rs <?php echo $price; ?></td>
                            <td>
                                <?php 
                                if ($image_name != "") {
                                    // Displaying the image
                                    ?>
                                    <img src="<?php echo SITEURL;?>/image/<?php echo $image_name; ?>" width="100px">
                                    <?php
                                } else {
                                    // Image not available
                                    echo "<div class='error'>Image Not Added.</div>";
                                }
                                ?>
                            </td>
                            <td><?php echo $stock; ?></td>
                            <td><?php echo $featured; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-product.php?id=<?php echo $id; ?>" class="btn-secondary"><i class="fa-solid fa-gear"></i></a>
                                <!-- id is added to know which value is deleted -->
                                <a href="<?php echo SITEURL; ?>admin/delete-product.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    // No products available
                    ?>
                    <tr>
                        <td colspan="7"><div class='error'>No Furniture Added.</div></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>
<?php include('section/footer.php'); ?>
