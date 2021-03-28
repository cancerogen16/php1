<ul class="menu">
    <li class="menu__item"><a class="menu__link home-link" href="/">Главная</a></li>
    <li class="menu__item"><a class="menu__link" href="/catalog.php">Каталог товаров</a></li>
    <?php if (isAdmin()) : ?>
    <li class="menu__item"><a class="menu__link" href="/admin/index.php">Панель администратора</a></li>
    <?php endif; ?>
</ul>