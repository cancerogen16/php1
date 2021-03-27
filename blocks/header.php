<?php
include_once __DIR__ . '/../config/config.php';
require_once ENGINE_DIR . "/autoload.php";
?>
<header class="header">
    <div class="container">
        <div class="header-row">
            <div class="header-row__left">
                <?= renderBlock('menu.php', $data) ?>
            </div>
            <div class="header-row__right">
                <div class="cart-wrap">
                    <?= renderBlock('cart.php', $data) ?>
                </div>
                <div class="account-wrap">
                    <?= renderBlock('account.php', $data) ?>
                </div>
            </div>
        </div>
    </div>
</header>