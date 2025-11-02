-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 02, 2025 lúc 09:25 PM
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
(6, 'Giày Búp Bê', NULL, '2025-10-28 22:46:37', '2025-10-28 22:46:37'),
(7, 'Giày Thể Thao', NULL, '2025-10-28 22:46:48', '2025-10-28 22:47:27'),
(8, 'Giày Lười', NULL, '2025-10-28 22:46:58', '2025-10-28 22:47:34'),
(9, 'Giày Boot', NULL, '2025-10-28 22:57:34', '2025-10-28 22:57:34'),
(10, 'Giày Cao Gót', NULL, '2025-10-29 23:28:51', '2025-10-29 23:28:51'),
(11, 'Sandal', NULL, '2025-10-29 23:28:59', '2025-10-29 23:28:59');

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
(16, 16, 0, 0, NULL, NULL, NULL),
(17, 16, 0, 0, NULL, '2025-10-28 23:08:44', '2025-10-28 23:08:44'),
(20, 18, 0, 0, NULL, NULL, NULL),
(21, 18, 0, 0, NULL, '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(22, 19, 0, 0, NULL, NULL, NULL),
(23, 19, 0, 0, NULL, '2025-10-28 23:53:59', '2025-10-28 23:53:59'),
(24, 20, 0, 0, NULL, NULL, NULL),
(25, 20, 0, 0, NULL, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(26, 21, 0, 0, NULL, NULL, NULL),
(27, 21, 0, 0, NULL, '2025-10-29 21:04:33', '2025-10-29 21:04:33'),
(28, 22, 0, 0, NULL, NULL, NULL),
(29, 22, 0, 0, NULL, '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(30, 23, 0, 0, NULL, NULL, NULL),
(31, 23, 0, 0, NULL, '2025-10-29 22:48:55', '2025-10-29 22:48:55'),
(32, 24, 0, 0, NULL, NULL, NULL),
(33, 24, 0, 0, NULL, '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(34, 25, 0, 0, NULL, NULL, NULL),
(35, 25, 0, 0, NULL, '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(36, 26, 0, 0, NULL, NULL, NULL),
(37, 26, 0, 0, NULL, '2025-10-29 23:09:59', '2025-10-29 23:09:59'),
(38, 27, 0, 0, NULL, NULL, NULL),
(39, 27, 0, 0, NULL, '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(40, 28, 0, 0, NULL, NULL, NULL),
(41, 28, 0, 0, NULL, '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(42, 29, 0, 0, NULL, NULL, NULL),
(43, 29, 0, 0, NULL, '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(44, 30, 0, 0, NULL, NULL, NULL),
(45, 30, 0, 0, NULL, '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(46, 31, 0, 0, NULL, NULL, NULL),
(47, 31, 0, 0, NULL, '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(48, 32, 0, 0, NULL, NULL, NULL),
(49, 32, 0, 0, NULL, '2025-10-30 00:16:23', '2025-10-30 00:16:23');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `material` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `material`, `description`, `price`, `created_at`, `updated_at`) VALUES
(16, 6, 'Giày Búp Bê Đông Hải Da Bóng Thân Đính Nơ', 'Da tổng hợp (PU)', 'Giày Búp Bê Đông Hải mũi nhọn được chế tác từ chất liệu da bóng tạo hiệu ứng ánh sáng sang trọng và dễ vệ sinh. Thiết kế phối màu tinh tế, điểm nhấn nơ mảnh đính trên thân giày che khéo đường nối, tăng sự duyên dáng. Đế thấp êm ái giúp di chuyển thoải mái, phù hợp đi làm, dự tiệc nhẹ hoặc dạo phố thanh lịch.\r\n- Màu: Đen bóng, kem bóng\r\n- Size: 35 - 40\r\n- Chất liệu: Da Tổng Hợp (PU)\r\n- Đế: Cao su\r\n- Cao: 2cm', 690000.00, '2025-10-28 23:08:44', '2025-10-29 22:57:55'),
(18, 6, 'Giày Búp Bê Đông Hải Dáng Mary Jane Truyền Thống', 'Da vi sợi (Microfiber)', 'Giày búp bê Đông Hải với thiết kế tối giản với đường nét mềm mại, mũi tròn và quai cài thanh mảnh tạo nên vẻ thanh lịch đầy nữ tính. Phom dáng ôm gọn bàn chân kết hợp cùng đế bánh khoảng 5 cm, giúp tôn dáng nhẹ nhàng, tạo hiệu ứng chân thon dài mà vẫn giữ được sự ổn định, thoải mái khi di chuyển.\r\nChi tiết khóa ánh bạc mang điểm nhấn tinh tế, tổng thể phù hợp cả khi đi làm lẫn dạo phố. \r\n- Màu: Đen, Kem\r\n- Size: 35 - 40\r\n- Chất liệu: Da vi sợi (Microfiber)\r\n- Đế: Cao su\r\n- Cao: 5cm', 890000.00, '2025-10-28 23:51:46', '2025-10-29 22:58:01'),
(19, 6, 'Giày Búp Bê Zucia Khóa Vuông', 'Da tổng hợp (PU)', 'Giày búp bê Zucia được kết hợp hoàn hảo giữa tính thời trang và sự tiện dụng, giúp quý cô thoải mái trong từng bước chân mà còn tôn lên vẻ nữ tính, duyên dáng dù đi làm, đi chơi hay tham dự một sự kiện, đôi giày này luôn nổi bật và tự tin trong mọi khoảnh khắc.\r\n- Màu: Đen, Nâu, Hồng\r\n- Size: 35 - 39\r\n- Chất liệu: Da Tổng Hợp (PU)\r\n- Đế: Cao su\r\n- Cao: 2cm', 590000.00, '2025-10-28 23:53:59', '2025-10-29 22:58:07'),
(20, 7, 'Giày Thể Thao Zuciani The Trend Walkers N22', 'Da tổng hợp (PU)', 'Sneaker Z By Zuciani mang phong cách tối giản với gam màu trang nhã, dễ dàng phối hợp cùng nhiều kiểu trang phục. Form giày được hoàn thiện tỉ mỉ, mang lại sự cân đối và hiện đại cho cả nam và nữ. Phần đế dày chắc chắn, bám tốt, giúp từng bước đi ổn định và thoải mái suốt ngày dài. Lót giày mềm mại, hỗ trợ giảm áp lực khi di chuyển nhiều giờ. Dây buộc truyền thống cho phép điều chỉnh linh hoạt, đảm bảo độ vừa vặn tối ưu. Với thiết kế unisex đa dụng, đôi sneaker này là lựa chọn hoàn hảo để đồng hành từ đi học, đi làm đến dạo phố hay du lịch.\r\n- Màu: Trắng\r\n- Size: 36 - 45\r\n- Chất liệu: Da Tổng Hợp (PU)\r\n- Đế: Cao su\r\n- Cao: 5cm', 950000.00, '2025-10-29 20:49:49', '2025-10-29 22:58:13'),
(21, 7, 'Giày Thể Thao Zuciani The Trend Walkers N23', 'Da tổng hợp (PU)', 'Sneaker Z By Zuciani nổi bật với thiết kế hiện đại, điểm nhấn tinh tế từ logo và chi tiết phối màu nhẹ nhàng, mang lại vẻ ngoài trẻ trung và dễ phối đồ. Thân giày được hoàn thiện tỉ mỉ với các đường may chắc chắn, kết hợp cùng những lỗ thoáng khí giúp bàn chân luôn dễ chịu khi mang lâu. Phần đế cao dày dặn, có độ bám tốt, hỗ trợ bước đi ổn định và thoải mái trên nhiều bề mặt. Lót giày êm ái, giảm áp lực cho bàn chân khi vận động liên tục. Dây buộc truyền thống cho phép điều chỉnh linh hoạt, đảm bảo sự vừa vặn cho mọi dáng chân. Với thiết kế unisex, mẫu sneaker này có đủ size cho cả nam và nữ, phù hợp để đồng hành trong nhiều hoạt động thường ngày từ đi làm, đi học cho đến dạo phố hay du lịch.\r\n- Màu: Xanh, Hồng\r\n- Size: 36 - 39\r\n- Chất liệu: Da Tổng Hợp (PU)\r\n- Đế: Cao su\r\n- Cao: 6cm', 950000.00, '2025-10-29 21:04:33', '2025-10-29 22:58:19'),
(22, 7, 'Giày Thể Thao Zuciani The Trend Walkers N14', 'Da tổng hợp (PU)', 'Giày Sneakers Z By Zuciani mang thiết kế tối giản hiện đại với chất liệu da mịn, điểm nhấn nổi bật nằm ở chi tiết viền màu chạy dọc thân giày, tạo nên sự cá tính và khác biệt. Đường chỉ may khéo léo tăng tính thẩm mỹ cho tổng thể. Đế cao su có độ đàn hồi tốt, được bo nhẹ lên phần mũi nhằm bảo vệ tối ưu và hạn chế va đập khi di chuyển. Lót trong mềm mại, kết hợp phần hậu êm ái giúp ôm chân thoải mái, giảm áp lực khi đứng hoặc đi bộ lâu. Với thiết kế gọn gàng, nhẹ nhàng và linh hoạt, mẫu sneaker này phù hợp cho mọi hoạt động hằng ngày, từ đi làm, đi học cho đến dạo phố hay di chuyển dài.\r\n- Màu: Đỏ, Xám\r\n- Size: 36 - 40\r\n- Chất liệu: Da Tổng Hợp (PU)\r\n- Đế: Cao su\r\n- Cao: 2cm', 820000.00, '2025-10-29 21:16:16', '2025-10-29 22:58:27'),
(23, 8, 'Giày Mọi Nữ Zuciani Quai Ngang Khóa Vuông', 'Da cao cấp', 'Giày mọi nữ Zuciani kết hợp giữa thời thượng và nhẹ êm khi có chất liệu da cao cấp với phần đế cao 5cm giúp quý cô tự tin khi diện. \r\n- Màu: Đen\r\n- Size: 35 - 39\r\n- Chất liệu: Da cao cấp\r\n- Đế: Cao su\r\n- Cao: 5cm', 2350000.00, '2025-10-29 22:48:55', '2025-10-29 22:48:55'),
(24, 8, 'Giày Mọi Nữ Đông Hải Dáng Loafer Chunky', 'Da vi sợi (Microfiber)', 'Giày Mọi Nữ Đông Hải kiểu dáng trơn tối giản với chi tiết khoen kim loại nổi bật tạo điểm nhấn vừa đủ, mang lại diện mạo tinh tế mà không cầu kỳ. Form giày mọi ôm nhẹ bàn chân, dễ xỏ, dễ mang, lý tưởng để di chuyển linh hoạt hằng ngày mà vẫn giữ phong cách chỉn chu.Phần đế dày khoảng 5cm giúp tăng chiều cao nhẹ nhàng. Dễ phối đồ – từ trang phục công sở đến phong cách dạo phố cuối tuần.\r\n- Màu: Đen, Kem\r\n- Size: 35 - 40\r\n- Chất liệu: Da vi sợi (Microfiber)\r\n- Đế: Cao su\r\n- Cao: 5cm', 890000.00, '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(25, 8, 'Giày Mọi Zucia Họa Tiết Hoa Ba Cánh', 'Da tổng hợp (PU)', 'Giày Mọi Nữ Zucia là mẫu giày dành cho các quý cô yêu thích phong cách nhẹ nhàng, thanh lịch. Phom ôm dáng đôi chân trông thon thả mang lại cảm giác nữ tính, giúp quý cô thêm phần tự tin.\r\n- Màu: Đen, Cafe\r\n- Size: 35 - 39\r\n- Chất liệu: Da tổng hợp (PU)\r\n- Đế: Cao su\r\n- Cao: 2cm', 620000.00, '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(26, 9, 'Giày Boot Nữ Zucia Mũi Nhọn Thiết Kế Khóa Kéo', 'Da tổng hợp (PU)', '- Màu sắc: Đen, Kem\r\n- Size: 35 - 39\r\n- Chất liệu: Da PU\r\n- Đế: Cao su\r\n- Cao: 6cm', 1490000.00, '2025-10-29 23:09:59', '2025-10-29 23:09:59'),
(27, 9, 'Giày Boot Nữ Đông Hải Cổ Cao Da Bóng Thời Thượng', 'Da tổng hợp', 'Giày Boot Nữ Đông Hải có thiết kế cổ cao qua gối trông vô cùng thời thượng và hiện đại. Đây là mẫu giày được trình diễn trong show Duyên của NTK Adrina Anh Tuấn do Đông Hải đồng hành và hỗ trợ. Thiết kế của giày được chăm chút tỉ mỉ trong từng chi tiết nhằm đảm bảo độ hoàn thiện từ thiết kế cho đến chất liệu. Mẫu giày mang \"hơi thở\" đan xen giữa hiện đại nhưng vẫn có chút phá cách khi quý cô có thể kết hợp cùng khăn turban kèm theo để tạo điểm nhấn trông vô cùng lạ mắt. \r\n- Màu sắc: Đen, Cafe, Nâu, Tím\r\n- Size: 36 - 39\r\n- Chất liệu: Da Tổng Hợp\r\n- Đế: Cao su\r\n- Cao: 7cm', 2150000.00, '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(28, 9, 'Boots Nữ Zuciani Cổ Cao Mũi Tròn Khoá kéo', 'Da', '- Loại sản phẩm: Giày boots nữ Zuciani\r\n- Màu sắc: Đen, Nâu\r\n- Size: 35 - 39\r\n- Chất liệu: Da\r\n- Đế: Cao su\r\n- Cao: 5cm', 3250000.00, '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(29, 10, 'Giày Cao Gót Zuciani Đế Nhọn Da Phối', 'Da cao cấp', 'Giày cao gót Zuciani là mẫu giày được hầu hết nhiều quý cô yêu thích lựa chọn bởi vừa dễ mang dễ phối vừa tôn dáng nhưng vẫn giữa được nét duyên dáng, uyển chuyển khi mang.\r\n- Màu: Đen, Nâu\r\n- Size: 35 - 39\r\n- Chất liệu: Da Cao Cấp\r\n- Đế: Cao su\r\n- Cao: 7cm', 2450000.00, '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(30, 10, 'Giày Cao Gót Zucia Mary Jane Đính Đá', 'Da tổng hợp (PU)', 'Giày cao gót mang phong cách cổ điển nhưng đầy cuốn hút, mẫu giày Mary Jane gót vuông sẽ là điểm nhấn hoàn hảo cho quý cô yêu thích nét thanh lịch pha chút kiêu sa và sang trọng. Chất liệu da bóng trở nên thu hút khi diện dưới ánh đèn, chi tiết khóa đá lấp lánh ở quai tạo điểm nhấn nữ tính. Giày nữ có gót vuông cao 5cm giúp dáng đi vững vàng, duyên dáng cả ngày dài. Dù kết hợp cùng váy tiểu thư, đầm dạ tiệc hay đơn giản là quần tây, quần jean thì đôi giày này chắc chắn sẽ nâng tầm phong cách, giúp người diện trở nên ấn tượng.\r\n- Màu: Đen, Đỏ, Hồng\r\n- Size: 35 - 39\r\n- Chất liệu: Da Tổng Hợp (PU)\r\n- Đế: Cao su\r\n- Cao: 5cm', 890000.00, '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(31, 10, 'Dép Mules Cao Gót Nữ Đông Hải Quai Phối Đá Lấp Lánh', 'Da tổng hợp (PU)', 'Dép Mules cao gót nữ Đông Hải với thiết kế mũi nhọn thanh lịch, quai ngang đính đá lấp lánh và gót trong suốt ánh kim mang đến vẻ ngoài sang trọng, thời thượng. Kiểu dép cao gót mũi nhọn hở gót giúp tôn dáng, tạo cảm giác thoáng nhẹ và dễ kết hợp cùng đầm, quần tây hay váy công sở. Lý tưởng cho nàng yêu thích dép cao gót quai đá, thiết kế tinh tế, dễ đi, phù hợp để diện đi làm, dự tiệc hay dạo phố thường ngày. Đây là lựa chọn hoàn hảo nếu quý cô đang tìm một mẫu dép Mules nữ cao gót vừa thanh lịch, vừa tiện dụng.\r\n- Màu sắc: Đen, Xám\r\n- Size: 35 - 39\r\n- Chất liệu: Da Tổng Hợp (PU)\r\n- Cao: 7cm', 720000.00, '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(32, 11, 'Giày Sandal Cao Gót Đông Hải Quai Đan Mảnh', 'Da tổng hợp (PU)', 'Sandal nữ quai mảnh gót vuông sở hữu thiết kế thanh lịch, hiện đại với đường nét tối giản nhưng đầy cuốn hút. Phần thân giày nổi bật với cấu trúc quai mảnh bắt chéo tinh tế, ôm gọn bàn chân và tạo hiệu ứng kéo dài dáng chân nhẹ nhàng. Quai hậu có khóa gài kim loại chắc chắn, dễ dàng điều chỉnh để phù hợp với từng dáng chân, đồng thời giúp giữ chân cố định khi di chuyển. Gót vuông cao vừa phải, vững chắc và mang lại cảm giác thoải mái cho cả ngày dài sử dụng. \r\n- Mã sản phẩm: S32F8\r\n- Màu: Đen, Kem, Xanh\r\n- Size: 35 - 39\r\n- Chất liệu: Da tổng hợp (PU)\r\n- Đế: Cao su\r\n- Cao: 6cm', 720000.00, '2025-10-30 00:16:23', '2025-10-30 00:16:23');

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
(18, 16, '#000000', '35', 2342, '2025-10-28 23:41:58', '2025-10-28 23:41:58'),
(19, 16, '#DCC1B0', '36', 45, '2025-10-28 23:42:28', '2025-10-28 23:42:28'),
(20, 16, '#000000', '37', 45, '2025-10-28 23:42:41', '2025-10-28 23:42:41'),
(21, 16, '#DCC1B0', '38', 753, '2025-10-28 23:42:59', '2025-10-28 23:42:59'),
(22, 16, '#000000', '39', 75, '2025-10-28 23:43:07', '2025-10-28 23:43:07'),
(23, 16, '#DCC1B0', '40', 1, '2025-10-28 23:43:16', '2025-10-28 23:43:16'),
(24, 18, '#000000', '35', 0, '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(25, 18, '#EFE1D8', '36', 0, '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(26, 18, '#000000', '37', 1000, '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(27, 18, '#EFE1D8', '38', 15680, '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(28, 18, '#000000', '39', 2984, '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(29, 19, '#B79D98', '35', 23, '2025-10-28 23:59:49', '2025-10-28 23:59:49'),
(30, 19, '#000000', '36', 2354, '2025-10-29 00:00:01', '2025-10-29 00:00:01'),
(31, 19, '#C5A890', '37', 678, '2025-10-29 00:00:21', '2025-10-29 00:00:21'),
(32, 19, '#000000', '38', 5, '2025-10-29 00:00:41', '2025-10-29 00:00:41'),
(33, 19, '#C5A890', '39', 500, '2025-10-29 00:00:54', '2025-10-29 00:00:54'),
(34, 20, '#ffffff', '36', 206, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(35, 20, '#ffffff', '37', 1, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(36, 20, '#ffffff', '38', 23, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(37, 20, '#ffffff', '39', 56, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(38, 20, '#ffffff', '40', 89, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(39, 20, '#ffffff', '41', 4675, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(40, 20, '#ffffff', '42', 635, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(41, 20, '#ffffff', '43', 64, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(42, 20, '#ffffff', '44', 653, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(43, 20, '#ffffff', '45', 2, '2025-10-29 20:49:49', '2025-10-29 20:49:49'),
(44, 21, '#D65E80', '36', 34, '2025-10-29 21:05:41', '2025-10-29 21:05:41'),
(45, 21, '#1F273C', '37', 346, '2025-10-29 21:06:09', '2025-10-29 21:06:09'),
(46, 21, '#D65E80', '38', 457, '2025-10-29 21:06:26', '2025-10-29 21:06:26'),
(47, 21, '#1F273C', '39', 753, '2025-10-29 21:06:38', '2025-10-29 21:06:38'),
(48, 22, '#802A35', '36', 345, '2025-10-29 21:16:16', '2025-10-29 23:52:25'),
(49, 22, '#51432C', '37', 3658, '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(50, 22, '#802A35', '38', 89, '2025-10-29 21:16:16', '2025-10-29 23:52:48'),
(51, 22, '#51432C', '39', 234, '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(52, 22, '#802A35', '40', 0, '2025-10-29 21:16:16', '2025-10-29 23:53:35'),
(53, 23, '#000000', '36', 34, '2025-10-29 22:49:10', '2025-10-29 22:49:10'),
(54, 23, '#000000', '37', 345, '2025-10-29 22:49:18', '2025-10-29 22:49:18'),
(55, 23, '#000000', '38', 89, '2025-10-29 22:49:25', '2025-10-29 22:49:25'),
(56, 23, '#000000', '39', 234, '2025-10-29 22:49:33', '2025-10-29 22:49:33'),
(57, 23, '#000000', '35', 12, '2025-10-29 22:49:46', '2025-10-29 22:49:46'),
(58, 24, '#F9E3B7', '35', 324, '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(59, 24, '#000000', '36', 356, '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(60, 24, '#F9E3B7', '37', 0, '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(61, 24, '#000000', '38', 245, '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(62, 24, '#F9E3B7', '39', 790, '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(63, 24, '#000000', '40', 12, '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(64, 25, '#E0C2AE', '35', 5769, '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(65, 25, '#000000', '36', 0, '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(66, 25, '#E0C2AE', '37', 34, '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(67, 25, '#000000', '38', 0, '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(68, 25, '#E0C2AE', '39', 0, '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(69, 26, '#DCDBA8', '35', 780, '2025-10-29 23:09:59', '2025-10-29 23:11:25'),
(70, 26, '#DCDBA8', '36', 123, '2025-10-29 23:09:59', '2025-10-29 23:11:34'),
(71, 26, '#DCDBA8', '37', 456, '2025-10-29 23:09:59', '2025-10-29 23:11:43'),
(72, 26, '#DCDBA8', '38', 243, '2025-10-29 23:09:59', '2025-10-29 23:11:54'),
(73, 26, '#DCDBA8', '39', 0, '2025-10-29 23:09:59', '2025-10-29 23:11:15'),
(74, 27, '#19193B', '36', 567, '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(75, 27, '#000000', '37', 356, '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(76, 27, '#AD8971', '38', 46, '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(77, 28, '#332826', '35', 357, '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(78, 28, '#33262829', '36', 1234, '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(79, 28, '#33262829', '37', 0, '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(80, 28, '#33262829', '38', 0, '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(81, 28, '#33262829', '39', 5678, '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(82, 29, '#000000', '35', 869, '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(83, 29, '#643C2D', '36', 24, '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(84, 29, '#000000', '37', 3567, '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(85, 29, '#643C2D', '38', 2355, '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(86, 29, '#000000', '39', 38, '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(87, 30, '#802A35', '35', 234, '2025-10-29 23:49:34', '2025-10-29 23:53:54'),
(88, 30, '#000000', '36', 386, '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(89, 30, '#88A09A', '37', 7653, '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(90, 30, '#802A35', '38', 735, '2025-10-29 23:49:34', '2025-10-29 23:54:12'),
(91, 30, '#000000', '39', 87, '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(92, 31, '#000000', '35', 16, '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(93, 31, '#C7C6CB', '36', 468, '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(94, 31, '#000000', '37', 4896, '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(95, 31, '#C7C6CB', '38', 98, '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(96, 31, '#000000', '39', 156, '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(97, 32, '#C8D6DF', '35', 8946, '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(98, 32, '#000000', '36', 51, '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(99, 32, '#fffdd0', '37', 54, '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(100, 32, '#C8D6DF', '38', 65, '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(101, 32, '#000000', '39', 456, '2025-10-30 00:16:23', '2025-10-30 00:16:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `created_at`, `updated_at`) VALUES
(13, 16, 'products/1761718124_a1.jpg', '2025-10-28 23:08:44', '2025-10-28 23:08:44'),
(14, 16, 'products/1761718338_a1.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(15, 16, 'products/1761718338_a2.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(16, 16, 'products/1761718338_a3.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(17, 16, 'products/1761718338_a4.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(18, 16, 'products/1761718338_a5.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(19, 16, 'products/1761718338_b1.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(20, 16, 'products/1761718338_b2.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(21, 16, 'products/1761718338_b3.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(22, 16, 'products/1761718338_b4.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(23, 16, 'products/1761718338_b5.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(24, 16, 'products/1761718338_c1.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(25, 16, 'products/1761718338_c2.jpg', '2025-10-28 23:12:18', '2025-10-28 23:12:18'),
(26, 18, 'products/1761720706_a1.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(27, 18, 'products/1761720706_a2.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(28, 18, 'products/1761720706_a3.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(29, 18, 'products/1761720706_a4.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(30, 18, 'products/1761720706_a5.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(31, 18, 'products/1761720706_b1.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(32, 18, 'products/1761720706_b2.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(33, 18, 'products/1761720706_b3.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(34, 18, 'products/1761720706_b4.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(35, 18, 'products/1761720706_b5.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(36, 18, 'products/1761720706_c1.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(37, 18, 'products/1761720706_c2.jpg', '2025-10-28 23:51:46', '2025-10-28 23:51:46'),
(38, 19, 'products/1761721273_a1.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(39, 19, 'products/1761721273_a2.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(40, 19, 'products/1761721273_a3.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(41, 19, 'products/1761721273_a4.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(42, 19, 'products/1761721273_a5.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(43, 19, 'products/1761721273_b1.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(44, 19, 'products/1761721273_b2.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(45, 19, 'products/1761721273_b3.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(46, 19, 'products/1761721273_b4.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(47, 19, 'products/1761721273_b5.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(48, 19, 'products/1761721273_c1.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(49, 19, 'products/1761721273_c2.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(50, 19, 'products/1761721273_d1.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(51, 19, 'products/1761721273_d2.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(52, 19, 'products/1761721273_d3.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(53, 19, 'products/1761721273_d4.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(54, 19, 'products/1761721273_d5.jpg', '2025-10-29 00:01:13', '2025-10-29 00:01:13'),
(55, 20, 'products/1761796336_a1.jpg', '2025-10-29 20:52:17', '2025-10-29 20:52:17'),
(56, 20, 'products/1761796337_a2.jpg', '2025-10-29 20:52:17', '2025-10-29 20:52:17'),
(57, 20, 'products/1761796337_a3.jpg', '2025-10-29 20:52:17', '2025-10-29 20:52:17'),
(58, 20, 'products/1761796337_a4.jpg', '2025-10-29 20:52:17', '2025-10-29 20:52:17'),
(59, 20, 'products/1761796337_a5.jpg', '2025-10-29 20:52:17', '2025-10-29 20:52:17'),
(60, 21, 'products/1761797306_a1.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(61, 21, 'products/1761797306_a2.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(62, 21, 'products/1761797306_a3.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(63, 21, 'products/1761797306_a4.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(64, 21, 'products/1761797306_a5.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(65, 21, 'products/1761797306_b1.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(66, 21, 'products/1761797306_b2.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(67, 21, 'products/1761797306_b3.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(68, 21, 'products/1761797306_b4.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(69, 21, 'products/1761797306_b5.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(70, 21, 'products/1761797306_c1.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(71, 21, 'products/1761797306_c2.jpg', '2025-10-29 21:08:26', '2025-10-29 21:08:26'),
(72, 22, 'products/1761797776_a1.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(73, 22, 'products/1761797776_a2.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(74, 22, 'products/1761797776_a3.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(75, 22, 'products/1761797776_a4.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(76, 22, 'products/1761797776_a5.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(77, 22, 'products/1761797776_b1.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(78, 22, 'products/1761797776_b2.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(79, 22, 'products/1761797776_b3.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(80, 22, 'products/1761797776_b4.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(81, 22, 'products/1761797776_b5.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(82, 22, 'products/1761797776_c1.jpg', '2025-10-29 21:16:16', '2025-10-29 21:16:16'),
(83, 23, 'products/1761803424_a1.jpg', '2025-10-29 22:50:24', '2025-10-29 22:50:24'),
(84, 23, 'products/1761803424_a2.jpg', '2025-10-29 22:50:24', '2025-10-29 22:50:24'),
(85, 23, 'products/1761803424_a3.jpg', '2025-10-29 22:50:24', '2025-10-29 22:50:24'),
(86, 23, 'products/1761803424_a4.jpg', '2025-10-29 22:50:24', '2025-10-29 22:50:24'),
(87, 23, 'products/1761803424_a5.jpg', '2025-10-29 22:50:24', '2025-10-29 22:50:24'),
(88, 24, 'products/1761803819_a1.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(89, 24, 'products/1761803819_a2.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(90, 24, 'products/1761803819_a3.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(91, 24, 'products/1761803819_a4.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(92, 24, 'products/1761803819_a5.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(93, 24, 'products/1761803819_b1.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(94, 24, 'products/1761803819_b2.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(95, 24, 'products/1761803819_b3.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(96, 24, 'products/1761803819_b4.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(97, 24, 'products/1761803819_b5.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(98, 24, 'products/1761803819_c1.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(99, 24, 'products/1761803819_c2.jpg', '2025-10-29 22:56:59', '2025-10-29 22:56:59'),
(100, 25, 'products/1761804231_a1.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(101, 25, 'products/1761804231_a2.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(102, 25, 'products/1761804231_a3.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(103, 25, 'products/1761804231_a4.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(104, 25, 'products/1761804231_a5.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(105, 25, 'products/1761804231_b1.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(106, 25, 'products/1761804231_b2.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(107, 25, 'products/1761804231_b3.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(108, 25, 'products/1761804231_b4.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(109, 25, 'products/1761804231_b5.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(110, 25, 'products/1761804231_c1.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(111, 25, 'products/1761804231_c2.jpg', '2025-10-29 23:03:51', '2025-10-29 23:03:51'),
(112, 26, 'products/1761804599_a1.jpg', '2025-10-29 23:09:59', '2025-10-29 23:09:59'),
(113, 26, 'products/1761804599_a2.jpg', '2025-10-29 23:09:59', '2025-10-29 23:09:59'),
(114, 26, 'products/1761804599_a3.jpg', '2025-10-29 23:09:59', '2025-10-29 23:09:59'),
(115, 26, 'products/1761804599_a4.jpg', '2025-10-29 23:09:59', '2025-10-29 23:09:59'),
(116, 26, 'products/1761804599_a5.jpg', '2025-10-29 23:09:59', '2025-10-29 23:09:59'),
(117, 26, 'products/1761804599_c1.jpg', '2025-10-29 23:09:59', '2025-10-29 23:09:59'),
(118, 27, 'products/1761805115_a1.jpg', '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(119, 27, 'products/1761805115_a2.jpg', '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(120, 27, 'products/1761805115_a3.jpg', '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(121, 27, 'products/1761805115_a4.jpg', '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(122, 27, 'products/1761805115_b1.jpg', '2025-10-29 23:18:35', '2025-10-29 23:18:35'),
(123, 27, 'products/1761805116_b2.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(124, 27, 'products/1761805116_b3.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(125, 27, 'products/1761805116_b4.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(126, 27, 'products/1761805116_c1.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(127, 27, 'products/1761805116_c2.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(128, 27, 'products/1761805116_c3.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(129, 27, 'products/1761805116_d1.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(130, 27, 'products/1761805116_d2.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(131, 27, 'products/1761805116_d3.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(132, 27, 'products/1761805116_d4.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(133, 27, 'products/1761805116_d5.jpg', '2025-10-29 23:18:36', '2025-10-29 23:18:36'),
(134, 28, 'products/1761805508_a1.jpg', '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(135, 28, 'products/1761805508_a2.jpg', '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(136, 28, 'products/1761805508_a3.jpg', '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(137, 28, 'products/1761805508_a4.jpg', '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(138, 28, 'products/1761805508_a5.jpg', '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(139, 28, 'products/1761805508_c1.jpg', '2025-10-29 23:25:08', '2025-10-29 23:25:08'),
(140, 29, 'products/1761806075_a1.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(141, 29, 'products/1761806075_a2.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(142, 29, 'products/1761806075_a3.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(143, 29, 'products/1761806075_a4.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(144, 29, 'products/1761806075_a5.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(145, 29, 'products/1761806075_b1.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(146, 29, 'products/1761806075_b2.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(147, 29, 'products/1761806075_b3.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(148, 29, 'products/1761806075_b4.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(149, 29, 'products/1761806075_b5.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(150, 29, 'products/1761806075_c1.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(151, 29, 'products/1761806075_c2.jpg', '2025-10-29 23:34:35', '2025-10-29 23:34:35'),
(152, 30, 'products/1761806974_a1.jpg', '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(153, 30, 'products/1761806974_a2.jpg', '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(154, 30, 'products/1761806974_a3.jpg', '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(155, 30, 'products/1761806974_a4.jpg', '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(156, 30, 'products/1761806974_a5.jpg', '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(157, 30, 'products/1761806974_b1.jpg', '2025-10-29 23:49:34', '2025-10-29 23:49:34'),
(158, 30, 'products/1761806975_b2.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(159, 30, 'products/1761806975_b3.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(160, 30, 'products/1761806975_b4.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(161, 30, 'products/1761806975_b5.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(162, 30, 'products/1761806975_c1.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(163, 30, 'products/1761806975_c2.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(164, 30, 'products/1761806975_c3.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(165, 30, 'products/1761806975_d1.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(166, 30, 'products/1761806975_d2.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(167, 30, 'products/1761806975_d3.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(168, 30, 'products/1761806975_d4.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(169, 30, 'products/1761806975_d5.jpg', '2025-10-29 23:49:35', '2025-10-29 23:49:35'),
(170, 31, 'products/1761807762_a1.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(171, 31, 'products/1761807762_a2.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(172, 31, 'products/1761807762_a3.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(173, 31, 'products/1761807762_a4.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(174, 31, 'products/1761807762_a5.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(175, 31, 'products/1761807762_b1.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(176, 31, 'products/1761807762_b2.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(177, 31, 'products/1761807762_b3.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(178, 31, 'products/1761807762_b4.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(179, 31, 'products/1761807762_b5.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(180, 31, 'products/1761807762_c1.jpg', '2025-10-30 00:02:42', '2025-10-30 00:02:42'),
(181, 32, 'products/1761808583_a1.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(182, 32, 'products/1761808583_a2.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(183, 32, 'products/1761808583_a3.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(184, 32, 'products/1761808583_a4.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(185, 32, 'products/1761808583_a5.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(186, 32, 'products/1761808583_b1.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(187, 32, 'products/1761808583_b2.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(188, 32, 'products/1761808583_b3.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(189, 32, 'products/1761808583_b4.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(190, 32, 'products/1761808583_b5.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(191, 32, 'products/1761808583_c1.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(192, 32, 'products/1761808583_c2.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(193, 32, 'products/1761808583_d1.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(194, 32, 'products/1761808583_d2.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(195, 32, 'products/1761808583_d3.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(196, 32, 'products/1761808583_d4.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23'),
(197, 32, 'products/1761808583_d5.jpg', '2025-10-30 00:16:23', '2025-10-30 00:16:23');

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
  `media` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('WImISgcK09cV2yQR5RE5GktDJkrTl5ZynG4ykx3n', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMFMzeUYxOE5lWm8xdWdidTNnbTZCWXl3b0VSa3VlWFlRcU8yMUNYTyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcHJvZHVjdHM/cGFnZT0yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1762114840),
('zQf5MVJrJokrcXiMZpCqD5IBj5McteWdgvwjCa2d', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTzNFdTFLd0N6cnl0Z0VBWG5xMjQ2eGdlT0FQQm9rZk5xSkZuWGNtMCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHJvZHVjdHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1762114944);

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
(4, 'Thảo', 'phamphuongthaond1911@gmail.com', '2025-09-12 07:21:58', '$2y$12$8Uo7yl964cazTJyWCImpzOvazanHogTY8GMmaTngCo7ixyxUAziTy', 'MByhkpzeKXCedPloawaNynRNwNRSv1cIIuBpTrDFPJ614oBsWZ4YRcnjK0Mi', '2025-09-12 00:21:15', '2025-09-20 23:45:19', 'customer', '0944763697', 'Nam Định'),
(5, 'Linh', '22111060566@hunre.edu.vn', '2025-09-12 07:26:57', '$2y$12$wf9Ucr32P293o/AHUmJc.OANE3Tw0I3v5GZsfrn57J1Kx5UsPUpre', 'gX2K1qT7hemxONRMgtG3x1hT7tMX4bPL3M2eftgl5xcVxOnMiHl64H9IrNx6', '2025-09-12 00:26:31', '2025-09-12 00:26:31', 'admin', '0987654321', 'Hà Nội');

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
(338, 4, NULL, NULL, '2025-10-29 07:01:29', '2025-10-29 00:01:29', '2025-10-29 00:01:29', NULL),
(339, 4, NULL, NULL, '2025-10-29 07:01:33', '2025-10-29 00:01:33', '2025-10-29 00:01:33', NULL),
(340, 4, NULL, NULL, '2025-10-29 07:01:35', '2025-10-29 00:01:35', '2025-10-29 00:01:35', NULL),
(341, 4, NULL, NULL, '2025-10-29 07:01:38', '2025-10-29 00:01:38', '2025-10-29 00:01:38', NULL),
(342, 4, NULL, NULL, '2025-10-29 07:02:02', '2025-10-29 00:02:02', '2025-10-29 00:02:02', NULL),
(343, 4, NULL, NULL, '2025-10-29 07:02:22', '2025-10-29 00:02:22', '2025-10-29 00:02:22', NULL),
(344, 4, NULL, NULL, '2025-10-30 03:33:25', '2025-10-29 20:33:25', '2025-10-29 20:33:25', NULL),
(345, 4, NULL, NULL, '2025-10-30 03:44:13', '2025-10-29 20:44:13', '2025-10-29 20:44:13', NULL),
(346, 4, NULL, NULL, '2025-10-30 04:06:52', '2025-10-29 21:06:52', '2025-10-29 21:06:52', NULL),
(347, 4, NULL, NULL, '2025-10-30 04:07:59', '2025-10-29 21:07:59', '2025-10-29 21:07:59', NULL),
(348, 4, NULL, NULL, '2025-10-30 04:08:07', '2025-10-29 21:08:07', '2025-10-29 21:08:07', NULL),
(349, 4, NULL, NULL, '2025-10-30 04:08:37', '2025-10-29 21:08:37', '2025-10-29 21:08:37', NULL),
(350, 4, NULL, NULL, '2025-10-30 04:16:23', '2025-10-29 21:16:23', '2025-10-29 21:16:23', NULL),
(351, 4, NULL, NULL, '2025-10-30 04:17:11', '2025-10-29 21:17:11', '2025-10-29 21:17:11', NULL),
(352, 4, NULL, NULL, '2025-10-30 04:17:13', '2025-10-29 21:17:13', '2025-10-29 21:17:13', NULL),
(353, 4, NULL, NULL, '2025-10-30 04:20:04', '2025-10-29 21:20:04', '2025-10-29 21:20:04', NULL),
(354, 4, NULL, NULL, '2025-10-30 04:25:03', '2025-10-29 21:25:03', '2025-10-29 21:25:03', NULL),
(355, 4, NULL, NULL, '2025-10-30 04:27:21', '2025-10-29 21:27:21', '2025-10-29 21:27:21', NULL),
(356, 4, NULL, NULL, '2025-10-30 04:35:06', '2025-10-29 21:35:06', '2025-10-29 21:35:06', NULL),
(357, 4, NULL, NULL, '2025-10-30 04:35:17', '2025-10-29 21:35:17', '2025-10-29 21:35:17', NULL),
(358, 4, NULL, NULL, '2025-10-30 04:35:20', '2025-10-29 21:35:20', '2025-10-29 21:35:20', NULL),
(359, 4, NULL, NULL, '2025-10-30 04:41:24', '2025-10-29 21:41:24', '2025-10-29 21:41:24', NULL),
(360, 4, NULL, NULL, '2025-10-30 04:51:01', '2025-10-29 21:51:01', '2025-10-29 21:51:01', NULL),
(361, 4, NULL, NULL, '2025-10-30 05:16:37', '2025-10-29 22:16:37', '2025-10-29 22:16:37', NULL),
(362, 4, NULL, NULL, '2025-10-30 05:16:43', '2025-10-29 22:16:43', '2025-10-29 22:16:43', NULL),
(363, 4, NULL, NULL, '2025-10-30 05:16:45', '2025-10-29 22:16:45', '2025-10-29 22:16:45', NULL),
(364, 4, NULL, NULL, '2025-10-30 05:20:32', '2025-10-29 22:20:32', '2025-10-29 22:20:32', NULL),
(365, 4, NULL, NULL, '2025-10-30 05:23:43', '2025-10-29 22:23:43', '2025-10-29 22:23:43', NULL),
(366, 4, NULL, NULL, '2025-10-30 05:23:46', '2025-10-29 22:23:46', '2025-10-29 22:23:46', NULL),
(367, 4, NULL, NULL, '2025-10-30 05:23:49', '2025-10-29 22:23:49', '2025-10-29 22:23:49', NULL),
(368, 4, NULL, NULL, '2025-10-30 05:24:51', '2025-10-29 22:24:51', '2025-10-29 22:24:51', NULL),
(369, 4, NULL, NULL, '2025-10-30 05:49:58', '2025-10-29 22:49:58', '2025-10-29 22:49:58', NULL),
(370, 4, NULL, NULL, '2025-10-30 06:10:14', '2025-10-29 23:10:14', '2025-10-29 23:10:14', NULL),
(371, 4, NULL, NULL, '2025-10-30 06:25:17', '2025-10-29 23:25:17', '2025-10-29 23:25:17', NULL),
(372, 4, NULL, NULL, '2025-10-30 06:51:13', '2025-10-29 23:51:13', '2025-10-29 23:51:13', NULL),
(373, 4, NULL, NULL, '2025-10-30 06:51:46', '2025-10-29 23:51:46', '2025-10-29 23:51:46', NULL),
(374, 4, NULL, NULL, '2025-10-30 06:51:52', '2025-10-29 23:51:52', '2025-10-29 23:51:52', NULL),
(375, 4, NULL, NULL, '2025-10-30 06:51:56', '2025-10-29 23:51:56', '2025-10-29 23:51:56', NULL),
(376, 4, NULL, NULL, '2025-10-30 06:51:58', '2025-10-29 23:51:58', '2025-10-29 23:51:58', NULL),
(377, 4, NULL, NULL, '2025-10-30 06:52:03', '2025-10-29 23:52:03', '2025-10-29 23:52:03', NULL),
(378, 4, NULL, NULL, '2025-10-30 06:52:06', '2025-10-29 23:52:06', '2025-10-29 23:52:06', NULL),
(379, 4, NULL, NULL, '2025-10-30 06:52:08', '2025-10-29 23:52:08', '2025-10-29 23:52:08', NULL),
(380, 4, NULL, NULL, '2025-10-30 06:54:20', '2025-10-29 23:54:20', '2025-10-29 23:54:20', NULL),
(381, 4, NULL, NULL, '2025-10-30 06:54:28', '2025-10-29 23:54:28', '2025-10-29 23:54:28', NULL),
(382, 4, NULL, NULL, '2025-10-30 07:18:50', '2025-10-30 00:18:50', '2025-10-30 00:18:50', NULL);

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
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_messages_users` (`user_id`);

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
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=383;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
