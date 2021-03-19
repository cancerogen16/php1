<?php
require __DIR__ . '/../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');

$products = getProducts('views', 'desc');
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1>Каталог товаров</h1>
            <p>Вывод списка товаров</p>

            <div class="products">
                <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                <div class="product">
                    <div class="product__image">
                        <a class="image__link" href="product.php?product_id=<?= $product['product_id'] ?>"
                            title="<?= $product['name'] ?>">
                            <img class="image" src="/img/<?= $product['image'] ?>" alt="<?= $product['name'] ?>"
                                width="250">
                        </a>
                    </div>
                    <div class="product__info">
                        <h3><a class="product__link" href="product.php?product_id=<?= $product['product_id'] ?>"
                                title="<?= $product['name'] ?>"><?= $product['name'] ?></a></h3>
                        <div class="price"><?= $product['price'] ?></div>
                    </div>
                </div>

                <?php endforeach; ?>
                <?php endif; ?>
            </div>


        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/footer.php'); ?>

    <?php require_once(TEMPLATES_DIR . '/modal.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
</body>

</html>