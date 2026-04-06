-- Tạo bảng products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `description` longtext,
  `price` decimal(10, 2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category` varchar(100),
  `image` varchar(255),
  `status` enum('active', 'inactive') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `customer_id` int(11) NOT NULL,
  `total_amount` decimal(10, 2) NOT NULL,
  `status` enum('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  `shipping_address` text,
  `notes` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`customer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm một số sản phẩm mẫu
INSERT INTO `products` (`name`, `description`, `price`, `stock`, `category`, `status`) VALUES
('Sản Phẩm 1', 'Mô tả sản phẩm 1', 100000, 50, 'Danh Mục 1', 'active'),
('Sản Phẩm 2', 'Mô tả sản phẩm 2', 200000, 30, 'Danh Mục 2', 'active'),
('Sản Phẩm 3', 'Mô tả sản phẩm 3', 150000, 45, 'Danh Mục 1', 'active'),
('Sản Phẩm 4', 'Mô tả sản phẩm 4', 250000, 20, 'Danh Mục 2', 'active'),
('Sản Phẩm 5', 'Mô tả sản phẩm 5', 180000, 60, 'Danh Mục 3', 'active');
