<?php
session_start();

require __DIR__ . '/../config/config.php';

$title = 'Главная страница';

if (!empty($_SESSION["username"])) {
    $title = 'Привет, <b>' . htmlspecialchars($_SESSION["username"]) . '</b>. Добро пожаловать на сайт.';
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Урок 6. Интерактивность: Методы передачи данных GET и POST, работа с формами и пользовательскими данными
    </title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <h1><?= $title ?></h1>
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/footer.php'); ?>
</body>

</html>