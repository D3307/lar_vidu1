-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 18, 2025 lúc 08:18 PM
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
-- Cơ sở dữ liệu: `ql_bangiaycaogot`
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
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `inventories`
--

INSERT INTO `inventories` (`id`, `product_id`, `quantity`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, 10000, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(2, 2, 687, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(3, 3, 2524, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(4, 4, 0, NULL, '2025-09-15 03:54:14', '2025-09-14 21:15:45'),
(5, 5, 2483, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(6, 6, 7359, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(7, 7, 1685, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(8, 8, 4595, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(9, 9, 1984, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(10, 10, 2526, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(11, 11, 645, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(12, 12, 0, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(13, 13, 1856, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(14, 14, 41, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14'),
(15, 15, 0, NULL, '2025-09-15 03:54:14', '2025-09-15 03:54:14');

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
(4, '2025_09_18_035442_create_wishlists_table', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `user_id`, `total`, `discount`, `final_total`, `status`, `payment_status`, `created_at`, `updated_at`, `payment_method`, `coupon_id`) VALUES
(2, 'Thảo', '0944763697', 'Hà Nội', 4, 3690000.00, 120000, 480000, 'pending', 'unpaid', '2025-09-12 05:46:27', '2025-09-12 05:46:27', 'cod', 10),
(3, 'Thảo', '0944763697', 'Hà Nội', 4, 3690000.00, 120000, 3570000, 'delivered', 'paid', '2025-09-12 05:49:23', '2025-09-14 19:29:09', 'cod', 10),
(4, 'Thảo', '0944763697', 'Hà Nội', 4, 4275000.00, 120000, 4155000, 'shipping', 'unpaid', '2025-09-12 05:55:25', '2025-09-14 22:44:54', 'cod', 10),
(5, 'Thảo', '0944763697', 'Hà Nội', 4, 740000.00, 120000, 620000, 'pending', 'unpaid', '2025-09-12 05:57:53', '2025-09-12 05:57:53', 'cod', 10),
(6, 'Linh', '0123456789', 'Nam Định', 5, 1049000.00, 262250, 786750, 'shipping', 'paid', '2025-09-14 23:01:28', '2025-09-15 07:04:25', 'momo', 7),
(8, 'Linh', '0987654321', 'Ha Noi', 5, 945000.00, 5000, 940000, 'delivered', 'paid', '2025-09-14 23:24:01', '2025-09-15 05:24:41', 'momo', 4),
(9, 'Lan', '098765431', 'Ha Noi', 10, 549000.00, 146700, 402300, 'processing', 'paid', '2025-09-15 00:58:44', '2025-09-15 00:58:44', 'momo', 1),
(11, 'Linh', '0987654321', 'Ha Noi', 5, 549000.00, 109800, 439200, 'delivered', 'paid', '2025-09-15 03:47:20', '2025-09-18 10:00:21', 'momo', 3),
(12, 'Lan', '0123456789', 'Ha Noi', 10, 370000.00, 37000, 333000, 'shipping', 'paid', '2025-09-15 03:53:07', '2025-09-15 05:24:12', 'momo', 2),
(13, 'Lan', '0987654321', 'Ha Noi', 10, 549000.00, 50000, 499000, 'cancelled', 'paid', '2025-09-15 03:56:48', '2025-09-15 05:24:02', 'momo', 8),
(14, 'Lan', '09763733737', 'Ha Noi', 10, 499000.00, 149700, 349300, 'processing', 'paid', '2025-09-15 04:05:43', '2025-09-15 05:21:22', 'momo', 1),
(15, 'Lan', '0123456789', 'Ha Noi', 10, 499000.00, 49900, 449100, 'delivered', 'paid', '2025-09-15 04:16:13', '2025-09-15 05:23:56', 'momo', 2),
(16, 'Lan', '0987654321', 'Hà Nội', 10, 549000.00, 164700, 384300, 'cancelled', 'paid', '2025-09-15 05:02:23', '2025-09-15 05:23:51', 'momo', 1),
(17, 'Linh', '0987654321', 'Hà Nội', 5, 549000.00, 50000, 499000, 'delivered', 'unpaid', '2025-09-15 05:47:48', '2025-09-18 09:59:50', 'cod', 8),
(18, 'Linh', '0987654321', 'Hà Nội', 5, 945000.00, 189000, 756000, 'cancelled', 'paid', '2025-09-15 06:00:58', '2025-09-15 06:59:44', 'momo', 10),
(19, 'Linh', '0987654321', 'Hà Nội', 5, 549000.00, 50000, 499000, 'delivered', 'paid', '2025-09-15 06:41:19', '2025-09-18 09:37:12', 'cod', 8),
(20, 'Linh', '0987654320', 'Ha Noi', 5, 549000.00, 0, 549000, 'delivered', 'unpaid', '2025-09-18 01:06:11', '2025-09-18 09:37:01', 'momo', NULL);

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
(23, 20, 1, NULL, NULL, 1, 549000.00, '2025-09-18 01:06:12', '2025-09-18 01:06:12');

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
  `size` varchar(50) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `image`, `size`, `material`, `color`, `description`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 5, 'Giày Cao Gót Slingback Phối Liệu Bóng', 'products/1757669169_1755787092_giayphoixich.jpeg', '35,36,37,38,39', 'Si bóng', '#000000,#ffc0cb,#fffdd0', 'Giày Cao Gót Slingback Phối Liệu Bóng thanh lịch, nữ tính\r\n\r\nThiết kế mũi nhọn, quai cách eo mang lại nét uyển chuyển trên từng bước chân\r\n\r\nGót cao 5cm kèm miếng đệm chống trơn trượt cho bạn dễ dàng di chuyển\r\n\r\nChất liệu da cao cấp tổng hợp. Giày phù hợp đi mọi dịp, như đi làm, dạo phố', 549000.00, 10000, '2025-09-12 02:26:09', '2025-09-12 02:29:27'),
(2, 1, 'Giày bít mũi nhọn gót stiletto', 'products/1757670291_giaybitmuinhon.jpg', '35,36,37,38,39', 'Da nhân tạo', '#000000,#fffdd0', 'Mã sản phẩm: 1010BMN0738\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót nhọn\r\nĐộ cao gót: 9 cm\r\nLoại mũi: Bít mũi nhọn\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Pumps', 855000.00, 687, '2025-09-12 02:43:22', '2025-09-15 03:36:36'),
(3, 1, 'Giày bít mũi block heel phối khóa trang trí', 'products/1757670432_giaybitmuiphoikhoa.jpg', '35,36,37,38,39', 'Da nhân tạo', '#000000,#fffdd0', 'Mã sản phẩm: 1010BMN0735\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót dạng khối\r\nĐộ cao gót: 6.5 cm\r\nLoại mũi: Bít mũi vuông\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Pumps', 945000.00, 2524, '2025-09-12 02:47:12', '2025-09-12 02:47:12'),
(4, 1, 'Giày slingback mũi nhọn phối khóa đôi', 'products/1757670596_giayslingbackmuinhonphoikhoadoi.jpg', '35,36,37,38,39', 'Da nhân tạo phủ bóng', '#800000,#000000', 'Mã sản phẩm: 1010BMN0731\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót nhọn\r\nĐộ cao gót: 8.5 cm\r\nLoại mũi: Bít mũi nhọn\r\nChất liệu: Da nhân tạo phủ bóng\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Mary Jane', 740000.00, 0, '2025-09-12 02:49:56', '2025-09-14 21:15:45'),
(5, 2, 'Giày sandal gót vuông quai ngang phối khóa trang trí', 'products/1757671059_giaysandalgotvuongquaingang.jpeg', '35,36,37,38,39', 'Si bóng', '#800000,#000000,#fffdd0', 'Giày Sandal Gót Vuông Quai Ngang Phối Khóa Trang Trí sành điệu\r\n\r\nQuai hậu phối khóa kim loại, gót trụ cao mang lại nét hiện đại, thời trang\r\n\r\nChất liệu da tổng hợp bền đẹp, dễ vệ sinh\r\n\r\nĐế bằng cao 9cm thanh lịch, dễ dàng di chuyển\r\n\r\nCó 3 màu cơ bản cho bạn dễ dàng lựa chọn và phối đồ', 599000.00, 2483, '2025-09-12 02:57:39', '2025-09-12 02:57:39'),
(6, 2, 'Giày sandal gót vuông quai ngang phối khóa trang trí', 'products/1757671441_giaysandalgotvuongquaingangphoikhoa.jpeg', '35,36,37,38,39', 'Da cao cấp tổng hợp', '#000000,#fffdd0,#aaaaaa', 'Giày sandal gót vuông quai ngang phối khoá trang trí tinh tế, thanh lịch\r\n\r\nGót vuông cao 5cm tạo cảm giác chắc chắn\r\n\r\nThiết kế thông minh với miếng đệm chống trơn trượt giúp đảm bảo an toàn cho bạn và tạo sự thoải mái trong lúc di chuyển\r\n\r\nChất liệu da tổng hợp cao cấp, dễ bảo quản, bền đẹp\r\n\r\nPhù hợp đi làm, đi tiệc, dạo phố', 499000.00, 7359, '2025-09-12 03:04:01', '2025-09-12 03:05:31'),
(7, 1, 'Giày Cao Gót Cao Gót Mũi Nhọn', 'products/1757671702_giaycaogotmuinhon.jpg', '35,36,37,38,39', 'Si bóng', '#000000,#fffdd0', 'Giày Cao Gót Cao Gót Mũi Nhọn thanh lịch, nữ tính\r\n\r\nGiày thiết kế mũi nhọn, quai cổ chân cách điệu mang lại nét đẹp uyển chuyển khi diện\r\n\r\nGót cao 5cm kèm miếng đệm chống trơn trượt cho bạn dễ dàng di chuyển\r\n\r\nChất liệu da cao cấp tổng hợp. Giày phù hợp đi mọi dịp, như đi làm, dạo phố', 499000.00, 1685, '2025-09-12 03:08:22', '2025-09-12 03:08:22'),
(8, 5, 'Giày Cao Gót Quai Mary Jane', 'products/1757932529_giaycaogotquaimaryjane.jpeg', '35,36,37,38,39', 'Si mờ trơn', '#000000,#ffc0cb,#a52a2a', 'Giày Cao Gót Quai Mary Jane thanh lịch\r\n\r\nMũi nhọn, quai nganh thanh mảnh, và gót bọc kim loại cực kì nữ tính\r\n\r\nThiết kế thông minh với đệm chống trơn trượt giúp đảm bảo an toàn cho bạn và tạo sự thoải mái trong lúc di chuyển\r\n\r\nChất liệu da tổng hợp cao cấp, dễ bảo quản, bền đẹp\r\n\r\nGiày có 3 màu dễ phối đồ. Phù hợp để đi làm, dạo phố, đi tiệc', 549000.00, 4595, '2025-09-12 03:12:20', '2025-09-15 03:35:31'),
(9, 4, 'Giày Cao Gót Đông Hải Bít Mũi Nhấn Quai Ankle Strap', 'products/1757672242_giayanklestrap.jpg', '35,36,37,38,39', 'Da tổng hợp (PU)', '#fffdd0,#0a0a0a,#fcdad5', 'Giày cao gót Đông Hải không chỉ là phụ kiện, mà là tuyên ngôn thời trang. Mẫu giày được thiết kế dành riêng cho những quý cô hiện đại, yêu thích sự thanh lịch nhưng vẫn muốn giữ nét trẻ trung, cuốn hút. Phần quai tinh tế ôm sát bàn chân, tạo nên vẻ đẹp duyên dáng. Độ cao 5cm không chỉ giúp tôn dáng mà còn mang lại sự thoải mái khi di chuyển cả ngày. Kiểu dáng hiện đại kết hợp cùng chất liệu cao cấp giúp đôi giày này trở thành điểm nhấn hoàn hảo cho bất kỳ trang phục nào!', 620000.00, 1984, '2025-09-12 03:17:22', '2025-09-12 03:18:01'),
(10, 4, 'Giày Cao Gót Zucia Mary Jane Đính Đá', 'products/1757674759_giaymaryjane.jpg', '35,36,37,38,39', 'Da tổng hợp (PU)', '#000000,#fcdad5,#B79d98', 'Giày cao gót mang phong cách cổ điển nhưng đầy cuốn hút, mẫu giày Mary Jane gót vuông sẽ là điểm nhấn hoàn hảo cho quý cô yêu thích nét thanh lịch pha chút kiêu sa và sang trọng. Chất liệu da bóng trở nên thu hút khi diện dưới ánh đèn, chi tiết khóa đá lấp lánh ở quai tạo điểm nhấn nữ tính. Giày nữ có gót vuông cao 5cm giúp dáng đi vững vàng, duyên dáng cả ngày dài. Dù kết hợp cùng váy tiểu thư, đầm dạ tiệc hay đơn giản là quần tây, quần jean thì đôi giày này chắc chắn sẽ nâng tầm phong cách, giúp người diện trở nên ấn tượng.', 890000.00, 2526, '2025-09-12 03:25:40', '2025-09-12 03:59:21'),
(11, 3, 'Giày Sandal Đế Xuồng Quai Chéo', 'products/1757672862_giaydexuong.jpg', '37,38,39', 'Si mờ trơn', '#000000,#ffc0cb,#fffdd0', 'Giày Sandal Đế Xuồng Quai Chéo thời trang, nữ tính\r\n\r\nThiết kế đế xuồng chắc chắn, quai đan chéo và quan cổ chân mang lại sự nổi bật và chắc chắn khi diện\r\n\r\nĐế bằng cao 9cm dễ dàng phối với nhiều bộ trang phục khác nhau\r\n\r\nChất liệu da tổng hợp bền đẹp, dễ vệ sinh', 549000.00, 645, '2025-09-12 03:27:43', '2025-09-12 03:32:33'),
(12, 1, 'Giày Cao Gót Đông Hải Satin Đính Pha Lê Sang Trọng', 'products/1757673114_giaysatin.jpg', '35,36,37,38', 'Da tổng hợp (PU)', '#800000,#000000,#fffdd0', 'Giày cao gót Đông Hải vải satin với thiết kế sang trọng sẽ là lựa chọn lý tưởng dành cho quý cô hiện đại hướng đến phong cách thời thượng. Đặc biệt, họa tiết đính đá pha lê tựa như một bông hoa gợi lên vẻ đẹp rạng rỡ, tăng phần tự tin khi diện. Đế nhọn cao 7cm tôn dáng, mang lại cảm giác thanh mảnh trong mỗi bước chân.', 850000.00, 4564, '2025-09-12 03:31:54', '2025-09-12 03:31:54'),
(13, 2, 'Giày Sandal Gót Vuông Quai Xé Dán', 'products/1757673608_giaysandalgotvuong.jpg', '35,38', 'Si mờ trơn', '#e6ddce,#f3ece2,#000000', 'Chất liệu da tổng hợp bền, đẹp\r\n\r\nQuai ngang thiết kế đơn giản, nữ tính\r\n\r\nQuai hậu dán, tiện dụng', 370000.00, 1856, '2025-09-12 03:40:08', '2025-09-12 03:40:08'),
(14, 1, 'Giày Cao Gót Zuciani Đế Nhọn Da Phối', 'products/1757674448_giaycaogotZucianidenhondaphoi.jpg', '35,36,37,38,39', 'Da cao cấp', '#20232a,#704a3d', 'Giày cao gót Zuciani là mẫu giày được hầu hết nhiều quý cô yêu thích lựa chọn bởi vừa dễ mang dễ phối vừa tôn dáng nhưng vẫn giữa được nét duyên dáng, uyển chuyển khi mang.', 2450000.00, 41, '2025-09-12 03:54:08', '2025-09-12 03:54:08'),
(15, 4, 'Giày cao gót viền cổ cao gót nón', 'products/1757674606_giaycaogotviencocaogotnon.jpg', '35,36,37,38,39', 'Da tổng hợp', '#B79d98,#000000,#fffdd0', 'Thiết kế dáng pump cổ điển được thổi hơi thở hiện đại hơn với gót nhọn hình chóp lạ mắt\r\n\r\nChất liệu da tổng hợp bóng mờ sang trọng, dễ vệ sinh\r\n\r\nDưới đé có rãnh chống trượt cho bước đi tự tin, thoải mái', 450000.00, 0, '2025-09-12 03:56:46', '2025-09-12 03:57:08');

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
(4, 5, 11, 1, 4, 'Shop cần xem xét lại thái độ nhân viên', '2025-09-18 10:01:05', '2025-09-18 10:01:05');

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
('44FCwRc1iKtxFiKeO3ILz6Hir9SfOh3s0DBWfEAb', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidDdVSGRBZGRxMjE1MGxKSk5ZWlRqRjVQSGF0alBFUWpMZ3Y3TjJxYSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758213333),
('N9YwHwNwd1LucuSg9BnMihCdX2iBKxVguVveCYqa', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM3lwUmF1YzZ3cWhuVE1kWnpZQlJPbHZZeGJhTllPSjc4SlQ1NWVvMSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758213334),
('Ua8Ungtg6jN8R52oYj81kp55U2FXAi1v5yik48e8', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaTVXU1Zjc0pQTzNzMmlna05KajR4ZFhkVkFsV1U0SkFXRTF6Y0t0UCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC93aXNobGlzdCI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O3M6NDoiY2FydCI7YToxOntzOjI3OiIyXzM1XyMwMDAwMDBfRGEgbmjDom4gdOG6oW8iO2E6ODp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozNjoiR2nDoHkgYsOtdCBtxalpIG5o4buNbiBnw7N0IHN0aWxldHRvIjtzOjU6InByaWNlIjtzOjk6Ijg1NTAwMC4wMCI7czo1OiJpbWFnZSI7czozODoicHJvZHVjdHMvMTc1NzY3MDI5MV9naWF5Yml0bXVpbmhvbi5qcGciO3M6NDoic2l6ZSI7czoyOiIzNSI7czo1OiJjb2xvciI7czo3OiIjMDAwMDAwIjtzOjg6Im1hdGVyaWFsIjtzOjE0OiJEYSBuaMOibiB04bqhbyI7czo4OiJxdWFudGl0eSI7czoxOiIxIjt9fX0=', 1758219441);

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
(4, 'Thảo', 'phamphuongthaond1911@gmail.com', '2025-09-12 07:21:58', '$2y$12$8Uo7yl964cazTJyWCImpzOvazanHogTY8GMmaTngCo7ixyxUAziTy', 'jqHXoNs9KXetj2HiyxB6flL2WnWVBuU3luo9vNPVpyhOcSfNU4QeV6S0PyG2', '2025-09-12 00:21:15', '2025-09-12 07:02:51', 'customer', '0944763697', 'Hà Nội'),
(5, 'Linh', '22111060566@hunre.edu.vn', '2025-09-12 07:26:57', '$2y$12$wf9Ucr32P293o/AHUmJc.OANE3Tw0I3v5GZsfrn57J1Kx5UsPUpre', 'aLOpAQjfSgGjvjj1YKBTSGuonW4uOnU0oEQuKoYsPuJ2nL6iXTY7cV82k52g', '2025-09-12 00:26:31', '2025-09-12 00:26:31', 'admin', '0987654321', 'Hà Nội'),
(10, 'Lan', 'lantruong346@gmail.com', '2025-09-15 07:55:37', '$2y$12$dyCpz7pTZhRbFFg2a6v2Xe3..blEWE/4UXFvfdZ8hZ4T4m3j5J2Pu', 'Y5reakdmmk9SOrcsVWeD7STDGTVP8c65mO0dmql2ZRh08TqGFY5rSGlQtfhd', '2025-09-15 00:53:06', '2025-09-15 00:53:06', 'customer', '0123456789', 'Hà Giang');

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
(165, 5, NULL, NULL, '2025-09-18 18:09:47', '2025-09-18 11:09:47', '2025-09-18 11:09:47', NULL);

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
(9, 5, 2, '2025-09-18 11:09:47', '2025-09-18 11:09:47', '#000000', '35', 'Da nhân tạo');

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
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `user_histories`
--
ALTER TABLE `user_histories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
