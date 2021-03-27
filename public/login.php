<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: /index.php");

    exit;
}

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Введите ваш логин";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Введите ваш пароль";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $user = getUser($username);

        if (count($user) == 1) {
            $user = reset($user);

            $hashed_password = $user['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["user_role"] = $user['user_role'];

                if ($user['user_role'] == 'admin') {
                    header("location: /admin/index.php");
                } else {
                    header("location: /index.php");
                }

                exit();
            } else {
                $password_err = "Пароль неверный";
            }
        } else {
            $username_err = "Не найден аккаунт с таким логином";
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
    <title>Авторизация</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
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
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/footer.php'); ?>
</body>

</html>