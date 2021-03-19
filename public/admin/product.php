<?php
require __DIR__ . '/../../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

$add_product = filter_input(INPUT_GET, 'add_product', FILTER_SANITIZE_SPECIAL_CHARS);

$title = 'Редактирование товара';

if ($add_product) {
    $title = 'Добавление товара';
}

$product_info = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($product_id) {
        editProduct($product_id, $_POST);
    } else {
        $product_id = addProduct($_POST);
    }
} else {
    if ($product_id) {
        $product_info = getProduct($product_id)[0];
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

            <div class="section">
                <div class="image-wrap">
                    <form enctype="multipart/form-data" method="post">
                        <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                        <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                        <div class="product-edit">
                            <div class="product-info">
                                <div class="form-group"><label for="product_name">Название товара </label>
                                    <input type="text" name="name" value="<?= $name ?>" id="product_name"
                                        placeholder="Название товара" />
                                </div>
                                <div class="form-group"><label for="product_quantity">Количество товара </label>
                                    <input type="text" name="quantity" value="<?= $quantity ?>" id="product_quantity"
                                        placeholder="Количество товара" />
                                </div>
                                <div class="form-group"><label for="product_price">Цена товара </label>
                                    <input type="text" name="price" value="<?= $price ?>" id="product_price"
                                        placeholder="Цена товара" />
                                </div>

                            </div>
                            <div class="product-image">
                                Изображение товара
                                <?php if (!empty($image)) : ?>
                                <img class="product-image" src="/img/<?= $image ?>" alt="<?= $name ?>" width="40">
                                <?php else : ?>
                                <p>Нет изображения</p>
                                <?php endif; ?>
                                <div class="form-group">
                                    <input type="file" name="file">
                                </div>
                            </div>
                        </div>

                        <input class="button" type="submit" value="Сохранить" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/admin/footer.php'); ?>

    <?php require_once(TEMPLATES_DIR . '/modal.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
</body>

</html>