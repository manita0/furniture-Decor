<?php
include(__DIR__ . '/section/header.php');
if (isset($_POST['signin'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $res = mysqli_query($conn, "SELECT * FROM tbl_users WHERE email='$email'");
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            header('Location: /furniture&Decor/user/furniture.php');
            exit;
        } else { $error = "Invalid Email or Password."; }
    } else { $error = "Invalid Email or Password."; }
}
?>
<?php if (isset($_GET['message']) && $_GET['message'] == 'password_updated'): ?>
    <div class="success">Password updated successfully. Please sign in.</div>
<?php endif; ?>
<?php if (isset($error)): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

<div class="container" id="signin">
    <div class="title">Sign In</div>
    <form method="POST" action="" id="signinForm">
        <div class="form">
            <div class="input_field">
                <label>Email</label>
                <input type="email" class="input" name="email" placeholder="example@gmail.com" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Password</label>
                <input type="password" class="input" name="password" placeholder="Enter your password" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <input type="submit" value="Sign In" name="signin" class="btn">
            </div>
            <p>Don't have an account?</p>
            <div class="input_field"><a href="/furniture&Decor/user/register.php" class="btn">Sign Up</a></div>
            <p><a href="/furniture&Decor/user/forgot-password.php" class="btn">Forgot Password?</a></p>
        </div>
    </form>
</div>
<script src="/furniture&Decor/js/validate.js"></script>
<script>attachValidation('signinForm');</script>
<?php include(__DIR__ . '/section/footer.php'); ?>
