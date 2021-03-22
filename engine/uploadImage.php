<?php
require_once(__DIR__ . '/../config/config.php');

function canUpload($file) {
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

function uploadImage() {
    $message = '';

    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // проверяем, можно ли загружать изображение
        $check = canUpload($file);

        if ($check === true) {
            $filename = $file['name'];

            // загружаем изображение на сервер
            if (move_uploaded_file($file['tmp_name'], IMAGES_DIR . $filename)) {
                $_POST['image'] = $filename;
            }
        } else {
            // выводим сообщение об ошибке
            $message = "<b>$check</b>";
        }
    }

    return $message;
}