<?php
include(__DIR__ . '/section/header.php');
if (isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $res = mysqli_query($conn, "SELECT * FROM tbl_users WHERE email='$email'");
    if (mysqli_num_rows($res) == 1) {
        if ($new_password === $confirm_password) {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            if (mysqli_query($conn, "UPDATE tbl_users SET password='$hashed' WHERE email='$email'")) {
                header('Location: /furniture&Decor/user/signin.php?message=password_updated');
                exit;
            } else { $error = "Failed to update password. Please try again."; }
        } else { $error = "Passwords do not match."; }
    } else { $error = "No account found with that email."; }
}
?>
<?php if (isset($error)): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

<div class="container" id="reset_password">
    <div class="title">Reset Password</div>
    <form method="POST" action="" id="resetForm">
        <div class="form">
            <div class="input_field">
                <label>Email</label>
                <input type="email" class="input" name="email" placeholder="example@gmail.com" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>New Password</label>
                <input type="password" class="input" name="new_password" placeholder="Min 6 chars, uppercase, number & special char" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Confirm Password</label>
                <input type="password" class="input" name="confirm_password" placeholder="Repeat new password" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <input type="submit" value="Reset Password" name="reset_password" class="btn">
            </div>
        </div>
    </form>
</div>
<script src="/furniture&Decor/js/validate.js"></script>
<script>attachValidation('resetForm');</script>
<?php include(__DIR__ . '/section/footer.php'); ?>
