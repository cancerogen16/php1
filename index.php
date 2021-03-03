<!DOCTYPE html>
<html lang="ru">
<?php
/**
 * вспомогательная функция - выводит разделитель заданий
 */
function starter($number)
{
    echo '<br><h3 style="text-align:center">' . $number . '</h3><hr><br>';
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Урок 2. Условные блоки, ветвление функции</title>
</head>

<body>
    <?php starter(1); ?>
    <?php
    $a = -3;
    $b = 0;

    /* 
    если $a и $b положительные, вывести их разность;
    если $а и $b отрицательные, вывести их произведение;
    если $а и $b разных знаков, вывести их сумму; 
    */

    // начальные данные
    echo "\$a = $a; \$b = $b;" . "<br>";

    if ($a >= 0 && $b >= 0) {
        echo "\$a - \$b = " . ($a - $b);
    } elseif ($a < 0 && $b < 0) {
        echo "\$a * \$b = " . ($a * $b);
    } else if (($a >= 0 && $b < 0) || ($a < 0 && $b >= 0)) {
        echo "\$a + \$b = " . ($a + $b);
    }
    ?>

    <?php starter(2); ?>
    <?php
    $a = 12;

    /*
    С помощью оператора switch организовать вывод чисел от $a до 15.
    */

    // начальные данные
    echo "\$a = $a;" . "<br>";

    switch ($a) {
        case 12:
            echo 12 . "<br>";
        case 13:
            echo 13 . "<br>";
        case 14:
            echo 14 . "<br>";
        case 15:
            echo 15 . "<br>";
    }
    ?>

    <?php starter(3); ?>
    <?php
    // Реализовать основные 4 арифметические операции в виде функций с двумя параметрами.

    function addition($num1, $num2)
    {
        return $num1 + $num2;
    }
    function substruction($num1, $num2)
    {
        return $num1 - $num2;
    }
    function multiply($num1, $num2)
    {
        return $num1 * $num2;
    }
    function division($num1, $num2)
    {
        return $num1 / $num2;
    }
    ?>

    <?php starter(4); ?>
    <?php

    /**
     * Реализовать функцию с тремя параметрами: mathOperation
     *
     * @param  mixed $arg1 первый аргумент
     * @param  mixed $arg2 второй аргумент
     * @param  mixed $operation действие
     * @return mixed
     */
    function mathOperation($arg1, $arg2, $operation)
    {
        switch ($operation) {
            case 'addition':
                return addition($arg1, $arg2);
            case 'substruction':
                return substruction($arg1, $arg2);
            case 'multiply':
                return multiply($arg1, $arg2);
            case 'division':
                return division($arg1, $arg2);
            default:
                return "Не задано действие!";
        }
    }

    $a = -3;
    $b = 7;
    $operation = 'multiply';

    // начальные данные
    echo "\$a = $a; \$b = $b; \$operation = $operation;" . "<br>";

    echo "Результат: " . mathOperation($a, $b, $operation);
    ?>

    <?php starter(6); ?>
    <?php
    /**
     * *С помощью рекурсии организовать функцию возведения числа в степень.
     *
     * @param  mixed $val – заданное число
     * @param  mixed $pow – степень
     * @return mixed
     */
    function power($val, $pow)
    {
        if ($pow == 0) {
            return 1;
        } elseif ($pow < 0) {
            return 1 / ($val * power($val, -$pow - 1));
        } else {
            return $val * power($val, $pow - 1);
        }
    }

    $val = 3;
    $pow = -2;

    // начальные данные
    echo "\$val = $val; \$pow = $pow;" . "<br>";

    echo "Результат: $val в степени $pow = " . power($val, $pow);
    ?>

    <?php starter(7); ?>
    <?php
    /*
    * *Написать функцию, которая вычисляет текущее время и возвращает его в формате с правильными склонениями, например:
    *  22 часа 15 минут
    *  21 час 43 минуты
    */

    function getCurrentTime()
    {
        date_default_timezone_set('Asia/Yekaterinburg');

        $hours = date('G'); // часы
        $minutes = date('i'); // минуты

        $hoursEnd = ''; // окончание часов
        $minutesEnd = ''; // окончание минут

        if ($hours == 1 || $hours == 21) {
            $hoursEnd = '';
        } elseif ($hours <= 4 || $hours >= 22) {
            $hoursEnd = 'а';
        } else {
            $hoursEnd = 'ов';
        }

        // последняя цифра в минутах
        $lastDigit = substr($minutes, -1);

        if ($lastDigit == 1 && $minutes != 11) {
            $minutesEnd = 'а';
        } elseif ($lastDigit == 2 || $lastDigit == 3 || $lastDigit == 4) {
            $minutesEnd = 'ы';
        }

        return $hours . ' час' . $hoursEnd . ' ' . $minutes . ' минут' . $minutesEnd;
    }

    echo "Текущее время: " . getCurrentTime();
    ?>

    <?php starter(5); ?>
    <?php /* вывести текущий год в подвале при помощи встроенных функций PHP */ ?>
    <footer>
        <h3><?php echo date('Y'); ?></h3>
    </footer>
</body>

</html>