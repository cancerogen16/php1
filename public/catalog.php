<?php
require __DIR__ . '/../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = uploadImage();
}

$images = getProductImages();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1>Галерея</h1>
            <p>Вывод изображений из базы данных</p>

            <div class="images">
                <?php if (!empty($images)) : ?>
                <?php foreach ($images as $image) : ?>
                <a class="image__link" href="productImage.php?image_id=<?= $image['id'] ?>"
                    title="<?= $image['caption'] ?>">
                    <img class="image" src="img/<?= $image['image'] ?>" alt="<?= $image['caption'] ?>" width="250">
                </a>
                <?php endforeach; ?>
                <?php endif; ?>
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