Урок 5. Базы данных MySQL и работа с ними на уровне PHP

Создаём таблицу product_image в базе данных shop
CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Путь к изображению',
  `caption` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Подпись изображения',
  `size` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Размер картинки',
  `views` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Число просмотров',
  `date_created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Дата создания',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;