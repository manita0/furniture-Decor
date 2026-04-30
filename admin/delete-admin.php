<?php
    // include constants.php file here
    include(__DIR__ . '/../config/constants.php');
    //1.get the id of Admin to be deleted
    $id = $_GET['id'];
    
    // Check if this admin is a superadmin
    $check_sql = "SELECT role FROM tbl_admin WHERE id=$id";
    $check_res = mysqli_query($conn, $check_sql);
    $admin_data = mysqli_fetch_assoc($check_res);
    
    if($admin_data['role'] == 'superadmin') {
        // Cannot delete superadmin
        $_SESSION['delete'] = "<div class='error'>Cannot delete Super Administrator!</div>";
        header('location:'.SITEURL.'admin/admin.php');
        exit();
    }
    
    //2.create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id" ;
    // Execute the Query
    $res = mysqli_query($conn,$sql);
    // check whether the query executed successfully or not
    if($res==TRUE){
        // query executed successfully and admin deleted
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully</div>";
        // redirect to manage admin page
        header('location:'.SITEURL.'admin/admin.php');
    }else{
        // failed to delete admin;
        $_SESSION['delete']="<div class='error'> Failed to delete Admin. Try Again later</div>";
        header('location:'.SITEURL.'admin/admin.php');
    }
?>