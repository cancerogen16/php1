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

$data['message'] = '';

$data['username'] = $data['phone'] = $data['address'] = "";
$data['username_err'] = $data['phone_err'] = $data['address_err'] = "";

$errors = [];

$order_id = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_SPECIAL_CHARS);

$data['title'] = 'Редактирование заказа №' . $order_id;

$data['order_status_id'] = 0;
$data['total'] = 0;

$order_info = [];

if ($order_id) {
    $order_info = getOrder($order_id);

    $data['order_status_id'] = $order_info['order_status_id'];
    $data['total'] = $order_info['total'];
}

$data['statuses'] = getStatuses();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((isset($_POST['save']) || isset($_POST['apply'])) && !$errors = validateOrder($_POST)) {
        if ($order_id) {
            editOrder($order_id, $_POST);
        }

        if (isset($_POST['save'])) {
            header("Location: /admin/orders.php");
        } elseif (isset($_POST['apply'])) {
            header("Location: /admin/order.php?order_id=" . $order_id);
        }

        exit();
    }
}

if (isset($_POST['username'])) {
    $data['username'] = $_POST['username'];
} elseif (!empty($order_info)) {
    $data['username'] = $order_info['username'];
} else {
    $data['username'] = '';
}
if (isset($_POST['phone'])) {
    $data['phone'] = $_POST['phone'];
} elseif (!empty($order_info)) {
    $data['phone'] = $order_info['phone'];
} else {
    $data['phone'] = 0;
}
if (isset($_POST['address'])) {
    $data['address'] = $_POST['address'];
} elseif (!empty($order_info)) {
    $data['address'] = $order_info['address'];
} else {
    $data['address'] = 0;
}
if (isset($_POST['order_products'])) {
    $data['order_products'] = $_POST['order_product'];
} elseif (!empty($order_info)) {
    $data['order_products'] = $order_info['order_products'];
} else {
    $data['order_products'] = '';
}

if (isset($errors['username'])) {
    $data['username_err'] = $errors['username'];
} else {
    $data['username_err'] = '';
}

if (isset($errors['phone'])) {
    $data['phone_err'] = $errors['phone'];
} else {
    $data['phone_err'] = '';
}

if (isset($errors['address'])) {
    $data['address_err'] = $errors['address'];
} else {
    $data['address_err'] = '';
}

$data['order_id'] = $order_id;

$params['TITLE'] = $data['title'];

$params['CONTENT'] = renderTemplate('admin/order.tpl', $data);

$params['HEADER'] = renderBlock('admin/header.php', $data);
$params['FOOTER'] = renderBlock('admin/footer.php', $data);

display($params);