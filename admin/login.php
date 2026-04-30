<?php include(__DIR__ . '/../config/constants.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - Furniture & Decor</title>
    <link rel="stylesheet" href="/furniture&Decor/css/admin.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="title">Admin Login</div>

        <?php
        if (isset($_SESSION['login'])) { echo $_SESSION['login']; unset($_SESSION['login']); }
        if (isset($_SESSION['no-login-message'])) { echo $_SESSION['no-login-message']; unset($_SESSION['no-login-message']); }
        ?>

        <form action="" method="POST" id="adminLoginForm">
            <div class="input_field">
                <label>Username</label>
                <input type="text" name="username" class="input" placeholder="Enter username" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Password</label>
                <input type="password" name="password" class="input" placeholder="Enter password" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <input type="submit" name="submit" value="Login" class="auth-btn">
            </div>
        </form>

        <div class="auth-link">
            <a href="register.php">Register/Sign-Up</a>
        </div>
    </div>

    <script src="/furniture&Decor/js/validate.js"></script>
    <script>attachValidation('adminLoginForm');</script>
</body>
</html>
<?php
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $res = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username='$username'");

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user']  = $username;
            header('location:' . SITEURL . 'admin/dashboard.php');
        } else {
            $_SESSION['login'] = "<div class='error'>Username or Password doesn't match.</div>";
            header('location:' . SITEURL . 'admin/login.php');
        }
    } else {
        $_SESSION['login'] = "<div class='error'>Username or Password doesn't match.</div>";
        header('location:' . SITEURL . 'admin/login.php');
    }
}
?>
