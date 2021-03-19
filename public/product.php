<?php
require __DIR__ . '/../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');

$image = [];

$image_id = isset($_GET['image_id']) ? $_GET['image_id'] : 0;

if ($image_id) {
    $image = getProductImage($image_id);
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница изображения</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1>Страница изображения</h1>
            <p>Вывод изображения из базы данных в полном размере</p>

            <div class="image-section">
                <div class="image-wrap">
                    <?php if (empty($image)) : ?>
                    <p>Нет изображения в базе данных</p>
                    <?php else : ?>
                    <img class="full-image" src="img/<?= $image['image'] ?>" alt="<?= $image['caption'] ?>">
                    <?php endif; ?>
                </div>
                <div class="image-description">
                    <div class="description-item">Название изображения: <?= $image['caption'] ?></div>
                    <div class="description-item">Размер изображения: <?= $image['size'] ?></div>
                    <div class="description-item">Число просмотров: <?= $image['views'] ?></div>
                </div>
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