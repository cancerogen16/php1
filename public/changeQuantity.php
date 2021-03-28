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

$json = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

    $result = changeQuantity($product_id, $user_id, $quantity);

    if ($result) {
        $json = [
            'success' => '1'
        ];
    } else {
        $json = [
            'error' => '0'
        ];
    }

    echo json_encode($json);
}