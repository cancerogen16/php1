<?php

/**
 * Получение массива файлов из директории
 *
 * @param  string $directory
 * @return array $files
 */
function getFilesList($directory)
{
    $files = [];

    if (strpos($directory, '/', -1) === false) {
        $directory = $directory . '/';
    }

    if (is_dir($directory)) {
        $items = scandir($directory);

        foreach ($items as $item) {
            if (filetype($directory . $item) === 'file') {
                $files[] = $item;
            }
        }
    }

    return $files;
}

/**
 * Проверка возможности загрузки изображения
 *
 * @param  string $file
 * @return mixed
 */
function canUpload($file)
{
    // если имя пустое, значит файл не выбран
    if ($file['name'] == '')
        return 'Вы не выбрали файл.';

    /* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
    if ($file['size'] == 0)
        return 'Файл слишком большой.';
    elseif ($file['size'] > 1048576)
        return ('Размер файла превышает 1 Мб!');

    $getMime = explode('.', $file['name']);

    $mime = strtolower(end($getMime));
    // объявим массив допустимых расширений
    $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

    // если расширение не входит в список допустимых - return
    if (!in_array($mime, $types))
        return 'Недопустимый тип файла.';

    return true;
}


/**
 * Загрузка изображения
 *
 * @return string
 */
function uploadImage()
{
    $message = '';

    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // проверяем, можно ли загружать изображение
        $check = canUpload($file);

        if ($check === true) {
            $filename = $file['name'];


            // загружаем изображение на сервер
            move_uploaded_file($file['tmp_name'], 'img/' . $filename);

            $caption = isset($_POST['caption']) ? $_POST['caption'] : '';

            if (empty($caption)) {
                $caption = basename($filename);
            }

            $size = getimagesize('img/' . $filename);

            addProductImage($filename, $caption, $size[0] . '*' . $size[1]);

            header("Location: /gallery.php");
            exit();
        } else {
            // выводим сообщение об ошибке
            $message = "<strong>$check</strong>";
        }
    }

    return $message;
}