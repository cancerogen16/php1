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

$order_id = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_SPECIAL_CHARS);
$delete_order = filter_input(INPUT_GET, 'delete_order', FILTER_SANITIZE_SPECIAL_CHARS);

if ($delete_order && $order_id) {
    deleteOrder($order_id);

    header("Location: /admin/orders.php");
    exit();
}

$params['TITLE'] = $data['title'] = 'Список заказов покупателей';

$data['orders'] = getOrders();

$params['CONTENT'] = renderTemplate('admin/orders.tpl', $data);

$params['HEADER'] = renderBlock('admin/header.php', $data);
$params['FOOTER'] = renderBlock('admin/footer.php', $data);

display($params);