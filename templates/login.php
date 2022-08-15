<body>
    <div class="card">
        <h2 class="card-heading">
            Sign in
        </h2>
        <form action="/user/post-login" class="card-form" method="POST">
            <?php if (!empty($errorsMsg['error'])) : ?>
                <div class="error-msg"><?php echo $errorsMsg['error'] ?></div>
            <?php endif; ?>
            <div class="input">
                <input type="text" class="input-field" name="login" value="" required />
                <label class="input-label">Login</label>
            </div>
            <?php if (!empty($errorsMsg['login'])) : ?>
                <div class="error-msg"><?php echo $errorsMsg['login'] ?></div>
            <?php endif; ?>
            <div class="input">
                <input type="password" class="input-field" name="password" required value="" />
                <label class="input-label">Password</label>
            </div>
            <?php if (!empty($errorsMsg['password'])) : ?>
                <div class="error-msg"><?php echo $errorsMsg['password'] ?></div>
            <?php endif; ?>
            <label class="form-checked__label" style="display: inline-block; margin-top: 20px">
                <input type="checkbox" class="form-checked__input" name="remember" value="true" />
                Remember me
            </label>
            <div class="action">
                <input type="submit" value="Sign in" class="action-button" />
            </div>
        </form>
    </div>
</body>

</html>