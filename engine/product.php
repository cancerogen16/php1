<?php

/**
 * Получение из базы данных товаров, отсортированных по $sort и $order
 *
 * @param  string $sort параметр сортировки
 * @param  string $order направление сортировки
 * @return array db_result
 */
function getProducts($sort = '', $order = '') {
    require_once(__DIR__ . '/../config/db.php');

    $products_data = [];

    $query = "SELECT * FROM product";

    if ($sort) {
        $query .= " ORDER BY $sort";

        if ($order) {
            $query .= " $order";
        }
    }

    if (!empty($products = get_db_result($query))) {
        foreach ($products as $product) {
            $image = $product['image'];

            if (!$image) {
                $image = 'noimage.jpg';
            }
            $products_data[] = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => number_format($product['price'], 0, ',', ' '),
                'image' => $image,
                'views' => $product['views'],
                'date_created' => $product['date_created'],
            ];
        }
    }

    return $products_data;
}

/**
 * Получение товара из базы данных
 *
 * @param  string $product_id
 * @return array db_result
 */
function getProduct($product_id) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT * FROM product WHERE product_id = '" . (int)$product_id . "'";

    $row = get_db_row($query);

    return $row;
}

/**
 * Добавление товара в базу данных
 *
 * @param  mixed $data
 * @return int insert_id
 */
function addProduct($data) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "INSERT INTO product (name, quantity, price, image, views) VALUES ('" . protect($data['name']) . "', '" . (int)$data['quantity'] . "', '" . (float)$data['price'] . "', '" . protect($data['image']) . "', 0)";

    return update_db($query);
}

/**
 * Редактирование товара в базе данных
 *
 * @param  string $product_id
 * @param  array $data
 * @return true
 */
function editProduct($product_id, $data) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "UPDATE product SET name = '" . protect($data['name']) . "', quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "', image = '" . protect($data['image']) . "'  WHERE product_id = '" . (int)$product_id . "'";

    return update_db($query);
}

/**
 * Удаление товара из базы данных
 *
 * @param  string $product_id
 * @return void
 */
function deleteProduct($product_id) {
    require_once(__DIR__ . '/../config/db.php');

    deleteImage($product_id);

    $query = "DELETE FROM product WHERE product_id = '" . (int)$product_id . "'";

    return update_db($query);
}

/**
 * Валидация товара при сохранении
 * 
 * @param array $data
 * 
 * @return array errors
 */
function validateProduct($data = []) {
    $errors = [];

    if (trim($data['name']) == '') {
        $errors['name'] = 'Название товара обязательно!';
    }

    return $errors;
}

/**
 * Удаление изображения товара, если оно использовалось только для одного товара
 *
 * @param  string $product_id
 * @return bool
 */
function deleteImage($product_id) {
    require_once(__DIR__ . '/../config/db.php');

    $deleted = false;

    $query = "SELECT image FROM product WHERE product_id = '" . (int)$product_id . "'";

    $image = get_db_result($query)[0]['image'];

    if ($image) {
        $query = "SELECT * FROM product WHERE image = '" . protect($image) . "'";

        $images = get_db_result($query);

        if (count($images) < 2) {
            $deleted = unlink(IMAGES_DIR . $image);
        }
    }

    return $deleted;
}

/**
 * Запись в базу количества просмотров
 *
 * @param  string $product_id
 * @return bool
 */
function setViews($product_id) {
    require_once(__DIR__ . '/../config/db.php');

    $result = false;

    if ($product_id) {
        $query = "UPDATE `product` SET `views`=`views`+1 WHERE product_id = '" . (int)$product_id . "'";

        $result = update_db($query);
    }

    return $result;
}