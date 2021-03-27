<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

$params['TITLE'] = $data['title'] = 'Каталог товаров';

$data['products'] = getProducts('views', 'desc');

$params['CONTENT'] = renderTemplate('catalog.tpl', $data);

$params['HEADER'] = renderBlock('header.php', $data);
$params['FOOTER'] = renderBlock('footer.php', $data);

display($params);