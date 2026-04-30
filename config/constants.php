<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_lifetime', 0);
    session_start();
}

if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/furniture&Decor/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'furniture');
    define('DB_PORT', 3307);
}

if (!isset($conn)) {
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT) or die(mysqli_error($conn));
}
?>
