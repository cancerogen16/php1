<form class="product-edit" enctype="multipart/form-data" method="post" action="">
    <div class="data-wrap">
        <input type="hidden" name="product_id" value="<?= $product_id ?>" />
        <input type="hidden" name="image" value="<?= $image ?>" />
        <div class="form-group"><label for="product_name">Название товара </label>
            <input type="text" name="name" value="<?= $name ?>" id="product_name" placeholder="Название товара" />
            <span class="field-error">
                <?php echo $name_err; ?>
            </span>
        </div>
        <div class="form-group"><label for="product_quantity">Количество товара </label>
            <input type="text" name="quantity" value="<?= $quantity ?>" id="product_quantity"
                placeholder="Количество товара" />
        </div>
        <div class="form-group"><label for="product_price">Цена товара </label>
            <input type="text" name="price" value="<?= $price ?>" id="product_price" placeholder="Цена товара" />
        </div>
        <button type="submit" name="save" class="btn">Сохранить</button>
        <button type="submit" name="apply" class="btn">Применить</button>
    </div>
    <div class="image-wrap">
        <?php if (!empty($image)) : ?>
        <img src="/img/<?= $image ?>" alt="<?= $name ?>" width="300">
        <?php else : ?>
        <p>Нет изображения</p>
        <?php endif; ?>
        <div class="upload">
            <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
            <input type="file" name="file">
            <button type="submit" name="load_image" class="btn">
                <?php if (!empty($image)) : ?>
                Заменить изображение
                <?php else : ?>
                Загрузить изображение
                <?php endif; ?>
            </button>
        </div>

        <div class="message">
            <?= $message ?>
        </div>
    </div>
</form>