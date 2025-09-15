-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 15, 2025 lúc 12:05 PM
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

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-1b6453892473a467d07372d45eb05abc2031647a', 'i:1;', 1757661901),
('laravel-cache-1b6453892473a467d07372d45eb05abc2031647a:timer', 'i:1757661901;', 1757661901),
('laravel-cache-ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'i:2;', 1757662060),
('laravel-cache-ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4:timer', 'i:1757662060;', 1757662060);

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
(3, '2025_09_15_033717_create_inventories_table', 3);

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

INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `user_id`, `total`, `status`, `payment_status`, `created_at`, `updated_at`, `payment_method`, `coupon_id`) VALUES
(1, 'Thảo', '0944763697', 'Hà Nội', 4, 549000.00, 'delivered', 'paid', '2025-09-12 04:12:12', '2025-09-12 04:13:38', 'momo', NULL),
(2, 'Thảo', '0944763697', 'Hà Nội', 4, 3690000.00, 'pending', 'unpaid', '2025-09-12 05:46:27', '2025-09-12 05:46:27', 'cod', 10),
(3, 'Thảo', '0944763697', 'Hà Nội', 4, 3690000.00, 'delivered', 'unpaid', '2025-09-12 05:49:23', '2025-09-14 19:29:09', 'cod', 10),
(4, 'Thảo', '0944763697', 'Hà Nội', 4, 4275000.00, 'shipping', 'paid', '2025-09-12 05:55:25', '2025-09-14 22:44:54', 'cod', 10),
(5, 'Thảo', '0944763697', 'Hà Nội', 4, 740000.00, 'pending', 'pending', '2025-09-12 05:57:53', '2025-09-12 05:57:53', 'cod', 10),
(6, 'Linh', '0123456789', 'Nam Định', 5, 1049000.00, 'pending', 'pending', '2025-09-14 23:01:28', '2025-09-14 23:01:28', 'momo', 7),
(7, 'Linh', '0987654321', 'Hà Nội', 5, 499000.00, 'pending', 'pending', '2025-09-14 23:07:56', '2025-09-14 23:07:56', 'momo', 3),
(8, 'Linh', '0987654321', 'Ha Noi', 5, 945000.00, 'pending', 'pending', '2025-09-14 23:24:01', '2025-09-14 23:24:01', 'momo', 4),
(9, 'Lan', '098765431', 'Ha Noi', 10, 549000.00, 'pending', 'pending', '2025-09-15 00:58:44', '2025-09-15 00:58:44', 'momo', 1);

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
(1, 1, 1, NULL, NULL, 1, 549000.00, '2025-09-12 04:12:12', '2025-09-12 04:12:12'),
(2, 2, 3, '#fffdd0', '35', 1, 945000.00, '2025-09-12 05:46:27', '2025-09-12 05:46:27'),
(3, 2, 1, '#ffc0cb', '38', 5, 549000.00, '2025-09-12 05:46:27', '2025-09-12 05:46:27'),
(4, 3, 3, '#fffdd0', '35', 1, 945000.00, '2025-09-12 05:49:23', '2025-09-12 05:49:23'),
(5, 3, 1, '#ffc0cb', '38', 5, 549000.00, '2025-09-12 05:49:23', '2025-09-12 05:49:23'),
(6, 4, 2, NULL, NULL, 5, 855000.00, '2025-09-12 05:55:25', '2025-09-12 05:55:25'),
(7, 5, 4, NULL, NULL, 1, 740000.00, '2025-09-12 05:57:53', '2025-09-12 05:57:53'),
(8, 6, 15, '#000000', '35', 1, 450000.00, '2025-09-14 23:01:28', '2025-09-14 23:01:28'),
(9, 6, 5, '#000000', '35', 1, 599000.00, '2025-09-14 23:01:28', '2025-09-14 23:01:28'),
(10, 7, 6, NULL, NULL, 1, 499000.00, '2025-09-14 23:07:56', '2025-09-14 23:07:56'),
(11, 8, 3, '#fffdd0', '35', 1, 945000.00, '2025-09-14 23:24:01', '2025-09-14 23:24:01'),
(12, 9, 1, '#ffc0cb', '35', 1, 549000.00, '2025-09-15 00:58:44', '2025-09-15 00:58:44');

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
(2, 1, 'Giày bít mũi nhọn gót stiletto', 'products/1757670291_giaybitmuinhon.jpg', '35,36,37,38,39', NULL, '#000000,#fffdd0', 'Mã sản phẩm: 1010BMN0738\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót nhọn\r\nĐộ cao gót: 9 cm\r\nLoại mũi: Bít mũi nhọn\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Pumps', 855000.00, 687, '2025-09-12 02:43:22', '2025-09-12 02:59:50'),
(3, 1, 'Giày bít mũi block heel phối khóa trang trí', 'products/1757670432_giaybitmuiphoikhoa.jpg', '35,36,37,38,39', 'Da nhân tạo', '#000000,#fffdd0', 'Mã sản phẩm: 1010BMN0735\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót dạng khối\r\nĐộ cao gót: 6.5 cm\r\nLoại mũi: Bít mũi vuông\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Pumps', 945000.00, 2524, '2025-09-12 02:47:12', '2025-09-12 02:47:12'),
(4, 1, 'Giày slingback mũi nhọn phối khóa đôi', 'products/1757670596_giayslingbackmuinhonphoikhoadoi.jpg', '35,36,37,38,39', 'Da nhân tạo phủ bóng', '#800000,#000000', 'Mã sản phẩm: 1010BMN0731\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót nhọn\r\nĐộ cao gót: 8.5 cm\r\nLoại mũi: Bít mũi nhọn\r\nChất liệu: Da nhân tạo phủ bóng\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Mary Jane', 740000.00, 0, '2025-09-12 02:49:56', '2025-09-14 21:15:45'),
(5, 2, 'Giày sandal gót vuông quai ngang phối khóa trang trí', 'products/1757671059_giaysandalgotvuongquaingang.jpeg', '35,36,37,38,39', 'Si bóng', '#800000,#000000,#fffdd0', 'Giày Sandal Gót Vuông Quai Ngang Phối Khóa Trang Trí sành điệu\r\n\r\nQuai hậu phối khóa kim loại, gót trụ cao mang lại nét hiện đại, thời trang\r\n\r\nChất liệu da tổng hợp bền đẹp, dễ vệ sinh\r\n\r\nĐế bằng cao 9cm thanh lịch, dễ dàng di chuyển\r\n\r\nCó 3 màu cơ bản cho bạn dễ dàng lựa chọn và phối đồ', 599000.00, 2483, '2025-09-12 02:57:39', '2025-09-12 02:57:39'),
(6, 2, 'Giày sandal gót vuông quai ngang phối khóa trang trí', 'products/1757671441_giaysandalgotvuongquaingangphoikhoa.jpeg', '35,36,37,38,39', 'Da cao cấp tổng hợp', '#000000,#fffdd0,#aaaaaa', 'Giày sandal gót vuông quai ngang phối khoá trang trí tinh tế, thanh lịch\r\n\r\nGót vuông cao 5cm tạo cảm giác chắc chắn\r\n\r\nThiết kế thông minh với miếng đệm chống trơn trượt giúp đảm bảo an toàn cho bạn và tạo sự thoải mái trong lúc di chuyển\r\n\r\nChất liệu da tổng hợp cao cấp, dễ bảo quản, bền đẹp\r\n\r\nPhù hợp đi làm, đi tiệc, dạo phố', 499000.00, 7359, '2025-09-12 03:04:01', '2025-09-12 03:05:31'),
(7, 1, 'Giày Cao Gót Cao Gót Mũi Nhọn', 'products/1757671702_giaycaogotmuinhon.jpg', '35,36,37,38,39', 'Si bóng', '#000000,#fffdd0', 'Giày Cao Gót Cao Gót Mũi Nhọn thanh lịch, nữ tính\r\n\r\nGiày thiết kế mũi nhọn, quai cổ chân cách điệu mang lại nét đẹp uyển chuyển khi diện\r\n\r\nGót cao 5cm kèm miếng đệm chống trơn trượt cho bạn dễ dàng di chuyển\r\n\r\nChất liệu da cao cấp tổng hợp. Giày phù hợp đi mọi dịp, như đi làm, dạo phố', 499000.00, 1685, '2025-09-12 03:08:22', '2025-09-12 03:08:22'),
(8, 5, 'Giày Cao Gót Quai Mary Jane', NULL, '35,36,37,38,39', 'Si mờ trơn', '#000000,#ffc0cb,#a52a2a', 'Giày Cao Gót Quai Mary Jane thanh lịch\r\n\r\nMũi nhọn, quai nganh thanh mảnh, và gót bọc kim loại cực kì nữ tính\r\n\r\nThiết kế thông minh với đệm chống trơn trượt giúp đảm bảo an toàn cho bạn và tạo sự thoải mái trong lúc di chuyển\r\n\r\nChất liệu da tổng hợp cao cấp, dễ bảo quản, bền đẹp\r\n\r\nGiày có 3 màu dễ phối đồ. Phù hợp để đi làm, dạo phố, đi tiệc', 549000.00, 4595, '2025-09-12 03:12:20', '2025-09-12 03:12:53'),
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
(1, 4, 1, 1, 5, 'Chất lượng sản phẩm tốt, shop hỗ trợ tư vấn nhiệt tình', '2025-09-12 04:42:02', '2025-09-12 04:42:02');

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
('qgoQPR8ImCMMt5NNDmtMJH67g75ATcQUKFMsBVoz', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia0FnMkdhanJyTXBhQkw2Mmp4VEJpenhrczFRZEs1dWNjalR3Q3hUTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wYXltZW50L21vbW8vOCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1757926157);

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
(5, 'Linh', '22111060566@hunre.edu.vn', '2025-09-12 07:26:57', '$2y$12$wf9Ucr32P293o/AHUmJc.OANE3Tw0I3v5GZsfrn57J1Kx5UsPUpre', 'TRc9NOdcGOFCwqADB1b4O4P1eWT4LfJYdFdOoygmnnfwTNuhMsL8EmpJXHZK', '2025-09-12 00:26:31', '2025-09-12 00:26:31', 'admin', NULL, NULL),
(10, 'Lan', 'lantruong346@gmail.com', '2025-09-15 07:55:37', '$2y$12$dyCpz7pTZhRbFFg2a6v2Xe3..blEWE/4UXFvfdZ8hZ4T4m3j5J2Pu', 'Yqlz5wZiTfY8QpviLeq6fRFv2jq4yXMWLP35KSXVsJbUxuF9N3N8SZtKpoBP', '2025-09-15 00:53:06', '2025-09-15 00:53:06', 'customer', NULL, NULL);

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
(1, 4, NULL, NULL, '2025-09-12 11:04:26', '2025-09-12 04:04:26', '2025-09-12 04:04:26', NULL),
(2, 4, NULL, 1, '2025-09-12 11:12:12', '2025-09-12 04:12:12', '2025-09-12 04:12:12', NULL),
(3, 4, NULL, NULL, '2025-09-12 11:24:41', '2025-09-12 04:24:41', '2025-09-12 04:24:41', NULL),
(4, 4, NULL, NULL, '2025-09-12 11:24:49', '2025-09-12 04:24:49', '2025-09-12 04:24:49', NULL),
(5, 4, NULL, NULL, '2025-09-12 11:24:58', '2025-09-12 04:24:58', '2025-09-12 04:24:58', NULL),
(6, 4, NULL, NULL, '2025-09-12 11:25:06', '2025-09-12 04:25:06', '2025-09-12 04:25:06', NULL),
(7, 4, NULL, NULL, '2025-09-12 11:25:14', '2025-09-12 04:25:14', '2025-09-12 04:25:14', NULL),
(8, 4, NULL, NULL, '2025-09-12 11:25:19', '2025-09-12 04:25:19', '2025-09-12 04:25:19', NULL),
(9, 4, NULL, NULL, '2025-09-12 11:25:26', '2025-09-12 04:25:26', '2025-09-12 04:25:26', NULL),
(10, 4, NULL, NULL, '2025-09-12 11:25:36', '2025-09-12 04:25:36', '2025-09-12 04:25:36', NULL),
(11, 4, NULL, 2, '2025-09-12 12:46:27', '2025-09-12 05:46:27', '2025-09-12 05:46:27', NULL),
(12, 4, NULL, 2, '2025-09-12 12:46:27', '2025-09-12 05:46:27', '2025-09-12 05:46:27', NULL),
(13, 4, NULL, 3, '2025-09-12 12:49:23', '2025-09-12 05:49:23', '2025-09-12 05:49:23', NULL),
(14, 4, NULL, 3, '2025-09-12 12:49:23', '2025-09-12 05:49:23', '2025-09-12 05:49:23', NULL),
(15, 4, 10, 3, '2025-09-12 12:49:23', '2025-09-12 05:49:23', '2025-09-12 05:49:23', 20.00),
(16, 4, NULL, NULL, '2025-09-12 12:55:09', '2025-09-12 05:55:09', '2025-09-12 05:55:09', NULL),
(17, 4, NULL, 4, '2025-09-12 12:55:25', '2025-09-12 05:55:25', '2025-09-12 05:55:25', NULL),
(18, 4, 10, 4, '2025-09-12 12:55:25', '2025-09-12 05:55:25', '2025-09-12 05:55:25', 20.00),
(19, 4, NULL, NULL, '2025-09-12 12:57:44', '2025-09-12 05:57:44', '2025-09-12 05:57:44', NULL),
(20, 4, NULL, 5, '2025-09-12 12:57:53', '2025-09-12 05:57:53', '2025-09-12 05:57:53', NULL),
(21, 4, 10, 5, '2025-09-12 12:57:53', '2025-09-12 05:57:53', '2025-09-12 05:57:53', 20.00),
(22, 5, NULL, NULL, '2025-09-15 02:06:52', '2025-09-14 19:06:52', '2025-09-14 19:06:52', NULL),
(23, 5, NULL, NULL, '2025-09-15 03:59:44', '2025-09-14 20:59:44', '2025-09-14 20:59:44', NULL),
(24, 5, NULL, NULL, '2025-09-15 03:59:50', '2025-09-14 20:59:50', '2025-09-14 20:59:50', NULL),
(25, 5, NULL, NULL, '2025-09-15 04:03:05', '2025-09-14 21:03:05', '2025-09-14 21:03:05', NULL),
(26, 5, NULL, NULL, '2025-09-15 04:03:07', '2025-09-14 21:03:07', '2025-09-14 21:03:07', NULL),
(27, 5, NULL, NULL, '2025-09-15 04:13:51', '2025-09-14 21:13:51', '2025-09-14 21:13:51', NULL),
(28, 5, NULL, NULL, '2025-09-15 06:00:39', '2025-09-14 23:00:39', '2025-09-14 23:00:39', NULL),
(29, 5, NULL, NULL, '2025-09-15 06:00:47', '2025-09-14 23:00:47', '2025-09-14 23:00:47', NULL),
(30, 5, NULL, 6, '2025-09-15 06:01:28', '2025-09-14 23:01:28', '2025-09-14 23:01:28', NULL),
(31, 5, NULL, 6, '2025-09-15 06:01:28', '2025-09-14 23:01:28', '2025-09-14 23:01:28', NULL),
(32, 5, 7, 6, '2025-09-15 06:01:28', '2025-09-14 23:01:28', '2025-09-14 23:01:28', 25.00),
(33, 5, NULL, NULL, '2025-09-15 06:07:33', '2025-09-14 23:07:33', '2025-09-14 23:07:33', NULL),
(34, 5, NULL, 7, '2025-09-15 06:07:56', '2025-09-14 23:07:56', '2025-09-14 23:07:56', NULL),
(35, 5, 3, 7, '2025-09-15 06:07:57', '2025-09-14 23:07:57', '2025-09-14 23:07:57', 20.00),
(36, 5, NULL, NULL, '2025-09-15 06:23:18', '2025-09-14 23:23:18', '2025-09-14 23:23:18', NULL),
(37, 5, NULL, NULL, '2025-09-15 06:23:22', '2025-09-14 23:23:22', '2025-09-14 23:23:22', NULL),
(38, 5, NULL, NULL, '2025-09-15 06:23:30', '2025-09-14 23:23:30', '2025-09-14 23:23:30', NULL),
(39, 5, NULL, NULL, '2025-09-15 06:23:35', '2025-09-14 23:23:35', '2025-09-14 23:23:35', NULL),
(40, 5, NULL, 8, '2025-09-15 06:24:01', '2025-09-14 23:24:01', '2025-09-14 23:24:01', NULL),
(41, 5, 4, 8, '2025-09-15 06:24:01', '2025-09-14 23:24:01', '2025-09-14 23:24:01', 5000.00),
(42, 10, NULL, NULL, '2025-09-15 07:58:01', '2025-09-15 00:58:01', '2025-09-15 00:58:01', NULL),
(43, 10, NULL, NULL, '2025-09-15 07:58:08', '2025-09-15 00:58:08', '2025-09-15 00:58:08', NULL),
(44, 10, NULL, 9, '2025-09-15 07:58:44', '2025-09-15 00:58:44', '2025-09-15 00:58:44', NULL),
(45, 10, 1, 9, '2025-09-15 07:58:44', '2025-09-15 00:58:44', '2025-09-15 00:58:44', 30.00);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `user_histories`
--
ALTER TABLE `user_histories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
