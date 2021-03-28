<h1>Оформление заказа</h1>

<form action="" method="post">
    <div class="cart-section">
        <h3>Список товаров в корзине</h3>
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
                        <div class="quantity-inner">
                            <div class="quantity-btns">
                                <a class="btn quantity-btn plus" href="/" title="Добавить"
                                    data-id="<?= $product['product_id'] ?>">+</a>
                                <a class="btn quantity-btn minus" href="/" title="Убавить"
                                    data-id="<?= $product['product_id'] ?>">-</a>
                            </div>
                            <div class="quantity-input">
                                <input type="text" value="<?= $product['quantity'] ?>" size="2" class="quantity-value"
                                    data-id="<?= $product['product_id'] ?>">
                            </div>
                        </div>
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
                    <td colspan="10">Ваша корзина пуста!</td>
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
    <div class="user-section">
        <h3>Данные для заказа</h3>
        <div class="table">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Имя</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="field-error">
                    <?php echo $username_err; ?>
                </span>
            </div>

            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Телефон</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="field-error">
                    <?php echo $phone_err; ?>
                </span>
            </div>

            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Адрес</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="field-error">
                    <?php echo $address_err; ?>
                </span>
            </div>
        </div>
    </div>
    <?php if (!empty($products)) : ?>
    <div class="cart-btns">
        <a class="btn" href="catalog.php" title="Продолжить покупки">Продолжить покупки</a>
        <button type="submit" class="btn" name="order" title="Подтверждение заказа">Подтверждение заказа</a>
    </div>
    <?php endif; ?>
</form>