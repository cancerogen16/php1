<?php

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
        $query = "INSERT INTO `cart` (user_id, products, session_id, date_added) VALUES ('" . (int)$user_id . "', '" . json_encode($products) . "', '" . session_id() . "', '" . $date_added . "')";
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
        $cart['total'] = number_format((float)$total, 0, ',', ' ');
    }

    return $cart;
}

function deleteCart($user_id) {
    require_once(__DIR__ . '/../config/db.php');

    if ($user_id) {
        $query = "DELETE FROM cart WHERE user_id = '" . (int)$user_id . "'";
    } else {
        $query = "DELETE FROM cart WHERE session_id = '" . session_id() . "'";
    }

    return update_db($query);
}

function changeQuantity($product_id, $user_id, $quantity) {
    require_once(__DIR__ . '/../config/db.php');

    $products = [];

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
                $products[$product_id] = $quantity;
            }
        }

        $query = "UPDATE `cart` SET products = '" . json_encode($products) . "' WHERE cart_id = '" . $cart_id . "'";

        return update_db($query);
    } else {
        return false;
    }
}