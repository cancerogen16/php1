<?php
function connect_db() {
    static $link = null;
    if (is_null($link)) {
        $link = @mysqli_connect(HOST, USER, PASS, DB_NAME) or die("Connection's error" . mysqli_connect_error());
    }
    return $link;
}

function get_db_result($request) {
    $db = connect_db();
    $result = @mysqli_query($db, $request) or die(mysqli_error($db));
    $array_result = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $array_result[] = $row;
    }
    return $array_result;
}

function get_db_row($request) {
    $db = connect_db();
    $result = @mysqli_query($db, $request) or die(mysqli_error($db));
    $array_result = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $array_result = $row;
    }
    return $array_result;
}

function update_db($request) {
    $db = connect_db();
    @mysqli_query($db, $request) or die(mysqli_error($db));

    return mysqli_affected_rows($db);
}

function protect($val) {
    return strip_tags(htmlspecialchars(mysqli_real_escape_string(connect_db(), $val)));
}

function getLastId() {
    return mysqli_insert_id(connect_db());
}