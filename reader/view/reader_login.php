<?php include 'view/header.php'; ?>

<div>
    <h2>Reader Login</h2>

    <form action="." method="post" id="technician_login_form">
        <input type="hidden" name="action" value="login">
        
        <label>Email:</label>
        <input type="email" name="email"
               value="<?php echo htmlspecialchars($email); ?>" size="30">
        <p class="errors"><?php echo htmlspecialchars($email_err); ?></p><br>

        <label>Password:</label>
        <input type="password" name="password" size="30">
        <p class="errors"><?php echo htmlspecialchars($password_err); ?></p><br>

        <input type="submit" value="Login">
        <span class="errors">
            <?php echo htmlspecialchars($login_err); ?>
        </span><br>
    </form>
</div>
<?php include 'view/footer.php'; ?>