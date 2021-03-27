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

$errors = [];

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

$add_product = filter_input(INPUT_GET, 'add_product', FILTER_SANITIZE_SPECIAL_CHARS);

$title = 'Редактирование товара';

if ($add_product) {
    $title = 'Добавление товара';
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
        $message = uploadImage();
    }
} else {
    if ($product_id) {
        $product_info = getProduct($product_id);
    }
}

if (isset($_POST['name'])) {
    $name = $_POST['name'];
} elseif (!empty($product_info)) {
    $name = $product_info['name'];
} else {
    $name = '';
}
if (isset($_POST['quantity'])) {
    $quantity = $_POST['quantity'];
} elseif (!empty($product_info)) {
    $quantity = $product_info['quantity'];
} else {
    $quantity = 0;
}
if (isset($_POST['price'])) {
    $price = $_POST['price'];
} elseif (!empty($product_info)) {
    $price = $product_info['price'];
} else {
    $price = 0;
}
if (isset($_POST['image'])) {
    $image = $_POST['image'];
} elseif (!empty($product_info)) {
    $image = $product_info['image'];
} else {
    $image = '';
}

if (isset($errors['name'])) {
    $name_err = $errors['name'];
} else {
    $name_err = '';
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование товара</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/admin/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1><?= $title ?></h1>
            <form class="product-edit" enctype="multipart/form-data" method="post" action="">
                <div class="data-wrap">
                    <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                    <input type="hidden" name="image" value="<?= $image ?>" />
                    <div class="form-group"><label for="product_name">Название товара </label>
                        <input type="text" name="name" value="<?= $name ?>" id="product_name" placeholder="Название товара" />
                        <span class="field-error"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group"><label for="product_quantity">Количество товара </label>
                        <input type="text" name="quantity" value="<?= $quantity ?>" id="product_quantity" placeholder="Количество товара" />
                    </div>
                    <div class="form-group"><label for="product_price">Цена товара </label>
                        <input type="text" name="price" value="<?= $price ?>" id="product_price" placeholder="Цена товара" />
                    </div>
                    <button type="submit" name="save" class="btn">Сохранить</button>
                    <button type="submit" name="apply" class="btn">Применить</button>
                </div>
                <div class="image-wrap">
                    <?php if (!empty($image)) : ?>
                        <img src="/img/<?= $image ?>" alt="<?= $name ?>" width="300">
                    <?php else : ?>
                        <p>Нет изображения</p>
                    <?php endif; ?>
                    <div class="upload">
                        <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                        <input type="file" name="file">
                        <button type="submit" name="load_image" class="btn">
                            <?php if (!empty($image)) : ?>
                                Заменить изображение
                            <?php else : ?>
                                Загрузить изображение
                            <?php endif; ?>
                        </button>
                    </div>

                    <div class="message"><?= $message ?></div>
                </div>
            </form>
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/admin/footer.php'); ?>

    <?php require_once(TEMPLATES_DIR . '/modal.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="/js/app.js"></script>
</body>

</html>