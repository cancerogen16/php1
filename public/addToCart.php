<?php
session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

$product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

$json = [];

if ($product_id && $quantity) {
    $user_id = 0;

    if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
        $user_id = (int)$_SESSION["user_id"];
    }

    addToCart($product_id, $quantity, $user_id);

    $cart = getCart($user_id);

    $json = [
        'success' => '1',
        'products' => $cart['products'],
        'count' => $cart['count'],
        'total' => $cart['total'],
    ];
} else {
    $json = [
        'error' => '1'
    ];
}

echo json_encode($json);