<h1>
    <?= $title ?>
</h1>

<form class="order-edit" enctype="multipart/form-data" method="post" action="">
    <input type="hidden" name="order_id" value="<?= $order_id ?>" />
    <div class="data-wrap">
        <h3>Покупатель</h3>
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
    <div class="data-wrap">
        <h3>Товары в заказе</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Итого</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($order_products)) : $product_row = 0; ?>
                <?php foreach ($order_products as $p => $order_product) : ?>
                <tr>
                    <td class="number">
                        <?= ($product_row + 1) ?>
                        <input type="hidden" name="order_product[<?=$product_row?>][product_id]"
                            value="<?=$order_product['product_id']?>">
                    </td>
                    <td class="name">
                        <?= $order_product['name'] ?>
                        <input type="hidden" name="order_product[<?=$product_row?>][name]"
                            value="<?=$order_product['name']?>">
                    </td>
                    <td class="quantity">
                        <input type="text" name="order_product[<?=$product_row?>][quantity]" class="form-control"
                            value="<?php echo $order_product['quantity']; ?>" />
                    </td>
                    <td class="price">
                        <?= $order_product['price'] ?>
                        <input type="hidden" name="order_product[<?=$product_row?>][price]"
                            value="<?=$order_product['price']?>">
                    </td>
                    <td class="price">
                        <?= $order_product['total'] ?>
                        <input type="hidden" name="order_product[<?=$product_row?>][total]"
                            value="<?=$order_product['total']?>">
                    </td>
                    <td class="action">
                        <a class="btn" href="javascript:void(0);" title="Удалить"
                            onclick="$(this).closest('tr').remove();">Удалить</a>
                    </td>
                </tr>
                <?php $product_row++; endforeach; ?>
                <tr>
                    <td class="name" colspan="4">
                        Итого
                    </td>
                    <td class="price">
                        <?= $total ?>
                    </td>
                    <td></td>
                </tr>
                <?php else : ?>
                <tr>
                    <td colspan="10">Нет товаров в заказе</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="data-wrap">
        <button type="submit" name="save" class="btn">Сохранить</button>
        <button type="submit" name="apply" class="btn">Применить</button>
    </div>
</form>