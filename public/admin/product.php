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

$errors = [];

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

$add_product = filter_input(INPUT_GET, 'add_product', FILTER_SANITIZE_SPECIAL_CHARS);

$data['title'] = 'Редактирование товара';

if ($add_product) {
    $data['title'] = 'Добавление товара';
}

$product_info = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((isset($_POST['save']) || isset($_POST['apply'])) && !$errors = validateProduct($_POST)) {
        if ($product_id) {
            editProduct($product_id, $_POST);
        } else {
            $product_id = addProduct($_POST);
        }

        if (isset($_POST['save'])) {
            header("Location: /admin/catalog.php");
        } elseif (isset($_POST['apply'])) {
            header("Location: /admin/product.php?product_id=" . $product_id);
        }

        exit();
    } elseif (isset($_POST['load_image'])) {
        $data['message'] = uploadImage();
    }
} else {
    if ($product_id) {
        $product_info = getProduct($product_id);
    }
}

if (isset($_POST['name'])) {
    $data['name'] = $_POST['name'];
} elseif (!empty($product_info)) {
    $data['name'] = $product_info['name'];
} else {
    $data['name'] = '';
}
if (isset($_POST['quantity'])) {
    $data['quantity'] = $_POST['quantity'];
} elseif (!empty($product_info)) {
    $data['quantity'] = $product_info['quantity'];
} else {
    $data['quantity'] = 0;
}
if (isset($_POST['price'])) {
    $data['price'] = $_POST['price'];
} elseif (!empty($product_info)) {
    $data['price'] = $product_info['price'];
} else {
    $data['price'] = 0;
}
if (isset($_POST['image'])) {
    $data['image'] = $_POST['image'];
} elseif (!empty($product_info)) {
    $data['image'] = $product_info['image'];
} else {
    $data['image'] = '';
}

if (isset($errors['name'])) {
    $data['name_err'] = $errors['name'];
} else {
    $data['name_err'] = '';
}

$data['product_id'] = $product_id;

$params['TITLE'] = $data['title'];

$params['CONTENT'] = renderTemplate('admin/product.tpl', $data);

$params['HEADER'] = renderBlock('admin/header.php', $data);
$params['FOOTER'] = renderBlock('admin/footer.php', $data);

display($params);