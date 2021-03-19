<?php

/**
 * Получение из базы данных товаров
 *
 * @return array db_result
 */
function getProducts() {
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT * FROM product WHERE 1";

    return get_db_result($query);
}

/**
 * Получение товара из базы данных
 *
 * @param  string $product_id
 * @return array
 */
function getProduct($product_id) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT * FROM product WHERE product_id = '" . (int)$product_id . "'";

    $row = get_db_result($query);

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

    update_db($query);

    return true;
}

/**
 * Удаление товара из базы данных
 *
 * @param  string $product_id
 * @return void
 */
function deleteProduct($product_id) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "DELETE FROM product WHERE product_id = '" . (int)$product_id . "'";

    update_db($query);

    return true;
}