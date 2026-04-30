<?php
include(__DIR__ . '/../config/constants.php');
session_destroy();
header('Location: /furniture&Decor/user/signin.php');
exit;
?>
