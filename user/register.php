<?php
include(__DIR__ . '/section/header.php');
if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $check = mysqli_query($conn, "SELECT id FROM tbl_users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "User is already registered with this email.";
    } else {
        $sql = "INSERT INTO tbl_users (name, email, password, phone, address) VALUES ('$name','$email','$password','$phone','$address')";
        if (mysqli_query($conn, $sql)) {
            header('Location: /furniture&Decor/user/signin.php');
            exit;
        } else { $error = "Failed to Register."; }
    }
}
?>
<?php if (isset($error)): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

<div class="container" id="signup">
    <div class="title">Register</div>
    <form method="POST" action="" id="signupForm">
        <div class="form">
            <div class="input_field">
                <label>Name</label>
                <input type="text" class="input" name="name" placeholder="Your full name" required
                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Email</label>
                <input type="email" class="input" name="email" placeholder="example@gmail.com" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Password</label>
                <input type="password" class="input" name="password" placeholder="Min 6 chars, uppercase, number & special char" required>
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Phone</label>
                <input type="tel" class="input" name="phone" maxlength="10" placeholder="98XXXXXXXX or 97XXXXXXXX" required
                       value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <label>Address</label>
                <input type="text" class="input" name="address" placeholder="Your address" required
                       value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                <span class="field-hint"></span>
            </div>
            <div class="input_field">
                <input type="submit" value="Sign Up" name="signup" class="btn">
            </div>
            <p>Already have an account?</p>
            <div class="input_field"><a href="/furniture&Decor/user/signin.php" class="btn">Sign In</a></div>
        </div>
    </form>
</div>
<script src="/furniture&Decor/js/validate.js"></script>
<script>attachValidation('signupForm');</script>
<?php include(__DIR__ . '/section/footer.php'); ?>
