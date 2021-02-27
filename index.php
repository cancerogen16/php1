<!DOCTYPE html>
<html lang="ru">
<?php
$title = 'Первый урок';
$head = 'Заголовок страницы';
$year = 2021;
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>

<body>
    <h1><?= $head ?></h1>
    <p>Текущий год: <?= $year ?></p>

    <?php
    $a = 1;
    $b = 2;

    echo '$a = ' . $a . ', ' . '$b = ' . $b . '<br>';

    echo 'Используя только две переменные, меняем их значение местами.<br>';

    $a = $a + $b; // a = 3, b = 2
    $b = $a - $b; // a = 3, b = 1
    $a = $a - $b; // a = 2, b = 1

    echo '$a = ' . $a . ', ' . '$b = ' . $b . '<br>';
    ?>
</body>

</html>