<?php
require __DIR__ . '/../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');

$product = [];

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

if ($product_id) {
    $product_info = getProduct($product_id)[0];
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница изображения</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <?php if (empty($product_info)) : ?>
            <p>Нет товара в базе данных</p>
            <?php else : ?>
            <h1><?= $product_info['name'] ?></h1>
            <div class="product-section">
                <div class="product-image">
                    <?php if (empty($product_info['image'])) : ?>
                    <p>Нет изображения в базе данных</p>
                    <?php else : ?>
                    <img class="full-image" src="img/<?= $product_info['image'] ?>" alt="<?= $product_info['name'] ?>">
                    <?php endif; ?>
                </div>
                <div class="product-description">
                    <div class="description-item">Наименование: <?= $product_info['name'] ?></div>
                    <div class="description-item">Количество: <?= $product_info['quantity'] ?></div>
                    <div class="description-item">Цена: <?= $product_info['price'] ?></div>
                    <div class="description-item">Число просмотров: <?= $product_info['views'] ?></div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/footer.php'); ?>

</body>

</html>