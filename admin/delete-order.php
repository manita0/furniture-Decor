<?php
  // include constants.php file here
  include(__DIR__ . '/../config/constants.php');

// Check if the `order_id` is set in the URL
if (isset($_GET['order_id'])) {
    // Get the order ID
    $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

    // SQL query to delete the order
    $sql = "DELETE FROM tbl_order WHERE id='$order_id'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // Order deleted successfully
        $_SESSION['success'] = "Order deleted successfully!";
    } else {
        // Failed to delete order
        $_SESSION['error'] = "Failed to delete order. Please try again.";
    }
} else {
    $_SESSION['error'] = "Invalid order ID.";
}

// Redirect back to the orders page
header('Location: order.php');
exit();
?>
