<?php

$logged = false;

$username = '';

if (!empty($_SESSION["username"])) {
    $logged = true;
    $username = htmlspecialchars($_SESSION["username"]);
}

?>
<div class="account">
    <?php if ($logged) : ?>
    <div class="login">
        <?php echo $username; ?>
    </div>
    |
    <div class="logout">
        <a href="logout.php">Выйти</a>
    </div>
    <?php else : ?>
    <div class="login">
        <a href="login.php">Войти</a>
    </div>
    |
    <div class="register">
        <a href="register.php">Регистрация</a>
    </div>
    <?php endif; ?>
</div>