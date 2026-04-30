<?php include('section/menu.php');?>
<html>
    <head>
    <title>Furniture & Decor</title>
    </head>
    <body>
        <!-- main content start -->
        <div class="maincontent">
         <div class="wrapper">
            <h1>Manage Admin</h1>
            <br> 
            <?php

                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];  //displaying session message
                    unset($_SESSION['add']); //removing session message
                }

                // delete admin
                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                // login pwd
                if(isset($_SESSION['login'])){
                        echo $_SESSION['login'];
                        unset ($_SESSION['login']);
                    }

                // update admin
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                
                // user not found
                if(isset($_SESSION['user-not-found'])){
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }

                // password not match
                if(isset($_SESSION['pwd-not-match'])){
                    echo $_SESSION['pwd-not-match'];
                    unset($_SESSION['pwd-not-match']);
                }

                // pwd change
                if(isset($_SESSION['change-pwd'])){
                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }
                // user login
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset ($_SESSION['login']);
                }


            ?>
            <!-- button to add admin  -->
             <br> <br>
             <a href="add-admin.php" class="btn-primary"><i class="fa-solid fa-user-plus"></i></a>
             <br> <br> <br>
            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                <?php
                    //Query to get all admin
                    $sql = "SELECT * FROM tbl_admin";
                    //execute the Query
                    $res = mysqli_query($conn,$sql);
                    // check whether the query is executed or not
                    if($res==TRUE){
                        // count rows to check whether we have data in database or not
                        $count = mysqli_num_rows($res); //function to get all the rows in database
                        $sn=1; //create a variable and assign the value
                        // check the num of rows
                        if($count>0){
                            // we have data in database
                            while($rows=mysqli_fetch_assoc($res)){
                                // using while loop to get all the data from database
                                // and while loop will run as long as we have data in database

                                // get individual data
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];
                                $email=$rows['email'];
                                $role = $rows['role'];

                                // display the values in our table
                                ?>
                                <!-- html code to display all the values -->
                                <tr>
                                    <td><?php echo $sn++;?> </td>
                                    <td><?php echo $full_name;?></td>
                                    <td><?php echo $username;?></td>
                                    <td><?php echo $email;?></td>
                                    <td><?php echo $role; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary"><i class="fa-solid fa-key"></i></i></a>
                                        <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary"><i class="fa-solid fa-user-gear"></i></a>
                                        <?php if ($role != 'superadmin') { ?>
                                        <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger"><i class="fa-solid fa-user-minus"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }else{
                            // we have not data in database
                        }
                    }
                ?>
            </table>

            </div>
        </div>
        <!-- main content ends -->
    </body>
</html>
<?php include('section/footer.php')?>
