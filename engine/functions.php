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

    $query = "SELECT * FROM product WHERE 1";

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

    $query = "SELECT * FROM user WHERE username = '" . protect($username) . "'";

    $results = get_db_result($query);

    return $results;
}

function addToCart($product_id, $user_id) {
    require_once(__DIR__ . '/../config/db.php');

    $products = [];

    $date_added = date('Y-m-d H:i:s');

    if ($user_id) {
        $query = "SELECT * FROM cart WHERE user_id = '" . (int)$user_id . "'";
    } else {
        $query = "SELECT * FROM cart WHERE session_id = '" . session_id() . "'";
    }

    $result = get_db_row($query);

    if (!empty($result)) {
        $cart_id = (int)$result['cart_id'];

        $products = json_decode($result['products'], true);

        if ($products) {
            if (isset($products[$product_id])) {
                $products[$product_id]++;
            } else {
                $products[$product_id] = 1;
            }
        } else {
            $products[$product_id] = 1;
        }

        $query = "UPDATE `cart` SET products = '" . json_encode($products) . "', session_id = '" . session_id() . "', date_added = '" . $date_added . "'  WHERE cart_id = '" . $cart_id . "'";
    } else {
        $query = "INSERT INTO `cart` (user_id, products, session_id, date_added) VALUES ('" . (int)$user_id . "', '" . $products . "', '" . session_id() . "', '" . $date_added . "')";
    }

    return update_db($query);
}

function removeFromCart($product_id, $user_id) {
    require_once(__DIR__ . '/../config/db.php');

    $products = [];

    $date_added = date('Y-m-d H:i:s');

    if ($user_id) {
        $query = "SELECT * FROM cart WHERE user_id = '" . (int)$user_id . "'";
    } else {
        $query = "SELECT * FROM cart WHERE session_id = '" . session_id() . "'";
    }

    $result = get_db_row($query);

    if (!empty($result)) {
        $cart_id = (int)$result['cart_id'];

        $products = json_decode($result['products'], true);

        if ($products) {
            if (isset($products[$product_id])) {
                unset($products[$product_id]);
            }
        }

        $query = "UPDATE `cart` SET products = '" . json_encode($products) . "', session_id = '" . session_id() . "', date_added = '" . $date_added . "'  WHERE cart_id = '" . $cart_id . "'";
    } else {
        $query = "INSERT INTO `cart` (user_id, products, session_id, date_added) VALUES ('" . (int)$user_id . "', '" . $products . "', '" . session_id() . "', '" . $date_added . "')";
    }

    return update_db($query);
}

function getCart($user_id) {
    require_once(__DIR__ . '/../config/db.php');

    $cart = [];

    if ($user_id) {
        $query = "SELECT * FROM cart WHERE user_id = '" . (int)$user_id . "'";
    } else {
        $query = "SELECT * FROM cart WHERE session_id = '" . session_id() . "'";
    }

    $result = get_db_row($query);

    if ($result) {
        $count = 0;
        $total = 0;

        $products = json_decode($result['products'], true);

        $cart = $result;
        $cart['products'] = [];

        foreach ($products as $product_id => $quantity) {
            $product = getProduct($product_id);

            $cart['products'][$product_id] = $product;
            $cart['products'][$product_id]['quantity'] = $quantity;
            $cart['products'][$product_id]['price'] = number_format((float)$product['price'], 0, ',', ' ');
            $cart['products'][$product_id]['total'] = number_format($quantity * (float)$product['price'], 0, ',', ' ');

            $count++;

            $total += $quantity * $product['price'];
        }

        $cart['count'] = $count;
        $cart['total'] = $total;
    }

    return $cart;
}