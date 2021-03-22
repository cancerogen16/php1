<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

require __DIR__ . '/../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');

$user_id = 0;

if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
    $user_id = (int)$_SESSION["user_id"];
}

if ($cart = getCart($user_id)) {
    $products = $cart['products'];
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1>Корзина</h1>
            <div class="cart-section">
                <table class="table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Наименование</th>
                            <th>Изображение</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Всего</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)) : $p = 1; ?>
                        <?php foreach ($products as $product) : ?>
                        <tr>
                            <td class="number"><?= $p++; ?></td>
                            <td class="name"><a href="product.php?product_id=<?= $product['product_id'] ?>"
                                    title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                            </td>
                            <td class="image">
                                <?php if (!empty($product['image'])) : ?>
                                <img class="product-image" src="/img/<?= $product['image'] ?>"
                                    alt="<?= $product['name'] ?>" width="64">
                                <?php else : ?>
                                Нет изображения
                                <?php endif; ?>
                            </td>
                            <td class="price"><?= $product['price'] ?></td>
                            <td class="quantity"><?= $product['quantity'] ?></td>
                            <td class="price"><?= $product['total'] ?></td>
                            <td class="action"><a class="btn"
                                    href="cart.php?addToCart=1&product_id=<?= $product['product_id'] ?>"
                                    title="Добавить">Добавить</a></td>
                            <td class="action"><a class="btn"
                                    href="cart.php?removeFromCart=1&product_id=<?= $product['product_id'] ?>"
                                    title="Удалить">Удалить</a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="10">Нет товаров в корзине</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <?php if (!empty($products)) : ?>
                        <tr>
                            <td colspan="4">Итого</td>
                            <td><?= $cart['count'] ?></td>
                            <td class="price"><?= $cart['total'] ?></td>
                            <td colspan="2"></td>
                        </tr>
                        <?php endif; ?>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/footer.php'); ?>

</body>

</html>