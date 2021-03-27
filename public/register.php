<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

$data['username'] = $data['password'] = $data['confirm_password'] = "";
$data['username_err'] = $data['password_err'] = $data['confirm_password_err'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $data['username_err'] = "Введите ваш логин";
    } else {
        if (!existUser(trim($_POST["username"]))) {
            $data['username_err'] = "Этот логин уже используется";
        } else {
            $data['username'] = trim($_POST["username"]);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $data['password_err'] = "Введите ваш пароль";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $data['password_err'] = "Пароль должен содержать не менее 6 символов";
    } else {
        $data['password'] = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $data['confirm_password_err'] = "Пожалуйста, подтвердите свой пароль";
    } else {
        $data['confirm_password'] = trim($_POST["confirm_password"]);
        if (empty($data['password_err']) && ($data['password'] != $data['confirm_password'])) {
            $data['confirm_password_err'] = "Подтверждение не совпадает с паролем";
        }
    }

    if (empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
        if (addUser($data['username'], $data['password'])) {
            $user = getUser($data['username']);

            if (count($user) == 1) {
                $user = reset($user);

                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $data['username'];
                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["user_role"] = $user['user_role'];
            } else {
                $data['username_err'] = "Не найден аккаунт с таким логином";
            }

            header("location: /index.php");
        } else {
            $message = "Что-то пошло не так. Попробуйте ещё раз";
        }
    }
}

$params['TITLE'] = $data['title'] = 'Регистрация';

$params['CONTENT'] = renderTemplate('register.tpl', $data);

$params['HEADER'] = renderBlock('header.php', $data);
$params['FOOTER'] = renderBlock('footer.php', $data);

display($params);