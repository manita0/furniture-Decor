<?php 
include('section/menu.php'); 
?>

<div class="maincontent">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        
        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="new password" required>
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirm password" required>
                    </td>
                </tr>
                <tr>
                    <td colspan ="2" >
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    // check whether the submit button is clicked or not
    if(isset($_POST['submit'])){
        // 1. Get the data from the form
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // 2. Check if the new password and confirm password match
        if ($new_password == $confirm_password) {
            // Hashing the new password before storing
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);


            // 3. Update the password if they match
            $sql = "UPDATE tbl_admin SET password=? WHERE id=?";

            // Prepare the query to avoid SQL injection
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'si', $hashed_password, $id);

            // Execute the query
            $res = mysqli_stmt_execute($stmt);

            // Check whether the query executed successfully or not
            if ($res == true) {
                // Display success message
                $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                header('location:' . SITEURL . 'admin/admin.php');
                exit();
            } else {
                // Display error message
                $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                header('location:' . SITEURL . 'admin/admin.php');
                exit();
            }
        } else {
            // Passwords don't match
            $_SESSION['pwd-not-match'] = "<div class='error'>Password didn't match.</div>";
            header('location:' . SITEURL . 'admin/admin.php');
            exit();
        }
    }
?>

<?php include('section/footer.php') ?>
