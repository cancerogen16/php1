<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

$data['title'] = 'Главная страница';

if (!empty($_SESSION["username"])) {
    $data['title'] = 'Привет, <b>' . htmlspecialchars($_SESSION["username"]) . '</b>. Добро пожаловать на сайт.';
}

$params['TITLE'] = $data['title'];

$params['CONTENT'] = renderTemplate('home.tpl', $data);

$params['HEADER'] = renderBlock('header.php', $data);
$params['FOOTER'] = renderBlock('footer.php', $data);

display($params);