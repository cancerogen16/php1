# Урок 6. Интерактивность: Методы передачи данных GET и POST, работа с формами и пользовательскими данными

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Название товара',
  `quantity` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Количество',
  `price` decimal(15,2) unsigned NOT NULL DEFAULT 0.00 COMMENT 'Цена',
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Путь к изображению',
  `views` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Число просмотров',
  `date_created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Дата создания',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;