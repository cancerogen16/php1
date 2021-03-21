<?php
require_once __DIR__ . '/../config/config.php';

require_once(ENGINE_DIR . '/functions.php');
require_once(ENGINE_DIR . '/db_model.php');
?>
<header class="header">
    <div class="container">
        <div class="header-row">
            <div class="header-row__left">
                <?php require_once(TEMPLATES_DIR . '/menu.php'); ?>
            </div>
            <div class="header-row__right">
                <?php require_once(TEMPLATES_DIR . '/account.php'); ?>
            </div>
        </div>
    </div>
</header>