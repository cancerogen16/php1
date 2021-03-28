<?php

function addOrder($data) {
    require_once(__DIR__ . '/../config/db.php');

    $date_added = date('Y-m-d H:i:s');

    $query = "INSERT INTO `order` (username, phone, address, order_status_id, date_added) VALUES ('" . protect($data['username']) . "', '" . protect($data['phone']) . "', '" . protect($data['address']) . "', '" . (int)$data['order_status_id'] . "', '" . $date_added . "')";

    update_db($query);

    $order_id = getLastId();

    if (!empty($data['products'])) {

        foreach ($data['products'] as $product_id => $product) {
            $query = "INSERT INTO `order_item` (order_id, product_id, name, quantity, price, total) VALUES ('" . (int)$order_id . "', '" . (int)$product_id . "', '" . protect($product['name']) . "', '" . intval($product['quantity']) . "', '" . floatval($product['price']) . "', '" . floatval($product['total']) . "')";

            update_db($query);
        }
    }

    return $order_id;
}