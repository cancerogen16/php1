<?php

function getOrders() {
    require_once(__DIR__ . '/../config/db.php');

    $orders_data = [];

    $query = "SELECT * FROM `order` LIMIT 1000";

    if (!empty($orders = get_db_result($query))) {
        foreach ($orders as $order) {
            $query = "SELECT name FROM `order_status` WHERE order_status_id = '" . (int)$order['order_status_id'] . "'";
            $status = get_db_row($query)['name'];

            $orders_data[] = [
                'order_id' => $order['order_id'],
                'username' => $order['username'],
                'phone' => $order['phone'],
                'address' => $order['address'],
                'total' => formatPrice($order['total']),
                'order_status_id' => $order['order_status_id'],
                'order_status' => $status,
                'date_added' => $order['date_added'],
            ];
        }
    }

    return $orders_data;
}

function deleteOrder($order_id) {
    require_once(__DIR__ . '/../config/db.php');

    $query = "DELETE FROM `order_item` WHERE order_id = '" . (int)$order_id . "'";
    update_db($query);

    $query = "DELETE FROM `order` WHERE order_id = '" . (int)$order_id . "'";

    return update_db($query);
}