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

$data['username'] = $data['password'] = "";
$data['username_err'] = $data['password_err'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $data['username_err'] = "Введите ваш логин";
    } else {
        $data['username'] = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $data['password_err'] = "Введите ваш пароль";
    } else {
        $data['password'] = trim($_POST["password"]);
    }

    if (empty($data['username_err']) && empty($data['password_err'])) {
        $user = getUser($data['username']);

        if (count($user) == 1) {
            $user = reset($user);

            $hashed_password = $user['password'];

            if (password_verify($data['password'], $hashed_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $data['username'];
                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["user_role"] = $user['user_role'];

                if ($user['user_role'] == 'admin') {
                    header("location: /admin/index.php");
                } else {
                    header("location: /index.php");
                }

                exit();
            } else {
                $data['password_err'] = "Пароль неверный";
            }
        } else {
            $data['username_err'] = "Не найден аккаунт с таким логином";
        }
    }
}

$params['TITLE'] = $data['title'] = 'Авторизация';

$params['CONTENT'] = renderTemplate('login.tpl', $data);

$params['HEADER'] = renderBlock('header.php', $data);
$params['FOOTER'] = renderBlock('footer.php', $data);

display($params);