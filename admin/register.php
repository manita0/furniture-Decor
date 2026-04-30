<?php
include(__DIR__ . '/../config/constants.php');


if (isset($_SESSION['user'])) {
    header('location:' . SITEURL . 'admin/dashboard.php');
    exit();
}

define('ADMIN_SECRET_KEY', 'Furniture2025');

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    $secret_key = $_POST['secret_key'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_pwd = $_POST['confirm_password'];

    if ($secret_key !== ADMIN_SECRET_KEY) {
        $error = "Invalid secret key.";
    } elseif ($password !== $confirm_pwd) {
        $error = "Passwords do not match.";
    } elseif (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM tbl_admin WHERE email='$email' OR username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Username or email already taken.";
        } else {
            $count_res = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM tbl_admin");
            $cnt_row = mysqli_fetch_assoc($count_res);
            $role = ($cnt_row['cnt'] == 0) ? 'superadmin' : 'admin';

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO tbl_admin SET
                full_name='$full_name', username='$username',
                email='$email', password='$hashed', role='$role'";

            if (mysqli_query($conn, $sql)) {
                $success = "Registered successfully as <strong>$role</strong>.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Register - Furniture & Decor</title>
    <link rel="stylesheet" href="/furniture&Decor/css/admin.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="title">Admin Register</div>

        <?php if ($error): ?>
            <div class="error" style="text-align:center;margin-bottom:15px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success" style="text-align:center;margin-bottom:15px;"><?php echo $success; ?></div>
            <div class="input_field">
                <a href="login.php" class="auth-btn">Go to Login</a>
            </div>
        <?php else: ?>
        <form action="" method="POST" id="adminRegisterForm">
            <div class="input_field">
                <label>Full Name</label>
                <input type="text" name="full_name" class="input" placeholder="Your full name" required
                       value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Username</label>
                <input type="text" name="username" class="input" placeholder="Min 3 chars, letters & numbers only" required
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Email</label>
                <input type="email" name="email" class="input" placeholder="example@gmail.com" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Password</label>
                <input type="password" name="password" class="input" placeholder="Min 6 chars, uppercase, number & special char" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="input" placeholder="Repeat your password" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Secret Key</label>
                <input type="password" name="secret_key" class="input" placeholder="Enter the secret key" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <input type="submit" name="submit" value="Register" class="auth-btn">
            </div>
        </form>
        <?php endif; ?>

    </div>

    <script src="/furniture&Decor/js/validate.js"></script>
    <script>attachValidation('adminRegisterForm');</script>
</body>
</html>
