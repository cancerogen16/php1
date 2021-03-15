<?php
$db_host = "localhost";
$db_name = "shop";
$db_user = "geekbrains";
$db_password = "123456";

$db = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Невозможно подключиться к БД");