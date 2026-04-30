<?php
include('section/menu.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "no";

    // Handle the new image if uploaded
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        // Remove old image if available
        $current_image = $_POST['current_image'];
        if ($current_image != "") {
            $path = "../image/" . $current_image;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Upload new image
        $image_name = $_FILES['image']['name'];
        $ext = end(explode('.', $image_name));
        $image_name = "Furniture_" . rand(0000, 9999) . "." . $ext;
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../image/" . $image_name;

        $upload = move_uploaded_file($source_path, $destination_path);
        if (!$upload) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
            header('location:' . SITEURL . '/admin/update-product.php?id=' . $id);
            die();
        }
    } else {
        $image_name = $_POST['current_image'];
    }

    // Update the database
    $sql = "UPDATE tbl_product SET
        title='$title',
        description='$description',
        price='$price',
        stock='$stock',
        image_name='$image_name',
        featured='$featured'
        WHERE id=$id";

    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['update'] = "<div class='success'>Product Updated Successfully.</div>";
        header('location:' . SITEURL . '/admin/product.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Product.</div>";
        header('location:' . SITEURL . '/admin/update-product.php?id=' . $id);
    }
}

// Fetch the current product details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_product WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    $title = $row['title'];
    $description = $row['description'];
    $price = $row['price'];
    $stock = $row['stock'];
    $current_image = $row['image_name'];
    $featured = $row['featured'];
} else {
    header('location:' . SITEURL . '/admin/product.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Product</title>
</head>
<body>
    <div class="maincontent">
        <div class="wrapper">
            <h1>Update Furniture</h1>
            <br><br>

            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" cols="43" rows="4"><?php echo $description; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                    </tr>
                    <tr>
                        <td>Stock:</td>
                        <td><input type="number" name="stock" value="<?php echo $stock; ?>"></td>
                    </tr>
                    <tr>
                        <td>Current Image:</td>
                        <td>
                            <?php if ($current_image != "") { ?>
                                <img src="../image/<?php echo $current_image; ?>" width="100px">
                            <?php } else { echo "No Image Available"; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Image:</td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="yes" <?php if ($featured == "yes") echo "checked"; ?>> Yes
                            <input type="radio" name="featured" value="no" <?php if ($featured == "no") echo "checked"; ?>> No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="submit" value="Update Furniture" class="btn-secondary"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
<?php include('section/footer.php'); ?>
