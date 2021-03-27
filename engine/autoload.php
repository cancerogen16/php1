<?php
require_once __DIR__ . '/../config/config.php';

$files = scandir(ENGINE_DIR);

foreach ($files as $file) {
    if (!in_array(['.', '..', 'autoload.php'], $files)) {
        if (substr($file, -3) == 'php') {
            include_once ENGINE_DIR . DIRECTORY_SEPARATOR . $file;
        }
    }
}