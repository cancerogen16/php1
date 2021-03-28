<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

if (!isAdmin()) {
    header("Location: /login.php");
    exit();
}

$params['TITLE'] = $data['title'] = 'Панель администратора';

$params['CONTENT'] = renderTemplate('admin/home.tpl', $data);

$params['HEADER'] = renderBlock('admin/header.php', $data);
$params['FOOTER'] = renderBlock('admin/footer.php', $data);

display($params);