<!DOCTYPE html>
<html lang="ru">
<?php
require __DIR__ . '/../../config/config.php';
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администрирование каталога</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/admin/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1>Администрирование каталога</h1>
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/admin/footer.php'); ?>
</body>

</html>