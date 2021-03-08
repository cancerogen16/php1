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
    <title>Урок 3. Циклы и массивы</title>
</head>

<body>
    <?php starter(1); ?>
    <?php
    /*
    * 1. С помощью цикла while вывести все числа в промежутке от 0 до 100, которые делятся на 3 без остатка.
    */
    $start = 0; // начальное значение
    $limit = 100; // конечное значение
    $multiplicity = 3; // кратность
    $number = $start; // очередное значение

    while ($number <= $limit) {
        if ($number % $multiplicity == 0) {
            echo $number . " ";
        }

        $number++;
    }

    echo " - делятся на $multiplicity без остатка"
    ?>

    <?php starter(2); ?>
    <?php
    /*
    * 2. С помощью цикла do…while написать функцию для вывода чисел от 0 до 10, чтобы результат выглядел так:
    *    0 – ноль.
    *    1 – нечетное число.
    *    2 – четное число.
    *    3 – нечетное число.
    *    …
    *    10 – четное число.
    */
    $start = 0; // начальное значение
    $limit = 10; // конечное значение
    $number = $start; // очередное значение

    do {
        if ($number == 0) {
            echo $number . " – ноль.";
        } elseif ($number % 2) {
            echo $number . " – нечетное число.";
        } else {
            echo $number . " – четное число.";
        }

        $number++;

        echo "<br>";
    } while ($number <= $limit);
    ?>

    <?php starter(3); ?>
    <?php
    /*
    * 3. Объявить массив, в котором в качестве ключей будут использоваться названия областей,
    * а в качестве значений – массивы с названиями городов из соответствующей области.
    * Вывести в цикле значения массива
    */
    $regions = [
        'Московская' => ['Москва', 'Зеленоград', 'Королёв'],
        'Ленинградская' => ['Санкт-Петербург', 'Всеволожск', 'Кронштадт'],
        'Вологодская' => ['Вологда', 'Череповец', 'Белозерск', 'Великий Устюг'],
    ];

    foreach ($regions as $region => $cities) {
        echo "$region область:" . "<br>";
        echo implode(", ", $cities) . "<br>";
    }
    ?>

    <?php starter(4); ?>
    <?php
    /*
    * 4. Объявить массив, индексами которого являются буквы русского языка,
    * а значениями – соответствующие латинские буквосочетания (‘а’=> ’a’, ‘б’ => ‘b’, ‘в’ => ‘v’, ‘г’ => ‘g’, …, ‘э’ => ‘e’, ‘ю’ => ‘yu’, ‘я’ => ‘ya’).
    */
    function translit($rusString)
    {
        $letters = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'j',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ъ' => '\'\'',
            'ы' => 'y',
            'ь' => '\'',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
        ];

        $engString = '';

        for ($i = 0; $i < mb_strlen($rusString, "UTF-8"); $i++) {
            $rusLetter = mb_substr($rusString, $i, 1, "UTF-8");
            $smallLetter = mb_strtolower($rusLetter, "UTF-8");

            if (isset($letters[$smallLetter])) {
                if ($smallLetter == $rusLetter) {
                    $engString .= $letters[$smallLetter];
                } else {
                    $engString .= mb_strtoupper($letters[$smallLetter], "UTF-8");
                }
            } else {
                $engString .= $rusLetter;
            }
        }

        return $engString;
    }

    $string = 'Объявить массив, индексами которого являются буквы Русского языка, а значениями – соответствующие латинские буквосочетания';
    echo $string . "<br>";
    echo translit($string) . "<br>";
    ?>

    <?php starter(5); ?>
    <?php
    /*
    * 5. Написать функцию, которая заменяет в строке пробелы на подчеркивания и возвращает видоизмененную строчку.
    */
    function replaceSpace($string)
    {
        return preg_replace("/\s/", "_", $string);
    }

    $string = 'Написать функцию, которая заменяет в строке пробелы на подчеркивания и возвращает видоизмененную строчку.';
    echo $string . "<br>";
    echo replaceSpace($string);
    ?>

    <?php starter(6); ?>
    <?php
    /*
    * 6. В имеющемся шаблоне сайта заменить статичное меню (ul - li) на генерируемое через PHP.
    * Необходимо представить пункты меню как элементы массива и вывести их циклом.
    * Подумать, как можно реализовать меню с вложенными подменю? Попробовать его реализовать.
    */
    $menu = [
        [
            'name' => 'Главная',
            'href' => '/',
        ],
        [
            'name' => 'Меню1',
            'href' => '#',
            'children' => [
                [
                    'name' => 'Подменю1',
                    'href' => '#',
                ],
                [
                    'name' => 'Подменю2',
                    'href' => '#',
                ],
            ],
        ],
        [
            'name' => 'Меню2',
            'href' => '#',
            'children' => [
                [
                    'name' => 'Подменю1',
                    'href' => '#',
                ],
                [
                    'name' => 'Подменю2',
                    'href' => '#',
                ],
                [
                    'name' => 'Подменю3',
                    'href' => '#',
                ],
            ],
        ],
        [
            'name' => 'Контакты',
            'href' => '#',
        ],
    ];

    echo '<ul>';
    foreach ($menu as $menuItem) {
        echo '<li><a href="' . $menuItem['href'] . '" >' . $menuItem['name'] . '</a>';
        if (isset($menuItem['children'])) {
            echo '<ul>';
            foreach ($menuItem['children'] as $child) {
                echo '<li><a href="' . $child['href'] . '" >' . $child['name'] . '</a>';
            }
            echo '</ul>';
        }
        echo '</li>';
    }
    echo '</ul>';
    ?>

    <?php starter(7); ?>
    <?php
    /*
    * 7. *Вывести с помощью цикла for числа от 0 до 9, НЕ используя тело цикла.
    */
    for ($i = 0; $i <= 9; print $i++) {
    }
    ?>

    <?php starter(8); ?>
    <?php
    /*
    * 8. *Повторить третье задание, но вывести на экран только города, начинающиеся с буквы «К».
    */
    $first = "К";
    foreach ($regions as $region => $cities) {
        echo "$region область:" . "<br>";

        $targetCities = [];
        foreach ($cities as $city) {
            if (mb_strpos($city, $first, 0, "UTF-8") === 0) {
                $targetCities[] = $city;
            }
        }

        if (empty($targetCities)) {
            echo "нет городов на букву $first" . "<br>";
        } else {
            echo implode(", ", $targetCities) . "<br>";
        }
    }
    ?>

    <?php starter(9); ?>
    <?php
    /*
    * 9. *Объединить две ранее написанные функции в одну, которая получает строку на русском языке, производит транслитерацию и замену пробелов на подчеркивания
    */
    function transSpace($rusString)
    {
        $letters = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'j',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ъ' => '\'\'',
            'ы' => 'y',
            'ь' => '\'',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
        ];

        $engString = '';

        for ($i = 0; $i < mb_strlen($rusString, "UTF-8"); $i++) {
            $rusLetter = mb_substr($rusString, $i, 1, "UTF-8");
            $smallLetter = mb_strtolower($rusLetter, "UTF-8");

            if (isset($letters[$smallLetter])) {
                if ($smallLetter == $rusLetter) {
                    $engString .= $letters[$smallLetter];
                } else {
                    $engString .= mb_strtoupper($letters[$smallLetter], "UTF-8");
                }
            } else {
                $engString .= $rusLetter;
            }
        }

        return preg_replace("/\s/", "_", $engString);
    }

    $string = '*Объединить две ранее написанные функции в одну, которая получает строку на русском языке, производит транслитерацию и замену пробелов на подчеркивания';
    echo $string . "<br>";
    echo transSpace($string) . "<br>";
    ?>
</body>

</html>