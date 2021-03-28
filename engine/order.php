<?php

function getOrders() {
    require_once(__DIR__ . '/../config/db.php');

    $orders_data = [];

    $query = "SELECT * FROM `order` LIMIT 1000";

    if (!empty($orders = get_db_result($query))) {
        foreach ($orders as $order) {
            $orders_data[] = [
                'order_id' => $order['order_id'],
                'username' => $order['username'],
                'phone' => $order['phone'],
                'address' => $order['address'],
                'total' => formatPrice($order['total']),
                'order_status_id' => $order['order_status_id'],
                'order_status' => getOrderStatus($order['order_status_id']),
                'date_added' => $order['date_added'],
            ];
        }
    }

    return $orders_data;
}

function getOrderStatus($order_status_id) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT name FROM `order_status` WHERE order_status_id = '" . (int)$order_status_id . "'";

    if ($status = get_db_row($query)) {
        return $status['name'];
    } else {
        return '';
    }
}

function getOrder($order_id) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT * FROM `order` WHERE order_id = '" . (int)$order_id . "'";

    $order = get_db_row($query);

    if (!empty($order)) {
        $order['status'] = getOrderStatus($order['order_status_id']);

        $query = "SELECT * FROM `order_item` WHERE order_id = '" . (int)$order_id . "'";

        $order['order_products'] = get_db_result($query);
    }

    return $order;
}

function getOrderProducts($order_id) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "SELECT * FROM `order_item` WHERE order_id = '" . (int)$order_id . "'";

    return get_db_result($query);
}

function editOrder($order_id, $data) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "UPDATE `order` SET username = '" . protect($data['username']) . "', phone = '" . protect($data['phone']) . "', address = '" . protect($data['address']) . "' WHERE order_id = '" . (int)$order_id . "'";
    update_db($query);

    $query = "DELETE FROM `order_item` WHERE order_id = '" . (int)$order_id . "'";
    update_db($query);

    if (!empty($data['order_product'])) {
        $total = 0;

        foreach ($data['order_product'] as $product) {
            $product_total = floatval($product['price']) * intval($product['quantity']);
            $total += $product_total;

            $query = "INSERT INTO `order_item` (order_id, product_id, name, quantity, price, total) VALUES ('" . (int)$order_id . "', '" . (int)$product['product_id'] . "', '" . protect($product['name']) . "', '" . intval($product['quantity']) . "', '" . floatval($product['price']) . "', '" . $product_total . "')";

            update_db($query);
        }

        $query = "UPDATE `order` SET total = '" . (float)$total . "' WHERE order_id = '" . (int)$order_id . "'";
        update_db($query);
    }

    return update_db($query);
}

function deleteOrder($order_id) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "DELETE FROM `order_item` WHERE order_id = '" . (int)$order_id . "'";
    update_db($query);

    $query = "DELETE FROM `order` WHERE order_id = '" . (int)$order_id . "'";

    return update_db($query);
}

function validateOrder($data = []) {
    $errors = [];

    if (trim($data['username']) == '') {
        $errors['username'] = 'Название товара обязательно!';
    }

    return $errors;
}