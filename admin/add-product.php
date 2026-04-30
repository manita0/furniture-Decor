<?php include('section/menu.php'); ?>
<div class="maincontent">
    <div class="wrapper">
        <h1>Add Furniture</h1>

        <br><br>
        <?php
        // Display and remove add product message
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']); 
        }

        // Display and remove image upload message
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload']; 
            unset($_SESSION['upload']); 
        }
        ?>
        <!-- product form starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Furniture Title" required>
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="43" rows="4"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" required>
                    </td>
                </tr>
                <tr>
                    <td>Stock:</td>
                    <td>
                        <input type="number" name="stock" required>
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image" required>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="yes"> Yes
                        <input type="radio" name="featured" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Furniture" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- product form ends -->
        <?php
        if (isset($_POST['submit'])) {
            // 1. Get data from the form
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "no";

            // 2. Check whether an image is selected
            if (isset($_FILES['image']['name'])) {
                // Get detail of selected image name
                $image_name = $_FILES['image']['name'];
                $image_tmp = $_FILES['image']['tmp_name'];

                // Check whether the select image is clicked or not and upload the image only if it exists
                if ($image_name != "") {
                    // Generate an MD5 hash of the image content
                    $image_hash = md5_file($image_tmp);

                    // Check if the image name already exists in the database
                    $sql_check_image = "SELECT * FROM tbl_product WHERE image_hash = '$image_hash'";
                    $res_check_image = mysqli_query($conn, $sql_check_image);

                    if (mysqli_num_rows($res_check_image) > 0) {
                        // Image with the same name already exists
                        $_SESSION['upload'] = "<div class='error'>Image with the same name already exists. Please choose a different image.</div>";
                        header('location:' . SITEURL . 'admin/add-product.php');
                        die();
                    }

                    // Auto-rename the image
                    $ext = end(explode('.', $image_name));
                    // Create new name for image
                    $image_name = "Furniture_" . rand(0000, 9999) . "." . $ext;

                    // Source path is the current path of the image
                    $source_path = $_FILES['image']['tmp_name'];
                    // Destination to upload the image
                    $destination_path = "../image/" . $image_name;
                    // Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check if the image was uploaded
                    if ($upload == false) {
                        // Failed to upload image
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:' . SITEURL . 'admin/add-product.php');
                        die();
                    }
                } else {
                    $image_name = ""; // Set default value as empty
                    $image_hash = ""; // Set default value as empty
                }
            } else {
                $image_name = ""; // Set default value as empty
                $image_hash = ""; // Set default value as empty
            }

            // 3. Check if the product title already exists
            $sql_check = "SELECT * FROM tbl_product WHERE title = '$title'";
            $res_check = mysqli_query($conn, $sql_check);

            if (mysqli_num_rows($res_check) > 0) {
                // Product with the same title already exists
                $_SESSION['add'] = "<div class='error'>Product with the same title already exists.</div>";
                header('location:' . SITEURL . 'admin/add-product.php');
                die();
            }

            // 4. Insert data into the database
            $sql = "INSERT INTO tbl_product SET
                title='$title',
                description='$description',
                price='$price',
                stock='$stock',
                image_name='$image_name',
                image_hash='$image_hash',
                featured='$featured'";

            // Execute query
            $res = mysqli_query($conn, $sql);

            // Check if the query executed successfully
            if ($res == true) {
                $_SESSION['add'] = "<div class='success'>Furniture Added Successfully.</div>";
                header('location:' . SITEURL . 'admin/product.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Furniture.</div>";
                header('location:' . SITEURL . 'admin/product.php');
            }
        }
        ?>

    </div>
</div>

<?php include('section/footer.php'); ?>
