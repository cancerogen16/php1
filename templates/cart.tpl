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
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)) : $p = 1; ?>
            <?php foreach ($products as $product) : ?>
            <tr>
                <td class="number">
                    <?= $p++; ?>
                </td>
                <td class="name"><a href="product.php?product_id=<?= $product['product_id'] ?>"
                        title="<?= $product['name'] ?>">
                        <?= $product['name'] ?>
                    </a>
                </td>
                <td class="image">
                    <?php if (!empty($product['image'])) : ?>
                    <img class="product-image" src="/img/<?= $product['image'] ?>" alt="<?= $product['name'] ?>"
                        width="64">
                    <?php else : ?>
                    Нет изображения
                    <?php endif; ?>
                </td>
                <td class="price">
                    <?= formatPrice($product['price']) ?>
                </td>
                <td class="quantity">
                    <?= $product['quantity'] ?>
                </td>
                <td class="price">
                    <?= formatPrice($product['total']) ?>
                </td>
                <td class="action"><a class="btn remove"
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
                <td>
                    <?= $cart['count'] ?>
                </td>
                <td class="price">
                    <?= formatPrice($cart['total']) ?>
                </td>
                <td colspan="2"></td>
            </tr>
            <?php endif; ?>
        </tfoot>
    </table>
</div>
<?php if (!empty($products)) : ?>
<div class="cart-btns">
    <a class="btn" href="catalog.php" title="Продолжить покупки">Продолжить покупки</a>
    <a class="btn" href="order.php" title="Оформление заказа">Оформление заказа</a>
</div>
<?php endif; ?>