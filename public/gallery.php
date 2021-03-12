<?php
require_once(realpath('../config/config.php'));

require_once(ENGINE_DIR . '/functions.php');

$message = '';

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // проверяем, можно ли загружать изображение
    $check = canUpload($file);

    if ($check === true) {
        // загружаем изображение на сервер
        move_uploaded_file($file['tmp_name'], 'img/' . $file['name']);
        header("Location: /gallery.php");
        exit();
    } else {
        // выводим сообщение об ошибке
        $message = "<strong>$check</strong>";
    }
}

$images = getFilesList(IMAGES_DIR);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея</title>
    <link rel="stylesheet" href="css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1>Галерея</h1>
            <p>Вывод изображений из папки</p>

            <div class="images">
                <?php if (!empty($images)) : ?>
                <?php foreach ($images as $image) : ?>
                <a class="image__link" href="img/<?= $image ?>" target="_blank" rel="modalimg">
                    <img class="image" src="img/<?= $image ?>" alt="<?= $image ?>" width="250">
                </a>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php require_once(TEMPLATES_DIR . '/uploadForm.php'); ?>
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