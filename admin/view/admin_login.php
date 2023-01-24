<?php include '../view/header.php'; ?>


<main>

<div class="container-sm justify-content-centre">
    <h2>Admin Login</h2>

        <form action="." method="post" id="admin_login_form">
            <input type="hidden" name="action" value="login">
            
            <label>Username:</label>
            <input type="text" name="username"
                value="<?php echo htmlspecialchars($user_name); ?>" size="30">
            <p class="errors"><?php echo htmlspecialchars($user_err); ?></p><br>

            <label>Password:</label>
            <input type="password" name="password" size="30">
            <p class="errors"><?php echo htmlspecialchars($password_err); ?></p><br>

            <input type="submit" value="Login">
            <span class="errors">
                <?php echo htmlspecialchars($login_err); ?>
            </span><br>
        </form>
    </div>
</main>
<?php include '../view/footer.php'; ?>