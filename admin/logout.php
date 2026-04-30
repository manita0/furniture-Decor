<?php
// include constants.php for SITEURL
include(__DIR__ . '/../config/constants.php');
// 1. Destroy the Session
session_destroy(); //unsets $_SESSION['user']
// 2.Redirect to login Page
header('location:'.SITEURL.'admin/login.php');
?>