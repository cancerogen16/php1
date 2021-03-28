<h1>
    <?= $title ?>
</h1>

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
                <td class="number">
                    <?= ($p + 1) ?>
                </td>
                <td class="name">
                    <?= $product['name'] ?>
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
                    <?= $product['price'] ?>
                </td>
                <td class="quantity">
                    <?= $product['quantity'] ?>
                </td>
                <td class="action"><a class="btn" href="product.php?product_id=<?= $product['product_id'] ?>"
                        title="Редактировать">Редактировать</a></td>
                <td class="action"><a class="btn"
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
        <a class="btn" href="product.php?add_product=1" title="Добавить товар">Добавить
            товар</a>
    </div>
</div>