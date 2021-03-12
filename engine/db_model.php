<?php

/**
 * Получение изображений из базы данных
 *
 * @return array
 */
function getProductImages()
{
    $images = [];

    $db = require_once(realpath('../config/db.php'));

    $link = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $query = "SELECT * FROM product_image WHERE 1 ORDER BY viewed DESC";

    if ($result = mysqli_query($link, $query)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $images[] = $row;
        }

        mysqli_free_result($result);
    }

    return $images;
}

function getProductImage($image_id)
{
    $row = [];

    $db = require_once(realpath('../config/db.php'));

    $link = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $query = "SELECT * FROM product_image WHERE id = $image_id";

    if ($result = mysqli_query($link, $query)) {

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_free_result($result);
    }

    return $row;
}


/**
 * Запись в базу данных изображения
 *
 * @param  mixed $image
 * @param  mixed $caption
 * @return void
 */
function addProductImage($image, $caption, $size)
{
    $db = require_once(realpath('../config/db.php'));

    $link = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $query = "INSERT INTO product_image (image, caption, size) VALUES ('$image', '$caption', '$size')";

    mysqli_query($link, $query);

    mysqli_close($link);

    return true;
}