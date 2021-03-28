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
                'order_status' => $order['order_status_id'],
                'date_added' => $order['date_added'],
            ];
        }
    }

    return $orders_data;
}