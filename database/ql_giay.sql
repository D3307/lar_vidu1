-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 24, 2025 lúc 12:25 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ql_giay`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `expiration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Stiletto Heels', 'Giày gót nhọn', '2025-09-12 00:39:36', '2025-09-12 00:39:36'),
(2, 'Block Heels', 'Giày gót vuông', '2025-09-12 00:41:09', '2025-09-12 00:41:09'),
(3, 'Wedge Heels', 'Giày gót đế xuồng', '2025-09-12 00:44:10', '2025-09-12 00:44:10'),
(4, 'Cone Heels', 'Giày gót nón', '2025-09-12 00:44:41', '2025-09-12 03:45:57'),
(5, 'Kitten Heels', 'Giày gót Kitten', '2025-09-12 00:47:01', '2025-09-12 00:47:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `discount` decimal(12,2) NOT NULL,
  `discount_type` enum('percent','fixed') DEFAULT 'percent',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `min_order_value` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount`, `discount_type`, `start_date`, `end_date`, `usage_limit`, `created_at`, `updated_at`, `min_order_value`) VALUES
(1, 'WELCOME30', 30.00, 'percent', '2025-09-12', '2025-10-12', 100, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 0.00),
(2, 'SALE10', 10.00, 'percent', '2025-09-12', '2025-10-12', 20, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 200000.00),
(3, 'SALE20', 20.00, 'percent', '2025-09-12', '2025-10-12', 150, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 300000.00),
(4, 'FREESHIP50', 5000.00, 'fixed', '2025-09-12', '2025-10-12', 300, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 150000.00),
(5, 'VIP15', 15.00, 'percent', '2025-09-12', '2025-11-11', 500, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 500000.00),
(6, 'NEWUSER50', 30000.00, 'fixed', '2025-09-12', '2025-10-12', 1000, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 0.00),
(7, 'WEEKEND25', 25.00, 'percent', '2025-09-12', '2025-09-19', 100, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 250000.00),
(8, 'FLASH100K', 50000.00, 'fixed', '2025-09-12', '2025-09-17', 50, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 400000.00),
(9, 'BIRTHDAY30', 30.00, 'percent', '2025-09-12', '2026-09-12', 999, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 0.00),
(10, 'LOYAL20', 20.00, 'percent', '2025-09-12', '2025-12-11', 300, '2025-09-12 11:29:20', '2025-09-12 11:29:20', 600000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `min_quantity` int(11) NOT NULL DEFAULT 0,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `inventories`
--

INSERT INTO `inventories` (`id`, `product_id`, `quantity`, `min_quantity`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, 9999, 10, NULL, '2025-09-15 03:54:14', '2025-09-21 00:59:52'),
(2, 2, 687, 5, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(3, 3, 2524, 15, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(4, 4, 10, 8, NULL, '2025-09-15 03:54:14', '2025-09-22 13:02:48'),
(5, 5, 2483, 20, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(6, 6, 359, 3, NULL, '2025-09-15 03:54:14', '2025-09-22 13:05:00'),
(7, 7, 1685, 2, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(8, 8, 4595, 4, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(9, 9, 3, 5, NULL, '2025-09-15 03:54:14', '2025-09-22 12:17:57'),
(10, 10, 2525, 15, NULL, '2025-09-15 03:54:14', '2025-09-21 00:59:01'),
(11, 11, 1, 8, NULL, '2025-09-15 03:54:14', '2025-09-22 14:04:05'),
(12, 12, 4562, 20, NULL, '2025-09-15 03:54:14', '2025-09-21 00:45:26'),
(13, 13, 1854, 3, NULL, '2025-09-15 03:54:14', '2025-09-21 00:00:34'),
(14, 14, 2000, 2, NULL, '2025-09-15 03:54:14', '2025-09-22 05:17:47'),
(15, 15, 0, 4, NULL, '2025-09-15 03:54:14', '2025-09-22 14:04:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_09_12_070931_create_sessions_table', 1),
(2, '2025_09_12_133659_create_password_reset_tokens_table', 2),
(3, '2025_09_15_033717_create_inventories_table', 3),
(4, '2025_09_18_035442_create_wishlists_table', 4),
(5, '2025_09_21_070955_add_momo_order_id_to_orders_table', 5),
(6, '2025_09_21_090906_create_stock_movements_table', 6),
(7, '2025_09_22_113023_create_transactions_table', 7),
(8, '2025_09_22_113138_create_transactions_details_table', 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `momo_order_id` varchar(255) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `discount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `final_total` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `payment_status` varchar(50) DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_method` enum('cod','momo') DEFAULT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `momo_order_id`, `name`, `phone`, `address`, `user_id`, `total`, `discount`, `final_total`, `status`, `payment_status`, `created_at`, `updated_at`, `payment_method`, `coupon_id`) VALUES
(2, NULL, 'Thảo', '0944763697', 'Hà Nội', 4, 3690000.00, 120000, 480000, 'pending', 'unpaid', '2025-09-12 05:46:27', '2025-09-12 05:46:27', 'cod', 10),
(3, NULL, 'Thảo', '0944763697', 'Hà Nội', 4, 3690000.00, 120000, 3570000, 'delivered', 'paid', '2025-09-12 05:49:23', '2025-09-14 19:29:09', 'cod', 10),
(4, NULL, 'Thảo', '0944763697', 'Hà Nội', 4, 4275000.00, 120000, 4155000, 'shipping', 'unpaid', '2025-09-12 05:55:25', '2025-09-14 22:44:54', 'cod', 10),
(5, NULL, 'Thảo', '0944763697', 'Hà Nội', 4, 740000.00, 120000, 620000, 'pending', 'unpaid', '2025-09-12 05:57:53', '2025-09-12 05:57:53', 'cod', 10),
(6, NULL, 'Linh', '0123456789', 'Nam Định', 5, 1049000.00, 262250, 786750, 'shipping', 'paid', '2025-09-14 23:01:28', '2025-09-15 07:04:25', 'momo', 7),
(8, NULL, 'Linh', '0987654321', 'Ha Noi', 5, 945000.00, 5000, 940000, 'delivered', 'paid', '2025-09-14 23:24:01', '2025-09-15 05:24:41', 'momo', 4),
(9, NULL, 'Lan', '098765431', 'Ha Noi', 10, 549000.00, 146700, 402300, 'processing', 'paid', '2025-09-15 00:58:44', '2025-09-15 00:58:44', 'momo', 1),
(11, NULL, 'Linh', '0987654321', 'Ha Noi', 5, 549000.00, 109800, 439200, 'delivered', 'paid', '2025-09-15 03:47:20', '2025-09-18 10:00:21', 'momo', 3),
(12, NULL, 'Lan', '0123456789', 'Ha Noi', 10, 370000.00, 37000, 333000, 'shipping', 'paid', '2025-09-15 03:53:07', '2025-09-15 05:24:12', 'momo', 2),
(13, NULL, 'Lan', '0987654321', 'Ha Noi', 10, 549000.00, 50000, 499000, 'cancelled', 'paid', '2025-09-15 03:56:48', '2025-09-15 05:24:02', 'momo', 8),
(14, NULL, 'Lan', '09763733737', 'Ha Noi', 10, 499000.00, 149700, 349300, 'processing', 'paid', '2025-09-15 04:05:43', '2025-09-15 05:21:22', 'momo', 1),
(15, NULL, 'Lan', '0123456789', 'Ha Noi', 10, 499000.00, 49900, 449100, 'delivered', 'paid', '2025-09-15 04:16:13', '2025-09-15 05:23:56', 'momo', 2),
(16, NULL, 'Lan', '0987654321', 'Hà Nội', 10, 549000.00, 164700, 384300, 'cancelled', 'paid', '2025-09-15 05:02:23', '2025-09-15 05:23:51', 'momo', 1),
(17, NULL, 'Linh', '0987654321', 'Hà Nội', 5, 549000.00, 50000, 499000, 'delivered', 'unpaid', '2025-09-15 05:47:48', '2025-09-18 09:59:50', 'cod', 8),
(18, NULL, 'Linh', '0987654321', 'Hà Nội', 5, 945000.00, 189000, 756000, 'cancelled', 'paid', '2025-09-15 06:00:58', '2025-09-15 06:59:44', 'momo', 10),
(19, NULL, 'Linh', '0987654321', 'Hà Nội', 5, 549000.00, 50000, 499000, 'delivered', 'paid', '2025-09-15 06:41:19', '2025-09-18 09:37:12', 'cod', 8),
(47, NULL, 'Linh', '0987654321', 'Ha Noi', 5, 890000.00, 267000, 623000, 'pending', 'unpaid', '2025-09-18 15:48:58', '2025-09-18 15:48:58', 'cod', 1),
(48, 'ORDER_48_1758439642', 'Thảo', '0944763697', 'Ha Noi', 4, 370000.00, 111000, 259000, 'delivered', 'paid', '2025-09-21 00:00:34', '2025-09-22 12:49:40', 'momo', 1),
(49, 'ORDER_49_1758441056', 'Thảo', '0944763697', 'Ha Noi', 4, 850000.00, 255000, 595000, 'delivered', 'paid', '2025-09-21 00:45:26', '2025-09-22 12:49:34', 'momo', 9),
(52, 'ORDER_52_1758444950', 'Thảo', '0944763697', 'Ha Noi', 4, 549000.00, 164700, 384300, 'delivered', 'paid', '2025-09-21 01:21:45', '2025-09-22 12:49:28', 'momo', 1),
(53, 'ORDER_53_1758569301', 'Thảo', '0944763697', 'Ha Noi', 4, 620000.00, 186000, 434000, 'delivered', 'paid', '2025-09-22 12:17:57', '2025-09-22 12:49:23', 'momo', 9);

--
-- Bẫy `orders`
--
DELIMITER $$
CREATE TRIGGER `set_order_status_before_insert` BEFORE INSERT ON `orders` FOR EACH ROW BEGIN
    -- Nếu đã thanh toán thì cho vào trạng thái chờ giao hàng
    IF NEW.payment_status = 'paid' THEN
        SET NEW.status = 'processing';
    ELSE
        SET NEW.status = 'pending';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_order_status_before_update` BEFORE UPDATE ON `orders` FOR EACH ROW BEGIN
    IF NEW.payment_status = 'paid' AND NEW.status = 'pending' THEN
        SET NEW.status = 'processing';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `color`, `size`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 3, '#fffdd0', '35', 1, 945000.00, '2025-09-12 05:46:27', '2025-09-12 05:46:27'),
