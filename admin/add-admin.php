<?php include('section/menu.php');?>
<div class="maincontent">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>
        <?php
            if(isset($_SESSION['add'])){ //checking whether the session is set or not
                echo $_SESSION['add']; //display session message if set
                unset ($_SESSION['add']); //remove session message
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" placeholder="Your Username" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" placeholder="abc@mail.com"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="Password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>
                        <select name="role">
                            <option value="admin">Admin</option>
                            <?php
                            // Check if there is already a superadmin
                            $sql_check_superadmin = "SELECT * FROM tbl_admin WHERE role = 'superadmin'";
                            $res_check_superadmin = mysqli_query($conn, $sql_check_superadmin);
                            if (mysqli_num_rows($res_check_superadmin) == 0) {
                                echo '<option value="superadmin">Superadmin</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-primary">
                    </td>
                </tr>
            </table>
               
    </form>
    </div>
</div>
<?php include('section/footer.php');?>
<?php
    // process the value from form and save it in database
    // check whether the submit button is clicked or not.
    if(isset($_POST['submit'])){
    // get the data from form
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);//password encryption with MD5
    $role = $_POST['role'];
    // 1. Check if the email is empty
    if (empty($email)) {
        $_SESSION['add'] = "<div class='error'>Email cannot be empty.</div>";
        header("location:" . SITEURL . 'admin/add-admin.php');
    } else {
        // 2. Check if the email already exists
        $check_email_sql = "SELECT * FROM tbl_admin WHERE email = '$email'";
        $check_email_res = mysqli_query($conn, $check_email_sql);

        if (mysqli_num_rows($check_email_res) > 0) {
            $_SESSION['add'] = "<div class='error'>This email is already taken. Please use a different email.</div>";
            header("location:" . SITEURL . 'admin/add-admin.php');
        } else {

            // 2. sql query to save the data into database
            $sql = "INSERT INTO tbl_admin SET
                full_name='$full_name',
                username='$username',
                email='$email',
                password='$password',
                role='$role'
            ";

            //3. executing query and saving data into database.
            $res = mysqli_query($conn, $sql);

            //4. check whether the (query is executed) data is inserted or not and display appropriate message
            if($res==TRUE){
                //data inserted
                // echo "data inserted";
                // create a session variable to display message
                $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
                // redirect page to Manage Admin
                header("location:".SITEURL.'admin/admin.php');
            }else{
                // fail to insert data
                // echo "data fail";
                // create a session variable to display message
                $_SESSION['add'] = "<div class='success'>Failed to add Admin</div>";
                // redirect page to Add Admin
                header("location:".SITEURL.'admin/add-admin.php');
                }
            }
        }
    }
    ?>
