<body>
    <div class="card">
        <h2 class="card-heading">
            Sign up
        </h2>
        <form action="/user/post-register" class="card-form" name="signin" method="POST">
            <?php if (!empty($errorsMsg['error'])) : ?>
            <div class="error-msg"><?php echo $errorsMsg['error'] ?></div>
            <?php endif; ?>
            <div class="input">
                <input name="login" type="text" class="input-field"
                    value="<?php echo !empty($_POST['login']) ? $_POST['login'] : '' ?>" required />
                <label class="input-label">Login</label>
            </div>
            <?php if (!empty($errorsMsg['login'])) : ?>
            <div class="error-msg"><?php echo $errorsMsg['login'] ?></div>
            <?php endif; ?>
            <div class="input" id="email-field">
                <input name="email" type="text" class="input-field"
                    value="<?php echo !empty($_POST['email']) ? $_POST['email'] : '' ?>" required />
                <label class="input-label">Email</label>
            </div>
            <?php if (!empty($errorsMsg['email'])) : ?>
            <div class="error-msg"><?php echo $errorsMsg['email'] ?></div>
            <?php endif; ?>
            <div class="input">
                <input name="password" type="password" class="input-field"
                    value="<?php echo !empty($_POST['password']) ? $_POST['password'] : '' ?>" required />
                <label class="input-label">Password</label>
            </div>
            <div class="input">
                <input name="confirm_password" type="password" class="input-field" value="" required />
                <label class="input-label">Password</label>
            </div>
            <?php if (!empty($errorsMsg['password'])) : ?>
            <div class="error-msg"><?php echo $errorsMsg['password'] ?></div>
            <?php endif; ?>
            <div class="action">
                <input type="submit" value="Sign up" class="action-button">
            </div>
        </form>
        <p class="signin-link">
            If already registered —
            <a href="/signin.php" class="signin-link__link">Sign in</a>
        </p>
    </div>
</body>
<script src="/js/checkEmail.js"></script>

</html>