<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
$addToCart = filter_input(INPUT_GET, 'addToCart', FILTER_SANITIZE_SPECIAL_CHARS);

$data['title'] = '';
$data['product'] = [];

if ($product_id) {
    if ($addToCart) {
        $user_id = 0;

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
            $user_id = (int)$_SESSION["user_id"];
        }

        addToCart($product_id, $user_id);

        header("location: /product.php?product_id=$product_id");
        exit;
    }

    setViews($product_id);

    $product_info = getProduct($product_id);

    $data['title'] = $product_info['name'];

    $data['product'] = $product_info;

    $params['TITLE'] = $data['title'];
}

$params['CONTENT'] = renderTemplate('product.tpl', $data);

$params['HEADER'] = renderBlock('header.php', $data);
$params['FOOTER'] = renderBlock('footer.php', $data);

display($params);