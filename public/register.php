<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

require __DIR__ . '/../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Введите ваш логин";
    } else {
        if (!existUser(trim($_POST["username"]))) {
            $username_err = "Этот логин уже используется";
        } else {
            $username = trim($_POST["username"]);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Введите ваш пароль";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Пароль должен содержать не менее 6 символов";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Пожалуйста, подтвердите свой пароль";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Подтверждение не совпадает с паролем";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        if (addUser($username, $password)) {
            $user = getUser($username);

            if (count($user) == 1) {
                $user = reset($user);

                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["user_role"] = $user['user_role'];
            } else {
                $username_err = "Не найден аккаунт с таким логином";
            }

            header("location: /index.php");
        } else {
            $message = "Что-то пошло не так. Попробуйте ещё раз";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <div class="form-signin">
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
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/footer.php'); ?>
</body>

</html>