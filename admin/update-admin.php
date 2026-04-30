<?php include('section/menu.php'); ?>

<div class="maincontent">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>
        <?php
            // 1. Get the ID of the selected admin
            $id = $_GET['id'];

            // 2. SQL query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is executed or not
            if ($res == TRUE) {
                // Check whether the data is available or not
                $count = mysqli_num_rows($res);
                // Check whether we have admin data or not
                if ($count == 1) {
                    // Get the details 
                    $row = mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username = $row['username'];
                    $email = $row['email'];
                    $role = $row['role'];
                } else {
                    // Redirect to manage admin page
                    header('location:' . SITEURL . 'admin/admin.php');
                }
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>" placeholder="Your Username"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" value="<?php echo $email; ?>" placeholder="abc@mail.com"></td>
                </tr>
                <?php if ($role == 'superadmin') { ?>
                <input type="hidden" name="role" value="superadmin">
                <?php } else { ?>
                <input type="hidden" name="role" value="admin">
                <?php } ?>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
    // Check whether the submit button is clicked or not
    if (isset($_POST['submit'])) {
        // Get all the values from form to update
        $id = $_POST['id'];
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $role = $_POST['role'];

        // Create SQL query to update admin
        $sql = "UPDATE tbl_admin SET
            full_name='$full_name',
            username='$username',
            email='$email',
            role='$role'
            WHERE id='$id'";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed successfully or not
        if ($res == TRUE) {
            // Query executed and admin updated
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
            // Redirect to manage admin page
            header('location:' . SITEURL . 'admin/admin.php');
        } else {
            // Failed to update admin
            $_SESSION['update'] = "<div class='error'>Admin Failed to Update.</div>";
            // Redirect to manage admin page
            header('location:' . SITEURL . 'admin/admin.php');
        }
    }
?>
<?php include('section/footer.php'); ?>
