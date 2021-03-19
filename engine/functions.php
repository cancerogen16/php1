<?php

/**
 * Получение из базы данных товаров, отсортированных по популярности
 *
 * @return array
 */
function getProducts()
{
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT * FROM product WHERE 1";

    return get_db_result($query);
}

/**
 * Получение товара из базы
 *
 * @param  string $product_id
 * @return array
 */
function getProduct($product_id)
{
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT * FROM product WHERE product_id = '" . (int)$product_id . "'";

    $row = get_db_result($query);

    return $row;
}

function addProduct($data)
{
    require_once(__DIR__ . '/../config/db.php');

    $name = (empty($data['name'])) ? '' : $data['name'];
    $quantity = (empty($data['quantity'])) ? 0 : $data['quantity'];
    $price = (empty($data['price'])) ? 0 : $data['price'];

    $query = "INSERT INTO product (name, quantity, price, views) VALUES ('$name', '$quantity', '$price', 0)";

    update_db($query);

    return true;
}

function editProduct($product_id, $data)
{
    require_once(__DIR__ . '/../config/db.php');

    $name = (empty($data['name'])) ? '' : $data['name'];
    $quantity = (empty($data['quantity'])) ? 0 : $data['quantity'];
    $price = (empty($data['price'])) ? 0 : $data['price'];

    $query = "UPDATE product SET name = '" . $name . "', quantity = '" . $quantity . "', price = '" . $price . "'  WHERE product_id = '" . (int)$product_id . "'";

    update_db($query);

    return true;
}

function deleteProduct($product_id)
{
    require_once(__DIR__ . '/../config/db.php');

    $query = "DELETE FROM product WHERE product_id = '" . (int)$product_id . "'";

    update_db($query);

    return true;
}