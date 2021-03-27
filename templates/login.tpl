<div class="form-login">
    <h1>Введите логин и пароль</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Логин</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="field-error"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Пароль</label>
            <input type="password" name="password" class="form-control">
            <span class="field-error"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Войти">
        </div>
        <p>Нет учетной записи? <a href="register.php">Зарегистрироваться</a>.</p>
    </form>
</div>