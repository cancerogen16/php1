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

    $query = "SELECT * FROM product WHERE 1";

    if ($sort) {
        $query .= " ORDER BY $sort";

        if ($order) {
            $query .= " $order";
        }
    }

    return get_db_result($query);
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

    deleteImage($product_id);

    $query = "DELETE FROM product WHERE product_id = '" . (int)$product_id . "'";

    update_db($query);

    return true;
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

/**
 * Определение пользователя по роли в сессии
 *
 * @return bool
 */
function isAdmin(): bool {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ? true : false;
}

/**
 * Найден пользователь в базе по имени
 *
 * @param  string $username
 * @return bool
 */
function existUser($username): bool {
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT id FROM user WHERE username = '" . protect($username) . "'";

    $results = get_db_result($query);

    return (count($results) == 1) ? false : true;
}

/**
 * Добавление пользователя в базу
 *
 * @param  string $username
 * @param  string $password
 * @return int insert_id
 */
function addUser($username, $password) {
    require_once(__DIR__ . '/../config/db.php');

    $ip = $_SERVER['REMOTE_ADDR'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT * FROM user WHERE 1"; // получение из базы всех пользователей

    $results = get_db_result($query);

    if (count($results) == 0) { // если пользователь первый
        $user_role = 'admin';
    } else {
        $user_role = 'customer';
    }

    $query = "INSERT INTO user (username, password, user_role, ip) VALUES ('" . protect($username) . "', '" . $password_hash . "', '" . $user_role . "', '" . $ip . "')";

    return update_db($query);
}

/**
 * Получение данных пользователя из базы по его имени
 *
 * @param  string $username
 * @return array
 */
function getUser($username) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT id, username, password FROM user WHERE username = '" . protect($username) . "'";

    $results = get_db_result($query);

    return $results;
}