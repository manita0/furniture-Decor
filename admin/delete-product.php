<?php
//include constants page
include(__DIR__ . '/../config/constants.php'); 

if (isset($_GET['id']) && isset($_GET['image_name'])) { //either use && or AND
    // process to delete
    //1. Get the ID and Image Name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2. Remove the physical image file if available
    if ($image_name != "") {
        // it has image and need to remove from folder.
        // get the image path.
        $path = "../image/" . $image_name;
        // remove image file from folder.
        if (file_exists($path)) {
            unlink($path);
        }
    }

    // 3.Delete from database
    $sql = "DELETE FROM tbl_product WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    // check whether the query executed or not and set the session message respectively.
    if ($res == true) {
        $_SESSION['delete'] = "<div class='success'>Product Deleted Successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Product.</div>";
    }

    header('location:' . SITEURL . '/admin/product.php');
} else {
    // else redirecting to product page
    $_SESSION['unauthorized'] = "<div class='error'>Unathorized Access.</div>";
    header('location:' . SITEURL . '/admin/product.php');
}
?>
