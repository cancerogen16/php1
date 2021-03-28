<h1>
    <?= $title ?>
</h1>

<div class="orders">
    <table class="table">
        <thead>
            <tr>
                <th>№</th>
                <th>Покупатель</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Статус</th>
                <th>Итого</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) : ?>
            <?php foreach ($orders as $i => $order) : ?>
            <tr>
                <td class="number">
                    <?= $order['order_id'] ?>
                </td>
                <td class="name">
                    <?= $order['username'] ?>
                </td>
                <td class="name">
                    <?= $order['phone'] ?>
                </td>
                <td class="name">
                    <?= $order['address'] ?>
                </td>
                <td class="quantity">
                    <?= $order['order_status'] ?>
                </td>
                <td class="price">
                    <?= $order['total'] ?>
                </td>
                <td class="action"><a class="btn" href="order.php?order_id=<?= $order['order_id'] ?>"
                        title="Редактировать">Редактировать</a></td>
                <td class="action"><a class="btn" href="orders.php?delete_order=1&order_id=<?= $order['order_id'] ?>"
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
</div>