<?php
require __DIR__ . '/../../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');

$message = '';

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
$delete_product = filter_input(INPUT_GET, 'delete_product', FILTER_SANITIZE_SPECIAL_CHARS);

if ($delete_product && $product_id) {
    deleteProduct($product_id);

    header("Location: /admin/catalog.php");
    exit();
}

$products = getProducts();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование каталога товаров</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/admin/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1>Редактирование каталога товаров</h1>
        </div>
        <hr>
        <div class="container">
            <div class="products">
                <table class="table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Наименование</th>
                            <th>Изображение</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $p => $product) : ?>
                        <tr>
                            <td><?= ($p + 1) ?></td>
                            <td><?= $product['name'] ?></td>
                            <td>
                                <?php if (!empty($product['image'])) : ?>
                                <img class="product-image" src="/img/<?= $product['image'] ?>"
                                    alt="<?= $product['name'] ?>" width="64">
                                <?php else : ?>
                                Нет изображения
                                <?php endif; ?>
                            </td>
                            <td><?= $product['price'] ?></td>
                            <td><?= $product['quantity'] ?></td>
                            <td><a class="button" href="product.php?product_id=<?= $product['product_id'] ?>"
                                    title="Редактировать">Редактировать</a></td>
                            <td><a class="button"
                                    href="catalog.php?delete_product=1&product_id=<?= $product['product_id'] ?>"
                                    title="Удалить">Удалить</a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="10">Нет товаров</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="add-product">
                    <a class="button" href="product.php?add_product=1" title="Добавить товар">Добавить
                        товар</a>
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