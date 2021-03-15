<h2>Загрузка изображений</h2>

<form enctype="multipart/form-data" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <input type="file" name="file">
    <input type="text" name="caption" value="" placeholder="Название изображения" />
    <input type="submit" value="Загрузить файл!" />
</form>

<div class="message"><?= $message ?></div>