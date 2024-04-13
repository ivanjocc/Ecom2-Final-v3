-- Create DB
DROP DATABASE IF EXISTS PetShop;
CREATE DATABASE IF NOT EXISTS PetShop;
USE PetShop;

-- Table 'product'
CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_path` varchar(255) NOT NULL,
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
  `role_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `role_id` (`role_id`),
  FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'user_order'
CREATE TABLE IF NOT EXISTS `user_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ref` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add role super admin
INSERT INTO `role` (`name`, `description`) VALUES ('superadmin', 'Super Administrator');

-- Insert super admin with password '12345678'
INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `role_id`)
VALUES ('superadmin', 'superadmin@admin.ca', '$2y$10$XbVZVwOxlwfv4iiSvMhZdOXiuWWlWhqWJIgZQ5aM5UiUyDhhcHKMa', 'Super', 'Admin', (SELECT `id` FROM `role` WHERE `name` = 'superadmin'));

-- Add role client
INSERT INTO `role` (`name`, `description`) VALUES ('client', 'Client');

-- Insert a client
INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `role_id`)
VALUES ('client', 'client@example.com', '$2y$10$WvUt5YLCr9E6H/sbCdtemeyfdK0xKdxd2cj1.pBpKa42QrIK46qpS', 'Client', 'Client', (SELECT `id` FROM `role` WHERE `name` = 'client'));

-- Insert items by default
INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`, `img_path`)
VALUES 
  ('Product 1', 50, 19.99, '/public/img/product1.png', 'Description Product 1', '/public/img/product1.png'),
  ('Product 2', 30, 29.99, '/public/img/product2.jpg', 'Description Product 2', '/public/img/product2.jpg'),
  ('Product 3', 20, 39.99, '/public/img/product3.jpg', 'Description Product 3', '/public/img/product3.jpg');
