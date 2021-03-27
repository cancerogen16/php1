<?php

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