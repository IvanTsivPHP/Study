-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.29 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.0.0.5944
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица mydb.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mydb.categories: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
	(1, 'Женщины', NULL),
	(2, 'Мужчины', NULL),
	(3, 'Дети', NULL),
	(4, 'Аксессуары', NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Дамп структуры для таблица mydb.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `creation_time` datetime DEFAULT NULL,
  `customer_name` varchar(45) DEFAULT NULL,
  `customer_surname` varchar(45) DEFAULT NULL,
  `customer_patronymic` varchar(45) DEFAULT NULL,
  `delivery` tinyint(1) DEFAULT '0',
  `delivery_city` varchar(45) DEFAULT NULL,
  `delivery_street` varchar(45) DEFAULT NULL,
  `delivery_home` varchar(45) DEFAULT NULL,
  `delivery_aprt` varchar(45) DEFAULT NULL,
  `commentary` text,
  `customer_phone` varchar(45) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `cash_payment` tinyint(1) DEFAULT '0',
  `price` decimal(12,2) DEFAULT NULL,
  `done_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mydb.orders: ~11 rows (приблизительно)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `product_id`, `creation_time`, `customer_name`, `customer_surname`, `customer_patronymic`, `delivery`, `delivery_city`, `delivery_street`, `delivery_home`, `delivery_aprt`, `commentary`, `customer_phone`, `customer_email`, `cash_payment`, `price`, `done_status`) VALUES
	(1, 2, '2020-10-05 00:00:00', 'Ivan', 'Petrov', NULL, 1, 'Novosibirsk', 'Kirova', '33', '33', NULL, '812345678', 'custom@email.com', 0, 3333.00, 0),
	(2, 2, '2020-10-09 00:00:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 22222.00, 1),
	(3, 1, '2020-10-05 00:00:00', 'adfasdf', 'sgfdsf', '', 0, '', '', '', '', '', '', '', 0, 31214.00, 1),
	(4, 2, '2020-10-05 12:24:44', 'adfasdf', 'sgfdsf', '', 0, '', '', '', '', '', '', '', 0, 122313.00, 0),
	(5, 3, '2020-10-05 12:30:39', 'Ivan', 'Petrov', '', 1, 'Novos', 'Kirov', '12', '4444', '', '', '', 0, 5435325.00, 0),
	(6, 2, '2020-10-05 12:33:48', 'Viktor', 'Kozlov', '', 1, 'City', 'Strt', '22', '111', '', '', '', 1, 2234.00, 0),
	(7, 1, '2020-10-05 12:35:16', 'Viktor', 'Kozlov', '', 1, 'City', 'Strt', '22', '111', '', '', '', 1, 65345.00, 0),
	(8, 2, '2020-10-05 12:35:47', 'Viktor', 'Kozlov', '', 1, 'City', 'Strt', '22', '111', '', '', '', 1, 34534.00, 0),
	(9, 1, '2020-10-05 12:37:49', 'Петр', 'Петров', 'Петрович', 1, 'Н', 'У', '12', '34', '', '', '', 0, 56765.00, 0),
	(10, 1, '2020-10-05 12:41:58', 'Петр', 'Петров', 'Петрович', 1, 'Н', 'У', '12', '34', '', '123', 'Ага', 0, 6664564.00, 0),
	(11, 1, '2020-10-05 12:46:04', 'Петр', 'Петров', 'Петрович', 1, 'Н', 'У', '12', '34', 'Коммент', '123', 'Ага', 0, 34543.00, 0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Дамп структуры для таблица mydb.orders_products
CREATE TABLE IF NOT EXISTS `orders_products` (
  `orders_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  PRIMARY KEY (`orders_id`,`products_id`),
  KEY `fk_orders_products_products1_idx` (`products_id`),
  CONSTRAINT `fk_orders_products_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_products_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mydb.orders_products: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `orders_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_products` ENABLE KEYS */;

-- Дамп структуры для таблица mydb.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `new` tinyint(1) DEFAULT '1',
  `sale` tinyint(1) DEFAULT '0',
  `price` decimal(12,2) DEFAULT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mydb.products: ~17 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `new`, `sale`, `price`, `picture`) VALUES
	(2, 'Платье женское', 1, 1, 4200.00, 'product-3.jpg'),
	(3, 'Спиннер', 1, 0, 1200.00, 'product-3(1).jpg'),
	(4, 'Трусы мужские', 1, 0, 500.00, 'product-11.jpg'),
	(5, 'Запанки', 0, 1, 2300.00, 'product-12.jpg'),
	(6, 'Костюм тройка', 0, 0, 5000.00, 'product-13.jpg'),
	(7, 'Полусапожки', 0, 0, 3400.00, 'product-9.jpg'),
	(8, 'Шапка с пропеллером', 1, 0, 1100.00, 'product-14.jpg'),
	(9, 'Комбинезон', 0, 0, 2500.00, 'product-15.jpg'),
	(10, 'Платье женское', 1, 1, 3400.00, 'product-1.jpg'),
	(11, 'Брюки женские', 1, 0, 2000.00, 'product-4.jpg'),
	(12, 'Сумочка', 0, 0, 1300.00, 'product-5.jpg'),
	(13, 'Свитер админский', 1, 1, 2330.00, 'product-16.jpg'),
	(14, 'Свитер детский', 0, 0, 2500.00, 'product-17.jpg'),
	(15, 'Ранец', 0, 0, 1333.00, 'product-18.jpg'),
	(16, 'Зонт катана', 0, 1, 3333.00, 'product-19.jpg'),
	(17, 'Пламбус', 1, 0, 5000.00, 'product-20.jpg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица mydb.products_categories
CREATE TABLE IF NOT EXISTS `products_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`) USING BTREE,
  KEY `fk_products_categories_categories1_idx` (`category_id`) USING BTREE,
  CONSTRAINT `fk_products_categories_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_products_categories_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mydb.products_categories: ~25 rows (приблизительно)
/*!40000 ALTER TABLE `products_categories` DISABLE KEYS */;
INSERT INTO `products_categories` (`product_id`, `category_id`) VALUES
	(2, 1),
	(3, 1),
	(7, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(17, 1),
	(4, 2),
	(5, 2),
	(6, 2),
	(13, 2),
	(15, 2),
	(17, 2),
	(8, 3),
	(9, 3),
	(14, 3),
	(15, 3),
	(17, 3),
	(2, 4),
	(3, 4),
	(5, 4),
	(12, 4),
	(15, 4),
	(16, 4);
/*!40000 ALTER TABLE `products_categories` ENABLE KEYS */;

-- Дамп структуры для таблица mydb.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mydb.roles: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `description`) VALUES
	(1, 'manager', NULL),
	(2, 'administrator', NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Дамп структуры для таблица mydb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mydb.users: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`) VALUES
	(1, 'admin@mail.com', '$2y$10$HP.mdhHaa5QzQaYhkqCGzuj/IHffAsu6ehpen0gNYn5KIY1LpjRfK'),
	(2, 'manager@mail.com', '$2y$10$yQcB29mR.K64Nh11SzWpO.N0wvR78MB8buOTtktgGCH5YDRQQdlSS');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Дамп структуры для таблица mydb.users_roles
CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`) USING BTREE,
  KEY `fk_users_roles_roles1_idx` (`role_id`) USING BTREE,
  CONSTRAINT `fk_users_roles_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_roles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mydb.users_roles: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(1, 2);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
