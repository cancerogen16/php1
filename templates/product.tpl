<?php if (empty($product)) : ?>
    <p>Нет товара в базе данных</p>
<?php else : ?>
    <h1><?= $product['name'] ?></h1>
    <div class="product-section">
        <div class="product-image">
            <?php if (empty($product['image'])) : ?>
                <p>Нет изображения в базе данных</p>
            <?php else : ?>
                <img class="full-image" src="img/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
            <?php endif; ?>
        </div>
        <div class="product-description">
            <div class="description-item">Наименование: <?= $product['name'] ?></div>
            <div class="description-item">Количество: <?= $product['quantity'] ?></div>
            <div class="description-item">Цена: <?= number_format((float)$product['price'], 0, ',', ' ') ?>
            </div>
            <div class="description-item">Число просмотров: <?= $product['views'] ?></div>
            <div class="product-cart">
                <a class="btn" href="product.php?addToCart=1&product_id=<?= $product['product_id'] ?>" title="Добавить товар в корзину">Добавить в корзину</a>
            </div>
        </div>
    </div>
<?php endif; ?>