<?php

/**
 * Получение из базы данных изображений, отсортированных по популярности
 *
 * @return array
 */
function getProductImages()
{
    require(realpath('../config/db.php'));

    $images = [];

    $query = "SELECT * FROM product_image WHERE 1 ORDER BY views DESC";

    if ($result = mysqli_query($db, $query)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $images[] = $row;
        }

        mysqli_free_result($result);
    }

    mysqli_close($db);

    return $images;
}

/**
 * Запись в базу количества просмотров данного изображения и получение массива его параметров
 *
 * @param  string $image_id
 * @return array
 */
function getProductImage($image_id)
{
    require(realpath('../config/db.php'));

    $query = "UPDATE `product_image` SET `views`=`views`+1 WHERE `id`='$image_id'";

    mysqli_query($db, $query);

    $row = [];

    $query = "SELECT * FROM product_image WHERE id = $image_id";

    if ($result = mysqli_query($db, $query)) {

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_free_result($result);
    }

    mysqli_close($db);

    return $row;
}

/**
 * Запись в базу данных изображения
 *
 * @param  mixed $image
 * @param  mixed $caption
 * @param  mixed $size
 * @return true
 */
function addProductImage($image, $caption, $size)
{
    require(realpath('../config/db.php'));

    $query = "INSERT INTO product_image (image, caption, size) VALUES ('$image', '$caption', '$size')";

    mysqli_query($db, $query);

    mysqli_close($db);

    return true;
}