-- Create DB
DROP DATABASE IF EXISTS PetShop;
CREATE DATABASE IF NOT EXISTS PetShop;
USE PetShop;

-- Create tables

-- Table 'address'
CREATE TABLE IF NOT EXISTS `address` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `street_name` varchar(255) NOT NULL,
  `street_nb` int(11) NOT NULL,
  `city` varchar(40) NOT NULL,
  `province` varchar(40) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `country` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'order_has_product'
CREATE TABLE IF NOT EXISTS `order_has_product` (
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  PRIMARY KEY (`product_id`,`order_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'product'
CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'role'
CREATE TABLE IF NOT EXISTS `role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'user'
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `billing_address_id` bigint(20) NOT NULL,
  `shipping_address_id` bigint(20) NOT NULL,
  `token` varchar(255) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'user_order'
CREATE TABLE IF NOT EXISTS `user_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ref` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'order_has_product'
ALTER TABLE `order_has_product`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `user_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Table 'user'
ALTER TABLE `user`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Table 'user_order'
ALTER TABLE `user_order`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Add role super admin
INSERT INTO `role` (`name`, `description`) VALUES ('superadmin', 'Super Administrator');

-- Insert super admin with password '12345678'
INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `billing_address_id`, `shipping_address_id`, `token`, `role_id`)
VALUES ('superadmin', 'superadmin@admin.ca', '$2y$10$XbVZVwOxlwfv4iiSvMhZdOXiuWWlWhqWJIgZQ5aM5UiUyDhhcHKMa', 'Super', 'Admin', 1, 1, '', (SELECT `id` FROM `role` WHERE `name` = 'superadmin'));

-- Add rol client
INSERT INTO `role` (`name`, `description`) VALUES ('client', 'Client');

-- Insert a client
INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `billing_address_id`, `shipping_address_id`, `token`, `role_id`)
VALUES ('client', 'test@example.com', '$2y$10$WvUt5YLCr9E6H/sbCdtemeyfdK0xKdxd2cj1.pBpKa42QrIK46qpS', 'test', 'client', 2, 2, '', (SELECT `id` FROM `role` WHERE `name` = 'client'));

-- Insert items par default
INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`)
VALUES 
  ('Product 1', 50, 19.99, '/public/img/product1.png', 'Description Product 1'),
  ('Product 2', 30, 29.99, '/public/img/product2.jpg', 'Description Product 2'),
  ('Product 3', 20, 39.99, '/public/img/product3.jpg', 'Description Product 3');

ALTER TABLE `product`
ADD COLUMN `img_path` varchar(255) NOT NULL;
