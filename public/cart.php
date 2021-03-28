<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

$user_id = 0;

if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
    $user_id = (int)$_SESSION["user_id"];
}

$addToCart = filter_input(INPUT_GET, 'addToCart', FILTER_SANITIZE_SPECIAL_CHARS);
$removeFromCart = filter_input(INPUT_GET, 'removeFromCart', FILTER_SANITIZE_SPECIAL_CHARS);

if ($addToCart || $removeFromCart) {
    $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($addToCart) {
        addToCart($product_id, $user_id);
    } elseif ($removeFromCart) {
        removeFromCart($product_id, $user_id);
    }

    header("location: /cart.php");
    exit;
}

$data['products'] = [];

if ($cart = getCart($user_id)) {
    $data['products'] = $cart['products'];
}

$params['TITLE'] = $data['title'] = 'Корзина';
$data['cart'] = $cart;

$params['CONTENT'] = renderTemplate('cart.tpl', $data);

$params['HEADER'] = renderBlock('header.php', $data);
$params['FOOTER'] = renderBlock('footer.php', $data);

display($params);