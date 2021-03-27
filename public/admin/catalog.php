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

$message = '';

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
$delete_product = filter_input(INPUT_GET, 'delete_product', FILTER_SANITIZE_SPECIAL_CHARS);

if ($delete_product && $product_id) {
    deleteProduct($product_id);

    header("Location: /admin/catalog.php");
    exit();
}

$params['TITLE'] = $data['title'] = 'Редактирование каталога товаров';

$data['products'] = getProducts();

$params['CONTENT'] = renderTemplate('admin/catalog.tpl', $data);

$params['HEADER'] = renderBlock('admin/header.php', $data);
$params['FOOTER'] = renderBlock('admin/footer.php', $data);

display($params);