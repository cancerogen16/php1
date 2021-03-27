<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";

$product_info = [
    'name' => ''
];

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

$addToCart = filter_input(INPUT_GET, 'addToCart', FILTER_SANITIZE_SPECIAL_CHARS);

if ($product_id) {
    if ($addToCart) {
        $user_id = 0;

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
            $user_id = (int)$_SESSION["user_id"];
        }

        addToCart($product_id, $user_id);

        header("location: /product.php?product_id=$product_id");
        exit;
    }

    setViews($product_id);
    $product_info = getProduct($product_id);
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product_info['name'] ?></title>
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
                        <div class="description-item">Цена: <?= number_format((float)$product_info['price'], 0, ',', ' ') ?>
                        </div>
                        <div class="description-item">Число просмотров: <?= $product_info['views'] ?></div>
                        <div class="product-cart">
                            <a class="btn" href="product.php?addToCart=1&product_id=<?= $product_info['product_id'] ?>" title="Добавить товар в корзину">Добавить в корзину</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/footer.php'); ?>

</body>

</html>