<?php

declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

require __DIR__ . '/../../config/config.php';

require_once(ENGINE_DIR . '/functions.php');

if (!isAdmin()) {
    header("Location: /login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <?php require_once(TEMPLATES_DIR . '/admin/header.php'); ?>
    <hr>

    <div class="content">
        <div class="container">
            <div class="page-header">
                <h1>Привет, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Добро пожаловать в панель
                    администратора.
                </h1>
            </div>
            <p>
                <a href="/logout.php" class="btn btn-danger">Выйти из своей учетной записи</a>
            </p>
        </div>
    </div>

    <hr>
    <?php require_once(TEMPLATES_DIR . '/admin/footer.php'); ?>
</body>

</html>