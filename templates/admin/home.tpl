<div class="page-header">
    <h1>Привет, <b>
            <?php echo htmlspecialchars($_SESSION["username"]); ?>
        </b>. Добро пожаловать в панель
        администратора.
    </h1>
</div>
<p>
    <a href="/logout.php" class="btn btn-danger">Выйти из своей учетной записи</a>
</p>