<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

$user_id = 0;

$data['username'] = $data['phone'] = $data['address'] = "";
$data['username_err'] = $data['phone_err'] = $data['address_err'] = "";

if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
    $user_id = (int)$_SESSION["user_id"];

    $data['username'] = $_SESSION["username"];
}

$data['products'] = [];

if ($cart = getCart($user_id)) {
    $data['products'] = $cart['products'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $data['username_err'] = "Введите ваше имя";
    } else {
        $data['username'] = trim($_POST["username"]);
    }

    if (empty(trim($_POST["phone"]))) {
        $data['phone_err'] = "Введите ваш телефон";
    } else {
        $data['phone'] = trim($_POST["phone"]);
    }

    if (empty(trim($_POST["address"]))) {
        $data['address_err'] = "Введите ваш адрес";
    } else {
        $data['address'] = trim($_POST["address"]);
    }

    if (empty($data['username_err']) && empty($data['phone_err']) && empty($data['address_err'])) {
        $data['order_status_id'] = '2'; // В обработке
        $data['count'] = $cart['count'];
        $data['total'] = $cart['total'];

        $order_id = addOrder($data);

        if ($order_id) {
            header("location: /success.php");
            exit;
        }
    }
}

$params['TITLE'] = $data['title'] = 'Оформление заказа';
$data['cart'] = $cart;

$params['CONTENT'] = renderTemplate('order.tpl', $data);

$params['HEADER'] = renderBlock('header.php', $data);
$params['FOOTER'] = renderBlock('footer.php', $data);

display($params);