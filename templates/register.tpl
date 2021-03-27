<div class="form-login">
    <h1>Регистрация</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Логин</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="field-error"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Пароль</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="field-error"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Подтверждение пароля</label>
            <input type="password" name="confirm_password" class="form-control"
                value="<?php echo $confirm_password; ?>">
            <span class="field-error"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group btns">
            <input type="submit" class="btn" value="Зарегистрироваться">
            <input type="reset" class="btn" value="Сбросить">
        </div>
        <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
    </form>
</div>