(3, 2, 1, '#ffc0cb', '38', 5, 549000.00, '2025-09-12 05:46:27', '2025-09-12 05:46:27'),
(4, 3, 3, '#fffdd0', '35', 1, 945000.00, '2025-09-12 05:49:23', '2025-09-12 05:49:23'),
(5, 3, 1, '#ffc0cb', '38', 5, 549000.00, '2025-09-12 05:49:23', '2025-09-12 05:49:23'),
(6, 4, 2, NULL, NULL, 5, 855000.00, '2025-09-12 05:55:25', '2025-09-12 05:55:25'),
(7, 5, 4, NULL, NULL, 1, 740000.00, '2025-09-12 05:57:53', '2025-09-12 05:57:53'),
(8, 6, 15, '#000000', '35', 1, 450000.00, '2025-09-14 23:01:28', '2025-09-14 23:01:28'),
(9, 6, 5, '#000000', '35', 1, 599000.00, '2025-09-14 23:01:28', '2025-09-14 23:01:28'),
(11, 8, 3, '#fffdd0', '35', 1, 945000.00, '2025-09-14 23:24:01', '2025-09-14 23:24:01'),
(12, 9, 1, '#ffc0cb', '35', 1, 549000.00, '2025-09-15 00:58:44', '2025-09-15 00:58:44'),
(14, 11, 1, '#ffc0cb', '35', 1, 549000.00, '2025-09-15 03:47:20', '2025-09-15 03:47:20'),
(15, 12, 13, NULL, NULL, 1, 370000.00, '2025-09-15 03:53:07', '2025-09-15 03:53:07'),
(16, 13, 8, '#a52a2a', '35', 1, 549000.00, '2025-09-15 03:56:48', '2025-09-15 03:56:48'),
(17, 14, 6, NULL, NULL, 1, 499000.00, '2025-09-15 04:05:43', '2025-09-15 04:05:43'),
(18, 15, 6, NULL, NULL, 1, 499000.00, '2025-09-15 04:16:13', '2025-09-15 04:16:13'),
(19, 16, 11, '#ffc0cb', '37', 1, 549000.00, '2025-09-15 05:02:23', '2025-09-15 05:02:23'),
(20, 17, 1, NULL, NULL, 1, 549000.00, '2025-09-15 05:47:48', '2025-09-15 05:47:48'),
(21, 18, 3, NULL, NULL, 1, 945000.00, '2025-09-15 06:00:58', '2025-09-15 06:00:58'),
(22, 19, 1, NULL, NULL, 1, 549000.00, '2025-09-15 06:41:19', '2025-09-15 06:41:19'),
(49, 47, 10, NULL, NULL, 1, 890000.00, '2025-09-18 15:48:58', '2025-09-18 15:48:58'),
(50, 48, 13, NULL, NULL, 1, 370000.00, '2025-09-21 00:00:34', '2025-09-21 00:00:34'),
(51, 49, 12, NULL, NULL, 1, 850000.00, '2025-09-21 00:45:26', '2025-09-21 00:45:26'),
(54, 52, 11, NULL, NULL, 1, 549000.00, '2025-09-21 01:21:45', '2025-09-21 01:21:45'),
(55, 53, 9, '#fffdd0', '36', 1, 620000.00, '2025-09-22 12:17:57', '2025-09-22 12:17:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `image`, `material`, `description`, `price`, `created_at`, `updated_at`) VALUES
(1, 5, 'Giày Cao Gót Slingback Phối Liệu Bóng', 'products/1757669169_1755787092_giayphoixich.jpeg', 'Si bóng', 'Giày Cao Gót Slingback Phối Liệu Bóng thanh lịch, nữ tính\r\n\r\nThiết kế mũi nhọn, quai cách eo mang lại nét uyển chuyển trên từng bước chân\r\n\r\nGót cao 5cm kèm miếng đệm chống trơn trượt cho bạn dễ dàng di chuyển\r\n\r\nChất liệu da cao cấp tổng hợp. Giày phù hợp đi mọi dịp, như đi làm, dạo phố', 549000.00, '2025-09-12 02:26:09', '2025-09-21 00:59:52'),
(2, 1, 'Giày bít mũi nhọn gót stiletto', 'products/1757670291_giaybitmuinhon.jpg', 'Da nhân tạo', 'Mã sản phẩm: 1010BMN0738\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót nhọn\r\nĐộ cao gót: 9 cm\r\nLoại mũi: Bít mũi nhọn\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Pumps', 855000.00, '2025-09-12 02:43:22', '2025-09-15 03:36:36'),
(3, 1, 'Giày bít mũi block heel phối khóa trang trí', 'products/1757670432_giaybitmuiphoikhoa.jpg', 'Da nhân tạo', 'Mã sản phẩm: 1010BMN0735\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót dạng khối\r\nĐộ cao gót: 6.5 cm\r\nLoại mũi: Bít mũi vuông\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Pumps', 945000.00, '2025-09-12 02:47:12', '2025-09-12 02:47:12'),
(4, 1, 'Giày slingback mũi nhọn phối khóa đôi', 'products/1757670596_giayslingbackmuinhonphoikhoadoi.jpg', 'Da nhân tạo phủ bóng', 'Mã sản phẩm: 1010BMN0731\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót nhọn\r\nĐộ cao gót: 8.5 cm\r\nLoại mũi: Bít mũi nhọn\r\nChất liệu: Da nhân tạo phủ bóng\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Mary Jane', 740000.00, '2025-09-12 02:49:56', '2025-09-22 13:02:48'),
(5, 2, 'Giày sandal gót vuông quai ngang phối khóa trang trí', 'products/1757671059_giaysandalgotvuongquaingang.jpeg', 'Si bóng', 'Giày Sandal Gót Vuông Quai Ngang Phối Khóa Trang Trí sành điệu\r\n\r\nQuai hậu phối khóa kim loại, gót trụ cao mang lại nét hiện đại, thời trang\r\n\r\nChất liệu da tổng hợp bền đẹp, dễ vệ sinh\r\n\r\nĐế bằng cao 9cm thanh lịch, dễ dàng di chuyển\r\n\r\nCó 3 màu cơ bản cho bạn dễ dàng lựa chọn và phối đồ', 599000.00, '2025-09-12 02:57:39', '2025-09-12 02:57:39'),
(6, 2, 'Giày sandal gót vuông quai ngang phối khóa trang trí', 'products/1757671441_giaysandalgotvuongquaingangphoikhoa.jpeg', 'Da cao cấp tổng hợp', 'Giày sandal gót vuông quai ngang phối khoá trang trí tinh tế, thanh lịch\r\n\r\nGót vuông cao 5cm tạo cảm giác chắc chắn\r\n\r\nThiết kế thông minh với miếng đệm chống trơn trượt giúp đảm bảo an toàn cho bạn và tạo sự thoải mái trong lúc di chuyển\r\n\r\nChất liệu da tổng hợp cao cấp, dễ bảo quản, bền đẹp\r\n\r\nPhù hợp đi làm, đi tiệc, dạo phố', 499000.00, '2025-09-12 03:04:01', '2025-09-22 13:05:00'),
(7, 1, 'Giày Cao Gót Cao Gót Mũi Nhọn', 'products/1757671702_giaycaogotmuinhon.jpg', 'Si bóng', 'Giày Cao Gót Cao Gót Mũi Nhọn thanh lịch, nữ tính\r\n\r\nGiày thiết kế mũi nhọn, quai cổ chân cách điệu mang lại nét đẹp uyển chuyển khi diện\r\n\r\nGót cao 5cm kèm miếng đệm chống trơn trượt cho bạn dễ dàng di chuyển\r\n\r\nChất liệu da cao cấp tổng hợp. Giày phù hợp đi mọi dịp, như đi làm, dạo phố', 499000.00, '2025-09-12 03:08:22', '2025-09-12 03:08:22'),
(8, 5, 'Giày Cao Gót Quai Mary Jane', 'products/1757932529_giaycaogotquaimaryjane.jpeg', 'Si mờ trơn', 'Giày Cao Gót Quai Mary Jane thanh lịch\r\n\r\nMũi nhọn, quai nganh thanh mảnh, và gót bọc kim loại cực kì nữ tính\r\n\r\nThiết kế thông minh với đệm chống trơn trượt giúp đảm bảo an toàn cho bạn và tạo sự thoải mái trong lúc di chuyển\r\n\r\nChất liệu da tổng hợp cao cấp, dễ bảo quản, bền đẹp\r\n\r\nGiày có 3 màu dễ phối đồ. Phù hợp để đi làm, dạo phố, đi tiệc', 549000.00, '2025-09-12 03:12:20', '2025-09-15 03:35:31'),
(9, 4, 'Giày Cao Gót Đông Hải Bít Mũi Nhấn Quai Ankle Strap', 'products/1757672242_giayanklestrap.jpg', 'Da tổng hợp (PU)', 'Giày cao gót Đông Hải không chỉ là phụ kiện, mà là tuyên ngôn thời trang. Mẫu giày được thiết kế dành riêng cho những quý cô hiện đại, yêu thích sự thanh lịch nhưng vẫn muốn giữ nét trẻ trung, cuốn hút. Phần quai tinh tế ôm sát bàn chân, tạo nên vẻ đẹp duyên dáng. Độ cao 5cm không chỉ giúp tôn dáng mà còn mang lại sự thoải mái khi di chuyển cả ngày. Kiểu dáng hiện đại kết hợp cùng chất liệu cao cấp giúp đôi giày này trở thành điểm nhấn hoàn hảo cho bất kỳ trang phục nào!', 620000.00, '2025-09-12 03:17:22', '2025-09-22 12:17:57'),
(10, 4, 'Giày Cao Gót Zucia Mary Jane Đính Đá', 'products/1757674759_giaymaryjane.jpg', 'Da tổng hợp (PU)', 'Giày cao gót mang phong cách cổ điển nhưng đầy cuốn hút, mẫu giày Mary Jane gót vuông sẽ là điểm nhấn hoàn hảo cho quý cô yêu thích nét thanh lịch pha chút kiêu sa và sang trọng. Chất liệu da bóng trở nên thu hút khi diện dưới ánh đèn, chi tiết khóa đá lấp lánh ở quai tạo điểm nhấn nữ tính. Giày nữ có gót vuông cao 5cm giúp dáng đi vững vàng, duyên dáng cả ngày dài. Dù kết hợp cùng váy tiểu thư, đầm dạ tiệc hay đơn giản là quần tây, quần jean thì đôi giày này chắc chắn sẽ nâng tầm phong cách, giúp người diện trở nên ấn tượng.', 890000.00, '2025-09-12 03:25:40', '2025-09-21 00:59:01'),
(11, 3, 'Giày Sandal Đế Xuồng Quai Chéo', 'products/1757672862_giaydexuong.jpg', 'Si mờ trơn', 'Giày Sandal Đế Xuồng Quai Chéo thời trang, nữ tính\r\n\r\nThiết kế đế xuồng chắc chắn, quai đan chéo và quan cổ chân mang lại sự nổi bật và chắc chắn khi diện\r\n\r\nĐế bằng cao 9cm dễ dàng phối với nhiều bộ trang phục khác nhau\r\n\r\nChất liệu da tổng hợp bền đẹp, dễ vệ sinh', 549000.00, '2025-09-12 03:27:43', '2025-09-22 14:04:05'),
(12, 1, 'Giày Cao Gót Đông Hải Satin Đính Pha Lê Sang Trọng', 'products/1757673114_giaysatin.jpg', 'Da tổng hợp (PU)', 'Giày cao gót Đông Hải vải satin với thiết kế sang trọng sẽ là lựa chọn lý tưởng dành cho quý cô hiện đại hướng đến phong cách thời thượng. Đặc biệt, họa tiết đính đá pha lê tựa như một bông hoa gợi lên vẻ đẹp rạng rỡ, tăng phần tự tin khi diện. Đế nhọn cao 7cm tôn dáng, mang lại cảm giác thanh mảnh trong mỗi bước chân.', 850000.00, '2025-09-12 03:31:54', '2025-09-21 00:45:26'),
(13, 2, 'Giày Sandal Gót Vuông Quai Xé Dán', 'products/1757673608_giaysandalgotvuong.jpg', 'Si mờ trơn', 'Chất liệu da tổng hợp bền, đẹp\r\n\r\nQuai ngang thiết kế đơn giản, nữ tính\r\n\r\nQuai hậu dán, tiện dụng', 370000.00, '2025-09-12 03:40:08', '2025-09-21 00:00:34'),
(14, 1, 'Giày Cao Gót Zuciani Đế Nhọn Da Phối', 'products/1757674448_giaycaogotZucianidenhondaphoi.jpg', 'Da cao cấp', 'Giày cao gót Zuciani là mẫu giày được hầu hết nhiều quý cô yêu thích lựa chọn bởi vừa dễ mang dễ phối vừa tôn dáng nhưng vẫn giữa được nét duyên dáng, uyển chuyển khi mang.', 2450000.00, '2025-09-12 03:54:08', '2025-09-18 14:11:52'),
(15, 4, 'Giày cao gót viền cổ cao gót nón', 'products/1757674606_giaycaogotviencocaogotnon.jpg', 'Da tổng hợp', 'Thiết kế dáng pump cổ điển được thổi hơi thở hiện đại hơn với gót nhọn hình chóp lạ mắt\r\n\r\nChất liệu da tổng hợp bóng mờ sang trọng, dễ vệ sinh\r\n\r\nDưới đé có rãnh chống trượt cho bước đi tự tin, thoải mái', 450000.00, '2025-09-12 03:56:46', '2025-09-22 14:04:05');

--
-- Bẫy `products`
--
DELIMITER $$
CREATE TRIGGER `after_product_delete` AFTER DELETE ON `products` FOR EACH ROW BEGIN
    DELETE FROM inventories WHERE product_id = OLD.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_product_insert` AFTER INSERT ON `products` FOR EACH ROW BEGIN
    INSERT INTO inventories (product_id, quantity) 
    VALUES (NEW.id, 0);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_details`
--

CREATE TABLE `product_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(100) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `color`, `size`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, '#000000,#ffc0cb,#fffdd0', '35,36,37,38,39', 9999, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(2, 2, '#000000,#fffdd0', '35,36,37,38,39', 687, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(3, 3, '#000000,#fffdd0', '35,36,37,38,39', 2524, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(4, 4, '#800000,#000000', '35,36,37,38,39', 10, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(5, 5, '#800000,#000000,#fffdd0', '35,36,37,38,39', 2483, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(6, 6, '#000000,#fffdd0,#aaaaaa', '35,36,37,38,39', 359, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(7, 7, '#000000,#fffdd0', '35,36,37,38,39', 1685, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(8, 8, '#000000,#ffc0cb,#a52a2a', '35,36,37,38,39', 4595, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(9, 9, '#fffdd0,#0a0a0a,#fcdad5', '35,36,37,38,39', 3, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(10, 10, '#000000,#fcdad5,#B79d98', '35,36,37,38,39', 2525, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(11, 11, '#000000,#ffc0cb,#fffdd0', '37,38,39', 1, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(12, 12, '#800000,#000000,#fffdd0', '35,36,37,38', 4562, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(13, 13, '#e6ddce,#f3ece2,#000000', '35,38', 1854, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(14, 14, '#20232a,#704a3d', '35,36,37,38,39', 0, '2025-09-25 07:51:57', '2025-09-25 07:51:57'),
(15, 15, '#B79d98,#000000,#fffdd0', '35,36,37,38,39', 0, '2025-09-25 07:51:57', '2025-09-25 07:51:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `order_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(2, 5, 19, 1, 5, 'Sẽ tiếp tục quay lại ủng hộ shop', '2025-09-18 09:50:37', '2025-09-18 09:50:37'),
(3, 5, 8, 3, 2, 'Giao hàng chậm', '2025-09-18 09:55:12', '2025-09-18 09:55:12'),
(4, 5, 11, 1, 4, 'Shop cần xem xét lại thái độ nhân viên', '2025-09-18 10:01:05', '2025-09-18 10:01:05'),
(5, 4, 3, 3, 5, 'Lần đầu mua hàng của shop, sẽ dùng thử 1 thời gian và quay lại đánh giá', '2025-09-20 23:57:03', '2025-09-20 23:57:03'),
(6, 4, 3, 1, 5, 'Lần đầu mua hàng của shop, sẽ dùng thử 1 thời gian và quay lại đánh giá', '2025-09-20 23:57:03', '2025-09-20 23:57:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('K6C2JTqEz9lyKPn6nYqhlVxbJgHRUVvJVKRZpvIO', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZTByZHBGTzR1WTg2NHVobnFiTlBmdFBlek9Dc2NFek1CQUhrbk9sOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGF0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1761301506),
('QTxvHGqjfcsSswI1Q8lrvlqX8AuteMpBy1TX16hf', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieU5aSTRMQkQ2UVUxNXhFQWpzV3dJMUNhY1N3VnBlMDZrVjRpZWFNdSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FjY291bnQiO31zOjQ6ImNhcnQiO2E6MTp7czozNDoiMTJfMzZfIzgwMDAwMF9EYSB04buVbmcgaOG7o3AgKFBVKSI7YTo4OntzOjI6ImlkIjtpOjEyO3M6NDoibmFtZSI7czo2MToiR2nDoHkgQ2FvIEfDs3QgxJDDtG5nIEjhuqNpIFNhdGluIMSQw61uaCBQaGEgTMOqIFNhbmcgVHLhu41uZyI7czo1OiJwcmljZSI7czo5OiI4NTAwMDAuMDAiO3M6NToiaW1hZ2UiO3M6MzM6InByb2R1Y3RzLzE3NTc2NzMxMTRfZ2lheXNhdGluLmpwZyI7czo0OiJzaXplIjtzOjI6IjM2IjtzOjU6ImNvbG9yIjtzOjc6IiM4MDAwMDAiO3M6ODoibWF0ZXJpYWwiO3M6MjA6IkRhIHThu5VuZyBo4bujcCAoUFUpIjtzOjg6InF1YW50aXR5IjtpOjI7fX19', 1758575306),
('qWfybRZqilgWle0H2NIMn3Lq1plcEiIGRR2U5l5f', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUm10YVEzQlFMb3ZubUJYaTZLSXJnaXJzQkM2QllPM081a2NuNG9YTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1758786761);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('import','export','adjustment') NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `transaction_id`, `inventory_id`, `type`, `quantity`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(2, 2, 2, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(3, 3, 3, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(4, 4, 4, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(5, 5, 5, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(6, 6, 6, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(7, 7, 7, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(8, 8, 8, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(9, 9, 9, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(10, 10, 10, 'import', 1000000, 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(11, 11, 1, 'import', 5000, 'Nhập hàng đợt 1', '2025-08-01 02:30:00', '2025-08-01 02:30:00'),
(12, 12, 1, 'export', 2000, 'Xuất bán cho đại lý A', '2025-08-10 07:20:00', '2025-08-10 07:20:00'),
(13, 13, 1, 'import', 7000, 'Nhập hàng đợt 2', '2025-09-05 04:00:00', '2025-09-05 04:00:00'),
(14, 14, 2, 'import', 1000, 'Nhập lô mới', '2025-08-15 03:15:00', '2025-08-15 03:15:00'),
(15, 15, 2, 'export', 300, 'Xuất bán sỉ cho shop B', '2025-08-25 09:45:00', '2025-08-25 09:45:00'),
(16, 16, 3, 'import', 2000, 'Nhập ban đầu', '2025-07-20 01:10:00', '2025-07-20 01:10:00'),
(17, 17, 3, 'export', 500, 'Bán lẻ', '2025-08-12 06:30:00', '2025-08-12 06:30:00'),
(18, 18, 3, 'import', 1200, 'Nhập bổ sung', '2025-09-01 02:50:00', '2025-09-01 02:50:00'),
(19, 19, 4, 'import', 100, 'Nhập test thị trường', '2025-08-03 05:00:00', '2025-08-03 05:00:00'),
(20, 20, 4, 'export', 100, 'Xuất hết hàng', '2025-08-20 10:30:00', '2025-08-20 10:30:00'),
(21, 21, 5, 'import', 3000, 'Nhập kho chính', '2025-07-25 08:45:00', '2025-07-25 08:45:00'),
(22, 22, 5, 'export', 500, 'Xuất cho đại lý C', '2025-08-18 03:20:00', '2025-08-18 03:20:00'),
(23, 23, 6, 'import', 8000, 'Nhập đợt lớn', '2025-08-02 07:10:00', '2025-08-02 07:10:00'),
(24, 24, 6, 'export', 600, 'Xuất bán sỉ', '2025-08-28 02:00:00', '2025-08-28 02:00:00'),
(25, 25, 7, 'import', 2000, 'Nhập hàng đầu kỳ', '2025-07-28 06:40:00', '2025-07-28 06:40:00'),
(26, 26, 7, 'export', 400, 'Bán lẻ', '2025-08-14 04:30:00', '2025-08-14 04:30:00'),
(27, 27, 8, 'import', 5000, 'Nhập về kho', '2025-07-30 09:00:00', '2025-07-30 09:00:00'),
(28, 28, 8, 'export', 800, 'Xuất cho cửa hàng D', '2025-09-02 02:45:00', '2025-09-02 02:45:00'),
(29, 29, 9, 'import', 2500, 'Nhập đợt 1', '2025-08-06 03:00:00', '2025-08-06 03:00:00'),
(30, 30, 9, 'export', 600, 'Xuất bán cho shop E', '2025-08-22 06:10:00', '2025-08-22 06:10:00'),
(31, 31, 10, 'import', 3000, 'Nhập hàng đầu kỳ', '2025-07-18 02:30:00', '2025-07-18 02:30:00'),
(32, 32, 10, 'export', 500, 'Xuất bán cho khách sỉ', '2025-08-08 08:25:00', '2025-08-08 08:25:00'),
(33, 33, 10, 'import', 1000, 'Nhập bổ sung', '2025-09-10 03:50:00', '2025-09-10 03:50:00'),
(34, 44, 15, 'export', 100, NULL, '2025-09-22 14:04:05', '2025-09-22 14:04:05'),
(35, 44, 11, 'export', 100, NULL, '2025-09-22 14:04:05', '2025-09-22 14:04:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('import','export') NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `note`, `created_at`, `updated_at`) VALUES
(1, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(2, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(3, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(4, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(5, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(6, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(7, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(8, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(9, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(10, 'import', 'Khởi tạo tồn kho', '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(11, 'import', 'Nhập hàng đợt 1', '2025-08-01 02:30:00', '2025-08-01 02:30:00'),
(12, 'export', 'Xuất bán cho đại lý A', '2025-08-10 07:20:00', '2025-08-10 07:20:00'),
(13, 'import', 'Nhập hàng đợt 2', '2025-09-05 04:00:00', '2025-09-05 04:00:00'),
(14, 'import', 'Nhập lô mới', '2025-08-15 03:15:00', '2025-08-15 03:15:00'),
(15, 'export', 'Xuất bán sỉ cho shop B', '2025-08-25 09:45:00', '2025-08-25 09:45:00'),
(16, 'import', 'Nhập ban đầu', '2025-07-20 01:10:00', '2025-07-20 01:10:00'),
(17, 'export', 'Bán lẻ', '2025-08-12 06:30:00', '2025-08-12 06:30:00'),
(18, 'import', 'Nhập bổ sung', '2025-09-01 02:50:00', '2025-09-01 02:50:00'),
(19, 'import', 'Nhập test thị trường', '2025-08-03 05:00:00', '2025-08-03 05:00:00'),
(20, 'export', 'Xuất hết hàng', '2025-08-20 10:30:00', '2025-08-20 10:30:00'),
(21, 'import', 'Nhập kho chính', '2025-07-25 08:45:00', '2025-07-25 08:45:00'),
(22, 'export', 'Xuất cho đại lý C', '2025-08-18 03:20:00', '2025-08-18 03:20:00'),
(23, 'import', 'Nhập đợt lớn', '2025-08-02 07:10:00', '2025-08-02 07:10:00'),
(24, 'export', 'Xuất bán sỉ', '2025-08-28 02:00:00', '2025-08-28 02:00:00'),
(25, 'import', 'Nhập hàng đầu kỳ', '2025-07-28 06:40:00', '2025-07-28 06:40:00'),
(26, 'export', 'Bán lẻ', '2025-08-14 04:30:00', '2025-08-14 04:30:00'),
(27, 'import', 'Nhập về kho', '2025-07-30 09:00:00', '2025-07-30 09:00:00'),
(28, 'export', 'Xuất cho cửa hàng D', '2025-09-02 02:45:00', '2025-09-02 02:45:00'),
(29, 'import', 'Nhập đợt 1', '2025-08-06 03:00:00', '2025-08-06 03:00:00'),
(30, 'export', 'Xuất bán cho shop E', '2025-08-22 06:10:00', '2025-08-22 06:10:00'),
(31, 'import', 'Nhập hàng đầu kỳ', '2025-07-18 02:30:00', '2025-07-18 02:30:00'),
(32, 'export', 'Xuất bán cho khách sỉ', '2025-08-08 08:25:00', '2025-08-08 08:25:00'),
(33, 'import', 'Nhập bổ sung', '2025-09-10 03:50:00', '2025-09-10 03:50:00'),
(34, 'import', 'Nhập thêm sản phẩm sắp hết', '2025-09-22 05:17:47', '2025-09-22 05:17:47'),
(35, 'import', 'Nhập hàng', '2025-09-22 05:29:23', '2025-09-22 05:29:23'),
(36, 'export', 'Xuất hàng cho cửa hàng khác', '2025-09-22 05:30:46', '2025-09-22 05:30:46'),
(37, 'export', NULL, '2025-09-22 05:31:35', '2025-09-22 05:31:35'),
(38, 'import', 'nhập', '2025-09-22 11:26:12', '2025-09-22 11:26:12'),
(39, 'import', 'nhập thêm giày', '2025-09-22 13:02:48', '2025-09-22 13:02:48'),
(40, 'export', 'xuất sản phẩm', '2025-09-22 13:05:00', '2025-09-22 13:05:00'),
(41, 'import', NULL, '2025-09-22 13:54:33', '2025-09-22 13:54:33'),
(44, 'export', NULL, '2025-09-22 14:04:05', '2025-09-22 14:04:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `inventory_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(2, 2, 2, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(3, 3, 3, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(4, 4, 4, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(5, 5, 5, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(6, 6, 6, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(7, 7, 7, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(8, 8, 8, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(9, 9, 9, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(10, 10, 10, 1000000, '2025-06-01 09:24:39', '2025-06-01 09:24:39'),
(11, 11, 1, 5000, '2025-08-01 02:30:00', '2025-08-01 02:30:00'),
(12, 12, 1, 2000, '2025-08-10 07:20:00', '2025-08-10 07:20:00'),
(13, 13, 1, 7000, '2025-09-05 04:00:00', '2025-09-05 04:00:00'),
(14, 14, 2, 1000, '2025-08-15 03:15:00', '2025-08-15 03:15:00'),
(15, 15, 2, 300, '2025-08-25 09:45:00', '2025-08-25 09:45:00'),
(16, 16, 3, 2000, '2025-07-20 01:10:00', '2025-07-20 01:10:00'),
(17, 17, 3, 500, '2025-08-12 06:30:00', '2025-08-12 06:30:00'),
(18, 18, 3, 1200, '2025-09-01 02:50:00', '2025-09-01 02:50:00'),
(19, 19, 4, 100, '2025-08-03 05:00:00', '2025-08-03 05:00:00'),
(20, 20, 4, 100, '2025-08-20 10:30:00', '2025-08-20 10:30:00'),
(21, 21, 5, 3000, '2025-07-25 08:45:00', '2025-07-25 08:45:00'),
(22, 22, 5, 500, '2025-08-18 03:20:00', '2025-08-18 03:20:00'),
(23, 23, 6, 8000, '2025-08-02 07:10:00', '2025-08-02 07:10:00'),
(24, 24, 6, 600, '2025-08-28 02:00:00', '2025-08-28 02:00:00'),
(25, 25, 7, 2000, '2025-07-28 06:40:00', '2025-07-28 06:40:00'),
(26, 26, 7, 400, '2025-08-14 04:30:00', '2025-08-14 04:30:00'),
(27, 27, 8, 5000, '2025-07-30 09:00:00', '2025-07-30 09:00:00'),
(28, 28, 8, 800, '2025-09-02 02:45:00', '2025-09-02 02:45:00'),
(29, 29, 9, 2500, '2025-08-06 03:00:00', '2025-08-06 03:00:00'),
(30, 30, 9, 600, '2025-08-22 06:10:00', '2025-08-22 06:10:00'),
(31, 31, 10, 3000, '2025-07-18 02:30:00', '2025-07-18 02:30:00'),
(32, 32, 10, 500, '2025-08-08 08:25:00', '2025-08-08 08:25:00'),
(33, 33, 10, 1000, '2025-09-10 03:50:00', '2025-09-10 03:50:00'),
(64, 34, 4, 100, '2025-09-22 05:17:47', '2025-09-22 05:17:47'),
(65, 34, 14, 2000, '2025-09-22 05:17:47', '2025-09-22 05:17:47'),
(66, 35, 15, 1000, '2025-09-22 05:29:23', '2025-09-22 05:29:23'),
(67, 36, 15, 1000, '2025-09-22 05:30:46', '2025-09-22 05:30:46'),
(68, 37, 4, 90, '2025-09-22 05:31:35', '2025-09-22 05:31:35'),
(69, 37, 9, 1980, '2025-09-22 05:31:35', '2025-09-22 05:31:35'),
(70, 38, 4, 90, '2025-09-22 11:26:12', '2025-09-22 11:26:12'),
(71, 39, 4, 10, '2025-09-22 13:02:48', '2025-09-22 13:02:48'),
(72, 40, 6, 7000, '2025-09-22 13:05:00', '2025-09-22 13:05:00'),
(73, 41, 15, 100, '2025-09-22 13:54:33', '2025-09-22 13:54:33'),
(74, 41, 11, 100, '2025-09-22 13:54:33', '2025-09-22 13:54:33'),
(77, 44, 15, 100, '2025-09-22 14:04:05', '2025-09-22 14:04:05'),
(78, 44, 11, 100, '2025-09-22 14:04:05', '2025-09-22 14:04:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `address`) VALUES
(4, 'Thảo', 'phamphuongthaond1911@gmail.com', '2025-09-12 07:21:58', '$2y$12$8Uo7yl964cazTJyWCImpzOvazanHogTY8GMmaTngCo7ixyxUAziTy', 'jqHXoNs9KXetj2HiyxB6flL2WnWVBuU3luo9vNPVpyhOcSfNU4QeV6S0PyG2', '2025-09-12 00:21:15', '2025-09-20 23:45:19', 'admin', '0944763697', 'Nam Định'),
(5, 'Linh', '22111060566@hunre.edu.vn', '2025-09-12 07:26:57', '$2y$12$wf9Ucr32P293o/AHUmJc.OANE3Tw0I3v5GZsfrn57J1Kx5UsPUpre', 'gX2K1qT7hemxONRMgtG3x1hT7tMX4bPL3M2eftgl5xcVxOnMiHl64H9IrNx6', '2025-09-12 00:26:31', '2025-09-12 00:26:31', 'admin', '0987654321', 'Hà Nội'),
(10, 'Lan', 'lantruong346@gmail.com', '2025-09-15 07:55:37', '$2y$12$dyCpz7pTZhRbFFg2a6v2Xe3..blEWE/4UXFvfdZ8hZ4T4m3j5J2Pu', 'Y5reakdmmk9SOrcsVWeD7STDGTVP8c65mO0dmql2ZRh08TqGFY5rSGlQtfhd', '2025-09-15 00:53:06', '2025-09-15 00:53:06', 'customer', '0123456789', 'Hà Giang'),
(11, 'Duyên', 'duya9654@gmail.com', '2025-09-18 22:53:13', '$2y$12$MxFHF9XcHSJaz2hKyYyVC.UFi34Vf/4cBZsuXPGt4go6Y3jNMEOpi', 'pfWJohBA8dXgxezcVKp0F5Znv2GOMxnNhVkbE0LYuicnZjJY19FvsQvUzPwH', '2025-09-18 15:52:33', '2025-09-20 23:51:46', 'customer', '0924800857', 'Thái Bình');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_histories`
--

CREATE TABLE `user_histories` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `discount` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_histories`
--

INSERT INTO `user_histories` (`id`, `user_id`, `coupon_id`, `order_id`, `used_at`, `created_at`, `updated_at`, `discount`) VALUES
(15, 4, 10, 3, '2025-09-12 12:49:23', '2025-09-12 05:49:23', '2025-09-12 05:49:23', 20.00),
(18, 4, 10, 4, '2025-09-12 12:55:25', '2025-09-12 05:55:25', '2025-09-12 05:55:25', 20.00),
(21, 4, 10, 5, '2025-09-12 12:57:53', '2025-09-12 05:57:53', '2025-09-12 05:57:53', 20.00),
(32, 5, 7, 6, '2025-09-15 06:01:28', '2025-09-14 23:01:28', '2025-09-14 23:01:28', 25.00),
(35, 5, 3, 7, '2025-09-15 06:07:57', '2025-09-14 23:07:57', '2025-09-14 23:07:57', 20.00),
(41, 5, 4, 8, '2025-09-15 06:24:01', '2025-09-14 23:24:01', '2025-09-14 23:24:01', 5000.00),
(44, 10, NULL, 9, '2025-09-15 07:58:44', '2025-09-15 00:58:44', '2025-09-15 00:58:44', NULL),
(45, 10, 1, 9, '2025-09-15 07:58:44', '2025-09-15 00:58:44', '2025-09-15 00:58:44', 30.00),
(51, 5, NULL, 10, '2025-09-15 10:37:42', '2025-09-15 03:37:42', '2025-09-15 03:37:42', NULL),
(52, 5, 5, 10, '2025-09-15 10:37:42', '2025-09-15 03:37:42', '2025-09-15 03:37:42', 15.00),
(55, 5, NULL, 11, '2025-09-15 10:47:20', '2025-09-15 03:47:20', '2025-09-15 03:47:20', NULL),
(56, 5, 3, 11, '2025-09-15 10:47:20', '2025-09-15 03:47:20', '2025-09-15 03:47:20', 20.00),
(58, 10, NULL, 12, '2025-09-15 10:53:07', '2025-09-15 03:53:07', '2025-09-15 03:53:07', NULL),
(59, 10, 2, 12, '2025-09-15 10:53:07', '2025-09-15 03:53:07', '2025-09-15 03:53:07', 10.00),
(63, 10, NULL, 13, '2025-09-15 10:56:48', '2025-09-15 03:56:48', '2025-09-15 03:56:48', NULL),
(64, 10, 8, 13, '2025-09-15 10:56:48', '2025-09-15 03:56:48', '2025-09-15 03:56:48', 50000.00),
(65, 10, NULL, NULL, '2025-09-15 11:05:30', '2025-09-15 04:05:30', '2025-09-15 04:05:30', NULL),
(66, 10, NULL, 14, '2025-09-15 11:05:43', '2025-09-15 04:05:43', '2025-09-15 04:05:43', NULL),
(67, 10, 1, 14, '2025-09-15 11:05:43', '2025-09-15 04:05:43', '2025-09-15 04:05:43', 30.00),
(69, 10, NULL, 15, '2025-09-15 11:16:13', '2025-09-15 04:16:13', '2025-09-15 04:16:13', NULL),
(70, 10, 2, 15, '2025-09-15 11:16:13', '2025-09-15 04:16:13', '2025-09-15 04:16:13', 10.00),
(73, 10, NULL, 16, '2025-09-15 12:02:23', '2025-09-15 05:02:23', '2025-09-15 05:02:23', NULL),
(74, 10, 1, 16, '2025-09-15 12:02:23', '2025-09-15 05:02:23', '2025-09-15 05:02:23', 30.00),
(75, 5, NULL, NULL, '2025-09-15 12:45:34', '2025-09-15 05:45:34', '2025-09-15 05:45:34', NULL),
(76, 5, NULL, 17, '2025-09-15 12:47:48', '2025-09-15 05:47:48', '2025-09-15 05:47:48', NULL),
(77, 5, 8, 17, '2025-09-15 12:47:48', '2025-09-15 05:47:48', '2025-09-15 05:47:48', 50000.00),
(78, 5, NULL, NULL, '2025-09-15 13:00:47', '2025-09-15 06:00:47', '2025-09-15 06:00:47', NULL),
(79, 5, NULL, 18, '2025-09-15 13:00:58', '2025-09-15 06:00:58', '2025-09-15 06:00:58', NULL),
(80, 5, 10, 18, '2025-09-15 13:00:58', '2025-09-15 06:00:58', '2025-09-15 06:00:58', 20.00),
(81, 5, NULL, NULL, '2025-09-15 13:31:38', '2025-09-15 06:31:38', '2025-09-15 06:31:38', NULL),
(82, 5, NULL, NULL, '2025-09-15 13:41:07', '2025-09-15 06:41:07', '2025-09-15 06:41:07', NULL),
(83, 5, NULL, 19, '2025-09-15 13:41:19', '2025-09-15 06:41:19', '2025-09-15 06:41:19', NULL),
(84, 5, 8, 19, '2025-09-15 13:41:19', '2025-09-15 06:41:19', '2025-09-15 06:41:19', 50000.00),
(85, 5, NULL, NULL, '2025-09-18 04:17:12', '2025-09-17 21:17:12', '2025-09-17 21:17:12', NULL),
(86, 5, NULL, NULL, '2025-09-18 04:18:42', '2025-09-17 21:18:42', '2025-09-17 21:18:42', NULL),
(87, 5, NULL, NULL, '2025-09-18 04:20:18', '2025-09-17 21:20:18', '2025-09-17 21:20:18', NULL),
(88, 5, NULL, NULL, '2025-09-18 04:20:33', '2025-09-17 21:20:33', '2025-09-17 21:20:33', NULL),
(89, 5, NULL, NULL, '2025-09-18 06:46:45', '2025-09-17 23:46:45', '2025-09-17 23:46:45', NULL),
(90, 5, NULL, NULL, '2025-09-18 06:49:57', '2025-09-17 23:49:57', '2025-09-17 23:49:57', NULL),
(91, 5, NULL, NULL, '2025-09-18 06:51:19', '2025-09-17 23:51:19', '2025-09-17 23:51:19', NULL),
(92, 5, NULL, NULL, '2025-09-18 06:51:38', '2025-09-17 23:51:38', '2025-09-17 23:51:38', NULL),
(93, 5, NULL, NULL, '2025-09-18 06:52:06', '2025-09-17 23:52:06', '2025-09-17 23:52:06', NULL),
(94, 5, NULL, NULL, '2025-09-18 06:55:10', '2025-09-17 23:55:10', '2025-09-17 23:55:10', NULL),
(95, 5, NULL, NULL, '2025-09-18 06:55:58', '2025-09-17 23:55:58', '2025-09-17 23:55:58', NULL),
(96, 5, NULL, NULL, '2025-09-18 06:56:54', '2025-09-17 23:56:54', '2025-09-17 23:56:54', NULL),
(97, 5, NULL, NULL, '2025-09-18 06:57:54', '2025-09-17 23:57:54', '2025-09-17 23:57:54', NULL),
(98, 5, NULL, NULL, '2025-09-18 06:58:52', '2025-09-17 23:58:52', '2025-09-17 23:58:52', NULL),
(99, 5, NULL, NULL, '2025-09-18 06:59:09', '2025-09-17 23:59:09', '2025-09-17 23:59:09', NULL),
(100, 5, NULL, NULL, '2025-09-18 07:01:03', '2025-09-18 00:01:03', '2025-09-18 00:01:03', NULL),
(101, 5, NULL, NULL, '2025-09-18 07:03:05', '2025-09-18 00:03:05', '2025-09-18 00:03:05', NULL),
(102, 5, NULL, NULL, '2025-09-18 07:04:30', '2025-09-18 00:04:30', '2025-09-18 00:04:30', NULL),
(103, 5, NULL, NULL, '2025-09-18 07:09:23', '2025-09-18 00:09:23', '2025-09-18 00:09:23', NULL),
(104, 5, NULL, NULL, '2025-09-18 07:10:29', '2025-09-18 00:10:29', '2025-09-18 00:10:29', NULL),
(105, 5, NULL, NULL, '2025-09-18 07:10:39', '2025-09-18 00:10:39', '2025-09-18 00:10:39', NULL),
(106, 5, NULL, NULL, '2025-09-18 07:10:55', '2025-09-18 00:10:55', '2025-09-18 00:10:55', NULL),
(107, 5, NULL, NULL, '2025-09-18 07:11:16', '2025-09-18 00:11:16', '2025-09-18 00:11:16', NULL),
(108, 5, NULL, NULL, '2025-09-18 07:12:12', '2025-09-18 00:12:12', '2025-09-18 00:12:12', NULL),
(109, 5, NULL, NULL, '2025-09-18 07:13:13', '2025-09-18 00:13:13', '2025-09-18 00:13:13', NULL),
(110, 5, NULL, NULL, '2025-09-18 07:15:22', '2025-09-18 00:15:22', '2025-09-18 00:15:22', NULL),
(111, 5, NULL, NULL, '2025-09-18 07:17:02', '2025-09-18 00:17:02', '2025-09-18 00:17:02', NULL),
(112, 5, NULL, NULL, '2025-09-18 07:18:14', '2025-09-18 00:18:14', '2025-09-18 00:18:14', NULL),
(113, 5, NULL, NULL, '2025-09-18 07:19:12', '2025-09-18 00:19:12', '2025-09-18 00:19:12', NULL),
(114, 5, NULL, NULL, '2025-09-18 07:20:30', '2025-09-18 00:20:30', '2025-09-18 00:20:30', NULL),
(115, 5, NULL, NULL, '2025-09-18 07:21:54', '2025-09-18 00:21:54', '2025-09-18 00:21:54', NULL),
(116, 5, NULL, NULL, '2025-09-18 07:23:21', '2025-09-18 00:23:21', '2025-09-18 00:23:21', NULL),
(117, 5, NULL, NULL, '2025-09-18 07:24:40', '2025-09-18 00:24:40', '2025-09-18 00:24:40', NULL),
(118, 5, NULL, NULL, '2025-09-18 07:24:57', '2025-09-18 00:24:57', '2025-09-18 00:24:57', NULL),
(119, 5, NULL, NULL, '2025-09-18 07:28:39', '2025-09-18 00:28:39', '2025-09-18 00:28:39', NULL),
(120, 5, NULL, NULL, '2025-09-18 07:28:48', '2025-09-18 00:28:48', '2025-09-18 00:28:48', NULL),
(121, 5, NULL, NULL, '2025-09-18 07:28:54', '2025-09-18 00:28:54', '2025-09-18 00:28:54', NULL),
(122, 5, NULL, NULL, '2025-09-18 07:31:07', '2025-09-18 00:31:07', '2025-09-18 00:31:07', NULL),
(123, 5, NULL, NULL, '2025-09-18 07:31:15', '2025-09-18 00:31:15', '2025-09-18 00:31:15', NULL),
(124, 5, NULL, NULL, '2025-09-18 07:31:21', '2025-09-18 00:31:21', '2025-09-18 00:31:21', NULL),
(125, 5, NULL, NULL, '2025-09-18 07:37:12', '2025-09-18 00:37:12', '2025-09-18 00:37:12', NULL),
(126, 5, NULL, NULL, '2025-09-18 07:37:18', '2025-09-18 00:37:18', '2025-09-18 00:37:18', NULL),
(127, 5, NULL, NULL, '2025-09-18 07:38:58', '2025-09-18 00:38:58', '2025-09-18 00:38:58', NULL),
(128, 5, NULL, NULL, '2025-09-18 07:39:06', '2025-09-18 00:39:06', '2025-09-18 00:39:06', NULL),
(129, 5, NULL, NULL, '2025-09-18 07:39:13', '2025-09-18 00:39:13', '2025-09-18 00:39:13', NULL),
(130, 5, NULL, NULL, '2025-09-18 07:41:32', '2025-09-18 00:41:32', '2025-09-18 00:41:32', NULL),
(131, 5, NULL, NULL, '2025-09-18 07:41:39', '2025-09-18 00:41:39', '2025-09-18 00:41:39', NULL),
(132, 5, NULL, NULL, '2025-09-18 07:44:51', '2025-09-18 00:44:51', '2025-09-18 00:44:51', NULL),
(133, 5, NULL, NULL, '2025-09-18 07:45:03', '2025-09-18 00:45:03', '2025-09-18 00:45:03', NULL),
(134, 5, NULL, NULL, '2025-09-18 07:48:13', '2025-09-18 00:48:13', '2025-09-18 00:48:13', NULL),
(135, 5, NULL, NULL, '2025-09-18 07:49:21', '2025-09-18 00:49:21', '2025-09-18 00:49:21', NULL),
(136, 5, NULL, NULL, '2025-09-18 07:49:44', '2025-09-18 00:49:44', '2025-09-18 00:49:44', NULL),
(137, 5, NULL, NULL, '2025-09-18 07:50:58', '2025-09-18 00:50:58', '2025-09-18 00:50:58', NULL),
(138, 5, NULL, NULL, '2025-09-18 07:52:21', '2025-09-18 00:52:21', '2025-09-18 00:52:21', NULL),
(139, 5, NULL, NULL, '2025-09-18 07:54:52', '2025-09-18 00:54:52', '2025-09-18 00:54:52', NULL),
(140, 5, NULL, NULL, '2025-09-18 07:55:29', '2025-09-18 00:55:29', '2025-09-18 00:55:29', NULL),
(141, 5, NULL, NULL, '2025-09-18 07:55:42', '2025-09-18 00:55:42', '2025-09-18 00:55:42', NULL),
(142, 5, NULL, NULL, '2025-09-18 07:56:12', '2025-09-18 00:56:12', '2025-09-18 00:56:12', NULL),
(143, 5, NULL, NULL, '2025-09-18 07:56:22', '2025-09-18 00:56:22', '2025-09-18 00:56:22', NULL),
(144, 5, NULL, 20, '2025-09-18 08:06:12', '2025-09-18 01:06:12', '2025-09-18 01:06:12', NULL),
(145, 5, NULL, NULL, '2025-09-18 17:23:53', '2025-09-18 10:23:53', '2025-09-18 10:23:53', NULL),
(146, 5, NULL, NULL, '2025-09-18 17:23:59', '2025-09-18 10:23:59', '2025-09-18 10:23:59', NULL),
(147, 5, NULL, NULL, '2025-09-18 17:27:20', '2025-09-18 10:27:20', '2025-09-18 10:27:20', NULL),
(148, 5, NULL, NULL, '2025-09-18 17:33:28', '2025-09-18 10:33:28', '2025-09-18 10:33:28', NULL),
(149, 5, NULL, NULL, '2025-09-18 17:33:32', '2025-09-18 10:33:32', '2025-09-18 10:33:32', NULL),
(150, 5, NULL, NULL, '2025-09-18 17:34:02', '2025-09-18 10:34:02', '2025-09-18 10:34:02', NULL),
(151, 5, NULL, NULL, '2025-09-18 17:34:08', '2025-09-18 10:34:08', '2025-09-18 10:34:08', NULL),
(152, 5, NULL, NULL, '2025-09-18 17:36:03', '2025-09-18 10:36:03', '2025-09-18 10:36:03', NULL),
(153, 5, NULL, NULL, '2025-09-18 17:36:05', '2025-09-18 10:36:05', '2025-09-18 10:36:05', NULL),
(154, 5, NULL, NULL, '2025-09-18 17:36:18', '2025-09-18 10:36:18', '2025-09-18 10:36:18', NULL),
(155, 5, NULL, NULL, '2025-09-18 17:36:23', '2025-09-18 10:36:23', '2025-09-18 10:36:23', NULL),
(156, 5, NULL, NULL, '2025-09-18 17:41:27', '2025-09-18 10:41:27', '2025-09-18 10:41:27', NULL),
(157, 5, NULL, NULL, '2025-09-18 17:41:31', '2025-09-18 10:41:31', '2025-09-18 10:41:31', NULL),
(158, 5, NULL, NULL, '2025-09-18 17:44:03', '2025-09-18 10:44:03', '2025-09-18 10:44:03', NULL),
(159, 5, NULL, NULL, '2025-09-18 17:51:05', '2025-09-18 10:51:05', '2025-09-18 10:51:05', NULL),
(160, 5, NULL, NULL, '2025-09-18 17:51:10', '2025-09-18 10:51:10', '2025-09-18 10:51:10', NULL),
(161, 5, NULL, NULL, '2025-09-18 17:54:25', '2025-09-18 10:54:25', '2025-09-18 10:54:25', NULL),
(162, 5, NULL, NULL, '2025-09-18 17:58:14', '2025-09-18 10:58:14', '2025-09-18 10:58:14', NULL),
(163, 5, NULL, NULL, '2025-09-18 18:09:10', '2025-09-18 11:09:10', '2025-09-18 11:09:10', NULL),
(164, 5, NULL, NULL, '2025-09-18 18:09:33', '2025-09-18 11:09:33', '2025-09-18 11:09:33', NULL),
(165, 5, NULL, NULL, '2025-09-18 18:09:47', '2025-09-18 11:09:47', '2025-09-18 11:09:47', NULL),
(166, 5, NULL, 21, '2025-09-18 18:29:00', '2025-09-18 11:29:00', '2025-09-18 11:29:00', NULL),
(167, 5, NULL, NULL, '2025-09-18 18:44:31', '2025-09-18 11:44:31', '2025-09-18 11:44:31', NULL),
(168, 5, NULL, NULL, '2025-09-18 18:44:37', '2025-09-18 11:44:37', '2025-09-18 11:44:37', NULL),
(169, 5, NULL, 22, '2025-09-18 19:12:51', '2025-09-18 12:12:51', '2025-09-18 12:12:51', NULL),
(170, 5, NULL, NULL, '2025-09-18 19:19:59', '2025-09-18 12:19:59', '2025-09-18 12:19:59', NULL),
(171, 5, NULL, NULL, '2025-09-18 19:24:00', '2025-09-18 12:24:00', '2025-09-18 12:24:00', NULL),
(172, 5, NULL, NULL, '2025-09-18 19:24:04', '2025-09-18 12:24:04', '2025-09-18 12:24:04', NULL),
(173, 5, NULL, NULL, '2025-09-18 19:38:14', '2025-09-18 12:38:14', '2025-09-18 12:38:14', NULL),
(174, 5, NULL, NULL, '2025-09-18 19:38:46', '2025-09-18 12:38:46', '2025-09-18 12:38:46', NULL),
(175, 5, NULL, NULL, '2025-09-18 19:38:50', '2025-09-18 12:38:50', '2025-09-18 12:38:50', NULL),
(176, 5, NULL, 23, '2025-09-18 19:41:40', '2025-09-18 12:41:40', '2025-09-18 12:41:40', NULL),
(177, 5, NULL, 24, '2025-09-18 19:51:23', '2025-09-18 12:51:23', '2025-09-18 12:51:23', NULL),
(178, 5, NULL, NULL, '2025-09-18 19:54:49', '2025-09-18 12:54:49', '2025-09-18 12:54:49', NULL),
(179, 5, NULL, NULL, '2025-09-18 19:54:57', '2025-09-18 12:54:57', '2025-09-18 12:54:57', NULL),
(180, 5, NULL, 25, '2025-09-18 19:55:15', '2025-09-18 12:55:15', '2025-09-18 12:55:15', NULL),
(181, 5, NULL, NULL, '2025-09-18 19:55:50', '2025-09-18 12:55:50', '2025-09-18 12:55:50', NULL),
(182, 5, NULL, NULL, '2025-09-18 19:56:59', '2025-09-18 12:56:59', '2025-09-18 12:56:59', NULL),
(183, 5, NULL, NULL, '2025-09-18 20:03:31', '2025-09-18 13:03:31', '2025-09-18 13:03:31', NULL),
(184, 5, NULL, NULL, '2025-09-18 20:05:30', '2025-09-18 13:05:30', '2025-09-18 13:05:30', NULL),
(185, 5, NULL, NULL, '2025-09-18 20:06:42', '2025-09-18 13:06:42', '2025-09-18 13:06:42', NULL),
(186, 5, NULL, NULL, '2025-09-18 20:08:23', '2025-09-18 13:08:23', '2025-09-18 13:08:23', NULL),
(187, 5, NULL, NULL, '2025-09-18 20:09:13', '2025-09-18 13:09:13', '2025-09-18 13:09:13', NULL),
(188, 5, NULL, NULL, '2025-09-18 20:10:32', '2025-09-18 13:10:32', '2025-09-18 13:10:32', NULL),
(189, 5, NULL, NULL, '2025-09-18 20:10:37', '2025-09-18 13:10:37', '2025-09-18 13:10:37', NULL),
(190, 5, NULL, NULL, '2025-09-18 20:13:44', '2025-09-18 13:13:44', '2025-09-18 13:13:44', NULL),
(191, 5, NULL, NULL, '2025-09-18 20:14:09', '2025-09-18 13:14:09', '2025-09-18 13:14:09', NULL),
(192, 5, NULL, NULL, '2025-09-18 20:15:40', '2025-09-18 13:15:40', '2025-09-18 13:15:40', NULL),
(193, 5, NULL, NULL, '2025-09-18 20:15:58', '2025-09-18 13:15:58', '2025-09-18 13:15:58', NULL),
(194, 5, NULL, NULL, '2025-09-18 20:16:21', '2025-09-18 13:16:21', '2025-09-18 13:16:21', NULL),
(195, 5, NULL, NULL, '2025-09-18 20:17:01', '2025-09-18 13:17:01', '2025-09-18 13:17:01', NULL),
(196, 5, NULL, NULL, '2025-09-18 20:19:52', '2025-09-18 13:19:52', '2025-09-18 13:19:52', NULL),
(197, 5, NULL, NULL, '2025-09-18 20:21:47', '2025-09-18 13:21:47', '2025-09-18 13:21:47', NULL),
(198, 5, NULL, NULL, '2025-09-18 20:24:47', '2025-09-18 13:24:47', '2025-09-18 13:24:47', NULL),
(199, 5, NULL, NULL, '2025-09-18 20:24:53', '2025-09-18 13:24:53', '2025-09-18 13:24:53', NULL),
(200, 5, NULL, NULL, '2025-09-18 20:25:31', '2025-09-18 13:25:31', '2025-09-18 13:25:31', NULL),
(201, 5, NULL, NULL, '2025-09-18 20:26:09', '2025-09-18 13:26:09', '2025-09-18 13:26:09', NULL),
(202, 5, NULL, NULL, '2025-09-18 20:28:03', '2025-09-18 13:28:03', '2025-09-18 13:28:03', NULL),
(203, 5, NULL, NULL, '2025-09-18 20:42:22', '2025-09-18 13:42:22', '2025-09-18 13:42:22', NULL),
(204, 5, NULL, NULL, '2025-09-18 20:56:51', '2025-09-18 13:56:51', '2025-09-18 13:56:51', NULL),
(205, 5, NULL, 26, '2025-09-18 20:57:15', '2025-09-18 13:57:15', '2025-09-18 13:57:15', NULL),
(206, 5, NULL, NULL, '2025-09-18 21:02:22', '2025-09-18 14:02:22', '2025-09-18 14:02:22', NULL),
(207, 5, NULL, NULL, '2025-09-18 21:02:55', '2025-09-18 14:02:55', '2025-09-18 14:02:55', NULL),
(208, 5, NULL, NULL, '2025-09-18 21:03:09', '2025-09-18 14:03:09', '2025-09-18 14:03:09', NULL),
(209, 5, NULL, 27, '2025-09-18 21:07:52', '2025-09-18 14:07:52', '2025-09-18 14:07:52', NULL),
(210, 5, NULL, NULL, '2025-09-18 21:11:38', '2025-09-18 14:11:38', '2025-09-18 14:11:38', NULL),
(211, 5, NULL, 29, '2025-09-18 21:11:52', '2025-09-18 14:11:52', '2025-09-18 14:11:52', NULL),
(212, 5, NULL, NULL, '2025-09-18 21:16:57', '2025-09-18 14:16:57', '2025-09-18 14:16:57', NULL),
(213, 5, NULL, 30, '2025-09-18 21:17:19', '2025-09-18 14:17:19', '2025-09-18 14:17:19', NULL),
(214, 5, NULL, NULL, '2025-09-18 21:18:06', '2025-09-18 14:18:06', '2025-09-18 14:18:06', NULL),
(215, 5, NULL, NULL, '2025-09-18 21:19:56', '2025-09-18 14:19:56', '2025-09-18 14:19:56', NULL),
(216, 5, NULL, NULL, '2025-09-18 21:20:44', '2025-09-18 14:20:44', '2025-09-18 14:20:44', NULL),
(217, 5, NULL, NULL, '2025-09-18 21:27:13', '2025-09-18 14:27:13', '2025-09-18 14:27:13', NULL),
(218, 5, NULL, 32, '2025-09-18 21:27:28', '2025-09-18 14:27:28', '2025-09-18 14:27:28', NULL),
(219, 5, NULL, NULL, '2025-09-18 21:28:07', '2025-09-18 14:28:07', '2025-09-18 14:28:07', NULL),
(220, 5, NULL, NULL, '2025-09-18 21:29:59', '2025-09-18 14:29:59', '2025-09-18 14:29:59', NULL),
(221, 5, NULL, NULL, '2025-09-18 21:30:03', '2025-09-18 14:30:03', '2025-09-18 14:30:03', NULL),
(222, 5, NULL, NULL, '2025-09-18 21:33:39', '2025-09-18 14:33:39', '2025-09-18 14:33:39', NULL),
(223, 5, NULL, 33, '2025-09-18 22:01:38', '2025-09-18 15:01:38', '2025-09-18 15:01:38', NULL),
(224, 5, NULL, NULL, '2025-09-18 22:06:09', '2025-09-18 15:06:09', '2025-09-18 15:06:09', NULL),
(227, 5, NULL, NULL, '2025-09-18 22:12:59', '2025-09-18 15:12:59', '2025-09-18 15:12:59', NULL),
(236, 5, NULL, 44, '2025-09-18 22:31:36', '2025-09-18 15:31:36', '2025-09-18 15:31:36', NULL),
(237, 5, NULL, 45, '2025-09-18 22:33:49', '2025-09-18 15:33:49', '2025-09-18 15:33:49', NULL),
(238, 5, NULL, NULL, '2025-09-18 22:41:05', '2025-09-18 15:41:05', '2025-09-18 15:41:05', NULL),
(239, 5, NULL, NULL, '2025-09-18 22:41:11', '2025-09-18 15:41:11', '2025-09-18 15:41:11', NULL),
(240, 5, NULL, 46, '2025-09-18 22:41:26', '2025-09-18 15:41:26', '2025-09-18 15:41:26', NULL),
(241, 5, NULL, NULL, '2025-09-18 22:48:39', '2025-09-18 15:48:39', '2025-09-18 15:48:39', NULL),
(242, 5, NULL, 47, '2025-09-18 22:48:58', '2025-09-18 15:48:58', '2025-09-18 15:48:58', NULL),
(243, 5, 1, 47, '2025-09-18 22:48:58', '2025-09-18 15:48:58', '2025-09-18 15:48:58', 30.00),
(244, 4, NULL, NULL, '2025-09-21 06:58:16', '2025-09-20 23:58:16', '2025-09-20 23:58:16', NULL),
(245, 4, NULL, NULL, '2025-09-21 06:59:54', '2025-09-20 23:59:54', '2025-09-20 23:59:54', NULL),
(246, 4, NULL, NULL, '2025-09-21 07:00:02', '2025-09-21 00:00:02', '2025-09-21 00:00:02', NULL),
(247, 4, NULL, NULL, '2025-09-21 07:00:08', '2025-09-21 00:00:08', '2025-09-21 00:00:08', NULL),
(248, 4, NULL, NULL, '2025-09-21 07:00:14', '2025-09-21 00:00:14', '2025-09-21 00:00:14', NULL),
(249, 4, NULL, 48, '2025-09-21 07:00:34', '2025-09-21 00:00:34', '2025-09-21 00:00:34', NULL),
(250, 4, 1, 48, '2025-09-21 07:00:34', '2025-09-21 00:00:34', '2025-09-21 00:00:34', 30.00),
(251, 4, NULL, NULL, '2025-09-21 07:44:54', '2025-09-21 00:44:54', '2025-09-21 00:44:54', NULL),
(252, 4, NULL, NULL, '2025-09-21 07:45:05', '2025-09-21 00:45:05', '2025-09-21 00:45:05', NULL),
(253, 4, NULL, 49, '2025-09-21 07:45:26', '2025-09-21 00:45:26', '2025-09-21 00:45:26', NULL),
(254, 4, 9, 49, '2025-09-21 07:45:26', '2025-09-21 00:45:26', '2025-09-21 00:45:26', 30.00),
(255, 4, NULL, NULL, '2025-09-21 07:54:25', '2025-09-21 00:54:25', '2025-09-21 00:54:25', NULL),
(256, 4, NULL, 50, '2025-09-21 07:54:56', '2025-09-21 00:54:56', '2025-09-21 00:54:56', NULL),
(257, 4, 9, 50, '2025-09-21 07:54:56', '2025-09-21 00:54:56', '2025-09-21 00:54:56', 30.00),
(258, 4, NULL, NULL, '2025-09-21 07:59:32', '2025-09-21 00:59:32', '2025-09-21 00:59:32', NULL),
(259, 4, NULL, 51, '2025-09-21 07:59:52', '2025-09-21 00:59:52', '2025-09-21 00:59:52', NULL),
(260, 4, 9, 51, '2025-09-21 07:59:52', '2025-09-21 00:59:52', '2025-09-21 00:59:52', 30.00),
(261, 4, NULL, NULL, '2025-09-21 08:21:33', '2025-09-21 01:21:33', '2025-09-21 01:21:33', NULL),
(262, 4, NULL, 52, '2025-09-21 08:21:45', '2025-09-21 01:21:45', '2025-09-21 01:21:45', NULL),
(263, 4, 1, 52, '2025-09-21 08:21:45', '2025-09-21 01:21:45', '2025-09-21 01:21:45', 30.00),
(264, 4, NULL, NULL, '2025-09-21 10:08:18', '2025-09-21 03:08:18', '2025-09-21 03:08:18', NULL),
(265, 4, NULL, NULL, '2025-09-21 10:51:44', '2025-09-21 03:51:44', '2025-09-21 03:51:44', NULL),
(266, 4, NULL, NULL, '2025-09-21 10:56:24', '2025-09-21 03:56:24', '2025-09-21 03:56:24', NULL),
(267, 4, NULL, NULL, '2025-09-21 11:45:31', '2025-09-21 04:45:31', '2025-09-21 04:45:31', NULL),
(268, 4, NULL, NULL, '2025-09-22 19:16:51', '2025-09-22 12:16:51', '2025-09-22 12:16:51', NULL),
(269, 4, NULL, NULL, '2025-09-22 19:17:02', '2025-09-22 12:17:02', '2025-09-22 12:17:02', NULL),
(270, 4, NULL, 53, '2025-09-22 19:17:57', '2025-09-22 12:17:57', '2025-09-22 12:17:57', NULL),
(271, 4, 9, 53, '2025-09-22 19:17:57', '2025-09-22 12:17:57', '2025-09-22 12:17:57', 30.00),
(272, 4, NULL, NULL, '2025-09-22 21:06:52', '2025-09-22 14:06:52', '2025-09-22 14:06:52', NULL),
(273, 4, NULL, NULL, '2025-09-22 21:06:59', '2025-09-22 14:06:59', '2025-09-22 14:06:59', NULL),
(274, 4, NULL, NULL, '2025-09-22 21:07:05', '2025-09-22 14:07:05', '2025-09-22 14:07:05', NULL);

--
-- Bẫy `user_histories`
--
DELIMITER $$
CREATE TRIGGER `trg_user_histories_before_insert` BEFORE INSERT ON `user_histories` FOR EACH ROW BEGIN
  DECLARE v_discount DECIMAL(12,2);

  SELECT discount INTO v_discount
  FROM coupons
  WHERE id = NEW.coupon_id;

  SET NEW.discount = v_discount;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`, `color`, `size`, `material`) VALUES
(9, 5, 2, '2025-09-18 11:09:47', '2025-09-18 11:09:47', '#000000', '35', 'Da nhân tạo'),
(10, 4, 12, '2025-09-22 14:07:05', '2025-09-22 14:07:05', '#800000', '36', 'Da tổng hợp (PU)');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventories_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orders_momo_order_id_index` (`momo_order_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD KEY `password_reset_tokens_email_index` (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_reviews_order` (`order_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_inventory_id_foreign` (`inventory_id`),
  ADD KEY `fk_stock_movements_transaction_id` (`transaction_id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_details_inventory_id_foreign` (`inventory_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `user_histories`
--
ALTER TABLE `user_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_histories_user` (`user_id`),
  ADD KEY `fk_user_histories_coupon` (`coupon_id`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_product_variant` (`user_id`,`product_id`,`color`,`size`,`material`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `user_histories`
--
ALTER TABLE `user_histories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `fk_stock_movements_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_histories`
--
ALTER TABLE `user_histories`
  ADD CONSTRAINT `fk_user_histories_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_user_histories_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
