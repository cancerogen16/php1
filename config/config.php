<?php
define('basePath', dirname(__DIR__));
define('PUBLIC_DIR', basePath . '/public');
define('ENGINE_DIR', basePath . '/engine');
define('UPLOADS_DIR', basePath . '/uploads');
define('TEMPLATES_DIR', basePath . '/templates');
define('IMAGES_DIR', PUBLIC_DIR . '/img');

$db = [
    'database' => 'shop',
    'username' => 'geekbrains',
    'password' => '123456',
];