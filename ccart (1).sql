-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2026 at 04:10 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccart`
--

-- --------------------------------------------------------

--
-- Table structure for table `cc_address`
--

CREATE TABLE `cc_address` (
  `address_id` int UNSIGNED NOT NULL,
  `customer_id` int NOT NULL,
  `firstname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_1` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int NOT NULL DEFAULT '0',
  `zone_id` int NOT NULL DEFAULT '0',
  `custom_field` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_address`
--

INSERT INTO `cc_address` (`address_id`, `customer_id`, `firstname`, `lastname`, `address_1`, `address_2`, `city`, `postcode`, `country_id`, `zone_id`, `custom_field`) VALUES
(1, 5, 'md', 'murad', 'Nowapara', 'Nowapara', NULL, '7460', 18, 323, ''),
(2, 11, 'md jubaer', 'rahman', 'fgfg', 'cv', NULL, '1687484', 1, 1, ''),
(3, 9, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', NULL, '7460', 18, 322, ''),
(4, 16, 'Jone', 'Done', 'Dhaka', 'Dhaka Mirpur', NULL, '1000', 18, 322, ''),
(5, 17, 'Jemmy', 'Carter', 'Buinkara (Driver para)', 'Dhaka Mirpur', NULL, '7460', 18, 322, '');

-- --------------------------------------------------------

--
-- Table structure for table `cc_album`
--

CREATE TABLE `cc_album` (
  `album_id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `main_image` text COLLATE utf8mb4_general_ci,
  `thumb` text COLLATE utf8mb4_general_ci,
  `alt_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort_order` int NOT NULL,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cc_album`
--

INSERT INTO `cc_album` (`album_id`, `name`, `main_image`, `thumb`, `alt_name`, `sort_order`, `createdBy`, `updatedBy`, `createdDtm`, `updatedDtm`) VALUES
(5, 'QC LV Capucines Croco press', 'uploads/manager/1773643908_d27347dea83b053b99b2.jpg', 'uploads/album/5/wm_600_pro_1968488478.jpg', '', 0, 1, NULL, '2024-11-20 18:16:57', '2026-03-16 12:52:52'),
(6, 'QC YSL Eva', 'uploads/manager/1773642404_83b9f615e2420bda680b.jpg', 'uploads/album/6/wm_600_pro_90964032.jpg', '', 0, 1, NULL, '2024-11-23 18:53:11', '2026-03-16 12:47:39'),
(11, '111111111', NULL, 'pro_1735730225_bf9af5840dcf408bd536.jpg', NULL, 0, 1, NULL, '2025-01-01 17:17:05', '2025-01-01 17:17:06'),
(12, 'Cjhfgfjyfuedrfd', NULL, 'pro_1737632758_1bda4b24571726d45020.jpg', NULL, 0, 1, NULL, '2025-01-23 17:45:58', '2025-01-23 17:46:00'),
(13, 'ttttttt', NULL, 'pro_1740981862_66c0d4095ca590ac548d.jpg', NULL, 0, 1, NULL, '2025-03-03 12:04:22', '2025-03-03 12:04:23'),
(14, 'Test 3', NULL, 'pro_1740996418_48515422e7c448123426.jpg', 'Test 3', 0, 1, NULL, '2025-03-03 16:06:58', '2025-09-17 19:28:36'),
(15, 'test', NULL, 'pro_1741516940_47dcd9af2626d7ab854e.jpg', 'test', 0, 1, NULL, '2025-03-09 16:42:20', '2025-09-16 17:48:12'),
(16, 'Cartier Necklace', 'uploads/manager/1773310476_dd8b9304cbb6f5074b33.jpg', 'uploads/album/16/wm_600_pro_750213466.jpg', 'Cartier Necklace', 0, 1, NULL, '2025-09-17 19:31:49', '2026-03-12 16:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `cc_album_details`
--

CREATE TABLE `cc_album_details` (
  `album_details_id` int UNSIGNED NOT NULL,
  `album_id` int NOT NULL,
  `main_image` text,
  `image` text,
  `alt_name` varchar(255) DEFAULT NULL,
  `sort_order` int NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cc_album_details`
--

INSERT INTO `cc_album_details` (`album_details_id`, `album_id`, `main_image`, `image`, `alt_name`, `sort_order`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(58, 11, NULL, 'pro_1735730226_e0e31380734102a19f30.jpg', NULL, 0, '2025-01-01 17:17:06', NULL, NULL, '2025-01-01 17:17:07'),
(59, 11, NULL, 'pro_1735730227_e9681fbef5f87212b30c.jpg', NULL, 0, '2025-01-01 17:17:07', NULL, NULL, '2025-01-01 17:17:08'),
(60, 11, NULL, 'pro_1735730228_a07b69e52a0c47dbeeb9.jpg', NULL, 0, '2025-01-01 17:17:08', NULL, NULL, '2025-01-01 17:17:10'),
(61, 11, NULL, 'pro_1735730230_328aeb8ded08dd1b530e.jpg', NULL, 0, '2025-01-01 17:17:10', NULL, NULL, '2025-01-01 17:17:11'),
(62, 11, NULL, 'pro_1735730231_46c5dd92ea0f77e39ad1.jpg', NULL, 0, '2025-01-01 17:17:11', NULL, NULL, '2025-01-01 17:17:12'),
(63, 11, NULL, 'pro_1735730232_9ea1abc261376291fcae.jpg', NULL, 0, '2025-01-01 17:17:12', NULL, NULL, '2025-01-01 17:17:13'),
(64, 11, NULL, 'pro_1735730233_80bd5d86fda1d644f018.jpg', NULL, 0, '2025-01-01 17:17:13', NULL, NULL, '2025-01-01 17:17:14'),
(65, 11, NULL, 'pro_1735730234_ddbaf829d0c6c36977bd.jpg', NULL, 0, '2025-01-01 17:17:14', NULL, NULL, '2025-01-01 17:17:16'),
(66, 12, NULL, 'pro_1737632760_5814275c6994dd3d6b74.jpg', NULL, 0, '2025-01-23 17:46:00', NULL, NULL, '2025-01-23 17:46:01'),
(67, 12, NULL, 'pro_1737632761_4e15755cdfbc02a49008.jpg', NULL, 0, '2025-01-23 17:46:01', NULL, NULL, '2025-01-23 17:46:03'),
(68, 12, NULL, 'pro_1737632763_e7e8874a7e3ca03af408.jpg', NULL, 0, '2025-01-23 17:46:03', NULL, NULL, '2025-01-23 17:46:04'),
(69, 12, NULL, 'pro_1737632764_ffb49e7a44e41537b18f.jpg', NULL, 0, '2025-01-23 17:46:04', NULL, NULL, '2025-01-23 17:46:06'),
(70, 12, NULL, 'pro_1737632766_d5dadf5f38facc188ae9.jpg', NULL, 0, '2025-01-23 17:46:06', NULL, NULL, '2025-01-23 17:46:08'),
(71, 12, NULL, 'pro_1737632768_dc3e0f075ea4f91955cb.jpg', NULL, 0, '2025-01-23 17:46:08', NULL, NULL, '2025-01-23 17:46:09'),
(72, 12, NULL, 'pro_1737632769_64a86c408c9e613c049d.jpg', NULL, 0, '2025-01-23 17:46:09', NULL, NULL, '2025-01-23 17:46:11'),
(73, 12, NULL, 'pro_1737632771_06e3e4d30c13b3bc3c4b.jpg', NULL, 0, '2025-01-23 17:46:11', NULL, NULL, '2025-01-23 17:46:12'),
(74, 12, NULL, 'pro_1737632772_a9d7ba99bffd005cbebc.jpg', NULL, 0, '2025-01-23 17:46:12', NULL, NULL, '2025-01-23 17:46:14'),
(75, 13, NULL, 'pro_1740981863_15f650c64a7603717c3f.jpg', NULL, 0, '2025-03-03 12:04:23', NULL, NULL, '2025-03-03 12:04:23'),
(76, 14, NULL, 'pro_1740996424_47777538fd496b9d29e0.jpg', 'Test 3', 0, '2025-03-03 16:07:04', NULL, NULL, '2025-09-17 19:28:29'),
(77, 14, NULL, 'pro_1740996430_732209c3a752188bc17a.jpg', 'Test 3', 0, '2025-03-03 16:07:10', NULL, NULL, '2025-09-17 19:28:30'),
(78, 15, NULL, 'pro_1741516947_96da2dbd24a7d7bcfe58.jpg', 'test', 0, '2025-03-09 16:42:26', NULL, NULL, '2025-09-16 17:48:06'),
(79, 15, NULL, 'pro_1741516953_da62399cab50f4a2cddf.jpg', 'test', 0, '2025-03-09 16:42:33', NULL, NULL, '2025-09-16 17:48:07'),
(80, 15, NULL, 'pro_1741516959_59b1057771eb16c76c4c.jpg', 'test', 0, '2025-03-09 16:42:39', NULL, NULL, '2025-09-16 17:48:08'),
(87, 16, 'uploads/manager/1773310485_0dd0bcde2bdbc9c837d2.jpg', 'uploads/album/16/87/wm_600_pro_654129714.jpg', 'Cartier Necklace', 0, '2026-03-12 16:38:17', NULL, NULL, '2026-03-12 16:38:17'),
(88, 16, 'uploads/manager/1773310485_1675f3beab19ffb44300.jpg', 'uploads/album/16/88/wm_600_pro_1593491673.jpg', 'Cartier Necklace', 0, '2026-03-12 16:38:17', NULL, NULL, '2026-03-12 16:38:17'),
(89, 16, 'uploads/manager/1773310485_1c83f5b10c9bddab7990.jpg', 'uploads/album/16/89/wm_600_pro_1766001035.jpg', 'Cartier Necklace', 0, '2026-03-12 16:38:17', NULL, NULL, '2026-03-12 16:38:17'),
(90, 16, 'uploads/manager/1773310485_1fd2f037837e42f737a5.jpg', 'uploads/album/16/90/wm_600_pro_393196594.jpg', 'Cartier Necklace', 0, '2026-03-12 16:38:17', NULL, NULL, '2026-03-12 16:38:18'),
(91, 16, 'uploads/manager/1773310485_3ebcf063f5fd5d269bd0.jpg', 'uploads/album/16/91/wm_600_pro_1240214147.jpg', 'Cartier Necklace', 0, '2026-03-12 16:38:18', NULL, NULL, '2026-03-12 16:38:18'),
(92, 16, 'uploads/manager/1773310485_3fccee0ed4b78f1e70c1.jpg', 'uploads/album/16/92/wm_600_pro_362294015.jpg', 'Cartier Necklace', 0, '2026-03-12 16:38:18', NULL, NULL, '2026-03-12 16:38:18'),
(93, 6, 'uploads/manager/1773641772_18eed60af59322ab23ce.jpg', 'uploads/album/6/93/wm_600_pro_2084319513.jpg', '', 0, '2026-03-16 12:18:56', NULL, NULL, '2026-03-16 12:18:57'),
(94, 6, 'uploads/manager/1773641772_ef430ded2b17f0a054a9.jpg', 'uploads/album/6/94/wm_600_pro_1140299701.jpg', '', 0, '2026-03-16 12:18:57', NULL, NULL, '2026-03-16 12:18:57'),
(95, 6, 'uploads/manager/1773641773_1ddfe5ec91df930dc649.jpg', 'uploads/album/6/95/wm_600_pro_740935925.jpg', '', 0, '2026-03-16 12:18:57', NULL, NULL, '2026-03-16 12:18:58'),
(96, 6, 'uploads/manager/1773641774_ff7fbc61cfc6acddbbb8.jpg', 'uploads/album/6/96/wm_600_pro_160978692.jpg', '', 0, '2026-03-16 12:18:58', NULL, NULL, '2026-03-16 12:18:59'),
(97, 6, 'uploads/manager/1773641775_233bab55f4ca80fd0249.jpg', 'uploads/album/6/97/wm_600_pro_583207212.jpg', '', 0, '2026-03-16 12:18:59', NULL, NULL, '2026-03-16 12:19:00'),
(98, 6, 'uploads/manager/1773641776_10a558c365802ce2a837.jpg', 'uploads/album/6/98/wm_600_pro_1962039198.jpg', '', 0, '2026-03-16 12:19:00', NULL, NULL, '2026-03-16 12:19:00'),
(99, 6, 'uploads/manager/1773641776_1cd4f960c60bb214bc0d.jpg', 'uploads/album/6/99/wm_600_pro_101717698.jpg', '', 0, '2026-03-16 12:19:00', NULL, NULL, '2026-03-16 12:19:01'),
(100, 6, 'uploads/manager/1773641776_80e40eda589c035b89b5.jpg', 'uploads/album/6/100/wm_600_pro_2132582712.jpg', '', 0, '2026-03-16 12:19:01', NULL, NULL, '2026-03-16 12:19:02'),
(101, 6, 'uploads/manager/1773641776_8b913f7bf98d7389db25.jpg', 'uploads/album/6/101/wm_600_pro_1115670638.jpg', '', 0, '2026-03-16 12:19:02', NULL, NULL, '2026-03-16 12:19:03'),
(102, 5, 'uploads/manager/1773643726_55b01599e1ff8a39d9f3.jpg', 'uploads/album/5/102/wm_600_pro_2138514565.jpg', '', 0, '2026-03-16 12:50:00', NULL, NULL, '2026-03-16 12:50:01'),
(103, 5, 'uploads/manager/1773643726_e9e4d30c391aa93cbab8.jpg', 'uploads/album/5/103/wm_600_pro_128081623.jpg', '', 0, '2026-03-16 12:50:01', NULL, NULL, '2026-03-16 12:50:02'),
(104, 5, 'uploads/manager/1773643727_ef9948c92bafa05ab67f.jpg', 'uploads/album/5/104/wm_600_pro_1001408204.jpg', '', 0, '2026-03-16 12:50:02', NULL, NULL, '2026-03-16 12:50:03'),
(105, 5, 'uploads/manager/1773643728_07acdc7975be29fdb271.jpg', 'uploads/album/5/105/wm_600_pro_423710559.jpg', '', 0, '2026-03-16 12:50:03', NULL, NULL, '2026-03-16 12:50:03'),
(106, 5, 'uploads/manager/1773643729_311d83a3d1f8cd540175.jpg', 'uploads/album/5/106/wm_600_pro_652437724.jpg', '', 0, '2026-03-16 12:50:03', NULL, NULL, '2026-03-16 12:50:04'),
(107, 5, 'uploads/manager/1773643729_5a09e27f9fdea8ec8ebd.jpg', 'uploads/album/5/107/wm_600_pro_1217910670.jpg', '', 0, '2026-03-16 12:50:04', NULL, NULL, '2026-03-16 12:50:05'),
(108, 5, 'uploads/manager/1773643729_956d2c2112f751304e98.jpg', 'uploads/album/5/108/wm_600_pro_1580704782.jpg', '', 0, '2026-03-16 12:50:05', NULL, NULL, '2026-03-16 12:50:06'),
(109, 5, 'uploads/manager/1773643729_c2f48e7a292383250230.jpg', 'uploads/album/5/109/wm_600_pro_640237291.jpg', '', 0, '2026-03-16 12:50:06', NULL, NULL, '2026-03-16 12:50:07'),
(110, 5, 'uploads/manager/1773643729_dd58ed71c84fc4ea9411.jpg', 'uploads/album/5/110/wm_600_pro_668317669.jpg', '', 0, '2026-03-16 12:50:07', NULL, NULL, '2026-03-16 12:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `cc_blog`
--

CREATE TABLE `cc_blog` (
  `blog_id` int NOT NULL,
  `blog_title` varchar(155) NOT NULL,
  `slug` text NOT NULL,
  `short_des` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `meta_title` text,
  `meta_keyword` text,
  `meta_description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `cat_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `video_id` varchar(255) DEFAULT NULL,
  `publish_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int NOT NULL,
  `updatedDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedBy` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_blog`
--

INSERT INTO `cc_blog` (`blog_id`, `blog_title`, `slug`, `short_des`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `cat_id`, `image`, `alt_name`, `video_id`, `publish_date`, `status`, `createdDtm`, `createdBy`, `updatedDtm`, `updatedBy`) VALUES
(3, 'Loft Office With Vintage Decor For Creative Working', 'loft-office-with-vintage-decor-for-creative-working', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit, tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit, quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam recusandae alias error harum maxime adipisci amet laborum. Perspiciatis minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit</p>', '', '', '', 1, 'pro_1740986286_1986b9f2a27f8012c69e.jpg', NULL, '', '2025-07-29 18:00:00', '1', '2025-03-03 13:16:36', 1, '2025-07-30 19:42:05', NULL),
(4, 'Lorem ipsum dolor sit amet consec adipis elit', 'lorem-ipsum-dolor-sit-amet-consec-adipis-elit', 'Lorem ipsum dolor sit amet consec adipis elit Lorem ipsum dolor sit amet consec adipis elit', '<p>Lorem ipsum dolor sit amet consec adipis elit</p>', '', '', '', 1, 'pro_1741578337_05118cdce725f6e07a30.jpg', NULL, 'I85afIyu0IU', '2025-07-29 18:00:00', '1', '2025-03-10 09:45:11', 1, '2025-07-30 19:41:50', NULL),
(5, 'gdfgdfgdfg dfg dfg ', 'gdfgdfgdfg-dfg-dfg-', ' f dgdgfd gdf g d dg df f dgdgfd gdf g d dg df f dgdgfd gdf g d dg df', '<p>f dgdgfd gdf g d dg df</p>', '', '', '', 1, 'pro_1742634442_185a3a3f591750c15256.png', NULL, 'I85afIyu0IU', '2025-07-29 18:00:00', '1', '2025-03-22 15:06:31', 1, '2025-07-30 19:41:36', NULL),
(6, 'A blog', 'a-blog', 'A blog is an informational website consisting of discrete, often informal diary-style text entries (posts). Posts are typically displayed in reverse chrono', '<p><span style=\"color: rgb(71, 71, 71);\" google=\"\" sans\",=\"\" arial,=\"\" sans-serif;\"=\"\">A blog is an informational website consisting of </span><span style=\"color: rgb(4, 12, 40); background-color: rgb(255, 255, 255);\" google=\"\" sans\",=\"\" arial,=\"\" sans-serif;\"=\"\">discrete, often informal diary-style text entries (posts)</span><span style=\"color: rgb(71, 71, 71);\" google=\"\" sans\",=\"\" arial,=\"\" sans-serif;\"=\"\">. Posts are typically displayed in reverse chronological order so that the most recent post appears first, at the top of the web page.</span></p>', '', '', '', 1, 'pro_1742637214_9302c48fa73e2e026573.jpg', NULL, '', '2025-07-29 18:00:00', '1', '2025-03-22 15:53:34', 1, '2025-07-30 19:41:23', NULL),
(7, 'Loft Office With Vintage Decor For Creative Working', 'loft-office-with-vintage-decor-for-creative-working', 'Loft Office With Vintage Decor For Creative Working', '<p><span style=\"background-color: rgba(0, 0, 0, 0.05);\">Loft Office With Vintage Decor For Creative Working</span></p>', '', '', '', 2, 'pro_1742811524_e6ea0bcf7ea3a1f9a4bc.png', NULL, '', '2025-07-29 18:00:00', '1', '2025-03-24 16:18:44', 1, '2025-07-30 19:41:13', NULL),
(8, 'Wider safety net to cover 10 lakh more next year', 'wider-safety-net-to-cover-10-lakh-more-next-year', 'The government will increase the number of beneficiaries of various social safety net schemes by at least 10 lakh from fiscal year (FY) 2025-2026', '<span style=\"color: rgb(71, 84, 103); font-family: \"Noto Serif JP\", serif;\">The government will increase the number of beneficiaries of various social safety net schemes by at least 10 lakh from fiscal year (FY) 2025-2026</span>', '', '', '', 4, 'pro_1742893286_19a7666bbe68e1318a6e.jpg', NULL, 'I85afIyu0IU', '2025-07-29 18:00:00', '1', '2025-03-25 14:59:20', 1, '2025-07-30 19:48:14', NULL),
(9, 'Loft Office With Vintage Decor For Creative Working', 'loft-office-with-vintage-decor-for-creative-working', 'Lorem ipsum dolor sit amet consec adipis elit', '<p><span style=\"font-family: Jost, sans-serif;\">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit, tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit, quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam recusandae alias error harum maxime adipisci amet laborum. Perspiciatis minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit</span></p>', 'Lorem ipsum dolor sit amet consec adipis elit', 'Lorem ipsum dolor sit amet consec adipis elit', 'Lorem ipsum dolor sit amet consec adipis elit', 2, 'pro_1753882125_e5d0dfd52b0924e01a8c.jpg', 'Loft Office With Vintage Decor For Creative Working', 'I85afIyu0IU', '2025-07-29 18:00:00', '1', '2025-07-30 19:28:45', 1, '2025-09-17 19:49:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cc_blog_carousel_image`
--

CREATE TABLE `cc_blog_carousel_image` (
  `blog_crassula_image_id` int NOT NULL,
  `blog_id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `alt_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cc_blog_carousel_image`
--

INSERT INTO `cc_blog_carousel_image` (`blog_crassula_image_id`, `blog_id`, `image`, `alt_name`) VALUES
(1, 8, 'pro_1752417067_5b935dabb86a1a9bb530.jpg', NULL),
(2, 8, 'pro_1752417067_66e405a50adc0b3b1bd0.jpg', NULL),
(3, 8, 'pro_1752417067_f5fed575bf359d05fb8f.jpg', NULL),
(4, 9, 'pro_1753882125_4c168f8c989e196a0ee6.jpg', 'Loft Office With Vintage Decor For Creative Working-1'),
(5, 9, 'pro_1753882125_84dc666d466c398f023f.jpg', 'Loft Office With Vintage Decor For Creative Working-2'),
(6, 9, 'pro_1753882125_4d6338aa8f4aded36b25.jpg', 'Loft Office With Vintage Decor For Creative Working-3'),
(7, 9, 'pro_1753882126_d248acd62f96d104da8d.jpg', 'Loft Office With Vintage Decor For Creative Working-4'),
(8, 9, 'pro_1753882126_ea1ad12509e1a054e585.jpg', 'Loft Office With Vintage Decor For Creative Working-5'),
(9, 7, 'pro_1753882873_950bd68f42660a1d7a76.jpg', NULL),
(10, 7, 'pro_1753882873_e4fbe2f3512693d801ff.jpg', NULL),
(11, 7, 'pro_1753882873_c8c904dfb482a851a2a2.jpg', NULL),
(12, 7, 'pro_1753882873_422c914ceec667dab790.jpg', NULL),
(13, 6, 'pro_1753882883_8590307b64956fce8074.jpg', NULL),
(14, 6, 'pro_1753882883_81ea1734886def126ce5.jpg', NULL),
(15, 6, 'pro_1753882883_988ac914446b9cbcb0fe.jpg', NULL),
(16, 6, 'pro_1753882883_0b6b1087293b9add9b9a.jpg', NULL),
(17, 5, 'pro_1753882896_427176152cb3fbb67629.jpg', NULL),
(18, 5, 'pro_1753882897_feb1c79aaadf2f19cbaf.jpg', NULL),
(19, 5, 'pro_1753882897_7e0aea260c247bb36582.jpg', NULL),
(20, 5, 'pro_1753882897_9a3a3ec5f78d09231980.jpg', NULL),
(21, 4, 'pro_1753882910_03dfa9d76b54f4bcbd96.jpg', NULL),
(22, 4, 'pro_1753882911_493e0d128acf61e9fea1.jpg', NULL),
(23, 4, 'pro_1753882911_d62513aae69328846e8c.jpg', NULL),
(24, 4, 'pro_1753882911_c8e2b28d9cdcad40f75a.jpg', NULL),
(25, 3, 'pro_1753882925_96abc7a30ccb721eea32.jpg', NULL),
(26, 3, 'pro_1753882925_a4e72bf0471d2ab3c063.jpg', NULL),
(27, 3, 'pro_1753882925_fe9d739e9b96bc13ce4d.jpg', NULL),
(28, 3, 'pro_1753882925_6b6c84b942c7d0dd83ae.jpg', NULL),
(29, 3, 'pro_1753882925_7868d2419e9927b1777e.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cc_blog_comments`
--

CREATE TABLE `cc_blog_comments` (
  `comment_id` bigint UNSIGNED NOT NULL,
  `blog_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL,
  `comment_content` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment_parent_id` int DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `cc_blog_comments`
--

INSERT INTO `cc_blog_comments` (`comment_id`, `blog_id`, `comment_author`, `comment_author_email`, `comment_author_IP`, `comment_date`, `comment_content`, `comment_approved`, `comment_parent_id`, `customer_id`) VALUES
(1, 3, 'Murad', 'murad@gmail.com', '192.168.0.110', '2025-07-13 08:48:54', 'dfsfsdf', '1', NULL, NULL),
(2, 3, 'sdfsdfsdfds', 'dfghgfhfg@maul', '192.168.0.137', '2025-07-13 08:49:04', 'fgdfgdfgdfsggdf', '1', NULL, NULL),
(3, 3, 'admin', 'gpgfh@gmail.com', '192.168.0.110', '2025-07-13 08:49:07', 'Thanks', '1', 1, NULL),
(4, 3, 'dfgdfg', 'fdgfdghdf', '192.168.0.137', '2025-07-13 08:50:20', 'fdgfdgdfg', '1', 1, NULL),
(5, 3, 'admin', 'sdfsdf', '192.168.0.137', '2025-07-13 08:50:35', 'dfgfdgdfg', '1', 1, NULL),
(6, 8, 'dfgdfgfdgdfg', 'admin@gmail.com', '192.168.0.137', '2025-07-13 09:10:45', 'tdfgfhfgfuyf', '1', NULL, NULL),
(7, 8, 'dfgdfgfdgdfg', 'admin@gmail.com', '192.168.0.137', '2025-07-13 09:11:03', 'tdfgfhfgfuyf', '1', NULL, NULL),
(8, 8, 'dfgdfgfdgdfg', 'admin@gmail.com', '192.168.0.137', '2025-07-13 09:11:08', 'tdfgfhfgfuyf', '1', NULL, NULL),
(9, 8, 'dfgdfgfdgdfg', 'admin@gmail.com', '192.168.0.137', '2025-07-13 09:11:14', 'tdfgfhfgfuyf', '1', NULL, NULL),
(10, 8, 'dfgdfgfdgdfg', 'admin@gmail.com', '192.168.0.137', '2025-07-13 09:11:21', 'tdfgfhfgfuyf', '1', NULL, NULL),
(11, 6, 'murad', 'admin@gmail.com', '192.168.0.110', '2025-07-13 09:13:00', 'fsfsafas', '1', NULL, NULL),
(12, 6, 'murad', 'admin@gmail.com', '192.168.0.110', '2025-07-13 09:13:05', 'fsfsafas', '1', NULL, NULL),
(13, 6, 'asdasd', 'gp@gmail.com', '192.168.0.110', '2025-07-13 09:13:16', 'sdsd', '1', 11, NULL),
(14, 8, 'dfgdfgfdgdfg', 'admin@gmail.com', '192.168.0.137', '2025-07-13 09:13:24', 'tdfgfhfgfuyf', '1', NULL, NULL),
(15, 6, 'dsd', 'gpasf@gmail.com', '192.168.0.110', '2025-07-13 09:13:27', 'sdsds', '1', 12, NULL),
(16, 8, 'dfgdfgfdgdfg', 'admin@gmail.com', '192.168.0.137', '2025-07-13 09:13:27', 'tdfgfhfgfuyf', '1', NULL, NULL),
(17, 6, 'murad', 'murad@gmail.com', '192.168.0.110', '2025-07-13 09:13:40', 'ewrer', '1', NULL, NULL),
(18, 8, 'GP', 'gp@gmail.com', '192.168.0.110', '2025-07-13 09:34:44', 'Thanks', '1', 6, NULL),
(19, 8, 'dfgdfgdf', 'sdfdsfds@', '192.168.0.107', '2025-07-28 00:38:44', '12345678', '1', 6, NULL),
(20, 3, 'ghfghhfgjhg', 'admin@gmail.com', '192.168.0.107', '2025-09-24 08:57:57', 'hgfghhhfhfghgfhfghgdhgfdetrysytytyrtyyyyfddfgdfgdf', '1', NULL, NULL),
(21, 3, 'asdasd', 'gpasf@gmail.com', '192.168.0.110', '2025-09-28 05:33:26', 'Thanks', '1', 1, NULL),
(22, 3, 'GPh', 'gp@gmail.com', '192.168.0.110', '2025-09-28 05:33:42', 'mm', '1', 1, NULL),
(23, 4, 'murad', 'admin@gmail.com', '192.168.0.110', '2025-12-22 22:23:52', 'dfhgffdh dfh dh dhffd hdh', '1', NULL, NULL),
(24, 4, 'GP', 'admin@gmail.com', '192.168.0.110', '2025-12-22 22:24:03', 'Thanks', '1', 23, NULL),
(25, 7, 'murad', 'admin@gmail.com', '192.168.0.110', '2025-12-22 23:02:15', 'sfsdfsdf sdf sdf s', '1', NULL, NULL),
(26, 7, 'GP', 'admin@gmail.com', '192.168.0.110', '2025-12-22 23:02:36', 'Thanks', '1', 25, NULL),
(27, 6, 'dfdsfdsf', 'jemmy@gmail.com', '192.168.0.107', '2025-12-31 00:13:29', 'Thank you!!', '1', 17, NULL),
(28, 3, 'Khan', 'khansk@gmail.com', '192.168.0.107', '2026-03-15 05:20:45', 'Nice', '1', NULL, NULL),
(29, 3, 'Jemmy', 'khansk@gmail.com', '192.168.0.107', '2026-03-15 05:20:57', 'fghgfhf', '1', 28, NULL),
(30, 3, 'dfdsfdsf', 'khansk@gmail.com', '192.168.0.107', '2026-03-15 05:21:11', 'Thank you!!', '1', 28, NULL),
(31, 5, 'Khan', 'khansk@gmail.com', '192.168.0.107', '2026-03-16 01:58:20', 'nice', '1', NULL, NULL),
(32, 5, 'Jemmy', 'khansk@gmail.com', '192.168.0.107', '2026-03-16 01:58:31', 'Thank you!!', '1', 31, NULL),
(33, 5, 'dfdsfdsf', 'khansk@gmail.com', '192.168.0.107', '2026-03-16 01:58:51', 'WELCOME', '1', 31, NULL),
(34, 3, 'dfdsfdsf', 'khansk@gmail.com', '192.168.0.107', '2026-04-02 05:53:09', 'Thank you!!', '1', 2, NULL),
(35, 9, 'Khan', 'khansk@gmail.com', '192.168.0.107', '2026-04-02 07:19:43', 'yuyuuhtytufuyugiiyi', '1', NULL, NULL),
(36, 9, 'Jemmy', 'khansk@gmail.com', '192.168.0.107', '2026-04-02 07:19:54', 'Thank you!!', '1', 35, NULL),
(37, 8, 'Jemmy', 'khansk@gmail.com', '192.168.0.107', '2026-04-09 01:42:34', 'Thank you!!', '1', 16, NULL),
(38, 3, 'IFIC', 'khansk@gmail.com', '192.168.0.107', '2026-05-03 06:40:02', 'Nice', '1', NULL, NULL),
(39, 3, 'dfdsfdsf', 'khansk@gmail.com', '192.168.0.107', '2026-05-03 06:40:23', 'Thank you!!', '1', 38, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cc_brand`
--

CREATE TABLE `cc_brand` (
  `brand_id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `sort_order` int NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_brand`
--

INSERT INTO `cc_brand` (`brand_id`, `name`, `image`, `alt_name`, `status`, `sort_order`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 'APM MONACO', 'brand_1696228253_e95c3e9868cea28689d4.jpg', NULL, 'Active', 0, '2023-09-05 11:38:05', 1, 1, '2025-07-30 13:10:11'),
(2, 'BALENCIAGA', 'brand_1696228241_d608e9f85a207b1cf019.png', NULL, 'Active', 0, '2023-09-05 11:38:13', 1, 1, '2025-07-28 19:29:22'),
(3, 'BALLY', 'brand_1696228218_c6ff1862161637985521.jpg', NULL, 'Active', 0, '2023-09-05 11:38:22', 1, 1, '2023-10-02 12:30:18'),
(4, 'BALMAIN', 'brand_1696228204_6d735e5377063fe1f41d.png', NULL, 'Active', 0, '2023-09-05 11:38:30', 1, 1, '2023-10-02 12:30:04'),
(5, 'CARTIER', 'brand_1732104887_350ac15aa60557e2de7a.png', NULL, 'Active', 0, '2023-09-05 11:38:38', 1, 1, '2024-11-20 18:14:47'),
(6, 'CHAUMET', 'brand_1696228178_3be026d66e58bb47fe2b.jpg', NULL, 'Active', 0, '2023-09-05 11:38:46', 1, 1, '2023-10-02 12:29:38'),
(7, 'FENDI', 'brand_1696228164_b3432e3302fcadb34e00.jpg', NULL, 'Active', 0, '2023-09-05 11:38:56', 1, 1, '2025-07-26 20:19:27'),
(8, 'GUCCI', 'brand_1696228150_ee0b65fb3415fb2a375a.png', NULL, 'Active', 0, '2023-09-05 11:39:05', 1, 1, '2023-10-02 12:29:10'),
(9, 'DELVAUX', 'brand_1696228136_177d105b1a009e9128ac.jpg', NULL, 'Active', 0, '2023-09-05 16:21:43', 1, 1, '2023-10-02 12:28:56'),
(10, 'CHANEL', 'brand_1696228117_45b1e9f3f957d80706f3.jpg', NULL, 'Active', 0, '2023-09-05 16:21:50', 1, 1, '2025-07-30 16:35:21'),
(12, 'FRED', 'brand_1696228107_de70f5dd9ba5ba79210a.png', NULL, 'Active', 0, '2023-09-05 16:22:04', 1, 1, '2023-10-02 12:28:27'),
(13, 'Louis Vuitton', 'brand_1696228075_a5837e2faf086f870d84.png', NULL, 'Active', 0, '2023-10-01 19:23:25', 1, 1, '2025-07-30 13:12:05'),
(20, 'Hermes', NULL, 'Hermes', 'Active', 0, '2026-05-04 16:34:27', 1, NULL, '2026-05-04 16:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `cc_category`
--

CREATE TABLE `cc_category` (
  `cat_id` int UNSIGNED NOT NULL,
  `parent_id` int DEFAULT NULL,
  `category_name` varchar(155) NOT NULL,
  `description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `icon_id` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `header_menu` enum('1','0') NOT NULL DEFAULT '0',
  `side_menu` enum('1','0') NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cc_category`
--

INSERT INTO `cc_category` (`cat_id`, `parent_id`, `category_name`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `icon_id`, `image`, `alt_name`, `header_menu`, `side_menu`, `sort_order`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, '', '0', '0', 0, '1', '2025-03-03 12:29:49', 1, NULL, '2025-03-03 12:29:49'),
(2, NULL, 'test_2', NULL, NULL, NULL, NULL, NULL, NULL, '', '0', '0', 0, '1', '2025-03-24 16:18:18', 1, NULL, '2025-03-24 16:18:18'),
(4, NULL, 'Chanel', NULL, NULL, NULL, NULL, NULL, NULL, '', '0', '0', 0, '1', '2025-07-30 19:45:59', 1, NULL, '2025-07-30 19:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `cc_country`
--

CREATE TABLE `cc_country` (
  `country_id` int UNSIGNED NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code_2` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code_3` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_format` mediumtext COLLATE utf8mb4_unicode_ci,
  `postcode_required` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_country`
--

INSERT INTO `cc_country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `postcode_required`, `status`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 0, 1),
(2, 'Albania', 'AL', 'ALB', '', 0, 1),
(3, 'Algeria', 'DZ', 'DZA', '', 0, 1),
(4, 'American Samoa', 'AS', 'ASM', '', 0, 1),
(5, 'Andorra', 'AD', 'AND', '', 0, 1),
(6, 'Angola', 'AO', 'AGO', '', 0, 1),
(7, 'Anguilla', 'AI', 'AIA', '', 0, 1),
(8, 'Antarctica', 'AQ', 'ATA', '', 0, 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 0, 1),
(10, 'Argentina', 'AR', 'ARG', '', 0, 1),
(11, 'Armenia', 'AM', 'ARM', '', 0, 1),
(12, 'Aruba', 'AW', 'ABW', '', 0, 1),
(13, 'Australia', 'AU', 'AUS', '', 0, 1),
(14, 'Austria', 'AT', 'AUT', '', 0, 1),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 0, 1),
(16, 'Bahamas', 'BS', 'BHS', '', 0, 1),
(17, 'Bahrain', 'BH', 'BHR', '', 0, 1),
(18, 'Bangladesh', 'BD', 'BGD', '', 0, 1),
(19, 'Barbados', 'BB', 'BRB', '', 0, 1),
(20, 'Belarus', 'BY', 'BLR', '', 0, 1),
(21, 'Belgium', 'BE', 'BEL', '', 0, 1),
(22, 'Belize', 'BZ', 'BLZ', '', 0, 1),
(23, 'Benin', 'BJ', 'BEN', '', 0, 1),
(24, 'Bermuda', 'BM', 'BMU', '', 0, 1),
(25, 'Bhutan', 'BT', 'BTN', '', 0, 1),
(26, 'Bolivia', 'BO', 'BOL', '', 0, 1),
(27, 'Bosnia and Herzegovina', 'BA', 'BIH', '', 0, 1),
(28, 'Botswana', 'BW', 'BWA', '', 0, 1),
(29, 'Bouvet Island', 'BV', 'BVT', '', 0, 1),
(30, 'Brazil', 'BR', 'BRA', '', 0, 1),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 0, 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 0, 1),
(33, 'Bulgaria', 'BG', 'BGR', '', 0, 1),
(34, 'Burkina Faso', 'BF', 'BFA', '', 0, 1),
(35, 'Burundi', 'BI', 'BDI', '', 0, 1),
(36, 'Cambodia', 'KH', 'KHM', '', 0, 1),
(37, 'Cameroon', 'CM', 'CMR', '', 0, 1),
(38, 'Canada', 'CA', 'CAN', '', 0, 1),
(39, 'Cape Verde', 'CV', 'CPV', '', 0, 1),
(40, 'Cayman Islands', 'KY', 'CYM', '', 0, 1),
(41, 'Central African Republic', 'CF', 'CAF', '', 0, 1),
(42, 'Chad', 'TD', 'TCD', '', 0, 1),
(43, 'Chile', 'CL', 'CHL', '', 0, 1),
(44, 'China', 'CN', 'CHN', '', 0, 1),
(45, 'Christmas Island', 'CX', 'CXR', '', 0, 1),
(46, 'Cocos Islands', 'CC', 'CCK', '', 0, 1),
(47, 'Colombia', 'CO', 'COL', '', 0, 1),
(48, 'Comoros', 'KM', 'COM', '', 0, 1),
(49, 'Congo', 'CG', 'COG', '', 0, 1),
(50, 'Cook Islands', 'CK', 'COK', '', 0, 1),
(51, 'Costa Rica', 'CR', 'CRI', '', 0, 1),
(52, 'Cote D\'Ivoire', 'CI', 'CIV', '', 0, 1),
(53, 'Croatia', 'HR', 'HRV', '', 0, 1),
(54, 'Cuba', 'CU', 'CUB', '', 0, 1),
(55, 'Cyprus', 'CY', 'CYP', '', 0, 1),
(56, 'Czech Republic', 'CZ', 'CZE', '', 0, 1),
(57, 'Denmark', 'DK', 'DNK', '', 0, 1),
(58, 'Djibouti', 'DJ', 'DJI', '', 0, 1),
(59, 'Dominica', 'DM', 'DMA', '', 0, 1),
(60, 'Dominican Republic', 'DO', 'DOM', '', 0, 1),
(61, 'East Timor', 'TL', 'TLS', '', 0, 1),
(62, 'Ecuador', 'EC', 'ECU', '', 0, 1),
(63, 'Egypt', 'EG', 'EGY', '', 0, 1),
(64, 'El Salvador', 'SV', 'SLV', '', 0, 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 0, 1),
(66, 'Eritrea', 'ER', 'ERI', '', 0, 1),
(67, 'Estonia', 'EE', 'EST', '', 0, 1),
(68, 'Ethiopia', 'ET', 'ETH', '', 0, 1),
(69, 'Falkland Islands', 'FK', 'FLK', '', 0, 1),
(70, 'Faroe Islands', 'FO', 'FRO', '', 0, 1),
(71, 'Fiji', 'FJ', 'FJI', '', 0, 1),
(72, 'Finland', 'FI', 'FIN', '', 0, 1),
(74, 'France, Metropolitan', 'FR', 'FRA', '', 1, 1),
(75, 'French Guiana', 'GF', 'GUF', '', 0, 1),
(76, 'French Polynesia', 'PF', 'PYF', '', 0, 1),
(77, 'French Southern Territories', 'TF', 'ATF', '', 0, 1),
(78, 'Gabon', 'GA', 'GAB', '', 0, 1),
(79, 'Gambia', 'GM', 'GMB', '', 0, 1),
(80, 'Georgia', 'GE', 'GEO', '', 0, 1),
(81, 'Germany', 'DE', 'DEU', '', 1, 1),
(82, 'Ghana', 'GH', 'GHA', '', 0, 1),
(83, 'Gibraltar', 'GI', 'GIB', '', 0, 1),
(84, 'Greece', 'GR', 'GRC', '', 0, 1),
(85, 'Greenland', 'GL', 'GRL', '', 0, 1),
(86, 'Grenada', 'GD', 'GRD', '', 0, 1),
(87, 'Guadeloupe', 'GP', 'GLP', '', 0, 1),
(88, 'Guam', 'GU', 'GUM', '', 0, 1),
(89, 'Guatemala', 'GT', 'GTM', '', 0, 1),
(90, 'Guinea', 'GN', 'GIN', '', 0, 1),
(91, 'Guinea-Bissau', 'GW', 'GNB', '', 0, 1),
(92, 'Guyana', 'GY', 'GUY', '', 0, 1),
(93, 'Haiti', 'HT', 'HTI', '', 0, 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', '', 0, 1),
(95, 'Honduras', 'HN', 'HND', '', 0, 1),
(96, 'Hong Kong', 'HK', 'HKG', '', 0, 1),
(97, 'Hungary', 'HU', 'HUN', '', 0, 1),
(98, 'Iceland', 'IS', 'ISL', '', 0, 1),
(99, 'India', 'IN', 'IND', '', 0, 1),
(100, 'Indonesia', 'ID', 'IDN', '', 0, 1),
(101, 'Iran', 'IR', 'IRN', '', 0, 1),
(102, 'Iraq', 'IQ', 'IRQ', '', 0, 1),
(103, 'Ireland', 'IE', 'IRL', '', 0, 1),
(104, 'Israel', 'IL', 'ISR', '', 0, 1),
(105, 'Italy', 'IT', 'ITA', '', 0, 1),
(106, 'Jamaica', 'JM', 'JAM', '', 0, 1),
(107, 'Japan', 'JP', 'JPN', '', 0, 1),
(108, 'Jordan', 'JO', 'JOR', '', 0, 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 0, 1),
(110, 'Kenya', 'KE', 'KEN', '', 0, 1),
(111, 'Kiribati', 'KI', 'KIR', '', 0, 1),
(112, 'North Korea', 'KP', 'PRK', '', 0, 1),
(113, 'South Korea', 'KR', 'KOR', '', 0, 1),
(114, 'Kuwait', 'KW', 'KWT', '', 0, 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 0, 1),
(116, 'Lao People\'s Democratic Republic', 'LA', 'LAO', '', 0, 1),
(117, 'Latvia', 'LV', 'LVA', '', 0, 1),
(118, 'Lebanon', 'LB', 'LBN', '', 0, 1),
(119, 'Lesotho', 'LS', 'LSO', '', 0, 1),
(120, 'Liberia', 'LR', 'LBR', '', 0, 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 0, 1),
(122, 'Liechtenstein', 'LI', 'LIE', '', 0, 1),
(123, 'Lithuania', 'LT', 'LTU', '', 0, 1),
(124, 'Luxembourg', 'LU', 'LUX', '', 0, 1),
(125, 'Macau', 'MO', 'MAC', '', 0, 1),
(126, 'FYROM', 'MK', 'MKD', '', 0, 1),
(127, 'Madagascar', 'MG', 'MDG', '', 0, 1),
(128, 'Malawi', 'MW', 'MWI', '', 0, 1),
(129, 'Malaysia', 'MY', 'MYS', '', 0, 1),
(130, 'Maldives', 'MV', 'MDV', '', 0, 1),
(131, 'Mali', 'ML', 'MLI', '', 0, 1),
(132, 'Malta', 'MT', 'MLT', '', 0, 1),
(133, 'Marshall Islands', 'MH', 'MHL', '', 0, 1),
(134, 'Martinique', 'MQ', 'MTQ', '', 0, 1),
(135, 'Mauritania', 'MR', 'MRT', '', 0, 1),
(136, 'Mauritius', 'MU', 'MUS', '', 0, 1),
(137, 'Mayotte', 'YT', 'MYT', '', 0, 1),
(138, 'Mexico', 'MX', 'MEX', '', 0, 1),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', '', 0, 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', '', 0, 1),
(141, 'Monaco', 'MC', 'MCO', '', 0, 1),
(142, 'Mongolia', 'MN', 'MNG', '', 0, 1),
(143, 'Montserrat', 'MS', 'MSR', '', 0, 1),
(144, 'Morocco', 'MA', 'MAR', '', 0, 1),
(145, 'Mozambique', 'MZ', 'MOZ', '', 0, 1),
(146, 'Myanmar', 'MM', 'MMR', '', 0, 1),
(147, 'Namibia', 'NA', 'NAM', '', 0, 1),
(148, 'Nauru', 'NR', 'NRU', '', 0, 1),
(149, 'Nepal', 'NP', 'NPL', '', 0, 1),
(150, 'Netherlands', 'NL', 'NLD', '', 0, 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', '', 0, 1),
(152, 'New Caledonia', 'NC', 'NCL', '', 0, 1),
(153, 'New Zealand', 'NZ', 'NZL', '', 0, 1),
(154, 'Nicaragua', 'NI', 'NIC', '', 0, 1),
(155, 'Niger', 'NE', 'NER', '', 0, 1),
(156, 'Nigeria', 'NG', 'NGA', '', 0, 1),
(157, 'Niue', 'NU', 'NIU', '', 0, 1),
(158, 'Norfolk Island', 'NF', 'NFK', '', 0, 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 0, 1),
(160, 'Norway', 'NO', 'NOR', '', 0, 1),
(161, 'Oman', 'OM', 'OMN', '', 0, 1),
(162, 'Pakistan', 'PK', 'PAK', '', 0, 1),
(163, 'Palau', 'PW', 'PLW', '', 0, 1),
(164, 'Panama', 'PA', 'PAN', '', 0, 1),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 0, 1),
(166, 'Paraguay', 'PY', 'PRY', '', 0, 1),
(167, 'Peru', 'PE', 'PER', '', 0, 1),
(168, 'Philippines', 'PH', 'PHL', '', 0, 1),
(169, 'Pitcairn', 'PN', 'PCN', '', 0, 1),
(170, 'Poland', 'PL', 'POL', '', 0, 1),
(171, 'Portugal', 'PT', 'PRT', '', 0, 1),
(172, 'Puerto Rico', 'PR', 'PRI', '', 0, 1),
(173, 'Qatar', 'QA', 'QAT', '', 0, 1),
(174, 'Reunion', 'RE', 'REU', '', 0, 1),
(175, 'Romania', 'RO', 'ROM', '', 0, 1),
(176, 'Russian Federation', 'RU', 'RUS', '', 0, 1),
(177, 'Rwanda', 'RW', 'RWA', '', 0, 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 0, 1),
(179, 'Saint Lucia', 'LC', 'LCA', '', 0, 1),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 0, 1),
(181, 'Samoa', 'WS', 'WSM', '', 0, 1),
(182, 'San Marino', 'SM', 'SMR', '', 0, 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 0, 1),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 0, 1),
(185, 'Senegal', 'SN', 'SEN', '', 0, 1),
(186, 'Seychelles', 'SC', 'SYC', '', 0, 1),
(187, 'Sierra Leone', 'SL', 'SLE', '', 0, 1),
(188, 'Singapore', 'SG', 'SGP', '', 0, 1),
(189, 'Slovak Republic', 'SK', 'SVK', '', 0, 1),
(190, 'Slovenia', 'SI', 'SVN', '', 0, 1),
(191, 'Solomon Islands', 'SB', 'SLB', '', 0, 1),
(192, 'Somalia', 'SO', 'SOM', '', 0, 1),
(193, 'South Africa', 'ZA', 'ZAF', '', 0, 1),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', 0, 1),
(195, 'Spain', 'ES', 'ESP', '', 0, 1),
(196, 'Sri Lanka', 'LK', 'LKA', '', 0, 1),
(197, 'St. Helena', 'SH', 'SHN', '', 0, 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 0, 1),
(199, 'Sudan', 'SD', 'SDN', '', 0, 1),
(200, 'Suriname', 'SR', 'SUR', '', 0, 1),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 0, 1),
(202, 'Swaziland', 'SZ', 'SWZ', '', 0, 1),
(203, 'Sweden', 'SE', 'SWE', '', 1, 1),
(204, 'Switzerland', 'CH', 'CHE', '', 0, 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 0, 1),
(206, 'Taiwan', 'TW', 'TWN', '', 0, 1),
(207, 'Tajikistan', 'TJ', 'TJK', '', 0, 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', '', 0, 1),
(209, 'Thailand', 'TH', 'THA', '', 0, 1),
(210, 'Togo', 'TG', 'TGO', '', 0, 1),
(211, 'Tokelau', 'TK', 'TKL', '', 0, 1),
(212, 'Tonga', 'TO', 'TON', '', 0, 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 0, 1),
(214, 'Tunisia', 'TN', 'TUN', '', 0, 1),
(215, 'Turkey', 'TR', 'TUR', '', 0, 1),
(216, 'Turkmenistan', 'TM', 'TKM', '', 0, 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 0, 1),
(218, 'Tuvalu', 'TV', 'TUV', '', 0, 1),
(219, 'Uganda', 'UG', 'UGA', '', 0, 1),
(220, 'Ukraine', 'UA', 'UKR', '', 0, 1),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 0, 1),
(222, 'United Kingdom', 'GB', 'GBR', '', 1, 1),
(223, 'United States', 'US', 'USA', '', 0, 1),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 0, 1),
(225, 'Uruguay', 'UY', 'URY', '', 0, 1),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 0, 1),
(227, 'Vanuatu', 'VU', 'VUT', '', 0, 1),
(228, 'Vatican City State', 'VA', 'VAT', '', 0, 1),
(229, 'Venezuela', 'VE', 'VEN', '', 0, 1),
(230, 'Viet Nam', 'VN', 'VNM', '', 0, 1),
(231, 'Virgin Islands', 'VG', 'VGB', '', 0, 1),
(232, 'Virgin Islands', 'VI', 'VIR', '', 0, 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 0, 1),
(234, 'Western Sahara', 'EH', 'ESH', '', 0, 1),
(235, 'Yemen', 'YE', 'YEM', '', 0, 1),
(237, 'Democratic Republic of Congo', 'CD', 'COD', '', 0, 1),
(238, 'Zambia', 'ZM', 'ZMB', '', 0, 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 0, 1),
(242, 'Montenegro', 'ME', 'MNE', '', 0, 1),
(243, 'Serbia', 'RS', 'SRB', '', 0, 1),
(244, 'Aaland Islands', 'AX', 'ALA', '', 0, 1),
(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', '', 0, 1),
(246, 'Curacao', 'CW', 'CUW', '', 0, 1),
(247, 'Palestinian Territory, Occupied', 'PS', 'PSE', '', 0, 1),
(248, 'South Sudan', 'SS', 'SSD', '', 0, 1),
(249, 'St. Barthelemy', 'BL', 'BLM', '', 0, 1),
(250, 'St. Martin', 'MF', 'MAF', '', 0, 1),
(251, 'Canary Islands', 'IC', 'ICA', '', 0, 1),
(252, 'Ascension Island', 'AC', 'ASC', '', 0, 1),
(253, 'Kosovo, Republic of', 'XK', 'UNK', '', 0, 1),
(254, 'Isle of Man', 'IM', 'IMN', '', 0, 1),
(255, 'Tristan da Cunha', 'TA', 'SHN', '', 0, 1),
(256, 'Guernsey', 'GG', 'GGY', '', 0, 1),
(257, 'Jersey', 'JE', 'JEY', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cc_coupon`
--

CREATE TABLE `cc_coupon` (
  `coupon_id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` enum('Percentage','Flat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Percentage',
  `discount_on` enum('Product','Shipping') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Product',
  `discount` decimal(7,5) NOT NULL,
  `for_subscribed_user` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `for_registered_user` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `total_useable` int DEFAULT NULL,
  `total_used` int DEFAULT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_coupon`
--

INSERT INTO `cc_coupon` (`coupon_id`, `name`, `code`, `discount_type`, `discount_on`, `discount`, `for_subscribed_user`, `for_registered_user`, `total_useable`, `total_used`, `date_start`, `date_end`, `status`) VALUES
(5, 'shipping', 'shipping', 'Percentage', 'Shipping', 20.00000, '0', '0', 100, 3, '2025-03-01', '2029-12-31', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `cc_coupon_category`
--

CREATE TABLE `cc_coupon_category` (
  `coupon_category_id` int UNSIGNED NOT NULL,
  `coupon_id` int NOT NULL,
  `prod_cat_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cc_coupon_history`
--

CREATE TABLE `cc_coupon_history` (
  `coupon_history_id` int UNSIGNED NOT NULL,
  `coupon_id` int NOT NULL,
  `order_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cc_coupon_product`
--

CREATE TABLE `cc_coupon_product` (
  `coupon_product_id` int UNSIGNED NOT NULL,
  `coupon_id` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cc_coupon_shipping`
--

CREATE TABLE `cc_coupon_shipping` (
  `coupon_shipping_id` int UNSIGNED NOT NULL,
  `coupon_id` int NOT NULL,
  `shipping_method_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_coupon_shipping`
--

INSERT INTO `cc_coupon_shipping` (`coupon_shipping_id`, `coupon_id`, `shipping_method_id`) VALUES
(60, 5, 1),
(61, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `cc_customer`
--

CREATE TABLE `cc_customer` (
  `customer_id` int UNSIGNED NOT NULL,
  `firstname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(96) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` double DEFAULT NULL,
  `point` int UNSIGNED DEFAULT NULL,
  `salt` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wishlist` mediumtext COLLATE utf8mb4_unicode_ci,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `address_id` int NOT NULL DEFAULT '0',
  `ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_customer`
--

INSERT INTO `cc_customer` (`customer_id`, `firstname`, `lastname`, `email`, `phone`, `password`, `balance`, `point`, `salt`, `wishlist`, `newsletter`, `address_id`, `ip`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(2, 'Syed', 'Wick', 'admin@gmail.com', '01963221186', 'b076040ecfeff67c6158436b93e01e24dc214938', NULL, NULL, '', NULL, 0, 0, '', 1, '2023-05-31 20:13:49', NULL, 1, '2025-01-26 18:39:11'),
(4, 'sumon', 'khan', 'khan@gmail.com', '01929649440', '7c222fb2927d828af22f592134e8932480637c0d', NULL, NULL, '', NULL, 1, 0, '', 1, '2023-06-01 20:15:13', 1, NULL, '2023-06-01 20:17:53'),
(5, 'md', 'murad', 'murad@gmail.com', '01923171718', '7c222fb2927d828af22f592134e8932480637c0d', 2025, 1203, '', NULL, 1, 0, '', 1, '2023-07-10 09:50:24', NULL, NULL, '2025-07-23 12:25:41'),
(6, 'Syed Imran', 'Ertaza', 'imran@gmail.com', '01924329315', '7c222fb2927d828af22f592134e8932480637c0d', NULL, NULL, '', NULL, 0, 0, '', 1, '2023-07-10 20:35:28', NULL, NULL, '2023-07-10 20:35:28'),
(7, 'adsad', 'asdsad', 'sdfds@gmail.com', '01989898989', '7c222fb2927d828af22f592134e8932480637c0d', NULL, NULL, '', NULL, 0, 0, '', 1, '2023-07-23 11:51:09', NULL, NULL, '2023-07-23 11:51:09'),
(8, 'MD.', 'ISLAM', 'sumon1@gmail.com', '01744445444', '7c222fb2927d828af22f592134e8932480637c0d', NULL, NULL, '', NULL, 0, 0, '', 1, '2023-10-02 19:04:52', NULL, NULL, '2023-10-02 19:04:52'),
(9, 'MD. TARIQUL ISLAM', 'ISLAM', 'dnationsoftbd5@gmail.com', '01714070771', '7c222fb2927d828af22f592134e8932480637c0d', 8200, 1172, '', NULL, 0, 0, '', 1, '2023-11-29 18:49:16', NULL, NULL, '2026-05-03 16:49:31'),
(10, 'md jubaer', 'rahman', 'dnationsoftdm07@gmail.com', '012373165333', '7c222fb2927d828af22f592134e8932480637c0d', NULL, NULL, '', NULL, 0, 0, '', 1, '2023-12-19 10:15:51', NULL, NULL, '2023-12-19 10:15:51'),
(16, 'Jone', 'Done', 'jone@gmail.com', '01744445422', '7c222fb2927d828af22f592134e8932480637c0d', NULL, 425, '', NULL, 0, 0, '', 1, '2025-03-03 15:59:56', NULL, NULL, '2025-03-03 16:35:17'),
(17, 'Jemmy', 'Carter', 'carter@gmail.com', '01714070711', '7c222fb2927d828af22f592134e8932480637c0d', NULL, 275, '', NULL, 0, 0, '', 1, '2025-03-10 14:59:01', NULL, NULL, '2025-03-10 15:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `cc_customer_ledger`
--

CREATE TABLE `cc_customer_ledger` (
  `ledg_id` int UNSIGNED NOT NULL,
  `customer_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `fund_request_id` int DEFAULT NULL,
  `payment_method_id` int DEFAULT NULL,
  `particulars` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangaction_type` enum('Dr.','Cr.') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cr.',
  `amount` double UNSIGNED NOT NULL,
  `rest_balance` double NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_customer_ledger`
--

INSERT INTO `cc_customer_ledger` (`ledg_id`, `customer_id`, `order_id`, `fund_request_id`, `payment_method_id`, `particulars`, `trangaction_type`, `amount`, `rest_balance`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 9, NULL, 4, 2, 'Deposit balance', 'Cr.', 1000, 6000, '2023-12-04 18:00:43', NULL, NULL, '2023-12-04 18:00:43'),
(2, 9, NULL, 5, 2, 'Deposit balance', 'Cr.', 1000, 7000, '2024-06-30 20:18:46', NULL, NULL, '2024-06-30 20:18:46'),
(3, 9, 30, NULL, 8, 'Product purchase', 'Dr.', 30, 6970, '2024-06-30 20:33:34', NULL, NULL, '2024-06-30 20:33:34'),
(4, 5, NULL, 6, 9, 'Deposit balance', 'Cr.', 200, 735, '2025-01-07 16:49:56', NULL, NULL, '2025-01-07 16:49:56'),
(5, 5, NULL, 7, 10, 'Deposit balance', 'Cr.', 300, 1035, '2025-01-07 16:53:43', NULL, NULL, '2025-01-07 16:53:43'),
(6, 9, NULL, 8, 9, 'Deposit balance', 'Cr.', 500, 7470, '2025-01-07 18:13:00', NULL, NULL, '2025-01-07 18:13:00'),
(7, 9, NULL, 9, 10, 'Deposit balance', 'Cr.', 30, 7500, '2025-01-07 18:14:58', NULL, NULL, '2025-01-07 18:14:58'),
(8, 9, NULL, 10, 9, 'Deposit balance', 'Cr.', 50, 7550, '2025-01-08 17:39:43', NULL, NULL, '2025-01-08 17:39:43'),
(9, 9, NULL, 11, 10, 'Deposit balance', 'Cr.', 50, 7600, '2025-01-08 17:41:31', NULL, NULL, '2025-01-08 17:41:31'),
(10, 5, NULL, 12, 9, 'Deposit balance', 'Cr.', 500, 1535, '2025-01-09 16:22:41', NULL, NULL, '2025-01-09 16:22:41'),
(11, 5, NULL, 13, 9, 'Deposit balance', 'Cr.', 300, 1835, '2025-01-14 11:04:56', NULL, NULL, '2025-01-14 11:04:56'),
(12, 5, NULL, 14, 10, 'Deposit balance', 'Cr.', 200, 2035, '2025-01-14 11:06:21', NULL, NULL, '2025-01-14 11:06:21'),
(13, 5, 57, NULL, 8, 'Product purchase', 'Dr.', 10, 2025, '2025-04-06 10:31:06', NULL, NULL, '2025-04-06 10:31:06'),
(14, 9, NULL, 15, 2, 'Deposit balance', 'Cr.', 500, 8100, '2025-09-06 12:41:49', NULL, NULL, '2025-09-06 12:41:49'),
(15, 9, NULL, 16, 2, 'Deposit balance', 'Cr.', 50, 8150, '2025-09-06 17:29:43', NULL, NULL, '2025-09-06 17:29:43'),
(16, 9, NULL, 17, 2, 'Deposit balance', 'Cr.', 50, 8200, '2025-10-04 20:03:51', NULL, NULL, '2025-10-04 20:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `cc_customer_point_history`
--

CREATE TABLE `cc_customer_point_history` (
  `ledg_id` int UNSIGNED NOT NULL,
  `customer_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `particulars` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangaction_type` enum('Dr.','Cr.') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cr.',
  `point` int UNSIGNED NOT NULL,
  `rest_point` int UNSIGNED NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_customer_point_history`
--

INSERT INTO `cc_customer_point_history` (`ledg_id`, `customer_id`, `order_id`, `particulars`, `trangaction_type`, `point`, `rest_point`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 5, 46, 'product purchase point', 'Cr.', 75, 75, '2025-03-03 12:12:05', NULL, NULL, '2025-03-03 12:12:05'),
(2, 5, 46, 'Point add by admin', 'Cr.', 10, 85, '2025-03-03 12:13:09', NULL, NULL, '2025-03-03 12:13:09'),
(3, 5, 46, 'Point deducted by admin', 'Dr.', 5, 80, '2025-03-03 12:13:24', NULL, NULL, '2025-03-03 12:13:24'),
(4, 16, 47, 'product purchase point', 'Cr.', 150, 150, '2025-03-03 16:34:02', NULL, NULL, '2025-03-03 16:34:02'),
(5, 16, 48, 'product purchase point', 'Cr.', 275, 425, '2025-03-03 16:35:17', NULL, NULL, '2025-03-03 16:35:17'),
(6, 5, 49, 'product purchase point', 'Cr.', 498, 578, '2025-03-10 10:24:07', NULL, NULL, '2025-03-10 10:24:07'),
(7, 17, 51, 'product purchase point', 'Cr.', 275, 275, '2025-03-10 15:09:08', NULL, NULL, '2025-03-10 15:09:08'),
(8, 5, 52, 'product purchase point', 'Cr.', 550, 1128, '2025-04-03 18:01:37', NULL, NULL, '2025-04-03 18:01:37'),
(9, 5, 53, 'product purchase point', 'Cr.', 15, 1143, '2025-04-05 10:48:07', NULL, NULL, '2025-04-05 10:48:07'),
(10, 9, 54, 'product purchase point', 'Cr.', 65, 65, '2025-04-05 18:10:26', NULL, NULL, '2025-04-05 18:10:26'),
(11, 9, 55, 'product purchase point', 'Cr.', 268, 333, '2025-04-05 20:03:11', NULL, NULL, '2025-04-05 20:03:11'),
(12, 5, 56, 'product purchase point', 'Cr.', 55, 1198, '2025-04-06 10:26:23', NULL, NULL, '2025-04-06 10:26:23'),
(13, 5, 57, 'Point add by admin', 'Cr.', 44, 1242, '2025-04-23 19:38:27', NULL, NULL, '2025-04-23 19:38:27'),
(14, 5, 57, 'Point deducted by admin', 'Dr.', 44, 1198, '2025-04-23 19:38:37', NULL, NULL, '2025-04-23 19:38:37'),
(15, 5, 57, 'product purchase point', 'Cr.', 5, 1203, '2025-04-23 19:39:06', NULL, NULL, '2025-04-23 19:39:06'),
(16, 9, 65, 'product purchase point', 'Cr.', 268, 601, '2025-09-06 20:54:26', NULL, NULL, '2025-09-06 20:54:26'),
(17, 9, 98, 'product purchase point', 'Cr.', 228, 829, '2026-04-09 15:46:45', NULL, NULL, '2026-04-09 15:46:45'),
(18, 9, 102, 'product purchase point', 'Cr.', 343, 1172, '2026-05-03 16:49:31', NULL, NULL, '2026-05-03 16:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `cc_customer_wishlist`
--

CREATE TABLE `cc_customer_wishlist` (
  `customer_wishlist_id` int UNSIGNED NOT NULL,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_customer_wishlist`
--

INSERT INTO `cc_customer_wishlist` (`customer_wishlist_id`, `customer_id`, `product_id`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(11, 5, 22, '2025-04-24 19:19:30', NULL, NULL, '2025-04-24 19:19:30'),
(12, 5, 23, '2025-04-24 19:19:32', NULL, NULL, '2025-04-24 19:19:32'),
(14, 5, 84, '2025-12-22 18:27:47', NULL, NULL, '2025-12-22 18:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `cc_fund_request`
--

CREATE TABLE `cc_fund_request` (
  `fund_request_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `payment_method_id` int NOT NULL,
  `amount` int NOT NULL,
  `card_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_number` int DEFAULT NULL,
  `card_expiration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_cvc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Complete','Canceled') COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_fund_request`
--

INSERT INTO `cc_fund_request` (`fund_request_id`, `customer_id`, `payment_method_id`, `amount`, `card_name`, `card_number`, `card_expiration`, `card_cvc`, `status`, `createdDtm`) VALUES
(1, 5, 4, 500, NULL, NULL, NULL, NULL, 'Complete', '2023-09-10 10:10:02'),
(2, 5, 2, 500, NULL, NULL, NULL, NULL, 'Complete', '2023-09-11 20:25:56'),
(3, 9, 2, 5000, NULL, NULL, NULL, NULL, 'Complete', '2023-12-02 20:42:55'),
(4, 9, 2, 1000, NULL, NULL, NULL, NULL, 'Complete', '2023-12-04 17:17:26'),
(5, 9, 2, 1000, NULL, NULL, NULL, NULL, 'Complete', '2024-06-30 20:18:25'),
(6, 5, 9, 200, NULL, NULL, NULL, NULL, 'Complete', '2025-01-07 16:49:56'),
(7, 5, 10, 300, NULL, NULL, NULL, NULL, 'Complete', '2025-01-07 16:52:11'),
(8, 9, 9, 500, NULL, NULL, NULL, NULL, 'Complete', '2025-01-07 18:13:00'),
(9, 9, 10, 30, NULL, NULL, NULL, NULL, 'Complete', '2025-01-07 18:13:56'),
(10, 9, 9, 50, NULL, NULL, NULL, NULL, 'Complete', '2025-01-08 17:39:43'),
(11, 9, 10, 50, NULL, NULL, NULL, NULL, 'Complete', '2025-01-08 17:40:36'),
(12, 5, 9, 500, NULL, NULL, NULL, NULL, 'Complete', '2025-01-09 16:22:41'),
(13, 5, 9, 300, NULL, NULL, NULL, NULL, 'Complete', '2025-01-14 11:04:56'),
(14, 5, 10, 200, NULL, NULL, NULL, NULL, 'Complete', '2025-01-14 11:05:21'),
(15, 9, 2, 500, NULL, NULL, NULL, NULL, 'Complete', '2025-05-28 20:01:41'),
(16, 9, 2, 50, NULL, NULL, NULL, NULL, 'Complete', '2025-09-06 17:29:24'),
(17, 9, 2, 50, NULL, NULL, NULL, NULL, 'Complete', '2025-10-04 20:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `cc_geo_zone`
--

CREATE TABLE `cc_geo_zone` (
  `geo_zone_id` int UNSIGNED NOT NULL,
  `geo_zone_name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_zone_description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_geo_zone`
--

INSERT INTO `cc_geo_zone` (`geo_zone_id`, `geo_zone_name`, `geo_zone_description`, `sort_order`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 'bd zone', 'bd zone', 0, '1', '2023-11-21 18:18:29', NULL, NULL, '2023-11-21 18:53:47'),
(2, 'test', 'test', 0, '1', '2023-12-25 18:29:39', NULL, NULL, '2023-12-25 18:30:00'),
(3, 'test 2', 'test 2', 0, '1', '2024-01-10 15:30:20', NULL, NULL, '2024-01-10 16:23:27'),
(4, 'Singapore', 'Singapore', 0, '1', '2024-01-24 17:20:25', NULL, NULL, '2024-01-24 17:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `cc_geo_zone_details`
--

CREATE TABLE `cc_geo_zone_details` (
  `geo_zone_details_id` int UNSIGNED NOT NULL,
  `geo_zone_id` int NOT NULL,
  `country_id` int NOT NULL,
  `zone_id` int NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_geo_zone_details`
--

INSERT INTO `cc_geo_zone_details` (`geo_zone_details_id`, `geo_zone_id`, `country_id`, `zone_id`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 1, 18, 0, '2023-11-21 18:18:29', NULL, NULL, '2023-11-21 18:18:29'),
(2, 2, 10, 0, '2023-12-25 18:29:39', NULL, NULL, '2023-12-25 18:29:39'),
(3, 3, 1, 0, '2024-01-10 15:30:20', NULL, NULL, '2024-01-10 16:23:27'),
(4, 4, 188, 0, '2024-01-24 17:20:25', NULL, NULL, '2024-01-24 17:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `cc_geo_zone_shipping_rate`
--

CREATE TABLE `cc_geo_zone_shipping_rate` (
  `cc_geo_zone_shipping_rate_id` int UNSIGNED NOT NULL,
  `geo_zone_id` int NOT NULL,
  `up_to_value` float NOT NULL,
  `cost` int NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_geo_zone_shipping_rate`
--

INSERT INTO `cc_geo_zone_shipping_rate` (`cc_geo_zone_shipping_rate_id`, `geo_zone_id`, `up_to_value`, `cost`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(2, 1, 10, 100, '2023-11-21 18:19:08', NULL, NULL, '2023-11-21 18:19:08'),
(3, 1, 20, 150, '2023-11-21 18:19:08', NULL, NULL, '2023-11-21 18:19:08'),
(4, 0, 5, 10, '2023-11-21 18:19:25', NULL, NULL, '2023-11-21 19:19:37'),
(5, 0, 10, 20, '2023-11-21 18:19:25', NULL, NULL, '2023-11-21 19:19:37'),
(6, 0, 20, 50, '2023-11-21 18:19:25', NULL, NULL, '2023-11-21 19:19:37'),
(7, 2, 4, 500, '2024-01-08 18:53:02', NULL, NULL, '2024-01-08 18:53:10'),
(8, 3, 8, 100, '2024-01-10 16:22:26', NULL, NULL, '2024-01-10 17:15:58'),
(9, 4, 10, 34, '2024-01-24 17:21:04', NULL, NULL, '2024-01-24 17:21:04'),
(10, 4, 20, 44, '2024-01-24 17:21:04', NULL, NULL, '2024-01-24 17:21:04'),
(11, 4, 30, 54, '2024-01-24 17:21:04', NULL, NULL, '2024-01-24 17:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `cc_icons`
--

CREATE TABLE `cc_icons` (
  `icon_id` int UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `code` text,
  `path` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cc_icons`
--

INSERT INTO `cc_icons` (`icon_id`, `name`, `code`, `path`) VALUES
(1, 'watch.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\">\r\n<path d=\"M9.14111 5.34961C6.57659 5.34961 4.49023 7.436 4.49023 10.0005C4.49023 12.565 6.57662 14.6514 9.14111 14.6514C10.3784 14.6514 11.5436 14.1692 12.4223 13.2937C12.5356 13.1808 12.5359 12.9975 12.4231 12.8843C12.3102 12.771 12.1269 12.7707 12.0137 12.8836C11.2443 13.6502 10.2241 14.0724 9.14115 14.0724C6.89588 14.0724 5.0692 12.2457 5.0692 10.0005C5.0692 7.75522 6.89588 5.92854 9.14115 5.92854C11.3864 5.92854 13.2131 7.75522 13.2131 10.0005C13.2131 10.8167 12.9714 11.6047 12.5142 12.2792C12.4245 12.4116 12.4591 12.5915 12.5914 12.6812C12.7237 12.7709 12.9037 12.7363 12.9934 12.604C13.5159 11.8332 13.7921 10.9329 13.7921 10.0005C13.792 7.43596 11.7056 5.34961 9.14111 5.34961Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M15.3298 8.87157H14.8401C14.6024 7.66934 13.9928 6.59923 13.1363 5.78676V3.66099V1.58613C13.1363 1.17112 12.7986 0.833496 12.3837 0.833496H5.89982C5.48482 0.833496 5.14719 1.17112 5.14719 1.58613V3.66099V5.78684C4.0305 6.84613 3.33301 8.3432 3.33301 10.0002C3.33301 11.6572 4.03054 13.1542 5.14719 14.2135V16.3393V18.4142C5.14719 18.8292 5.48482 19.1668 5.89982 19.1668H12.3837C12.7987 19.1668 13.1363 18.8292 13.1363 18.4142V16.3393V14.2135C13.9929 13.4011 14.6025 12.331 14.8402 11.1287H15.3298C15.7448 11.1287 16.0825 10.7911 16.0825 10.3761V9.6242C16.0824 9.20923 15.7448 8.87157 15.3298 8.87157ZM5.72612 3.95049H6.34881C6.50869 3.95049 6.63828 3.8209 6.63828 3.66102C6.63828 3.50114 6.50866 3.37156 6.34881 3.37156H5.72612V1.58613C5.72612 1.49038 5.80404 1.41243 5.89982 1.41243H12.3837C12.4794 1.41243 12.5574 1.49035 12.5574 1.58613V3.37152H7.22369C7.06381 3.37152 6.93423 3.50111 6.93423 3.66099C6.93423 3.82087 7.06385 3.95046 7.22369 3.95046H12.5573V5.30419C12.5455 5.29549 12.5334 5.28714 12.5215 5.27855C12.5102 5.27046 12.4989 5.26233 12.4876 5.25431C12.4616 5.23598 12.4356 5.21797 12.4094 5.2001C12.3995 5.19337 12.3897 5.18656 12.3798 5.17987C12.3443 5.15598 12.3086 5.13239 12.2727 5.10929C12.2657 5.10481 12.2587 5.10052 12.2517 5.09611C12.223 5.07785 12.1943 5.05984 12.1653 5.04212C12.1497 5.03255 12.1339 5.02321 12.1182 5.01376C12.0979 5.00165 12.0777 4.98959 12.0573 4.9777C12.0389 4.96699 12.0205 4.95639 12.0019 4.9459C11.9845 4.93602 11.967 4.92624 11.9495 4.91654C11.9289 4.90512 11.9083 4.89373 11.8876 4.88252C11.8748 4.87565 11.8619 4.86899 11.8491 4.86218C11.7631 4.81667 11.6758 4.77331 11.5874 4.73202C11.5817 4.72941 11.5761 4.72669 11.5704 4.72411C11.5395 4.70982 11.5085 4.69586 11.4772 4.68211C11.4733 4.68042 11.4695 4.67871 11.4656 4.67702C10.9925 4.46973 10.4869 4.32371 9.95844 4.24905C9.94982 4.24784 9.94111 4.24658 9.93241 4.2454C9.90208 4.24128 9.87168 4.23731 9.84125 4.23362C9.82821 4.23204 9.81514 4.23061 9.80211 4.22914C9.77253 4.22578 9.74303 4.22241 9.71334 4.21951C9.67603 4.21586 9.63861 4.21249 9.60116 4.20952C9.58197 4.20802 9.5627 4.20687 9.54347 4.20551C9.51723 4.20369 9.49098 4.20197 9.46466 4.2005C9.44651 4.1995 9.42835 4.19864 9.41013 4.19781C9.38076 4.19645 9.35133 4.19534 9.32193 4.19445C9.30675 4.19398 9.2916 4.19344 9.27639 4.19309C9.23159 4.19205 9.18669 4.1914 9.14175 4.1914C9.09681 4.1914 9.05195 4.19205 9.00711 4.19309C8.9919 4.19344 8.97675 4.19398 8.96157 4.19445C8.93213 4.19534 8.90274 4.19645 8.87337 4.19781C8.85515 4.19864 8.83699 4.1995 8.81884 4.2005C8.79263 4.20197 8.76645 4.20369 8.74028 4.20548C8.72091 4.2068 8.70153 4.20798 8.68223 4.20949C8.64865 4.21214 8.6152 4.21518 8.58172 4.21844C8.54792 4.2217 8.51423 4.22535 8.4806 4.22922C8.46793 4.23068 8.45529 4.23204 8.44261 4.23358C8.41189 4.23731 8.38124 4.24132 8.35066 4.24547C8.34228 4.24662 8.33394 4.2478 8.32556 4.24898C7.79682 4.32368 7.29083 4.46977 6.81753 4.6772C6.81391 4.67878 6.81023 4.68039 6.80661 4.682C6.77528 4.69582 6.74405 4.70986 6.71297 4.72422C6.70746 4.72676 6.70198 4.72937 6.69647 4.73195C6.60859 4.77292 6.52187 4.81603 6.4364 4.86118C6.42279 4.86841 6.40908 4.8755 6.39547 4.88281C6.37531 4.89366 6.35533 4.90472 6.33535 4.91582C6.31705 4.92599 6.29875 4.93616 6.28053 4.94651C6.26277 4.95657 6.24508 4.96678 6.22746 4.97705C6.20587 4.98962 6.18438 5.00237 6.16297 5.01522C6.14843 5.02396 6.13379 5.03263 6.11932 5.04147C6.08702 5.06124 6.05487 5.08129 6.02289 5.10173C6.01928 5.10406 6.01559 5.10628 6.01197 5.10861C5.97509 5.13228 5.93849 5.15648 5.90208 5.18101C5.89438 5.18617 5.88682 5.19147 5.8792 5.1967C5.85044 5.21628 5.82183 5.23612 5.7934 5.25621C5.78409 5.2628 5.77486 5.26946 5.76558 5.27608C5.75244 5.2855 5.73919 5.29477 5.72609 5.3043L5.72612 3.95049ZM12.5573 18.4142C12.5573 18.51 12.4794 18.5879 12.3836 18.5879H5.89982C5.80407 18.5879 5.72612 18.51 5.72612 18.4142V16.6288H12.5573V18.4142ZM12.5573 16.0499H5.72612V14.6961C5.73923 14.7057 5.75255 14.715 5.76576 14.7245C5.77496 14.731 5.78409 14.7376 5.79333 14.7442C5.82191 14.7644 5.85062 14.7843 5.87952 14.804C5.88704 14.8091 5.89449 14.8143 5.90201 14.8194C5.93846 14.844 5.97513 14.8682 6.01208 14.8919C6.01544 14.894 6.01885 14.8961 6.02218 14.8982C6.05444 14.9189 6.08688 14.9391 6.11947 14.959C6.13375 14.9678 6.14818 14.9763 6.16258 14.985C6.18421 14.9979 6.2058 15.0108 6.22757 15.0235C6.24508 15.0337 6.26269 15.0438 6.28038 15.0538C6.29872 15.0642 6.31712 15.0745 6.33556 15.0846C6.35544 15.0957 6.37531 15.1067 6.39536 15.1175C6.40918 15.1249 6.42308 15.1321 6.43693 15.1394C6.52208 15.1844 6.60842 15.2273 6.696 15.2682C6.70173 15.2708 6.70742 15.2735 6.71319 15.2762C6.7442 15.2905 6.77528 15.3045 6.80654 15.3183C6.81023 15.3199 6.81395 15.3216 6.81764 15.3232C7.29087 15.5306 7.79675 15.6766 8.32538 15.7513C8.33386 15.7525 8.34239 15.7537 8.35091 15.7549C8.38134 15.759 8.41185 15.763 8.44247 15.7667C8.45529 15.7683 8.46814 15.7697 8.48096 15.7711C8.51451 15.775 8.54806 15.7786 8.58176 15.7819C8.61524 15.7851 8.64872 15.7882 8.68227 15.7908C8.70157 15.7923 8.72098 15.7935 8.74031 15.7949C8.76649 15.7967 8.79266 15.7984 8.81887 15.7998C8.83703 15.8008 8.85522 15.8017 8.87341 15.8025C8.90277 15.8039 8.93221 15.8049 8.9616 15.8059C8.97679 15.8063 8.99193 15.8069 9.00715 15.8072C9.05195 15.8083 9.09685 15.8089 9.14179 15.8089C9.18672 15.8089 9.23159 15.8082 9.27642 15.8072C9.29164 15.8069 9.30679 15.8063 9.32197 15.8059C9.3514 15.8049 9.3808 15.8039 9.41016 15.8025C9.42835 15.8017 9.44651 15.8008 9.4647 15.7998C9.49101 15.7984 9.51726 15.7966 9.54351 15.7948C9.56274 15.7935 9.58204 15.7923 9.60119 15.7908C9.63868 15.7878 9.67607 15.7845 9.71338 15.7808C9.74306 15.7779 9.7726 15.7745 9.80215 15.7712C9.81518 15.7697 9.82825 15.7683 9.84128 15.7667C9.87179 15.7631 9.90216 15.7591 9.93245 15.7549C9.94115 15.7537 9.94981 15.7525 9.95848 15.7513C10.4869 15.6766 10.9926 15.5306 11.4657 15.3233C11.4695 15.3216 11.4733 15.3199 11.4771 15.3183C11.5084 15.3045 11.5394 15.2905 11.5703 15.2762C11.5761 15.2736 11.5818 15.2708 11.5875 15.2682C11.6758 15.227 11.763 15.1837 11.8489 15.1383C11.8618 15.1314 11.8747 15.1248 11.8876 15.1178C11.9083 15.1067 11.9288 15.0954 11.9493 15.084C11.967 15.0742 11.9846 15.0644 12.0021 15.0544C12.0205 15.044 12.0389 15.0334 12.0571 15.0228C12.0776 15.0108 12.0981 14.9987 12.1185 14.9865C12.134 14.9772 12.1497 14.9678 12.1652 14.9584C12.1944 14.9405 12.2235 14.9223 12.2524 14.9039C12.2591 14.8996 12.2659 14.8955 12.2726 14.8911C12.3087 14.868 12.3444 14.8444 12.38 14.8204C12.3897 14.8138 12.3994 14.8071 12.4091 14.8005C12.4354 14.7825 12.4616 14.7644 12.4877 14.746C12.499 14.738 12.5101 14.73 12.5214 14.7219C12.5334 14.7133 12.5455 14.7048 12.5574 14.6961V16.0499H12.5573ZM14.3683 10.1795C14.3679 10.1933 14.3673 10.2069 14.3668 10.2206C14.3617 10.3407 14.3526 10.4607 14.3394 10.5799C14.338 10.5924 14.3366 10.6048 14.3351 10.6173C14.3281 10.6769 14.3204 10.7363 14.3114 10.7954C14.3113 10.7955 14.3113 10.7957 14.3113 10.7958C14.1255 12.0073 13.5226 13.0831 12.6543 13.8716C12.6537 13.8722 12.6529 13.8726 12.6523 13.8732C12.4737 14.0352 12.2854 14.1837 12.0889 14.3182C12.086 14.3202 12.0831 14.3222 12.0803 14.3242C12.051 14.3441 12.0215 14.3637 11.9919 14.383C11.9875 14.3859 11.9831 14.3888 11.9787 14.3917C11.9496 14.4106 11.9202 14.4291 11.8907 14.4474C11.8858 14.4504 11.881 14.4535 11.8762 14.4565C11.8465 14.4748 11.8166 14.4927 11.7866 14.5104C11.782 14.5131 11.7774 14.5158 11.7728 14.5185C11.742 14.5365 11.7111 14.5541 11.6801 14.5714C11.6763 14.5735 11.6725 14.5757 11.6687 14.5778C11.6365 14.5956 11.6042 14.613 11.5717 14.6301C11.5692 14.6315 11.5667 14.6329 11.5642 14.6342C11.5303 14.6519 11.4962 14.6693 11.462 14.6863C11.4611 14.6868 11.4602 14.6872 11.4593 14.6877C10.9951 14.9179 10.4986 15.0779 9.98519 15.1617C9.98491 15.1618 9.98466 15.1618 9.98437 15.1619C9.94785 15.1678 9.91125 15.1733 9.87458 15.1785C9.86903 15.1793 9.86348 15.1801 9.85786 15.1809C9.82503 15.1854 9.79212 15.1896 9.75918 15.1935C9.74922 15.1946 9.73927 15.1958 9.72931 15.1969C9.69977 15.2003 9.67023 15.2034 9.64062 15.2062C9.62644 15.2076 9.61222 15.2088 9.59801 15.21C9.57176 15.2123 9.54555 15.2145 9.51923 15.2164C9.50075 15.2177 9.48213 15.2188 9.46359 15.22C9.44085 15.2214 9.41815 15.2228 9.39541 15.2239C9.37113 15.225 9.34675 15.2259 9.32236 15.2267C9.30475 15.2273 9.2872 15.2281 9.26962 15.2286C9.22711 15.2296 9.18454 15.2302 9.14182 15.2302C9.0991 15.2302 9.05653 15.2296 9.01403 15.2286C8.99637 15.2281 8.97883 15.2273 8.96121 15.2267C8.93686 15.2259 8.91251 15.2251 8.88823 15.2239C8.86546 15.2228 8.84269 15.2214 8.81995 15.22C8.80144 15.2189 8.78289 15.2178 8.76441 15.2164C8.73809 15.2145 8.71181 15.2123 8.68553 15.21C8.67135 15.2088 8.6572 15.2076 8.64306 15.2062C8.61338 15.2034 8.58373 15.2003 8.55419 15.1969C8.5443 15.1958 8.53446 15.1946 8.52457 15.1935C8.49152 15.1896 8.45855 15.1854 8.42564 15.1808C8.42016 15.18 8.41468 15.1793 8.40924 15.1785C8.37246 15.1733 8.33576 15.1678 8.29917 15.1618C8.29906 15.1618 8.29888 15.1618 8.29877 15.1617C7.78544 15.0779 7.28901 14.918 6.82487 14.6879C6.82358 14.6873 6.82233 14.6866 6.82107 14.686C6.78727 14.6692 6.75361 14.652 6.7201 14.6344C6.71705 14.6328 6.71401 14.6311 6.71097 14.6296C6.67903 14.6127 6.64723 14.5956 6.61565 14.5781C6.61117 14.5756 6.60673 14.5731 6.60226 14.5706C6.57193 14.5537 6.54171 14.5365 6.51163 14.519C6.50611 14.5157 6.50063 14.5124 6.49512 14.5092C6.46604 14.4921 6.43715 14.4747 6.40839 14.4571C6.40216 14.4532 6.39604 14.4493 6.38988 14.4455C6.36174 14.428 6.3337 14.4104 6.30584 14.3924C6.29968 14.3884 6.2936 14.3843 6.28747 14.3802C6.25965 14.3621 6.23194 14.3437 6.20444 14.325C6.19906 14.3214 6.19377 14.3176 6.18843 14.3139C6.16018 14.2945 6.13196 14.2749 6.10407 14.255C6.10124 14.2529 6.09845 14.2508 6.09562 14.2488C5.9347 14.1331 5.77958 14.0079 5.63123 13.8733C5.63084 13.8729 5.63041 13.8726 5.63005 13.8723C4.57534 12.9148 3.91201 11.5335 3.91201 10.0002C3.91201 8.46691 4.57531 7.08561 5.62998 6.12815C5.63037 6.12779 5.63084 6.12754 5.6312 6.12719C5.77958 5.99255 5.93473 5.86733 6.09562 5.75164C6.09845 5.74963 6.1012 5.74752 6.10403 5.74551C6.13221 5.72536 6.16061 5.70559 6.18911 5.68604C6.19416 5.68257 6.19917 5.67898 6.20429 5.67551C6.23201 5.65664 6.25994 5.63816 6.28797 5.61987C6.29392 5.61596 6.29979 5.61203 6.30577 5.60816C6.3337 5.59004 6.36185 5.57235 6.3901 5.5548C6.39618 5.55101 6.4022 5.54718 6.40832 5.54342C6.43711 5.52569 6.46612 5.50833 6.49519 5.49121C6.50067 5.48795 6.50611 5.48473 6.51159 5.48151C6.54171 5.46396 6.57196 5.44674 6.60236 5.42977C6.60677 5.42729 6.61117 5.42482 6.61558 5.42239C6.6473 5.40484 6.67917 5.38762 6.71122 5.37075C6.71415 5.36922 6.71709 5.36764 6.72003 5.3661C6.75361 5.34848 6.78738 5.33126 6.82129 5.31439C6.82244 5.31382 6.82362 5.31325 6.82476 5.31264C7.28893 5.08251 7.7854 4.92252 8.29881 4.83866C8.29892 4.83862 8.2991 4.83862 8.2992 4.83859C8.3358 4.83261 8.37246 4.82713 8.4092 4.8219C8.41475 4.82111 8.42027 4.82032 8.42585 4.81957C8.45869 4.81502 8.4916 4.81084 8.52454 4.80697C8.53446 4.80582 8.54438 4.80464 8.55433 4.80353C8.58391 4.8002 8.61348 4.79709 8.64313 4.79426C8.65728 4.7929 8.67142 4.79171 8.6856 4.79046C8.71188 4.78817 8.73817 4.78595 8.76448 4.78405C8.78296 4.78273 8.80151 4.78165 8.82002 4.78054C8.84276 4.77915 8.8655 4.77768 8.88831 4.77657C8.91258 4.77542 8.93693 4.7746 8.96128 4.77377C8.9789 4.77317 8.99644 4.77234 9.0141 4.77191C9.0566 4.77087 9.09917 4.7703 9.14189 4.7703C9.18461 4.7703 9.22719 4.77087 9.26969 4.77191C9.28731 4.77234 9.30485 4.77313 9.32247 4.77374C9.34685 4.7746 9.3712 4.77535 9.39552 4.77653C9.41829 4.77764 9.44099 4.77907 9.46369 4.78047C9.48224 4.78158 9.50083 4.78266 9.51934 4.78402C9.54562 4.78591 9.57187 4.7881 9.59811 4.79042C9.61233 4.79164 9.62655 4.79286 9.64073 4.79422C9.6703 4.79705 9.69981 4.80016 9.72931 4.80349C9.73934 4.8046 9.7494 4.80579 9.75939 4.80693C9.79226 4.81084 9.8251 4.81499 9.85786 4.8195C9.86348 4.82029 9.86914 4.82108 9.87476 4.8219C9.91139 4.82706 9.94799 4.83253 9.98444 4.83851C9.98473 4.83855 9.98498 4.83859 9.98526 4.83862C10.4987 4.92248 10.9953 5.08251 11.4595 5.31278C11.4603 5.31318 11.4611 5.31361 11.4619 5.31396C11.4962 5.33101 11.5304 5.34848 11.5643 5.36628C11.5668 5.36757 11.5692 5.36886 11.5716 5.37015C11.6042 5.3873 11.6366 5.40481 11.6689 5.42264C11.6726 5.42472 11.6763 5.42683 11.6801 5.42894C11.7112 5.44627 11.7422 5.46393 11.7729 5.48186C11.7775 5.48451 11.782 5.48727 11.7866 5.48992C11.8167 5.50765 11.8467 5.52559 11.8764 5.54388C11.8812 5.54682 11.8859 5.54983 11.8907 5.5528C11.9203 5.57113 11.9498 5.58975 11.979 5.6087C11.9833 5.61145 11.9874 5.61425 11.9916 5.61704C12.0214 5.63648 12.0511 5.65614 12.0806 5.67626C12.0831 5.67798 12.0857 5.67984 12.0883 5.6816C12.2851 5.81627 12.4737 5.96494 12.6525 6.12719C12.6536 6.12819 12.6548 6.12905 12.6559 6.13001C13.5235 6.91842 14.1258 7.99375 14.3114 9.20454C14.3114 9.20465 14.3114 9.20476 14.3114 9.2049C14.3204 9.26388 14.3282 9.32328 14.3352 9.38279C14.3367 9.39536 14.3381 9.408 14.3395 9.4206C14.3527 9.5397 14.3618 9.65962 14.3668 9.77972C14.3674 9.7934 14.3679 9.80707 14.3684 9.82079C14.3704 9.88062 14.3718 9.94042 14.3718 10.0002C14.3717 10.0599 14.3703 10.1197 14.3683 10.1795ZM15.3298 10.5498H14.9246C14.926 10.5355 14.927 10.5212 14.9282 10.5069C14.9305 10.4798 14.9329 10.4527 14.9349 10.4255C14.9365 10.404 14.9377 10.3824 14.939 10.3609C14.9406 10.3355 14.9423 10.3101 14.9435 10.2846C14.9448 10.2581 14.9456 10.2316 14.9465 10.2051C14.9472 10.1845 14.9482 10.1639 14.9487 10.1432C14.9498 10.0955 14.9505 10.0478 14.9505 10.0002C14.9505 9.95259 14.9499 9.90493 14.9487 9.85724C14.9482 9.83658 14.9472 9.8161 14.9465 9.79551C14.9456 9.7689 14.9448 9.74233 14.9435 9.71573C14.9423 9.69034 14.9405 9.66506 14.939 9.63975C14.9376 9.61808 14.9365 9.59645 14.9349 9.57479C14.9329 9.54772 14.9305 9.52079 14.9282 9.49387C14.927 9.47944 14.926 9.46497 14.9246 9.45057H15.3298C15.4255 9.45057 15.5035 9.52849 15.5035 9.62428V10.3762C15.5035 10.4719 15.4256 10.5498 15.3298 10.5498Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M9.14173 6.35205C8.98185 6.35205 8.85226 6.4816 8.85226 6.64152V9.22405C8.53755 9.34186 8.3125 9.64482 8.3125 10.0001C8.3125 10.4574 8.6845 10.8294 9.14176 10.8294C9.49708 10.8294 9.80001 10.6043 9.91785 10.2896H11.6387C11.7986 10.2896 11.9281 10.1601 11.9281 10.0002C11.9281 9.84026 11.7986 9.71071 11.6387 9.71071H9.91785C9.83381 9.48627 9.65567 9.30809 9.43123 9.22409V6.64155C9.43119 6.48167 9.30157 6.35205 9.14173 6.35205ZM9.14173 10.2505C9.00369 10.2505 8.89143 10.1382 8.89143 10.0002C8.89143 9.86214 9.00373 9.74988 9.14173 9.74988C9.27973 9.74988 9.39202 9.86218 9.39202 10.0002C9.39202 10.1382 9.27973 10.2505 9.14173 10.2505Z\" fill=\"#5F5F5F\"/>\r\n</svg>', NULL),
(2, 'toy.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\">\r\n<g >\r\n<path d=\"M18.9333 10.1665H15.7978L13.9333 7.73318C13.0333 6.53318 11.6 5.83318 10.1 5.83318H4.33332C3.6 5.83318 3 6.43318 3 7.1665V10.1665H1.66668V4.79068C2.24008 4.6417 2.66668 4.11818 2.66668 3.49982C2.66668 2.7665 2.06668 2.1665 1.33336 2.1665C0.6 2.1665 0 2.7665 0 3.49982C0 4.11818 0.426602 4.6417 1 4.79068V10.1687C0.4325 10.2018 0 10.6556 0 11.2331V14.7665C0 15.3665 0.46668 15.8331 1.06668 15.8331H1.69023C1.84941 16.972 2.8134 17.8331 4.00004 17.8331C5.18668 17.8331 6.15066 16.972 6.30984 15.8331H13.6902C13.8494 16.972 14.8134 17.8331 16 17.8331C17.1867 17.8331 18.1507 16.972 18.3098 15.8331H18.9334C19.5334 15.8331 20.0001 15.3665 20.0001 14.7665V13.1665V11.8331V11.2331C20 10.6331 19.5333 10.1665 18.9333 10.1665ZM3.66668 7.1665C3.66668 6.79982 3.96668 6.49982 4.33336 6.49982H10.1334C11.4 6.49982 12.6334 7.09982 13.4334 8.13314L15 10.1665H11.851L11.3333 8.5665C11.1666 8.03318 10.6 7.7665 10.0666 7.93318C9.53332 8.09986 9.26664 8.6665 9.43332 9.19986L9.74899 10.1665H7.18824L6.6 8.56654C6.53332 8.29986 6.33332 8.09986 6.1 7.99986C5.86668 7.89986 5.6 7.86654 5.33332 7.96654C4.8 8.13322 4.53332 8.69986 4.73332 9.23322L5.06387 10.1665H3.66668V7.1665ZM10.0333 9.03314C9.96664 8.83314 10.0666 8.66646 10.2333 8.59982C10.4333 8.53314 10.6 8.63314 10.6666 8.79982L11.1333 10.1665H10.4333L10.0333 9.03314ZM5.33332 9.03314C5.26664 8.86646 5.36664 8.66646 5.53332 8.59982C5.63332 8.5665 5.73332 8.5665 5.8 8.59982C5.86668 8.6665 5.93332 8.73314 5.96668 8.79982L6.46668 10.1665H5.76668L5.33332 9.03314ZM0.66668 3.49982C0.66668 3.13314 0.96668 2.83314 1.33336 2.83314C1.70004 2.83314 2.00004 3.13314 2.00004 3.49982C2.00004 3.8665 1.70004 4.1665 1.33336 4.1665C0.96668 4.1665 0.66668 3.8665 0.66668 3.49982ZM4 17.1665C3.06668 17.1665 2.33332 16.4332 2.33332 15.4998C2.33332 14.5665 3.06664 13.8331 4 13.8331C4.93332 13.8331 5.66668 14.5665 5.66668 15.4998C5.66668 16.4331 4.93332 17.1665 4 17.1665ZM16 17.1665C15.0667 17.1665 14.3333 16.4332 14.3333 15.4998C14.3333 14.5665 15.0666 13.8331 16 13.8331C16.9333 13.8331 17.6667 14.5665 17.6667 15.4998C17.6667 16.4331 16.9333 17.1665 16 17.1665ZM18.9333 15.1665H18.3098C18.1506 14.0276 17.1866 13.1665 16 13.1665C15.9946 13.1665 15.9893 13.1669 15.9839 13.1669C15.9781 13.1669 15.9724 13.1665 15.9666 13.1665C14.8 13.1665 13.8333 14.0332 13.6666 15.1665H6.30981C6.16055 14.0986 5.30352 13.2753 4.21887 13.1768C4.21094 13.1761 4.20289 13.1757 4.19492 13.175C4.16762 13.1728 4.14035 13.1706 4.11277 13.1693C4.07539 13.1675 4.03781 13.1665 4 13.1665C3.96219 13.1665 3.92461 13.1675 3.88723 13.1693C3.85965 13.1706 3.83238 13.1728 3.80508 13.175C3.79711 13.1757 3.78906 13.1761 3.78113 13.1768C2.69648 13.2753 1.83945 14.0986 1.6902 15.1665H1.06668C0.833359 15.1665 0.66668 14.9998 0.66668 14.7665V12.4998H1.66668C1.86668 12.4998 2 12.3665 2 12.1665C2 11.9665 1.86668 11.8332 1.66668 11.8332H0.66668V11.2332C0.66668 10.9999 0.833359 10.8332 1.06668 10.8332H3.33336H5.30004H7.43336H9.96668H12.0667H15.6667H18.9334C19.1667 10.8332 19.3334 10.9999 19.3334 11.2332V11.4999H18.6667C18.1 11.4999 17.6667 11.9332 17.6667 12.4999C17.6667 13.0665 18.1 13.4999 18.6667 13.4999H19.3334V14.7665C19.3333 14.9998 19.1667 15.1665 18.9333 15.1665ZM19.3333 12.1665V12.8332H18.6666C18.4666 12.8332 18.3333 12.6999 18.3333 12.4999C18.3333 12.2999 18.4666 12.1665 18.6666 12.1665L19.3333 12.1665Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M4.00031 15.1665C3.80031 15.1665 3.66699 15.2998 3.66699 15.4998C3.66699 15.6998 3.80031 15.8331 4.00031 15.8331C4.20031 15.8331 4.33363 15.6998 4.33363 15.4998C4.33363 15.2998 4.20031 15.1665 4.00031 15.1665Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M16.0003 15.1665C15.8003 15.1665 15.667 15.2998 15.667 15.4998C15.667 15.6998 15.8003 15.8331 16.0003 15.8331C16.2003 15.8331 16.3336 15.6998 16.3336 15.4998C16.3336 15.2998 16.2003 15.1665 16.0003 15.1665Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M11.667 11.833H10.0003C9.80031 11.833 9.66699 11.9663 9.66699 12.1663V12.4997C9.66699 12.6997 9.80031 12.833 10.0003 12.833C10.2003 12.833 10.3336 12.6997 10.3336 12.4997H11.3336C11.3336 12.6997 11.467 12.833 11.667 12.833C11.867 12.833 12.0003 12.6997 12.0003 12.4997V12.1664C12.0003 11.9664 11.867 11.833 11.667 11.833Z\" fill=\"#5F5F5F\"/>\r\n</g>\r\n<defs>\r\n<clipPath >\r\n<rect width=\"20\" height=\"20\" fill=\"white\"/>\r\n</clipPath>\r\n</defs>\r\n</svg>', NULL),
(3, 'security.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\">\r\n<path d=\"M9.33874 14.8245C10.1333 14.8245 10.7576 14.2002 10.7576 13.4056C10.7576 12.6111 10.1333 11.9868 9.33874 11.9868C8.5442 11.9868 7.91992 12.6111 7.91992 13.4056C7.91992 14.2002 8.5442 14.8245 9.33874 14.8245ZM9.33874 12.5543C9.82114 12.5543 10.19 12.9232 10.19 13.4056C10.19 13.888 9.82114 14.2569 9.33874 14.2569C8.85634 14.2569 8.48745 13.888 8.48745 13.4056C8.48745 12.9232 8.85634 12.5543 9.33874 12.5543Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M7.52169 14.5401C7.3798 14.6252 7.35143 14.7955 7.43656 14.9373C7.8622 15.59 8.57161 15.9589 9.33778 15.9589C10.1039 15.9589 10.8134 15.59 11.239 14.9373C11.3241 14.7955 11.2958 14.6252 11.1539 14.5401C11.012 14.4549 10.8417 14.4833 10.7566 14.6252C10.4445 15.1076 9.90531 15.3914 9.33778 15.3914C8.77025 15.3914 8.2311 15.1076 7.91896 14.6252C7.83383 14.4833 7.66357 14.4549 7.52169 14.5401Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M7.09825 15.42C7.01312 15.3065 6.81448 15.2781 6.70098 15.3633C6.58747 15.4484 6.5591 15.647 6.64422 15.7605C7.29688 16.6118 8.26168 17.0942 9.33999 17.0942C10.4183 17.0942 11.3831 16.6118 12.0357 15.7605C12.1209 15.647 12.1209 15.4484 11.979 15.3633C11.8655 15.2781 11.6669 15.2781 11.5817 15.42C11.0426 16.1294 10.2197 16.5267 9.33999 16.5267C8.46032 16.5267 7.6374 16.1294 7.09825 15.42Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M12.4046 16.2144C11.6384 17.1225 10.5317 17.6616 9.3399 17.6616C8.14809 17.6616 7.04141 17.1225 6.27525 16.2144C6.16174 16.1009 5.99148 16.0725 5.87798 16.186C5.76447 16.2995 5.7361 16.4698 5.8496 16.5833C6.70089 17.6332 7.97783 18.2291 9.3399 18.2291C10.702 18.2291 11.9789 17.6332 12.8302 16.5833C12.9437 16.4698 12.9153 16.2712 12.8018 16.186C12.6883 16.0725 12.4897 16.1009 12.4046 16.2144Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M15.5819 1.771H3.09626C2.92601 1.771 2.8125 1.8845 2.8125 2.05476V2.62229C2.8125 3.41683 3.43678 4.04111 4.23132 4.04111V6.31123C4.23132 7.10577 4.40158 7.84355 4.7421 8.49621C4.7421 8.52459 4.77047 8.58134 4.79885 8.60972C5.62177 10.2839 7.35273 11.419 9.33908 11.419C11.3254 11.419 13.0564 10.2839 13.9077 8.60972C13.9361 8.58134 13.9644 8.55297 13.9644 8.49621C14.2766 7.84355 14.4752 7.10577 14.4752 6.31123V4.04111C15.2698 4.04111 15.894 3.41683 15.894 2.62229V2.05476C15.8657 1.8845 15.7522 1.771 15.5819 1.771ZM9.33908 10.8515C7.60812 10.8515 6.10417 9.88666 5.338 8.43946C6.24605 7.10577 7.72162 6.31123 9.33908 6.31123C10.9565 6.31123 12.4321 7.10577 13.3402 8.43946C12.574 9.88666 11.07 10.8515 9.33908 10.8515ZM13.8793 6.31123C13.8793 6.85038 13.7658 7.36116 13.5955 7.84355C12.6024 6.50986 11.0417 5.7437 9.33908 5.7437C7.63649 5.7437 6.07579 6.50986 5.08262 7.84355C4.91236 7.36116 4.79885 6.85038 4.79885 6.31123V4.04111H13.8793V6.31123ZM15.2981 2.62229C15.2981 3.10469 14.9292 3.47358 14.4468 3.47358H14.1631H4.51509H4.23132C3.74892 3.47358 3.38003 3.10469 3.38003 2.62229V2.33852H15.2981V2.62229Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M9.33874 7.1626C8.5442 7.1626 7.91992 7.78688 7.91992 8.58142C7.91992 9.37596 8.5442 10.0002 9.33874 10.0002C10.1333 10.0002 10.7576 9.37596 10.7576 8.58142C10.7576 7.78688 10.1333 7.1626 9.33874 7.1626ZM9.33874 9.43271C8.85634 9.43271 8.48745 9.06382 8.48745 8.58142C8.48745 8.09902 8.85634 7.73013 9.33874 7.73013C9.82114 7.73013 10.19 8.09902 10.19 8.58142C10.19 9.06382 9.82114 9.43271 9.33874 9.43271Z\" fill=\"#5F5F5F\"/>\r\n</svg>', NULL),
(4, 'popular.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\">\r\n<path d=\"M9.14644 1.70824C9.08098 1.72901 8.93956 1.83236 8.83255 1.93938C8.50835 2.26009 8.48077 2.56368 8.73251 2.96033C8.7704 3.0258 8.736 3.10174 8.35646 3.7847C8.12532 4.20213 7.92874 4.5471 7.92176 4.55391C7.91477 4.56421 7.67333 4.4022 7.39051 4.19864L6.86973 3.82608L6.89051 3.69148C6.92839 3.46383 6.84564 3.25695 6.63178 3.04308C6.26271 2.67402 5.89016 2.67402 5.52458 3.04308C5.26585 3.30181 5.20039 3.51218 5.28995 3.81578C5.34511 3.99857 5.6728 4.33656 5.82801 4.37112C5.89016 4.38142 5.93834 4.4022 5.93834 4.40901C5.93834 4.41931 6.04187 5.04029 6.16599 5.78872L6.39365 7.15115L6.3212 7.33045C6.15569 7.74089 6.10035 8.0375 6.10035 8.54466C6.09686 9.22081 6.2072 9.63474 6.55566 10.2348C6.76952 10.6073 7.33866 11.1765 7.70423 11.3903L7.97326 11.5455L7.66966 11.6869C6.3624 12.2975 5.46558 13.5082 5.28261 14.9087C5.26533 15.0501 5.24805 15.978 5.24805 16.968V18.772H9.39138H13.5307L13.5169 16.7989C13.5066 15.1258 13.4928 14.7879 13.4479 14.5913C13.1236 13.2603 12.306 12.2461 11.0953 11.6805L10.7882 11.5391L10.9607 11.4493C11.2126 11.3217 11.5195 11.0803 11.7748 10.8078C12.0508 10.518 12.1679 10.349 12.3474 9.99019C12.744 9.20021 12.7992 8.36903 12.5096 7.4963L12.3854 7.13073L12.6131 5.7786C12.7372 5.03348 12.8373 4.41948 12.8373 4.40918C12.8373 4.4022 12.8856 4.3816 12.9476 4.3713C13.1028 4.33673 13.4305 3.99874 13.4857 3.81595C13.5373 3.63666 13.5373 3.55373 13.4857 3.37444C13.4305 3.18467 13.1096 2.86396 12.92 2.80879C12.6164 2.71906 12.406 2.7847 12.1438 3.04343C11.93 3.25729 11.8472 3.46435 11.8851 3.69183L11.9059 3.82643L11.3851 4.19532C11.0988 4.39888 10.8608 4.56089 10.8538 4.55408C10.8469 4.54727 10.6503 4.2023 10.4193 3.78488C10.0399 3.10192 10.0054 3.02597 10.0433 2.96051C10.295 2.56386 10.2674 2.26026 9.94323 1.93956C9.68101 1.68065 9.45004 1.61169 9.14644 1.70824ZM9.59494 2.28436C9.70179 2.39137 9.68799 2.60506 9.57417 2.69479C9.37759 2.85 9.11188 2.73268 9.11188 2.48792C9.11188 2.30862 9.2051 2.21539 9.38789 2.21539C9.48094 2.21539 9.55008 2.23949 9.59494 2.28436ZM6.28349 3.38805C6.45248 3.55705 6.30758 3.87095 6.05933 3.87095C5.89382 3.87095 5.8006 3.77091 5.8006 3.59493C5.8006 3.50188 5.82469 3.43275 5.86956 3.38805C5.91442 3.34319 5.98338 3.3191 6.07643 3.3191C6.16966 3.3191 6.23862 3.34336 6.28349 3.38805ZM10.0778 4.29186C10.371 4.82311 10.6297 5.28523 10.6505 5.31281C10.6815 5.35419 10.8092 5.27493 11.4438 4.82643C11.8577 4.52982 12.2199 4.28488 12.244 4.28488C12.3062 4.28488 12.2957 4.38491 12.1026 5.54396L11.9198 6.61327H9.38789H6.85611L6.67315 5.54396C6.48007 4.38491 6.46959 4.28488 6.53523 4.28488C6.55601 4.28488 6.9146 4.52982 7.33202 4.82643C7.97012 5.28523 8.09093 5.35768 8.12532 5.31281C8.14609 5.28523 8.40465 4.82294 8.69794 4.29186L9.23269 3.32259H9.38789H9.54309L10.0778 4.29186ZM12.9062 3.38805C12.9511 3.43292 12.9752 3.50188 12.9752 3.59493C12.9752 3.77091 12.882 3.87095 12.7165 3.87095C12.5475 3.87095 12.4233 3.74682 12.4233 3.57783C12.4233 3.41232 12.5234 3.3191 12.6993 3.3191C12.7924 3.3191 12.8614 3.34336 12.9062 3.38805ZM11.8991 7.41355C12.2924 8.2655 12.2062 9.33831 11.6887 10.1178C11.5611 10.3076 11.1264 10.7697 11.0712 10.7697C11.0574 10.7697 11.0436 10.5661 11.0436 10.3179C11.0436 9.74176 11.0125 9.63143 10.7676 9.38649C10.4986 9.11397 10.4572 9.10716 9.31893 9.12095C8.26341 9.13125 8.23932 9.13824 7.99787 9.37968C7.78052 9.59703 7.74945 9.69358 7.73915 10.2592C7.73216 10.542 7.71505 10.7697 7.70126 10.7697C7.64609 10.7697 7.22518 10.3247 7.09756 10.1351C6.76638 9.63492 6.64906 9.23478 6.64906 8.5794C6.64557 8.04466 6.69044 7.8205 6.87671 7.41355L6.98356 7.1824H9.38789H11.792L11.8991 7.41355ZM10.4226 9.73495C10.4881 9.80042 10.4916 9.84878 10.4916 10.4558V11.1077L10.357 11.1594C9.84302 11.3662 8.99787 11.3662 8.43223 11.1629L8.28384 11.1077V10.456C8.28384 9.84896 8.28733 9.8006 8.3528 9.73513C8.41827 9.66966 8.46662 9.66617 9.38754 9.66617C10.3088 9.66599 10.3572 9.66949 10.4226 9.73495ZM10.0812 11.9254C11.3608 12.1496 12.375 13.012 12.7924 14.2365C12.9579 14.7264 12.9752 14.9403 12.9752 16.6372V18.2205H9.38789H5.8006V16.6372C5.8006 15.4024 5.8109 14.9919 5.85227 14.7676C6.10751 13.3016 7.21139 12.191 8.67385 11.9254C9.01533 11.8633 9.73286 11.8633 10.0812 11.9254Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M15.7209 1.69828C15.3242 1.79832 14.9447 2.1192 14.7586 2.51916C14.662 2.72272 14.6482 2.7847 14.6482 3.04692C14.6482 3.31595 14.6585 3.36082 14.7793 3.60226L14.907 3.86448V5.10977V6.35506H14.493H14.0791V7.18292V8.01078H14.3551H14.6311V12.9088V17.8069L15.3176 18.3243L16.0075 18.8418L16.6975 18.321L17.3907 17.8036V12.9088V8.01078H17.6667H17.9422V7.18292V6.35506H17.5283H17.1144V5.10977V3.86448L17.2455 3.60226C17.3628 3.36082 17.3731 3.31595 17.3731 3.04692C17.3731 2.7847 17.3593 2.72272 17.2628 2.51916C17.0351 2.03627 16.5833 1.71207 16.0969 1.681C15.9623 1.67419 15.7966 1.681 15.7209 1.69828ZM16.3244 2.26741C17.0073 2.50886 17.0073 3.57817 16.3244 3.81962C15.6276 4.06455 15.0204 3.47814 15.2205 2.7538C15.2689 2.58131 15.5068 2.32957 15.6828 2.26741C15.8658 2.20195 16.1383 2.20195 16.3244 2.26741ZM16.0105 4.40254C16.2071 4.40254 16.3452 4.38177 16.4347 4.34388L16.5623 4.28871V5.32346V6.35488H16.0105H15.4586V5.32346V4.28871L15.5898 4.34388C15.676 4.38194 15.8139 4.40254 16.0105 4.40254ZM17.3904 7.18275V7.45876H16.0107H14.631V7.18275V6.90673H16.0107H17.3904V7.18275ZM15.7347 11.1841V14.3575H16.0107H16.2867V11.1841V8.01078H16.5627H16.8387V12.7709V17.5276L16.4248 17.8414L16.0108 18.1553L15.5969 17.8414L15.183 17.5276V12.7709V8.01078H15.459H15.735V11.1841H15.7347Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M1.84017 3.72287C0.915759 5.58547 0.833008 5.77874 0.833008 6.15461C0.833008 6.74103 1.20906 7.39641 1.73332 7.72409L1.93688 7.84822V13.3086V18.7725H2.76475H3.59261V13.3086V7.8484L3.79617 7.72427C4.25148 7.44145 4.59296 6.92399 4.6689 6.39623C4.70347 6.16509 4.69998 6.07535 4.65162 5.83391C4.60326 5.57518 4.49991 5.34752 3.68915 3.72287C3.19247 2.72252 2.77505 1.90496 2.76475 1.90496C2.75445 1.90496 2.33702 2.72252 1.84017 3.72287ZM3.45103 4.48858L4.1202 5.83041L4.13399 6.09944C4.16157 6.56505 3.99258 6.9411 3.6373 7.21362C3.20958 7.5448 2.31957 7.5448 1.89184 7.21362C1.53657 6.9411 1.36758 6.56505 1.39516 6.09944L1.40895 5.83041L2.07812 4.48858C2.44369 3.75045 2.75427 3.14675 2.76457 3.14675C2.77487 3.14675 3.08545 3.75045 3.45103 4.48858ZM3.04059 13.1155V18.2206H2.76457H2.48856V13.1155V8.01041H2.76457H3.04059V13.1155Z\" fill=\"#5F5F5F\"/>\r\n</svg>', NULL),
(5, 'gift.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\">\r\n<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M13.3291 2.25375C13.2161 2.14068 13.0243 2.14068 12.9112 2.25375L11.4981 3.66686H14.596C14.6043 3.58575 14.5768 3.50143 14.5125 3.43708L13.3291 2.25375ZM12.2041 1.54664C12.7077 1.04305 13.5326 1.04305 14.0362 1.54664L15.2196 2.72998C15.4784 2.98879 15.6045 3.32899 15.5971 3.66691H16.2497C16.9683 3.66691 17.5381 3.89102 17.9192 4.32779C18.2894 4.75217 18.4163 5.3035 18.4163 5.83358V6.66691C18.4163 7.19699 18.2894 7.74832 17.9192 8.17269C17.713 8.40904 17.4515 8.58311 17.1411 8.6931V15.0002C17.1411 16.2779 16.9346 17.2889 16.2655 17.958C15.5964 18.6271 14.5855 18.8336 13.3078 18.8336H6.64111C5.36341 18.8336 4.35251 18.6271 3.68339 17.958C3.01428 17.2889 2.80778 16.2779 2.80778 15.0002V8.68233C2.50722 8.5718 2.25548 8.40057 2.05757 8.1682C1.69197 7.73895 1.58301 7.18477 1.58301 6.66691V5.83358C1.58301 5.31572 1.69197 4.76154 2.05757 4.33229C2.43624 3.8877 3.01192 3.66691 3.74967 3.66691H4.39337C4.38599 3.32899 4.51213 2.98879 4.77094 2.72998L5.95428 1.54664C6.45787 1.04305 7.28279 1.04305 7.78638 1.54664L9.90663 3.66691H10.0839L12.2041 1.54664ZM6.66138 2.25375C6.77445 2.14068 6.9662 2.14068 7.07927 2.25375L8.49237 3.66686H5.3945C5.38623 3.58575 5.4137 3.50143 5.47805 3.43708L6.66138 2.25375ZM2.81886 4.9807C2.66988 5.15562 2.58301 5.43477 2.58301 5.83358V6.66691C2.58301 7.06572 2.66988 7.34487 2.81886 7.51979C2.95478 7.67936 3.21243 7.83358 3.74967 7.83358H16.2497C16.756 7.83358 17.0196 7.68268 17.1656 7.51529C17.3225 7.3355 17.4163 7.0535 17.4163 6.66691V5.83358C17.4163 5.44699 17.3225 5.16499 17.1656 4.98519C17.0196 4.81781 16.756 4.66691 16.2497 4.66691H3.74967C3.21243 4.66691 2.95478 4.82112 2.81886 4.9807ZM3.80778 8.83358V15.0002C3.80778 16.2225 4.01795 16.8783 4.3905 17.2509C4.76305 17.6234 5.41881 17.8336 6.64111 17.8336H13.3078C14.5301 17.8336 15.1859 17.6234 15.5584 17.2509C15.931 16.8783 16.1411 16.2225 16.1411 15.0002V8.83358H12.9742V12.6086C12.9742 13.6772 11.7853 14.303 10.9052 13.7163L10.903 13.7148L10.1635 13.2163L10.1627 13.2157C10.0586 13.1468 9.91722 13.1423 9.79727 13.2191L9.01615 13.7343L9.01094 13.7377L9.01092 13.7377C8.12648 14.3054 6.94922 13.6868 6.94922 12.6169V8.83358H3.80778ZM7.94922 8.83358V12.6169C7.94922 12.8795 8.23689 13.0441 8.46869 12.8975L9.24889 12.3829L9.25255 12.3804L9.25256 12.3805C9.69866 12.0918 10.2728 12.0873 10.7182 12.3842L10.7204 12.3857L11.4599 12.8842L11.4607 12.8848C11.6805 13.0304 11.9742 12.8729 11.9742 12.6086V8.83358H7.94922Z\" fill=\"#5F5F5F\"/>\r\n</svg>', NULL),
(6, 'gadget.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\">\r\n<path d=\"M16.5625 11.9062V5.9375C16.5625 5.53125 16.3125 5.1875 15.9375 5.0625V3.6875C16.3125 3.5625 16.5625 3.21875 16.5625 2.8125C16.5625 2.28125 16.1562 1.875 15.625 1.875C15.0938 1.875 14.6875 2.28125 14.6875 2.8125C14.6875 3.21875 14.9375 3.5625 15.3125 3.6875V5.0625C14.9375 5.1875 14.6875 5.53125 14.6875 5.9375V11.875H5.3125V5.9375C5.3125 5.53125 5.0625 5.1875 4.6875 5.0625V3.6875C5.0625 3.5625 5.3125 3.21875 5.3125 2.8125C5.3125 2.28125 4.90625 1.875 4.375 1.875C3.84375 1.875 3.4375 2.28125 3.4375 2.8125C3.4375 3.21875 3.6875 3.5625 4.0625 3.6875V5.0625C3.6875 5.1875 3.4375 5.53125 3.4375 5.9375V11.9062C2.03125 12.0625 0.9375 13.25 0.9375 14.6875V16.5625C0.9375 16.75 1.0625 16.875 1.25 16.875H1.875V17.8125C1.875 18 2 18.125 2.1875 18.125H17.8125C18 18.125 18.125 18 18.125 17.8125V16.875H18.75C18.9375 16.875 19.0625 16.75 19.0625 16.5625V14.6875C19.0625 13.25 17.9688 12.0625 16.5625 11.9062ZM15.625 2.5C15.8125 2.5 15.9375 2.625 15.9375 2.8125C15.9375 3 15.8125 3.125 15.625 3.125C15.4375 3.125 15.3125 3 15.3125 2.8125C15.3125 2.625 15.4375 2.5 15.625 2.5ZM15.3125 5.9375C15.3125 5.75 15.4375 5.625 15.625 5.625C15.8125 5.625 15.9375 5.75 15.9375 5.9375V11.875H15.3125V5.9375ZM4.375 2.5C4.5625 2.5 4.6875 2.625 4.6875 2.8125C4.6875 3 4.5625 3.125 4.375 3.125C4.1875 3.125 4.0625 3 4.0625 2.8125C4.0625 2.625 4.1875 2.5 4.375 2.5ZM4.0625 5.9375C4.0625 5.75 4.1875 5.625 4.375 5.625C4.5625 5.625 4.6875 5.75 4.6875 5.9375V11.875H4.0625V5.9375ZM17.5 17.5H2.5V16.875H17.5V17.5ZM18.4375 16.25H17.8125H2.1875H1.5625V14.6875C1.5625 13.4688 2.53125 12.5 3.75 12.5H5H15H16.25C17.4688 12.5 18.4375 13.4688 18.4375 14.6875V16.25Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M4.375 13.4375C3.84375 13.4375 3.4375 13.8438 3.4375 14.375C3.4375 14.9062 3.84375 15.3125 4.375 15.3125C4.90625 15.3125 5.3125 14.9062 5.3125 14.375C5.3125 13.8438 4.90625 13.4375 4.375 13.4375ZM4.375 14.6875C4.1875 14.6875 4.0625 14.5625 4.0625 14.375C4.0625 14.1875 4.1875 14.0625 4.375 14.0625C4.5625 14.0625 4.6875 14.1875 4.6875 14.375C4.6875 14.5625 4.5625 14.6875 4.375 14.6875Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M7.1875 13.4375C6.65625 13.4375 6.25 13.8438 6.25 14.375C6.25 14.9062 6.65625 15.3125 7.1875 15.3125C7.71875 15.3125 8.125 14.9062 8.125 14.375C8.125 13.8438 7.71875 13.4375 7.1875 13.4375ZM7.1875 14.6875C7 14.6875 6.875 14.5625 6.875 14.375C6.875 14.1875 7 14.0625 7.1875 14.0625C7.375 14.0625 7.5 14.1875 7.5 14.375C7.5 14.5625 7.375 14.6875 7.1875 14.6875Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M10 13.4375C9.46875 13.4375 9.0625 13.8438 9.0625 14.375C9.0625 14.9062 9.46875 15.3125 10 15.3125C10.5312 15.3125 10.9375 14.9062 10.9375 14.375C10.9375 13.8438 10.5312 13.4375 10 13.4375ZM10 14.6875C9.8125 14.6875 9.6875 14.5625 9.6875 14.375C9.6875 14.1875 9.8125 14.0625 10 14.0625C10.1875 14.0625 10.3125 14.1875 10.3125 14.375C10.3125 14.5625 10.1875 14.6875 10 14.6875Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M12.8125 13.4375C12.2812 13.4375 11.875 13.8438 11.875 14.375C11.875 14.9062 12.2812 15.3125 12.8125 15.3125C13.3438 15.3125 13.75 14.9062 13.75 14.375C13.75 13.8438 13.3438 13.4375 12.8125 13.4375ZM12.8125 14.6875C12.625 14.6875 12.5 14.5625 12.5 14.375C12.5 14.1875 12.625 14.0625 12.8125 14.0625C13 14.0625 13.125 14.1875 13.125 14.375C13.125 14.5625 13 14.6875 12.8125 14.6875Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M15.625 13.4375C15.0938 13.4375 14.6875 13.8438 14.6875 14.375C14.6875 14.9062 15.0938 15.3125 15.625 15.3125C16.1562 15.3125 16.5625 14.9062 16.5625 14.375C16.5625 13.8438 16.1562 13.4375 15.625 13.4375ZM15.625 14.6875C15.4375 14.6875 15.3125 14.5625 15.3125 14.375C15.3125 14.1875 15.4375 14.0625 15.625 14.0625C15.8125 14.0625 15.9375 14.1875 15.9375 14.375C15.9375 14.5625 15.8125 14.6875 15.625 14.6875Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M9.0625 10C9.0625 10.5312 9.46875 10.9375 10 10.9375C10.5312 10.9375 10.9375 10.5312 10.9375 10C10.9375 9.46875 10.5312 9.0625 10 9.0625C9.46875 9.0625 9.0625 9.46875 9.0625 10ZM10.3125 10C10.3125 10.1875 10.1875 10.3125 10 10.3125C9.8125 10.3125 9.6875 10.1875 9.6875 10C9.6875 9.8125 9.8125 9.6875 10 9.6875C10.1875 9.6875 10.3125 9.8125 10.3125 10Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M11.2812 8.9375C11.375 8.9375 11.4375 8.90625 11.5 8.84375C11.625 8.71875 11.625 8.53125 11.5 8.40625C11.0938 8.03125 10.5625 7.8125 10.0312 7.8125C9.5 7.8125 8.9375 8.03125 8.5625 8.40625C8.4375 8.53125 8.4375 8.71875 8.5625 8.84375C8.6875 8.96875 8.875 8.96875 9 8.84375C9.28125 8.5625 9.65625 8.4375 10.0625 8.4375C10.4688 8.4375 10.8437 8.59375 11.125 8.84375C11.125 8.90625 11.1875 8.9375 11.2812 8.9375Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M12.1254 8.03125C12.2192 8.03125 12.2817 8 12.3442 7.9375C12.4692 7.8125 12.4692 7.625 12.3129 7.5C11.6879 6.875 10.8754 6.5625 10.0004 6.5625C9.12542 6.5625 8.31292 6.875 7.65667 7.46875C7.53167 7.59375 7.53167 7.78125 7.62542 7.90625C7.75042 8.03125 7.93792 8.03125 8.06292 7.9375C8.59417 7.46875 9.25042 7.1875 9.96917 7.1875C10.6879 7.1875 11.3442 7.46875 11.8754 7.9375C11.9692 8 12.0317 8.03125 12.1254 8.03125Z\" fill=\"#5F5F5F\"/>\r\n<path d=\"M7.25042 7.03125C8.00042 6.34375 8.96917 5.9375 10.0004 5.9375C11.0317 5.9375 12.0004 6.3125 12.7504 7.03125C12.8129 7.09375 12.8754 7.125 12.9692 7.125C13.0629 7.125 13.1254 7.09375 13.1879 7.03125C13.3129 6.90625 13.3129 6.71875 13.1567 6.59375C12.2817 5.78125 11.1567 5.34375 9.96917 5.34375C8.78167 5.34375 7.65667 5.78125 6.78167 6.59375C6.65667 6.71875 6.65667 6.90625 6.75042 7.03125C6.93792 7.125 7.12542 7.125 7.25042 7.03125Z\" fill=\"#5F5F5F\"/>\r\n</svg>', NULL),
(7, 'favorite.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\">\r\n<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M9.99417 4.24742C9.19892 3.54902 8.15273 3.125 7.00663 3.125C4.51768 3.125 2.5 5.12475 2.5 7.59157C2.5 8.7275 2.92199 9.77017 3.62666 10.5583L10 16.875L16.1847 10.7453L16.3675 10.5526C17.0722 9.76433 17.5 8.7275 17.5 7.59157C17.5 5.12475 15.4823 3.125 12.9933 3.125C11.8472 3.125 10.8011 3.54902 10.0058 4.24743L10 4.24165L9.99417 4.24742ZM10 5.91615L10.0458 5.95629L10.7566 5.25173L10.8307 5.18666C11.4057 4.68172 12.161 4.375 12.9933 4.375C14.8025 4.375 16.25 5.82561 16.25 7.59157C16.25 8.40108 15.9488 9.1395 15.4469 9.70675L15.291 9.87108L10 15.1151L4.53562 9.69925C4.04494 9.13817 3.75 8.40075 3.75 7.59157C3.75 5.82561 5.19749 4.375 7.00663 4.375C7.83896 4.375 8.59433 4.68172 9.16933 5.18665L9.24342 5.25169L9.95433 5.95627L10 5.91615Z\" fill=\"#5F5F5F\"/>\r\n</svg>', NULL),
(9, 'kid.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\">\r\n<g >\r\n<path d=\"M9.99995 17.0201C8.40504 17.0201 6.84386 16.4704 5.60403 15.4724C4.46845 14.5583 3.63945 13.3028 3.2453 11.9098C2.9223 12.0908 2.56135 12.1853 2.18508 12.1853C0.980183 12.1853 0 11.2051 0 10.0002C0 8.79537 0.980183 7.81519 2.18508 7.81519C2.56135 7.81519 2.9223 7.90962 3.2453 8.0906C3.63945 6.69766 4.46845 5.44216 5.60403 4.52808C5.9362 4.26073 6.29129 4.02565 6.66407 3.82459C6.67828 3.8146 6.69396 3.80607 6.71083 3.79938C6.71147 3.79911 6.71202 3.79892 6.71266 3.79865C7.71925 3.26579 8.85089 2.98047 10 2.98047C11.595 2.98047 13.1561 3.53011 14.3961 4.52817C15.5316 5.44225 16.3606 6.69775 16.7547 8.0906C17.0776 7.90962 17.4387 7.81528 17.8149 7.81528C19.0198 7.81528 20 8.79546 20 10.0004C20 11.2053 19.0198 12.1854 17.8149 12.1854C17.4387 12.1854 17.0777 12.091 16.7547 11.91C16.3606 13.303 15.5316 14.5585 14.3961 15.4725C13.156 16.4704 11.5949 17.0201 9.99995 17.0201ZM3.38695 11.3117C3.41262 11.3117 3.43848 11.316 3.46332 11.3248C3.53713 11.3508 3.59251 11.4128 3.61029 11.4891C4.3036 14.4758 6.93114 16.5617 9.99995 16.5617C13.0689 16.5617 15.6965 14.4758 16.3896 11.4891C16.4073 11.4128 16.4628 11.3509 16.5366 11.3248C16.6104 11.2988 16.6924 11.3121 16.7541 11.3603C17.061 11.6 17.4278 11.7268 17.8148 11.7268C18.767 11.7268 19.5415 10.9523 19.5415 10.0002C19.5415 9.04814 18.767 8.27351 17.8148 8.27351C17.4277 8.27351 17.0608 8.40022 16.7541 8.64006C16.6924 8.68828 16.6103 8.70167 16.5366 8.67554C16.4628 8.6495 16.4074 8.58752 16.3896 8.51124C16.0981 7.2551 15.4643 6.15811 14.5994 5.30885C14.3507 5.35753 12.9212 5.59279 11.2925 4.95835C9.87783 4.40715 9.21011 3.76216 8.99153 3.51489C8.70548 3.55853 8.42484 3.6206 8.15153 3.69991C8.3591 3.9811 8.85107 4.53449 9.82997 5.10926C11.2371 5.93541 12.6079 5.86472 12.6213 5.86381C12.7481 5.85574 12.8562 5.95265 12.8637 6.07899C12.8712 6.20533 12.7748 6.31388 12.6485 6.3214C12.5869 6.32488 11.1238 6.40061 9.59792 5.5045C8.411 4.80753 7.88171 4.13228 7.69697 3.85008C7.49463 3.92526 7.29686 4.01016 7.10424 4.10423C7.27908 4.39303 7.72337 4.99841 8.67679 5.66788C10.0065 6.6014 11.3844 6.64586 11.3981 6.64614C11.5246 6.64925 11.6248 6.75423 11.6217 6.88066C11.6189 7.00709 11.5173 7.1084 11.3878 7.10446C11.3261 7.10309 9.86188 7.05999 8.41338 6.04295C7.37855 5.31673 6.89548 4.6535 6.69863 4.32069C5.17532 5.20323 4.03304 6.68969 3.61029 8.51134C3.5926 8.58762 3.53713 8.6495 3.46332 8.67563C3.3897 8.70176 3.30756 8.68847 3.24585 8.64015C2.9389 8.4004 2.57207 8.2736 2.18508 8.2736C1.23295 8.2736 0.458415 9.04814 0.458415 10.0002C0.458415 10.9523 1.23295 11.7268 2.18508 11.7268C2.57217 11.7268 2.93899 11.6001 3.24585 11.3603C3.28674 11.3284 3.33662 11.3117 3.38695 11.3117ZM9.58105 3.45181C9.89773 3.72989 10.4876 4.15282 11.4588 4.53129C12.5824 4.96898 13.6148 4.95752 14.151 4.90755C13.0138 3.98073 11.5642 3.43879 9.99995 3.43879C9.85931 3.43879 9.71977 3.4431 9.58105 3.45181ZM9.99995 15.5806C8.26779 15.5806 6.75034 14.7321 5.92712 13.4698C5.91612 13.4563 5.90649 13.4416 5.8987 13.4258C5.5008 12.7987 5.27305 12.0719 5.27305 11.2981C5.27305 11.1715 5.37565 11.0689 5.50226 11.0689H14.4976C14.6243 11.0689 14.7269 11.1715 14.7269 11.2981C14.7269 12.0722 14.499 12.7991 14.1008 13.4264C14.0931 13.4418 14.0838 13.4562 14.0731 13.4694C13.2501 14.7319 11.7324 15.5806 9.99995 15.5806ZM6.55524 13.5539C7.33262 14.504 8.5873 15.1221 9.99995 15.1221C11.4127 15.1221 12.6675 14.504 13.4448 13.5539H6.55524ZM6.23307 13.0955H13.7669C14.0489 12.6229 14.2235 12.0913 14.2609 11.5272H5.73917C5.77649 12.0913 5.95105 12.6229 6.23307 13.0955ZM17.1149 10.8932C17.0836 10.8932 17.0518 10.8868 17.0214 10.8732C16.9058 10.8215 16.8541 10.6859 16.9057 10.5704L16.9972 10.3658C17.066 10.2121 17.0437 10.0347 16.9391 9.90281L16.8437 9.78252C16.7961 9.72265 16.7816 9.64289 16.8049 9.57009C16.9161 9.22399 17.3469 8.60889 18.179 8.75741C19.008 8.90539 19.2147 9.63775 19.2083 10.0043C19.2061 10.1294 19.1039 10.2295 18.9792 10.2295C18.9777 10.2295 18.9765 10.2295 18.9751 10.2295C18.8488 10.2273 18.7483 10.1235 18.7499 9.99743C18.7503 9.92793 18.735 9.32245 18.0985 9.20877C17.6103 9.12149 17.3772 9.43257 17.2875 9.60447L17.2982 9.61804C17.5095 9.88447 17.5544 10.2428 17.4156 10.5531L17.3241 10.7577C17.2861 10.8426 17.2025 10.8932 17.1149 10.8932ZM2.98886 10.8932C2.90131 10.8932 2.81769 10.8427 2.77955 10.7576L2.68805 10.553C2.54915 10.2427 2.59426 9.88438 2.8055 9.61795L2.81623 9.60447C2.72564 9.43037 2.4924 9.12194 2.0052 9.20877C1.36819 9.32255 1.35333 9.92885 1.35379 9.99761C1.35452 10.1237 1.25331 10.2274 1.12724 10.2288C1.00301 10.232 0.897668 10.1304 0.895376 10.0044C0.888958 9.63784 1.0957 8.90557 1.9247 8.7575C2.75727 8.60852 3.18763 9.22399 3.29875 9.57018C3.32213 9.64298 3.30765 9.72265 3.26006 9.78261L3.16471 9.9029C3.06001 10.0348 3.03773 10.2122 3.10649 10.3659L3.19799 10.5704C3.24961 10.686 3.1979 10.8216 3.08229 10.8733C3.05194 10.8867 3.02013 10.8932 2.98886 10.8932ZM13.4848 9.61712C13.3864 9.61712 13.2955 9.55313 13.2654 9.4542C13.2566 9.42551 13.0464 8.76906 12.3847 8.76906C11.7367 8.76906 11.5833 9.41029 11.577 9.43761C11.549 9.56056 11.4267 9.63867 11.3038 9.61107C11.1806 9.58375 11.1026 9.46273 11.1293 9.33951C11.2062 8.98369 11.5676 8.31064 12.3847 8.31064C13.1908 8.31064 13.6006 8.97259 13.7046 9.32264C13.7407 9.44394 13.6716 9.57156 13.5502 9.60768C13.5285 9.61401 13.5064 9.61712 13.4848 9.61712ZM8.64644 9.61712C8.54128 9.61712 8.44657 9.54424 8.42292 9.43752C8.41668 9.41001 8.2632 8.76906 7.61519 8.76906C6.95305 8.76906 6.74301 9.42624 6.73439 9.45429C6.69735 9.57477 6.57 9.64362 6.4488 9.60676C6.32814 9.57027 6.25947 9.44357 6.29532 9.32264C6.39938 8.97259 6.80911 8.31064 7.61519 8.31064C8.43227 8.31064 8.79368 8.98359 8.8706 9.33951C8.89737 9.46328 8.8188 9.58522 8.69503 9.61199C8.6788 9.61538 8.66248 9.61712 8.64644 9.61712Z\" fill=\"#5F5F5F\"/>\r\n</g>\r\n<defs>\r\n<clipPath >\r\n<rect width=\"20\" height=\"20\" fill=\"white\"/>\r\n</clipPath>\r\n</defs>\r\n</svg>', NULL),
(10, 'accessories.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\">\n<path d=\"M24 17C24 21.9706 19.9706 26 15 26C10.0294 26 6 21.9706 6 17C6 13.3034 8.2328 10.1342 11.4198 8.749L11.772 9.023L13.3198 10.2268C10.2732 10.9844 8 13.7222 8 17C8 20.8598 11.1402 24 15 24C18.8598 24 22 20.8598 22 17C22 13.7222 19.7268 10.9844 16.6802 10.2268L18.5802 8.7492C21.7672 10.1344 24 13.3034 24 17ZM15 9L20 5.111L18 2H12L10 5.111L13 7.4444L15 9Z\" fill=\"#231F20\"/>\n</svg>', NULL),
(11, 'apparels.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\">\r\n<path d=\"M13.5005 12.5C13.7766 12.5 14.0004 12.2761 14.0004 12C14.0004 11.7238 13.7766 11.5 13.5005 11.5C13.2243 11.5 13.0005 11.7238 13.0005 12C13.0005 12.2761 13.2243 12.5 13.5005 12.5Z\" fill=\"#231F20\"/>\r\n<path d=\"M13.5005 16C13.7766 16 14.0004 15.7761 14.0004 15.5C14.0004 15.2238 13.7766 15 13.5005 15C13.2243 15 13.0005 15.2238 13.0005 15.5C13.0005 15.7761 13.2243 16 13.5005 16Z\" fill=\"#231F20\"/>\r\n<path d=\"M13.5005 19.5C13.7766 19.5 14.0004 19.2761 14.0004 19C14.0004 18.7238 13.7766 18.5 13.5005 18.5C13.2243 18.5 13.0005 18.7238 13.0005 19C13.0005 19.2761 13.2243 19.5 13.5005 19.5Z\" fill=\"#231F20\"/>\r\n<path d=\"M13.5005 23C13.7766 23 14.0004 22.7761 14.0004 22.5C14.0004 22.2238 13.7766 22 13.5005 22C13.2243 22 13.0005 22.2238 13.0005 22.5C13.0005 22.7761 13.2243 23 13.5005 23Z\" fill=\"#231F20\"/>\r\n<path d=\"M22.5 12.5H18.5C18.2238 12.5 18 12.7238 18 13V18C18 18.2761 18.2238 18.4999 18.5 18.4999H22.5C22.7762 18.4999 23 18.2761 23 18V13C23 12.7238 22.7762 12.5 22.5 12.5ZM22 17.5H19V13.5H22V17.5Z\" fill=\"#231F20\"/>\r\n<path d=\"M27.5002 5.50002H26V3.99979C26 3.1715 25.3285 2.49978 24.5 2.49978H19.44C19.4387 2.49978 19.4375 2.4999 19.4362 2.4999H19.4245C18.9647 1.00658 16.4621 0 13.5002 0C10.5383 0 8.03576 1.00658 7.57604 2.4999H7.56432C7.56303 2.4999 7.5618 2.49978 7.56051 2.49978H2.5C1.67184 2.49978 1 3.17162 1 3.99979V25.4998C1 26.3283 1.67172 26.9998 2.5 26.9998H4.00023V28.5C4.00023 29.3286 4.6716 30 5.50023 30H27.5003C28.3289 30 29.0003 29.3286 29.0003 28.5V7.00002C29.0002 6.17139 28.3289 5.50002 27.5002 5.50002ZM7.56238 3.49992C7.70131 3.50045 7.83449 3.55934 7.92906 3.6624L10.5141 6.48246L9.47348 8.82791L6.80951 3.49992H7.56238ZM19.0714 3.66229C19.166 3.55928 19.2992 3.50045 19.438 3.49992H20.1909L17.527 8.82791L16.4863 6.48246L19.0714 3.66229ZM13.5002 1.00002C16.1329 1.00002 18.2451 1.89146 18.4787 2.82861L15.5279 6.04805L15.5278 6.04811L13.8682 7.85854C13.67 8.07398 13.3304 8.07398 13.1322 7.85854L11.4726 6.04811C11.4726 6.04811 11.4726 6.04805 11.4725 6.04805L8.52168 2.82861C8.75535 1.89146 10.8675 1.00002 13.5002 1.00002ZM1.99996 25.4998V3.99979C1.99996 3.72393 2.22408 3.4998 2.49994 3.4998H5.69137L9.05324 10.2235C9.24227 10.6016 9.78607 10.5891 9.95746 10.2027L11.2513 7.28666L12.3943 8.53365C12.3947 8.53412 12.3952 8.53453 12.3956 8.535L13.1315 9.33785C13.3297 9.55406 13.6705 9.55406 13.8687 9.33785L14.6047 8.53494C14.6051 8.53453 14.6055 8.53412 14.6059 8.53365L15.749 7.2866L17.0429 10.2026C17.2143 10.589 17.758 10.6015 17.9471 10.2234L21.3091 3.4998H24.5C24.7762 3.4998 25 3.72375 25 3.99979V25.4998C25 25.7761 24.7763 25.9997 24.5 25.9997H2.5C2.22391 25.9998 1.99996 25.776 1.99996 25.4998ZM28.0002 28.5C28.0002 28.7763 27.7766 29 27.5003 29H5.50023C5.22391 29 5.00025 28.7763 5.00025 28.5V27H24.5003C25.3289 27 26.0003 26.3286 26.0003 25.5V6.49998H27.5003C27.7766 6.49998 28.0002 6.72363 28.0002 6.99996V28.5Z\" fill=\"#231F20\"/>\r\n</svg>', NULL);
INSERT INTO `cc_icons` (`icon_id`, `name`, `code`, `path`) VALUES
(12, 'backpacks.svg', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\">\n<path d=\"M13.6969 11.2622L13.8125 10.0403C13.825 9.91216 13.9407 9.81841 14.0688 9.82779C14.1969 9.84029 14.2907 9.95591 14.2813 10.084L14.1657 11.3059C14.1532 11.4278 14.0532 11.5184 13.9313 11.5184C13.925 11.5184 13.9157 11.5184 13.9094 11.5184C13.7782 11.5028 13.6844 11.3903 13.6969 11.2622ZM15.0625 11.4372C15.0657 11.4372 15.0657 11.4372 15.0625 11.4372C15.1938 11.4372 15.2969 11.3309 15.2969 11.1997L15.2844 9.99341C15.2844 9.86529 15.1782 9.76216 15.05 9.76216H15.0469C14.9188 9.76216 14.8125 9.86841 14.8157 9.99966L14.8282 11.2059C14.8313 11.334 14.9344 11.4372 15.0625 11.4372ZM9.82504 16.4278C10.0907 16.209 10.4688 16.1715 11.0938 16.1122H11.1C13.3157 15.8997 15.5688 15.7247 17.7907 15.5965C18.225 15.5715 18.7188 15.5434 19.1969 15.6465C19.7563 15.7684 20.2 16.0559 20.4532 16.459C20.775 16.9778 20.7407 17.6278 20.7125 18.1059L20.5407 21.209C20.5188 21.584 20.4907 22.0965 20.1875 22.4778C19.8125 22.9497 19.2032 23.0465 18.5688 23.0465C18.4844 23.0465 18.4 23.0434 18.3157 23.0434L11.4438 22.8215C10.8782 22.8028 10.2938 22.7528 9.88442 22.359C9.50004 21.9903 9.40629 21.4465 9.36254 20.9153C9.29379 20.0809 9.28442 19.2372 9.33442 18.3965C9.33442 18.3934 9.33442 18.3903 9.33442 18.3872C9.34692 18.1528 9.36567 17.9184 9.38754 17.684C9.45942 17.0372 9.54379 16.6622 9.82504 16.4278ZM20.2282 18.4215C17.3032 18.484 14.375 18.5465 11.45 18.609L11.525 19.5747C11.5375 19.7309 11.5594 20.0215 11.3657 20.2247C11.1844 20.4153 10.9094 20.4215 10.7625 20.4215C10.75 20.4215 10.7375 20.4215 10.725 20.4215C10.5875 20.4215 10.3407 20.4059 10.2032 20.1965C10.1094 20.0559 10.1219 19.8934 10.1313 19.7997L10.2219 18.6372C10.0813 18.6403 9.94067 18.6434 9.80004 18.6465C9.76567 19.3934 9.77817 20.1434 9.83754 20.884C9.87192 21.2934 9.93129 21.7528 10.2157 22.0247C10.5063 22.3028 10.9719 22.3403 11.4657 22.3559L18.3375 22.5778C19.35 22.609 19.65 22.4122 19.825 22.1903C20.0188 21.9434 20.0532 21.5903 20.075 21.184L20.2282 18.4215ZM10.5938 19.934C10.6094 19.9403 10.65 19.9528 10.7532 19.9497C10.8313 19.9497 10.9782 19.9465 11.025 19.8965C11.075 19.8434 11.0625 19.684 11.0563 19.609L10.9782 18.6184C10.8813 18.6215 10.7875 18.6215 10.6907 18.6247L10.5969 19.834C10.5938 19.8559 10.5907 19.9122 10.5938 19.934ZM9.82504 18.1747C13.3 18.0997 16.775 18.0247 20.2532 17.9528C20.275 17.4715 20.2625 17.0434 20.0563 16.7122C19.875 16.4215 19.5282 16.2028 19.1 16.109C18.8782 16.0622 18.6438 16.0465 18.4125 16.0465C18.2094 16.0465 18.0094 16.059 17.8188 16.0684C15.6032 16.1965 13.3563 16.3684 11.1469 16.5809H11.1407C10.6032 16.634 10.2782 16.6653 10.125 16.7903C9.98754 16.9028 9.92192 17.1497 9.86254 17.734C9.84692 17.8809 9.83442 18.0278 9.82504 18.1747ZM5.55317 22.3122C4.62504 17.709 4.78129 12.9747 5.02192 8.51841C5.05942 7.81216 5.11567 7.18091 5.39692 6.59654C5.57192 6.23404 5.83129 5.92154 6.14379 5.67779C6.60942 5.17779 7.30629 4.88716 8.10317 4.59029C8.57192 4.41529 9.13129 4.23091 9.70629 4.19654C10.0719 4.17466 10.9844 4.16841 11.5375 4.58091C11.8032 4.78091 11.9969 4.99966 12.2032 5.27779C12.1969 5.12154 12.1938 4.96529 12.2 4.80904C12.2313 3.96841 12.4907 3.36841 12.9907 2.97779C13.2938 2.74029 13.725 2.59029 14.2094 2.54966C14.5875 2.51841 14.9907 2.49654 15.4 2.55591C15.8438 2.61841 16.3063 2.70279 16.6782 2.98716C17.1313 3.33404 17.3938 3.95591 17.4125 4.73404C17.4125 4.78716 17.4125 4.84029 17.4125 4.89341C17.5719 4.69029 17.7688 4.53091 18.0344 4.39654C18.5782 4.12466 19.0782 4.04654 19.7094 4.01216C20.5969 3.96216 21.3282 4.21841 22.1938 4.55591C23.0594 4.89654 23.7032 5.68091 24.3375 6.52466C24.3563 6.54966 24.3719 6.58091 24.3782 6.60904C24.4907 6.73716 24.5844 6.86841 24.6532 7.00591C24.9875 7.67466 25.0188 8.43716 25.0438 9.11216C25.2032 13.0872 25.3688 17.1997 24.2438 21.1278C23.9219 22.2528 23.4907 23.3559 22.9657 24.409L22.925 25.0372C22.925 25.059 22.9219 25.084 22.9219 25.1153C22.9094 25.3934 22.8875 25.9684 22.6 26.4934C22.1532 27.3153 21.3407 27.4934 20.7219 27.4934C20.7063 27.4934 20.6907 27.4934 20.6782 27.4934C19.0219 27.4715 17.8532 27.4653 16.5 27.4622C15.1719 27.4559 13.6688 27.4528 11.4063 27.4247C11.2625 27.4215 11.0688 27.4278 10.8438 27.4309C9.05942 27.4684 7.26879 27.4403 6.71254 26.684C6.33129 26.1653 6.23754 25.2622 6.22817 24.3434C5.89379 23.5872 5.71254 23.1059 5.55317 22.3122ZM22.4125 24.6965C17.2032 24.4465 11.9219 24.384 6.70317 24.5153C6.72192 25.2809 6.80942 26.0153 7.09379 26.3997C7.22504 26.5747 7.59692 26.8059 8.63442 26.909C9.38442 26.984 10.225 26.9653 10.8375 26.9528C11.0313 26.9497 11.2 26.9465 11.3375 26.9465C11.3625 26.9465 11.3907 26.9465 11.4125 26.9465C13.675 26.9715 15.1782 26.9778 16.5032 26.984C17.8594 26.9903 19.0282 26.9934 20.6844 27.0153C20.6969 27.0153 20.7125 27.0153 20.725 27.0153C22.2 27.0153 22.4188 25.9153 22.4532 25.0872C22.4532 25.0528 22.4563 25.0215 22.4563 24.9965L22.4719 24.7684C22.4782 24.7184 22.5063 24.6965 22.4125 24.6965ZM22.2438 5.99341C22.6375 6.97154 22.9125 8.00279 23.0563 9.06216C23.2157 10.2434 23.2125 11.434 23.0407 12.5997C23.1094 12.9122 23.1657 13.2403 23.2125 13.5872C23.5282 15.9934 23.3657 18.4403 23.2094 20.809L23.0594 23.0903C23.3469 22.4059 23.5969 21.7028 23.8 20.9903C24.9032 17.1372 24.7407 13.0622 24.5813 9.12466C24.5563 8.49966 24.5282 7.79029 24.2375 7.20904C23.9813 6.70279 23.1219 6.16529 22.2438 5.99341ZM21.7125 5.94029C21.6157 5.94029 21.5188 5.94654 21.4219 5.95591C20.4344 6.08091 19.8657 6.44029 19.6469 7.08404C19.9375 7.31841 20.2063 7.57779 20.45 7.85904C21.45 9.00279 22.2 10.0497 22.6844 11.3778C22.775 9.52466 22.4375 7.63716 21.7125 5.94029ZM17.4313 5.87779C17.4438 5.88091 17.4532 5.88404 17.4657 5.88716C18.1125 6.10279 18.7157 6.40904 19.2625 6.79029C19.4125 6.43716 19.6563 6.15279 19.9875 5.94029C20.3438 5.71216 20.7938 5.56529 21.3657 5.49341C21.525 5.47466 21.7 5.47154 21.8813 5.48404C21.8875 5.48404 21.8907 5.48404 21.8969 5.48404C22.2844 5.51216 22.7125 5.61529 23.1188 5.77779C22.7844 5.43091 22.4282 5.14966 22.025 4.99341C21.1875 4.66529 20.5344 4.43716 19.7375 4.48091C19.1532 4.51216 18.7219 4.57779 18.2469 4.81529C17.8563 5.00591 17.6563 5.26216 17.4313 5.87779ZM15.5 3.03716C15.6 3.20591 15.6563 3.37154 15.6844 3.45904C15.7594 3.68716 15.825 3.92466 15.875 4.15904V4.16216C15.975 4.62154 16.025 5.09029 16.025 5.55904C16.3219 5.59654 16.6157 5.65279 16.9032 5.72466C16.9063 5.63091 16.9125 5.53404 16.9188 5.44341C16.9344 5.19966 16.9469 4.97154 16.9407 4.74029C16.9313 4.37154 16.85 3.70279 16.3907 3.35279C16.1532 3.16841 15.8375 3.09029 15.5 3.03716ZM13.9688 3.99029C14.4094 3.94029 14.8969 3.92779 15.3438 3.95279C15.3125 3.83716 15.2782 3.72154 15.2407 3.60904C15.125 3.26529 14.9875 3.07466 14.8188 3.02466C14.6813 2.98404 14.5094 3.04029 14.375 3.16841C14.2219 3.31529 14.1282 3.53091 14.0657 3.70279C14.0282 3.79341 13.9969 3.89029 13.9688 3.99029ZM13.8594 4.47466C13.8 4.83716 13.7907 5.20279 13.825 5.56529C13.8407 5.56216 13.8594 5.56216 13.875 5.55904C14.4375 5.48716 15.0032 5.47154 15.5563 5.51216C15.5532 5.14966 15.5188 4.78404 15.45 4.42779C14.9407 4.39029 14.3594 4.40904 13.8594 4.47466ZM12.7094 5.79966C12.925 5.73716 13.1438 5.68716 13.3625 5.64341C13.3125 5.16841 13.3344 4.69341 13.4282 4.22154C13.4282 4.21841 13.4282 4.21841 13.4282 4.21529V4.21216C13.475 3.98091 13.5407 3.75591 13.6219 3.53716C13.6719 3.39654 13.7407 3.23404 13.8407 3.08091C13.6188 3.14029 13.425 3.22779 13.275 3.34341C12.8907 3.64341 12.6907 4.12779 12.6625 4.82154C12.6563 5.14654 12.6813 5.46529 12.7094 5.79966ZM10.4532 7.43404C10.4375 7.44966 10.4219 7.46216 10.4032 7.47154C9.50004 8.16529 8.75629 9.08091 8.23129 10.1778C7.10317 12.5215 6.84379 14.2497 6.73754 16.8059C6.73754 17.434 6.72817 18.0715 6.71879 18.6872C6.70317 19.834 6.68442 21.0215 6.72817 22.1872C6.73754 22.4559 6.72817 22.7934 6.71567 23.1809C6.70629 23.4528 6.70004 23.7465 6.69692 24.0497C11.95 23.9184 17.2688 23.9809 22.5125 24.234L22.7407 20.7809C22.8969 18.4372 23.0563 16.0122 22.7469 13.6528C22.4282 11.2215 21.5719 9.84966 20.1 8.16841C19.8407 7.87154 19.5563 7.60279 19.2469 7.36216C19.2375 7.35591 19.2282 7.34966 19.2219 7.34341C18.6594 6.90904 18.025 6.57154 17.3157 6.33716C16.2657 5.98716 15.0969 5.87779 13.9344 6.03091C13.4688 6.09029 13.0219 6.19029 12.5907 6.33091C12.5844 6.33404 12.5594 6.34029 12.5532 6.34341C11.7907 6.58716 11.0844 6.95591 10.4532 7.43404ZM8.10942 5.08716C8.14067 5.09029 8.16879 5.09341 8.20004 5.09654C8.30942 5.11216 8.42192 5.13716 8.53442 5.17466H8.53754C8.53754 5.17466 8.53754 5.17466 8.54067 5.17466C9.28129 5.41529 10.0094 6.10279 10.3907 6.89966C10.9282 6.52154 11.5157 6.21529 12.1375 5.98716C11.8 5.49966 11.5938 5.20279 11.2594 4.94966C10.9625 4.72779 10.3938 4.61841 9.73754 4.65904C9.22504 4.69029 8.72817 4.85279 8.27192 5.02466C8.21254 5.04654 8.15942 5.06841 8.10942 5.08716ZM7.85004 9.76529C7.84692 9.80904 7.84692 9.85591 7.84379 9.89966C8.36567 8.83716 9.10942 7.90904 10.0032 7.19341C9.71567 6.54341 9.14692 5.94966 8.55942 5.69029C7.96879 6.68716 7.90942 8.18404 7.85004 9.76529ZM6.01254 22.2215C6.08129 22.559 6.15004 22.8372 6.25004 23.1309C6.25942 22.7809 6.26879 22.4497 6.25942 22.2028C6.21567 21.0247 6.23442 19.8309 6.25004 18.6778C6.25942 18.0622 6.26879 17.4278 6.26879 16.7997C6.26879 16.7965 6.26879 16.7934 6.26879 16.7903C6.35942 14.584 6.56254 12.9809 7.31567 11.084C7.34379 10.634 7.36254 10.184 7.37817 9.74654C7.44067 8.15904 7.49692 6.65279 8.09067 5.55904C7.18442 5.44966 6.21254 5.97779 5.81567 6.79966C5.57192 7.30904 5.52192 7.89029 5.48754 8.54341C5.25317 12.9715 5.09692 17.6715 6.01254 22.2215ZM11.9782 10.9247C11.9 10.8434 11.8907 10.7215 11.9532 10.6278C12.6 9.68091 13.3875 8.84341 14.2907 8.13404C14.3813 8.06216 14.5125 8.06841 14.5969 8.14966C14.8657 8.40279 15.1438 8.64966 15.4125 8.89029C15.9719 9.38716 16.55 9.89654 17.0594 10.4903C17.1407 10.584 17.1344 10.7247 17.0438 10.8122C16.6532 11.1903 16.2657 11.6247 15.8907 12.0434C15.5094 12.4684 15.1188 12.909 14.7125 13.2997C14.6688 13.3434 14.6094 13.3653 14.55 13.3653C14.5032 13.3653 14.4532 13.3497 14.4125 13.3215C13.775 12.8622 13.225 12.2653 12.6438 11.6372C12.4313 11.4028 12.2094 11.1622 11.9782 10.9247ZM12.45 10.7403C12.6344 10.934 12.8157 11.1309 12.9907 11.3184C13.5063 11.8778 13.9969 12.4059 14.5313 12.8247C14.875 12.4809 15.2125 12.1028 15.5407 11.734C15.8688 11.3653 16.2094 10.984 16.5563 10.634C16.1032 10.1372 15.6125 9.70279 15.0969 9.24341C14.875 9.04654 14.6438 8.84341 14.4188 8.63404C13.6719 9.24341 13.0094 9.94966 12.45 10.7403Z\" fill=\"black\"/>\n</svg>', NULL),
(13, 'female-doctor.svg', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<g >\r\n<path d=\"M26.5464 25.1816C26.4274 24.7412 26.2626 24.3466 26.0575 23.9951C25.6987 23.3789 25.2226 22.8992 24.6989 22.5192C24.3052 22.2326 23.8841 22.001 23.4574 21.8005C23.2193 21.6897 22.9813 21.5881 22.7432 21.4929C22.6865 20.8291 21.575 20.289 21.6007 18.3471C21.6135 17.3492 22.5894 15.3844 21.3645 13.7988C21.5165 13.645 21.6593 13.4674 21.7875 13.2623C22.042 12.8631 22.2453 12.3669 22.3825 11.7553C22.421 11.585 22.4393 11.4166 22.4393 11.2499C22.4393 10.9029 22.3569 10.5724 22.2196 10.2758C22.1244 10.0707 22.0017 9.88213 21.8607 9.71185C21.9339 9.44449 22.0218 9.0856 22.0988 8.66449C22.2068 8.08037 22.2965 7.38 22.2965 6.64301C22.2965 6.16693 22.2599 5.67527 22.1629 5.19006C22.0896 4.8266 21.9834 4.4659 21.8333 4.11978C21.608 3.59977 21.2803 3.11086 20.8244 2.70803C20.4014 2.33355 19.8722 2.03602 19.2332 1.84377C18.964 1.5215 18.6857 1.24682 18.3964 1.01795C17.9112 0.629766 17.4003 0.371602 16.8785 0.214102C16.3585 0.0567774 15.8311 0 15.3056 0C15.0273 0 14.7489 0.0164648 14.4724 0.0403125C14.2124 0.0641016 13.9964 0.091582 13.8022 0.123633C13.5129 0.172148 13.2749 0.23625 13.0442 0.316816C12.8134 0.396445 12.5901 0.488965 12.2989 0.604277C12.189 0.647285 12.0426 0.712324 11.8668 0.800215C11.561 0.954961 11.1673 1.18289 10.7444 1.49783C10.1109 1.97021 9.41322 2.63672 8.8676 3.53941C8.59479 3.9917 8.36223 4.5007 8.1974 5.07199C8.03445 5.64234 7.93924 6.27316 7.93924 6.96258C7.93924 7.39195 7.97586 7.84605 8.05643 8.32031C8.05643 8.35512 8.05824 8.38529 8.06012 8.41734C8.06381 8.47688 8.06926 8.53822 8.07477 8.60227C8.08578 8.69748 8.09674 8.79451 8.10588 8.87695C8.10957 8.91814 8.1132 8.95477 8.11502 8.98318C8.11684 8.99783 8.11684 9.00973 8.11871 9.01799V9.02807V9.03082V9.08578L8.2359 9.60217C8.06744 9.78527 7.92277 9.99035 7.81109 10.2146C7.65359 10.5268 7.56025 10.8784 7.56025 11.2519C7.56025 11.4168 7.57859 11.5852 7.61885 11.7555H7.61697C7.71037 12.1638 7.83119 12.5209 7.97586 12.8312C8.16811 13.2441 8.40617 13.5755 8.66984 13.8346C7.48695 15.4139 8.4483 17.3566 8.46107 18.3473C8.48674 20.2644 7.4027 20.8155 7.32031 21.4674C7.30197 21.4765 7.28369 21.483 7.26354 21.4912C6.78014 21.6844 6.2876 21.9041 5.82066 22.1797C5.47092 22.3866 5.13219 22.6246 4.82275 22.9085C4.35764 23.3351 3.95668 23.8652 3.68018 24.5216C3.40186 25.179 3.24805 25.9571 3.24805 26.8754C3.24805 27.0045 3.27553 27.129 3.31947 27.2426C3.3616 27.3497 3.41838 27.4477 3.48611 27.5411C3.61432 27.715 3.77908 27.8697 3.98053 28.0199C4.33578 28.2808 4.80635 28.5262 5.41607 28.756C6.32979 29.1012 7.55293 29.4088 9.13678 29.6349C10.7188 29.8592 12.6597 30.0002 14.9998 30.0002C17.0287 30.0002 18.7572 29.8949 20.2129 29.72C21.3042 29.5891 22.2417 29.4197 23.0382 29.2247C23.6352 29.0792 24.1533 28.9199 24.5983 28.7514C24.9297 28.6251 25.2226 28.4933 25.4753 28.3577C25.6658 28.257 25.8342 28.1527 25.9825 28.0455C26.206 27.8844 26.3854 27.7169 26.5227 27.5283C26.5904 27.4349 26.6454 27.3342 26.6875 27.2243C26.7279 27.1162 26.7516 26.9972 26.7516 26.8755C26.7515 26.2464 26.6801 25.6842 26.5464 25.1816ZM11.2846 6.84633C13.9286 7.43408 18.552 4.6234 18.552 4.6234C18.552 4.6234 18.607 5.90514 19.4877 7.0807C19.8356 7.54395 20.1213 8.26723 20.3355 8.95389C20.2787 8.84584 20.1433 8.8074 19.9418 8.78086C19.4877 8.72045 18.8139 8.68107 18.0558 8.7177C15.8036 8.82756 15.9702 9.03264 15.0858 9.03264C14.2014 9.03264 14.368 8.82756 12.1158 8.7177C11.3577 8.68107 10.6839 8.72045 10.2298 8.78086C10.1529 8.79094 10.0851 8.80377 10.0283 8.82023C10.3068 8.47781 10.7243 7.93764 11.2846 6.84633ZM19.9088 10.3802C19.907 10.3931 19.8978 11.6839 19.0189 12.1271C18.7204 12.2773 18.3469 12.3596 17.966 12.3605C17.5632 12.3605 17.1952 12.2699 16.9022 12.0978C16.5781 11.9074 16.3602 11.6254 16.2522 11.2601C16.2284 11.1749 16.2045 11.0898 16.1807 11.0083C16.1111 10.7575 15.9244 10.0589 16.3217 9.75129C16.5763 9.55172 17.3709 9.42627 18.1326 9.42627C18.8248 9.42627 19.5297 9.51967 19.7366 9.7357C19.8722 9.87674 19.9254 10.1312 19.9088 10.3802ZM13.9909 11.0083C13.9689 11.0898 13.9451 11.1749 13.9194 11.2601C13.8132 11.6254 13.5935 11.9074 13.2712 12.0978C12.9764 12.2699 12.6083 12.3605 12.2074 12.3605C11.8265 12.3596 11.453 12.2772 11.1527 12.1271C10.2738 11.6839 10.2646 10.3931 10.2646 10.3802C10.2482 10.1312 10.3013 9.87668 10.4349 9.7357C10.6437 9.51961 11.3486 9.42627 12.0407 9.42627C12.8006 9.42627 13.5953 9.55172 13.8516 9.75129C14.2491 10.0589 14.0605 10.7575 13.9909 11.0083ZM8.57281 11.5393C8.55084 11.4404 8.53982 11.3452 8.53982 11.2519C8.53982 11.0422 8.59109 10.8435 8.68631 10.6522C8.76506 10.4947 8.87492 10.3455 9.00857 10.21C9.23381 10.5506 9.41873 10.8197 9.48647 10.8875C9.61649 11.0157 9.68059 10.8912 9.68973 10.6513C9.77029 11.187 10.0248 12.0722 10.847 12.5099C12.0317 13.1398 13.8023 12.9036 14.401 11.5028C14.6738 10.8692 14.6775 10.2521 15.0859 10.2521C15.4942 10.2521 15.4997 10.8692 15.7707 11.5028C16.3713 12.9035 18.1401 13.1398 19.3248 12.5099C20.5094 11.88 20.5186 10.3218 20.5186 10.2119C20.5186 10.1561 20.5717 10.113 20.6486 10.1038C20.7494 10.5268 20.8006 10.8143 20.8006 10.8143C20.8006 10.8143 20.9142 10.5982 21.0845 10.3089C21.1852 10.4279 21.2694 10.5561 21.3317 10.6898C21.4159 10.8683 21.4599 11.056 21.4599 11.2501C21.4599 11.3435 21.4488 11.4405 21.4269 11.5395C21.3481 11.8883 21.2493 12.1767 21.1375 12.4165C20.9691 12.7736 20.775 13.0208 20.5736 13.2021C20.3703 13.3833 20.1561 13.5005 19.9309 13.5829L19.7148 13.6617L19.6378 13.8796C19.4035 14.5424 19.1746 15.0752 18.9438 15.5028C18.715 15.9304 18.4861 16.2508 18.248 16.5016L18.1546 16.6005L18.1254 16.7342C18.0191 17.2231 17.9129 17.7633 17.9129 18.4023C17.9129 18.6001 17.9221 18.8051 17.9459 19.0212C17.9716 19.2758 18.0302 19.5138 18.1162 19.7335C18.1217 19.7445 18.1254 19.7537 18.129 19.7646L15.1536 21.3281L11.8559 19.7992C11.9566 19.5611 12.0262 19.3011 12.0554 19.021C12.0774 18.8049 12.0866 18.5998 12.0866 18.4021C12.0866 17.763 11.9822 17.2211 11.8742 16.7321L11.8449 16.6003L11.7515 16.5014C11.5153 16.2496 11.2863 15.9292 11.0557 15.5016C10.8268 15.075 10.5979 14.5421 10.3635 13.8793L10.2866 13.6632L10.0705 13.5826C9.92029 13.5277 9.77568 13.4572 9.63465 13.3629C9.42406 13.221 9.22268 13.0278 9.03957 12.7385C8.85658 12.4502 8.69182 12.063 8.57281 11.5393ZM16.201 21.5534L18.4752 20.3568C18.5393 20.4373 18.6052 20.5151 18.6766 20.5875C18.8268 20.7422 18.9915 20.8777 19.1673 21.0004L16.2339 25.5799L15.908 23.3323L16.7393 22.4506L16.201 21.5534ZM14.3095 23.3322L14.0019 25.4489L10.7921 21.0278C10.8744 20.972 10.9532 20.9143 11.0301 20.8539C11.2023 20.7165 11.3597 20.5618 11.4989 20.3888L14.0148 21.5561L13.4783 22.4505L14.3095 23.3322ZM25.7481 26.9256C25.7151 26.9806 25.6382 27.0721 25.5082 27.1765C25.3947 27.2681 25.2445 27.3687 25.0523 27.4731C24.719 27.6562 24.2649 27.8476 23.6882 28.028C22.8239 28.3008 21.6832 28.5498 20.2421 28.7293C18.8029 28.9087 17.0652 29.0204 14.9998 29.0204C13.0058 29.0204 11.3157 28.9161 9.90395 28.7476C8.84744 28.6204 7.94656 28.4565 7.19398 28.2734C6.63002 28.136 6.15025 27.9859 5.7493 27.8348C5.449 27.7204 5.19447 27.605 4.98576 27.4942C4.82826 27.41 4.69643 27.3267 4.58844 27.2498C4.4273 27.1344 4.32477 27.0301 4.2735 26.9578C4.24783 26.9221 4.23506 26.8964 4.23137 26.8818C4.22955 26.8763 4.22768 26.8726 4.22768 26.8717C4.22768 26.3233 4.28996 25.8546 4.39795 25.4462C4.49135 25.0891 4.62137 24.7797 4.77881 24.506C5.05531 24.0271 5.41783 23.65 5.84814 23.3331C6.17041 23.0951 6.53111 22.8909 6.91385 22.7088C7.48695 22.436 8.1077 22.2144 8.71742 21.9901C9.23012 21.8006 9.73367 21.6101 10.1987 21.3758L15.2671 28.3594L19.7569 21.3519C19.9821 21.4673 20.2147 21.5735 20.4545 21.6724C21.0569 21.9196 21.6996 22.1329 22.3186 22.3792C22.7818 22.5623 23.2341 22.7628 23.6442 23.0017C23.9537 23.1812 24.2393 23.3808 24.4938 23.6106C24.8747 23.9558 25.1878 24.364 25.4112 24.8878C25.6364 25.4115 25.7719 26.0541 25.7719 26.8726C25.7719 26.8763 25.7664 26.8963 25.7481 26.9256Z\" fill=\"#231F20\"/>\r\n<path d=\"M22.5879 26.3193H18.6694V27.006H22.5879V26.3193Z\" fill=\"#231F20\"/>\r\n</g>\r\n<defs>\r\n<clipPath >\r\n<rect width=\"30\" height=\"30\" fill=\"white\"/>\r\n</clipPath>\r\n</defs>\r\n</svg>\r\n', NULL),
(14, 'hand_bags.svg', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<g >\r\n<path d=\"M29.6392 27.9157L26.4471 8.83147C26.2628 7.72991 25.2043 6.83366 24.0874 6.83366H22.0709C21.9428 3.04378 18.8203 0 14.9998 0C11.1792 0 8.05672 3.04378 7.92865 6.83366H5.91215C4.79529 6.83366 3.73667 7.72985 3.55246 8.83147L0.360315 27.9157C0.268272 28.4662 0.402573 28.9879 0.738482 29.3848C1.07439 29.7816 1.56681 30.0001 2.12493 30.0001H27.8745C28.4326 30.0001 28.9251 29.7816 29.261 29.3848C29.597 28.9879 29.7313 28.4662 29.6392 27.9157ZM1.47199 24.4483H14.2793C14.4241 24.4483 14.5415 24.3309 14.5415 24.1861C14.5415 24.0413 14.4241 23.9239 14.2793 23.9239H1.55972L2.91661 15.8115H6.54739C6.69218 15.8115 6.80957 15.6941 6.80957 15.5493C6.80957 15.4045 6.69218 15.2871 6.54739 15.2871H3.00428L3.34321 13.2608H10.3219C10.4667 13.2608 10.5841 13.1434 10.5841 12.9986C10.5841 12.8538 10.4667 12.7364 10.3219 12.7364H3.43093L3.84229 10.2771H26.1573L28.2148 22.5781H22.034C21.8892 22.5781 21.7718 22.6955 21.7718 22.8402C21.7718 22.985 21.8892 23.1024 22.034 23.1024H28.3025L28.5156 24.3762H27.07C26.9252 24.3762 26.8078 24.4936 26.8078 24.6384C26.8078 24.7832 26.9252 24.9006 27.07 24.9006H28.6033L28.8703 26.497H1.1293L1.47199 24.4483ZM14.9998 0.524375C18.5311 0.524375 21.4183 3.33299 21.5461 6.83366H20.309C20.2478 5.50286 19.7037 4.2504 18.7606 3.28351C17.7508 2.24821 16.4152 1.67806 14.9998 1.67806C13.5841 1.67806 12.2485 2.24747 11.239 3.28154C10.295 4.24843 9.75076 5.50168 9.69037 6.83372H8.45334C8.58122 3.33299 11.4684 0.524375 14.9998 0.524375ZM19.7844 6.83366H10.215C10.3424 4.25799 12.4398 2.20244 14.9998 2.20244C17.5585 2.20244 19.6552 4.25768 19.7844 6.83366ZM5.91215 7.35803H24.0875C24.9448 7.35803 25.7886 8.07242 25.93 8.91796L26.0696 9.75264H3.93001L4.06962 8.91796C4.21102 8.07242 5.05483 7.35803 5.91215 7.35803ZM28.8608 29.0459C28.6262 29.323 28.276 29.4756 27.8746 29.4756H2.12499C1.72363 29.4756 1.37335 29.323 1.13873 29.0459C0.904061 28.7688 0.811339 28.3981 0.877534 28.0022L1.04157 27.0214H28.9579L29.122 28.0022C29.1882 28.3981 29.0955 28.7687 28.8608 29.0459Z\" fill=\"#231F20\"/>\r\n</g>\r\n<defs>\r\n<clipPath >\r\n<rect width=\"30\" height=\"30\" fill=\"white\"/>\r\n</clipPath>\r\n</defs>\r\n</svg>\r\n', NULL),
(15, 'leather_goods.svg', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M15 3.75195C14.6095 3.75195 14.293 4.06851 14.293 4.45901V4.91355C14.293 5.30404 14.6095 5.6206 15 5.6206C15.3905 5.6206 15.7071 5.30404 15.7071 4.91355V4.45901C15.7071 4.06841 15.3905 3.75195 15 3.75195Z\" fill=\"#231F20\"/>\r\n<path d=\"M15 18.4834C14.6095 18.4834 14.293 18.8 14.293 19.1905V20.0414C14.293 20.4319 14.6095 20.7485 15 20.7485C15.3905 20.7485 15.7071 20.4319 15.7071 20.0414V19.1905C15.7071 18.8 15.3905 18.4834 15 18.4834Z\" fill=\"#231F20\"/>\r\n<path d=\"M15 14.7012C14.6095 14.7012 14.293 15.0177 14.293 15.4082V16.2592C14.293 16.6497 14.6095 16.9663 15 16.9663C15.3905 16.9663 15.7071 16.6497 15.7071 16.2592V15.4082C15.7071 15.0177 15.3905 14.7012 15 14.7012Z\" fill=\"#231F20\"/>\r\n<path d=\"M15 7.1377C14.6095 7.1377 14.293 7.45425 14.293 7.84475V8.69574C14.293 9.08624 14.6095 9.4028 15 9.4028C15.3905 9.4028 15.7071 9.08624 15.7071 8.69574V7.84475C15.7071 7.45425 15.3905 7.1377 15 7.1377Z\" fill=\"#231F20\"/>\r\n<path d=\"M15 10.9189C14.6095 10.9189 14.293 11.2355 14.293 11.626V12.4769C14.293 12.8674 14.6095 13.1839 15 13.1839C15.3905 13.1839 15.7071 12.8674 15.7071 12.4769V11.626C15.7071 11.2354 15.3905 10.9189 15 10.9189Z\" fill=\"#231F20\"/>\r\n<path d=\"M15 22.2646C14.6095 22.2646 14.293 22.5812 14.293 22.9717V23.4262C14.293 23.8167 14.6095 24.1333 15 24.1333C15.3905 24.1333 15.7071 23.8167 15.7071 23.4262V22.9717C15.7071 22.5812 15.3905 22.2646 15 22.2646Z\" fill=\"#231F20\"/>\r\n<path d=\"M27.0704 20.6921C24.7749 20.6921 22.9075 18.0511 22.9075 14.8049C22.9075 11.5586 24.7749 8.9175 27.0704 8.9175C27.4361 8.9175 27.7731 8.71992 27.9518 8.40084C28.1304 8.08176 28.1226 7.69116 27.9315 7.37945L25.1971 2.92065C25.0354 2.65702 24.7619 2.48187 24.4546 2.44561C24.1473 2.40904 23.8407 2.51571 23.6218 2.73439C22.6709 3.68528 21.1239 3.68508 20.1731 2.73439C19.7125 2.27389 19.4588 1.66138 19.4587 1.00998C19.4586 0.452213 19.0064 0 18.4487 0H11.5512C10.9935 0 10.5413 0.452213 10.5412 1.00998C10.541 1.66138 10.2873 2.27389 9.82682 2.73439C8.87613 3.68528 7.32889 3.68508 6.3781 2.73439C6.15922 2.51571 5.85195 2.40904 5.54529 2.44561C5.23813 2.48187 4.9645 2.65702 4.80278 2.92065L2.06849 7.37945C1.87729 7.69116 1.86951 8.08176 2.04819 8.40084C2.22687 8.71992 2.56394 8.9175 2.92959 8.9175C5.2251 8.9175 7.09253 11.5586 7.09253 14.8049C7.09253 18.0511 5.2251 20.6921 2.92959 20.6921C2.58515 20.6921 2.26445 20.8677 2.0788 21.1578C1.89304 21.4478 1.86809 21.8126 2.01243 22.1254L3.73674 25.8619C3.92472 26.2692 4.35875 26.5042 4.80228 26.4377C4.87389 26.4272 12.0049 25.4187 14.0366 29.4449C14.2068 29.7821 14.551 29.9963 14.9286 29.9999C14.9319 29.9999 14.9351 29.9999 14.9384 29.9999C15.3124 29.9999 15.6561 29.7931 15.8312 29.4622C18.0153 25.3344 25.1522 26.1449 25.224 26.1536C25.6481 26.2054 26.0586 25.9847 26.2496 25.6026L27.9739 22.1538C28.1305 21.8407 28.1137 21.4689 27.9297 21.1711C27.7457 20.8734 27.4205 20.6921 27.0704 20.6921ZM24.7484 24.0879C22.8498 23.9771 17.7243 24.0075 14.9467 27.2024C12.8094 24.7425 9.15562 24.296 6.78335 24.296C6.17942 24.296 5.65872 24.325 5.26712 24.357L4.40572 22.4904C5.53933 22.1415 6.57002 21.389 7.39556 20.2882C8.50291 18.8117 9.1127 16.8645 9.1127 14.805C9.1127 12.7454 8.50291 10.7982 7.39556 9.32173C6.60891 8.27286 5.6363 7.54015 4.56562 7.17157L5.94943 4.91505C7.64363 5.84837 9.82066 5.59746 11.2553 4.16295C11.854 3.56427 12.2614 2.8253 12.447 2.02016H17.5528C17.7384 2.8253 18.1458 3.56427 18.7445 4.16295C20.1792 5.59756 22.3562 5.84837 24.0504 4.91505L25.4342 7.17157C24.3635 7.54015 23.3909 8.27286 22.6043 9.32163C21.497 10.7981 20.8872 12.7454 20.8872 14.8049C20.8872 16.8644 21.497 18.8116 22.6043 20.2881C23.42 21.3756 24.4357 22.1232 25.5533 22.4775L24.7484 24.0879Z\" fill=\"#231F20\"/>\r\n</svg>\r\n', NULL),
(16, 'scarves.svg', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M27.2235 10.0525L15.5001 4.19074V3.49998C15.5001 3.224 15.276 3 15.0001 3C14.4486 3 14 2.55152 14 1.99998C14 1.4485 14.4485 0.999961 15.0001 0.999961C15.5516 0.999961 16.0001 1.44844 16.0001 1.99998C16.0001 2.27596 16.2241 2.49996 16.5001 2.49996C16.776 2.49996 17.0001 2.27596 17.0001 1.99998C17.0001 0.897012 16.103 0 15.0001 0C13.8971 0 13.0001 0.897012 13.0001 1.99998C13.0001 2.92998 13.6386 3.71396 14.5001 3.93697V4.19074L2.77653 10.0525C2.56905 10.1565 2.46001 10.389 2.51351 10.615C2.56653 10.8405 2.76804 11 3.00001 11H8.49997V27.5C8.49997 27.5004 8.50003 27.5007 8.50003 27.501V29.5C8.50003 29.776 8.72403 30 9.00001 30C9.27599 30 9.49999 29.776 9.49999 29.5V28H10.5V29.5C10.5 29.776 10.724 30 11 30C11.276 30 11.5 29.776 11.5 29.5V28H11.5492H12.5V29.5C12.5 29.776 12.724 30 13 30C13.2759 30 13.5 29.776 13.5 29.5V28H14.4506H14.4999V29.5C14.4999 29.776 14.7239 30 14.9999 30C15.2759 30 15.4999 29.776 15.4999 29.5V28H16.4999V29.5C16.4999 29.776 16.7239 30 16.9999 30C17.2759 30 17.4999 29.776 17.4999 29.5V27.5C17.4999 27.4997 17.4998 27.4994 17.4998 27.499V21H18.4999V22.5C18.4999 22.776 18.7239 23 18.9999 23C19.2758 23 19.4998 22.776 19.4998 22.5V21H20.4999V22.5C20.4999 22.776 20.7239 23 20.9998 23C21.2758 23 21.4998 22.776 21.4998 22.5V21C21.7758 21 21.9997 20.776 21.9997 20.5V11H26.9998C27.2317 11 27.4328 10.8405 27.4867 10.615C27.5401 10.389 27.431 10.1565 27.2235 10.0525ZM9.50005 10.5V10H11.0123C11.0044 10.1687 11.0002 10.3358 11.0002 10.5C11.0002 12.0984 11.3513 13.71 12.0309 14.4999C11.3512 15.2897 11 16.9015 11 18.5C11 20.0986 11.3512 21.7104 12.0309 22.5002C11.3514 23.29 11.0002 24.9017 11.0002 26.5001C11.0002 26.6643 11.0044 26.8314 11.0123 27.0001H9.49999V10.501C9.49999 10.5006 9.50005 10.5004 9.50005 10.5ZM14.0002 10.5C14.0002 12.7735 13.2902 14 13.0002 14C12.7097 14 12.0002 12.7735 12.0002 10.5C12.0002 10.336 12.0042 10.169 12.0132 10H13.9867C13.9957 10.169 14.0002 10.336 14.0002 10.5ZM13 22C12.7095 22 12 20.7735 12 18.5C12 16.2265 12.7095 15 13 15C13.2905 15 14 16.2265 14 18.5C14 20.7735 13.2905 22 13 22ZM12.0133 27C12.0042 26.831 12.0002 26.664 12.0002 26.5C12.0002 24.2265 12.7098 23 13.0003 23C13.2902 23 14.0003 24.2265 14.0003 26.5C14.0003 26.664 13.9958 26.831 13.9868 27H12.0133ZM16.5 27H14.9879C14.996 26.8313 15.0002 26.6642 15.0002 26.5C15.0002 24.9015 14.6491 23.2897 13.9694 22.4999C14.6489 21.71 15.0001 20.0984 15.0001 18.5C15.0001 16.9016 14.649 15.29 13.9694 14.5001C14.6491 13.7103 15.0002 12.0985 15.0002 10.4999C15.0002 10.3358 14.996 10.1687 14.9879 9.99996H16.5V20.5V27ZM21 20H19.3094C19.4346 19.3868 19.5001 18.7075 19.5001 18C19.5001 16.4016 19.1489 14.7898 18.4693 14C19.1489 13.2102 19.5001 11.5985 19.5001 9.99996H21V20ZM17.5 13.5V10H18.5C18.5 12.2735 17.7905 13.5 17.5 13.5ZM17.5 20V14.5C17.7905 14.5 18.5 15.7264 18.5 17.9999C18.5 18.7095 18.425 19.406 18.2855 19.9999H17.5V20ZM22 10V9.50004C22 9.22406 21.776 9.00006 21.5 9.00006H21.5H18.987H17.0001H17H14.4508H11.5492H9.00007H9.00001C8.72403 9.00006 8.50003 9.22406 8.50003 9.50004V10H5.11806L15.0001 5.05898L24.8821 9.99996H22V10Z\" fill=\"#231F20\"/>\r\n</svg>\r\n', NULL),
(17, 'shoes-7.svg', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M30 17.2308C30 16.7624 29.9096 16.2576 29.6698 15.7767C29.4309 15.2958 29.0367 14.8497 28.4926 14.5211C27.9741 14.2064 27.0131 13.635 25.8248 12.9563L25.9152 12.7879C26.0145 12.6051 25.9461 12.3769 25.763 12.278C25.5799 12.179 25.3519 12.2474 25.2526 12.4305L25.1695 12.5845C24.6277 12.2783 24.0511 11.9577 23.4555 11.6334C23.3518 11.5768 23.2444 11.5198 23.1393 11.4629L23.2239 11.3121C23.3261 11.1308 23.2614 10.9013 23.0797 10.7995C22.8981 10.698 22.6687 10.7628 22.5672 10.944L22.476 11.1069C21.7915 10.7429 21.0987 10.3851 20.4163 10.0458L20.4509 9.98588C20.5553 9.80612 20.4936 9.57561 20.3142 9.47154C20.134 9.36713 19.9039 9.42889 19.7994 9.60865L19.7391 9.71383C18.7192 9.22229 17.7427 8.78694 16.8934 8.47188C16.028 8.15383 15.3673 7.99317 14.7756 7.99024C14.4543 7.98988 14.148 8.04321 13.873 8.16344C13.6675 8.25315 13.4844 8.37924 13.3351 8.52303C13.1108 8.73924 12.9616 8.98405 12.845 9.22117C12.7285 9.45947 12.6417 9.69584 12.5556 9.92934C12.3605 10.4603 12.1674 10.8158 11.9505 11.0834C11.7681 11.308 11.5674 11.4831 11.324 11.632C10.9608 11.854 10.4894 12.0173 9.8618 12.1228C9.23566 12.2283 8.46064 12.2731 7.52602 12.2754H7.51207C6.97975 12.275 6.56719 12.1985 6.23262 12.0827C5.73258 11.9077 5.39215 11.647 5.0884 11.3334C4.78547 11.0194 4.53949 10.6518 4.25273 10.2896C4.05604 10.0426 3.80824 9.85545 3.54498 9.73668C3.28137 9.61721 3.00451 9.56348 2.73539 9.56319C2.40598 9.56389 2.08611 9.64258 1.79824 9.79662C1.51184 9.95031 1.25227 10.1859 1.08387 10.5055C0.276094 12.0464 0 13.6476 0 15.0642C0 16.0058 0.121348 16.8683 0.295605 17.5956C0.435645 18.1739 0.604805 18.6581 0.788965 19.0486C0.851484 20.367 1.03822 21.3722 1.04197 21.3939L1.15594 22.0094H9.76371L10.5681 21.3929L13.0466 22.0094H29.2058L29.3249 21.4006C29.461 20.7034 29.5271 20.0667 29.5271 19.4788C29.5271 19.3442 29.5168 19.2177 29.5103 19.0883C29.6272 18.8857 29.7323 18.668 29.8125 18.4192C29.9257 18.0617 29.9992 17.6595 30 17.2308ZM27.9455 20.5034H13.2304L10.2281 19.756L9.25266 20.5034H2.42953C2.38986 20.1968 2.34498 19.7982 2.3141 19.342L28.0124 19.278C28.0146 19.3456 28.0212 19.4081 28.0212 19.4787C28.0212 19.7897 27.9955 20.1324 27.9455 20.5034ZM28.3779 17.961C28.3088 18.1801 28.211 18.3629 28.1448 18.4492L28.2455 18.5242L2.24133 18.5889C2.10012 18.3404 1.90529 17.8543 1.76004 17.244C1.61191 16.6263 1.50563 15.8752 1.50598 15.0641C1.50598 13.8405 1.74498 12.4872 2.41781 11.2052C2.4259 11.189 2.45238 11.1548 2.51115 11.1231C2.56852 11.0915 2.65307 11.0688 2.73545 11.0695C2.80313 11.0691 2.86746 11.0827 2.9226 11.1081C2.97814 11.1338 3.02666 11.1687 3.07588 11.2298C3.38174 11.6044 3.77848 12.2478 4.46713 12.8034C4.81201 13.0802 5.23336 13.3309 5.74002 13.506C6.24668 13.6817 6.8342 13.7813 7.51213 13.7813H7.51359H7.5283H7.52977C8.8357 13.7769 9.90856 13.7019 10.835 13.4512C11.2976 13.3251 11.7237 13.1526 12.1086 12.9173C12.4932 12.6832 12.8344 12.3857 13.1204 12.0316C13.4771 11.5919 13.7395 11.0727 13.969 10.4495C14.044 10.2459 14.1105 10.0697 14.1741 9.93297C14.2212 9.83037 14.2665 9.75098 14.3065 9.69473C14.3682 9.60977 14.4065 9.57965 14.4568 9.5524C14.508 9.52703 14.5932 9.49692 14.7756 9.49615C15.069 9.49322 15.5963 9.59506 16.3705 9.88404C17.1272 10.1635 18.028 10.5635 18.9817 11.0212L18.0868 12.5672C18.0456 12.5614 18.0045 12.5544 17.961 12.5544C17.4323 12.5544 17.0044 12.9827 17.0044 13.5111C17.0044 14.0397 17.4323 14.4681 17.961 14.4681C18.4897 14.4681 18.9178 14.0397 18.9178 13.5111C18.9178 13.3015 18.8486 13.1092 18.7346 12.9518L19.6604 11.3518C20.345 11.6908 21.0465 12.0522 21.7399 12.421L20.9943 13.7508C20.9554 13.746 20.9171 13.739 20.8774 13.739C20.3487 13.739 19.92 14.1674 19.92 14.6961C19.92 15.2247 20.3487 15.6528 20.8774 15.6528C21.4061 15.6528 21.834 15.2248 21.834 14.6961C21.834 14.4832 21.7627 14.2887 21.6451 14.1299L22.4032 12.7769C22.5135 12.8364 22.626 12.8963 22.7348 12.9559C23.332 13.281 23.9099 13.603 24.454 13.9101L23.9003 14.9347C23.8651 14.9307 23.8305 14.924 23.7937 14.924C23.265 14.924 22.8363 15.352 22.8363 15.8807C22.8363 16.4094 23.265 16.8377 23.7937 16.8377C24.3224 16.8377 24.7504 16.4094 24.7504 15.8807C24.7504 15.6645 24.6761 15.4671 24.5555 15.3072L25.1085 14.2818C26.271 14.9458 27.21 15.5042 27.7101 15.808C28.0248 16.0013 28.2028 16.215 28.3226 16.4503C28.4403 16.6853 28.494 16.9529 28.494 17.2309C28.494 17.4834 28.4484 17.7411 28.3779 17.961Z\" fill=\"#231F20\"/>\r\n</svg>\r\n', NULL),
(18, 'small_item.svg', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M8.125 27.5C5.0184 27.5 2.5 24.9816 2.5 21.875C2.5 18.7684 5.0184 16.25 8.125 16.25C11.2316 16.25 13.75 18.7684 13.75 21.875C13.75 24.9816 11.2316 27.5 8.125 27.5ZM21.875 27.5C18.7684 27.5 16.25 24.9816 16.25 21.875C16.25 18.7684 18.7684 16.25 21.875 16.25C24.9816 16.25 27.5 18.7684 27.5 21.875C27.5 24.9816 24.9816 27.5 21.875 27.5ZM8.125 13.75C5.0184 13.75 2.5 11.2316 2.5 8.125C2.5 5.0184 5.0184 2.5 8.125 2.5C11.2316 2.5 13.75 5.0184 13.75 8.125C13.75 11.2316 11.2316 13.75 8.125 13.75ZM21.875 13.75C18.7684 13.75 16.25 11.2316 16.25 8.125C16.25 5.0184 18.7684 2.5 21.875 2.5C24.9816 2.5 27.5 5.0184 27.5 8.125C27.5 11.2316 24.9816 13.75 21.875 13.75ZM21.875 11.25C23.6009 11.25 25 9.85089 25 8.125C25 6.39911 23.6009 5 21.875 5C20.1491 5 18.75 6.39911 18.75 8.125C18.75 9.85089 20.1491 11.25 21.875 11.25ZM8.125 11.25C9.85089 11.25 11.25 9.85089 11.25 8.125C11.25 6.39911 9.85089 5 8.125 5C6.39911 5 5 6.39911 5 8.125C5 9.85089 6.39911 11.25 8.125 11.25ZM21.875 25C23.6009 25 25 23.6009 25 21.875C25 20.1491 23.6009 18.75 21.875 18.75C20.1491 18.75 18.75 20.1491 18.75 21.875C18.75 23.6009 20.1491 25 21.875 25ZM8.125 25C9.85089 25 11.25 23.6009 11.25 21.875C11.25 20.1491 9.85089 18.75 8.125 18.75C6.39911 18.75 5 20.1491 5 21.875C5 23.6009 6.39911 25 8.125 25Z\" fill=\"#231F20\"/>\r\n</svg>\r\n', NULL),
(19, 'sweaters.svg', '<svg width=\"20\" height=\"20\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M27.5715 5.71008C27.5205 3.56543 26.1086 1.70051 24.0581 1.06969L21.2252 0.198047C20.7982 0.0665625 20.3552 0 19.9083 0H10.0908C9.64407 0 9.20099 0.0665625 8.7739 0.198047L5.94101 1.06969C3.89064 1.70057 2.4787 3.56543 2.42767 5.71008L2.012 23.1676C2.00333 23.5305 2.19411 23.8603 2.50483 24.0352V25.7133C2.50483 26.0834 2.71044 26.4161 3.04144 26.5816L6.51317 28.3174V29.0292C6.51317 29.5645 6.94864 29.9999 7.48396 29.9999H22.5152C23.0506 29.9999 23.486 29.5645 23.486 29.0292V28.3174L26.9578 26.5815C27.2888 26.416 27.4944 26.0833 27.4944 25.7132V24.0352C27.8051 23.8603 27.9959 23.5305 27.9872 23.1676L27.5715 5.71008ZM18.0007 0.939434C17.7742 2.39209 16.5148 3.5073 14.9996 3.5073C13.4844 3.5073 12.225 2.39209 11.9985 0.939434H18.0007ZM10.0908 0.939434H11.0512C11.2845 2.91164 12.9656 4.44674 14.9995 4.44674C17.0334 4.44674 18.7147 2.91164 18.9479 0.939434H19.9082C19.9453 0.939434 19.9824 0.940371 20.0193 0.941484C19.7818 3.52459 17.6256 5.5115 14.9996 5.5115C13.6861 5.5115 12.4425 5.00912 11.4979 4.09711C10.6235 3.25283 10.0914 2.14096 9.98034 0.941543C10.0171 0.940371 10.054 0.939434 10.0908 0.939434ZM5.5612 26.7911L3.46161 25.7413C3.45089 25.736 3.44427 25.7252 3.44427 25.7133V24.4448L5.56665 25.3545L5.53765 26.4863C5.53501 26.5898 5.54315 26.6918 5.5612 26.7911ZM22.5466 29.0292C22.5466 29.0464 22.5326 29.0605 22.5153 29.0605H7.48396C7.46667 29.0605 7.45267 29.0464 7.45267 29.0292V27.9958H22.5466V29.0292ZM23.3715 26.8956C23.2705 26.9993 23.1351 27.0564 22.9903 27.0564H7.00894V27.0564C6.86415 27.0564 6.72874 26.9992 6.62773 26.8956C6.52665 26.7919 6.47304 26.6551 6.47679 26.5104L6.52911 24.4695L7.67644 24.9528C7.79304 25.0019 7.92452 25.0019 8.04112 24.9528L10.2377 24.0275L12.4344 24.9528C12.551 25.0019 12.6825 25.0019 12.7992 24.9528L14.9952 24.0275L17.1915 24.9528C17.3081 25.002 17.4396 25.002 17.5561 24.9529L19.7547 24.0274L21.9549 24.9529C22.0131 24.9774 22.075 24.9896 22.137 24.9896C22.1989 24.9896 22.2608 24.9774 22.3191 24.9529L23.47 24.4688L23.5224 26.5105C23.5262 26.6552 23.4726 26.792 23.3715 26.8956ZM7.67649 16.9361C7.7931 16.9852 7.92458 16.9852 8.04118 16.9361L10.2378 16.0108L12.4345 16.9361C12.4928 16.9607 12.5548 16.973 12.6169 16.973C12.679 16.973 12.7409 16.9607 12.7993 16.9361L14.9953 16.0109L17.1917 16.9361C17.3083 16.9853 17.4397 16.9853 17.5562 16.9362L19.7548 16.0107L21.955 16.9362C22.0714 16.9852 22.2028 16.9852 22.3192 16.9362L23.2668 16.5376L23.3934 21.4777L22.137 22.0061L19.9368 21.0807C19.8203 21.0316 19.6889 21.0316 19.5724 21.0807L17.374 22.0061L15.1776 21.0807C15.0611 21.0316 14.9295 21.0316 14.8129 21.0807L12.6168 22.006L10.4202 21.0807C10.3036 21.0316 10.1721 21.0316 10.0555 21.0807L7.8589 22.0061L6.60593 21.4782L6.73255 16.5384L7.67649 16.9361ZM6.75833 15.5299L6.78335 14.5556L7.67644 14.9319C7.79304 14.981 7.92452 14.981 8.04112 14.9319L10.2377 14.0065L12.4344 14.9319C12.551 14.981 12.6825 14.981 12.7991 14.9319L14.9951 14.0066L17.1915 14.9319C17.308 14.981 17.4396 14.981 17.556 14.9319L19.7546 14.0065L21.9548 14.9319C22.013 14.9565 22.0749 14.9687 22.1369 14.9687C22.1989 14.9687 22.2608 14.9565 22.319 14.9319L23.2157 14.5547L23.2408 15.5292L22.137 15.9935L19.9367 15.0681C19.8202 15.019 19.6888 15.019 19.5724 15.0681L17.3739 15.9935L15.1775 15.0681C15.061 15.019 14.9295 15.019 14.8128 15.0681L12.6168 15.9934L10.4201 15.0681C10.3035 15.019 10.1721 15.019 10.0554 15.0681L7.85878 15.9935L6.75833 15.5299ZM7.67649 22.9485C7.7931 22.9976 7.92458 22.9976 8.04118 22.9485L10.2378 22.0232L12.4345 22.9485C12.5511 22.9976 12.6826 22.9976 12.7992 22.9485L14.9953 22.0233L17.1916 22.9485C17.3081 22.9977 17.4397 22.9977 17.5562 22.9486L19.7547 22.0232L21.9549 22.9486C22.0132 22.9731 22.0751 22.9853 22.137 22.9853C22.199 22.9853 22.2609 22.9731 22.3191 22.9486L23.4192 22.4859L23.4443 23.4604L22.137 24.0103L19.9368 23.0848C19.8203 23.0358 19.6889 23.0358 19.5724 23.0848L17.374 24.0102L15.1776 23.0849C15.0611 23.0357 14.9295 23.0357 14.8129 23.0849L12.6168 24.0101L10.4201 23.0849C10.3036 23.0358 10.1721 23.0358 10.0555 23.0849L7.85884 24.0102L6.55501 23.461L6.57991 22.4866L7.67649 22.9485ZM26.5549 25.7133C26.5549 25.7252 26.5483 25.736 26.5376 25.7413L24.438 26.7912C24.4561 26.6919 24.4642 26.5899 24.4616 26.4864L24.4326 25.3545L26.5549 24.4449V25.7133ZM27.029 23.2195L24.4066 24.3434L23.9868 7.97326C23.9802 7.71392 23.7639 7.50949 23.5052 7.51576C23.2458 7.52238 23.041 7.73807 23.0477 7.9974L23.19 13.5464L22.137 13.9893L19.9368 13.0639C19.8203 13.0148 19.6889 13.0148 19.5724 13.0639L17.374 13.9893L15.1776 13.0639C15.0611 13.0148 14.9295 13.0148 14.8129 13.0639L12.6168 13.9892L10.4201 13.0639C10.3036 13.0148 10.1721 13.0148 10.0555 13.0639L7.85878 13.9893L6.80913 13.5471L6.95146 7.9974C6.95808 7.73807 6.75323 7.52238 6.49396 7.51576C6.23421 7.50908 6.01899 7.71398 6.01231 7.97326L5.59255 24.3434L2.97019 23.2195C2.95835 23.2144 2.95091 23.2028 2.9512 23.1899L3.36681 5.7324C3.40823 3.9924 4.5538 2.47945 6.21728 1.96758L9.05011 1.09588C9.05081 1.0957 9.05157 1.09553 9.05222 1.09523C9.1973 2.49311 9.82419 3.78697 10.8452 4.77281C11.9659 5.85492 13.4412 6.45088 14.9995 6.45088C16.554 6.45088 18.0267 5.85738 19.1465 4.77984C20.1713 3.79353 20.8014 2.49656 20.9469 1.09529C20.9476 1.09547 20.9482 1.09564 20.9489 1.09588L23.7817 1.96758C25.4452 2.47945 26.5908 3.9924 26.6322 5.7324L27.0479 23.1899C27.0483 23.2028 27.0409 23.2145 27.029 23.2195Z\" fill=\"#231F20\"/>\r\n</svg>\r\n', NULL);
INSERT INTO `cc_icons` (`icon_id`, `name`, `code`, `path`) VALUES
(21, 'noun-brand.svg', '<svg width=\"16\" height=\"20\" viewBox=\"0 0 16 20\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">↩\r\n<g >↩\r\n<path d=\"M7.82694 0.750004C7.66355 0.750004 7.54986 0.814634 7.4233 0.885259C7.29675 0.955936 7.167 1.04302 7.04021 1.13135C6.91343 1.21969 6.78897 1.31 6.68483 1.37793C6.58069 1.44581 6.48567 1.49118 6.47322 1.49463C6.46083 1.4986 6.35659 1.50532 6.23296 1.50002C6.10933 1.49473 5.95968 1.48135 5.8064 1.46926C5.65312 1.4573 5.49605 1.44521 5.35166 1.44827C5.20727 1.45091 5.07663 1.45375 4.93514 1.53665C4.79365 1.61968 4.72668 1.73539 4.65188 1.86087C4.5771 1.98641 4.50851 2.1272 4.44219 2.2681C4.37591 2.40898 4.31264 2.54845 4.25589 2.66019C4.19914 2.77191 4.13985 2.85845 4.13075 2.86771C4.1215 2.87697 4.03391 2.93957 3.92392 2.9971C3.81393 3.05476 3.67666 3.11923 3.53797 3.18655C3.39926 3.25391 3.26075 3.32347 3.1372 3.39944C3.01365 3.47543 2.9022 3.54382 2.82051 3.68753C2.7388 3.83125 2.73658 3.96372 2.73353 4.11038C2.73076 4.25705 2.73908 4.4166 2.75119 4.57229C2.76311 4.72799 2.77587 4.87982 2.78178 5.0054C2.78733 5.13094 2.77993 5.23689 2.77716 5.24954C2.77346 5.26283 2.72891 5.35912 2.66204 5.46487C2.59512 5.57062 2.50874 5.69645 2.42178 5.82522C2.3348 5.95395 2.24633 6.08339 2.17674 6.21194C2.10713 6.34054 2.04395 6.45859 2.04395 6.62454C2.04395 6.79049 2.10717 6.90566 2.17674 7.03421C2.24634 7.1628 2.33482 7.29459 2.42178 7.42337C2.50876 7.55209 2.59516 7.67843 2.66204 7.78421C2.72897 7.88995 2.77382 7.98445 2.77716 7.9971C2.78086 8.01038 2.78779 8.11809 2.78178 8.24368C2.77624 8.36922 2.76311 8.5211 2.75119 8.67679C2.73926 8.83248 2.73048 8.98959 2.73353 9.13626C2.7363 9.28292 2.73908 9.41783 2.82051 9.56155C2.90222 9.70528 3.01365 9.77367 3.1372 9.84964C3.26076 9.92563 3.39926 9.99468 3.53797 10.062C3.67666 10.1294 3.81393 10.1939 3.92392 10.2515C4.03391 10.3092 4.12163 10.3696 4.13075 10.3789C4.13907 10.3877 4.19268 10.4663 4.24634 10.5689L2.564 13.5318C2.54181 13.5708 2.53039 13.6153 2.53097 13.6605C2.53154 13.7057 2.54408 13.7499 2.56726 13.7883C2.59044 13.8268 2.62339 13.8581 2.6626 13.879C2.70181 13.8998 2.74581 13.9094 2.78993 13.9068L4.21243 13.8199L4.84963 15.1133C4.86948 15.1534 4.89954 15.1873 4.93665 15.2115C4.97376 15.2356 5.01655 15.249 5.06051 15.2504C5.10447 15.2517 5.14798 15.2409 5.18644 15.2191C5.2249 15.1973 5.2569 15.1653 5.27906 15.1265L7.00487 12.0904C7.01679 12.0987 7.02816 12.1064 7.04017 12.1148C7.16696 12.2031 7.29672 12.2907 7.42327 12.3614C7.54981 12.432 7.66351 12.4961 7.8269 12.4961C7.99027 12.4961 8.10397 12.4321 8.23052 12.3614C8.35706 12.2907 8.48682 12.2031 8.61361 12.1148C8.62581 12.1063 8.63727 12.0984 8.64947 12.0899L10.3738 15.1265C10.396 15.1654 10.428 15.1976 10.4665 15.2195C10.505 15.2413 10.5486 15.2522 10.5926 15.2508C10.6367 15.2495 10.6796 15.236 10.7167 15.2118C10.7539 15.1876 10.784 15.1536 10.8037 15.1133L11.441 13.8199L12.8634 13.9068C12.9077 13.9098 12.952 13.9005 12.9915 13.8798C13.031 13.8591 13.0642 13.8278 13.0876 13.7893C13.111 13.7507 13.1237 13.7064 13.1244 13.661C13.125 13.6157 13.1136 13.571 13.0913 13.5318L11.407 10.5698C11.4609 10.4668 11.5145 10.3877 11.5231 10.3789C11.5324 10.3697 11.62 10.3091 11.7299 10.2515C11.8399 10.1938 11.9767 10.1294 12.1154 10.062C12.2541 9.99469 12.3931 9.92561 12.5167 9.84963C12.6402 9.77365 12.7517 9.70527 12.8334 9.56155C12.9151 9.41783 12.9173 9.28292 12.9203 9.13625C12.9231 8.98959 12.9148 8.83248 12.9027 8.67678C12.8908 8.52109 12.8775 8.36926 12.8716 8.24368C12.8661 8.11814 12.8735 8.00973 12.8772 7.99709C12.8809 7.98381 12.9254 7.89003 12.9923 7.78421C13.0592 7.67846 13.1451 7.55216 13.2321 7.42337C13.319 7.29464 13.408 7.16275 13.4776 7.03421C13.5472 6.90561 13.6075 6.79049 13.6075 6.62454C13.6075 6.45859 13.5472 6.34048 13.4776 6.21194C13.408 6.08335 13.319 5.954 13.2321 5.82522C13.1451 5.6965 13.0592 5.57064 12.9923 5.46487C12.9254 5.35913 12.8805 5.26217 12.8772 5.24954C12.8735 5.23625 12.866 5.13093 12.8716 5.0054C12.8772 4.87986 12.8908 4.72798 12.9027 4.57229C12.9146 4.4166 12.9234 4.25705 12.9203 4.11038C12.9176 3.96372 12.9148 3.83125 12.8334 3.68753C12.7516 3.54382 12.6402 3.47541 12.5167 3.39944C12.3931 3.32345 12.2541 3.25391 12.1154 3.18655C11.9767 3.1192 11.8399 3.05472 11.7299 2.9971C11.62 2.93944 11.5322 2.87687 11.5231 2.8677C11.5139 2.85844 11.4547 2.77184 11.398 2.66018C11.3412 2.54846 11.2775 2.40897 11.2112 2.26809C11.1449 2.1272 11.0768 1.98636 11.002 1.86087C10.9272 1.73533 10.8597 1.61963 10.7182 1.53665C10.5768 1.45362 10.4466 1.45133 10.3022 1.44826C10.1578 1.44562 10.0007 1.45784 9.84746 1.46926C9.69418 1.48121 9.54454 1.49418 9.42091 1.50002C9.29728 1.50531 9.19308 1.4986 9.18063 1.49463C9.16825 1.49066 9.0727 1.44595 8.96855 1.37793C8.86441 1.31005 8.74044 1.21967 8.61364 1.13135C8.48687 1.04301 8.35711 0.95594 8.23056 0.885255C8.10401 0.814578 7.99031 0.750004 7.82694 0.750004ZM7.82646 1.24952C7.83635 1.25415 7.91122 1.27363 7.99555 1.32081C8.0939 1.3758 8.21461 1.45829 8.33756 1.54395C8.46051 1.62963 8.58473 1.71876 8.70297 1.7959C8.82121 1.87308 8.92272 1.93913 9.0531 1.97461C9.18349 2.01008 9.30346 2.00482 9.44383 1.99806C9.5842 1.99144 9.73703 1.97619 9.88568 1.96436C10.0343 1.95241 10.1795 1.94391 10.2917 1.9463C10.3881 1.94856 10.4621 1.97017 10.4727 1.9712C10.4801 1.98116 10.5339 2.03514 10.5831 2.11769C10.6412 2.21519 10.705 2.34679 10.7694 2.48341C10.8337 2.62004 10.8965 2.76134 10.9609 2.8882C11.0253 3.01506 11.0804 3.12328 11.1759 3.22023C11.2713 3.3172 11.3777 3.37256 11.5026 3.438C11.6275 3.50349 11.7693 3.56999 11.9038 3.63527C12.0383 3.70062 12.168 3.76563 12.264 3.82472C12.3459 3.875 12.399 3.93014 12.4082 3.93702C12.4091 3.94887 12.4277 4.02365 12.4298 4.12062C12.4325 4.2346 12.4233 4.38224 12.4121 4.53322C12.4007 4.6842 12.3882 4.83938 12.3815 4.98195C12.375 5.12453 12.3666 5.24649 12.4016 5.37892C12.4365 5.51136 12.5019 5.61428 12.5778 5.73439C12.6537 5.85448 12.7438 5.98058 12.8281 6.10548C12.9124 6.23035 12.9914 6.35323 13.0455 6.45314C13.0915 6.53811 13.1109 6.613 13.1157 6.62404C13.1111 6.63368 13.0919 6.70733 13.0455 6.79298C12.9914 6.89288 12.9125 7.01575 12.8281 7.14064C12.7438 7.26551 12.6538 7.39407 12.5778 7.51417C12.5019 7.63426 12.4365 7.73721 12.4016 7.86964C12.3666 8.00209 12.3749 8.12403 12.3815 8.26661C12.388 8.40919 12.4006 8.56435 12.4121 8.71534C12.4237 8.86633 12.4322 9.01152 12.4298 9.1255C12.4279 9.22249 12.4092 9.29723 12.4082 9.30909C12.3989 9.3159 12.3458 9.371 12.264 9.4214C12.168 9.48051 12.0383 9.54802 11.9038 9.61329C11.7693 9.67865 11.6275 9.74264 11.5026 9.80811C11.3777 9.8736 11.2713 9.92897 11.1759 10.0259C11.0804 10.1229 11.0253 10.2311 10.9609 10.3579C10.8965 10.4848 10.8337 10.6285 10.7694 10.7651C10.705 10.9018 10.6412 11.0309 10.5831 11.1284C10.5338 11.2111 10.48 11.2669 10.4727 11.2774C10.4622 11.2778 10.3881 11.2978 10.2917 11.2998C10.1795 11.3025 10.0343 11.2933 9.88568 11.2817C9.73703 11.2698 9.5842 11.2548 9.44383 11.2481C9.30346 11.2414 9.18349 11.2357 9.0531 11.271C8.92271 11.3065 8.82121 11.3731 8.70297 11.4502C8.58473 11.5274 8.46051 11.6189 8.33756 11.7046C8.21461 11.7903 8.0939 11.8704 7.99555 11.9253C7.91115 11.9725 7.83632 11.9919 7.82646 11.9966C7.81555 11.9918 7.74197 11.9721 7.65832 11.9253C7.55997 11.8703 7.43878 11.7903 7.31583 11.7046C7.19288 11.6189 7.06913 11.5273 6.95089 11.4502C6.83265 11.373 6.73115 11.3065 6.60076 11.271C6.47037 11.2355 6.3504 11.2413 6.21003 11.2481C6.06966 11.2547 5.91683 11.2701 5.76819 11.2817C5.61955 11.2937 5.47392 11.3022 5.36169 11.2998C5.26695 11.2975 5.19416 11.2789 5.18161 11.2778C5.17514 11.2685 5.1207 11.2121 5.07079 11.1284C5.01265 11.0309 4.94834 10.9018 4.88403 10.7652C4.8197 10.6285 4.75691 10.4848 4.69249 10.3579C4.62806 10.2311 4.57346 10.1228 4.47801 10.0259C4.38256 9.92892 4.27331 9.87356 4.14842 9.80812C4.02354 9.74263 3.88456 9.67864 3.75005 9.6133C3.61554 9.54794 3.48591 9.48045 3.38989 9.4214C3.30855 9.37141 3.25536 9.31649 3.24563 9.3091C3.24481 9.29738 3.22567 9.22258 3.22364 9.1255C3.22086 9.01152 3.23011 8.86634 3.24175 8.71535C3.25331 8.56436 3.26569 8.4092 3.27235 8.26662C3.27882 8.12404 3.28677 8.00209 3.25183 7.86964C3.21689 7.7372 3.15152 7.63428 3.07557 7.51417C2.99959 7.39408 2.90961 7.26554 2.82527 7.14064C2.74097 7.01577 2.6625 6.89288 2.60841 6.79298C2.5621 6.70743 2.54278 6.63372 2.53816 6.62404C2.54278 6.61295 2.56238 6.53805 2.60841 6.45314C2.66249 6.35324 2.74094 6.23037 2.82527 6.10548C2.90957 5.98061 2.99964 5.85449 3.07557 5.73439C3.15146 5.6143 3.2169 5.51136 3.25183 5.37892C3.28677 5.24648 3.279 5.12453 3.27235 4.98195C3.26588 4.83938 3.25331 4.68421 3.24175 4.53322C3.2302 4.38224 3.22123 4.2346 3.22364 4.12062C3.22548 4.02352 3.2448 3.94876 3.24563 3.93703C3.25534 3.92975 3.30849 3.87483 3.38989 3.82472C3.48591 3.76561 3.61554 3.7006 3.75005 3.63527C3.88456 3.56991 4.02354 3.50341 4.14842 3.438C4.27331 3.37251 4.38256 3.31715 4.47801 3.22023C4.57346 3.12325 4.62805 3.01505 4.69249 2.8882C4.75691 2.76133 4.81971 2.62004 4.88403 2.48342C4.94836 2.3468 5.01266 2.21522 5.07079 2.11769C5.12034 2.03457 5.17441 1.98014 5.18114 1.97072C5.19279 1.9693 5.26618 1.94834 5.36169 1.9463C5.47392 1.94366 5.61955 1.95282 5.76819 1.96437C5.91683 1.97633 6.06966 1.99129 6.21003 1.99807C6.3504 2.00468 6.47037 2.00996 6.60076 1.97462C6.73115 1.93915 6.83265 1.87304 6.95089 1.79591C7.06913 1.71873 7.19288 1.62963 7.31583 1.54396C7.43878 1.45828 7.55997 1.37576 7.65832 1.32082C7.74197 1.27403 7.81559 1.25438 7.82646 1.24952ZM7.82646 2.85401C5.78197 2.85401 4.11832 4.54494 4.11832 6.62452C4.11832 8.70409 5.78197 10.3926 7.82646 10.3926C9.87094 10.3926 11.5351 8.70409 11.5351 6.62452C11.5351 4.54494 9.87094 2.85401 7.82646 2.85401ZM7.82646 3.35401C9.6083 3.35401 11.0454 4.81675 11.0454 6.62452C11.0454 8.43229 9.6083 9.89258 7.82646 9.89258C6.04461 9.89258 4.60794 8.43229 4.60794 6.62452C4.60794 4.81675 6.04461 3.35401 7.82646 3.35401ZM7.82646 5.29395C7.79236 5.29415 7.75869 5.30164 7.72759 5.31594C7.69649 5.33023 7.66867 5.35102 7.6459 5.37696L7.10804 5.98389L6.18758 5.33789C6.14749 5.31004 6.10021 5.295 6.05174 5.29468C6.00327 5.29436 5.9558 5.30877 5.91536 5.33609C5.87492 5.3634 5.84333 5.40239 5.82461 5.44809C5.80589 5.4938 5.80088 5.54416 5.81022 5.59278L6.22341 7.75C6.23407 7.80715 6.2639 7.85871 6.30776 7.89579C6.35162 7.93287 6.40676 7.95314 6.46367 7.95313H9.18971C9.24663 7.95314 9.30176 7.93287 9.34562 7.89579C9.38948 7.85871 9.41931 7.80715 9.42998 7.75L9.84317 5.59278C9.8525 5.54416 9.84749 5.4938 9.82877 5.44809C9.81005 5.40239 9.77847 5.3634 9.73803 5.33609C9.69759 5.30877 9.65012 5.29436 9.60165 5.29468C9.55318 5.295 9.50589 5.31004 9.4658 5.33789L8.54678 5.98389L8.00701 5.37696C7.98424 5.35102 7.95641 5.33023 7.92532 5.31594C7.89422 5.30164 7.86055 5.29415 7.82646 5.29395ZM7.82646 5.91748L8.32657 6.48243C8.36625 6.52729 8.42051 6.55592 8.47927 6.56302C8.53803 6.57011 8.59731 6.55518 8.64613 6.521L9.24942 6.09668L8.98909 7.45312H6.66381L6.40587 6.09668L7.00726 6.521C7.05603 6.55504 7.11521 6.56989 7.17386 6.5628C7.23251 6.55571 7.28667 6.52716 7.32633 6.48243L7.82646 5.91748ZM4.50476 11.1099C4.55163 11.2066 4.60038 11.3018 4.65188 11.3882C4.72666 11.5137 4.79365 11.627 4.93514 11.71C5.07663 11.793 5.20727 11.7948 5.35166 11.7979C5.49605 11.8005 5.65312 11.7913 5.8064 11.7798C5.95968 11.7678 6.10933 11.7521 6.23296 11.7461C6.35659 11.7408 6.46078 11.7499 6.47322 11.7539C6.48154 11.7567 6.53099 11.7797 6.59408 11.8155L5.08417 14.4771L4.57689 13.4488C4.55558 13.405 4.52219 13.3686 4.48084 13.344C4.4395 13.3195 4.39201 13.3078 4.34427 13.3106L3.21602 13.3809L4.50476 11.1099ZM11.1486 11.1099L12.4374 13.3804L11.311 13.3105C11.2632 13.3077 11.2156 13.3193 11.1742 13.3439C11.1327 13.3684 11.0993 13.4049 11.0779 13.4487L10.5706 14.4766L9.05883 11.8159C9.12243 11.7797 9.17201 11.7563 9.18063 11.7539C9.19302 11.7499 9.29727 11.7404 9.42091 11.7461C9.54454 11.7514 9.69418 11.7677 9.84746 11.7798C10.0007 11.7917 10.1578 11.8009 10.3022 11.7978C10.4466 11.7952 10.5768 11.7928 10.7182 11.7099C10.8597 11.6269 10.9272 11.5136 11.002 11.3882C11.0535 11.3017 11.1018 11.2066 11.1486 11.1099Z\" fill=\"#231F20\"></path>↩\r\n</g>↩\r\n<defs>↩\r\n<clipPath >↩\r\n<rect width=\"15.6522\" height=\"20\" fill=\"white\"></rect>↩\r\n</clipPath>↩\r\n</defs>↩\r\n</svg>', NULL),
(22, 'female-with.svg', '<svg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<g >\r\n<path d=\"M23.7373 22.5294L23.5726 22.3766C19.8052 18.8509 20.7474 14.4388 20.7574 14.3941C20.7772 14.3097 20.7496 14.2294 20.7018 14.1646C20.7178 14.0737 20.7297 14.0108 20.7307 14.0019C21.1482 7.53623 19.9648 3.23858 17.2172 1.23042C14.3274 -0.878086 10.7827 0.325798 10.3294 0.494407C9.9752 0.521613 7.95467 0.770535 6.44533 2.98656C5.18459 4.83751 4.21986 8.24455 5.25253 14.471C5.27191 14.7087 5.27631 14.9343 5.31557 15.1903C5.32307 15.2359 5.35223 15.2672 5.37862 15.3028C3.80933 20.4838 6.46977 25.8504 6.53966 25.9863C6.35916 26.0467 6.18207 26.1093 5.9861 26.1498C5.83085 26.1806 5.73017 26.3354 5.76145 26.4902C5.78817 26.6272 5.91018 26.7213 6.04312 26.7213C6.06348 26.7213 6.08075 26.7203 6.10323 26.7164C7.39329 26.4496 8.34907 25.8107 8.95019 24.8177C9.77499 23.448 9.73345 21.7179 9.58113 20.588C10.4436 21.4987 11.5903 22.1345 13.12 22.2148C13.1343 22.216 13.1462 22.216 13.1615 22.216C13.7548 22.216 14.7114 21.6287 15.6281 20.7052C15.6866 20.6457 15.77 20.5543 15.8462 20.472C15.763 21.7991 15.6502 24.3605 15.9093 25.6114C15.9374 25.7473 16.0575 25.8405 16.1914 25.8405C16.2118 25.8405 16.2302 25.8385 16.2515 25.8346C16.4056 25.8028 16.5073 25.6491 16.4762 25.4943C16.3115 24.7037 16.3095 23.3021 16.3493 22.0719C16.3869 22.0473 16.424 22.0136 16.4475 21.9677C17.9186 19.1864 18.5633 16.7232 18.6536 14.597C19.6436 17.3265 19.1843 21.195 17.249 26.1409C17.1905 26.2898 17.265 26.4584 17.4127 26.5149C17.4465 26.5288 17.4821 26.5358 17.518 26.5358C17.632 26.5358 17.7431 26.4673 17.7868 26.3522C19.9472 20.8309 20.3242 16.5624 18.9087 13.6645C18.8294 13.4998 18.729 13.361 18.638 13.2082C18.3939 10.0839 16.8603 7.83908 15.0331 6.59561C10.4408 3.473 10.784 1.80092 10.7969 1.75238C10.845 1.60397 10.7656 1.44481 10.6164 1.39268C10.466 1.33859 10.3005 1.41907 10.2499 1.56976C10.1793 1.77469 9.69777 3.66474 14.7098 7.07227C16.0549 7.98732 17.2254 9.49372 17.77 11.5341C16.832 10.3273 15.7845 9.37562 14.5767 8.66583C10.7133 6.39507 10.1181 2.48432 10.1142 2.44457C10.0907 2.2903 9.94947 2.17626 9.79324 2.19842C9.63896 2.2178 9.52493 2.35921 9.54138 2.51543C9.54432 2.53075 9.60834 3.20534 9.45797 4.20185C9.44364 4.23215 9.41725 4.25642 9.41432 4.29308C9.41432 4.29796 9.41041 4.37143 9.40829 4.48791C9.18559 5.70515 8.64246 7.30914 7.34409 8.78573L7.28105 8.8561C6.65271 9.57029 5.8908 10.4497 5.48956 11.8008C5.1051 7.40639 5.90269 4.82529 6.91353 3.33241C8.36927 1.18269 10.3224 1.07517 10.4058 1.07224C10.4361 1.07126 10.4688 1.06426 10.499 1.05188C10.5366 1.03754 14.1103 -0.323387 16.8803 1.70008C19.46 3.58427 20.5629 7.71233 20.1652 13.9276C20.1463 14.0079 18.5215 22.0324 22.8107 29.8511C22.8633 29.9464 22.9605 30 23.0627 30C23.1114 30 23.157 29.9881 23.2024 29.9641C23.3414 29.8889 23.3931 29.7123 23.3145 29.5733C21.0597 25.4629 20.4865 21.3064 20.4329 18.3186C20.8278 19.7381 21.6224 21.3421 23.1806 22.8003L23.3492 22.956C24.4532 23.9737 25.4949 24.937 23.4375 28.885C23.3652 29.0269 23.4157 29.2006 23.5595 29.275C23.6003 29.2969 23.6478 29.3067 23.6925 29.3067C23.7977 29.3067 23.8958 29.2511 23.9482 29.153C26.2082 24.809 24.8949 23.5968 23.7373 22.5294ZM7.05689 25.7691C7.05151 25.7563 7.05884 25.7444 7.05395 25.7315C7.02414 25.6732 4.78026 21.1823 5.65719 16.5569C6.15862 18.876 6.9031 21.5236 7.97389 24.574C8.01853 24.7019 8.14755 24.7614 8.27739 24.7475C7.96151 25.177 7.55538 25.5182 7.05689 25.7691ZM8.51751 24.3934C8.51556 24.3895 8.51947 24.3864 8.51751 24.3815C7.26915 20.8264 6.46667 17.8346 5.98203 15.2872C6.22166 14.5507 6.55692 13.823 7.00476 13.1173C7.07269 14.3993 7.39915 17.3465 8.7938 19.5497C8.79478 19.5596 8.78729 19.5686 8.78989 19.5764C8.79885 19.606 9.59726 22.4312 8.51751 24.3934ZM15.2153 20.2954C14.2139 21.3082 13.4194 21.6415 13.146 21.6365C7.53795 21.3498 7.55636 12.5614 7.55734 12.4731C7.55734 12.42 7.52704 12.3793 7.50179 12.3368C8.44714 10.9679 9.42572 9.24285 9.81849 7.0089C10.2248 8.13687 11.0233 9.28944 12.5767 9.75177C14.4371 10.3052 16.6651 11.2104 17.9889 13.2469C17.9889 13.2574 17.978 13.2652 17.9788 13.2758C18.211 16.9615 15.9216 19.5813 15.2153 20.2954ZM16.4037 20.732C16.4353 20.1883 16.4656 19.8093 16.4711 19.7132C16.7562 19.3371 17.0643 18.871 17.3578 18.3384C17.1099 19.1031 16.7969 19.9017 16.4037 20.732ZM10.0373 4.24648C10.6122 5.68088 11.8169 7.71152 14.2769 9.15683C15.0486 9.61069 15.7485 10.1735 16.4017 10.8392C15.2278 10.0396 13.9164 9.54765 12.7409 9.19951C10.5714 8.55473 10.0938 6.36933 9.99752 5.15469C10.0014 4.95334 9.99312 4.74449 9.9871 4.5363C10.0036 4.43839 10.0249 4.33771 10.0373 4.24648ZM7.70754 9.23209L7.76944 9.16074C8.42563 8.41626 8.89187 7.64847 9.23756 6.9079C8.8298 9.20635 7.77889 10.976 6.81269 12.333C6.39011 12.9254 6.07016 13.5379 5.79875 14.1563C5.68048 11.5548 6.78956 10.2742 7.70754 9.23209Z\" fill=\"#231F20\"/>\r\n</g>\r\n<defs>\r\n<clipPath >\r\n<rect width=\"30\" height=\"30\" fill=\"white\"/>\r\n</clipPath>\r\n</defs>\r\n</svg>\r\n', NULL),
(23, 'dress-stylish.svg', '<svg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M11.4687 5.50002C11.1687 5.50002 10.9687 5.30004 10.9687 5.00004C10.9687 3.00006 9.96869 1.00002 8.96873 1.00002C8.66873 1.00002 8.46875 0.800039 8.46875 0.500039C8.46875 0.200039 8.66873 0 8.96873 0C10.7188 0 11.9687 2.65002 11.9687 4.99998C11.9687 5.25 11.7687 5.50002 11.4687 5.50002Z\" fill=\"white\"/>\r\n<path d=\"M19.4687 5.49996C19.1687 5.49996 18.9688 5.29998 18.9688 4.99998C18.9688 2.64996 20.2187 0 21.9687 0C22.2687 0 22.4687 0.19998 22.4687 0.49998C22.4687 0.79998 22.2687 0.999961 21.9687 0.999961C20.9687 0.999961 19.9688 2.99994 19.9688 4.99998C19.9687 5.24994 19.7687 5.49996 19.4687 5.49996Z\" fill=\"white\"/>\r\n<path d=\"M27.9688 28.45C25.7188 26.2 23.7688 23.25 22.1688 20.5H21.9688C18.3688 20.5 14.9688 17.6 14.9688 14C14.9688 17.6 11.5687 20.5 7.96875 20.5H7.76877C6.16875 23.25 4.21875 26.2 1.96875 28.45C1.96875 28.45 1.96875 28.45 2.01873 28.5C7.71873 28.5 12.6187 25.3 14.9687 20.5C17.3188 25.2499 22.2688 28.5 27.9188 28.5C27.9688 28.45 27.9688 28.45 27.9688 28.45Z\" fill=\"white\"/>\r\n<path d=\"M14.9692 9.99998L11.7192 5.3C11.5692 5.10002 11.3692 5 11.1192 5C10.7692 5 10.4692 5.25002 10.3692 5.6L9.6692 8.49998C9.5192 9.09998 9.6692 9.69998 9.9692 10.2L10.0192 10.2499C10.6692 10.9999 10.9692 12.45 10.9692 13.9999C13.1692 13.9999 14.9692 12.1999 14.9692 9.99998Z\" fill=\"white\"/>\r\n<path d=\"M19.9188 10.2C20.2687 9.69998 20.3687 9.09998 20.2187 8.49998L19.5688 5.6C19.4688 5.25002 19.1688 5 18.8188 5C18.5688 5 18.3188 5.10002 18.2188 5.3L14.9688 9.99998C14.9688 12.2 16.7688 14 18.9688 14C19.0188 12.6499 19.3188 11.25 19.9188 10.2Z\" fill=\"white\"/>\r\n<path d=\"M14.9688 10C14.9688 12.2 13.1688 14 10.9688 14H18.9687C16.7688 14 14.9688 12.2 14.9688 10Z\" fill=\"white\"/>\r\n<path d=\"M27.9188 28.4L27.9687 28.45C27.9687 28.45 27.9687 28.45 27.9188 28.5C22.2687 28.5 17.3187 25.25 14.9688 20.5C12.6188 25.25 7.66875 28.5 2.01873 28.5C1.96875 28.4501 1.96875 28.4501 1.96875 28.4501C1.96875 28.4501 2.96877 30.45 7.46877 28.95C7.46877 28.95 9.61875 28.25 11.5188 28.6001C12.3688 28.8 13.2688 29.0001 14.1688 29.0001H14.9688H15.7687C16.6687 29.0001 17.5188 28.8001 18.4188 28.6001C20.3188 28.2 22.4688 28.95 22.4688 28.95C26.9688 30.45 27.9688 28.4501 27.9688 28.4501C27.9687 28.4 27.9188 28.4 27.9188 28.4Z\" fill=\"white\"/>\r\n<path d=\"M21.9688 20.5H22.1687C20.7187 17.95 19.6187 15.55 18.9688 14H16.4688H14.9688C14.9688 17.5999 18.3688 20.5 21.9688 20.5Z\" fill=\"white\"/>\r\n<path d=\"M21.1689 20.5C22.7189 23.25 24.719 26.2 26.969 28.45C27.269 28.45 27.6189 28.5 27.969 28.5C27.969 28.45 28.019 28.45 28.019 28.45C25.769 26.2 23.819 23.25 22.2189 20.5H21.9689H21.1689Z\" fill=\"black\"/>\r\n<path d=\"M20.2685 8.49998L19.6185 5.6C19.5185 5.25002 19.2185 5 18.8685 5C18.6685 5 18.5185 5.04998 18.3685 5.19998C18.4686 5.3 18.5685 5.45 18.6186 5.6L19.2685 8.49998C19.4185 9.09998 19.2685 9.69998 18.9685 10.2L18.9186 10.2499C18.3685 11.1999 18.0685 12.5499 18.0186 13.8999C18.3186 13.9999 18.6685 13.9999 18.9685 13.9999C19.0185 12.6499 19.3185 11.25 19.8685 10.2499L19.9185 10.2C20.2685 9.69998 20.3685 9.09998 20.2685 8.49998Z\" fill=\"black\"/>\r\n<path d=\"M18.9688 14H17.9688C18.6187 15.55 19.7188 17.9 21.1687 20.45C21.4188 20.5 21.7188 20.5 21.9687 20.5H22.1687C20.7188 17.95 19.6188 15.55 18.9688 14Z\" fill=\"black\"/>\r\n<path d=\"M8.76879 20.5C7.16877 23.25 5.21877 26.2 2.96877 28.45C2.66877 28.45 2.31879 28.5 1.96875 28.5C1.96875 28.45 1.96875 28.45 1.96875 28.45C4.21875 26.2 6.16875 23.25 7.76877 20.5H7.96875H8.76879Z\" fill=\"white\"/>\r\n<path d=\"M9.71888 8.49998L10.3689 5.6C10.4689 5.25002 10.7689 5 11.1189 5C11.3188 5 11.4688 5.04998 11.6188 5.19998C11.5188 5.3 11.4189 5.45 11.3688 5.6L10.6688 8.49998C10.5188 9.09998 10.6688 9.69998 10.9688 10.2L11.0188 10.2499C11.5688 11.1999 11.8688 12.5499 11.9188 13.8999C11.6188 13.9499 11.3188 13.9999 10.9688 13.9999C10.9188 12.6499 10.6188 11.25 10.0688 10.2499L10.0188 10.2C9.66884 9.69998 9.56888 9.09998 9.71888 8.49998Z\" fill=\"white\"/>\r\n<path d=\"M7.96951 20.5C11.5695 20.5 14.9695 17.6 14.9695 14H13.4695H10.9695C10.3195 15.55 9.21949 17.95 7.76953 20.5H7.96951Z\" fill=\"white\"/>\r\n<path d=\"M10.9695 14H11.9695C11.3195 15.55 10.2195 17.9 8.76949 20.45C8.51947 20.5 8.26951 20.5 7.96951 20.5H7.76953C9.21943 17.95 10.3195 15.55 10.9695 14Z\" fill=\"white\"/>\r\n<path d=\"M10.9687 5.50002C10.6687 5.50002 10.4687 5.30004 10.4687 5.00004C10.4687 3.00006 9.46869 1.00002 8.46873 1.00002C8.16873 1.00002 7.96875 0.800039 7.96875 0.500039C7.96875 0.200039 8.16867 0 8.46867 0C10.2187 0 11.4687 2.65002 11.4687 4.99998C11.4687 5.25 11.2687 5.50002 10.9687 5.50002Z\" fill=\"black\"/>\r\n<path d=\"M18.9687 5.49996C18.6687 5.49996 18.4688 5.29998 18.4688 4.99998C18.4688 2.64996 19.7187 0 21.4687 0C21.7687 0 21.9687 0.19998 21.9687 0.49998C21.9687 0.79998 21.7687 0.999961 21.4687 0.999961C20.4687 0.999961 19.4688 2.99994 19.4688 4.99998C19.4688 5.24994 19.2687 5.49996 18.9687 5.49996Z\" fill=\"black\"/>\r\n<path d=\"M25.4187 30.0005C24.5187 30.0005 23.4687 29.8005 22.3187 29.4005C22.3187 29.4005 21.0186 29.0005 19.6686 29.0005C19.2686 29.0005 18.8687 29.0504 18.5186 29.1005L18.3686 29.1505C17.5186 29.3504 16.6686 29.5004 15.8186 29.5004H14.1686C13.2686 29.5004 12.4186 29.3005 11.6186 29.1505L11.4686 29.1005C11.1186 29.0505 10.7686 29.0005 10.3186 29.0005C8.91862 29.0005 7.66859 29.4005 7.66859 29.4005C6.46859 29.8005 5.41859 30.0005 4.51859 30.0005C2.61857 30.0005 1.81859 29.1505 1.61861 28.8005C1.61861 28.8005 1.61861 28.8005 1.61861 28.7505V28.7005V28.6505C1.51859 28.4005 1.56862 28.1005 1.81859 28.0006C1.96859 27.9005 2.11859 27.9005 2.26859 28.0006C7.56857 27.9005 12.2686 24.9506 14.5686 20.3006C14.7186 19.9506 15.3186 19.9506 15.4686 20.3006C17.7686 24.9506 22.4186 27.9006 27.6686 28.0006C27.8685 27.8506 28.1186 27.8506 28.2686 28.0006C28.2686 28.0006 28.3185 28.0006 28.3185 28.0505L28.3685 28.1005C28.5185 28.2505 28.5685 28.5005 28.4685 28.7005C28.4685 28.7005 28.4685 28.7505 28.4186 28.7505C28.4186 28.7505 28.4186 28.7505 28.4186 28.8005C28.4186 28.8005 28.4186 28.8505 28.3686 28.8505C28.0687 29.1505 27.3187 30.0005 25.4187 30.0005ZM19.6687 28.0005C21.2187 28.0005 22.5687 28.4505 22.6187 28.4505C23.6687 28.8005 24.6187 29.0005 25.4187 29.0005C25.7687 29.0005 26.0687 28.9505 26.3187 28.9005C21.5687 28.4005 17.3687 25.7005 14.9687 21.5505C12.5687 25.7005 8.4187 28.4005 3.6187 28.9005C3.86872 28.9505 4.16872 29.0005 4.5187 29.0005C5.31868 29.0005 6.26872 28.8005 7.31872 28.4505C7.3687 28.4505 8.76874 28.0005 10.2687 28.0005C10.7687 28.0005 11.2187 28.0505 11.6187 28.1505L11.7687 28.2005C12.5687 28.3505 13.3688 28.5505 14.1188 28.5505H15.7688C16.5687 28.5505 17.3688 28.4005 18.1188 28.2005L18.2688 28.1505C18.7187 28.0505 19.1687 28.0005 19.6687 28.0005Z\" fill=\"black\"/>\r\n<path d=\"M22.1687 21H21.9688C17.9687 21 14.4688 17.75 14.4688 14C14.4688 13.7 14.6687 13.5 14.9687 13.5H18.9688C19.1687 13.5 19.3688 13.6 19.4188 13.8C19.8188 14.75 20.9687 17.35 22.6187 20.25C22.7188 20.4 22.7188 20.6 22.6187 20.75C22.5187 20.9 22.3687 21 22.1687 21ZM15.4687 14.5C15.7687 17.3 18.2687 19.65 21.2687 19.95C19.9687 17.6 19.0187 15.5 18.6187 14.5H15.4687Z\" fill=\"black\"/>\r\n<path d=\"M7.96914 21H7.76915C7.56917 21 7.41917 20.9 7.31916 20.75C7.21914 20.6 7.21914 20.4 7.31916 20.25C8.96916 17.35 10.1192 14.75 10.5191 13.8C10.6192 13.6 10.7692 13.5 10.9691 13.5H14.9692C15.2692 13.5 15.4691 13.7 15.4691 14C15.4691 17.75 11.9692 21 7.96914 21ZM11.3191 14.5C10.8191 15.65 9.91914 17.65 8.6691 19.95C11.6691 19.65 14.2191 17.25 14.4691 14.5H11.3191Z\" fill=\"black\"/>\r\n<path d=\"M27.9191 29C22.5191 29 17.619 26.15 14.9691 21.55C12.3191 26.15 7.41909 29 2.01909 29C1.86909 29 1.66911 28.9 1.61907 28.75L1.56909 28.65C1.41909 28.5 1.46907 28.25 1.61907 28.1C3.51909 26.2 5.46909 23.55 7.31907 20.25C7.41909 20.1 7.56909 20 7.76907 20H7.96905C11.4191 20 14.469 17.2 14.469 14C14.469 13.7 14.669 13.5 14.969 13.5C15.269 13.5 15.469 13.7 15.469 14C15.469 17.2 18.519 20 21.969 20H22.169C22.3689 20 22.5189 20.1 22.619 20.25C24.4689 23.55 26.4189 26.15 28.319 28.1C28.419 28.2 28.469 28.3 28.469 28.45C28.469 28.4999 28.469 28.6 28.419 28.6499C28.419 28.6499 28.369 28.6999 28.319 28.7999C28.269 28.9001 28.119 29 27.9191 29ZM14.9691 20C15.1691 20 15.3191 20.1001 15.4191 20.3C17.6191 24.7 21.9191 27.6001 26.8191 27.95C25.1691 26.15 23.5191 23.8 21.9191 21.0001C18.8691 20.9501 16.0691 19.0001 15.0191 16.4C13.9191 19 11.169 20.95 8.11905 21.0001C6.51903 23.8001 4.86903 26.15 3.21903 27.95C8.11905 27.55 12.419 24.7 14.619 20.3C14.619 20.1001 14.769 20 14.9691 20Z\" fill=\"black\"/>\r\n<path d=\"M10.9693 14.4999C10.6693 14.4999 10.4693 14.2999 10.4693 13.9999C10.4693 12.4499 10.1693 11.1499 9.66931 10.5499L9.61933 10.4999C9.16933 9.84996 9.06931 9.09996 9.21931 8.34996L9.86929 5.44998C9.96931 4.89996 10.4693 4.5 11.0693 4.5C11.4693 4.5 11.8693 4.69998 12.1193 5.05002L15.3693 9.75C15.4193 9.85002 15.4693 9.94998 15.4693 10.05C15.4693 12.4999 13.4693 14.4999 10.9693 14.4999ZM10.4193 9.94986C11.0193 10.6499 11.3692 11.8999 11.4193 13.4999C13.0693 13.2499 14.3693 11.8999 14.4193 10.1999L11.2193 5.6499C11.1193 5.4999 10.8193 5.54988 10.7693 5.74992L10.1193 8.6499C10.0693 9.04986 10.1693 9.5499 10.4193 9.94986Z\" fill=\"black\"/>\r\n<path d=\"M18.9688 14.5C16.4687 14.5 14.4688 12.5 14.4688 9.99996C14.4688 9.89994 14.5187 9.79998 14.5688 9.69996L17.8188 4.99998C18.0688 4.69998 18.4688 4.5 18.8688 4.5C19.4688 4.5 19.9688 4.90002 20.1188 5.50002L20.7688 8.4C20.9188 9.10002 20.7688 9.85002 20.3687 10.5C19.8688 11.35 19.5687 12.65 19.5187 14.05C19.4688 14.2999 19.2688 14.5 18.9688 14.5ZM15.4688 10.15C15.5188 11.8499 16.8688 13.25 18.5188 13.45C18.6188 12.05 18.9687 10.85 19.4687 9.94998L19.5187 9.9C19.7687 9.49998 19.8687 9.04998 19.7687 8.59998L19.1188 5.69994C19.0688 5.49996 18.7688 5.44992 18.6688 5.59992L15.4688 10.15Z\" fill=\"black\"/>\r\n<path d=\"M18.9687 14.4999H10.9687C10.6687 14.4999 10.4688 14.2999 10.4688 13.9999C10.4688 13.6999 10.6687 13.5 10.9687 13.5C12.9187 13.5 14.4687 11.95 14.4687 9.99998C14.4687 9.69998 14.6687 9.5 14.9687 9.5C15.2687 9.5 15.4687 9.69998 15.4687 9.99998C15.4687 11.95 17.0187 13.5 18.9687 13.5C19.2687 13.5 19.4686 13.6999 19.4686 13.9999C19.4687 14.2999 19.2687 14.4999 18.9687 14.4999ZM13.8187 13.4999H16.1687C15.6688 13.0999 15.2687 12.5999 15.0187 12.0499C14.6687 12.5999 14.2687 13.0999 13.8187 13.4999Z\" fill=\"black\"/>\r\n</svg>\r\n', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cc_modules`
--

CREATE TABLE `cc_modules` (
  `module_id` int UNSIGNED NOT NULL,
  `module_name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_key` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_modules`
--

INSERT INTO `cc_modules` (`module_id`, `module_name`, `module_key`, `status`) VALUES
(1, 'Top Search', 'top_search', '1'),
(2, 'Wishlist', 'wishlist', '1'),
(3, 'Compare', 'compare', '1'),
(4, 'Bulk Edit Products', 'bulk_edit_products', '1'),
(5, 'Contact With Whatsapp', 'contact_with_whatsapp', '1'),
(6, 'Coupon', 'coupon', '1'),
(7, 'Image Crop', 'image_crop', '1'),
(8, 'Review', 'review', '1'),
(9, 'Multi option', 'multi_option', '1'),
(10, 'Multi attribute', 'multi_attribute', '1'),
(11, 'Watermark Image', 'watermark', '1'),
(12, 'Multi Category', 'multi_category', '1'),
(13, 'Album', 'album', '1'),
(14, 'Multi Status Update', 'multi_status_update', '1'),
(15, 'Blog', 'blog', '1'),
(16, 'Points', 'point', '1'),
(17, 'Both Products', 'both_products', '1'),
(18, 'Product Guides', 'product_guides', '1'),
(19, 'Other Products', 'other_products', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cc_module_settings`
--

CREATE TABLE `cc_module_settings` (
  `module_settings_id` int UNSIGNED NOT NULL,
  `module_id` int NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_module_settings`
--

INSERT INTO `cc_module_settings` (`module_settings_id`, `module_id`, `label`, `title`, `value`, `time`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 5, NULL, 'Whatsapp number', '01923121212', '2023-10-08 03:56:20', '2023-10-08 09:56:20', NULL, NULL, '2023-12-04 11:01:27'),
(2, 16, 'point_par_doller', 'Point Par Doller ($1)', '1', '2025-03-03 06:11:36', '2025-03-03 12:11:36', NULL, NULL, '2025-04-05 10:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `cc_newsletter`
--

CREATE TABLE `cc_newsletter` (
  `newsletter_id` int UNSIGNED NOT NULL,
  `customer_id` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_newsletter`
--

INSERT INTO `cc_newsletter` (`newsletter_id`, `customer_id`, `email`, `status`) VALUES
(25, '5', 'murad@gmail.com', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cc_offer`
--

CREATE TABLE `cc_offer` (
  `offer_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_name` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `offer_type` enum('distinct','indistinct') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'distinct' COMMENT 'distinct offer mean, if anyone takes a offer, he can not take any other offer with the amount he is buying (Other offer should be calculated based on his rest of the amount after taking the 1st offer). If this is indistinct type offer, he can get other offer on that amount.',
  `offer_on` enum('product','amount') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'amount',
  `qty` int DEFAULT NULL,
  `on_amount` decimal(5,2) NOT NULL,
  `discount_on` enum('product','product_amount','shipping_amount') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'product_amount',
  `discount_percent` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `discount_amount` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `amount` double DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `expire_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_offer`
--

INSERT INTO `cc_offer` (`offer_id`, `name`, `key`, `description`, `banner`, `alt_name`, `slug`, `offer_type`, `offer_on`, `qty`, `on_amount`, `discount_on`, `discount_percent`, `discount_amount`, `amount`, `start_date`, `expire_date`) VALUES
(3, 'Buy One Get 20 % off', 'general_offer', 'Buy One Get 20 % off', 'pro_1757156031_01be31c7a3bbdead6cd0.jpg', 'Buy One Get 20 % off', 'buy-one-get-20--off', 'distinct', 'product', 1, 0.00, 'product_amount', '0', '0', NULL, '2025-09-05 00:00:00', '2025-01-31 00:00:00'),
(4, 'Offer all products', 'zone_based_offer', 'Offer all products', 'pro_1757158462_4ad75d816bba54c4ea23.jpg', 'Offer all products', 'offer-all-products', 'distinct', 'product', 2, 0.00, 'shipping_amount', '0', '0', NULL, '2025-09-05 00:00:00', '2025-01-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cc_offer_discount`
--

CREATE TABLE `cc_offer_discount` (
  `offer_discount_id` int NOT NULL,
  `offer_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `shipping_method_id` int DEFAULT NULL,
  `geo_zone_id` int DEFAULT NULL,
  `discount_calculate_on` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci DEFAULT 'fixed',
  `discount_amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_offer_discount`
--

INSERT INTO `cc_offer_discount` (`offer_discount_id`, `offer_id`, `product_id`, `qty`, `shipping_method_id`, `geo_zone_id`, `discount_calculate_on`, `discount_amount`) VALUES
(21, 4, NULL, NULL, 5, 1, 'fixed', 15),
(22, 4, NULL, NULL, 5, 2, 'percentage', 10),
(23, 4, NULL, NULL, 5, 3, 'percentage', 10),
(24, 4, NULL, NULL, 5, 4, 'percentage', 10),
(32, 3, NULL, NULL, NULL, NULL, 'percentage', 10);

-- --------------------------------------------------------

--
-- Table structure for table `cc_offer_on_product`
--

CREATE TABLE `cc_offer_on_product` (
  `offer_on_product_id` int NOT NULL,
  `offer_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `prod_cat_id` int DEFAULT NULL,
  `brand_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_offer_on_product`
--

INSERT INTO `cc_offer_on_product` (`offer_on_product_id`, `offer_id`, `product_id`, `prod_cat_id`, `brand_id`) VALUES
(9, 4, NULL, NULL, NULL),
(17, 3, 39, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cc_option`
--

CREATE TABLE `cc_option` (
  `option_id` int UNSIGNED NOT NULL,
  `name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_option`
--

INSERT INTO `cc_option` (`option_id`, `name`, `type`, `sort_order`) VALUES
(8, 'Size', 'radio', 0),
(9, 'Color', 'radio', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cc_option_value`
--

CREATE TABLE `cc_option_value` (
  `option_value_id` int UNSIGNED NOT NULL,
  `option_id` int NOT NULL,
  `name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_option_value`
--

INSERT INTO `cc_option_value` (`option_value_id`, `option_id`, `name`, `image`, `sort_order`) VALUES
(11, 8, '35', NULL, 0),
(13, 9, 'Red', NULL, 0),
(14, 9, 'Black', NULL, 0),
(15, 8, '36', NULL, 0),
(17, 8, '37', NULL, 0),
(18, 8, '38', NULL, 0),
(19, 8, '39', NULL, 0),
(20, 8, '40', NULL, 0),
(21, 8, '41', NULL, 0),
(22, 8, '42', NULL, 0),
(23, 8, '43', NULL, 0),
(24, 8, '44', NULL, 0),
(25, 8, '45', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cc_order`
--

CREATE TABLE `cc_order` (
  `order_id` int UNSIGNED NOT NULL,
  `invoice_no` int NOT NULL DEFAULT '0',
  `store_id` int NOT NULL DEFAULT '0',
  `customer_id` int DEFAULT '0',
  `firstname` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(96) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_firstname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_lastname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_address_1` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_address_2` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_city` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_postcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_country` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_country_id` int NOT NULL,
  `payment_phone` int NOT NULL,
  `payment_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_transection_code` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_firstname` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_lastname` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address_1` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address_2` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_postcode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country_id` int DEFAULT NULL,
  `shipping_phone` int DEFAULT NULL,
  `shipping_method` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_charge` decimal(10,4) DEFAULT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci,
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total_point` double DEFAULT NULL,
  `vat` int NOT NULL,
  `discount` decimal(10,4) DEFAULT NULL,
  `final_amount` decimal(10,4) NOT NULL,
  `status` tinyint NOT NULL,
  `payment_status` enum('Pending','Paid','Failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `PM_transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_order`
--

INSERT INTO `cc_order` (`order_id`, `invoice_no`, `store_id`, `customer_id`, `firstname`, `lastname`, `email`, `telephone`, `payment_firstname`, `payment_lastname`, `payment_address_1`, `payment_address_2`, `payment_city`, `payment_postcode`, `payment_country`, `payment_country_id`, `payment_phone`, `payment_email`, `payment_method`, `payment_transection_code`, `shipping_firstname`, `shipping_lastname`, `shipping_address_1`, `shipping_address_2`, `shipping_city`, `shipping_postcode`, `shipping_country`, `shipping_country_id`, `shipping_phone`, `shipping_method`, `shipping_charge`, `comment`, `total`, `total_point`, `vat`, `discount`, `final_amount`, `status`, `payment_status`, `PM_transaction_id`, `ip`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(15, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD.', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '323', '7460', NULL, 18, 2147483647, 'admin@gmail.com', '2', NULL, 'MD.', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '323', '7460', NULL, 18, 2147483647, 'zone_rate', 0.0000, NULL, 109.0000, NULL, 0, 5.0000, 104.0000, 1, 'Pending', NULL, '', '2023-12-26 18:56:31', NULL, NULL, '2023-12-26 18:56:31'),
(16, 0, 1, 0, NULL, NULL, NULL, NULL, 'ffgf', 'dfggf', 'ffsdfd', 'dfsdf', '118', '45758', NULL, 4, 54845484, 'sdfdf@gmail.com', '2', NULL, '', '', '', '', '', '', NULL, NULL, 0, 'flat', 0.0000, NULL, 218.0000, NULL, 0, NULL, 218.0000, 1, 'Pending', NULL, '', '2023-12-28 10:49:11', NULL, NULL, '2023-12-28 10:49:11'),
(17, 0, 1, 0, NULL, NULL, NULL, NULL, 'df', 'dfggf', 'ffsdfd', 'dfsdf', '191', '7877', NULL, 13, 123456789, 'sdf@xc.co', '2', NULL, 'sddf', 'dfdf', '5', 'dfsdf', '33', '12345', NULL, NULL, 123456789, 'flat', 0.0000, NULL, 112.0000, NULL, 0, NULL, 112.0000, 1, 'Pending', NULL, '', '2024-01-01 12:47:16', NULL, NULL, '2024-01-01 12:47:16'),
(18, 0, 1, 0, NULL, NULL, NULL, NULL, 'ffgf', 'dfggf', 'ffsdfd', 'dfsdf', '71', '12345678', NULL, 3, 1542553, 'dd@gmail.com', '2', NULL, 'sddf', 'dfdf', 'dfsdfd', 'dfsdf', '1', '124585', NULL, NULL, 2147483647, 'flat', 0.0000, NULL, 1962.0000, NULL, 0, NULL, 1962.0000, 5, 'Pending', NULL, '', '2024-01-01 13:06:35', NULL, NULL, '2024-01-10 12:56:00'),
(19, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 2147483647, 'khan@mail.co', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 2147483647, 'flat', 5.0000, NULL, 228.0000, NULL, 0, NULL, 233.0000, 1, 'Pending', NULL, '', '2024-01-08 20:08:42', NULL, NULL, '2024-01-08 20:08:42'),
(20, 0, 1, 12, NULL, NULL, NULL, NULL, 'md jubaer', 'rahman', 'ffsdfd', 'dfsdf', '122', '123456', NULL, 5, 1703165333, 'apurefashion@gmail.com', '2', NULL, 'md jubaer', 'rahman', 'ffsdfd', 'dfsdf', '122', '123456', NULL, 5, 1703165333, 'flat', 5.0000, NULL, 110.0000, NULL, 0, NULL, 115.0000, 7, 'Pending', NULL, '', '2024-01-10 10:07:14', NULL, NULL, '2024-01-10 10:32:58'),
(21, 0, 1, 12, NULL, NULL, NULL, NULL, 'md jubaer', 'rahman', 'ffsdfd', 'dfsdf', '2', '654847', NULL, 1, 1703165333, 'apurefashion@gmail.com', '2', NULL, 'md jubaer', 'rahman', 'ffsdfd', 'dfsdf', '2', '654847', NULL, 1, 1703165333, 'flat', 5.0000, NULL, 485.0000, NULL, 0, NULL, 490.0000, 2, 'Pending', NULL, '', '2024-01-23 18:33:12', NULL, NULL, '2024-01-23 18:36:52'),
(22, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'hngjh', '320', '7460', NULL, 18, 2147483647, 'khan@mail.co', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'hngjh', '320', '7460', NULL, 18, 2147483647, 'zone_rate', 0.0000, NULL, 218.0000, NULL, 0, NULL, 218.0000, 1, 'Pending', NULL, '', '2024-01-23 18:39:52', NULL, NULL, '2024-01-23 18:39:52'),
(23, 0, 1, 0, NULL, NULL, NULL, NULL, 'ffgf', 'dfggf', 'ffsdfd', 'dfsdf', '82', '5000', NULL, 3, 1542553, 'sdfdf@gmail.com', '2', NULL, 'ffgf', 'dfggf', 'ffsdfd', 'dfsdf', '82', '5000', NULL, 3, 1542553, 'flat', 5.0000, NULL, 65.0000, NULL, 0, NULL, 70.0000, 1, 'Pending', NULL, '', '2024-02-20 17:52:58', NULL, NULL, '2024-02-20 17:52:58'),
(24, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 0.0000, NULL, 102.0000, NULL, 0, NULL, 102.0000, 1, 'Pending', NULL, '', '2024-05-09 11:17:39', NULL, NULL, '2024-05-09 11:17:39'),
(25, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '9', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 55.0000, NULL, 0, NULL, 60.0000, 7, 'Pending', NULL, '', '2024-06-02 19:24:24', NULL, NULL, '2024-06-30 20:28:34'),
(26, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '9', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 15.0000, NULL, 0, NULL, 20.0000, 0, 'Pending', NULL, '', '2024-06-02 19:29:23', NULL, NULL, '2024-06-02 19:29:23'),
(28, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 5.0000, NULL, 0, NULL, 10.0000, 2, 'Pending', NULL, '', '2024-06-29 10:31:05', NULL, NULL, '2024-06-29 10:32:10'),
(29, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'flat', 5.0000, NULL, 350.0000, NULL, 0, NULL, 355.0000, 1, 'Pending', NULL, '', '2024-06-30 20:33:02', NULL, NULL, '2024-06-30 20:33:02'),
(30, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '8', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'flat', 5.0000, NULL, 25.0000, NULL, 0, NULL, 30.0000, 2, 'Pending', NULL, '', '2024-06-30 20:33:34', NULL, NULL, '2024-07-01 20:14:29'),
(31, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 78.0000, NULL, 0, NULL, 83.0000, 7, 'Pending', NULL, '', '2024-08-10 10:42:56', NULL, NULL, '2024-11-20 18:06:04'),
(32, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '10', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 55.0000, NULL, 0, NULL, 60.0000, 0, 'Paid', NULL, '', '2024-12-30 17:26:02', NULL, NULL, '2024-12-30 17:27:41'),
(33, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 2147483647, 'khan@mail.co', '10', NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 2147483647, 'flat', 5.0000, NULL, 15.0000, NULL, 0, NULL, 20.0000, 0, 'Pending', NULL, '', '2024-12-30 17:34:05', NULL, NULL, '2024-12-30 17:34:05'),
(34, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 2147483647, 'admin@gmail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 2147483647, 'flat', 5.0000, NULL, 5.0000, NULL, 0, NULL, 10.0000, 0, 'Pending', NULL, '', '2024-12-30 18:12:34', NULL, NULL, '2024-12-30 18:12:34'),
(35, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 4354464, 'admin@gmail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 4354464, 'flat', 5.0000, NULL, 5.0000, NULL, 0, NULL, 10.0000, 0, 'Paid', NULL, '', '2024-12-30 18:14:15', NULL, NULL, '2024-12-30 18:16:09'),
(36, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'Don', 'Buinkara (Driver para)', 'Dhaka', '320', '7460', NULL, 18, 8877, 'khan@mail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'Don', 'Buinkara (Driver para)', 'Dhaka', '320', '7460', NULL, 18, 8877, 'flat', 5.0000, NULL, 15.0000, NULL, 0, NULL, 20.0000, 0, 'Pending', NULL, '', '2024-12-30 18:23:17', NULL, NULL, '2024-12-30 18:23:17'),
(37, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '321', '7460', NULL, 18, 6546, 'khan@mail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '321', '7460', NULL, 18, 6546, 'flat', 5.0000, NULL, 15.0000, NULL, 0, NULL, 20.0000, 0, 'Pending', NULL, '', '2024-12-30 18:31:42', NULL, NULL, '2024-12-30 18:31:42'),
(38, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'Don', 'Buinkara (Driver para)', 'Dhaka', '321', '7460', NULL, 18, 34345, 'khan@mail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'Don', 'Buinkara (Driver para)', 'Dhaka', '321', '7460', NULL, 18, 34345, 'flat', 5.0000, NULL, 5.0000, NULL, 0, NULL, 10.0000, 0, 'Pending', NULL, '', '2024-12-30 18:33:24', NULL, NULL, '2024-12-30 18:33:24'),
(39, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '321', '7460', NULL, 18, 4564646, 'khan@mail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '321', '7460', NULL, 18, 4564646, 'flat', 5.0000, NULL, 55.0000, NULL, 0, NULL, 60.0000, 0, 'Paid', NULL, '', '2024-12-30 18:35:52', NULL, NULL, '2024-12-30 18:36:55'),
(40, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '10', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 55.0000, NULL, 0, NULL, 60.0000, 0, 'Paid', NULL, '', '2024-12-31 16:46:09', NULL, NULL, '2024-12-31 16:47:29'),
(41, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '321', '7460', NULL, 18, 4565646, 'khan@mail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '321', '7460', NULL, 18, 4565646, 'flat', 5.0000, NULL, 5.0000, NULL, 0, NULL, 10.0000, 0, 'Paid', NULL, '', '2025-01-01 17:06:43', NULL, NULL, '2025-01-23 17:28:01'),
(42, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '10', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 55.0000, NULL, 0, NULL, 60.0000, 0, 'Paid', NULL, '', '2025-01-02 11:00:42', NULL, NULL, '2025-01-02 11:01:24'),
(43, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '10', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 15.0000, NULL, 0, NULL, 20.0000, 0, 'Paid', 'EC-677622042f353-fNZtmsh-43', '', '2025-01-02 11:20:02', NULL, NULL, '2025-01-26 18:44:28'),
(44, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 43545645, 'khan@mail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 43545645, 'flat', 5.0000, NULL, 15.0000, NULL, 0, 0.2500, 19.7500, 5, 'Paid', NULL, '', '2025-02-03 17:54:02', NULL, NULL, '2025-04-05 17:56:59'),
(45, 0, 1, 0, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '323', '7460', NULL, 18, 2147483647, 'admin@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'khan', 'Buinkara (Driver para)', 'Dhaka', '323', '7460', NULL, 18, 2147483647, 'flat', 5.0000, NULL, 55.0000, NULL, 0, 0.2500, 59.7500, 5, 'Paid', NULL, '', '2025-02-12 17:51:29', NULL, NULL, '2025-04-05 17:56:24'),
(46, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'flat', 5.0000, NULL, 15.0000, 80, 0, 2.5000, 17.5000, 5, 'Paid', NULL, '', '2025-03-03 12:09:36', NULL, NULL, '2025-03-03 12:13:24'),
(47, 0, 1, 16, NULL, NULL, NULL, NULL, 'Jone', 'Done', 'Dhaka', 'Dhaka', '315', '4544', NULL, 17, 1744445422, 'jone@gmail.com', '2', NULL, 'Jone', 'Done', 'Dhaka', 'Dhaka', '315', '4544', NULL, 17, 1744445422, 'flat', 5.0000, NULL, 30.0000, 150, 0, 0.2500, 34.7500, 5, 'Paid', NULL, '', '2025-03-03 16:26:10', NULL, NULL, '2025-03-03 16:34:16'),
(48, 0, 1, 16, NULL, NULL, NULL, NULL, 'Jone', 'Done', 'Dhaka', 'Dhaka Mirpur', '322', '1000', NULL, 18, 1744445422, 'jone@gmail.com', '2', NULL, 'Jone', 'Done', 'Dhaka', 'Dhaka Mirpur', '322', '1000', NULL, 18, 1744445422, 'flat', 5.0000, NULL, 55.0000, 275, 0, NULL, 60.0000, 5, 'Paid', NULL, '', '2025-03-03 16:35:05', NULL, NULL, '2025-03-03 16:35:28'),
(49, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '4240', '7460', NULL, 188, 1923171718, 'zone_rate', 34.0000, NULL, 99.5000, 497.5, 0, NULL, 133.5000, 1, 'Paid', NULL, '', '2025-03-10 10:23:52', NULL, NULL, '2025-03-10 10:24:07'),
(50, 0, 1, 17, NULL, NULL, NULL, NULL, 'Jemmy', 'Carter', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 1714070711, 'carter@gmail.com', '2', NULL, 'Jemmy', 'Carter', 'Buinkara (Driver para)', 'Dhaka', '322', '7460', NULL, 18, 1714070711, 'flat', 5.0000, NULL, 15.0000, NULL, 0, 2.5000, 17.5000, 1, 'Pending', NULL, '', '2025-03-10 15:05:09', NULL, NULL, '2025-03-10 15:05:09'),
(51, 0, 1, 17, NULL, NULL, NULL, NULL, 'Jemmy', 'Carter', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070711, 'carter@gmail.com', '2', NULL, 'Jemmy', 'Carter', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070711, 'flat', 5.0000, NULL, 55.0000, 275, 0, NULL, 60.0000, 5, 'Paid', NULL, '', '2025-03-10 15:08:13', NULL, NULL, '2025-03-10 15:09:32'),
(61, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'flat', 5.0000, NULL, 99.5000, NULL, 0, 19.9000, 84.6000, 1, 'Pending', NULL, '', '2025-09-06 17:31:56', NULL, NULL, '2025-09-06 17:31:56'),
(63, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'zone_rate', 100.0000, NULL, 99.5000, NULL, 0, 10.0000, 189.5000, 1, 'Pending', NULL, '', '2025-09-06 17:48:36', NULL, NULL, '2025-09-06 17:48:36'),
(64, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'zone_rate', 100.0000, NULL, 199.0000, NULL, 0, 10.0000, 289.0000, 1, 'Pending', NULL, '', '2025-09-06 18:02:07', NULL, NULL, '2025-09-06 18:02:07'),
(65, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'flat', 5.0000, NULL, 268.0000, 268, 0, 0.5000, 272.5000, 5, 'Paid', NULL, '', '2025-09-06 19:40:30', NULL, NULL, '2025-09-06 20:54:58'),
(67, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'flat', 5.0000, NULL, 15.0000, NULL, 0, 0.0000, 20.0000, 1, 'Pending', NULL, '', '2025-09-16 17:36:54', NULL, NULL, '2025-09-16 17:36:54'),
(68, 0, 1, 0, NULL, NULL, NULL, NULL, 'md', 'khan', 'Nowapara', 'Dhaka Mirpur', '191', '6435', NULL, 13, 574446545, 'dnationsoftbd5@gmail.com', '2', NULL, 'md', 'khan', 'Nowapara', 'Dhaka Mirpur', '191', '6435', NULL, 13, 574446545, 'flat', 5.0000, NULL, 228.0000, NULL, 0, 0.0000, 233.0000, 1, 'Pending', NULL, '', '2025-09-23 18:02:50', NULL, NULL, '2025-09-23 18:02:50'),
(74, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '324', '7460', NULL, 18, 1714070771, 'flat', 5.0000, NULL, 88.0000, NULL, 0, 0.0000, 93.0000, 1, 'Pending', NULL, '', '2025-10-02 12:21:51', NULL, NULL, '2025-10-02 12:21:51'),
(76, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'sk', 'john', 'london', 'london', '191', '6543', NULL, 13, 2147483647, 'flat', 5.0000, NULL, 299.9900, NULL, 0, 0.0000, 304.9900, 1, 'Pending', NULL, '', '2025-10-04 19:53:00', NULL, NULL, '2025-10-04 19:53:00'),
(77, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'sk', 'john', 'london', 'london', '156', '8765', NULL, 10, 878665577, 'flat', 5.0000, NULL, 228.0000, NULL, 0, 0.0000, 233.0000, 1, 'Pending', NULL, '', '2025-10-04 19:55:08', NULL, NULL, '2025-10-04 19:55:08'),
(79, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'zone_rate', 100.0000, NULL, 109.5000, NULL, 0, 0.0000, 209.5000, 15, 'Pending', NULL, '', '2025-12-22 12:28:05', NULL, NULL, '2025-12-22 12:29:03'),
(80, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'murad@gmail.com', '2', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'zone_rate', 150.0000, NULL, 519.0000, NULL, 0, 0.0000, 669.0000, 1, 'Pending', NULL, '', '2025-12-22 18:28:37', NULL, NULL, '2025-12-22 18:28:37'),
(81, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'murad@gmail.com', '4', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'zone_rate', 100.0000, NULL, 656.0000, NULL, 0, 0.0000, 756.0000, 1, 'Pending', NULL, '', '2025-12-23 10:22:58', NULL, NULL, '2025-12-23 10:22:58'),
(82, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Nowapara', 'Dhaka Mirpur', '69', '6543', NULL, 3, 2147483647, 'khansk@gmail.com', '2', NULL, 'Sk', 'khan', 'Nowapara', 'Dhaka Mirpur', '69', '6543', NULL, 3, 2147483647, 'flat', 5.0000, NULL, 176.0000, NULL, 0, 0.0000, 181.0000, 1, 'Pending', NULL, '', '2025-12-31 18:57:47', NULL, NULL, '2025-12-31 18:57:47'),
(83, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 2147483647, 'khansk@gmail.com', '2', NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 2147483647, 'flat', 5.0000, NULL, 130.0000, NULL, 0, 0.0000, 135.0000, 1, 'Pending', NULL, '', '2026-02-11 19:25:17', NULL, NULL, '2026-02-11 19:25:17'),
(84, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 786766567, 'khansk@gmail.com', '2', NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 786766567, 'zone_rate', 10.0000, NULL, 350.0000, NULL, 0, 0.0000, 360.0000, 1, 'Pending', NULL, '', '2026-03-15 12:38:17', NULL, NULL, '2026-03-15 12:38:17'),
(85, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'zone_rate', 100.0000, NULL, 356.0000, NULL, 0, 0.0000, 456.0000, 1, 'Pending', NULL, '', '2026-03-15 16:32:00', NULL, NULL, '2026-03-15 16:32:00'),
(87, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 2147483647, 'khansk@gmail.com', '2', NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 2147483647, 'zone_rate', 10.0000, NULL, 343.0000, NULL, 0, 0.0000, 353.0000, 1, 'Pending', NULL, '', '2026-03-16 15:21:06', NULL, NULL, '2026-03-16 15:21:06'),
(88, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 654654656, 'khansk@gmail.com', '2', NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 654654656, 'flat', 5.0000, NULL, 343.0000, NULL, 0, 0.0000, 348.0000, 1, 'Pending', NULL, '', '2026-03-18 15:56:32', NULL, NULL, '2026-03-18 15:56:32'),
(89, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '195', '7460', NULL, 13, 66777676, 'khansk@gmail.com', '2', NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '195', '7460', NULL, 13, 66777676, 'flat', 5.0000, NULL, 178.0000, NULL, 0, 0.0000, 183.0000, 1, 'Pending', NULL, '', '2026-03-18 16:14:39', NULL, NULL, '2026-03-18 16:14:39'),
(90, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'zone_rate', 100.0000, NULL, 75.0000, NULL, 0, 0.0000, 175.0000, 1, 'Pending', NULL, '', '2026-04-04 13:18:00', NULL, NULL, '2026-04-04 13:18:00'),
(91, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '197', '7460', NULL, 13, 2147483647, 'khansk@gmail.com', '2', NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '197', '7460', NULL, 13, 2147483647, 'zone_rate', 10.0000, NULL, 350.0000, NULL, 0, 0.0000, 360.0000, 1, 'Pending', NULL, '', '2026-04-04 17:48:27', NULL, NULL, '2026-04-04 17:48:27'),
(94, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'DDF', 'Dhaka', 'Dhaka', '197', '7460', NULL, 13, 3435455, 'khansk@gmail.com', '10', NULL, 'Sk', 'DDF', 'Dhaka', 'Dhaka', '197', '7460', NULL, 13, 3435455, 'zone_rate', 10.0000, NULL, 700.0000, NULL, 0, 0.0000, 710.0000, 1, 'Pending', NULL, '', '2026-04-05 12:57:02', NULL, NULL, '2026-04-05 12:57:02'),
(95, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'murad', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 978768685, 'khansk@gmail.com', '10', NULL, 'Sk', 'murad', 'Dhaka', 'Dhaka', '191', '7460', NULL, 13, 978768685, 'zone_rate', 20.0000, NULL, 450.0000, NULL, 0, 0.0000, 470.0000, 1, 'Pending', NULL, '', '2026-04-05 13:01:04', NULL, NULL, '2026-04-05 13:01:04'),
(96, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '5', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'zone_rate', 150.0000, NULL, 1715.0000, NULL, 0, 0.0000, 1.0000, 1, 'Pending', NULL, '', '2026-04-05 18:22:59', NULL, NULL, '2026-04-05 18:22:59'),
(97, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '2', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'zone_rate', 100.0000, NULL, 1050.0000, NULL, 0, 0.0000, 1150.0000, 1, 'Pending', NULL, '', '2026-04-09 15:45:26', NULL, NULL, '2026-04-09 15:45:26'),
(98, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'flat', 5.0000, NULL, 228.0000, 228, 0, 0.0000, 233.0000, 0, 'Failed', NULL, '', '2026-04-09 15:46:45', NULL, NULL, '2026-04-09 15:50:20'),
(99, 0, 1, 5, NULL, NULL, NULL, NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'murad@gmail.com', '9', NULL, 'md', 'murad', 'Nowapara', 'Nowapara', '323', '7460', NULL, 18, 1923171718, 'flat', 5.0000, NULL, 399.4900, NULL, 0, 0.0000, 404.4900, 1, 'Pending', NULL, '', '2026-04-11 09:57:01', NULL, NULL, '2026-04-11 09:57:01'),
(100, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '197', '7460', NULL, 13, 76567858, 'khansk@gmail.com', '9', NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '197', '7460', NULL, 13, 76567858, 'zone_rate', 10.0000, NULL, 343.0000, NULL, 0, 0.0000, 353.0000, 0, 'Paid', NULL, '', '2026-04-11 12:02:32', NULL, NULL, '2026-04-11 12:02:32'),
(101, 0, 1, 0, NULL, NULL, NULL, NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '195', '7460', NULL, 13, 4454545, 'khansk@gmail.com', '9', NULL, 'Sk', 'khan', 'Dhaka', 'Dhaka', '195', '7460', NULL, 13, 4454545, 'flat', 5.0000, NULL, 350.0000, NULL, 0, 0.0000, 355.0000, 0, 'Paid', NULL, '', '2026-04-11 12:18:28', NULL, NULL, '2026-04-11 12:18:28'),
(102, 0, 1, 9, NULL, NULL, NULL, NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'dnationsoftbd5@gmail.com', '10', NULL, 'MD. TARIQUL ISLAM', 'ISLAM', 'Buinkara (Driver para)', 'Dhaka Mirpur', '322', '7460', NULL, 18, 1714070771, 'flat', 5.0000, NULL, 343.0000, 343, 0, 0.0000, 348.0000, 0, 'Paid', NULL, '', '2026-05-03 16:49:31', NULL, NULL, '2026-05-03 16:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `cc_order_card_details`
--

CREATE TABLE `cc_order_card_details` (
  `order_card_details_id` int UNSIGNED NOT NULL,
  `order_id` int NOT NULL,
  `payment_method_id` int NOT NULL,
  `card_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_number` bigint NOT NULL,
  `card_expiration` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_cvc` int NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cc_order_history`
--

CREATE TABLE `cc_order_history` (
  `order_history_id` int UNSIGNED NOT NULL,
  `order_id` int NOT NULL,
  `order_status_id` int NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_order_history`
--

INSERT INTO `cc_order_history` (`order_history_id`, `order_id`, `order_status_id`, `notify`, `comment`, `date_added`) VALUES
(23, 15, 1, 0, '', '2023-12-26 18:56:31'),
(24, 16, 1, 0, '', '2023-12-28 10:49:11'),
(25, 17, 1, 0, '', '2024-01-01 12:47:16'),
(26, 18, 1, 0, '', '2024-01-01 13:06:35'),
(27, 18, 2, 0, 'sfrdsf', '2024-01-08 18:46:32'),
(28, 19, 1, 0, '', '2024-01-08 20:08:42'),
(30, 20, 1, 0, '', '2024-01-10 10:07:14'),
(31, 20, 2, 0, 'ok', '2024-01-10 10:26:42'),
(32, 20, 2, 0, 'sd', '2024-01-10 10:27:13'),
(33, 20, 2, 0, 'ok', '2024-01-10 10:28:28'),
(37, 20, 7, 0, 'canceled', '2024-01-10 10:32:58'),
(38, 18, 2, 0, 'ok.', '2024-01-10 10:35:00'),
(39, 18, 2, 0, 'ok', '2024-01-10 10:35:23'),
(40, 18, 5, 0, 'k', '2024-01-10 12:56:00'),
(41, 21, 1, 0, '', '2024-01-23 18:33:12'),
(42, 21, 2, 0, 'cvbdf', '2024-01-23 18:36:52'),
(43, 22, 1, 0, '', '2024-01-23 18:39:52'),
(44, 23, 1, 0, '', '2024-02-20 17:52:58'),
(45, 24, 1, 0, '', '2024-05-09 11:17:39'),
(46, 25, 1, 0, '', '2024-06-02 19:24:24'),
(47, 26, 1, 0, '', '2024-06-02 19:29:23'),
(49, 25, 5, 0, 'dfghf', '2024-06-27 17:22:17'),
(50, 28, 1, 0, '', '2024-06-29 10:31:05'),
(51, 28, 2, 0, 'cvcv', '2024-06-29 10:32:10'),
(52, 25, 7, 0, 'dsfgdggv', '2024-06-30 20:28:34'),
(53, 29, 1, 0, '', '2024-06-30 20:33:02'),
(54, 30, 1, 0, '', '2024-06-30 20:33:34'),
(55, 30, 2, 0, 'tt', '2024-07-01 20:14:29'),
(56, 31, 1, 0, '', '2024-08-10 10:42:56'),
(57, 31, 5, 0, 'ghfvguy', '2024-10-08 13:04:50'),
(58, 31, 7, 0, 'fdgdfgdf', '2024-11-20 18:06:04'),
(59, 32, 1, 0, '', '2024-12-30 17:26:02'),
(60, 33, 1, 0, '', '2024-12-30 17:34:05'),
(61, 34, 1, 0, '', '2024-12-30 18:12:34'),
(62, 35, 1, 0, '', '2024-12-30 18:14:15'),
(63, 36, 1, 0, '', '2024-12-30 18:23:17'),
(64, 37, 1, 0, '', '2024-12-30 18:31:42'),
(65, 38, 1, 0, '', '2024-12-30 18:33:24'),
(66, 39, 1, 0, '', '2024-12-30 18:35:52'),
(67, 40, 1, 0, '', '2024-12-31 16:46:09'),
(68, 41, 1, 0, '', '2025-01-01 17:06:43'),
(69, 42, 1, 0, '', '2025-01-02 11:00:42'),
(70, 43, 1, 0, '', '2025-01-02 11:20:02'),
(71, 44, 1, 0, '', '2025-02-03 17:54:02'),
(72, 45, 1, 0, '', '2025-02-12 17:51:29'),
(73, 46, 1, 0, '', '2025-03-03 12:09:36'),
(74, 46, 5, 0, 't', '2025-03-03 12:12:57'),
(75, 47, 1, 0, '', '2025-03-03 16:26:10'),
(76, 47, 5, 0, 'hjhjhjhjg', '2025-03-03 16:34:16'),
(77, 48, 1, 0, '', '2025-03-03 16:35:05'),
(78, 48, 5, 0, 'fdfgdfgd', '2025-03-03 16:35:28'),
(79, 49, 1, 0, '', '2025-03-10 10:23:52'),
(80, 50, 1, 0, '', '2025-03-10 15:05:09'),
(81, 51, 1, 0, '', '2025-03-10 15:08:13'),
(82, 51, 5, 0, 'hfghfghfh', '2025-03-10 15:09:32'),
(87, 45, 5, 0, 'ghfbb', '2025-04-05 17:56:24'),
(88, 44, 5, 0, 'fhgfhhf', '2025-04-05 17:56:59'),
(97, 61, 1, 0, '', '2025-09-06 17:31:56'),
(99, 63, 1, 0, '', '2025-09-06 17:48:36'),
(100, 64, 1, 0, '', '2025-09-06 18:02:07'),
(101, 65, 1, 0, '', '2025-09-06 19:40:30'),
(102, 65, 5, 0, 'guiyiloo', '2025-09-06 20:54:58'),
(104, 67, 1, 0, '', '2025-09-16 17:36:54'),
(105, 68, 1, 0, '', '2025-09-23 18:02:50'),
(111, 74, 1, 0, '', '2025-10-02 12:21:51'),
(113, 76, 1, 0, '', '2025-10-04 19:53:00'),
(114, 77, 1, 0, '', '2025-10-04 19:55:08'),
(116, 79, 1, 0, '', '2025-12-22 12:28:05'),
(117, 79, 15, 0, 'test', '2025-12-22 12:29:03'),
(118, 80, 1, 0, '', '2025-12-22 18:28:37'),
(119, 81, 1, 0, '', '2025-12-23 10:22:58'),
(120, 82, 1, 0, '', '2025-12-31 18:57:47'),
(121, 83, 1, 0, '', '2026-02-11 19:25:17'),
(122, 84, 1, 0, '', '2026-03-15 12:38:17'),
(123, 85, 1, 0, '', '2026-03-15 16:32:00'),
(125, 87, 1, 0, '', '2026-03-16 15:21:06'),
(126, 88, 1, 0, '', '2026-03-18 15:56:32'),
(127, 89, 1, 0, '', '2026-03-18 16:14:39'),
(128, 90, 1, 0, '', '2026-04-04 13:18:00'),
(129, 91, 1, 0, '', '2026-04-04 17:48:27'),
(132, 94, 1, 0, '', '2026-04-05 12:57:02'),
(133, 95, 1, 0, '', '2026-04-05 13:01:04'),
(134, 96, 1, 0, '', '2026-04-05 18:22:59'),
(135, 97, 1, 0, '', '2026-04-09 15:45:26'),
(136, 98, 1, 0, '', '2026-04-09 15:46:45'),
(137, 99, 1, 0, '', '2026-04-11 09:57:01'),
(138, 100, 1, 0, '', '2026-04-11 12:02:32'),
(139, 101, 1, 0, '', '2026-04-11 12:18:28'),
(140, 102, 1, 0, '', '2026-05-03 16:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `cc_order_item`
--

CREATE TABLE `cc_order_item` (
  `order_item` int UNSIGNED NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` double UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `total_price` double UNSIGNED NOT NULL,
  `discount` int DEFAULT NULL,
  `final_price` double UNSIGNED NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_order_item`
--

INSERT INTO `cc_order_item` (`order_item`, `order_id`, `product_id`, `price`, `quantity`, `total_price`, `discount`, `final_price`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(17, 15, 39, 109, 1, 109, NULL, 109, '2023-12-26 18:56:31', NULL, NULL, '2023-12-26 18:56:31'),
(18, 16, 39, 109, 2, 218, NULL, 218, '2023-12-28 10:49:11', NULL, NULL, '2023-12-28 10:49:11'),
(19, 17, 39, 112, 1, 112, NULL, 112, '2024-01-01 12:47:16', NULL, NULL, '2024-01-01 12:47:16'),
(20, 18, 39, 109, 18, 1962, NULL, 1962, '2024-01-01 13:06:35', NULL, NULL, '2024-01-01 13:06:35'),
(21, 19, 23, 228, 1, 228, NULL, 228, '2024-01-08 20:08:42', NULL, NULL, '2024-01-08 20:08:42'),
(22, 20, 36, 55, 2, 110, NULL, 110, '2024-01-10 10:07:14', NULL, NULL, '2024-01-10 10:07:14'),
(23, 21, 14, 485, 1, 485, NULL, 485, '2024-01-23 18:33:12', NULL, NULL, '2024-01-23 18:33:12'),
(24, 22, 39, 109, 2, 218, NULL, 218, '2024-01-23 18:39:52', NULL, NULL, '2024-01-23 18:39:52'),
(25, 23, 42, 65, 1, 65, NULL, 65, '2024-02-20 17:52:58', NULL, NULL, '2024-02-20 17:52:58'),
(26, 24, 39, 102, 1, 102, NULL, 102, '2024-05-09 11:17:39', NULL, NULL, '2024-05-09 11:17:39'),
(27, 25, 33, 55, 1, 55, NULL, 55, '2024-06-02 19:24:24', NULL, NULL, '2024-06-02 19:24:24'),
(28, 26, 32, 15, 1, 15, NULL, 15, '2024-06-02 19:29:23', NULL, NULL, '2024-06-02 19:29:23'),
(30, 28, 31, 5, 1, 5, NULL, 5, '2024-06-29 10:31:05', NULL, NULL, '2024-06-29 10:31:05'),
(31, 29, 5, 350, 1, 350, NULL, 350, '2024-06-30 20:33:02', NULL, NULL, '2024-06-30 20:33:02'),
(32, 30, 28, 25, 1, 25, NULL, 25, '2024-06-30 20:33:34', NULL, NULL, '2024-06-30 20:33:34'),
(33, 31, 7, 78, 1, 78, NULL, 78, '2024-08-10 10:42:56', NULL, NULL, '2024-08-10 10:42:56'),
(34, 32, 72, 55, 1, 55, NULL, 55, '2024-12-30 17:26:02', NULL, NULL, '2024-12-30 17:26:02'),
(35, 33, 32, 15, 1, 15, NULL, 15, '2024-12-30 17:34:05', NULL, NULL, '2024-12-30 17:34:05'),
(36, 34, 31, 5, 1, 5, NULL, 5, '2024-12-30 18:12:34', NULL, NULL, '2024-12-30 18:12:34'),
(37, 35, 31, 5, 1, 5, NULL, 5, '2024-12-30 18:14:15', NULL, NULL, '2024-12-30 18:14:15'),
(38, 36, 32, 15, 1, 15, NULL, 15, '2024-12-30 18:23:17', NULL, NULL, '2024-12-30 18:23:17'),
(39, 37, 32, 15, 1, 15, NULL, 15, '2024-12-30 18:31:42', NULL, NULL, '2024-12-30 18:31:42'),
(40, 38, 31, 5, 1, 5, NULL, 5, '2024-12-30 18:33:24', NULL, NULL, '2024-12-30 18:33:24'),
(41, 39, 33, 55, 1, 55, NULL, 55, '2024-12-30 18:35:52', NULL, NULL, '2024-12-30 18:35:52'),
(42, 40, 72, 55, 1, 55, NULL, 55, '2024-12-31 16:46:09', NULL, NULL, '2024-12-31 16:46:09'),
(43, 41, 31, 5, 1, 5, NULL, 5, '2025-01-01 17:06:43', NULL, NULL, '2025-01-01 17:06:43'),
(44, 42, 72, 55, 1, 55, NULL, 55, '2025-01-02 11:00:42', NULL, NULL, '2025-01-02 11:00:42'),
(45, 43, 73, 15, 1, 15, NULL, 15, '2025-01-02 11:20:02', NULL, NULL, '2025-01-02 11:20:02'),
(46, 44, 32, 15, 1, 15, NULL, 15, '2025-02-03 17:54:02', NULL, NULL, '2025-02-03 17:54:02'),
(47, 45, 72, 55, 1, 55, NULL, 55, '2025-02-12 17:51:29', NULL, NULL, '2025-02-12 17:51:29'),
(48, 46, 73, 15, 1, 15, NULL, 15, '2025-03-03 12:09:36', NULL, NULL, '2025-03-03 12:09:36'),
(49, 47, 32, 15, 2, 30, NULL, 30, '2025-03-03 16:26:10', NULL, NULL, '2025-03-03 16:26:10'),
(50, 48, 33, 55, 1, 55, NULL, 55, '2025-03-03 16:35:05', NULL, NULL, '2025-03-03 16:35:05'),
(51, 49, 81, 99.5, 1, 99.5, NULL, 99.5, '2025-03-10 10:23:52', NULL, NULL, '2025-03-10 10:23:52'),
(52, 50, 32, 15, 1, 15, NULL, 15, '2025-03-10 15:05:09', NULL, NULL, '2025-03-10 15:05:09'),
(53, 51, 33, 55, 1, 55, NULL, 55, '2025-03-10 15:08:13', NULL, NULL, '2025-03-10 15:08:13'),
(63, 61, 81, 99.5, 1, 99.5, NULL, 99.5, '2025-09-06 17:31:56', NULL, NULL, '2025-09-06 17:31:56'),
(65, 63, 81, 99.5, 1, 99.5, NULL, 99.5, '2025-09-06 17:48:36', NULL, NULL, '2025-09-06 17:48:36'),
(66, 64, 81, 99.5, 2, 199, NULL, 199, '2025-09-06 18:02:07', NULL, NULL, '2025-09-06 18:02:07'),
(67, 65, 22, 268, 1, 268, NULL, 268, '2025-09-06 19:40:30', NULL, NULL, '2025-09-06 19:40:30'),
(69, 67, 32, 15, 1, 15, NULL, 15, '2025-09-16 17:36:54', NULL, NULL, '2025-09-16 17:36:54'),
(70, 68, 23, 228, 1, 228, NULL, 228, '2025-09-23 18:02:50', NULL, NULL, '2025-09-23 18:02:50'),
(80, 74, 41, 88, 1, 88, NULL, 88, '2025-10-02 12:21:51', NULL, NULL, '2025-10-02 12:21:51'),
(82, 76, 83, 299.99, 1, 299.99, NULL, 299.99, '2025-10-04 19:53:00', NULL, NULL, '2025-10-04 19:53:00'),
(83, 77, 23, 228, 1, 228, NULL, 228, '2025-10-04 19:55:08', NULL, NULL, '2025-10-04 19:55:08'),
(86, 79, 81, 99.5, 1, 99.5, NULL, 99.5, '2025-12-22 12:28:05', NULL, NULL, '2025-12-22 12:28:05'),
(87, 79, 31, 5, 2, 10, NULL, 10, '2025-12-22 12:28:05', NULL, NULL, '2025-12-22 12:28:05'),
(88, 80, 85, 343, 1, 343, NULL, 343, '2025-12-22 18:28:37', NULL, NULL, '2025-12-22 18:28:37'),
(89, 80, 41, 88, 2, 176, NULL, 176, '2025-12-22 18:28:37', NULL, NULL, '2025-12-22 18:28:37'),
(90, 81, 53, 228, 1, 228, NULL, 228, '2025-12-23 10:22:58', NULL, NULL, '2025-12-23 10:22:58'),
(91, 81, 39, 100, 2, 200, NULL, 200, '2025-12-23 10:22:58', NULL, NULL, '2025-12-23 10:22:58'),
(92, 81, 16, 228, 1, 228, NULL, 228, '2025-12-23 10:22:58', NULL, NULL, '2025-12-23 10:22:58'),
(93, 82, 41, 88, 2, 176, NULL, 176, '2025-12-31 18:57:47', NULL, NULL, '2025-12-31 18:57:47'),
(94, 83, 42, 65, 2, 130, NULL, 130, '2026-02-11 19:25:17', NULL, NULL, '2026-02-11 19:25:17'),
(95, 84, 4, 350, 1, 350, NULL, 350, '2026-03-15 12:38:17', NULL, NULL, '2026-03-15 12:38:17'),
(96, 85, 87, 89, 4, 356, NULL, 356, '2026-03-15 16:32:00', NULL, NULL, '2026-03-15 16:32:00'),
(98, 87, 85, 343, 1, 343, NULL, 343, '2026-03-16 15:21:06', NULL, NULL, '2026-03-16 15:21:06'),
(99, 88, 85, 343, 1, 343, NULL, 343, '2026-03-18 15:56:32', NULL, NULL, '2026-03-18 15:56:32'),
(100, 89, 87, 89, 2, 178, NULL, 178, '2026-03-18 16:14:39', NULL, NULL, '2026-03-18 16:14:39'),
(101, 90, 73, 15, 5, 75, NULL, 75, '2026-04-04 13:18:00', NULL, NULL, '2026-04-04 13:18:00'),
(102, 91, 4, 350, 1, 350, NULL, 350, '2026-04-04 17:48:27', NULL, NULL, '2026-04-04 17:48:27'),
(105, 94, 4, 350, 2, 700, NULL, 700, '2026-04-05 12:57:02', NULL, NULL, '2026-04-05 12:57:02'),
(106, 95, 2, 450, 1, 450, NULL, 450, '2026-04-05 13:01:04', NULL, NULL, '2026-04-05 13:01:04'),
(107, 96, 85, 343, 5, 1715, NULL, 1715, '2026-04-05 18:22:59', NULL, NULL, '2026-04-05 18:22:59'),
(108, 97, 4, 350, 3, 1050, NULL, 1050, '2026-04-09 15:45:26', NULL, NULL, '2026-04-09 15:45:26'),
(109, 98, 54, 228, 1, 228, NULL, 228, '2026-04-09 15:46:45', NULL, NULL, '2026-04-09 15:46:45'),
(110, 99, 81, 99.5, 1, 99.5, NULL, 99.5, '2026-04-11 09:57:01', NULL, NULL, '2026-04-11 09:57:01'),
(111, 99, 83, 299.99, 1, 299.99, NULL, 299.99, '2026-04-11 09:57:01', NULL, NULL, '2026-04-11 09:57:01'),
(112, 100, 85, 343, 1, 343, NULL, 343, '2026-04-11 12:02:32', NULL, NULL, '2026-04-11 12:02:32'),
(113, 101, 4, 350, 1, 350, NULL, 350, '2026-04-11 12:18:28', NULL, NULL, '2026-04-11 12:18:28'),
(114, 102, 85, 343, 1, 343, NULL, 343, '2026-05-03 16:49:31', NULL, NULL, '2026-05-03 16:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `cc_order_option`
--

CREATE TABLE `cc_order_option` (
  `order_option_id` int UNSIGNED NOT NULL,
  `order_id` int NOT NULL,
  `order_item_id` int NOT NULL,
  `product_id` int NOT NULL,
  `option_id` int NOT NULL,
  `option_value_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_order_option`
--

INSERT INTO `cc_order_option` (`order_option_id`, `order_id`, `order_item_id`, `product_id`, `option_id`, `option_value_id`, `name`, `value`) VALUES
(1, 15, 17, 39, 1, 3, 'size', '15'),
(2, 15, 17, 39, 2, 1, 'color', 'Red'),
(3, 16, 18, 39, 1, 3, 'size', '15'),
(4, 16, 18, 39, 2, 1, 'color', 'Red'),
(5, 17, 19, 39, 1, 4, 'size', '20'),
(6, 17, 19, 39, 2, 1, 'color', 'Red'),
(7, 18, 20, 39, 1, 3, 'size', '15'),
(8, 18, 20, 39, 2, 1, 'color', 'Red'),
(9, 22, 24, 39, 1, 3, 'size', '15'),
(10, 22, 24, 39, 2, 1, 'color', 'Red'),
(11, 24, 26, 39, 1, 3, 'size', '15'),
(14, 28, 30, 31, 8, 11, 'size', '50'),
(15, 28, 30, 31, 9, 13, 'color', 'Red'),
(16, 34, 36, 31, 8, 11, 'size', '50'),
(17, 34, 36, 31, 9, 13, 'color', 'Red'),
(18, 35, 37, 31, 8, 11, 'size', '50'),
(19, 35, 37, 31, 9, 13, 'color', 'Red'),
(20, 38, 40, 31, 8, 11, 'size', '50'),
(21, 38, 40, 31, 9, 14, 'color', 'Black'),
(22, 41, 43, 31, 8, 11, 'size', '50'),
(23, 41, 43, 31, 9, 14, 'color', 'Black'),
(31, 79, 87, 31, 8, 11, 'size', '35'),
(32, 79, 87, 31, 9, 14, 'color', 'Black'),
(34, 91, 102, 4, 8, 18, 'size', '38'),
(35, 94, 105, 4, 8, 17, 'size', '37'),
(36, 95, 106, 2, 8, 11, 'size', '35'),
(37, 97, 108, 4, 8, 11, 'size', '35'),
(38, 101, 113, 4, 8, 18, 'size', '38');

-- --------------------------------------------------------

--
-- Table structure for table `cc_order_status`
--

CREATE TABLE `cc_order_status` (
  `order_status_id` int UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_order_status`
--

INSERT INTO `cc_order_status` (`order_status_id`, `name`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(3, 'Shipped'),
(5, 'Complete'),
(7, 'Canceled'),
(8, 'Denied'),
(9, 'Canceled Reversal'),
(10, 'Failed'),
(11, 'Refunded'),
(12, 'Reversed'),
(13, 'Chargeback'),
(14, 'Expired'),
(15, 'Processed'),
(16, 'Voided');

-- --------------------------------------------------------

--
-- Table structure for table `cc_pages`
--

CREATE TABLE `cc_pages` (
  `page_id` int UNSIGNED NOT NULL,
  `temp` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_des` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_description` mediumtext COLLATE utf8mb4_unicode_ci,
  `f_image` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_type` enum('page','post','video','analyses') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_pages`
--

INSERT INTO `cc_pages` (`page_id`, `temp`, `page_title`, `slug`, `short_des`, `page_description`, `f_image`, `page_type`, `meta_title`, `meta_description`, `meta_keyword`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 'contact.php', 'Contact Us', 'contact-us', 'test', NULL, '', '', NULL, NULL, NULL, 'Active', '2023-05-30 22:31:48', NULL, NULL, '2023-07-22 20:20:13'),
(2, 'default.php', 'About Us', 'about-us', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', NULL, NULL, NULL, 'Active', '2023-05-30 22:31:48', NULL, NULL, '2023-10-02 11:43:04'),
(4, 'default.php', 'Privacy Policy', 'privacy-policy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia, molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum numqu', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', NULL, NULL, NULL, 'Active', '2023-05-30 22:31:48', NULL, NULL, '2023-05-30 22:31:48'),
(5, 'default.php', 'Terms And Conditions', 'terms-and-conditions', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', NULL, NULL, NULL, 'Active', '2023-05-30 22:31:48', NULL, NULL, '2023-05-30 22:31:48'),
(6, 'default.php', 'Returns Policy', 'returns-policy', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', NULL, NULL, NULL, 'Active', '2023-05-30 22:31:48', NULL, NULL, '2023-05-30 22:31:48'),
(7, 'default.php', 'FAQ', 'faq', 'dghdfgh', '<p>srfgyhfhyhfguy</p>', NULL, NULL, NULL, NULL, NULL, 'Active', '2023-06-18 19:43:02', NULL, NULL, '2023-06-18 19:43:02'),
(9, 'default.php', 'New Arrivals', 'new-arrivals', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', '2023-09-24 17:58:57', NULL, NULL, '2023-09-24 17:58:57'),
(10, 'default.php', 'Need help', 'need-help', NULL, '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', NULL, NULL, '', '', '', 'Active', '2023-10-02 12:03:01', NULL, NULL, '2023-12-25 18:30:28'),
(12, 'default.php', 'Blog', 'blog', 'Blog', '<p>Blog<br></p>', NULL, NULL, 'Blog', 'Blog', 'Blog', 'Active', '2024-06-30 20:32:20', NULL, NULL, '2024-06-30 20:32:20'),
(13, 'site_map.php', 'Site Map', 'site-map', NULL, NULL, NULL, NULL, '', '', '', 'Active', '2024-10-26 18:49:20', NULL, NULL, '2024-10-26 18:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `cc_payment_method`
--

CREATE TABLE `cc_payment_method` (
  `payment_method_id` int UNSIGNED NOT NULL,
  `name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_payment_method`
--

INSERT INTO `cc_payment_method` (`payment_method_id`, `name`, `code`, `image`, `status`) VALUES
(1, 'Cash On Delivery', 'cash_on', 'cash_1759055968_1465e094942ee20fb670.png', '0'),
(2, 'Bank Transfer', 'bank_transfer', 'bank_1692269261_e30f1169975c89545ff2.png', '1'),
(3, 'Paypal', 'paypal', 'paypal_1692681576_8816a976c4c15e75aeb4.png', '1'),
(4, 'Western Union', 'western_union', 'western_union_1693227784_6fff290ee998d1951995.png', '1'),
(5, 'MoneyGram', 'moneyGram', 'moneyGram_1693228242_b037b4cb9fcab1d64b21.png', '1'),
(6, 'Bitcoin', 'bitcoin', 'bitcoin_1693229111_ab1db8a222a0b4082eb1.png', '0'),
(7, 'Credit Card / Debit Card', 'credit_card', 'cash_1759055918_f57b29fe04b4f69c505b.png', '1'),
(8, 'eWallet', 'u_wallet', 'cash_1759055992_1743dfad6cce7df3aa71.png', '0'),
(9, 'Stripe', 'stripe', 'stripe_1711190105_76334e85265e1bfe92f5.png', '1'),
(10, 'Ois Bizcraft', 'oisbizcraft', 'oisbizcraft_1733202301_f7de86d0599a71d8ccf9.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cc_payment_settings`
--

CREATE TABLE `cc_payment_settings` (
  `settings_id` int UNSIGNED NOT NULL,
  `payment_method_id` int NOT NULL,
  `label` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_payment_settings`
--

INSERT INTO `cc_payment_settings` (`settings_id`, `payment_method_id`, `label`, `title`, `value`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 2, 'instruction', 'Bank Transfer Instruction', 'A set of payment instructions will be sent to you shortly.\r\nPlease check your spam or junk if you do not see it in your inbox.\r\nIf no instruction is receive within 24 hours, please email us at\r\namazingadgets@gmail.com', '2023-08-17 11:01:47', NULL, NULL, '2023-08-17 11:33:17'),
(4, 4, 'instruction', 'Western Union Instruction', 'A set of payment instructions will be sent to you shortly.\r\nPlease check your spam or junk if you do not see it in your inbox.\r\nIf no instruction is receive within 24 hours, please email us at\r\namazinggadgets@gmail.com', '2023-08-28 18:30:55', NULL, NULL, '2023-08-28 19:00:39'),
(5, 5, 'instruction', 'MoneyGram Instruction', 'A set of payment instructions will be sent to you shortly.\r\nPlease check your spam or junk if you do not see it in your inbox.\r\nIf no instruction is receive within 24 hours, please email us at\r\namazinggadgets@gmail.com', '2023-08-28 18:30:55', NULL, NULL, '2023-08-28 19:05:52'),
(6, 6, 'instruction', 'Bitcoin Instruction', 'A set of payment instructions will be sent to you shortly.\r\nPlease check your spam or junk if you do not see it in your inbox.\r\nIf no instruction is receive within 24 hours, please email us at\r\namazinggadgets@gmail.com', '2023-08-28 18:30:55', NULL, NULL, '2023-08-28 19:05:52'),
(7, 3, 'api_url', 'API URL', 'sandbox', '2023-08-29 20:15:37', NULL, NULL, '2023-09-03 18:11:19'),
(10, 3, 'api_username', 'Api Username', 'sb-u1koz27136347_api1.business.example.com', '2023-09-03 17:28:22', NULL, NULL, '2023-09-03 17:32:04'),
(11, 3, 'api_password', 'Api Password', 'Q6GHERFNRMSURNYD', '2023-09-03 17:29:27', NULL, NULL, '2023-09-03 17:32:04'),
(12, 3, 'api_signature', 'Api Signature', 'AwIggmgx-fAD0IWRrXWdFxsw.d--AlUB67UCRrfEheVSFrGOH9DRld-V', '2023-09-03 17:30:00', NULL, NULL, '2023-09-03 17:32:04'),
(13, 9, 'key', 'Key', 'pk_test_51HiuQiDVsvPo6h6ZrkChvkyVywgbs83tPg809JsvQLqyJ3JAlXbXhTOlwZEmlzXud1paIE87z7o5erGMEUbDrevD00jOYwmg2Y', '2024-05-09 10:45:48', NULL, NULL, '2024-05-09 10:45:48'),
(14, 9, 'secret_key', 'Secret Key', 'sk_test_51HiuQiDVsvPo6h6ZmBoulU8B7qWOCl6qYC3feinEzPuj0lLICpwhE2vEHncoIA6fZaKSjXMDn09L8ueDBMzt3I6Z00SA7fC6xY', '2024-05-09 10:46:21', NULL, NULL, '2024-05-09 10:46:21'),
(15, 10, 'api_key', 'Api Key', 'DNNDT2QAB583ZP188BHNFMCXRB4G7SJ3', '2024-12-17 11:56:10', NULL, NULL, '2024-12-17 11:56:10'),
(16, 10, 'ois_bizcraft_api_url', 'OIS Bizcraft Api Url', 'https://devapiportal.oisbizcraft.com/api/payments', '2024-12-17 11:56:39', NULL, NULL, '2024-12-19 13:05:53'),
(17, 10, 'merchant_outlet_id', 'Merchant Outlet Id', '13', '2024-12-30 17:22:30', NULL, NULL, '2024-12-30 17:22:30'),
(18, 10, 'terminal_id', 'Terminal Id', '001', '2024-12-30 17:22:53', NULL, NULL, '2024-12-30 17:22:53'),
(19, 10, 'cust_code', 'Cust Code', '001095', '2024-12-30 17:23:17', NULL, NULL, '2024-12-30 17:23:17'),
(20, 10, 'exchange_rates_api', 'Exchange Rates Api', '51f16f3fee1c4eec91235cbd887a5259', '2024-12-30 17:23:56', NULL, NULL, '2024-12-30 17:23:56');

-- --------------------------------------------------------

--
-- Table structure for table `cc_products`
--

CREATE TABLE `cc_products` (
  `product_id` int UNSIGNED NOT NULL,
  `store_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` int DEFAULT NULL,
  `main_image` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `alt_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `product_category_id` int DEFAULT NULL,
  `featured` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `average_feedback` int DEFAULT NULL,
  `date_available` date DEFAULT NULL,
  `weight` decimal(10,4) NOT NULL,
  `length` decimal(10,4) NOT NULL,
  `width` decimal(10,4) NOT NULL,
  `height` decimal(10,4) NOT NULL,
  `sort_order` int NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_products`
--

INSERT INTO `cc_products` (`product_id`, `store_id`, `name`, `model`, `product_code`, `main_image`, `image`, `alt_name`, `brand_id`, `price`, `quantity`, `product_category_id`, `featured`, `average_feedback`, `date_available`, `weight`, `length`, `width`, `height`, `sort_order`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 1, 'Fendi Shoes A005', 'Fendi-004', NULL, NULL, 'pro_1696164202_cf190a454852091e77df.jpg', NULL, 2, 488.00, 15, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-09-05 11:57:44', 1, NULL, '2025-10-02 12:22:20'),
(2, 1, 'Fendi Shoes A005', 'Fendi-003', NULL, NULL, 'pro_1696161104_6b8d29e6452348aa0c7d.jpg', NULL, 2, 488.00, 9, NULL, '1', NULL, NULL, 9.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-09-05 12:02:56', 1, NULL, '2026-04-05 13:01:04'),
(3, 1, 'Fendi Shoes A002', 'Fendi-002', NULL, NULL, 'pro_1696160994_f701494e6ef39dd07100.jpg', NULL, 2, 208.00, 18, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-09-05 12:06:29', 1, NULL, '2024-02-19 19:28:23'),
(4, 1, 'Fendi Shoes A001', 'Fendi-001', NULL, 'uploads/manager/1773555924_336d163f5e9a3eb7cf64.jpg', 'uploads/products/4/wm_600_pro_1464420100.jpg', 'Fendi Shoes A001', 2, 368.00, 7, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-09-05 12:11:55', 1, NULL, '2026-04-11 12:18:28'),
(5, 1, 'LV Jewelries 010', 'LV-010', NULL, NULL, 'pro_1696160004_bdb78f45d1716eca85e1.jpg', NULL, 2, 88.00, 17, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-09-05 12:16:16', 1, NULL, '2024-06-30 20:33:02'),
(6, 1, 'LV Jewelries 009', 'LV-009', NULL, NULL, 'pro_1696159825_0146497603e8f4762622.jpg', NULL, 2, 88.00, 18, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-09-05 12:18:38', 1, NULL, '2023-10-01 17:30:25'),
(7, 1, 'LV Jewelries 008', 'LV-008', NULL, NULL, 'pro_1696159637_c3db346c928e4a0772b6.jpg', NULL, 2, 78.00, 17, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-09-05 12:27:30', 1, NULL, '2024-08-10 10:42:56'),
(8, 1, 'LV Jewelries 001', 'lv-001', NULL, NULL, 'pro_1696142862_f3f1e6a1edf79529f06c.jpg', NULL, NULL, 98.00, 18, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 12:47:42', 1, NULL, '2023-10-01 12:47:42'),
(9, 1, 'LV Jewelries 002', 'lv-002', NULL, NULL, 'pro_1696143178_f11bfb79c62daaa26ca7.jpg', NULL, NULL, 98.00, 18, NULL, '0', 5, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 12:52:58', 1, NULL, '2025-12-31 19:29:45'),
(10, 1, 'LV Jewelries 003', 'lv-003', NULL, NULL, 'pro_1696143320_989963aa313fffdd753b.jpg', NULL, NULL, 98.00, 18, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 12:55:20', 1, NULL, '2023-10-01 12:55:21'),
(11, 1, 'GUCCI BRACELETS A001', ' A001', NULL, NULL, 'pro_1696159929_aad5544bac1df32a35c8.jpg', NULL, NULL, 78.00, 17, NULL, '0', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 17:32:09', 1, NULL, '2025-10-02 12:20:29'),
(12, 1, 'GUCCI BRACELETS A002', ' A002', NULL, NULL, 'pro_1696160189_30e201c36461d1d868f1.jpg', NULL, NULL, 98.00, 17, NULL, '0', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 17:36:29', 1, NULL, '2025-10-02 12:20:29'),
(13, 1, 'GUCCI BRACELETS A004', ' A004', NULL, NULL, 'pro_1696160559_c322117ac736954cda4b.jpg', NULL, NULL, 55.00, 17, NULL, '0', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 17:42:39', 1, NULL, '2025-10-02 12:20:29'),
(14, 1, 'GUCCI BRACELETS A005', ' A005', NULL, NULL, 'pro_1696160716_338db8e66ff102691420.jpg', NULL, NULL, 485.00, 17, NULL, '0', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 17:45:16', 1, NULL, '2025-10-02 12:20:29'),
(15, 1, 'Fendi Shoes A005', 'Fendi-005', NULL, 'uploads/manager/1775304370_b74819183564a7170a2a.jpg', 'uploads/products/15/wm_600_pro_1087040899.jpg', 'Fendi Shoes A005', NULL, 228.00, 18, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 18:45:15', 1, NULL, '2026-04-04 18:10:13'),
(16, 1, 'Fendi Shoes A006', 'Fendi-006', NULL, NULL, 'pro_1696165172_e079f896b8a9814cd7ba.jpg', NULL, 7, 228.00, 17, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 18:59:32', 1, NULL, '2025-12-23 10:22:58'),
(17, 1, 'Fendi Shoes A007', 'Fendi-007', NULL, NULL, 'pro_1696165334_a74470c53d931b71bd83.jpg', NULL, 7, 268.00, 18, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:02:14', 1, NULL, '2025-09-18 11:49:42'),
(18, 1, 'Fendi Shoes A008', 'Fendi-008', NULL, NULL, 'pro_1696165453_19ed6901e12b867fe665.jpg', NULL, 7, 248.00, 18, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:04:13', 1, NULL, '2025-09-18 11:49:43'),
(19, 1, 'Fendi Shoes A009', 'Fendi-009', NULL, NULL, 'pro_1696165548_bfcc7cd642500a82f8f6.jpg', NULL, 7, 228.00, 18, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:05:48', 1, NULL, '2025-09-18 11:49:45'),
(20, 1, 'Fendi Shoes A010', 'Fendi-010', NULL, NULL, 'pro_1696165643_48962c4463f37a486573.jpg', NULL, NULL, 268.00, 18, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:07:23', 1, NULL, '2025-09-18 11:49:46'),
(21, 1, 'LV MEN BAGS A001', 'LB-001', NULL, NULL, 'pro_1696166671_84b5f40f22e50088f0c3.jpg', NULL, NULL, 228.00, 15, NULL, '0', NULL, NULL, 5.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:24:31', 1, NULL, '2023-12-21 11:00:58'),
(22, 1, 'LV MEN BAGS A002', 'LB-002', NULL, NULL, 'pro_1696167111_c4fc580993edeb12b7c9.jpg', NULL, 13, 268.00, 13, NULL, '0', NULL, NULL, 4.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:31:51', 1, NULL, '2025-10-14 20:33:36'),
(23, 1, 'LV MEN BAGS A003', 'LB-003', NULL, NULL, 'pro_1696167211_e2e1dcbc057a56d32ed2.jpg', NULL, 13, 228.00, 13, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:33:31', 1, NULL, '2025-10-14 20:33:36'),
(24, 1, 'LV MEN BAGS A004', 'LB-004', NULL, NULL, 'pro_1696167286_efaf3c9d38393b21054c.jpg', NULL, 13, 248.00, 17, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:34:46', 1, NULL, '2025-10-02 12:21:21'),
(25, 1, 'sunglasses A001', 'A001', NULL, 'uploads/manager/02/1775886531_461d1580605a7b2f41e4.jpg', 'uploads/products/25/wm_600_pro_1112905921.jpg', 'sunglasses A001', NULL, 845.00, 18, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:54:32', 1, NULL, '2026-04-11 11:49:10'),
(26, 1, 'sunglasses A002', ' A002', NULL, NULL, 'pro_1696168709_40129cbbcf6656f65b58.jpg', NULL, NULL, 125.00, 1, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 19:58:29', 1, NULL, '2023-10-01 19:58:30'),
(27, 1, 'sunglasses A003', ' A007', NULL, NULL, 'pro_1696168818_35e276374b7290d93ed5.jpg', NULL, NULL, 25.00, 418, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 20:00:18', 1, NULL, '2023-10-01 20:00:18'),
(28, 1, 'sunglasses A003', ' A007', NULL, NULL, 'pro_1696168820_164b4ed81bd2487498f8.jpg', NULL, NULL, 25.00, 417, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 20:00:20', 1, NULL, '2024-06-30 20:33:34'),
(29, 1, 'sunglasses A006', ' A007', NULL, NULL, 'pro_1696169018_a3809991cf480c9c99fc.jpg', NULL, NULL, 55.00, 1, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 20:03:38', 1, NULL, '2023-10-01 20:03:38'),
(30, 1, 'sunglasses A008', ' A008', NULL, 'uploads/manager/1775884503_5389f312737a83297fa3.jpg', 'uploads/products/30/wm_600_pro_1988602632.jpg', 'sunglasses A008', NULL, 58.00, 8, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-01 20:29:36', 1, NULL, '2026-04-11 11:15:37'),
(31, 1, 'T-shart  A01', '  A01', NULL, NULL, 'pro_1696245796_17eda446e0183d9118bb.jpg', '', 2, 5.00, 7, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-02 17:23:16', 1, NULL, '2025-12-22 12:28:05'),
(32, 1, 'T-shart  A02', ' A002', NULL, NULL, 'pro_1696245994_3ca48f17339f48d638bc.jpg', NULL, 2, 15.00, 77, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-02 17:26:34', 1, NULL, '2025-09-16 17:36:54'),
(33, 1, 'T-shart A03', ' A003', NULL, NULL, 'pro_1696246174_36c422d7f766ec9b0546.jpg', NULL, 2, 55.00, 5, NULL, '0', NULL, NULL, 4.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-10-02 17:29:34', 1, NULL, '2025-09-13 19:50:34'),
(37, 1, 'Test 2', '161123', NULL, NULL, 'pro_1701688967_0899e4ad62dce4ecce93.jpg', NULL, 10, 8.00, 8, NULL, '0', NULL, NULL, 8.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-12-04 17:22:47', 1, NULL, '2023-12-04 17:22:47'),
(39, 1, 'tretertertret', 'ertre', NULL, NULL, 'pro_1703506332_5c2090d03f0d716957c2.jpg', NULL, 10, 100.00, 5, NULL, '1', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2023-12-25 18:12:12', 1, NULL, '2025-12-23 10:22:58'),
(40, 1, 'Chanel Preppy Coco Small Bowling Bag', '181123', NULL, 'uploads/manager/01/1777811293_0a1d9d19a2acfa7bca4e.jpg', 'uploads/products/40/wm_600_pro_581725784.jpg', 'Chanel Preppy Coco Small Bowling Bag', NULL, 65.00, 18, NULL, '0', NULL, NULL, 8.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-01-10 16:51:12', 1, NULL, '2026-05-03 18:28:52'),
(41, 1, 'Chanel Small Shopping Bag', '201123', NULL, 'uploads/manager/01/1777811149_f33a36a47d294a083e70.jpg', 'uploads/products/41/wm_600_pro_1718625576.jpg', 'Chanel Small Shopping Bag', 10, 88.00, 83, NULL, '1', NULL, NULL, 8.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-01-23 17:42:32', 1, NULL, '2026-05-04 16:22:32'),
(42, 1, 'CHANEL 181123-113 Xcm', '201123', NULL, 'uploads/manager/02/1777810626_ea3ebc3be7c30093c5fc.jpg', 'uploads/products/42/wm_600_pro_477433361.jpg', 'CHANEL 181123-113 Xcm', 1, 65.00, 84, NULL, '0', NULL, NULL, 30.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-01-23 17:46:14', 1, NULL, '2026-05-03 18:19:08'),
(50, 1, 'Fendi Shoes A009', 'Fendi-009', NULL, NULL, NULL, NULL, 7, 228.00, 20, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-01 11:24:47', 1, NULL, '2024-10-21 12:53:07'),
(51, 1, 'Fendi Shoes A008', 'Fendi-008', NULL, NULL, NULL, NULL, 7, 248.00, 18, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-01 11:24:47', 1, NULL, '2024-06-02 18:22:05'),
(53, 1, 'Fendi Shoes A006', 'Fendi-006', NULL, 'uploads/manager/1775725599_37b47b9cf4da5cd74352.jpg', 'uploads/products/53/wm_600_pro_70459949.jpg', 'Fendi Shoes A006', 7, 228.00, 17, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-01 11:24:47', 1, NULL, '2026-04-09 15:07:27'),
(54, 1, 'Fendi Shoes A005', 'Fendi-005', NULL, 'uploads/manager/1775303960_05ff31aa0a2990f2246e.jpg', 'uploads/products/54/wm_600_pro_900159086.jpg', 'Fendi Shoes A005', NULL, 228.00, 15, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-01 11:24:47', 1, NULL, '2026-04-09 15:46:45'),
(55, 1, 'GUCCI BRACELETS A005', ' A005', NULL, NULL, NULL, NULL, NULL, 485.00, 18, NULL, '0', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-01 11:24:47', 1, NULL, '2025-02-03 18:44:43'),
(56, 1, 'Hermes Jypsiere Mini Brown', ' A004', NULL, 'uploads/manager/02/1777810117_fc217eff0e2e5f39851a.jpg', 'uploads/products/56/wm_600_pro_1407502999.jpg', 'Hermes Jypsiere Mini Brown', 20, 55.00, 18, NULL, '1', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-01 11:24:47', 1, NULL, '2026-05-04 16:45:54'),
(57, 1, 'Hermes Jypsiere Mini White', ' A002', NULL, 'uploads/manager/02/1777809912_c9fdc004fc3a366d02e4.jpg', 'uploads/products/57/wm_600_pro_839229262.jpg', 'GUCCI BRACELETS A002', NULL, 98.00, 18, NULL, '0', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-01 11:24:47', 1, NULL, '2026-05-03 18:07:20'),
(58, 1, 'Gucci GG Supreme canvas pouch in black and gray', ' A001', NULL, 'uploads/manager/02/1777809212_091bb0d0c3151a322aaf.jpg', 'uploads/products/58/wm_600_pro_1485675516.jpg', 'Gucci GG Supreme canvas pouch in black and gray', NULL, 78.00, 18, NULL, '0', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-01 11:24:47', 1, NULL, '2026-05-03 18:00:45'),
(70, 1, 'Hermès Kelly 18 belt', ' A004', NULL, 'uploads/manager/1777808993_5b0d6964beca4b4f7318.jpg', 'uploads/products/70/wm_600_pro_1939843418.jpg', 'GUCCI BRACELETS A004', NULL, 55.00, 22, NULL, '0', NULL, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-06-29 10:47:48', 1, NULL, '2026-05-03 17:51:46'),
(72, 1, 'Copy of T-shart  A03', ' A003', NULL, NULL, 'pro_1732108062_e40fcf312ca17a52619f.jpg', NULL, 2, 55.00, 4, NULL, '0', NULL, NULL, 4.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2024-11-20 19:06:14', 1, NULL, '2025-09-23 19:43:01'),
(81, 1, 'Test', '161123', NULL, 'uploads/manager/01/1773899329_2c15dd2886943aa366e9.jpg', 'uploads/products/81/wm_600_pro_1243176483.jpg', 'Test', 13, 99.50, 9, NULL, '0', 5, NULL, 1.5000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2025-02-03 18:38:48', 1, NULL, '2026-04-11 09:57:01'),
(84, 1, 'new products', 'new products', NULL, NULL, 'pro_1753879560_a0b95c9deb9dd32c562b.jpg', NULL, 7, 111.00, 22, NULL, '0', NULL, NULL, 5.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2025-07-13 19:37:20', 1, NULL, '2025-07-30 18:46:00'),
(85, 1, 'New watermark test', 'New watermark test', NULL, 'uploads/manager/1773310476_dd8b9304cbb6f5074b33.jpg', 'uploads/products/85/wm_600_pro_1910884256.jpg', 'New watermark test', 1, 343.00, 199, NULL, '0', NULL, NULL, 3.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2025-07-30 18:46:09', 1, NULL, '2026-05-03 16:49:31'),
(86, 1, 'Lv Bag', '#43535d', NULL, 'uploads/manager/1773483247_bde84d3dea7c396e6c59.jpg', 'uploads/products/86/wm_600_pro_505574283.jpg', 'Lv Bag', 13, 100.00, 100, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2025-09-16 17:54:49', 1, NULL, '2026-03-14 16:36:35'),
(87, 1, 'Cartier Necklace', 'Cartier Necklace', NULL, 'uploads/manager/1773310485_1c83f5b10c9bddab7990.jpg', 'uploads/products/87/wm_600_pro_2081255866.jpg', 'Cartier Necklace', 5, 89.00, 993, NULL, '0', NULL, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0, 'Active', '2025-09-17 19:34:09', 1, NULL, '2026-04-09 15:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_attribute`
--

CREATE TABLE `cc_product_attribute` (
  `attribute_id` int UNSIGNED NOT NULL,
  `attribute_group_id` int NOT NULL,
  `product_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` mediumtext COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_attribute`
--

INSERT INTO `cc_product_attribute` (`attribute_id`, `attribute_group_id`, `product_id`, `name`, `details`, `sort_order`) VALUES
(9, 1, 39, 'trete', 'etret', 0),
(10, 2, 39, 'ertert', '', 0),
(30, 1, 1, 'somon', '', 0),
(31, 2, 1, 'ewe', '', 0),
(32, 1, 2, 'somon', '', 0),
(33, 2, 2, 'ewe', '', 0),
(34, 1, 21, 'somon', '', 0),
(35, 2, 21, 'DDR-4', '', 0),
(36, 1, 22, 'somon', '', 0),
(37, 2, 22, 'DDR-4', '', 0),
(65, 1, 31, 'Gold', '', 0),
(66, 2, 31, '2GB', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_attribute_group`
--

CREATE TABLE `cc_product_attribute_group` (
  `attribute_group_id` int UNSIGNED NOT NULL,
  `name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_attribute_group`
--

INSERT INTO `cc_product_attribute_group` (`attribute_group_id`, `name`, `sort_order`) VALUES
(1, 'new', 0),
(2, 'test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_bought_together`
--

CREATE TABLE `cc_product_bought_together` (
  `bought_together_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `related_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_bought_together`
--

INSERT INTO `cc_product_bought_together` (`bought_together_id`, `product_id`, `related_id`) VALUES
(7, 39, 2),
(8, 39, 16),
(59, 87, 12),
(60, 87, 13),
(61, 87, 14),
(69, 70, 2),
(70, 70, 3),
(71, 70, 15),
(74, 57, 6),
(75, 57, 7);

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_category`
--

CREATE TABLE `cc_product_category` (
  `prod_cat_id` int UNSIGNED NOT NULL,
  `parent_id` int DEFAULT NULL,
  `category_name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_id` int DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_menu` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `side_menu` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_category`
--

INSERT INTO `cc_product_category` (`prod_cat_id`, `parent_id`, `category_name`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `icon_id`, `image`, `alt_name`, `header_menu`, `side_menu`, `sort_order`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, NULL, 'Women ', '', '', '', '', 13, NULL, NULL, '0', '1', 1, '1', '2023-09-04 18:13:48', 1, 1, '2025-09-23 19:33:28'),
(2, 1, 'Bags ', '', '', '', '', 14, 'category_1696138314_359a3f697852c1d725ef.jpg', '', '0', '0', 5, '1', '2023-09-04 18:17:57', 1, 1, '2026-04-05 20:51:29'),
(3, 2, 'Backpacks ', NULL, NULL, NULL, NULL, 8, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:09:32', 1, NULL, '2023-09-04 19:09:32'),
(4, 2, 'Crossbodys', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:31:00', 1, NULL, '2023-09-04 19:31:00'),
(5, 2, 'Top Handles ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:31:14', 1, NULL, '2023-09-04 19:31:14'),
(6, 2, 'Totes ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 15, '1', '2023-09-04 19:31:29', 1, NULL, '2023-09-06 11:21:14'),
(7, 2, 'Bums & Pouches ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:31:44', 1, NULL, '2023-09-04 19:31:44'),
(8, 2, 'Clutches ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:31:55', 1, NULL, '2023-09-04 19:31:55'),
(9, 2, 'Travels', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:32:03', 1, NULL, '2023-09-04 19:32:03'),
(10, 2, 'Purses & Holders', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:32:12', 1, NULL, '2023-09-04 19:32:12'),
(11, 1, 'Jewelry', '', '', '', '', 21, 'category_1696138395_9b13d7e2e67c84a1b83e.jpg', NULL, '0', '1', 6, '1', '2023-09-04 19:32:50', 1, 1, '2025-08-02 11:05:31'),
(12, 11, 'Bangles & Bracelets ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:32:59', 1, NULL, '2023-09-04 19:32:59'),
(13, 11, 'Chest Pins ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:33:07', 1, NULL, '2023-09-04 19:33:07'),
(14, 11, 'Earrings ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:33:15', 1, NULL, '2023-09-04 19:33:15'),
(15, 11, 'Necklaces & Chokers ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:33:22', 1, NULL, '2023-09-04 19:33:22'),
(16, 11, 'Rings ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 19:33:30', 1, NULL, '2023-09-04 19:33:30'),
(24, NULL, 'Men', '', '', '', '', 9, NULL, NULL, '0', '1', 2, '1', '2023-09-04 19:42:26', 1, 1, '2025-09-23 19:33:13'),
(25, 24, 'Bags ', '', NULL, NULL, NULL, NULL, 'category_1696132561_b51b6e2c923f2711f408.jpg', NULL, '0', '0', 0, '1', '2023-09-04 19:44:10', 1, 1, '2023-10-01 09:56:01'),
(26, 25, 'Backpacks ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-04 20:06:02', 1, NULL, '2023-09-04 20:06:02'),
(27, 25, 'Business', NULL, '', '', '', NULL, NULL, NULL, '0', '0', 1, '1', '2023-09-04 20:06:16', 1, 1, '2024-01-25 20:34:58'),
(28, 25, 'Crossbodys', NULL, '', '', '', NULL, NULL, NULL, '0', '0', 3, '1', '2023-09-04 20:06:34', 1, 1, '2024-01-25 20:35:47'),
(29, 25, 'Messengers', NULL, '', '', '', NULL, NULL, NULL, '0', '0', 4, '1', '2023-09-04 20:07:08', 1, 1, '2024-01-25 20:36:10'),
(30, 25, 'Bums & Pouches ', NULL, '', '', '', NULL, NULL, NULL, '0', '0', 2, '1', '2023-09-04 20:07:20', 1, 1, '2024-01-25 20:34:37'),
(31, 25, 'Travels ', NULL, '', '', '', NULL, NULL, NULL, '0', '0', 5, '1', '2023-09-04 20:07:32', 1, 1, '2024-01-25 20:36:43'),
(32, 25, 'Wallets & Holders', NULL, '', '', '', NULL, NULL, NULL, '0', '0', 6, '1', '2023-09-04 20:07:45', 1, 1, '2024-01-25 20:36:56'),
(33, 24, 'Jewelry', '', NULL, NULL, NULL, 1, NULL, NULL, '0', '0', 0, '1', '2023-09-04 20:08:46', 1, 1, '2023-09-05 09:53:34'),
(34, 33, 'Bangles & bracelets ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 09:53:06', 1, NULL, '2023-09-05 09:53:06'),
(35, 33, 'Necklaces ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 09:55:30', 1, NULL, '2023-09-05 09:55:30'),
(36, 33, 'Rings ', '', NULL, NULL, NULL, 10, NULL, NULL, '0', '0', 0, '1', '2023-09-05 09:55:43', 1, 1, '2023-09-30 18:26:34'),
(37, 24, 'Shoes', '', '', '', '', 17, 'category_1696138374_e258c51a36f521423d45.jpg', NULL, '0', '1', 8, '1', '2023-09-05 09:59:16', 1, 1, '2023-10-01 11:32:54'),
(38, 37, 'Business', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 09:59:41', 1, NULL, '2023-09-05 09:59:41'),
(39, 37, 'Casual', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 09:59:51', 1, NULL, '2023-09-05 09:59:51'),
(40, 37, 'Sports', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:00:03', 1, NULL, '2023-09-05 10:00:03'),
(41, 37, 'Sandals ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:00:14', 1, NULL, '2023-09-05 10:00:14'),
(42, 37, 'Flats', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:00:28', 1, NULL, '2023-09-05 10:00:28'),
(43, 37, 'Seasonal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:00:38', 1, NULL, '2023-09-05 10:00:38'),
(44, NULL, 'Ready to wear', '', '', '', '', 12, NULL, NULL, '0', '1', 3, '1', '2023-09-05 10:03:12', 1, 1, '2023-09-30 18:23:30'),
(45, 44, 'Tees', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:03:35', 1, NULL, '2023-09-05 10:03:35'),
(46, 44, 'Bottoms', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:03:48', 1, NULL, '2023-09-05 10:03:48'),
(47, 44, 'Scarves', '', '', '', '', 16, 'category_1696138351_fd0e6908f22927585367.jpg', NULL, '0', '1', 9, '1', '2023-09-05 10:03:58', 1, 1, '2025-07-26 20:21:49'),
(48, 44, 'Sweaters', '', '', '', '', 19, 'category_1696138337_f8e1e9cdc3659085c9b9.jpg', NULL, '0', '0', 10, '1', '2023-09-05 10:04:10', 1, 1, '2023-10-01 11:32:17'),
(49, 44, 'Jackets & Coats', '', NULL, NULL, NULL, 11, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:04:20', 1, 1, '2023-09-30 17:53:08'),
(50, NULL, 'Treasures', '', '', '', '', 18, NULL, NULL, '0', '1', 4, '1', '2023-09-05 10:04:51', 1, 1, '2023-09-30 18:22:25'),
(51, 50, 'Boxes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:05:23', 1, NULL, '2023-09-05 10:05:23'),
(52, 50, 'Pillows', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:05:36', 1, NULL, '2023-09-05 10:05:36'),
(53, 50, 'Blankets', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:05:49', 1, NULL, '2023-09-05 10:05:49'),
(54, 50, 'Key Chains', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:06:11', 1, NULL, '2023-09-05 10:06:11'),
(55, 50, 'Sun Glasses', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:07:37', 1, NULL, '2023-09-05 10:07:37'),
(56, 50, 'Seasonals', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2023-09-05 10:08:02', 1, NULL, '2023-09-06 11:47:25'),
(57, 24, 'Belts', '', NULL, NULL, NULL, 15, 'category_1696138413_a21a6d31adaf2441f90a.jpg', NULL, '0', '0', 0, '1', '2023-09-25 11:05:52', 1, 1, '2023-10-01 11:33:33'),
(58, NULL, 'New Arrivals', NULL, '', '', '', 5, NULL, NULL, '1', '0', 0, '1', '2023-09-28 12:04:00', 1, 1, '2023-09-28 12:06:08'),
(60, NULL, 'Bags', '', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 0, '1', '2025-07-26 20:08:11', 1, 1, '2025-08-05 10:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_category_popular`
--

CREATE TABLE `cc_product_category_popular` (
  `prod_cat_popular_id` int UNSIGNED NOT NULL,
  `prod_cat_id` int NOT NULL,
  `popular` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_category_popular`
--

INSERT INTO `cc_product_category_popular` (`prod_cat_popular_id`, `prod_cat_id`, `popular`, `sort_order`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(6, 2, '1', 0, '1', '2023-09-05 12:20:45', NULL, NULL, '2023-09-05 12:20:45'),
(10, 48, '1', 0, '1', '2023-09-05 12:22:57', NULL, NULL, '2023-09-05 12:22:57'),
(11, 47, '1', 0, '1', '2023-09-05 12:23:19', NULL, NULL, '2023-09-05 12:23:19'),
(14, 37, '1', 0, '1', '2023-09-25 10:58:37', NULL, NULL, '2023-09-25 10:58:37'),
(15, 11, '1', 0, '1', '2023-09-25 10:59:03', NULL, NULL, '2023-09-25 10:59:03'),
(16, 57, '1', 0, '1', '2023-09-25 11:06:00', NULL, NULL, '2023-09-25 11:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_category_shop_by`
--

CREATE TABLE `cc_product_category_shop_by` (
  `prod_cat_shop_by_id` int UNSIGNED NOT NULL,
  `prod_cat_id` int NOT NULL,
  `shop_by` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_category_shop_by`
--

INSERT INTO `cc_product_category_shop_by` (`prod_cat_shop_by_id`, `prod_cat_id`, `shop_by`, `sort_order`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 36, '1', 0, '1', '2024-06-27 11:14:40', NULL, NULL, '2024-06-27 11:14:40'),
(2, 37, '1', 0, '1', '2024-06-27 11:14:45', NULL, NULL, '2024-06-27 11:14:45'),
(3, 33, '1', 0, '1', '2024-06-27 11:14:48', NULL, NULL, '2024-06-27 11:14:48'),
(4, 1, '1', 0, '1', '2024-06-27 11:15:03', NULL, NULL, '2024-06-27 11:15:03'),
(5, 2, '1', 0, '1', '2024-06-27 11:15:16', NULL, NULL, '2024-06-27 11:15:16'),
(6, 11, '1', 0, '1', '2024-06-27 11:15:34', NULL, NULL, '2024-06-27 11:15:34'),
(7, 44, '1', 0, '1', '2024-06-27 11:16:07', NULL, NULL, '2024-06-27 11:16:07'),
(8, 47, '1', 0, '1', '2024-06-27 11:16:12', NULL, NULL, '2024-06-27 11:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_description`
--

CREATE TABLE `cc_product_description` (
  `product_desc_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `tag` mediumtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_image` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documentation_pdf` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `safety_pdf` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions_pdf` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_description`
--

INSERT INTO `cc_product_description` (`product_desc_id`, `product_id`, `description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`, `description_image`, `documentation_pdf`, `safety_pdf`, `instructions_pdf`, `video`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 1, '<p>Fendi Shoes A004<br></p>', 'Fendi Shoes A004', 'Fendi Shoes A004', 'Fendi Shoes A004', 'Fendi Shoes A004', NULL, NULL, NULL, NULL, NULL, '2023-09-05 11:57:45', 1, NULL, '2023-10-01 18:43:25'),
(2, 2, '<p>Fendi Shoes A003<br></p>', 'Fendi Shoes A003', 'Fendi Shoes A003', 'Fendi Shoes A003', 'Fendi Shoes A003', NULL, NULL, NULL, NULL, NULL, '2023-09-05 12:02:57', 1, NULL, '2023-10-01 17:51:46'),
(3, 3, '<p>Fendi Shoes A002<br></p>', 'Fendi Shoes A002', 'Fendi Shoes A002', 'Fendi Shoes A002', 'Fendi Shoes A002', NULL, NULL, NULL, NULL, NULL, '2023-09-05 12:06:30', 1, NULL, '2023-10-01 17:49:59'),
(4, 4, '<p>Fendi Shoes A001<br></p>', 'Fendi Shoes A001', 'Fendi Shoes A001', 'Fendi Shoes A001', 'Fendi Shoes A001', NULL, NULL, NULL, NULL, NULL, '2023-09-05 12:11:56', 1, NULL, '2023-10-01 17:44:32'),
(5, 5, '<p>LV Jewelries 010<br></p>', 'LV Jewelries 010', 'LV Jewelries 010', 'LV Jewelries 010', 'LV Jewelries 010', NULL, NULL, NULL, NULL, NULL, '2023-09-05 12:16:17', 1, NULL, '2023-10-01 17:33:27'),
(6, 6, '<p>LV Jewelries 009<br></p>', 'LV Jewelries 009', 'LV Jewelries 009', 'LV Jewelries 009', 'LV Jewelries 009', NULL, NULL, NULL, NULL, NULL, '2023-09-05 12:18:39', 1, NULL, '2023-10-01 17:30:28'),
(7, 7, '<p>LV Jewelries 008<br></p>', 'LV Jewelries 008', 'LV Jewelries 008', 'LV Jewelries 008', 'LV Jewelries 008', NULL, NULL, NULL, NULL, NULL, '2023-09-05 12:27:31', 1, NULL, '2023-10-01 17:27:23'),
(8, 8, NULL, 'LV Jewelries 001', 'LV Jewelries 001', 'LV Jewelries 001', 'LV Jewelries 001', NULL, NULL, NULL, NULL, NULL, '2023-10-01 12:47:45', 1, NULL, '2023-10-01 12:47:45'),
(9, 9, '<p>LV Jewelries 002<br></p>', 'LV Jewelries 002', 'LV Jewelries 002', 'LV Jewelries 002', 'LV Jewelries 002', NULL, NULL, NULL, NULL, NULL, '2023-10-01 12:53:01', 1, NULL, '2023-10-01 12:53:01'),
(10, 10, NULL, 'LV Jewelries 003', 'LV Jewelries 003', 'LV Jewelries 003', 'LV Jewelries 003', NULL, NULL, NULL, NULL, NULL, '2023-10-01 12:55:23', 1, NULL, '2023-10-01 12:55:23'),
(11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 17:32:12', 1, NULL, '2023-10-01 17:32:12'),
(12, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 17:36:30', 1, NULL, '2023-10-01 17:36:30'),
(13, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 17:42:42', 1, NULL, '2023-10-01 17:42:42'),
(14, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 17:45:19', 1, NULL, '2023-10-01 17:45:19'),
(15, 15, NULL, 'Fendi Shoes A005', 'Fendi Shoes A005', 'Fendi Shoes A005', 'Fendi Shoes A005', NULL, NULL, NULL, NULL, NULL, '2023-10-01 18:45:19', 1, NULL, '2023-10-01 18:45:19'),
(16, 16, NULL, 'Fendi Shoes A006', 'Fendi Shoes A006', 'Fendi Shoes A006', 'Fendi Shoes A006', NULL, NULL, NULL, NULL, NULL, '2023-10-01 18:59:37', 1, NULL, '2023-10-01 18:59:37'),
(17, 17, NULL, 'Fendi Shoes A007', 'Fendi Shoes A007', 'Fendi Shoes A007', 'Fendi Shoes A007', NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:02:19', 1, NULL, '2023-10-01 19:02:19'),
(18, 18, NULL, 'Fendi Shoes A008', 'Fendi Shoes A008', 'Fendi Shoes A008', 'Fendi Shoes A008', NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:04:19', 1, NULL, '2023-10-01 19:04:19'),
(19, 19, NULL, 'Fendi Shoes A009', 'Fendi Shoes A009', 'Fendi Shoes A009', 'Fendi Shoes A009', NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:05:54', 1, NULL, '2023-10-01 19:05:54'),
(20, 20, NULL, 'Fendi Shoes A010', 'Fendi Shoes A010', 'Fendi Shoes A010', 'Fendi Shoes A010', NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:07:28', 1, NULL, '2023-10-01 19:07:28'),
(21, 21, NULL, 'LV MEN BAGS A001', 'LV MEN BAGS A001', 'LV MEN BAGS A001', 'LV MEN BAGS A001', NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:24:35', 1, NULL, '2023-10-01 19:24:35'),
(22, 22, NULL, 'LV MEN BAGS A002', 'LV MEN BAGS A002', 'LV MEN BAGS A002', 'LV MEN BAGS A002', NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:31:53', 1, NULL, '2023-10-01 19:31:53'),
(23, 23, NULL, 'LV MEN BAGS A003', 'LV MEN BAGS A003', 'LV MEN BAGS A003', 'LV MEN BAGS A003', NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:33:33', 1, NULL, '2023-10-01 19:33:33'),
(24, 24, NULL, 'LV MEN BAGS A004', 'LV MEN BAGS A004', 'LV MEN BAGS A004', 'LV MEN BAGS A004', NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:34:48', 1, NULL, '2023-10-01 19:34:48'),
(25, 25, NULL, NULL, 'dghfyryh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:54:33', 1, NULL, '2024-01-23 20:54:29'),
(26, 26, NULL, NULL, 'gfhfyhy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 19:58:32', 1, NULL, '2024-01-23 20:54:40'),
(27, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 20:00:20', 1, NULL, '2023-10-01 20:00:20'),
(28, 28, NULL, NULL, 'cxvfdsgsdsd', 'hgfhgfh', 'sdfsfsdf', NULL, NULL, NULL, NULL, NULL, '2023-10-01 20:00:23', 1, NULL, '2024-01-25 20:59:18'),
(29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 20:03:40', 1, NULL, '2023-10-01 20:03:40'),
(30, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-01 20:29:39', 1, NULL, '2023-10-01 20:29:39'),
(31, 31, '<p><span style=\"font-family: \"Times New Roman\";\">Introducing the T-shirt A01, a versatile and stylish addition to your wardrobe. Crafted with high-quality materials, this T-shirt offers both comfort and durability. Its classic design features a crew neck and short sleeves, making it suitable for any casual occasion. The A01 is available in a range of vibrant colors, allowing you to express your personal style. Whether you\'re dressing up or down, this T-shirt is a must-have staple that effortlessly combines fashion and functionality.</span><br></p>', NULL, 'Test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-02 17:23:17', 1, NULL, '2024-06-26 18:29:00'),
(32, 32, '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-02 17:26:35', 1, NULL, '2025-07-05 20:00:55'),
(33, 33, NULL, NULL, NULL, NULL, 'Test', NULL, NULL, NULL, NULL, NULL, '2023-10-02 17:29:35', 1, NULL, '2023-12-05 18:05:15'),
(37, 37, '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</span><br></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-04 17:22:47', 1, NULL, '2023-12-25 17:21:13'),
(39, 39, '<p>ertret</p>', 'ertret', 'ertret', 'ertret', 'ertret', NULL, NULL, NULL, NULL, NULL, '2023-12-25 18:12:13', 1, NULL, '2023-12-25 18:12:13'),
(40, 40, '<p>Chanel Preppy Coco Small Bowling Bag<br></p>', NULL, 'Chanel Preppy Coco Small Bowling Bag', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-10 16:51:16', 1, NULL, '2026-05-03 18:28:54'),
(41, 41, '<p>Chanel Small Shopping Bag<br></p>', NULL, 'Chanel Small Shopping Bag', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 17:42:39', 1, NULL, '2026-05-03 18:26:29'),
(42, 42, '<p>CHANEL 181123-113 Xcm<br></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-23 17:46:20', 1, NULL, '2024-01-23 17:46:20'),
(50, 50, NULL, 'Fendi Shoes A009', 'Fendi Shoes A009', 'Fendi Shoes A009', 'Fendi Shoes A009', NULL, NULL, NULL, NULL, NULL, '2024-06-01 11:24:47', 1, NULL, '2024-06-01 11:24:47'),
(51, 51, NULL, 'Fendi Shoes A008', 'Fendi Shoes A008', 'Fendi Shoes A008', 'Fendi Shoes A008', NULL, NULL, NULL, NULL, NULL, '2024-06-01 11:24:47', 1, NULL, '2024-06-01 11:24:47'),
(53, 53, NULL, 'Fendi Shoes A006', 'Fendi Shoes A006', 'Fendi Shoes A006', 'Fendi Shoes A006', NULL, NULL, NULL, NULL, NULL, '2024-06-01 11:24:47', 1, NULL, '2024-06-01 11:24:47'),
(54, 54, NULL, 'Fendi Shoes A005', 'Fendi Shoes A005', 'Fendi Shoes A005', 'Fendi Shoes A005', NULL, NULL, NULL, NULL, NULL, '2024-06-01 11:24:47', 1, NULL, '2024-06-01 11:24:47'),
(55, 55, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-01 11:24:47', 1, NULL, '2024-06-01 11:24:47'),
(56, 56, NULL, NULL, 'Hermes Jypsiere Mini Brown', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-01 11:24:47', 1, NULL, '2026-05-03 18:09:36'),
(57, 57, NULL, NULL, 'Hermes Jypsiere Mini White', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-01 11:24:47', 1, NULL, '2026-05-03 18:07:20'),
(58, 58, NULL, NULL, 'Gucci GG Supreme canvas pouch in black and gray', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-01 11:24:47', 1, NULL, '2026-05-03 18:00:47'),
(70, 70, NULL, NULL, 'Hermès Kelly 18 belt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-29 10:47:48', 1, NULL, '2026-05-03 17:51:46'),
(72, 72, NULL, NULL, NULL, NULL, 'Test', NULL, NULL, NULL, NULL, NULL, '2024-11-20 19:06:14', 1, NULL, '2024-11-20 19:06:14'),
(79, 81, NULL, NULL, NULL, NULL, NULL, 'des_1745415397_c4394bc371c934feb3a4.jpg', 'doc_1745415397_aa8d99b1313e432668ab.pdf', 'saf_1745415397_5c3e4c242af480e6bd19.pdf', 'ins_1745415397_d5dd848c44b6e2216306.pdf', 's0ab0CdGWMo', '2025-02-03 18:38:59', 1, NULL, '2025-04-23 19:36:37'),
(82, 84, '<p>new products</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-13 19:37:23', 1, NULL, '2025-07-13 19:37:23'),
(83, 85, '<p>New watermark test</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-30 18:46:12', 1, NULL, '2025-07-30 18:46:12'),
(84, 86, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-16 17:54:50', 1, NULL, '2025-09-16 17:54:50'),
(85, 87, '<p>Cartier Necklace</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-17 19:34:11', 1, NULL, '2025-09-17 19:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_feedback`
--

CREATE TABLE `cc_product_feedback` (
  `product_feedback_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `feedback_star` int NOT NULL,
  `feedback_text` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Active') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_feedback`
--

INSERT INTO `cc_product_feedback` (`product_feedback_id`, `product_id`, `customer_id`, `feedback_star`, `feedback_text`, `status`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(2, 81, 9, 5, 'nice', 'Pending', '2026-03-19 16:39:07', NULL, NULL, '2026-03-19 16:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_free_delivery`
--

CREATE TABLE `cc_product_free_delivery` (
  `product_free_delivery_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_free_delivery`
--

INSERT INTO `cc_product_free_delivery` (`product_free_delivery_id`, `product_id`, `sort_order`) VALUES
(1, 24, 0),
(2, 39, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_image`
--

CREATE TABLE `cc_product_image` (
  `product_image_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `Product_option_id` int DEFAULT NULL,
  `main_image` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `alt_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_image`
--

INSERT INTO `cc_product_image` (`product_image_id`, `product_id`, `Product_option_id`, `main_image`, `image`, `alt_name`, `sort_order`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(38, 8, NULL, NULL, 'pro_1696142862_4d4f3bdc9cb0c19a7b05.jpg', NULL, 0, '2023-10-01 12:47:42', NULL, NULL, '2023-10-01 12:47:43'),
(39, 8, NULL, NULL, 'pro_1696142863_39bdb6b5b4a37183e6da.jpg', NULL, 0, '2023-10-01 12:47:43', NULL, NULL, '2023-10-01 12:47:43'),
(40, 8, NULL, NULL, 'pro_1696142863_dc95c1dc9f38046f9deb.jpg', NULL, 0, '2023-10-01 12:47:43', NULL, NULL, '2023-10-01 12:47:43'),
(41, 8, NULL, NULL, 'pro_1696142863_fccf0e7f3818f46cf708.jpg', NULL, 0, '2023-10-01 12:47:43', NULL, NULL, '2023-10-01 12:47:43'),
(42, 8, NULL, NULL, 'pro_1696142863_d31c959725bce07cae30.jpg', NULL, 0, '2023-10-01 12:47:43', NULL, NULL, '2023-10-01 12:47:44'),
(43, 8, NULL, NULL, 'pro_1696142864_1ecb2788c34c0d9f584a.jpg', NULL, 0, '2023-10-01 12:47:44', NULL, NULL, '2023-10-01 12:47:44'),
(44, 8, NULL, NULL, 'pro_1696142864_a33af623d277c08d4915.jpg', NULL, 0, '2023-10-01 12:47:44', NULL, NULL, '2023-10-01 12:47:44'),
(45, 8, NULL, NULL, 'pro_1696142864_b7b8138633a6083fae14.jpg', NULL, 0, '2023-10-01 12:47:44', NULL, NULL, '2023-10-01 12:47:45'),
(46, 9, NULL, NULL, 'pro_1696143179_709b5a2acb141149bf98.jpg', NULL, 0, '2023-10-01 12:52:59', NULL, NULL, '2023-10-01 12:52:59'),
(48, 9, NULL, NULL, 'pro_1696143179_38c8d11f842ab489c856.jpg', NULL, 0, '2023-10-01 12:52:59', NULL, NULL, '2023-10-01 12:53:00'),
(49, 9, NULL, NULL, 'pro_1696143180_e1431a4a33da2b960f86.jpg', NULL, 0, '2023-10-01 12:53:00', NULL, NULL, '2023-10-01 12:53:00'),
(50, 9, NULL, NULL, 'pro_1696143180_0b9799e2a4371d5a99fa.jpg', NULL, 0, '2023-10-01 12:53:00', NULL, NULL, '2023-10-01 12:53:00'),
(51, 9, NULL, NULL, 'pro_1696143180_63c591a21247322d38a8.jpg', NULL, 0, '2023-10-01 12:53:00', NULL, NULL, '2023-10-01 12:53:01'),
(52, 9, NULL, NULL, 'pro_1696143181_12d5bbf9ceddf4d1a7e1.jpg', NULL, 0, '2023-10-01 12:53:01', NULL, NULL, '2023-10-01 12:53:01'),
(53, 10, NULL, NULL, 'pro_1696143321_78b7b249ab7bca151326.jpg', NULL, 0, '2023-10-01 12:55:21', NULL, NULL, '2023-10-01 12:55:21'),
(54, 10, NULL, NULL, 'pro_1696143321_7b471396cf1947bfdbd5.jpg', NULL, 0, '2023-10-01 12:55:21', NULL, NULL, '2023-10-01 12:55:21'),
(55, 10, NULL, NULL, 'pro_1696143321_8baeff6886aa29599f34.jpg', NULL, 0, '2023-10-01 12:55:21', NULL, NULL, '2023-10-01 12:55:22'),
(56, 10, NULL, NULL, 'pro_1696143322_4d96cc871821b3bd0cea.jpg', NULL, 0, '2023-10-01 12:55:22', NULL, NULL, '2023-10-01 12:55:22'),
(57, 10, NULL, NULL, 'pro_1696143322_16417e51b4f5fe3b8032.jpg', NULL, 0, '2023-10-01 12:55:22', NULL, NULL, '2023-10-01 12:55:22'),
(58, 10, NULL, NULL, 'pro_1696143322_8e3500a0fa8fef438a6b.jpg', NULL, 0, '2023-10-01 12:55:22', NULL, NULL, '2023-10-01 12:55:23'),
(59, 10, NULL, NULL, 'pro_1696143323_5a484d5dc52b403451d3.jpg', NULL, 0, '2023-10-01 12:55:23', NULL, NULL, '2023-10-01 12:55:23'),
(60, 7, NULL, NULL, 'pro_1696159638_f75ca44e10f0a6d5cc5a.jpg', NULL, 0, '2023-10-01 17:27:18', NULL, NULL, '2023-10-01 17:27:18'),
(61, 7, NULL, NULL, 'pro_1696159638_b52323ae0ad9795bbab7.jpg', NULL, 0, '2023-10-01 17:27:18', NULL, NULL, '2023-10-01 17:27:19'),
(62, 7, NULL, NULL, 'pro_1696159639_2f3dd81ec5dc42e44031.jpg', NULL, 0, '2023-10-01 17:27:19', NULL, NULL, '2023-10-01 17:27:20'),
(63, 7, NULL, NULL, 'pro_1696159640_137283012764cbb60232.jpg', NULL, 0, '2023-10-01 17:27:20', NULL, NULL, '2023-10-01 17:27:21'),
(64, 7, NULL, NULL, 'pro_1696159641_bd2fbe7e3ecfd2b45eb1.jpg', NULL, 0, '2023-10-01 17:27:21', NULL, NULL, '2023-10-01 17:27:21'),
(65, 7, NULL, NULL, 'pro_1696159641_a619c1233a2b2ccc1be4.jpg', NULL, 0, '2023-10-01 17:27:21', NULL, NULL, '2023-10-01 17:27:22'),
(66, 7, NULL, NULL, 'pro_1696159642_eee0f739a829f61793b6.jpg', NULL, 0, '2023-10-01 17:27:22', NULL, NULL, '2023-10-01 17:27:23'),
(67, 6, NULL, NULL, 'pro_1696159825_7055139333a44ac43d41.jpg', NULL, 0, '2023-10-01 17:30:25', NULL, NULL, '2023-10-01 17:30:25'),
(68, 6, NULL, NULL, 'pro_1696159825_1e84f3c8e0b0f6b0c33b.jpg', NULL, 0, '2023-10-01 17:30:25', NULL, NULL, '2023-10-01 17:30:26'),
(69, 6, NULL, NULL, 'pro_1696159826_87126e3e2161cebf4d23.jpg', NULL, 0, '2023-10-01 17:30:26', NULL, NULL, '2023-10-01 17:30:26'),
(70, 6, NULL, NULL, 'pro_1696159826_3858a0b62146d2851737.jpg', NULL, 0, '2023-10-01 17:30:26', NULL, NULL, '2023-10-01 17:30:26'),
(71, 6, NULL, NULL, 'pro_1696159826_0541628df49b576f6793.jpg', NULL, 0, '2023-10-01 17:30:26', NULL, NULL, '2023-10-01 17:30:27'),
(72, 6, NULL, NULL, 'pro_1696159827_22792aa7b6e5671db43f.jpg', NULL, 0, '2023-10-01 17:30:27', NULL, NULL, '2023-10-01 17:30:27'),
(73, 6, NULL, NULL, 'pro_1696159827_bf37e7e6747d25a2230a.jpg', NULL, 0, '2023-10-01 17:30:27', NULL, NULL, '2023-10-01 17:30:27'),
(74, 6, NULL, NULL, 'pro_1696159827_b2ce4c26c001b765e960.jpg', NULL, 0, '2023-10-01 17:30:27', NULL, NULL, '2023-10-01 17:30:28'),
(75, 11, NULL, NULL, 'pro_1696159929_1f087b3b62df88a55013.jpg', NULL, 0, '2023-10-01 17:32:09', NULL, NULL, '2023-10-01 17:32:09'),
(76, 11, NULL, NULL, 'pro_1696159929_96901f172269c84b8802.jpg', NULL, 0, '2023-10-01 17:32:09', NULL, NULL, '2023-10-01 17:32:10'),
(77, 11, NULL, NULL, 'pro_1696159930_7582b6553212ee33b856.jpg', NULL, 0, '2023-10-01 17:32:10', NULL, NULL, '2023-10-01 17:32:10'),
(78, 11, NULL, NULL, 'pro_1696159930_45e672ea95d9e39b304e.jpg', NULL, 0, '2023-10-01 17:32:10', NULL, NULL, '2023-10-01 17:32:10'),
(79, 11, NULL, NULL, 'pro_1696159930_e193f076d184a4411e06.jpg', NULL, 0, '2023-10-01 17:32:10', NULL, NULL, '2023-10-01 17:32:11'),
(80, 11, NULL, NULL, 'pro_1696159931_896bbe6ec266c0db6764.jpg', NULL, 0, '2023-10-01 17:32:11', NULL, NULL, '2023-10-01 17:32:11'),
(81, 11, NULL, NULL, 'pro_1696159931_960188ca28acf013789d.jpg', NULL, 0, '2023-10-01 17:32:11', NULL, NULL, '2023-10-01 17:32:11'),
(82, 11, NULL, NULL, 'pro_1696159931_bba2b9ebbed748cc5106.jpg', NULL, 0, '2023-10-01 17:32:11', NULL, NULL, '2023-10-01 17:32:12'),
(83, 5, NULL, NULL, 'pro_1696160004_977c9383caabb00b0cc9.jpg', NULL, 0, '2023-10-01 17:33:24', NULL, NULL, '2023-10-01 17:33:25'),
(84, 5, NULL, NULL, 'pro_1696160005_d257f8fe76afcd26fefc.jpg', NULL, 0, '2023-10-01 17:33:25', NULL, NULL, '2023-10-01 17:33:25'),
(85, 5, NULL, NULL, 'pro_1696160005_1a29ce4f3e23b684cece.jpg', NULL, 0, '2023-10-01 17:33:25', NULL, NULL, '2023-10-01 17:33:25'),
(86, 5, NULL, NULL, 'pro_1696160005_c362d726be2814c9e065.jpg', NULL, 0, '2023-10-01 17:33:25', NULL, NULL, '2023-10-01 17:33:26'),
(87, 5, NULL, NULL, 'pro_1696160006_00decf85cd65d7b80706.jpg', NULL, 0, '2023-10-01 17:33:26', NULL, NULL, '2023-10-01 17:33:26'),
(88, 5, NULL, NULL, 'pro_1696160006_a80159184e37b247c53e.jpg', NULL, 0, '2023-10-01 17:33:26', NULL, NULL, '2023-10-01 17:33:26'),
(89, 5, NULL, NULL, 'pro_1696160006_36ec40e885374034e260.jpg', NULL, 0, '2023-10-01 17:33:26', NULL, NULL, '2023-10-01 17:33:27'),
(90, 5, NULL, NULL, 'pro_1696160007_a0bde29775ba876b5ede.jpg', NULL, 0, '2023-10-01 17:33:27', NULL, NULL, '2023-10-01 17:33:27'),
(91, 12, NULL, NULL, 'pro_1696160189_bdbcfd7d170723b50923.jpg', NULL, 0, '2023-10-01 17:36:29', NULL, NULL, '2023-10-01 17:36:29'),
(92, 12, NULL, NULL, 'pro_1696160189_5d57bd517832e23df07e.jpg', NULL, 0, '2023-10-01 17:36:29', NULL, NULL, '2023-10-01 17:36:29'),
(93, 12, NULL, NULL, 'pro_1696160189_fd1cf4bf20a7894c931c.jpg', NULL, 0, '2023-10-01 17:36:29', NULL, NULL, '2023-10-01 17:36:30'),
(94, 12, NULL, NULL, 'pro_1696160190_d9fe1cedc1b4ae2599e2.jpg', NULL, 0, '2023-10-01 17:36:30', NULL, NULL, '2023-10-01 17:36:30'),
(95, 12, NULL, NULL, 'pro_1696160190_cedee3b72cb38dde7c3d.jpg', NULL, 0, '2023-10-01 17:36:30', NULL, NULL, '2023-10-01 17:36:30'),
(96, 12, NULL, NULL, 'pro_1696160190_6c47a61c5e843ed0e63a.jpg', NULL, 0, '2023-10-01 17:36:30', NULL, NULL, '2023-10-01 17:36:30'),
(97, 12, NULL, NULL, 'pro_1696160190_9e50a73e7a69edb90856.jpg', NULL, 0, '2023-10-01 17:36:30', NULL, NULL, '2023-10-01 17:36:30'),
(98, 13, NULL, NULL, 'pro_1696160560_31084d2eadcc6a7d3e68.jpg', NULL, 0, '2023-10-01 17:42:40', NULL, NULL, '2023-10-01 17:42:40'),
(99, 13, NULL, NULL, 'pro_1696160560_28ed07cbfb4b4976b29f.jpg', NULL, 0, '2023-10-01 17:42:40', NULL, NULL, '2023-10-01 17:42:40'),
(100, 13, NULL, NULL, 'pro_1696160560_52a34fe365539ea09f29.jpg', NULL, 0, '2023-10-01 17:42:40', NULL, NULL, '2023-10-01 17:42:41'),
(101, 13, NULL, NULL, 'pro_1696160561_f24e95cf26d7eb1a5af5.jpg', NULL, 0, '2023-10-01 17:42:41', NULL, NULL, '2023-10-01 17:42:41'),
(102, 13, NULL, NULL, 'pro_1696160561_64c598a32c8d78773e3e.jpg', NULL, 0, '2023-10-01 17:42:41', NULL, NULL, '2023-10-01 17:42:41'),
(103, 13, NULL, NULL, 'pro_1696160561_37e5c06bdd9f451ae73a.jpg', NULL, 0, '2023-10-01 17:42:41', NULL, NULL, '2023-10-01 17:42:41'),
(104, 13, NULL, NULL, 'pro_1696160561_9b3bfa5d993ae19e1e76.jpg', NULL, 0, '2023-10-01 17:42:41', NULL, NULL, '2023-10-01 17:42:42'),
(105, 13, NULL, NULL, 'pro_1696160562_f2857c0076a9d287c550.jpg', NULL, 0, '2023-10-01 17:42:42', NULL, NULL, '2023-10-01 17:42:42'),
(114, 14, NULL, NULL, 'pro_1696160717_b45346da7cc11a5291f7.jpg', NULL, 0, '2023-10-01 17:45:17', NULL, NULL, '2023-10-01 17:45:17'),
(115, 14, NULL, NULL, 'pro_1696160717_f9229429cdc27f389bdc.jpg', NULL, 0, '2023-10-01 17:45:17', NULL, NULL, '2023-10-01 17:45:17'),
(116, 14, NULL, NULL, 'pro_1696160717_eccd5f6e11106826ca92.jpg', NULL, 0, '2023-10-01 17:45:17', NULL, NULL, '2023-10-01 17:45:18'),
(117, 14, NULL, NULL, 'pro_1696160718_e18e83e860359ea76b5b.jpg', NULL, 0, '2023-10-01 17:45:18', NULL, NULL, '2023-10-01 17:45:18'),
(118, 14, NULL, NULL, 'pro_1696160718_10d5c5a74021db9b31ec.jpg', NULL, 0, '2023-10-01 17:45:18', NULL, NULL, '2023-10-01 17:45:18'),
(119, 14, NULL, NULL, 'pro_1696160718_7840440bc0a37a8a5bb6.jpg', NULL, 0, '2023-10-01 17:45:18', NULL, NULL, '2023-10-01 17:45:19'),
(120, 14, NULL, NULL, 'pro_1696160719_926f19aba1dbe134d29a.jpg', NULL, 0, '2023-10-01 17:45:19', NULL, NULL, '2023-10-01 17:45:19'),
(121, 14, NULL, NULL, 'pro_1696160719_6cad24b6dd5facf83725.jpg', NULL, 0, '2023-10-01 17:45:19', NULL, NULL, '2023-10-01 17:45:19'),
(122, 3, NULL, NULL, 'pro_1696160995_f31a010c6f76422aa387.jpg', NULL, 0, '2023-10-01 17:49:55', NULL, NULL, '2023-10-01 17:49:55'),
(123, 3, NULL, NULL, 'pro_1696160995_39431eb5407508416b1a.jpg', NULL, 0, '2023-10-01 17:49:55', NULL, NULL, '2023-10-01 17:49:56'),
(124, 3, NULL, NULL, 'pro_1696160996_8eb473513d1da45ceb01.jpg', NULL, 0, '2023-10-01 17:49:56', NULL, NULL, '2023-10-01 17:49:56'),
(125, 3, NULL, NULL, 'pro_1696160996_681d928e3157b278ac92.jpg', NULL, 0, '2023-10-01 17:49:56', NULL, NULL, '2023-10-01 17:49:57'),
(126, 3, NULL, NULL, 'pro_1696160997_130820328b44cebd7672.jpg', NULL, 0, '2023-10-01 17:49:57', NULL, NULL, '2023-10-01 17:49:57'),
(127, 3, NULL, NULL, 'pro_1696160997_1b69a4e3429b1c3beba5.jpg', NULL, 0, '2023-10-01 17:49:57', NULL, NULL, '2023-10-01 17:49:58'),
(128, 3, NULL, NULL, 'pro_1696160998_7e09720c98853ca1f223.jpg', NULL, 0, '2023-10-01 17:49:58', NULL, NULL, '2023-10-01 17:49:58'),
(129, 3, NULL, NULL, 'pro_1696160998_31a4ab6c075880a92737.jpg', NULL, 0, '2023-10-01 17:49:58', NULL, NULL, '2023-10-01 17:49:59'),
(130, 2, NULL, NULL, 'pro_1696161104_618e469617e960e08ca1.jpg', NULL, 0, '2023-10-01 17:51:44', NULL, NULL, '2023-10-01 17:51:44'),
(131, 2, NULL, NULL, 'pro_1696161104_06af2aa345303cf07129.jpg', NULL, 0, '2023-10-01 17:51:44', NULL, NULL, '2023-10-01 17:51:45'),
(132, 2, NULL, NULL, 'pro_1696161105_f441f588055ec13eb7aa.jpg', NULL, 0, '2023-10-01 17:51:45', NULL, NULL, '2023-10-01 17:51:45'),
(133, 2, NULL, NULL, 'pro_1696161105_4cbea9d43c02d700f619.jpg', NULL, 0, '2023-10-01 17:51:45', NULL, NULL, '2023-10-01 17:51:45'),
(134, 2, NULL, NULL, 'pro_1696161105_8ff596a98e5b610848f9.jpg', NULL, 0, '2023-10-01 17:51:45', NULL, NULL, '2023-10-01 17:51:46'),
(135, 2, NULL, NULL, 'pro_1696161106_c81183a60f7557120143.jpg', NULL, 0, '2023-10-01 17:51:46', NULL, NULL, '2023-10-01 17:51:46'),
(136, 2, NULL, NULL, 'pro_1696161106_9e0a587b9321a5a8b9ab.jpg', NULL, 0, '2023-10-01 17:51:46', NULL, NULL, '2023-10-01 17:51:46'),
(137, 2, NULL, NULL, 'pro_1696161106_3fae90c5a3e9048f7043.jpg', NULL, 0, '2023-10-01 17:51:46', NULL, NULL, '2023-10-01 17:51:46'),
(138, 1, NULL, NULL, 'pro_1696164202_e52b4f431630359b2bb3.jpg', NULL, 0, '2023-10-01 18:43:22', NULL, NULL, '2023-10-01 18:43:23'),
(139, 1, NULL, NULL, 'pro_1696164203_3ca852fe9a2e9758e902.jpg', NULL, 0, '2023-10-01 18:43:23', NULL, NULL, '2023-10-01 18:43:23'),
(140, 1, NULL, NULL, 'pro_1696164203_ece37792e46b43e2084a.jpg', NULL, 0, '2023-10-01 18:43:23', NULL, NULL, '2023-10-01 18:43:23'),
(141, 1, NULL, NULL, 'pro_1696164203_51c1c1338fae2a3cc407.jpg', NULL, 0, '2023-10-01 18:43:23', NULL, NULL, '2023-10-01 18:43:24'),
(142, 1, NULL, NULL, 'pro_1696164204_ec4a8f2686b4154a9eff.jpg', NULL, 0, '2023-10-01 18:43:24', NULL, NULL, '2023-10-01 18:43:24'),
(143, 1, NULL, NULL, 'pro_1696164204_dec82a0fcdd0fd6052de.jpg', NULL, 0, '2023-10-01 18:43:24', NULL, NULL, '2023-10-01 18:43:24'),
(144, 1, NULL, NULL, 'pro_1696164204_eef918605d87f0d4ddfc.jpg', NULL, 0, '2023-10-01 18:43:24', NULL, NULL, '2023-10-01 18:43:25'),
(145, 1, NULL, NULL, 'pro_1696164205_d79b37e755977f80d974.jpg', NULL, 0, '2023-10-01 18:43:25', NULL, NULL, '2023-10-01 18:43:25'),
(155, 16, NULL, NULL, 'pro_1696165172_fc97d6445735495737aa.jpg', NULL, 0, '2023-10-01 18:59:32', NULL, NULL, '2023-10-01 18:59:33'),
(156, 16, NULL, NULL, 'pro_1696165173_233daf487d2ef3adc922.jpg', NULL, 0, '2023-10-01 18:59:33', NULL, NULL, '2023-10-01 18:59:34'),
(157, 16, NULL, NULL, 'pro_1696165174_a1995d00e1ea6784ac94.jpg', NULL, 0, '2023-10-01 18:59:34', NULL, NULL, '2023-10-01 18:59:34'),
(158, 16, NULL, NULL, 'pro_1696165174_3fc8353c6dc5a0a11004.jpg', NULL, 0, '2023-10-01 18:59:34', NULL, NULL, '2023-10-01 18:59:35'),
(159, 16, NULL, NULL, 'pro_1696165175_b4e0de82cff96cc53eb2.jpg', NULL, 0, '2023-10-01 18:59:35', NULL, NULL, '2023-10-01 18:59:35'),
(160, 16, NULL, NULL, 'pro_1696165175_8a80b895ecc27ef36125.jpg', NULL, 0, '2023-10-01 18:59:35', NULL, NULL, '2023-10-01 18:59:36'),
(161, 16, NULL, NULL, 'pro_1696165176_8786eb9e07bdb1e0b691.jpg', NULL, 0, '2023-10-01 18:59:36', NULL, NULL, '2023-10-01 18:59:37'),
(162, 16, NULL, NULL, 'pro_1696165177_d08b39d68f6cb3839df2.jpg', NULL, 0, '2023-10-01 18:59:37', NULL, NULL, '2023-10-01 18:59:37'),
(163, 17, NULL, NULL, 'pro_1696165334_ff26c30b8512819cc15f.jpg', NULL, 0, '2023-10-01 19:02:14', NULL, NULL, '2023-10-01 19:02:15'),
(164, 17, NULL, NULL, 'pro_1696165335_f9a3c1b7e095c13f49b1.jpg', NULL, 0, '2023-10-01 19:02:15', NULL, NULL, '2023-10-01 19:02:15'),
(165, 17, NULL, NULL, 'pro_1696165335_bc8fd09a2a2df30c8a8d.jpg', NULL, 0, '2023-10-01 19:02:15', NULL, NULL, '2023-10-01 19:02:16'),
(166, 17, NULL, NULL, 'pro_1696165336_85f3954801e74c7bafec.jpg', NULL, 0, '2023-10-01 19:02:16', NULL, NULL, '2023-10-01 19:02:17'),
(167, 17, NULL, NULL, 'pro_1696165337_b422159030270c685670.jpg', NULL, 0, '2023-10-01 19:02:17', NULL, NULL, '2023-10-01 19:02:17'),
(168, 17, NULL, NULL, 'pro_1696165337_85ba05589f9b8365ddd8.jpg', NULL, 0, '2023-10-01 19:02:17', NULL, NULL, '2023-10-01 19:02:18'),
(169, 17, NULL, NULL, 'pro_1696165338_304a366aaef729e956e0.jpg', NULL, 0, '2023-10-01 19:02:18', NULL, NULL, '2023-10-01 19:02:18'),
(170, 17, NULL, NULL, 'pro_1696165338_0b3276fe3ba7b96fd88e.jpg', NULL, 0, '2023-10-01 19:02:18', NULL, NULL, '2023-10-01 19:02:19'),
(171, 18, NULL, NULL, 'pro_1696165454_799804bacd697e13f74b.jpg', NULL, 0, '2023-10-01 19:04:14', NULL, NULL, '2023-10-01 19:04:15'),
(172, 18, NULL, NULL, 'pro_1696165455_27ff5a144b60a92ae7c3.jpg', NULL, 0, '2023-10-01 19:04:15', NULL, NULL, '2023-10-01 19:04:15'),
(173, 18, NULL, NULL, 'pro_1696165455_d6102e869686dc358bd1.jpg', NULL, 0, '2023-10-01 19:04:15', NULL, NULL, '2023-10-01 19:04:16'),
(174, 18, NULL, NULL, 'pro_1696165456_edd4a75aa2eb9691f66b.jpg', NULL, 0, '2023-10-01 19:04:16', NULL, NULL, '2023-10-01 19:04:16'),
(175, 18, NULL, NULL, 'pro_1696165456_ccf5b27fda1b7d7f2e13.jpg', NULL, 0, '2023-10-01 19:04:16', NULL, NULL, '2023-10-01 19:04:17'),
(176, 18, NULL, NULL, 'pro_1696165457_446ff4c4ffede16b1300.jpg', NULL, 0, '2023-10-01 19:04:17', NULL, NULL, '2023-10-01 19:04:18'),
(177, 18, NULL, NULL, 'pro_1696165458_f4014cffa4e36e18523e.jpg', NULL, 0, '2023-10-01 19:04:18', NULL, NULL, '2023-10-01 19:04:18'),
(178, 18, NULL, NULL, 'pro_1696165458_140156ce726976359b83.jpg', NULL, 0, '2023-10-01 19:04:18', NULL, NULL, '2023-10-01 19:04:19'),
(179, 19, NULL, NULL, 'pro_1696165549_312673a30817363f2a5b.jpg', NULL, 0, '2023-10-01 19:05:49', NULL, NULL, '2023-10-01 19:05:50'),
(180, 19, NULL, NULL, 'pro_1696165550_4e3a902c02dc1d00cafe.jpg', NULL, 0, '2023-10-01 19:05:50', NULL, NULL, '2023-10-01 19:05:50'),
(181, 19, NULL, NULL, 'pro_1696165550_492971bde34739731d5e.jpg', NULL, 0, '2023-10-01 19:05:50', NULL, NULL, '2023-10-01 19:05:51'),
(182, 19, NULL, NULL, 'pro_1696165551_35902b69f80d2340eb13.jpg', NULL, 0, '2023-10-01 19:05:51', NULL, NULL, '2023-10-01 19:05:51'),
(183, 19, NULL, NULL, 'pro_1696165551_c4bfa3ef4198d5c8036e.jpg', NULL, 0, '2023-10-01 19:05:51', NULL, NULL, '2023-10-01 19:05:52'),
(184, 19, NULL, NULL, 'pro_1696165552_83ab49d29c62ddc1e999.jpg', NULL, 0, '2023-10-01 19:05:52', NULL, NULL, '2023-10-01 19:05:52'),
(185, 19, NULL, NULL, 'pro_1696165552_c5c894364d58d7c40b69.jpg', NULL, 0, '2023-10-01 19:05:52', NULL, NULL, '2023-10-01 19:05:53'),
(186, 19, NULL, NULL, 'pro_1696165553_7f71ee47fc4f27bbf457.jpg', NULL, 0, '2023-10-01 19:05:53', NULL, NULL, '2023-10-01 19:05:54'),
(187, 20, NULL, NULL, 'pro_1696165644_7379a3c81787602a9d3f.jpg', NULL, 0, '2023-10-01 19:07:24', NULL, NULL, '2023-10-01 19:07:24'),
(188, 20, NULL, NULL, 'pro_1696165644_53a101270631ac1bd5fe.jpg', NULL, 0, '2023-10-01 19:07:24', NULL, NULL, '2023-10-01 19:07:25'),
(189, 20, NULL, NULL, 'pro_1696165645_de0e8e56cf7f56073301.jpg', NULL, 0, '2023-10-01 19:07:25', NULL, NULL, '2023-10-01 19:07:25'),
(190, 20, NULL, NULL, 'pro_1696165645_c5cbe85aaa88be387082.jpg', NULL, 0, '2023-10-01 19:07:25', NULL, NULL, '2023-10-01 19:07:26'),
(191, 20, NULL, NULL, 'pro_1696165646_1d8df202c2c1bfe98129.jpg', NULL, 0, '2023-10-01 19:07:26', NULL, NULL, '2023-10-01 19:07:27'),
(192, 20, NULL, NULL, 'pro_1696165647_d8ca6ddc0482e9e9e35e.jpg', NULL, 0, '2023-10-01 19:07:27', NULL, NULL, '2023-10-01 19:07:27'),
(193, 20, NULL, NULL, 'pro_1696165647_6d2e6415d552973d6eda.jpg', NULL, 0, '2023-10-01 19:07:27', NULL, NULL, '2023-10-01 19:07:28'),
(194, 20, NULL, NULL, 'pro_1696165648_e0bd8cde9456923faba2.jpg', NULL, 0, '2023-10-01 19:07:28', NULL, NULL, '2023-10-01 19:07:28'),
(195, 21, NULL, NULL, 'pro_1696166672_703f45fdb34d82357491.jpg', NULL, 0, '2023-10-01 19:24:32', NULL, NULL, '2023-10-01 19:24:32'),
(196, 21, NULL, NULL, 'pro_1696166672_dba79a17b87e285f2514.jpg', NULL, 0, '2023-10-01 19:24:32', NULL, NULL, '2023-10-01 19:24:33'),
(197, 21, NULL, NULL, 'pro_1696166673_466519ece6ca71ccb6d0.jpg', NULL, 0, '2023-10-01 19:24:33', NULL, NULL, '2023-10-01 19:24:34'),
(198, 21, NULL, NULL, 'pro_1696166674_9752b94aa1771cb8bb13.jpg', NULL, 0, '2023-10-01 19:24:34', NULL, NULL, '2023-10-01 19:24:34'),
(199, 21, NULL, NULL, 'pro_1696166674_1f22d2b58d29ffb473b4.jpg', NULL, 0, '2023-10-01 19:24:34', NULL, NULL, '2023-10-01 19:24:34'),
(200, 21, NULL, NULL, 'pro_1696166674_bdce837c60f8659828d0.jpg', NULL, 0, '2023-10-01 19:24:34', NULL, NULL, '2023-10-01 19:24:34'),
(201, 21, NULL, NULL, 'pro_1696166674_87998c36a49e885cf468.jpg', NULL, 0, '2023-10-01 19:24:34', NULL, NULL, '2023-10-01 19:24:34'),
(202, 21, NULL, NULL, 'pro_1696166674_b56267bf3552eabf92a9.jpg', NULL, 0, '2023-10-01 19:24:34', NULL, NULL, '2023-10-01 19:24:35'),
(203, 22, NULL, NULL, 'pro_1696167111_4cbf0d1a29b1fe0803ae.jpg', NULL, 0, '2023-10-01 19:31:51', NULL, NULL, '2023-10-01 19:31:51'),
(204, 22, NULL, NULL, 'pro_1696167111_e1321b0bf7a3d74ce19b.jpg', NULL, 0, '2023-10-01 19:31:51', NULL, NULL, '2023-10-01 19:31:51'),
(205, 22, NULL, NULL, 'pro_1696167111_835fc8c327b52bcb831c.jpg', NULL, 0, '2023-10-01 19:31:51', NULL, NULL, '2023-10-01 19:31:52'),
(206, 22, NULL, NULL, 'pro_1696167112_3d1e8a72225a53276337.jpg', NULL, 0, '2023-10-01 19:31:52', NULL, NULL, '2023-10-01 19:31:52'),
(207, 22, NULL, NULL, 'pro_1696167112_eb4bb5ee347ae517e63a.jpg', NULL, 0, '2023-10-01 19:31:52', NULL, NULL, '2023-10-01 19:31:52'),
(208, 22, NULL, NULL, 'pro_1696167112_a50d6f0463e45c338e38.jpg', NULL, 0, '2023-10-01 19:31:52', NULL, NULL, '2023-10-01 19:31:52'),
(209, 22, NULL, NULL, 'pro_1696167112_dfbdaf2430a7ebf49962.jpg', NULL, 0, '2023-10-01 19:31:52', NULL, NULL, '2023-10-01 19:31:52'),
(210, 22, NULL, NULL, 'pro_1696167112_81c43a04363a6ea00381.jpg', NULL, 0, '2023-10-01 19:31:52', NULL, NULL, '2023-10-01 19:31:53'),
(211, 23, NULL, NULL, 'pro_1696167211_1310368b2559438ac633.jpg', NULL, 0, '2023-10-01 19:33:31', NULL, NULL, '2023-10-01 19:33:31'),
(212, 23, NULL, NULL, 'pro_1696167211_ac41cd606f6dd00f6719.jpg', NULL, 0, '2023-10-01 19:33:31', NULL, NULL, '2023-10-01 19:33:32'),
(213, 23, NULL, NULL, 'pro_1696167212_d0b9e01f31dd527da367.jpg', NULL, 0, '2023-10-01 19:33:32', NULL, NULL, '2023-10-01 19:33:32'),
(214, 23, NULL, NULL, 'pro_1696167212_2b2429612fa774a628a8.jpg', NULL, 0, '2023-10-01 19:33:32', NULL, NULL, '2023-10-01 19:33:32'),
(215, 23, NULL, NULL, 'pro_1696167212_f9c4cf52d70fb355a76a.jpg', NULL, 0, '2023-10-01 19:33:32', NULL, NULL, '2023-10-01 19:33:32'),
(216, 23, NULL, NULL, 'pro_1696167212_96d0be47d8a0a94445ab.jpg', NULL, 0, '2023-10-01 19:33:32', NULL, NULL, '2023-10-01 19:33:33'),
(217, 23, NULL, NULL, 'pro_1696167213_fa41f0bd1cc75ab4cc68.jpg', NULL, 0, '2023-10-01 19:33:33', NULL, NULL, '2023-10-01 19:33:33'),
(218, 23, NULL, NULL, 'pro_1696167213_a281ed6270fd14c71309.jpg', NULL, 0, '2023-10-01 19:33:33', NULL, NULL, '2023-10-01 19:33:33'),
(219, 24, NULL, NULL, 'pro_1696167286_4d2298f44e4da80245be.jpg', NULL, 0, '2023-10-01 19:34:46', NULL, NULL, '2023-10-01 19:34:46'),
(220, 24, NULL, NULL, 'pro_1696167286_19d36206107577b43cef.jpg', NULL, 0, '2023-10-01 19:34:46', NULL, NULL, '2023-10-01 19:34:47'),
(221, 24, NULL, NULL, 'pro_1696167287_cf2154ce9beb072d2ac4.jpg', NULL, 0, '2023-10-01 19:34:47', NULL, NULL, '2023-10-01 19:34:47'),
(222, 24, NULL, NULL, 'pro_1696167287_7f384a3ad047f77792bc.jpg', NULL, 0, '2023-10-01 19:34:47', NULL, NULL, '2023-10-01 19:34:47'),
(223, 24, NULL, NULL, 'pro_1696167287_4f2248198581519d572f.jpg', NULL, 0, '2023-10-01 19:34:47', NULL, NULL, '2023-10-01 19:34:47'),
(224, 24, NULL, NULL, 'pro_1696167287_e3679c2c55f0e6d829b3.jpg', NULL, 0, '2023-10-01 19:34:47', NULL, NULL, '2023-10-01 19:34:47'),
(225, 24, NULL, NULL, 'pro_1696167287_b94bb02da9c4cffcff91.jpg', NULL, 0, '2023-10-01 19:34:47', NULL, NULL, '2023-10-01 19:34:48'),
(226, 24, NULL, NULL, 'pro_1696167288_c0e79fb60eddd5781015.jpg', NULL, 0, '2023-10-01 19:34:48', NULL, NULL, '2023-10-01 19:34:48'),
(233, 26, NULL, NULL, 'pro_1696168710_c62cc3dda2b296a06431.jpg', NULL, 0, '2023-10-01 19:58:30', NULL, NULL, '2023-10-01 19:58:30'),
(234, 26, NULL, NULL, 'pro_1696168710_f4f47a53411a2d5dbb25.jpg', NULL, 0, '2023-10-01 19:58:30', NULL, NULL, '2023-10-01 19:58:30'),
(235, 26, NULL, NULL, 'pro_1696168710_4720a73049faded4302e.jpg', NULL, 0, '2023-10-01 19:58:30', NULL, NULL, '2023-10-01 19:58:31'),
(236, 26, NULL, NULL, 'pro_1696168711_4c3f3d9e95ff7993cc92.jpg', NULL, 0, '2023-10-01 19:58:31', NULL, NULL, '2023-10-01 19:58:31'),
(237, 26, NULL, NULL, 'pro_1696168711_8bdd69f994c1443e282d.jpg', NULL, 0, '2023-10-01 19:58:31', NULL, NULL, '2023-10-01 19:58:31'),
(238, 26, NULL, NULL, 'pro_1696168711_122ed1c38a4c8ee07c18.jpg', NULL, 0, '2023-10-01 19:58:31', NULL, NULL, '2023-10-01 19:58:32'),
(246, 28, NULL, NULL, 'pro_1696168821_8885d37273324a3a052c.jpg', NULL, 0, '2023-10-01 20:00:21', NULL, NULL, '2023-10-01 20:00:21'),
(247, 28, NULL, NULL, 'pro_1696168821_7873a1d44b0fc310b3f4.jpg', NULL, 0, '2023-10-01 20:00:21', NULL, NULL, '2023-10-01 20:00:21'),
(248, 28, NULL, NULL, 'pro_1696168821_c3b38aef4c047117c1ef.jpg', NULL, 0, '2023-10-01 20:00:21', NULL, NULL, '2023-10-01 20:00:22'),
(249, 28, NULL, NULL, 'pro_1696168822_ae4eccc227f583ecf5d2.jpg', NULL, 0, '2023-10-01 20:00:22', NULL, NULL, '2023-10-01 20:00:22'),
(250, 28, NULL, NULL, 'pro_1696168822_caf32db88b350772d2ab.jpg', NULL, 0, '2023-10-01 20:00:22', NULL, NULL, '2023-10-01 20:00:22'),
(251, 28, NULL, NULL, 'pro_1696168822_cba89d8c73e5ea9bbadf.jpg', NULL, 0, '2023-10-01 20:00:22', NULL, NULL, '2023-10-01 20:00:23'),
(252, 28, NULL, NULL, 'pro_1696168823_38dfcf70b673b3763285.jpg', NULL, 0, '2023-10-01 20:00:23', NULL, NULL, '2023-10-01 20:00:23'),
(253, 29, NULL, NULL, 'pro_1696169018_7d0b1b282323a13c955c.jpg', NULL, 0, '2023-10-01 20:03:38', NULL, NULL, '2023-10-01 20:03:38'),
(254, 29, NULL, NULL, 'pro_1696169018_441b58d68cd601474176.jpg', NULL, 0, '2023-10-01 20:03:38', NULL, NULL, '2023-10-01 20:03:39'),
(255, 29, NULL, NULL, 'pro_1696169019_a1a9ac194f10b07fac5a.jpg', NULL, 0, '2023-10-01 20:03:39', NULL, NULL, '2023-10-01 20:03:39'),
(256, 29, NULL, NULL, 'pro_1696169019_bf94b46888896ebe0e6c.jpg', NULL, 0, '2023-10-01 20:03:39', NULL, NULL, '2023-10-01 20:03:40'),
(257, 29, NULL, NULL, 'pro_1696169020_ebfcfc87be5eb5e5c1f0.jpg', NULL, 0, '2023-10-01 20:03:40', NULL, NULL, '2023-10-01 20:03:40'),
(258, 29, NULL, NULL, 'pro_1696169020_81c49c201bfda899107a.jpg', NULL, 0, '2023-10-01 20:03:40', NULL, NULL, '2023-10-01 20:03:40'),
(265, 31, NULL, NULL, 'pro_1696245797_d4ed31ef46a3860c1990.jpg', NULL, 0, '2023-10-02 17:23:17', NULL, NULL, '2023-10-02 17:23:17'),
(266, 31, NULL, NULL, 'pro_1696245797_cad74564c73506c1ddf0.jpg', NULL, 0, '2023-10-02 17:23:17', NULL, NULL, '2023-10-02 17:23:17'),
(267, 32, NULL, NULL, 'pro_1696245994_bac6dbcf47a176a425a0.jpg', NULL, 0, '2023-10-02 17:26:34', NULL, NULL, '2023-10-02 17:26:35'),
(268, 32, NULL, NULL, 'pro_1696245995_c73b17f401c80d389b7f.jpg', NULL, 0, '2023-10-02 17:26:35', NULL, NULL, '2023-10-02 17:26:35'),
(269, 32, NULL, NULL, 'pro_1696245995_ee8e0bd5cd779869c159.jpg', NULL, 0, '2023-10-02 17:26:35', NULL, NULL, '2023-10-02 17:26:35'),
(270, 33, NULL, NULL, 'pro_1696246174_c5a0db9526b33f83dffa.jpg', NULL, 0, '2023-10-02 17:29:34', NULL, NULL, '2023-10-02 17:29:34'),
(271, 33, NULL, NULL, 'pro_1696246174_9603050810bfdff27b71.jpg', NULL, 0, '2023-10-02 17:29:34', NULL, NULL, '2023-10-02 17:29:35'),
(272, 33, NULL, NULL, 'pro_1696246175_0b62bc8b88157df5588c.jpg', NULL, 0, '2023-10-02 17:29:35', NULL, NULL, '2023-10-02 17:29:35'),
(277, 39, NULL, NULL, 'pro_1703506332_2804153ea64a70379dea.jpg', NULL, 0, '2023-12-25 18:12:12', NULL, NULL, '2023-12-25 18:12:12'),
(279, 39, NULL, NULL, 'pro_1703506333_152b0e981a67455c7e64.jpg', NULL, 0, '2023-12-25 18:12:13', NULL, NULL, '2023-12-25 18:12:13'),
(316, 31, NULL, NULL, 'pro_1719404695_bf9406f1f46badf58002.jpg', NULL, 0, '2024-06-26 18:24:55', NULL, NULL, '2024-06-26 18:24:56'),
(317, 31, NULL, NULL, 'pro_1719404696_786fc738d34e832ff280.jpg', NULL, 0, '2024-06-26 18:24:56', NULL, NULL, '2024-06-26 18:24:56'),
(318, 31, NULL, NULL, 'pro_1719404696_5a3c272619c449c6791a.jpg', NULL, 0, '2024-06-26 18:24:56', NULL, NULL, '2024-06-26 18:24:56'),
(319, 31, NULL, NULL, 'pro_1719404696_e90e1ba2d9690142bf30.jpg', NULL, 0, '2024-06-26 18:24:56', NULL, NULL, '2024-06-26 18:24:57'),
(320, 31, NULL, NULL, 'pro_1719404697_c1fc01c9e0e557ae4af6.jpg', NULL, 0, '2024-06-26 18:24:57', NULL, NULL, '2024-06-26 18:24:57'),
(321, 31, NULL, NULL, 'pro_1719404697_4f7444768bd4148fb32b.jpg', NULL, 0, '2024-06-26 18:24:57', NULL, NULL, '2024-06-26 18:24:58'),
(322, 31, NULL, NULL, 'pro_1719404698_7b047739c85fb3b1da37.jpg', NULL, 0, '2024-06-26 18:24:58', NULL, NULL, '2024-06-26 18:24:58'),
(323, 31, NULL, NULL, 'pro_1719404698_d0ad6ad4686089ec5125.jpg', NULL, 0, '2024-06-26 18:24:58', NULL, NULL, '2024-06-26 18:24:59'),
(324, 31, NULL, NULL, 'pro_1719404699_3e42a9cdf27cd5dc48af.jpg', NULL, 0, '2024-06-26 18:24:59', NULL, NULL, '2024-06-26 18:24:59'),
(352, 72, NULL, NULL, 'pro_1732108064_eede5033f03ec90910c2.jpg', NULL, 0, '2024-11-20 19:07:44', NULL, NULL, '2024-11-20 19:07:46'),
(353, 72, NULL, NULL, 'pro_1732108066_d76bed497d506877f7f7.jpg', NULL, 0, '2024-11-20 19:07:46', NULL, NULL, '2024-11-20 19:07:48'),
(354, 72, NULL, NULL, 'pro_1732108068_86fb8714dd373fddd9e9.jpg', NULL, 0, '2024-11-20 19:07:48', NULL, NULL, '2024-11-20 19:07:50'),
(355, 72, NULL, NULL, 'pro_1732108070_4fa4da714cceb27b83ae.jpg', NULL, 0, '2024-11-20 19:07:50', NULL, NULL, '2024-11-20 19:07:52'),
(356, 72, NULL, NULL, 'pro_1732108072_31ba665fbf5a147a272b.jpg', NULL, 0, '2024-11-20 19:07:52', NULL, NULL, '2024-11-20 19:07:54'),
(357, 72, NULL, NULL, 'pro_1732108074_904202c9927fec993ee4.jpg', NULL, 0, '2024-11-20 19:07:54', NULL, NULL, '2024-11-20 19:07:56'),
(358, 72, NULL, NULL, 'pro_1732108076_6537f181a6c05dcaa934.jpg', NULL, 0, '2024-11-20 19:07:56', NULL, NULL, '2024-11-20 19:07:58'),
(359, 72, NULL, NULL, 'pro_1732108078_bde23958bdeb507f7ac0.jpg', NULL, 0, '2024-11-20 19:07:58', NULL, NULL, '2024-11-20 19:08:00'),
(390, 84, NULL, NULL, 'pro_1753879560_61917f8c17cce6877f85.jpg', NULL, 0, '2025-07-30 18:46:00', NULL, NULL, '2025-07-30 18:46:00'),
(391, 84, NULL, NULL, 'pro_1753879561_6fde948d91dbec33259d.jpg', NULL, 0, '2025-07-30 18:46:01', NULL, NULL, '2025-07-30 18:46:01'),
(392, 84, NULL, NULL, 'pro_1753879561_d1d6d79723946dfba51c.jpg', NULL, 0, '2025-07-30 18:46:01', NULL, NULL, '2025-07-30 18:46:01'),
(393, 84, NULL, NULL, 'pro_1753879561_6600ef47dc29ef391ea7.jpg', NULL, 0, '2025-07-30 18:46:01', NULL, NULL, '2025-07-30 18:46:01'),
(394, 84, NULL, NULL, 'pro_1753879561_4c55837949d53bcf6d39.jpg', NULL, 0, '2025-07-30 18:46:01', NULL, NULL, '2025-07-30 18:46:02'),
(476, 85, NULL, 'uploads/manager/1773310485_0dd0bcde2bdbc9c837d2.jpg', 'uploads/products/85/476/wm_600_pro_1279569374.jpg', 'New watermark test', 0, '2026-03-12 16:40:19', NULL, NULL, '2026-03-12 16:40:19'),
(477, 85, NULL, 'uploads/manager/1773310485_1675f3beab19ffb44300.jpg', 'uploads/products/85/477/wm_600_pro_334533193.jpg', 'New watermark test', 0, '2026-03-12 16:40:19', NULL, NULL, '2026-03-12 16:40:19'),
(478, 85, NULL, 'uploads/manager/1773310485_1c83f5b10c9bddab7990.jpg', 'uploads/products/85/478/wm_600_pro_1195602836.jpg', 'New watermark test', 0, '2026-03-12 16:40:19', NULL, NULL, '2026-03-12 16:40:19'),
(479, 85, NULL, 'uploads/manager/1773310485_1fd2f037837e42f737a5.jpg', 'uploads/products/85/479/wm_600_pro_808401237.jpg', 'New watermark test', 0, '2026-03-12 16:40:19', NULL, NULL, '2026-03-12 16:40:20'),
(480, 85, NULL, 'uploads/manager/1773310485_3ebcf063f5fd5d269bd0.jpg', 'uploads/products/85/480/wm_600_pro_1654315077.jpg', 'New watermark test', 0, '2026-03-12 16:40:20', NULL, NULL, '2026-03-12 16:40:20'),
(481, 85, NULL, 'uploads/manager/1773310485_3fccee0ed4b78f1e70c1.jpg', 'uploads/products/85/481/wm_600_pro_132871667.jpg', 'New watermark test', 0, '2026-03-12 16:40:20', NULL, NULL, '2026-03-12 16:40:20'),
(482, 85, NULL, 'uploads/manager/1773310485_6d512d487335f01d0a61.jpg', 'uploads/products/85/482/wm_600_pro_1792825125.jpg', 'New watermark test', 0, '2026-03-12 16:40:20', NULL, NULL, '2026-03-12 16:40:20'),
(484, 86, NULL, 'uploads/manager/1773483962_4b5e7a77ffe495678383.jpg', 'uploads/products/86/484/wm_600_pro_632653713.jpg', 'Lv Bag', 0, '2026-03-14 16:26:48', NULL, NULL, '2026-03-14 16:26:49'),
(485, 86, NULL, 'uploads/manager/1773483962_4f895f7fdb3db2b2cb80.jpg', 'uploads/products/86/485/wm_600_pro_806530310.jpg', 'Lv Bag', 0, '2026-03-14 16:26:49', NULL, NULL, '2026-03-14 16:26:49'),
(486, 86, NULL, 'uploads/manager/1773483962_6d179f76faac766c9171.jpg', 'uploads/products/86/486/wm_600_pro_814474382.jpg', 'Lv Bag', 0, '2026-03-14 16:26:49', NULL, NULL, '2026-03-14 16:26:49'),
(487, 86, NULL, 'uploads/manager/1773483962_d151a71fd36fbd444244.jpg', 'uploads/products/86/487/wm_600_pro_921407805.jpg', 'Lv Bag', 0, '2026-03-14 16:26:49', NULL, NULL, '2026-03-14 16:26:49'),
(488, 86, NULL, 'uploads/manager/1773483962_d71c9710a29aa4443924.jpg', 'uploads/products/86/488/wm_600_pro_452036147.jpg', 'Lv Bag', 0, '2026-03-14 16:26:49', NULL, NULL, '2026-03-14 16:26:50'),
(489, 86, NULL, 'uploads/manager/1773483962_db9255451a4d73cc358c.jpg', 'uploads/products/86/489/wm_600_pro_608504144.jpg', 'Lv Bag', 0, '2026-03-14 16:26:50', NULL, NULL, '2026-03-14 16:26:50'),
(490, 86, NULL, 'uploads/manager/1773483962_e1e4bdbd0461080286f2.jpg', 'uploads/products/86/490/wm_600_pro_684212418.jpg', 'Lv Bag', 0, '2026-03-14 16:26:50', NULL, NULL, '2026-03-14 16:26:50'),
(491, 86, NULL, 'uploads/manager/1773483962_f44ba392ce6f90543ed9.jpg', 'uploads/products/86/491/wm_600_pro_1919183909.jpg', 'Lv Bag', 0, '2026-03-14 16:26:50', NULL, NULL, '2026-03-14 16:26:50'),
(492, 86, NULL, 'uploads/manager/1773483963_237be6d4fddff6d99822.jpg', 'uploads/products/86/492/wm_600_pro_477108970.jpg', 'Lv Bag', 0, '2026-03-14 16:26:50', NULL, NULL, '2026-03-14 16:26:51'),
(493, 4, NULL, 'uploads/manager/1773555992_6deb0ccd9f2034b53788.jpg', 'uploads/products/4/493/wm_600_pro_746944765.jpg', 'Fendi Shoes A001', 0, '2026-03-15 12:27:30', NULL, NULL, '2026-03-15 12:27:30'),
(494, 4, NULL, 'uploads/manager/1773555993_589c59764c4d2a9567ab.jpg', 'uploads/products/4/494/wm_600_pro_921827636.jpg', 'Fendi Shoes A001', 0, '2026-03-15 12:27:30', NULL, NULL, '2026-03-15 12:27:31'),
(495, 4, NULL, 'uploads/manager/1773555993_d3ef397d81da6caa328a.jpg', 'uploads/products/4/495/wm_600_pro_1990319891.jpg', 'Fendi Shoes A001', 0, '2026-03-15 12:27:31', NULL, NULL, '2026-03-15 12:27:32'),
(496, 4, NULL, 'uploads/manager/1773555993_d9c00fc2262ede35f55e.jpg', 'uploads/products/4/496/wm_600_pro_348668588.jpg', 'Fendi Shoes A001', 0, '2026-03-15 12:27:32', NULL, NULL, '2026-03-15 12:27:33'),
(497, 4, NULL, 'uploads/manager/1773555993_dd8643f7f5cd631f7d8f.jpg', 'uploads/products/4/497/wm_600_pro_1078459303.jpg', 'Fendi Shoes A001', 0, '2026-03-15 12:27:33', NULL, NULL, '2026-03-15 12:27:33'),
(498, 4, NULL, 'uploads/manager/1773555994_06f65ed0b9e545e30716.jpg', 'uploads/products/4/498/wm_600_pro_2077311827.jpg', 'Fendi Shoes A001', 0, '2026-03-15 12:27:33', NULL, NULL, '2026-03-15 12:27:34'),
(499, 4, NULL, 'uploads/manager/1773555994_d4651600fcdeafdc2500.jpg', 'uploads/products/4/499/wm_600_pro_883465669.jpg', 'Fendi Shoes A001', 0, '2026-03-15 12:27:34', NULL, NULL, '2026-03-15 12:27:35'),
(500, 81, NULL, 'uploads/manager/01/1773899329_0653828cc6aba0f6560f.jpg', 'uploads/products/81/500/wm_600_pro_1361033533.jpg', 'Test', 0, '2026-03-19 12:38:21', NULL, NULL, '2026-03-19 12:38:21'),
(501, 81, NULL, 'uploads/manager/01/1773899329_0acb6570da8b81f7bd0c.jpg', 'uploads/products/81/501/wm_600_pro_587135370.jpg', 'Test', 0, '2026-03-19 12:38:21', NULL, NULL, '2026-03-19 12:38:21'),
(502, 81, NULL, 'uploads/manager/01/1773899329_1ba6b7c3e1f08be070f9.jpg', 'uploads/products/81/502/wm_600_pro_383874326.jpg', 'Test', 0, '2026-03-19 12:38:21', NULL, NULL, '2026-03-19 12:38:21'),
(503, 81, NULL, 'uploads/manager/01/1773899329_5ee695d32daacc17eadd.jpg', 'uploads/products/81/503/wm_600_pro_1042725114.jpg', 'Test', 0, '2026-03-19 12:38:21', NULL, NULL, '2026-03-19 12:38:22'),
(504, 81, NULL, 'uploads/manager/01/1773899329_73acca019199fd75a51c.jpg', 'uploads/products/81/504/wm_600_pro_580249997.jpg', 'Test', 0, '2026-03-19 12:38:22', NULL, NULL, '2026-03-19 12:38:22'),
(505, 81, NULL, 'uploads/manager/01/1773899329_81eecebd537f3266e008.jpg', 'uploads/products/81/505/wm_600_pro_249421400.jpg', 'Test', 0, '2026-03-19 12:38:22', NULL, NULL, '2026-03-19 12:38:22'),
(506, 81, NULL, 'uploads/manager/01/1773899329_8550e31ea463ec196e30.jpg', 'uploads/products/81/506/wm_600_pro_998978149.jpg', 'Test', 0, '2026-03-19 12:38:22', NULL, NULL, '2026-03-19 12:38:22'),
(507, 81, NULL, 'uploads/manager/01/1773899329_c32fcd68cb39ff4a9457.jpg', 'uploads/products/81/507/wm_600_pro_1657439232.jpg', 'Test', 0, '2026-03-19 12:38:22', NULL, NULL, '2026-03-19 12:38:23'),
(508, 81, NULL, 'uploads/manager/01/1773899329_e546f1449a0d2aca754d.jpg', 'uploads/products/81/508/wm_600_pro_566505430.jpg', 'Test', 0, '2026-03-19 12:38:23', NULL, NULL, '2026-03-19 12:38:23'),
(509, 54, NULL, 'uploads/manager/1775303960_05ff31aa0a2990f2246e.jpg', 'uploads/products/54/509/wm_600_pro_780118502.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:00:25', NULL, NULL, '2026-04-04 18:00:26'),
(510, 54, NULL, 'uploads/manager/1775303961_64e5aac8550052a26c37.jpg', 'uploads/products/54/510/wm_600_pro_1113751775.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:00:26', NULL, NULL, '2026-04-04 18:00:27'),
(511, 54, NULL, 'uploads/manager/1775303961_6799566a2af51ec9df3b.jpg', 'uploads/products/54/511/wm_600_pro_1808345059.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:00:27', NULL, NULL, '2026-04-04 18:00:28'),
(512, 54, NULL, 'uploads/manager/1775303961_7b5123be19885aaa75ab.jpg', 'uploads/products/54/512/wm_600_pro_1409189726.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:00:28', NULL, NULL, '2026-04-04 18:00:29'),
(513, 54, NULL, 'uploads/manager/1775303961_8464f9e567f89c5ca1f3.jpg', 'uploads/products/54/513/wm_600_pro_653228367.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:00:29', NULL, NULL, '2026-04-04 18:00:30'),
(514, 54, NULL, 'uploads/manager/1775303962_7f31c80eb6ebc5ba8c06.jpg', 'uploads/products/54/514/wm_600_pro_519750812.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:00:30', NULL, NULL, '2026-04-04 18:00:31'),
(515, 54, NULL, 'uploads/manager/1775303962_9fab5e82c6e761d2f7df.jpg', 'uploads/products/54/515/wm_600_pro_1130549371.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:00:31', NULL, NULL, '2026-04-04 18:00:32'),
(516, 54, NULL, 'uploads/manager/1775303962_dcaeb06079647425edfd.jpg', 'uploads/products/54/516/wm_600_pro_324600730.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:00:32', NULL, NULL, '2026-04-04 18:00:33'),
(517, 15, NULL, 'uploads/manager/1775304369_3b20b957ef76a45c0757.jpg', 'uploads/products/15/517/wm_600_pro_995981416.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:14:24', NULL, NULL, '2026-04-04 18:14:25'),
(518, 15, NULL, 'uploads/manager/1775304369_a9d62aeed4373705e9d0.jpg', 'uploads/products/15/518/wm_600_pro_2142583570.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:14:25', NULL, NULL, '2026-04-04 18:14:25'),
(519, 15, NULL, 'uploads/manager/1775304370_1c2a03d0292c64a793ec.jpg', 'uploads/products/15/519/wm_600_pro_1709264049.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:14:25', NULL, NULL, '2026-04-04 18:14:26'),
(520, 15, NULL, 'uploads/manager/1775304370_82346b9f84cde9819d78.jpg', 'uploads/products/15/520/wm_600_pro_189235195.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:14:26', NULL, NULL, '2026-04-04 18:14:27'),
(521, 15, NULL, 'uploads/manager/1775304370_b74819183564a7170a2a.jpg', 'uploads/products/15/521/wm_600_pro_1701466205.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:14:27', NULL, NULL, '2026-04-04 18:14:28'),
(522, 15, NULL, 'uploads/manager/1775304371_81690f038cb7ca2781ee.jpg', 'uploads/products/15/522/wm_600_pro_1876338931.jpg', 'Fendi Shoes A005', 0, '2026-04-04 18:14:28', NULL, NULL, '2026-04-04 18:14:29'),
(531, 87, NULL, 'uploads/manager/1773310485_1675f3beab19ffb44300.jpg', 'uploads/products/87/531/wm_600_pro_1555846684.jpg', 'Cartier Necklace', 0, '2026-04-09 15:06:02', NULL, NULL, '2026-04-09 15:06:02'),
(532, 87, NULL, 'uploads/manager/1773310485_1c83f5b10c9bddab7990.jpg', 'uploads/products/87/532/wm_600_pro_504659044.jpg', 'Cartier Necklace', 0, '2026-04-09 15:06:02', NULL, NULL, '2026-04-09 15:06:02'),
(533, 87, NULL, 'uploads/manager/1773310485_1fd2f037837e42f737a5.jpg', 'uploads/products/87/533/wm_600_pro_119136607.jpg', 'Cartier Necklace', 0, '2026-04-09 15:06:02', NULL, NULL, '2026-04-09 15:06:03'),
(534, 87, NULL, 'uploads/manager/1773310485_3ebcf063f5fd5d269bd0.jpg', 'uploads/products/87/534/wm_600_pro_1636491415.jpg', 'Cartier Necklace', 0, '2026-04-09 15:06:03', NULL, NULL, '2026-04-09 15:06:03'),
(535, 53, NULL, 'uploads/manager/1775725599_76792bde715a87ca9c75.jpg', 'uploads/products/53/535/wm_600_pro_491684567.jpg', 'Fendi Shoes A006', 0, '2026-04-09 15:07:27', NULL, NULL, '2026-04-09 15:07:27'),
(536, 53, NULL, 'uploads/manager/1775725599_8c8ec4de34ff1c3e404e.jpg', 'uploads/products/53/536/wm_600_pro_387891135.jpg', 'Fendi Shoes A006', 0, '2026-04-09 15:07:27', NULL, NULL, '2026-04-09 15:07:27'),
(537, 53, NULL, 'uploads/manager/1775725599_9979f539746b6c6b30f3.jpg', 'uploads/products/53/537/wm_600_pro_1592546338.jpg', 'Fendi Shoes A006', 0, '2026-04-09 15:07:27', NULL, NULL, '2026-04-09 15:07:28'),
(538, 53, NULL, 'uploads/manager/1775725599_aca24195b3f0a7bfa795.jpg', 'uploads/products/53/538/wm_600_pro_258171756.jpg', 'Fendi Shoes A006', 0, '2026-04-09 15:07:28', NULL, NULL, '2026-04-09 15:07:28'),
(539, 53, NULL, 'uploads/manager/1775725599_b6e6aab8fd3a18918548.jpg', 'uploads/products/53/539/wm_600_pro_1676498967.jpg', 'Fendi Shoes A006', 0, '2026-04-09 15:07:28', NULL, NULL, '2026-04-09 15:07:28'),
(540, 53, NULL, 'uploads/manager/1775725599_c09a29f4a0f1b38fe9cc.jpg', 'uploads/products/53/540/wm_600_pro_442929127.jpg', 'Fendi Shoes A006', 0, '2026-04-09 15:07:28', NULL, NULL, '2026-04-09 15:07:28'),
(541, 53, NULL, 'uploads/manager/1775725599_f1def00d09da4a41f984.jpg', 'uploads/products/53/541/wm_600_pro_999288560.jpg', 'Fendi Shoes A006', 0, '2026-04-09 15:07:28', NULL, NULL, '2026-04-09 15:07:29'),
(542, 30, NULL, 'uploads/manager/1775884503_05c7a9437163d0f1cfe8.jpg', 'uploads/products/30/542/wm_600_pro_60270036.jpg', 'sunglasses A008', 0, '2026-04-11 11:15:37', NULL, NULL, '2026-04-11 11:15:38'),
(543, 30, NULL, 'uploads/manager/1775884503_5389f312737a83297fa3.jpg', 'uploads/products/30/543/wm_600_pro_1152368084.jpg', 'sunglasses A008', 0, '2026-04-11 11:15:38', NULL, NULL, '2026-04-11 11:15:38'),
(544, 30, NULL, 'uploads/manager/1775884503_7b5eb8af64e086ea111b.jpg', 'uploads/products/30/544/wm_600_pro_1811063558.jpg', 'sunglasses A008', 0, '2026-04-11 11:15:38', NULL, NULL, '2026-04-11 11:15:39'),
(546, 30, NULL, 'uploads/manager/1775884504_d3ba4af0f385e8fd61c4.jpg', 'uploads/products/30/546/wm_600_pro_68440907.jpg', 'sunglasses A008', 0, '2026-04-11 11:15:39', NULL, NULL, '2026-04-11 11:15:40'),
(547, 30, NULL, 'uploads/manager/1775884505_294496648f3e35dc5dd1.jpg', 'uploads/products/30/547/wm_600_pro_855876207.jpg', 'sunglasses A008', 0, '2026-04-11 11:15:40', NULL, NULL, '2026-04-11 11:15:40'),
(550, 25, NULL, 'uploads/manager/02/1775886531_3c084fb81570ae1f51b0.jpg', 'uploads/products/25/550/wm_600_pro_541339075.jpg', 'sunglasses A001', 0, '2026-04-11 11:49:10', NULL, NULL, '2026-04-11 11:49:10'),
(551, 25, NULL, 'uploads/manager/02/1775886531_42cbd6addb6b98ca3f2a.jpg', 'uploads/products/25/551/wm_600_pro_1550253247.jpg', 'sunglasses A001', 0, '2026-04-11 11:49:10', NULL, NULL, '2026-04-11 11:49:10'),
(552, 25, NULL, 'uploads/manager/02/1775886531_771564cb52847a328db6.jpg', 'uploads/products/25/552/wm_600_pro_2106895169.jpg', 'sunglasses A001', 0, '2026-04-11 11:49:10', NULL, NULL, '2026-04-11 11:49:11'),
(553, 25, NULL, 'uploads/manager/02/1775886531_8acd3d96c4b9e7cb5de0.jpg', 'uploads/products/25/553/wm_600_pro_1051949019.jpg', 'sunglasses A001', 0, '2026-04-11 11:49:11', NULL, NULL, '2026-04-11 11:49:11'),
(554, 25, NULL, 'uploads/manager/02/1775886531_8f0a3bfb0ab314b580ce.jpg', 'uploads/products/25/554/wm_600_pro_9406285.jpg', 'sunglasses A001', 0, '2026-04-11 11:49:11', NULL, NULL, '2026-04-11 11:49:11'),
(555, 25, NULL, 'uploads/manager/02/1775886531_a1ed1f96632e72181b92.jpg', 'uploads/products/25/555/wm_600_pro_1886039393.jpg', 'sunglasses A001', 0, '2026-04-11 11:49:11', NULL, NULL, '2026-04-11 11:49:11'),
(556, 25, NULL, 'uploads/manager/02/1775886531_f34e87f28d7ead8c2228.jpg', 'uploads/products/25/556/wm_600_pro_189622877.jpg', 'sunglasses A001', 0, '2026-04-11 11:49:11', NULL, NULL, '2026-04-11 11:49:12'),
(557, 70, NULL, 'uploads/manager/1777809001_0c2d276fdd21eae4d6e6.jpg', 'uploads/products/70/557/wm_600_pro_440427268.jpg', 'GUCCI BRACELETS A004', 0, '2026-05-03 17:51:09', NULL, NULL, '2026-05-03 17:51:09'),
(558, 70, NULL, 'uploads/manager/1777809001_10c9626663dc48640afb.jpg', 'uploads/products/70/558/wm_600_pro_1559843178.jpg', 'GUCCI BRACELETS A004', 0, '2026-05-03 17:51:09', NULL, NULL, '2026-05-03 17:51:09'),
(559, 70, NULL, 'uploads/manager/1777809001_56890e1106aa9e33c3f8.jpg', 'uploads/products/70/559/wm_600_pro_1830108677.jpg', 'GUCCI BRACELETS A004', 0, '2026-05-03 17:51:09', NULL, NULL, '2026-05-03 17:51:09'),
(560, 70, NULL, 'uploads/manager/1777809001_57713d379bd964d8f8d3.jpg', 'uploads/products/70/560/wm_600_pro_1478569457.jpg', 'GUCCI BRACELETS A004', 0, '2026-05-03 17:51:09', NULL, NULL, '2026-05-03 17:51:10'),
(561, 70, NULL, 'uploads/manager/1777809001_7a3969720d414298d8c4.jpg', 'uploads/products/70/561/wm_600_pro_694651439.jpg', 'GUCCI BRACELETS A004', 0, '2026-05-03 17:51:10', NULL, NULL, '2026-05-03 17:51:10'),
(562, 70, NULL, 'uploads/manager/1777809001_ac12d8c35bec5d67de8c.jpg', 'uploads/products/70/562/wm_600_pro_461397370.jpg', 'GUCCI BRACELETS A004', 0, '2026-05-03 17:51:10', NULL, NULL, '2026-05-03 17:51:10'),
(563, 70, NULL, 'uploads/manager/1777809001_f98b0944f93f00de79e1.jpg', 'uploads/products/70/563/wm_600_pro_1128895056.jpg', 'GUCCI BRACELETS A004', 0, '2026-05-03 17:51:10', NULL, NULL, '2026-05-03 17:51:10'),
(564, 70, NULL, 'uploads/manager/1777809001_fc3141997db8c9a05929.jpg', 'uploads/products/70/564/wm_600_pro_1710379975.jpg', 'GUCCI BRACELETS A004', 0, '2026-05-03 17:51:10', NULL, NULL, '2026-05-03 17:51:11'),
(565, 58, NULL, 'uploads/manager/02/1777809212_4d593a3077365b673e00.jpg', 'uploads/products/58/565/wm_600_pro_462294819.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:45', NULL, NULL, '2026-05-03 18:00:45'),
(566, 58, NULL, 'uploads/manager/02/1777809212_5ad89ef4c95c2b180854.jpg', 'uploads/products/58/566/wm_600_pro_484678601.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:45', NULL, NULL, '2026-05-03 18:00:45'),
(567, 58, NULL, 'uploads/manager/02/1777809212_902070361ddcfda3ffc5.jpg', 'uploads/products/58/567/wm_600_pro_1904624969.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:45', NULL, NULL, '2026-05-03 18:00:45'),
(568, 58, NULL, 'uploads/manager/02/1777809212_cf8e69ac5694e62cd62c.jpg', 'uploads/products/58/568/wm_600_pro_1439852245.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:45', NULL, NULL, '2026-05-03 18:00:46'),
(569, 58, NULL, 'uploads/manager/02/1777809212_d58ff0087d530696016b.jpg', 'uploads/products/58/569/wm_600_pro_2097916613.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:46', NULL, NULL, '2026-05-03 18:00:46'),
(570, 58, NULL, 'uploads/manager/02/1777809212_d895712f4db2bf2c37ea.jpg', 'uploads/products/58/570/wm_600_pro_1947115492.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:46', NULL, NULL, '2026-05-03 18:00:46'),
(571, 58, NULL, 'uploads/manager/02/1777809212_dfe11691a74a0858fe27.jpg', 'uploads/products/58/571/wm_600_pro_963457273.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:46', NULL, NULL, '2026-05-03 18:00:47'),
(572, 58, NULL, 'uploads/manager/02/1777809212_dff3dee9df677d52e8e2.jpg', 'uploads/products/58/572/wm_600_pro_1386029938.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:47', NULL, NULL, '2026-05-03 18:00:47'),
(573, 58, NULL, 'uploads/manager/02/1777809212_f3cf825582cfcb302b6c.jpg', 'uploads/products/58/573/wm_600_pro_1994044334.jpg', 'Gucci GG Supreme canvas pouch in black and gray', 0, '2026-05-03 18:00:47', NULL, NULL, '2026-05-03 18:00:47'),
(574, 57, NULL, 'uploads/manager/02/1777809912_0c48d0d6f47a58d04fb6.jpg', 'uploads/products/57/574/wm_600_pro_1789818331.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:19', NULL, NULL, '2026-05-03 18:06:20'),
(575, 57, NULL, 'uploads/manager/02/1777809912_39890d378bc26ffdaff2.jpg', 'uploads/products/57/575/wm_600_pro_125817740.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:20', NULL, NULL, '2026-05-03 18:06:20'),
(576, 57, NULL, 'uploads/manager/02/1777809912_5c9450dceeb2ffba134c.jpg', 'uploads/products/57/576/wm_600_pro_505436967.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:20', NULL, NULL, '2026-05-03 18:06:20'),
(577, 57, NULL, 'uploads/manager/02/1777809912_67be9beb04735009ad08.jpg', 'uploads/products/57/577/wm_600_pro_544626022.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:20', NULL, NULL, '2026-05-03 18:06:20'),
(578, 57, NULL, 'uploads/manager/02/1777809912_6cbc0f0e90e3b2627d36.jpg', 'uploads/products/57/578/wm_600_pro_1423330926.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:20', NULL, NULL, '2026-05-03 18:06:21'),
(579, 57, NULL, 'uploads/manager/02/1777809912_845093f1dcc7ebb9c46a.jpg', 'uploads/products/57/579/wm_600_pro_1868688274.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:21', NULL, NULL, '2026-05-03 18:06:21'),
(580, 57, NULL, 'uploads/manager/02/1777809912_a635dc8a0893c7ab8c7b.jpg', 'uploads/products/57/580/wm_600_pro_1459509600.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:21', NULL, NULL, '2026-05-03 18:06:21'),
(581, 57, NULL, 'uploads/manager/02/1777809912_dcbb8d6ab5603f17f863.jpg', 'uploads/products/57/581/wm_600_pro_736711316.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:21', NULL, NULL, '2026-05-03 18:06:21'),
(582, 57, NULL, 'uploads/manager/02/1777809912_f96decaa0f8b6f565f81.jpg', 'uploads/products/57/582/wm_600_pro_1362238249.jpg', 'GUCCI BRACELETS A002', 0, '2026-05-03 18:06:21', NULL, NULL, '2026-05-03 18:06:22'),
(583, 56, NULL, 'uploads/manager/02/1777810117_32c010139aa829e5117b.jpg', 'uploads/products/56/583/wm_600_pro_155895104.jpg', 'Hermes Jypsiere Mini Brown', 0, '2026-05-03 18:09:34', NULL, NULL, '2026-05-03 18:09:35'),
(584, 56, NULL, 'uploads/manager/02/1777810117_36fc571c66f3a36c9b40.jpg', 'uploads/products/56/584/wm_600_pro_1794422200.jpg', 'Hermes Jypsiere Mini Brown', 0, '2026-05-03 18:09:35', NULL, NULL, '2026-05-03 18:09:35'),
(585, 56, NULL, 'uploads/manager/02/1777810117_4a08fb022a10541feccb.jpg', 'uploads/products/56/585/wm_600_pro_501373418.jpg', 'Hermes Jypsiere Mini Brown', 0, '2026-05-03 18:09:35', NULL, NULL, '2026-05-03 18:09:35'),
(586, 56, NULL, 'uploads/manager/02/1777810117_64791e5637bd1198005c.jpg', 'uploads/products/56/586/wm_600_pro_1694759922.jpg', 'Hermes Jypsiere Mini Brown', 0, '2026-05-03 18:09:35', NULL, NULL, '2026-05-03 18:09:35'),
(587, 56, NULL, 'uploads/manager/02/1777810117_819eb90f84cd59bdbf6c.jpg', 'uploads/products/56/587/wm_600_pro_1949514948.jpg', 'Hermes Jypsiere Mini Brown', 0, '2026-05-03 18:09:35', NULL, NULL, '2026-05-03 18:09:36');
INSERT INTO `cc_product_image` (`product_image_id`, `product_id`, `Product_option_id`, `main_image`, `image`, `alt_name`, `sort_order`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(588, 56, NULL, 'uploads/manager/02/1777810117_894206b5b090320b2edd.jpg', 'uploads/products/56/588/wm_600_pro_1465364701.jpg', 'Hermes Jypsiere Mini Brown', 0, '2026-05-03 18:09:36', NULL, NULL, '2026-05-03 18:09:36'),
(589, 42, NULL, 'uploads/manager/02/1777810635_18606f60d9e4ca99dc22.jpg', 'uploads/products/42/589/wm_600_pro_427416905.jpg', 'CHANEL 181123-113 Xcm', 0, '2026-05-03 18:19:08', NULL, NULL, '2026-05-03 18:19:08'),
(590, 42, NULL, 'uploads/manager/02/1777810635_2d5f528f72a4da83b014.jpg', 'uploads/products/42/590/wm_600_pro_1959558462.jpg', 'CHANEL 181123-113 Xcm', 0, '2026-05-03 18:19:08', NULL, NULL, '2026-05-03 18:19:09'),
(591, 42, NULL, 'uploads/manager/02/1777810635_3507e6922c09b8327bbc.jpg', 'uploads/products/42/591/wm_600_pro_793662523.jpg', 'CHANEL 181123-113 Xcm', 0, '2026-05-03 18:19:09', NULL, NULL, '2026-05-03 18:19:09'),
(592, 42, NULL, 'uploads/manager/02/1777810635_6c96ac5fedf8204945d7.jpg', 'uploads/products/42/592/wm_600_pro_1538515294.jpg', 'CHANEL 181123-113 Xcm', 0, '2026-05-03 18:19:09', NULL, NULL, '2026-05-03 18:19:09'),
(593, 42, NULL, 'uploads/manager/02/1777810635_7276285ddbda64dc46a7.jpg', 'uploads/products/42/593/wm_600_pro_1137970332.jpg', 'CHANEL 181123-113 Xcm', 0, '2026-05-03 18:19:09', NULL, NULL, '2026-05-03 18:19:09'),
(594, 42, NULL, 'uploads/manager/02/1777810635_7a0a056ae6d5b4f5838c.jpg', 'uploads/products/42/594/wm_600_pro_421976039.jpg', 'CHANEL 181123-113 Xcm', 0, '2026-05-03 18:19:09', NULL, NULL, '2026-05-03 18:19:10'),
(595, 42, NULL, 'uploads/manager/02/1777810635_e9160e7c06e834886c15.jpg', 'uploads/products/42/595/wm_600_pro_187158169.jpg', 'CHANEL 181123-113 Xcm', 0, '2026-05-03 18:19:10', NULL, NULL, '2026-05-03 18:19:10'),
(596, 42, NULL, 'uploads/manager/02/1777810635_f1d354af55c4d3368547.jpg', 'uploads/products/42/596/wm_600_pro_1030991998.jpg', 'CHANEL 181123-113 Xcm', 0, '2026-05-03 18:19:10', NULL, NULL, '2026-05-03 18:19:10'),
(597, 41, NULL, 'uploads/manager/01/1777811149_289891b2d0f6532bcae1.jpg', 'uploads/products/41/597/wm_600_pro_1005453628.jpg', 'Chanel Small Shopping Bag', 0, '2026-05-03 18:26:27', NULL, NULL, '2026-05-03 18:26:27'),
(598, 41, NULL, 'uploads/manager/01/1777811149_29616235fb14c699523a.jpg', 'uploads/products/41/598/wm_600_pro_1746955284.jpg', 'Chanel Small Shopping Bag', 0, '2026-05-03 18:26:27', NULL, NULL, '2026-05-03 18:26:28'),
(599, 41, NULL, 'uploads/manager/01/1777811149_5ca642cffa13fda0ce92.jpg', 'uploads/products/41/599/wm_600_pro_1095561421.jpg', 'Chanel Small Shopping Bag', 0, '2026-05-03 18:26:28', NULL, NULL, '2026-05-03 18:26:28'),
(600, 41, NULL, 'uploads/manager/01/1777811149_9af2c4b38e7bdb6f5513.jpg', 'uploads/products/41/600/wm_600_pro_1375855443.jpg', 'Chanel Small Shopping Bag', 0, '2026-05-03 18:26:28', NULL, NULL, '2026-05-03 18:26:28'),
(601, 41, NULL, 'uploads/manager/01/1777811149_bf5e46503de49ac94d58.jpg', 'uploads/products/41/601/wm_600_pro_1155055148.jpg', 'Chanel Small Shopping Bag', 0, '2026-05-03 18:26:28', NULL, NULL, '2026-05-03 18:26:28'),
(602, 41, NULL, 'uploads/manager/01/1777811149_c07add17a0713aaf4e35.jpg', 'uploads/products/41/602/wm_600_pro_1608450766.jpg', 'Chanel Small Shopping Bag', 0, '2026-05-03 18:26:28', NULL, NULL, '2026-05-03 18:26:29'),
(603, 41, NULL, 'uploads/manager/01/1777811149_fd7cd9083fef3509f339.jpg', 'uploads/products/41/603/wm_600_pro_1126586688.jpg', 'Chanel Small Shopping Bag', 0, '2026-05-03 18:26:29', NULL, NULL, '2026-05-03 18:26:29'),
(604, 40, NULL, 'uploads/manager/01/1777811293_09c7e570cd08bd93af2e.jpg', 'uploads/products/40/604/wm_600_pro_1743925345.jpg', 'Chanel Preppy Coco Small Bowling Bag', 0, '2026-05-03 18:28:52', NULL, NULL, '2026-05-03 18:28:52'),
(605, 40, NULL, 'uploads/manager/01/1777811293_4a1448b9286087469c63.jpg', 'uploads/products/40/605/wm_600_pro_109211490.jpg', 'Chanel Preppy Coco Small Bowling Bag', 0, '2026-05-03 18:28:52', NULL, NULL, '2026-05-03 18:28:52'),
(606, 40, NULL, 'uploads/manager/01/1777811293_94d65541c727f705db79.jpg', 'uploads/products/40/606/wm_600_pro_1855010875.jpg', 'Chanel Preppy Coco Small Bowling Bag', 0, '2026-05-03 18:28:52', NULL, NULL, '2026-05-03 18:28:53'),
(607, 40, NULL, 'uploads/manager/01/1777811293_9e24c12bef28a2854c1c.jpg', 'uploads/products/40/607/wm_600_pro_1127293853.jpg', 'Chanel Preppy Coco Small Bowling Bag', 0, '2026-05-03 18:28:53', NULL, NULL, '2026-05-03 18:28:53'),
(608, 40, NULL, 'uploads/manager/01/1777811293_aaee19e634dfc2c85092.jpg', 'uploads/products/40/608/wm_600_pro_628118377.jpg', 'Chanel Preppy Coco Small Bowling Bag', 0, '2026-05-03 18:28:53', NULL, NULL, '2026-05-03 18:28:53'),
(609, 40, NULL, 'uploads/manager/01/1777811293_af0f6901d8b710a312b0.jpg', 'uploads/products/40/609/wm_600_pro_1623919121.jpg', 'Chanel Preppy Coco Small Bowling Bag', 0, '2026-05-03 18:28:53', NULL, NULL, '2026-05-03 18:28:53'),
(610, 40, NULL, 'uploads/manager/01/1777811293_ba2626d8a75eef3c0035.jpg', 'uploads/products/40/610/wm_600_pro_672301745.jpg', 'Chanel Preppy Coco Small Bowling Bag', 0, '2026-05-03 18:28:53', NULL, NULL, '2026-05-03 18:28:54'),
(611, 40, NULL, 'uploads/manager/01/1777811293_c3a6fcf40205f783630c.jpg', 'uploads/products/40/611/wm_600_pro_367063874.jpg', 'Chanel Preppy Coco Small Bowling Bag', 0, '2026-05-03 18:28:54', NULL, NULL, '2026-05-03 18:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_option`
--

CREATE TABLE `cc_product_option` (
  `product_option_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `option_id` int NOT NULL,
  `option_value_id` int NOT NULL,
  `quantity` int NOT NULL,
  `subtract` tinyint(1) DEFAULT NULL,
  `price` decimal(15,4) DEFAULT NULL,
  `price_prefix` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int DEFAULT NULL,
  `point_prefix` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(15,8) DEFAULT NULL,
  `weight_prefix` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_option`
--

INSERT INTO `cc_product_option` (`product_option_id`, `product_id`, `option_id`, `option_value_id`, `quantity`, `subtract`, `price`, `price_prefix`, `points`, `point_prefix`, `weight`, `weight_prefix`) VALUES
(88, 1, 8, 11, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(90, 2, 8, 11, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(147, 84, 8, 11, 11, NULL, 0.0000, '', NULL, '', NULL, ''),
(148, 84, 8, 15, 11, NULL, 0.0000, '', NULL, '', NULL, ''),
(149, 84, 9, 13, 22, NULL, 0.0000, '', NULL, '', NULL, ''),
(150, 84, 9, 14, 22, NULL, 0.0000, '', NULL, '', NULL, ''),
(173, 31, 8, 11, 1, NULL, 0.0000, '', NULL, '', NULL, ''),
(174, 31, 9, 13, 1, NULL, 0.0000, '', NULL, '', NULL, ''),
(175, 31, 9, 14, 1, NULL, 0.0000, '', NULL, '', NULL, ''),
(198, 86, 8, 11, 1, NULL, 0.0000, '', NULL, '', NULL, ''),
(199, 86, 8, 15, 1, NULL, 0.0000, '', NULL, '', NULL, ''),
(200, 86, 9, 13, 1, NULL, 0.0000, '', NULL, '', NULL, ''),
(201, 86, 9, 14, 1, NULL, 0.0000, '', NULL, '', NULL, ''),
(280, 4, 8, 11, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(281, 4, 8, 15, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(282, 4, 8, 17, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(283, 4, 8, 18, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(284, 4, 8, 19, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(285, 4, 8, 20, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(286, 4, 8, 21, 5, NULL, 10.0000, '', NULL, '', NULL, ''),
(287, 4, 8, 22, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(288, 4, 8, 23, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(289, 4, 8, 24, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(290, 4, 8, 25, 5, NULL, 0.0000, '', NULL, '', NULL, ''),
(303, 87, 8, 11, 1, NULL, 0.0000, '', NULL, '', NULL, ''),
(304, 87, 8, 20, 1, NULL, 5.0000, '', NULL, '', NULL, ''),
(305, 87, 9, 13, 2, NULL, 0.0000, '', NULL, '', NULL, ''),
(306, 87, 9, 14, 2, NULL, 4.0000, '', NULL, '', NULL, ''),
(312, 70, 8, 11, 5, 1, 100.0000, '', NULL, '', NULL, ''),
(319, 56, 8, 11, 20, NULL, 0.0000, '', NULL, '', NULL, ''),
(320, 56, 8, 11, 25, NULL, 0.0000, '', NULL, '', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_related`
--

CREATE TABLE `cc_product_related` (
  `product_related_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `related_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_related`
--

INSERT INTO `cc_product_related` (`product_related_id`, `product_id`, `related_id`) VALUES
(30, 3, 1),
(31, 3, 2),
(49, 6, 4),
(50, 6, 5),
(51, 5, 4),
(59, 39, 22),
(63, 2, 1),
(67, 7, 4),
(68, 7, 5),
(69, 7, 6),
(188, 32, 3),
(189, 32, 4),
(190, 32, 2),
(191, 32, 16),
(192, 31, 11),
(193, 31, 12),
(194, 31, 13),
(195, 31, 14),
(208, 87, 85),
(209, 87, 42),
(216, 70, 7),
(217, 70, 8);

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_special`
--

CREATE TABLE `cc_product_special` (
  `product_special_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `special_price` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_special`
--

INSERT INTO `cc_product_special` (`product_special_id`, `product_id`, `special_price`, `start_date`, `end_date`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 1, 460.00, '2023-09-04', '2024-12-13', '2023-09-05 11:57:45', NULL, NULL, '2023-09-05 11:57:45'),
(2, 2, 450.00, '2023-09-05', '2024-11-05', '2023-09-05 12:02:57', NULL, NULL, '2023-09-05 12:02:57'),
(3, 3, 200.00, '2023-09-04', '2023-12-13', '2023-09-05 12:06:30', NULL, NULL, '2023-09-05 12:06:30'),
(4, 4, 350.00, '2023-09-05', '2023-12-29', '2023-09-05 12:11:56', NULL, NULL, '2023-09-05 12:11:56'),
(5, 5, 350.00, '2023-09-05', '2023-12-29', '2023-09-05 12:16:17', NULL, NULL, '2023-09-05 12:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `cc_product_to_category`
--

CREATE TABLE `cc_product_to_category` (
  `product_to_cat_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_product_to_category`
--

INSERT INTO `cc_product_to_category` (`product_to_cat_id`, `product_id`, `category_id`) VALUES
(104, 8, 11),
(105, 8, 12),
(118, 6, 11),
(119, 6, 14),
(120, 11, 11),
(121, 11, 12),
(126, 12, 11),
(127, 12, 12),
(128, 13, 11),
(129, 13, 12),
(132, 14, 11),
(133, 14, 12),
(155, 18, 37),
(156, 18, 39),
(176, 26, 50),
(177, 26, 55),
(178, 27, 50),
(179, 27, 55),
(180, 28, 50),
(181, 28, 55),
(182, 29, 50),
(183, 29, 55),
(196, 21, 2),
(197, 21, 29),
(204, 22, 2),
(205, 22, 29),
(208, 23, 2),
(209, 23, 29),
(230, 37, 2),
(239, 39, 1),
(240, 39, 2),
(272, 5, 10),
(273, 5, 11),
(274, 5, 13),
(275, 5, 14),
(280, 9, 11),
(281, 9, 14),
(282, 9, 34),
(312, 10, 11),
(313, 10, 34),
(328, 50, 37),
(329, 51, 37),
(330, 51, 39),
(337, 55, 11),
(338, 55, 12),
(368, 7, 11),
(369, 7, 13),
(370, 7, 15),
(371, 7, 16),
(447, 1, 2),
(474, 24, 2),
(475, 24, 29),
(499, 72, 44),
(503, 33, 44),
(620, 32, 44),
(622, 17, 1),
(623, 17, 24),
(625, 84, 2),
(660, 31, 44),
(675, 86, 25),
(697, 81, 1),
(698, 81, 44),
(699, 81, 58),
(700, 54, 37),
(702, 15, 37),
(715, 4, 37),
(716, 4, 39),
(717, 4, 40),
(718, 4, 43),
(733, 53, 37),
(734, 87, 11),
(735, 87, 15),
(738, 30, 50),
(739, 30, 55),
(740, 25, 50),
(741, 25, 55),
(744, 85, 2),
(745, 85, 60),
(748, 70, 11),
(749, 70, 12),
(750, 58, 25),
(753, 57, 11),
(754, 57, 12),
(758, 42, 2),
(761, 40, 5),
(762, 41, 2),
(763, 41, 5),
(772, 56, 11),
(773, 56, 12);

-- --------------------------------------------------------

--
-- Table structure for table `cc_roles`
--

CREATE TABLE `cc_roles` (
  `role_id` int UNSIGNED NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_roles`
--

INSERT INTO `cc_roles` (`role_id`, `role`, `permission`, `is_default`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 'Admin', '{\"Dashboard\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Pages\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Customers\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Product_category\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Settings\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Role\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"User\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Products\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Brand\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Customers\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Color_family\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Attribute_group\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Page_settings\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Coupon\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Module\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Newsletter\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Option\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Order\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Theme_settings\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Email_send\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Reviews\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Shipping\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Flat_rate\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Payment\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Bank_transfer\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Cash_on_delivery\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Advanced_products\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Fund_request\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Geo_zone\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Stripe\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Album\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Oisbizcraft\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Blog_category\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Blog\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"General_offer\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"}}', '1', '2023-05-30 22:31:49', 1, NULL, '2025-09-06 16:41:34'),
(2, 'Manager', '{\"Dashboard\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Pages\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Customers\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Product_category\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Settings\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Role\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"User\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Products\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Brand\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Color_family\":{\"mod_access\":\"1\",\"create\":\"1\",\"read\":\"1\",\"update\":\"1\",\"delete\":\"1\"},\"Geo_zone\":{\"update\":\"1\",\"delete\":\"1\"}}', '', '2023-05-30 22:31:49', 1, NULL, '2023-12-25 18:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `cc_settings`
--

CREATE TABLE `cc_settings` (
  `settings_id` int UNSIGNED NOT NULL,
  `label` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_settings`
--

INSERT INTO `cc_settings` (`settings_id`, `label`, `title`, `value`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 'invoice_prefix', 'Invoice Prefix', 'FL-INV-', '2023-06-10 09:57:51', 1, NULL, '2023-10-01 09:32:00'),
(2, 'currency_symbol', 'Currency Symbol', '$', '2023-06-10 09:57:51', 1, NULL, '2023-07-17 10:32:49'),
(3, 'currency', 'Currency', 'USD', '2023-06-10 09:57:51', 1, NULL, '2023-06-13 20:22:35'),
(4, 'Theme', 'Theme', 'Theme_4', '2023-06-10 09:57:51', 1, NULL, '2026-05-12 12:20:20'),
(6, 'store_name', 'Store Name', 'Style mint', '2023-06-10 09:57:51', 1, NULL, '2025-08-30 10:26:06'),
(7, 'store_owner', 'Store Owner', 'admin', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(8, 'address', 'Address', '121 King St, Melbourne VIC 3000, United Kingdom', '2023-06-10 09:57:51', 1, NULL, '2023-09-25 10:17:54'),
(9, 'email', 'Email', 'stylemint@gmail.com', '2023-06-10 09:57:51', 1, NULL, '2025-08-30 10:26:06'),
(10, 'phone', 'Phone', '01714070770', '2023-06-10 09:57:51', 1, NULL, '2024-01-10 15:29:31'),
(11, 'country', 'Country', '18', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(12, 'state', 'State', '322', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(13, 'language', 'Language', 'Language', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(14, 'length_class', 'Length Class', 'Inch', '2023-06-10 09:57:51', 1, NULL, '2023-07-09 18:35:57'),
(15, 'weight_class', 'Weight Class', 'Gram', '2023-06-10 09:57:51', 1, NULL, '2023-07-09 18:35:57'),
(16, 'store_logo', 'Store Logo', 'logo_1680408092_956787fe09859ea5cd56.png', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(17, 'store_icon', 'Store Icon', 'Store Icon', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(18, 'mail_protocol', 'Mail Protocol', 'Mail Protocol', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(19, 'mail_address', 'Mail Address', 'dnationsoftdm8@gmail.com', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(20, 'smtp_host', 'SMTP Host', 'SMTP Host', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(21, 'smtp_username', 'SMTP Username', 'SMTP Username', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(22, 'smtp_password', 'SMTP Password', 'SMTP Password', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(23, 'smtp_port', 'SMTP Port', 'SMTP Port', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(24, 'smtp_timeout', 'SMTP Timeout', 'SMTP Timeout', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(25, 'new_account_alert_mail', 'New Account Alert Mail', '1', '2023-06-10 09:57:51', 1, NULL, '2023-07-06 13:00:34'),
(26, 'new_order_alert_mail', 'New Order Alert Mail', '1', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(27, 'fb_url', 'Facebook', '#', '2023-06-10 09:57:51', 1, NULL, '2024-01-08 20:07:42'),
(28, 'twitter_url', 'Twitter', '#', '2023-06-10 09:57:51', 1, NULL, '2024-01-08 20:07:42'),
(29, 'tiktok_url', 'Tiktok', '#', '2023-06-10 09:57:51', 1, NULL, '2024-01-08 20:07:42'),
(30, 'instagram_url', 'Instagram', '#', '2023-06-10 09:57:51', 1, NULL, '2024-01-08 20:07:42'),
(31, 'smtp_crypto', 'SMTP Crypto', 'ssl', '2023-06-10 09:57:51', 1, NULL, '2023-06-10 09:57:51'),
(32, 'category_product_limit', 'Category product limit', '9', '2023-10-08 10:43:20', NULL, NULL, '2026-04-11 09:33:25'),
(33, 'meta_title', 'Meta Title', 'Style mint', '2023-11-29 18:47:38', NULL, NULL, '2025-08-30 10:26:06'),
(34, 'meta_keyword', 'Meta Keyword', 'Style mint', '2023-11-29 18:48:16', NULL, NULL, '2025-08-30 10:26:06'),
(35, 'meta_description', 'Meta Description', 'Style mint', '2023-11-29 18:48:39', NULL, NULL, '2025-08-30 10:26:06'),
(36, 'watermark_image', 'Watermark Image', 'wm_1758024056_328b2cd6d24fc2dfeb2d.png', '2025-07-30 16:57:43', NULL, NULL, '2025-09-16 18:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `cc_shipping_method`
--

CREATE TABLE `cc_shipping_method` (
  `shipping_method_id` int UNSIGNED NOT NULL,
  `name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_shipping_method`
--

INSERT INTO `cc_shipping_method` (`shipping_method_id`, `name`, `code`, `status`) VALUES
(1, 'Flat Rate Shipping', 'flat', '1'),
(2, 'Zone Based Shipping', 'zone', '0'),
(3, 'Weight Based Shipping', 'weight', '0'),
(5, 'Zone Rate Shipping', 'zone_rate', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cc_shipping_settings`
--

CREATE TABLE `cc_shipping_settings` (
  `settings_id` int UNSIGNED NOT NULL,
  `shipping_method_id` int NOT NULL,
  `label` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_shipping_settings`
--

INSERT INTO `cc_shipping_settings` (`settings_id`, `shipping_method_id`, `label`, `title`, `value`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 1, 'flat_rate_price', 'Flat Rate', '5', '2023-05-30 22:31:49', NULL, NULL, '2023-05-30 22:31:49'),
(2, 2, 'in_dhaka', 'Inside of Dhaka', '20', '2023-05-30 22:31:49', NULL, NULL, '2023-08-19 12:19:10'),
(3, 2, 'out_dhaka', 'Outside of Dhaka', '50', '2023-05-30 22:31:49', NULL, NULL, '2023-06-07 20:07:59'),
(4, 5, 'zone_rate_method', 'Zone Rate Method', '1', '2023-11-07 19:38:45', NULL, NULL, '2023-11-08 19:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `cc_stores`
--

CREATE TABLE `cc_stores` (
  `store_id` int UNSIGNED NOT NULL,
  `name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_stores`
--

INSERT INTO `cc_stores` (`store_id`, `name`, `description`, `is_default`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 'Default', 'Default Store Description', '1', '2023-05-30 22:31:50', NULL, NULL, '2023-05-30 22:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `cc_theme_settings`
--

CREATE TABLE `cc_theme_settings` (
  `theme_settings_id` int UNSIGNED NOT NULL,
  `label` varchar(155) NOT NULL,
  `title` varchar(155) NOT NULL,
  `value` varchar(155) NOT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cc_theme_settings`
--

INSERT INTO `cc_theme_settings` (`theme_settings_id`, `label`, `title`, `value`, `alt_name`, `theme`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 'slider_1', 'slider', 'slider_1752063695_82fbc10873a90447ab79.jpg', 'Slider 1', NULL, '2023-05-30 22:31:50', NULL, NULL, '2025-09-16 17:38:03'),
(2, 'slider_2', 'slider', 'slider_1752063700_be137c9b88ce8049d666.jpg', 'Slider 2', NULL, '2023-05-30 22:31:50', NULL, NULL, '2025-09-16 17:38:11'),
(3, 'slider_3', 'slider', 'slider_1752063707_38e4cf419adbc1775a08.jpg', 'Slider 3', NULL, '2023-05-30 22:31:50', NULL, NULL, '2025-09-16 17:38:22'),
(4, 'home_category', 'Home Category', '2', NULL, 'Default', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:36:27'),
(5, 'side_logo', 'side logo', 'logo_1756362438_d50755263575f9b51212.png', 'ccart_logo', NULL, '2023-05-30 22:31:50', NULL, NULL, '2025-09-16 17:37:53'),
(6, 'featured_products_limit', 'Featured Products Limit', '6', NULL, 'Default', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:31:39'),
(7, 'home_category_banner', 'Home Category Banner', 'banner_1696225033_0cbb0932cf8c0dd61da7.jpg', NULL, 'Default', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:37:13'),
(8, 'hot_deals_category', 'Hot Deals Category', '2', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:40:18'),
(9, 'trending_collection_category', 'Trending Collection Category', '2', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:32:11'),
(10, 'special_category_one', 'Special Category one', '37', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:32:13'),
(11, 'special_category_two', 'Special Category Two', '3', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:32:15'),
(12, 'special_category_three', 'Special Category Three', '15', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:32:17'),
(13, 'trending_youtube_video', 'Trending Youtube Video', 'https://www.youtube.com/embed/sfIwFJwjgSM', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2026-03-11 16:27:17'),
(14, 'brands_youtube_video', 'Brands Youtube Video', 'https://www.youtube.com/embed/SuuGnwrzrcw', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:32:21'),
(15, 'special_banner', 'Special Banner', 'sp_banner_1696225117_4bea475432e029b12139.jpg', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:38:37'),
(16, 'left_side_banner_one', 'Left Side Banne One', 'left_banner_1732373131_946fa50c70c56e957bb3.jpg', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2024-11-23 20:45:31'),
(17, 'left_side_banner_two', 'Left Side Banne Two', 'left_banner_1696225186_06043d62c9bff24919bc.jpg', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:39:46'),
(18, 'left_side_banner_three', 'Left Side Banne Three', 'left_banner_1696225190_e388fa8be68c2c2ab3aa.jpg', NULL, 'Theme_2', '2023-05-30 22:31:50', NULL, NULL, '2023-10-02 11:39:50'),
(19, 'head_side_baner_1', 'Side Banner ', 'head_side_baner_1752063633_e5cdfe9b0f3c9afc27d7.jpg', 'Top Section One', 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2025-09-17 18:50:42'),
(20, 'head_side_baner_2', 'Side Banner', 'head_side_baner_1752063659_cb61a92edb17512ad6a3.jpg', 'Top Section Two', 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2025-09-17 18:50:49'),
(21, 'head_side_category_1', 'Side Category', '24', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2024-07-01 20:16:20'),
(22, 'head_side_category_2', 'Side Category', '1', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-26 19:24:50'),
(23, 'head_side_title_1', 'Side Title', '', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2024-07-01 20:16:20'),
(24, 'head_side_title_2', 'Side Title', '', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2024-02-22 20:58:03'),
(25, 'home_category_1', 'Home Category', '44', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-10-02 11:59:06'),
(26, 'home_category_baner_1', 'Category Banner', 'home_category_1752323002_95f3d95f01645f1bffc8.png', 'Category Section One', 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2025-09-17 18:50:58'),
(27, 'home_category_title_1', 'Category title', 'Apparels', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-27 09:48:59'),
(28, 'home_category_2', 'Home Category', '44', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-12-26 20:19:31'),
(29, 'home_category_baner_2', 'Category Banner', 'home_category_1752323020_548ce363f81ad6f90d9f.png', 'Category Section Two', 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2025-09-17 18:51:06'),
(30, 'home_category_title_2', 'Category title', 'Treasures', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-27 09:48:49'),
(31, 'home_category_3', 'Home Category', '2', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-26 19:51:38'),
(32, 'home_category_baner_3', 'Category Banner', 'home_category_1708783561_70d702a833321500eb59.jpg', 'Category Section Three', 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2025-09-17 18:51:19'),
(33, 'home_category_title_3', 'Category title', 'Bag', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-27 09:48:22'),
(34, 'home_category_4', 'Home Category', '11', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-26 19:54:36'),
(35, 'home_category_baner_4', 'Category Banner', 'home_category_1708783582_45fecc18858725d6018b.jpg', 'Category Section Four', 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2025-09-17 18:51:30'),
(36, 'home_category_title_4', 'Category title', 'Jewelry', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-27 09:47:20'),
(37, 'home_category_5', 'Category', '37', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-27 09:47:13'),
(38, 'home_category_baner_5', 'Category Banner', 'home_category_1752323029_18879d05409287998a18.png', 'Category Banner', 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2025-09-17 18:50:24'),
(39, 'home_category_title_5', 'Category title', 'Shoes', NULL, 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2023-09-27 09:47:04'),
(40, 'banner_bottom', 'Banner Bottom', 'banner_bottom_1729494837_6b90e30a67ccf2938735.jpg', 'Banner Bottom', 'Theme_3', '2023-09-26 16:29:16', NULL, NULL, '2025-09-17 18:52:11'),
(41, 'favicon', 'Favicon', 'favicon_1758024498_b8b00f85d6fad84f37af.png', NULL, NULL, '2023-12-13 18:37:27', NULL, NULL, '2025-09-16 18:08:18'),
(42, 'top_category_left_title', 'Top Category Left Title', 'Man Watches', NULL, 'Theme_4', '2025-12-22 17:02:11', NULL, NULL, '2025-12-22 18:21:12'),
(43, 'top_category_left_sub_title', 'Top Category Left Sub Title', 'You can Find All Man Watch In This Tab', NULL, 'Theme_4', '2025-12-22 17:02:44', NULL, NULL, '2025-12-22 18:21:12'),
(44, 'top_category_left_image', 'Top Category Left Image', 'top_category_left_image_1766406072_f9f9ec5aedd686239662.jpg', 'Man Watches', 'Theme_4', '2025-12-22 17:03:12', NULL, NULL, '2025-12-22 18:21:12'),
(45, 'top_category_left_category', 'Top Category Left Category', '3', NULL, 'Theme_4', '2025-12-22 17:03:43', NULL, NULL, '2025-12-22 18:21:12'),
(46, 'top_category_right_title', 'Top Category Right Title', 'Woman Watches', NULL, 'Theme_4', '2025-12-22 17:04:11', NULL, NULL, '2025-12-22 18:21:37'),
(47, 'top_category_right_sub_title', 'Top Category Right Sub Title', 'You can Find All Man Watch In This Tab', NULL, 'Theme_4', '2025-12-22 17:04:45', NULL, NULL, '2025-12-22 18:21:37'),
(48, 'top_category_right_image', 'Top Category Right Image', 'top_category_right_image_1766406097_11200dfb28a3b3919664.jpg', 'Women image', 'Theme_4', '2025-12-22 17:05:09', NULL, NULL, '2025-12-22 18:21:37'),
(49, 'top_category_right_category', 'Top Category Right Category', '1', NULL, 'Theme_4', '2025-12-22 17:05:39', NULL, NULL, '2025-12-22 18:21:37'),
(50, 'recent_product_title', 'Recent Product Title', 'Recently', NULL, 'Theme_4', '2025-12-22 17:06:04', NULL, NULL, '2025-12-22 18:23:26'),
(51, 'recent_product_sub_title', 'Recent Product Sub Title', 'Choose your fresh Vegetables. No chemical', NULL, 'Theme_4', '2025-12-22 17:06:31', NULL, NULL, '2025-12-22 18:23:26'),
(52, 'recent_product_image', 'Recent Product Image', 'recent_product_image_1766406206_a722f7a02607ab4dfbde.jpg', 'Women image', 'Theme_4', '2025-12-22 17:06:54', NULL, NULL, '2025-12-22 18:23:26'),
(53, 'recent_product_category', 'Recent Product Category', '2', NULL, 'Theme_4', '2025-12-22 17:07:18', NULL, NULL, '2025-12-22 18:23:46'),
(54, 'section_one_title', 'Section One Title', 'Best Sellers', NULL, 'Theme_4', '2025-12-22 17:07:41', NULL, NULL, '2025-12-22 18:22:08'),
(55, 'section_one_sub_title', 'Section One Sub Title', 'Join thousands who wear our best-selling styles with pride.', NULL, 'Theme_4', '2025-12-22 17:08:07', NULL, NULL, '2025-12-22 18:22:09'),
(56, 'section_one_category', 'Section One Category', '2', NULL, 'Theme_4', '2025-12-22 17:08:31', NULL, NULL, '2025-12-22 18:24:23'),
(57, 'section_one_image', 'Section One Image', 'section_one_image_1766406128_11d5896696c6165f644d.jpg', 'Women image', 'Theme_4', '2025-12-22 17:08:54', NULL, NULL, '2025-12-22 18:22:09'),
(58, 'section_two_image', 'Section Two Image', 'section_two_image_1766406152_9b9761a9f54c256e4161.jpg', 'Women image', 'Theme_4', '2025-12-22 17:09:15', NULL, NULL, '2025-12-22 18:22:32'),
(59, 'section_two_category', 'Section Two Category', '2', NULL, 'Theme_4', '2025-12-22 17:09:41', NULL, NULL, '2025-12-22 18:24:13'),
(60, 'section_two_title', 'Section Two Title', 'New Arrivals', NULL, 'Theme_4', '2025-12-22 17:10:05', NULL, NULL, '2025-12-22 18:22:32'),
(61, 'section_two_sub_title', 'Section Two Sub Title', 'Join thousands who wear our best-selling styles with pride.', NULL, 'Theme_4', '2025-12-22 17:10:27', NULL, NULL, '2025-12-22 18:22:32'),
(62, 'offer_view', 'Offer View', '', NULL, 'Theme_4', '2025-12-22 17:10:57', NULL, NULL, '2025-12-22 17:10:57'),
(63, 'popular_this_week', 'Popular this week', '', NULL, 'Theme_4', '2025-12-22 17:11:20', NULL, NULL, '2025-12-22 17:11:20'),
(64, 'slider4_1', 'Slider 1', 'slider_1766402370_8fa697dc54a1bbb53254.png', 'Women image', 'Theme_4', '2025-12-22 17:11:39', NULL, NULL, '2025-12-22 17:19:30'),
(65, 'slider4_2', 'Slider 2', 'slider_1766402395_23ad71781058d56adfc1.png', 'Women image', 'Theme_4', '2025-12-22 17:13:10', NULL, NULL, '2025-12-22 17:19:55'),
(66, 'slider4_3', 'Slider 3', 'slider_1766402419_931c04b7c32c323b4e85.png', 'Women image', 'Theme_4', '2025-12-22 17:13:29', NULL, NULL, '2025-12-22 17:20:19'),
(67, 'slider4_text_1', 'Slider Text', 'Luxury Meets Affordability?', NULL, 'Theme_4', '2025-12-22 17:13:50', NULL, NULL, '2025-12-22 17:19:30'),
(68, 'slider4_text_2', 'Slider Text', 'Luxury Meets Affordability?', NULL, 'Theme_4', '2025-12-22 17:14:08', NULL, NULL, '2025-12-22 17:19:55'),
(69, 'slider4_text_3', 'Slider Text', 'Luxury Meets Affordability?', NULL, 'Theme_4', '2025-12-22 17:14:19', NULL, NULL, '2025-12-22 17:20:19'),
(70, 'slider4_sub_text_1', 'Slider Short Text', 'Get designer looks without the designer price tag.', NULL, 'Theme_4', '2025-12-22 17:14:39', NULL, NULL, '2025-12-22 17:19:30'),
(71, 'slider4_sub_text_2', 'Slider Short Text', 'Get designer looks without the designer price tag.', NULL, 'Theme_4', '2025-12-22 17:14:51', NULL, NULL, '2025-12-22 17:19:55'),
(72, 'slider4_sub_text_3', 'Slider Short Text', 'Get designer looks without the designer price tag.', NULL, 'Theme_4', '2025-12-22 17:15:05', NULL, NULL, '2025-12-22 17:20:19'),
(73, 'slider4_category_1', 'Slider Category', '2', NULL, 'Theme_4', '2025-12-22 17:15:25', NULL, NULL, '2025-12-22 17:19:30'),
(74, 'slider4_category_2', 'Slider Category', '11', NULL, 'Theme_4', '2025-12-22 17:15:35', NULL, NULL, '2025-12-22 17:19:55'),
(75, 'slider4_category_3', 'Slider Category', '12', NULL, 'Theme_4', '2025-12-22 17:15:45', NULL, NULL, '2025-12-22 17:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `cc_users`
--

CREATE TABLE `cc_users` (
  `user_id` int UNSIGNED NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` int DEFAULT NULL,
  `address` mediumtext COLLATE utf8mb4_unicode_ci,
  `pic` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int NOT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `is_default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_users`
--

INSERT INTO `cc_users` (`user_id`, `email`, `password`, `pass`, `name`, `mobile`, `address`, `pic`, `alt_name`, `role_id`, `status`, `is_default`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 'admin@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '12345678', 'Demo Admin', 1924329315, 'This is demo address', 'user_1696139087_6351b290e7689d543410.png', NULL, 1, '1', '1', '2023-05-30 22:31:50', 1, 1, '2025-01-26 18:38:57'),
(3, 'murad@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '12345678', 'Murad', NULL, NULL, 'user_1703506631_941dc5116d9028b42816.jpg', NULL, 2, '1', '0', '2023-10-18 19:55:19', 1, 1, '2023-12-25 18:17:11'),
(4, 'khan12@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '12345678', 'Sumon', NULL, NULL, '', NULL, 1, '1', '0', '2024-11-20 18:35:01', 1, NULL, '2024-11-20 18:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `cc_weight_shipping_settings`
--

CREATE TABLE `cc_weight_shipping_settings` (
  `settings_id` int UNSIGNED NOT NULL,
  `shipping_method_id` int NOT NULL,
  `label` int NOT NULL,
  `title` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updatedDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_weight_shipping_settings`
--

INSERT INTO `cc_weight_shipping_settings` (`settings_id`, `shipping_method_id`, `label`, `title`, `value`, `createdDtm`, `createdBy`, `updatedBy`, `updatedDtm`) VALUES
(1, 3, 5, '', 50, '2023-11-21 18:56:42', NULL, NULL, '2023-11-21 18:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `cc_zone`
--

CREATE TABLE `cc_zone` (
  `zone_id` int UNSIGNED NOT NULL,
  `country_id` int NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc_zone`
--

INSERT INTO `cc_zone` (`zone_id`, `country_id`, `name`, `code`, `status`) VALUES
(1, 1, 'Badakhshan', 'BDS', 1),
(2, 1, 'Badghis', 'BDG', 1),
(3, 1, 'Baghlan', 'BGL', 1),
(4, 1, 'Balkh', 'BAL', 1),
(5, 1, 'Bamian', 'BAM', 1),
(6, 1, 'Farah', 'FRA', 1),
(7, 1, 'Faryab', 'FYB', 1),
(8, 1, 'Ghazni', 'GHA', 1),
(9, 1, 'Ghowr', 'GHO', 1),
(10, 1, 'Helmand', 'HEL', 1),
(11, 1, 'Herat', 'HER', 1),
(12, 1, 'Jowzjan', 'JOW', 1),
(13, 1, 'Kabul', 'KAB', 1),
(14, 1, 'Kandahar', 'KAN', 1),
(15, 1, 'Kapisa', 'KAP', 1),
(16, 1, 'Khost', 'KHO', 1),
(17, 1, 'Konar', 'KNR', 1),
(18, 1, 'Kondoz', 'KDZ', 1),
(19, 1, 'Laghman', 'LAG', 1),
(20, 1, 'Lowgar', 'LOW', 1),
(21, 1, 'Nangrahar', 'NAN', 1),
(22, 1, 'Nimruz', 'NIM', 1),
(23, 1, 'Nurestan', 'NUR', 1),
(24, 1, 'Oruzgan', 'ORU', 1),
(25, 1, 'Paktia', 'PIA', 1),
(26, 1, 'Paktika', 'PKA', 1),
(27, 1, 'Parwan', 'PAR', 1),
(28, 1, 'Samangan', 'SAM', 1),
(29, 1, 'Sar-e Pol', 'SAR', 1),
(30, 1, 'Takhar', 'TAK', 1),
(31, 1, 'Wardak', 'WAR', 1),
(32, 1, 'Zabol', 'ZAB', 1),
(33, 2, 'Berat', 'BR', 1),
(34, 2, 'Bulqize', 'BU', 1),
(35, 2, 'Delvine', 'DL', 1),
(36, 2, 'Devoll', 'DV', 1),
(37, 2, 'Diber', 'DI', 1),
(38, 2, 'Durres', 'DR', 1),
(39, 2, 'Elbasan', 'EL', 1),
(40, 2, 'Kolonje', 'ER', 1),
(41, 2, 'Fier', 'FR', 1),
(42, 2, 'Gjirokaster', 'GJ', 1),
(43, 2, 'Gramsh', 'GR', 1),
(44, 2, 'Has', 'HA', 1),
(45, 2, 'Kavaje', 'KA', 1),
(46, 2, 'Kurbin', 'KB', 1),
(47, 2, 'Kucove', 'KC', 1),
(48, 2, 'Korce', 'KO', 1),
(49, 2, 'Kruje', 'KR', 1),
(50, 2, 'Kukes', 'KU', 1),
(51, 2, 'Librazhd', 'LB', 1),
(52, 2, 'Lezhe', 'LE', 1),
(53, 2, 'Lushnje', 'LU', 1),
(54, 2, 'Malesi e Madhe', 'MM', 1),
(55, 2, 'Mallakaster', 'MK', 1),
(56, 2, 'Mat', 'MT', 1),
(57, 2, 'Mirdite', 'MR', 1),
(58, 2, 'Peqin', 'PQ', 1),
(59, 2, 'Permet', 'PR', 1),
(60, 2, 'Pogradec', 'PG', 1),
(61, 2, 'Puke', 'PU', 1),
(62, 2, 'Shkoder', 'SH', 1),
(63, 2, 'Skrapar', 'SK', 1),
(64, 2, 'Sarande', 'SR', 1),
(65, 2, 'Tepelene', 'TE', 1),
(66, 2, 'Tropoje', 'TP', 1),
(67, 2, 'Tirane', 'TR', 1),
(68, 2, 'Vlore', 'VL', 1),
(69, 3, 'Adrar', 'ADR', 1),
(70, 3, 'Ain Defla', 'ADE', 1),
(71, 3, 'Ain Temouchent', 'ATE', 1),
(72, 3, 'Alger', 'ALG', 1),
(73, 3, 'Annaba', 'ANN', 1),
(74, 3, 'Batna', 'BAT', 1),
(75, 3, 'Bechar', 'BEC', 1),
(76, 3, 'Bejaia', 'BEJ', 1),
(77, 3, 'Biskra', 'BIS', 1),
(78, 3, 'Blida', 'BLI', 1),
(79, 3, 'Bordj Bou Arreridj', 'BBA', 1),
(80, 3, 'Bouira', 'BOA', 1),
(81, 3, 'Boumerdes', 'BMD', 1),
(82, 3, 'Chlef', 'CHL', 1),
(83, 3, 'Constantine', 'CON', 1),
(84, 3, 'Djelfa', 'DJE', 1),
(85, 3, 'El Bayadh', 'EBA', 1),
(86, 3, 'El Oued', 'EOU', 1),
(87, 3, 'El Tarf', 'ETA', 1),
(88, 3, 'Ghardaia', 'GHA', 1),
(89, 3, 'Guelma', 'GUE', 1),
(90, 3, 'Illizi', 'ILL', 1),
(91, 3, 'Jijel', 'JIJ', 1),
(92, 3, 'Khenchela', 'KHE', 1),
(93, 3, 'Laghouat', 'LAG', 1),
(94, 3, 'Muaskar', 'MUA', 1),
(95, 3, 'Medea', 'MED', 1),
(96, 3, 'Mila', 'MIL', 1),
(97, 3, 'Mostaganem', 'MOS', 1),
(98, 3, 'MSila', 'MSI', 1),
(99, 3, 'Naama', 'NAA', 1),
(100, 3, 'Oran', 'ORA', 1),
(101, 3, 'Ouargla', 'OUA', 1),
(102, 3, 'Oum el-Bouaghi', 'OEB', 1),
(103, 3, 'Relizane', 'REL', 1),
(104, 3, 'Saida', 'SAI', 1),
(105, 3, 'Setif', 'SET', 1),
(106, 3, 'Sidi Bel Abbes', 'SBA', 1),
(107, 3, 'Skikda', 'SKI', 1),
(108, 3, 'Souk Ahras', 'SAH', 1),
(109, 3, 'Tamanghasset', 'TAM', 1),
(110, 3, 'Tebessa', 'TEB', 1),
(111, 3, 'Tiaret', 'TIA', 1),
(112, 3, 'Tindouf', 'TIN', 1),
(113, 3, 'Tipaza', 'TIP', 1),
(114, 3, 'Tissemsilt', 'TIS', 1),
(115, 3, 'Tizi Ouzou', 'TOU', 1),
(116, 3, 'Tlemcen', 'TLE', 1),
(117, 4, 'Eastern', 'E', 1),
(118, 4, 'Manu a', 'M', 1),
(119, 4, 'Rose Island', 'R', 1),
(120, 4, 'Swains Island', 'S', 1),
(121, 4, 'Western', 'W', 1),
(122, 5, 'Andorra la Vella', 'ALV', 1),
(123, 5, 'Canillo', 'CAN', 1),
(124, 5, 'Encamp', 'ENC', 1),
(125, 5, 'Escaldes-Engordany', 'ESE', 1),
(126, 5, 'La Massana', 'LMA', 1),
(127, 5, 'Ordino', 'ORD', 1),
(128, 5, 'Sant Julia de Loria', 'SJL', 1),
(129, 6, 'Bengo', 'BGO', 1),
(130, 6, 'Benguela', 'BGU', 1),
(131, 6, 'Bie', 'BIE', 1),
(132, 6, 'Cabinda', 'CAB', 1),
(133, 6, 'Cuando-Cubango', 'CCU', 1),
(134, 6, 'Cuanza Norte', 'CNO', 1),
(135, 6, 'Cuanza Sul', 'CUS', 1),
(136, 6, 'Cunene', 'CNN', 1),
(137, 6, 'Huambo', 'HUA', 1),
(138, 6, 'Huila', 'HUI', 1),
(139, 6, 'Luanda', 'LUA', 1),
(140, 6, 'Lunda Norte', 'LNO', 1),
(141, 6, 'Lunda Sul', 'LSU', 1),
(142, 6, 'Malange', 'MAL', 1),
(143, 6, 'Moxico', 'MOX', 1),
(144, 6, 'Namibe', 'NAM', 1),
(145, 6, 'Uige', 'UIG', 1),
(146, 6, 'Zaire', 'ZAI', 1),
(147, 9, 'Saint George', 'ASG', 1),
(148, 9, 'Saint John', 'ASJ', 1),
(149, 9, 'Saint Mary', 'ASM', 1),
(150, 9, 'Saint Paul', 'ASL', 1),
(151, 9, 'Saint Peter', 'ASR', 1),
(152, 9, 'Saint Philip', 'ASH', 1),
(153, 9, 'Barbuda', 'BAR', 1),
(154, 9, 'Redonda', 'RED', 1),
(155, 10, 'Antartida e Islas del Atlantico', 'AN', 1),
(156, 10, 'Buenos Aires', 'BA', 1),
(157, 10, 'Catamarca', 'CA', 1),
(158, 10, 'Chaco', 'CH', 1),
(159, 10, 'Chubut', 'CU', 1),
(160, 10, 'Cordoba', 'CO', 1),
(161, 10, 'Corrientes', 'CR', 1),
(162, 10, 'Distrito Federal', 'DF', 1),
(163, 10, 'Entre Rios', 'ER', 1),
(164, 10, 'Formosa', 'FO', 1),
(165, 10, 'Jujuy', 'JU', 1),
(166, 10, 'La Pampa', 'LP', 1),
(167, 10, 'La Rioja', 'LR', 1),
(168, 10, 'Mendoza', 'ME', 1),
(169, 10, 'Misiones', 'MI', 1),
(170, 10, 'Neuquen', 'NE', 1),
(171, 10, 'Rio Negro', 'RN', 1),
(172, 10, 'Salta', 'SA', 1),
(173, 10, 'San Juan', 'SJ', 1),
(174, 10, 'San Luis', 'SL', 1),
(175, 10, 'Santa Cruz', 'SC', 1),
(176, 10, 'Santa Fe', 'SF', 1),
(177, 10, 'Santiago del Estero', 'SD', 1),
(178, 10, 'Tierra del Fuego', 'TF', 1),
(179, 10, 'Tucuman', 'TU', 1),
(180, 11, 'Aragatsotn', 'AGT', 1),
(181, 11, 'Ararat', 'ARR', 1),
(182, 11, 'Armavir', 'ARM', 1),
(183, 11, 'Geghark unik ', 'GEG', 1),
(184, 11, 'Kotayk ', 'KOT', 1),
(185, 11, 'Lorri', 'LOR', 1),
(186, 11, 'Shirak', 'SHI', 1),
(187, 11, 'Syunik ', 'SYU', 1),
(188, 11, 'Tavush', 'TAV', 1),
(189, 11, 'Vayots  Dzor', 'VAY', 1),
(190, 11, 'Yerevan', 'YER', 1),
(191, 13, 'Australian Capital Territory', 'ACT', 1),
(192, 13, 'New South Wales', 'NSW', 1),
(193, 13, 'Northern Territory', 'NT', 1),
(194, 13, 'Queensland', 'QLD', 1),
(195, 13, 'South Australia', 'SA', 1),
(196, 13, 'Tasmania', 'TAS', 1),
(197, 13, 'Victoria', 'VIC', 1),
(198, 13, 'Western Australia', 'WA', 1),
(199, 14, 'Burgenland', 'BUR', 1),
(200, 14, 'Kärnten', 'KAR', 1),
(201, 14, 'Niederösterreich', 'NOS', 1),
(202, 14, 'Oberösterreich', 'OOS', 1),
(203, 14, 'Salzburg', 'SAL', 1),
(204, 14, 'Steiermark', 'STE', 1),
(205, 14, 'Tirol', 'TIR', 1),
(206, 14, 'Vorarlberg', 'VOR', 1),
(207, 14, 'Wien', 'WIE', 1),
(208, 15, 'Ali Bayramli', 'AB', 1),
(209, 15, 'Abseron', 'ABS', 1),
(210, 15, 'AgcabAdi', 'AGC', 1),
(211, 15, 'Agdam', 'AGM', 1),
(212, 15, 'Agdas', 'AGS', 1),
(213, 15, 'Agstafa', 'AGA', 1),
(214, 15, 'Agsu', 'AGU', 1),
(215, 15, 'Astara', 'AST', 1),
(216, 15, 'Baki', 'BA', 1),
(217, 15, 'BabAk', 'BAB', 1),
(218, 15, 'BalakAn', 'BAL', 1),
(219, 15, 'BArdA', 'BAR', 1),
(220, 15, 'Beylaqan', 'BEY', 1),
(221, 15, 'Bilasuvar', 'BIL', 1),
(222, 15, 'Cabrayil', 'CAB', 1),
(223, 15, 'Calilabab', 'CAL', 1),
(224, 15, 'Culfa', 'CUL', 1),
(225, 15, 'Daskasan', 'DAS', 1),
(226, 15, 'Davaci', 'DAV', 1),
(227, 15, 'Fuzuli', 'FUZ', 1),
(228, 15, 'Ganca', 'GA', 1),
(229, 15, 'Gadabay', 'GAD', 1),
(230, 15, 'Goranboy', 'GOR', 1),
(231, 15, 'Goycay', 'GOY', 1),
(232, 15, 'Haciqabul', 'HAC', 1),
(233, 15, 'Imisli', 'IMI', 1),
(234, 15, 'Ismayilli', 'ISM', 1),
(235, 15, 'Kalbacar', 'KAL', 1),
(236, 15, 'Kurdamir', 'KUR', 1),
(237, 15, 'Lankaran', 'LA', 1),
(238, 15, 'Lacin', 'LAC', 1),
(239, 15, 'Lankaran', 'LAN', 1),
(240, 15, 'Lerik', 'LER', 1),
(241, 15, 'Masalli', 'MAS', 1),
(242, 15, 'Mingacevir', 'MI', 1),
(243, 15, 'Naftalan', 'NA', 1),
(244, 15, 'Neftcala', 'NEF', 1),
(245, 15, 'Oguz', 'OGU', 1),
(246, 15, 'Ordubad', 'ORD', 1),
(247, 15, 'Qabala', 'QAB', 1),
(248, 15, 'Qax', 'QAX', 1),
(249, 15, 'Qazax', 'QAZ', 1),
(250, 15, 'Qobustan', 'QOB', 1),
(251, 15, 'Quba', 'QBA', 1),
(252, 15, 'Qubadli', 'QBI', 1),
(253, 15, 'Qusar', 'QUS', 1),
(254, 15, 'Saki', 'SA', 1),
(255, 15, 'Saatli', 'SAT', 1),
(256, 15, 'Sabirabad', 'SAB', 1),
(257, 15, 'Sadarak', 'SAD', 1),
(258, 15, 'Sahbuz', 'SAH', 1),
(259, 15, 'Saki', 'SAK', 1),
(260, 15, 'Salyan', 'SAL', 1),
(261, 15, 'Sumqayit', 'SM', 1),
(262, 15, 'Samaxi', 'SMI', 1),
(263, 15, 'Samkir', 'SKR', 1),
(264, 15, 'Samux', 'SMX', 1),
(265, 15, 'Sarur', 'SAR', 1),
(266, 15, 'Siyazan', 'SIY', 1),
(267, 15, 'Susa', 'SS', 1),
(268, 15, 'Susa', 'SUS', 1),
(269, 15, 'Tartar', 'TAR', 1),
(270, 15, 'Tovuz', 'TOV', 1),
(271, 15, 'Ucar', 'UCA', 1),
(272, 15, 'Xankandi', 'XA', 1),
(273, 15, 'Xacmaz', 'XAC', 1),
(274, 15, 'Xanlar', 'XAN', 1),
(275, 15, 'Xizi', 'XIZ', 1),
(276, 15, 'Xocali', 'XCI', 1),
(277, 15, 'Xocavand', 'XVD', 1),
(278, 15, 'Yardimli', 'YAR', 1),
(279, 15, 'Yevlax', 'YEV', 1),
(280, 15, 'Zangilan', 'ZAN', 1),
(281, 15, 'Zaqatala', 'ZAQ', 1),
(282, 15, 'Zardab', 'ZAR', 1),
(283, 15, 'Naxcivan', 'NX', 1),
(284, 16, 'Acklins', 'ACK', 1),
(285, 16, 'Berry Islands', 'BER', 1),
(286, 16, 'Bimini', 'BIM', 1),
(287, 16, 'Black Point', 'BLK', 1),
(288, 16, 'Cat Island', 'CAT', 1),
(289, 16, 'Central Abaco', 'CAB', 1),
(290, 16, 'Central Andros', 'CAN', 1),
(291, 16, 'Central Eleuthera', 'CEL', 1),
(292, 16, 'City of Freeport', 'FRE', 1),
(293, 16, 'Crooked Island', 'CRO', 1),
(294, 16, 'East Grand Bahama', 'EGB', 1),
(295, 16, 'Exuma', 'EXU', 1),
(296, 16, 'Grand Cay', 'GRD', 1),
(297, 16, 'Harbour Island', 'HAR', 1),
(298, 16, 'Hope Town', 'HOP', 1),
(299, 16, 'Inagua', 'INA', 1),
(300, 16, 'Long Island', 'LNG', 1),
(301, 16, 'Mangrove Cay', 'MAN', 1),
(302, 16, 'Mayaguana', 'MAY', 1),
(303, 16, 'Moore s Island', 'MOO', 1),
(304, 16, 'North Abaco', 'NAB', 1),
(305, 16, 'North Andros', 'NAN', 1),
(306, 16, 'North Eleuthera', 'NEL', 1),
(307, 16, 'Ragged Island', 'RAG', 1),
(308, 16, 'Rum Cay', 'RUM', 1),
(309, 16, 'San Salvador', 'SAL', 1),
(310, 16, 'South Abaco', 'SAB', 1),
(311, 16, 'South Andros', 'SAN', 1),
(312, 16, 'South Eleuthera', 'SEL', 1),
(313, 16, 'Spanish Wells', 'SWE', 1),
(314, 16, 'West Grand Bahama', 'WGB', 1),
(315, 17, 'Capital', 'CAP', 1),
(316, 17, 'Central', 'CEN', 1),
(317, 17, 'Muharraq', 'MUH', 1),
(318, 17, 'Northern', 'NOR', 1),
(319, 17, 'Southern', 'SOU', 1),
(320, 18, 'Barisal', 'BAR', 1),
(321, 18, 'Chittagong', 'CHI', 1),
(322, 18, 'Dhaka', 'DHA', 1),
(323, 18, 'Khulna', 'KHU', 1),
(324, 18, 'Rajshahi', 'RAJ', 1),
(325, 18, 'Sylhet', 'SYL', 1),
(326, 19, 'Christ Church', 'CC', 1),
(327, 19, 'Saint Andrew', 'AND', 1),
(328, 19, 'Saint George', 'GEO', 1),
(329, 19, 'Saint James', 'JAM', 1),
(330, 19, 'Saint John', 'JOH', 1),
(331, 19, 'Saint Joseph', 'JOS', 1),
(332, 19, 'Saint Lucy', 'LUC', 1),
(333, 19, 'Saint Michael', 'MIC', 1),
(334, 19, 'Saint Peter', 'PET', 1),
(335, 19, 'Saint Philip', 'PHI', 1),
(336, 19, 'Saint Thomas', 'THO', 1),
(337, 20, 'Brestskaya (Brest)', 'BR', 1),
(338, 20, 'Homyel skaya (Homyel )', 'HO', 1),
(339, 20, 'Horad Minsk', 'HM', 1),
(340, 20, 'Hrodzyenskaya (Hrodna)', 'HR', 1),
(341, 20, 'Mahilyowskaya (Mahilyow)', 'MA', 1),
(342, 20, 'Minskaya', 'MI', 1),
(343, 20, 'Vitsyebskaya (Vitsyebsk)', 'VI', 1),
(344, 21, 'Antwerpen', 'VAN', 1),
(345, 21, 'Brabant Wallon', 'WBR', 1),
(346, 21, 'Hainaut', 'WHT', 1),
(347, 21, 'Liège', 'WLG', 1),
(348, 21, 'Limburg', 'VLI', 1),
(349, 21, 'Luxembourg', 'WLX', 1),
(350, 21, 'Namur', 'WNA', 1),
(351, 21, 'Oost-Vlaanderen', 'VOV', 1),
(352, 21, 'Vlaams Brabant', 'VBR', 1),
(353, 21, 'West-Vlaanderen', 'VWV', 1),
(354, 22, 'Belize', 'BZ', 1),
(355, 22, 'Cayo', 'CY', 1),
(356, 22, 'Corozal', 'CR', 1),
(357, 22, 'Orange Walk', 'OW', 1),
(358, 22, 'Stann Creek', 'SC', 1),
(359, 22, 'Toledo', 'TO', 1),
(360, 23, 'Alibori', 'AL', 1),
(361, 23, 'Atakora', 'AK', 1),
(362, 23, 'Atlantique', 'AQ', 1),
(363, 23, 'Borgou', 'BO', 1),
(364, 23, 'Collines', 'CO', 1),
(365, 23, 'Donga', 'DO', 1),
(366, 23, 'Kouffo', 'KO', 1),
(367, 23, 'Littoral', 'LI', 1),
(368, 23, 'Mono', 'MO', 1),
(369, 23, 'Oueme', 'OU', 1),
(370, 23, 'Plateau', 'PL', 1),
(371, 23, 'Zou', 'ZO', 1),
(372, 24, 'Devonshire', 'DS', 1),
(373, 24, 'Hamilton City', 'HC', 1),
(374, 24, 'Hamilton', 'HA', 1),
(375, 24, 'Paget', 'PG', 1),
(376, 24, 'Pembroke', 'PB', 1),
(377, 24, 'Saint George City', 'GC', 1),
(378, 24, 'Saint George s', 'SG', 1),
(379, 24, 'Sandys', 'SA', 1),
(380, 24, 'Smith s', 'SM', 1),
(381, 24, 'Southampton', 'SH', 1),
(382, 24, 'Warwick', 'WA', 1),
(383, 25, 'Bumthang', 'BUM', 1),
(384, 25, 'Chukha', 'CHU', 1),
(385, 25, 'Dagana', 'DAG', 1),
(386, 25, 'Gasa', 'GAS', 1),
(387, 25, 'Haa', 'HAA', 1),
(388, 25, 'Lhuntse', 'LHU', 1),
(389, 25, 'Mongar', 'MON', 1),
(390, 25, 'Paro', 'PAR', 1),
(391, 25, 'Pemagatshel', 'PEM', 1),
(392, 25, 'Punakha', 'PUN', 1),
(393, 25, 'Samdrup Jongkhar', 'SJO', 1),
(394, 25, 'Samtse', 'SAT', 1),
(395, 25, 'Sarpang', 'SAR', 1),
(396, 25, 'Thimphu', 'THI', 1),
(397, 25, 'Trashigang', 'TRG', 1),
(398, 25, 'Trashiyangste', 'TRY', 1),
(399, 25, 'Trongsa', 'TRO', 1),
(400, 25, 'Tsirang', 'TSI', 1),
(401, 25, 'Wangdue Phodrang', 'WPH', 1),
(402, 25, 'Zhemgang', 'ZHE', 1),
(403, 26, 'Beni', 'BEN', 1),
(404, 26, 'Chuquisaca', 'CHU', 1),
(405, 26, 'Cochabamba', 'COC', 1),
(406, 26, 'La Paz', 'LPZ', 1),
(407, 26, 'Oruro', 'ORU', 1),
(408, 26, 'Pando', 'PAN', 1),
(409, 26, 'Potosi', 'POT', 1),
(410, 26, 'Santa Cruz', 'SCZ', 1),
(411, 26, 'Tarija', 'TAR', 1),
(412, 27, 'Brcko district', 'BRO', 1),
(413, 27, 'Unsko-Sanski Kanton', 'FUS', 1),
(414, 27, 'Posavski Kanton', 'FPO', 1),
(415, 27, 'Tuzlanski Kanton', 'FTU', 1),
(416, 27, 'Zenicko-Dobojski Kanton', 'FZE', 1),
(417, 27, 'Bosanskopodrinjski Kanton', 'FBP', 1),
(418, 27, 'Srednjebosanski Kanton', 'FSB', 1),
(419, 27, 'Hercegovacko-neretvanski Kanton', 'FHN', 1),
(420, 27, 'Zapadnohercegovacka Zupanija', 'FZH', 1),
(421, 27, 'Kanton Sarajevo', 'FSA', 1),
(422, 27, 'Zapadnobosanska', 'FZA', 1),
(423, 27, 'Banja Luka', 'SBL', 1),
(424, 27, 'Doboj', 'SDO', 1),
(425, 27, 'Bijeljina', 'SBI', 1),
(426, 27, 'Vlasenica', 'SVL', 1),
(427, 27, 'Sarajevo-Romanija or Sokolac', 'SSR', 1),
(428, 27, 'Foca', 'SFO', 1),
(429, 27, 'Trebinje', 'STR', 1),
(430, 28, 'Central', 'CE', 1),
(431, 28, 'Ghanzi', 'GH', 1),
(432, 28, 'Kgalagadi', 'KD', 1),
(433, 28, 'Kgatleng', 'KT', 1),
(434, 28, 'Kweneng', 'KW', 1),
(435, 28, 'Ngamiland', 'NG', 1),
(436, 28, 'North East', 'NE', 1),
(437, 28, 'North West', 'NW', 1),
(438, 28, 'South East', 'SE', 1),
(439, 28, 'Southern', 'SO', 1),
(440, 30, 'Acre', 'AC', 1),
(441, 30, 'Alagoas', 'AL', 1),
(442, 30, 'Amapá', 'AP', 1),
(443, 30, 'Amazonas', 'AM', 1),
(444, 30, 'Bahia', 'BA', 1),
(445, 30, 'Ceará', 'CE', 1),
(446, 30, 'Distrito Federal', 'DF', 1),
(447, 30, 'Espírito Santo', 'ES', 1),
(448, 30, 'Goiás', 'GO', 1),
(449, 30, 'Maranhão', 'MA', 1),
(450, 30, 'Mato Grosso', 'MT', 1),
(451, 30, 'Mato Grosso do Sul', 'MS', 1),
(452, 30, 'Minas Gerais', 'MG', 1),
(453, 30, 'Pará', 'PA', 1),
(454, 30, 'Paraíba', 'PB', 1),
(455, 30, 'Paraná', 'PR', 1),
(456, 30, 'Pernambuco', 'PE', 1),
(457, 30, 'Piauí', 'PI', 1),
(458, 30, 'Rio de Janeiro', 'RJ', 1),
(459, 30, 'Rio Grande do Norte', 'RN', 1),
(460, 30, 'Rio Grande do Sul', 'RS', 1),
(461, 30, 'Rondônia', 'RO', 1),
(462, 30, 'Roraima', 'RR', 1),
(463, 30, 'Santa Catarina', 'SC', 1),
(464, 30, 'São Paulo', 'SP', 1),
(465, 30, 'Sergipe', 'SE', 1),
(466, 30, 'Tocantins', 'TO', 1),
(467, 31, 'Peros Banhos', 'PB', 1),
(468, 31, 'Salomon Islands', 'SI', 1),
(469, 31, 'Nelsons Island', 'NI', 1),
(470, 31, 'Three Brothers', 'TB', 1),
(471, 31, 'Eagle Islands', 'EA', 1),
(472, 31, 'Danger Island', 'DI', 1),
(473, 31, 'Egmont Islands', 'EG', 1),
(474, 31, 'Diego Garcia', 'DG', 1),
(475, 32, 'Belait', 'BEL', 1),
(476, 32, 'Brunei and Muara', 'BRM', 1),
(477, 32, 'Temburong', 'TEM', 1),
(478, 32, 'Tutong', 'TUT', 1),
(479, 33, 'Blagoevgrad', '', 1),
(480, 33, 'Burgas', '', 1),
(481, 33, 'Dobrich', '', 1),
(482, 33, 'Gabrovo', '', 1),
(483, 33, 'Haskovo', '', 1),
(484, 33, 'Kardjali', '', 1),
(485, 33, 'Kyustendil', '', 1),
(486, 33, 'Lovech', '', 1),
(487, 33, 'Montana', '', 1),
(488, 33, 'Pazardjik', '', 1),
(489, 33, 'Pernik', '', 1),
(490, 33, 'Pleven', '', 1),
(491, 33, 'Plovdiv', '', 1),
(492, 33, 'Razgrad', '', 1),
(493, 33, 'Shumen', '', 1),
(494, 33, 'Silistra', '', 1),
(495, 33, 'Sliven', '', 1),
(496, 33, 'Smolyan', '', 1),
(497, 33, 'Sofia', '', 1),
(498, 33, 'Sofia - town', '', 1),
(499, 33, 'Stara Zagora', '', 1),
(500, 33, 'Targovishte', '', 1),
(501, 33, 'Varna', '', 1),
(502, 33, 'Veliko Tarnovo', '', 1),
(503, 33, 'Vidin', '', 1),
(504, 33, 'Vratza', '', 1),
(505, 33, 'Yambol', '', 1),
(506, 34, 'Bale', 'BAL', 1),
(507, 34, 'Bam', 'BAM', 1),
(508, 34, 'Banwa', 'BAN', 1),
(509, 34, 'Bazega', 'BAZ', 1),
(510, 34, 'Bougouriba', 'BOR', 1),
(511, 34, 'Boulgou', 'BLG', 1),
(512, 34, 'Boulkiemde', 'BOK', 1),
(513, 34, 'Comoe', 'COM', 1),
(514, 34, 'Ganzourgou', 'GAN', 1),
(515, 34, 'Gnagna', 'GNA', 1),
(516, 34, 'Gourma', 'GOU', 1),
(517, 34, 'Houet', 'HOU', 1),
(518, 34, 'Ioba', 'IOA', 1),
(519, 34, 'Kadiogo', 'KAD', 1),
(520, 34, 'Kenedougou', 'KEN', 1),
(521, 34, 'Komondjari', 'KOD', 1),
(522, 34, 'Kompienga', 'KOP', 1),
(523, 34, 'Kossi', 'KOS', 1),
(524, 34, 'Koulpelogo', 'KOL', 1),
(525, 34, 'Kouritenga', 'KOT', 1),
(526, 34, 'Kourweogo', 'KOW', 1),
(527, 34, 'Leraba', 'LER', 1),
(528, 34, 'Loroum', 'LOR', 1),
(529, 34, 'Mouhoun', 'MOU', 1),
(530, 34, 'Nahouri', 'NAH', 1),
(531, 34, 'Namentenga', 'NAM', 1),
(532, 34, 'Nayala', 'NAY', 1),
(533, 34, 'Noumbiel', 'NOU', 1),
(534, 34, 'Oubritenga', 'OUB', 1),
(535, 34, 'Oudalan', 'OUD', 1),
(536, 34, 'Passore', 'PAS', 1),
(537, 34, 'Poni', 'PON', 1),
(538, 34, 'Sanguie', 'SAG', 1),
(539, 34, 'Sanmatenga', 'SAM', 1),
(540, 34, 'Seno', 'SEN', 1),
(541, 34, 'Sissili', 'SIS', 1),
(542, 34, 'Soum', 'SOM', 1),
(543, 34, 'Sourou', 'SOR', 1),
(544, 34, 'Tapoa', 'TAP', 1),
(545, 34, 'Tuy', 'TUY', 1),
(546, 34, 'Yagha', 'YAG', 1),
(547, 34, 'Yatenga', 'YAT', 1),
(548, 34, 'Ziro', 'ZIR', 1),
(549, 34, 'Zondoma', 'ZOD', 1),
(550, 34, 'Zoundweogo', 'ZOW', 1),
(551, 35, 'Bubanza', 'BB', 1),
(552, 35, 'Bujumbura', 'BJ', 1),
(553, 35, 'Bururi', 'BR', 1),
(554, 35, 'Cankuzo', 'CA', 1),
(555, 35, 'Cibitoke', 'CI', 1),
(556, 35, 'Gitega', 'GI', 1),
(557, 35, 'Karuzi', 'KR', 1),
(558, 35, 'Kayanza', 'KY', 1),
(559, 35, 'Kirundo', 'KI', 1),
(560, 35, 'Makamba', 'MA', 1),
(561, 35, 'Muramvya', 'MU', 1),
(562, 35, 'Muyinga', 'MY', 1),
(563, 35, 'Mwaro', 'MW', 1),
(564, 35, 'Ngozi', 'NG', 1),
(565, 35, 'Rutana', 'RT', 1),
(566, 35, 'Ruyigi', 'RY', 1),
(567, 36, 'Phnom Penh', 'PP', 1),
(568, 36, 'Preah Seihanu (Kompong Som or Sihanoukville)', 'PS', 1),
(569, 36, 'Pailin', 'PA', 1),
(570, 36, 'Keb', 'KB', 1),
(571, 36, 'Banteay Meanchey', 'BM', 1),
(572, 36, 'Battambang', 'BA', 1),
(573, 36, 'Kampong Cham', 'KM', 1),
(574, 36, 'Kampong Chhnang', 'KN', 1),
(575, 36, 'Kampong Speu', 'KU', 1),
(576, 36, 'Kampong Som', 'KO', 1),
(577, 36, 'Kampong Thom', 'KT', 1),
(578, 36, 'Kampot', 'KP', 1),
(579, 36, 'Kandal', 'KL', 1),
(580, 36, 'Kaoh Kong', 'KK', 1),
(581, 36, 'Kratie', 'KR', 1),
(582, 36, 'Mondul Kiri', 'MK', 1),
(583, 36, 'Oddar Meancheay', 'OM', 1),
(584, 36, 'Pursat', 'PU', 1),
(585, 36, 'Preah Vihear', 'PR', 1),
(586, 36, 'Prey Veng', 'PG', 1),
(587, 36, 'Ratanak Kiri', 'RK', 1),
(588, 36, 'Siemreap', 'SI', 1),
(589, 36, 'Stung Treng', 'ST', 1),
(590, 36, 'Svay Rieng', 'SR', 1),
(591, 36, 'Takeo', 'TK', 1),
(592, 37, 'Adamawa (Adamaoua)', 'ADA', 1),
(593, 37, 'Centre', 'CEN', 1),
(594, 37, 'East (Est)', 'EST', 1),
(595, 37, 'Extreme North (Extreme-Nord)', 'EXN', 1),
(596, 37, 'Littoral', 'LIT', 1),
(597, 37, 'North (Nord)', 'NOR', 1),
(598, 37, 'Northwest (Nord-Ouest)', 'NOT', 1),
(599, 37, 'West (Ouest)', 'OUE', 1),
(600, 37, 'South (Sud)', 'SUD', 1),
(601, 37, 'Southwest (Sud-Ouest).', 'SOU', 1),
(602, 38, 'Alberta', 'AB', 1),
(603, 38, 'British Columbia', 'BC', 1),
(604, 38, 'Manitoba', 'MB', 1),
(605, 38, 'New Brunswick', 'NB', 1),
(606, 38, 'Newfoundland and Labrador', 'NL', 1),
(607, 38, 'Northwest Territories', 'NT', 1),
(608, 38, 'Nova Scotia', 'NS', 1),
(609, 38, 'Nunavut', 'NU', 1),
(610, 38, 'Ontario', 'ON', 1),
(611, 38, 'Prince Edward Island', 'PE', 1),
(612, 38, 'Québec', 'QC', 1),
(613, 38, 'Saskatchewan', 'SK', 1),
(614, 38, 'Yukon Territory', 'YT', 1),
(615, 39, 'Boa Vista', 'BV', 1),
(616, 39, 'Brava', 'BR', 1),
(617, 39, 'Calheta de Sao Miguel', 'CS', 1),
(618, 39, 'Maio', 'MA', 1),
(619, 39, 'Mosteiros', 'MO', 1),
(620, 39, 'Paul', 'PA', 1),
(621, 39, 'Porto Novo', 'PN', 1),
(622, 39, 'Praia', 'PR', 1),
(623, 39, 'Ribeira Grande', 'RG', 1),
(624, 39, 'Sal', 'SL', 1),
(625, 39, 'Santa Catarina', 'CA', 1),
(626, 39, 'Santa Cruz', 'CR', 1),
(627, 39, 'Sao Domingos', 'SD', 1),
(628, 39, 'Sao Filipe', 'SF', 1),
(629, 39, 'Sao Nicolau', 'SN', 1),
(630, 39, 'Sao Vicente', 'SV', 1),
(631, 39, 'Tarrafal', 'TA', 1),
(632, 40, 'Creek', 'CR', 1),
(633, 40, 'Eastern', 'EA', 1),
(634, 40, 'Midland', 'ML', 1),
(635, 40, 'South Town', 'ST', 1),
(636, 40, 'Spot Bay', 'SP', 1),
(637, 40, 'Stake Bay', 'SK', 1),
(638, 40, 'West End', 'WD', 1),
(639, 40, 'Western', 'WN', 1),
(640, 41, 'Bamingui-Bangoran', 'BBA', 1),
(641, 41, 'Basse-Kotto', 'BKO', 1),
(642, 41, 'Haute-Kotto', 'HKO', 1),
(643, 41, 'Haut-Mbomou', 'HMB', 1),
(644, 41, 'Kemo', 'KEM', 1),
(645, 41, 'Lobaye', 'LOB', 1),
(646, 41, 'Mambere-KadeÔ', 'MKD', 1),
(647, 41, 'Mbomou', 'MBO', 1),
(648, 41, 'Nana-Mambere', 'NMM', 1),
(649, 41, 'Ombella-M Poko', 'OMP', 1),
(650, 41, 'Ouaka', 'OUK', 1),
(651, 41, 'Ouham', 'OUH', 1),
(652, 41, 'Ouham-Pende', 'OPE', 1),
(653, 41, 'Vakaga', 'VAK', 1),
(654, 41, 'Nana-Grebizi', 'NGR', 1),
(655, 41, 'Sangha-Mbaere', 'SMB', 1),
(656, 41, 'Bangui', 'BAN', 1),
(657, 42, 'Batha', 'BA', 1),
(658, 42, 'Biltine', 'BI', 1),
(659, 42, 'Borkou-Ennedi-Tibesti', 'BE', 1),
(660, 42, 'Chari-Baguirmi', 'CB', 1),
(661, 42, 'Guera', 'GU', 1),
(662, 42, 'Kanem', 'KA', 1),
(663, 42, 'Lac', 'LA', 1),
(664, 42, 'Logone Occidental', 'LC', 1),
(665, 42, 'Logone Oriental', 'LR', 1),
(666, 42, 'Mayo-Kebbi', 'MK', 1),
(667, 42, 'Moyen-Chari', 'MC', 1),
(668, 42, 'Ouaddai', 'OU', 1),
(669, 42, 'Salamat', 'SA', 1),
(670, 42, 'Tandjile', 'TA', 1),
(671, 43, 'Aisen del General Carlos Ibanez', 'AI', 1),
(672, 43, 'Antofagasta', 'AN', 1),
(673, 43, 'Araucania', 'AR', 1),
(674, 43, 'Atacama', 'AT', 1),
(675, 43, 'Bio-Bio', 'BI', 1),
(676, 43, 'Coquimbo', 'CO', 1),
(677, 43, 'Libertador General Bernardo O Higgins', 'LI', 1),
(678, 43, 'Los Lagos', 'LL', 1),
(679, 43, 'Magallanes y de la Antartica Chilena', 'MA', 1),
(680, 43, 'Maule', 'ML', 1),
(681, 43, 'Region Metropolitana', 'RM', 1),
(682, 43, 'Tarapaca', 'TA', 1),
(683, 43, 'Valparaiso', 'VS', 1),
(684, 44, 'Anhui', 'AN', 1),
(685, 44, 'Beijing', 'BE', 1),
(686, 44, 'Chongqing', 'CH', 1),
(687, 44, 'Fujian', 'FU', 1),
(688, 44, 'Gansu', 'GA', 1),
(689, 44, 'Guangdong', 'GU', 1),
(690, 44, 'Guangxi', 'GX', 1),
(691, 44, 'Guizhou', 'GZ', 1),
(692, 44, 'Hainan', 'HA', 1),
(693, 44, 'Hebei', 'HB', 1),
(694, 44, 'Heilongjiang', 'HL', 1),
(695, 44, 'Henan', 'HE', 1),
(696, 44, 'Hong Kong', 'HK', 1),
(697, 44, 'Hubei', 'HU', 1),
(698, 44, 'Hunan', 'HN', 1),
(699, 44, 'Inner Mongolia', 'IM', 1),
(700, 44, 'Jiangsu', 'JI', 1),
(701, 44, 'Jiangxi', 'JX', 1),
(702, 44, 'Jilin', 'JL', 1),
(703, 44, 'Liaoning', 'LI', 1),
(704, 44, 'Macau', 'MA', 1),
(705, 44, 'Ningxia', 'NI', 1),
(706, 44, 'Shaanxi', 'SH', 1),
(707, 44, 'Shandong', 'SA', 1),
(708, 44, 'Shanghai', 'SG', 1),
(709, 44, 'Shanxi', 'SX', 1),
(710, 44, 'Sichuan', 'SI', 1),
(711, 44, 'Tianjin', 'TI', 1),
(712, 44, 'Xinjiang', 'XI', 1),
(713, 44, 'Yunnan', 'YU', 1),
(714, 44, 'Zhejiang', 'ZH', 1),
(715, 46, 'Direction Island', 'D', 1),
(716, 46, 'Home Island', 'H', 1),
(717, 46, 'Horsburgh Island', 'O', 1),
(718, 46, 'South Island', 'S', 1),
(719, 46, 'West Island', 'W', 1),
(720, 47, 'Amazonas', 'AMZ', 1),
(721, 47, 'Antioquia', 'ANT', 1),
(722, 47, 'Arauca', 'ARA', 1),
(723, 47, 'Atlantico', 'ATL', 1),
(724, 47, 'Bogota D.C.', 'BDC', 1),
(725, 47, 'Bolivar', 'BOL', 1),
(726, 47, 'Boyaca', 'BOY', 1),
(727, 47, 'Caldas', 'CAL', 1),
(728, 47, 'Caqueta', 'CAQ', 1),
(729, 47, 'Casanare', 'CAS', 1),
(730, 47, 'Cauca', 'CAU', 1),
(731, 47, 'Cesar', 'CES', 1),
(732, 47, 'Choco', 'CHO', 1),
(733, 47, 'Cordoba', 'COR', 1),
(734, 47, 'Cundinamarca', 'CAM', 1),
(735, 47, 'Guainia', 'GNA', 1),
(736, 47, 'Guajira', 'GJR', 1),
(737, 47, 'Guaviare', 'GVR', 1),
(738, 47, 'Huila', 'HUI', 1),
(739, 47, 'Magdalena', 'MAG', 1),
(740, 47, 'Meta', 'MET', 1),
(741, 47, 'Narino', 'NAR', 1),
(742, 47, 'Norte de Santander', 'NDS', 1),
(743, 47, 'Putumayo', 'PUT', 1),
(744, 47, 'Quindio', 'QUI', 1),
(745, 47, 'Risaralda', 'RIS', 1),
(746, 47, 'San Andres y Providencia', 'SAP', 1),
(747, 47, 'Santander', 'SAN', 1),
(748, 47, 'Sucre', 'SUC', 1),
(749, 47, 'Tolima', 'TOL', 1),
(750, 47, 'Valle del Cauca', 'VDC', 1),
(751, 47, 'Vaupes', 'VAU', 1),
(752, 47, 'Vichada', 'VIC', 1),
(753, 48, 'Grande Comore', 'G', 1),
(754, 48, 'Anjouan', 'A', 1),
(755, 48, 'Moheli', 'M', 1),
(756, 49, 'Bouenza', 'BO', 1),
(757, 49, 'Brazzaville', 'BR', 1),
(758, 49, 'Cuvette', 'CU', 1),
(759, 49, 'Cuvette-Ouest', 'CO', 1),
(760, 49, 'Kouilou', 'KO', 1),
(761, 49, 'Lekoumou', 'LE', 1),
(762, 49, 'Likouala', 'LI', 1),
(763, 49, 'Niari', 'NI', 1),
(764, 49, 'Plateaux', 'PL', 1),
(765, 49, 'Pool', 'PO', 1),
(766, 49, 'Sangha', 'SA', 1),
(767, 50, 'Pukapuka', 'PU', 1),
(768, 50, 'Rakahanga', 'RK', 1),
(769, 50, 'Manihiki', 'MK', 1),
(770, 50, 'Penrhyn', 'PE', 1),
(771, 50, 'Nassau Island', 'NI', 1),
(772, 50, 'Surwarrow', 'SU', 1),
(773, 50, 'Palmerston', 'PA', 1),
(774, 50, 'Aitutaki', 'AI', 1),
(775, 50, 'Manuae', 'MA', 1),
(776, 50, 'Takutea', 'TA', 1),
(777, 50, 'Mitiaro', 'MT', 1),
(778, 50, 'Atiu', 'AT', 1),
(779, 50, 'Mauke', 'MU', 1),
(780, 50, 'Rarotonga', 'RR', 1),
(781, 50, 'Mangaia', 'MG', 1),
(782, 51, 'Alajuela', 'AL', 1),
(783, 51, 'Cartago', 'CA', 1),
(784, 51, 'Guanacaste', 'GU', 1),
(785, 51, 'Heredia', 'HE', 1),
(786, 51, 'Limon', 'LI', 1),
(787, 51, 'Puntarenas', 'PU', 1),
(788, 51, 'San Jose', 'SJ', 1),
(789, 52, 'Abengourou', 'ABE', 1),
(790, 52, 'Abidjan', 'ABI', 1),
(791, 52, 'Aboisso', 'ABO', 1),
(792, 52, 'Adiake', 'ADI', 1),
(793, 52, 'Adzope', 'ADZ', 1),
(794, 52, 'Agboville', 'AGB', 1),
(795, 52, 'Agnibilekrou', 'AGN', 1),
(796, 52, 'Alepe', 'ALE', 1),
(797, 52, 'Bocanda', 'BOC', 1),
(798, 52, 'Bangolo', 'BAN', 1),
(799, 52, 'Beoumi', 'BEO', 1),
(800, 52, 'Biankouma', 'BIA', 1),
(801, 52, 'Bondoukou', 'BDK', 1),
(802, 52, 'Bongouanou', 'BGN', 1),
(803, 52, 'Bouafle', 'BFL', 1),
(804, 52, 'Bouake', 'BKE', 1),
(805, 52, 'Bouna', 'BNA', 1),
(806, 52, 'Boundiali', 'BDL', 1),
(807, 52, 'Dabakala', 'DKL', 1),
(808, 52, 'Dabou', 'DBU', 1),
(809, 52, 'Daloa', 'DAL', 1),
(810, 52, 'Danane', 'DAN', 1),
(811, 52, 'Daoukro', 'DAO', 1),
(812, 52, 'Dimbokro', 'DIM', 1),
(813, 52, 'Divo', 'DIV', 1),
(814, 52, 'Duekoue', 'DUE', 1),
(815, 52, 'Ferkessedougou', 'FER', 1),
(816, 52, 'Gagnoa', 'GAG', 1),
(817, 52, 'Grand-Bassam', 'GBA', 1),
(818, 52, 'Grand-Lahou', 'GLA', 1),
(819, 52, 'Guiglo', 'GUI', 1),
(820, 52, 'Issia', 'ISS', 1),
(821, 52, 'Jacqueville', 'JAC', 1),
(822, 52, 'Katiola', 'KAT', 1),
(823, 52, 'Korhogo', 'KOR', 1),
(824, 52, 'Lakota', 'LAK', 1),
(825, 52, 'Man', 'MAN', 1),
(826, 52, 'Mankono', 'MKN', 1),
(827, 52, 'Mbahiakro', 'MBA', 1),
(828, 52, 'Odienne', 'ODI', 1),
(829, 52, 'Oume', 'OUM', 1),
(830, 52, 'Sakassou', 'SAK', 1),
(831, 52, 'San-Pedro', 'SPE', 1),
(832, 52, 'Sassandra', 'SAS', 1),
(833, 52, 'Seguela', 'SEG', 1),
(834, 52, 'Sinfra', 'SIN', 1),
(835, 52, 'Soubre', 'SOU', 1),
(836, 52, 'Tabou', 'TAB', 1),
(837, 52, 'Tanda', 'TAN', 1),
(838, 52, 'Tiebissou', 'TIE', 1),
(839, 52, 'Tingrela', 'TIN', 1),
(840, 52, 'Tiassale', 'TIA', 1),
(841, 52, 'Touba', 'TBA', 1),
(842, 52, 'Toulepleu', 'TLP', 1),
(843, 52, 'Toumodi', 'TMD', 1),
(844, 52, 'Vavoua', 'VAV', 1),
(845, 52, 'Yamoussoukro', 'YAM', 1),
(846, 52, 'Zuenoula', 'ZUE', 1),
(847, 53, 'Bjelovarsko-bilogorska', 'BB', 1),
(848, 53, 'Grad Zagreb', 'GZ', 1),
(849, 53, 'Dubrovačko-neretvanska', 'DN', 1),
(850, 53, 'Istarska', 'IS', 1),
(851, 53, 'Karlovačka', 'KA', 1),
(852, 53, 'Koprivničko-križevačka', 'KK', 1),
(853, 53, 'Krapinsko-zagorska', 'KZ', 1),
(854, 53, 'Ličko-senjska', 'LS', 1),
(855, 53, 'Međimurska', 'ME', 1),
(856, 53, 'Osječko-baranjska', 'OB', 1),
(857, 53, 'Požeško-slavonska', 'PS', 1),
(858, 53, 'Primorsko-goranska', 'PG', 1),
(859, 53, 'Šibensko-kninska', 'SK', 1),
(860, 53, 'Sisačko-moslavačka', 'SM', 1),
(861, 53, 'Brodsko-posavska', 'BP', 1),
(862, 53, 'Splitsko-dalmatinska', 'SD', 1),
(863, 53, 'Varaždinska', 'VA', 1),
(864, 53, 'Virovitičko-podravska', 'VP', 1),
(865, 53, 'Vukovarsko-srijemska', 'VS', 1),
(866, 53, 'Zadarska', 'ZA', 1),
(867, 53, 'Zagrebačka', 'ZG', 1),
(868, 54, 'Camaguey', 'CA', 1),
(869, 54, 'Ciego de Avila', 'CD', 1),
(870, 54, 'Cienfuegos', 'CI', 1),
(871, 54, 'Ciudad de La Habana', 'CH', 1),
(872, 54, 'Granma', 'GR', 1),
(873, 54, 'Guantanamo', 'GU', 1),
(874, 54, 'Holguin', 'HO', 1),
(875, 54, 'Isla de la Juventud', 'IJ', 1),
(876, 54, 'La Habana', 'LH', 1),
(877, 54, 'Las Tunas', 'LT', 1),
(878, 54, 'Matanzas', 'MA', 1),
(879, 54, 'Pinar del Rio', 'PR', 1),
(880, 54, 'Sancti Spiritus', 'SS', 1),
(881, 54, 'Santiago de Cuba', 'SC', 1),
(882, 54, 'Villa Clara', 'VC', 1),
(883, 55, 'Famagusta', 'F', 1),
(884, 55, 'Kyrenia', 'K', 1),
(885, 55, 'Larnaca', 'A', 1),
(886, 55, 'Limassol', 'I', 1),
(887, 55, 'Nicosia', 'N', 1),
(888, 55, 'Paphos', 'P', 1),
(889, 56, 'Ústecký', 'U', 1),
(890, 56, 'Jihočeský', 'C', 1),
(891, 56, 'Jihomoravský', 'B', 1),
(892, 56, 'Karlovarský', 'K', 1),
(893, 56, 'Královehradecký', 'H', 1),
(894, 56, 'Liberecký', 'L', 1),
(895, 56, 'Moravskoslezský', 'T', 1),
(896, 56, 'Olomoucký', 'M', 1),
(897, 56, 'Pardubický', 'E', 1),
(898, 56, 'Plzeňský', 'P', 1),
(899, 56, 'Praha', 'A', 1),
(900, 56, 'Středočeský', 'S', 1),
(901, 56, 'Vysočina', 'J', 1),
(902, 56, 'Zlínský', 'Z', 1),
(903, 57, 'Arhus', 'AR', 1),
(904, 57, 'Bornholm', 'BH', 1),
(905, 57, 'Copenhagen', 'CO', 1),
(906, 57, 'Faroe Islands', 'FO', 1),
(907, 57, 'Frederiksborg', 'FR', 1),
(908, 57, 'Fyn', 'FY', 1),
(909, 57, 'Kobenhavn', 'KO', 1),
(910, 57, 'Nordjylland', 'NO', 1),
(911, 57, 'Ribe', 'RI', 1),
(912, 57, 'Ringkobing', 'RK', 1),
(913, 57, 'Roskilde', 'RO', 1),
(914, 57, 'Sonderjylland', 'SO', 1),
(915, 57, 'Storstrom', 'ST', 1),
(916, 57, 'Vejle', 'VK', 1),
(917, 57, 'Vestjælland', 'VJ', 1),
(918, 57, 'Viborg', 'VB', 1),
(919, 58, ' Ali Sabih', 'S', 1),
(920, 58, 'Dikhil', 'K', 1),
(921, 58, 'Djibouti', 'J', 1),
(922, 58, 'Obock', 'O', 1),
(923, 58, 'Tadjoura', 'T', 1),
(924, 59, 'Saint Andrew Parish', 'AND', 1),
(925, 59, 'Saint David Parish', 'DAV', 1),
(926, 59, 'Saint George Parish', 'GEO', 1),
(927, 59, 'Saint John Parish', 'JOH', 1),
(928, 59, 'Saint Joseph Parish', 'JOS', 1),
(929, 59, 'Saint Luke Parish', 'LUK', 1),
(930, 59, 'Saint Mark Parish', 'MAR', 1),
(931, 59, 'Saint Patrick Parish', 'PAT', 1),
(932, 59, 'Saint Paul Parish', 'PAU', 1),
(933, 59, 'Saint Peter Parish', 'PET', 1),
(934, 60, 'Distrito Nacional', 'DN', 1),
(935, 60, 'Azua', 'AZ', 1),
(936, 60, 'Baoruco', 'BC', 1),
(937, 60, 'Barahona', 'BH', 1),
(938, 60, 'Dajabon', 'DJ', 1),
(939, 60, 'Duarte', 'DU', 1),
(940, 60, 'Elias Pina', 'EL', 1),
(941, 60, 'El Seybo', 'SY', 1),
(942, 60, 'Espaillat', 'ET', 1),
(943, 60, 'Hato Mayor', 'HM', 1),
(944, 60, 'Independencia', 'IN', 1),
(945, 60, 'La Altagracia', 'AL', 1),
(946, 60, 'La Romana', 'RO', 1),
(947, 60, 'La Vega', 'VE', 1),
(948, 60, 'Maria Trinidad Sanchez', 'MT', 1),
(949, 60, 'Monsenor Nouel', 'MN', 1),
(950, 60, 'Monte Cristi', 'MC', 1),
(951, 60, 'Monte Plata', 'MP', 1),
(952, 60, 'Pedernales', 'PD', 1),
(953, 60, 'Peravia (Bani)', 'PR', 1),
(954, 60, 'Puerto Plata', 'PP', 1),
(955, 60, 'Salcedo', 'SL', 1),
(956, 60, 'Samana', 'SM', 1),
(957, 60, 'Sanchez Ramirez', 'SH', 1),
(958, 60, 'San Cristobal', 'SC', 1),
(959, 60, 'San Jose de Ocoa', 'JO', 1),
(960, 60, 'San Juan', 'SJ', 1),
(961, 60, 'San Pedro de Macoris', 'PM', 1),
(962, 60, 'Santiago', 'SA', 1),
(963, 60, 'Santiago Rodriguez', 'ST', 1),
(964, 60, 'Santo Domingo', 'SD', 1),
(965, 60, 'Valverde', 'VA', 1),
(966, 61, 'Aileu', 'AL', 1),
(967, 61, 'Ainaro', 'AN', 1),
(968, 61, 'Baucau', 'BA', 1),
(969, 61, 'Bobonaro', 'BO', 1),
(970, 61, 'Cova Lima', 'CO', 1),
(971, 61, 'Dili', 'DI', 1),
(972, 61, 'Ermera', 'ER', 1),
(973, 61, 'Lautem', 'LA', 1),
(974, 61, 'Liquica', 'LI', 1),
(975, 61, 'Manatuto', 'MT', 1),
(976, 61, 'Manufahi', 'MF', 1),
(977, 61, 'Oecussi', 'OE', 1),
(978, 61, 'Viqueque', 'VI', 1),
(979, 62, 'Azuay', 'AZU', 1),
(980, 62, 'Bolivar', 'BOL', 1),
(981, 62, 'Cañar', 'CAN', 1),
(982, 62, 'Carchi', 'CAR', 1),
(983, 62, 'Chimborazo', 'CHI', 1),
(984, 62, 'Cotopaxi', 'COT', 1),
(985, 62, 'El Oro', 'EOR', 1),
(986, 62, 'Esmeraldas', 'ESM', 1),
(987, 62, 'Galápagos', 'GPS', 1),
(988, 62, 'Guayas', 'GUA', 1),
(989, 62, 'Imbabura', 'IMB', 1),
(990, 62, 'Loja', 'LOJ', 1),
(991, 62, 'Los Rios', 'LRO', 1),
(992, 62, 'Manabí', 'MAN', 1),
(993, 62, 'Morona Santiago', 'MSA', 1),
(994, 62, 'Napo', 'NAP', 1),
(995, 62, 'Orellana', 'ORE', 1),
(996, 62, 'Pastaza', 'PAS', 1),
(997, 62, 'Pichincha', 'PIC', 1),
(998, 62, 'Sucumbíos', 'SUC', 1),
(999, 62, 'Tungurahua', 'TUN', 1),
(1000, 62, 'Zamora Chinchipe', 'ZCH', 1),
(1001, 63, 'Ad Daqahliyah', 'DHY', 1),
(1002, 63, 'Al Bahr al Ahmar', 'BAM', 1),
(1003, 63, 'Al Buhayrah', 'BHY', 1),
(1004, 63, 'Al Fayyum', 'FYM', 1),
(1005, 63, 'Al Gharbiyah', 'GBY', 1),
(1006, 63, 'Al Iskandariyah', 'IDR', 1),
(1007, 63, 'Al Isma iliyah', 'IML', 1),
(1008, 63, 'Al Jizah', 'JZH', 1),
(1009, 63, 'Al Minufiyah', 'MFY', 1),
(1010, 63, 'Al Minya', 'MNY', 1),
(1011, 63, 'Al Qahirah', 'QHR', 1),
(1012, 63, 'Al Qalyubiyah', 'QLY', 1),
(1013, 63, 'Al Wadi al Jadid', 'WJD', 1),
(1014, 63, 'Ash Sharqiyah', 'SHQ', 1),
(1015, 63, 'As Suways', 'SWY', 1),
(1016, 63, 'Aswan', 'ASW', 1),
(1017, 63, 'Asyut', 'ASY', 1),
(1018, 63, 'Bani Suwayf', 'BSW', 1),
(1019, 63, 'Bur Sa id', 'BSD', 1),
(1020, 63, 'Dumyat', 'DMY', 1),
(1021, 63, 'Janub Sina ', 'JNS', 1),
(1022, 63, 'Kafr ash Shaykh', 'KSH', 1),
(1023, 63, 'Matruh', 'MAT', 1),
(1024, 63, 'Qina', 'QIN', 1),
(1025, 63, 'Shamal Sina ', 'SHS', 1),
(1026, 63, 'Suhaj', 'SUH', 1),
(1027, 64, 'Ahuachapan', 'AH', 1),
(1028, 64, 'Cabanas', 'CA', 1),
(1029, 64, 'Chalatenango', 'CH', 1),
(1030, 64, 'Cuscatlan', 'CU', 1),
(1031, 64, 'La Libertad', 'LB', 1),
(1032, 64, 'La Paz', 'PZ', 1),
(1033, 64, 'La Union', 'UN', 1),
(1034, 64, 'Morazan', 'MO', 1),
(1035, 64, 'San Miguel', 'SM', 1),
(1036, 64, 'San Salvador', 'SS', 1),
(1037, 64, 'San Vicente', 'SV', 1),
(1038, 64, 'Santa Ana', 'SA', 1),
(1039, 64, 'Sonsonate', 'SO', 1),
(1040, 64, 'Usulutan', 'US', 1),
(1041, 65, 'Provincia Annobon', 'AN', 1),
(1042, 65, 'Provincia Bioko Norte', 'BN', 1),
(1043, 65, 'Provincia Bioko Sur', 'BS', 1),
(1044, 65, 'Provincia Centro Sur', 'CS', 1),
(1045, 65, 'Provincia Kie-Ntem', 'KN', 1),
(1046, 65, 'Provincia Litoral', 'LI', 1),
(1047, 65, 'Provincia Wele-Nzas', 'WN', 1),
(1048, 66, 'Central (Maekel)', 'MA', 1),
(1049, 66, 'Anseba (Keren)', 'KE', 1),
(1050, 66, 'Southern Red Sea (Debub-Keih-Bahri)', 'DK', 1),
(1051, 66, 'Northern Red Sea (Semien-Keih-Bahri)', 'SK', 1),
(1052, 66, 'Southern (Debub)', 'DE', 1),
(1053, 66, 'Gash-Barka (Barentu)', 'BR', 1),
(1054, 67, 'Harjumaa (Tallinn)', 'HA', 1),
(1055, 67, 'Hiiumaa (Kardla)', 'HI', 1),
(1056, 67, 'Ida-Virumaa (Johvi)', 'IV', 1),
(1057, 67, 'Jarvamaa (Paide)', 'JA', 1),
(1058, 67, 'Jogevamaa (Jogeva)', 'JO', 1),
(1059, 67, 'Laane-Virumaa (Rakvere)', 'LV', 1),
(1060, 67, 'Laanemaa (Haapsalu)', 'LA', 1),
(1061, 67, 'Parnumaa (Parnu)', 'PA', 1),
(1062, 67, 'Polvamaa (Polva)', 'PO', 1),
(1063, 67, 'Raplamaa (Rapla)', 'RA', 1),
(1064, 67, 'Saaremaa (Kuessaare)', 'SA', 1),
(1065, 67, 'Tartumaa (Tartu)', 'TA', 1),
(1066, 67, 'Valgamaa (Valga)', 'VA', 1),
(1067, 67, 'Viljandimaa (Viljandi)', 'VI', 1),
(1068, 67, 'Vorumaa (Voru)', 'VO', 1),
(1069, 68, 'Afar', 'AF', 1),
(1070, 68, 'Amhara', 'AH', 1),
(1071, 68, 'Benishangul-Gumaz', 'BG', 1),
(1072, 68, 'Gambela', 'GB', 1),
(1073, 68, 'Hariai', 'HR', 1),
(1074, 68, 'Oromia', 'OR', 1),
(1075, 68, 'Somali', 'SM', 1),
(1076, 68, 'Southern Nations - Nationalities and Peoples Region', 'SN', 1),
(1077, 68, 'Tigray', 'TG', 1),
(1078, 68, 'Addis Ababa', 'AA', 1),
(1079, 68, 'Dire Dawa', 'DD', 1),
(1080, 71, 'Central Division', 'C', 1),
(1081, 71, 'Northern Division', 'N', 1),
(1082, 71, 'Eastern Division', 'E', 1),
(1083, 71, 'Western Division', 'W', 1),
(1084, 71, 'Rotuma', 'R', 1),
(1085, 72, 'Ahvenanmaan lääni', 'AL', 1),
(1086, 72, 'Etelä-Suomen lääni', 'ES', 1),
(1087, 72, 'Itä-Suomen lääni', 'IS', 1),
(1088, 72, 'Länsi-Suomen lääni', 'LS', 1),
(1089, 72, 'Lapin lääni', 'LA', 1),
(1090, 72, 'Oulun lääni', 'OU', 1),
(1114, 74, 'Ain', '01', 1),
(1115, 74, 'Aisne', '02', 1),
(1116, 74, 'Allier', '03', 1),
(1117, 74, 'Alpes de Haute Provence', '04', 1),
(1118, 74, 'Hautes-Alpes', '05', 1),
(1119, 74, 'Alpes Maritimes', '06', 1),
(1120, 74, 'Ardèche', '07', 1),
(1121, 74, 'Ardennes', '08', 1),
(1122, 74, 'Ariège', '09', 1),
(1123, 74, 'Aube', '10', 1),
(1124, 74, 'Aude', '11', 1),
(1125, 74, 'Aveyron', '12', 1),
(1126, 74, 'Bouches du Rhône', '13', 1),
(1127, 74, 'Calvados', '14', 1),
(1128, 74, 'Cantal', '15', 1),
(1129, 74, 'Charente', '16', 1),
(1130, 74, 'Charente Maritime', '17', 1),
(1131, 74, 'Cher', '18', 1),
(1132, 74, 'Corrèze', '19', 1),
(1133, 74, 'Corse du Sud', '2A', 1),
(1134, 74, 'Haute Corse', '2B', 1),
(1135, 74, 'Côte d or', '21', 1),
(1136, 74, 'Côtes d Armor', '22', 1),
(1137, 74, 'Creuse', '23', 1),
(1138, 74, 'Dordogne', '24', 1),
(1139, 74, 'Doubs', '25', 1),
(1140, 74, 'Drôme', '26', 1),
(1141, 74, 'Eure', '27', 1),
(1142, 74, 'Eure et Loir', '28', 1),
(1143, 74, 'Finistère', '29', 1),
(1144, 74, 'Gard', '30', 1),
(1145, 74, 'Haute Garonne', '31', 1),
(1146, 74, 'Gers', '32', 1),
(1147, 74, 'Gironde', '33', 1),
(1148, 74, 'Hérault', '34', 1),
(1149, 74, 'Ille et Vilaine', '35', 1),
(1150, 74, 'Indre', '36', 1),
(1151, 74, 'Indre et Loire', '37', 1),
(1152, 74, 'Isére', '38', 1),
(1153, 74, 'Jura', '39', 1),
(1154, 74, 'Landes', '40', 1),
(1155, 74, 'Loir et Cher', '41', 1),
(1156, 74, 'Loire', '42', 1),
(1157, 74, 'Haute Loire', '43', 1),
(1158, 74, 'Loire Atlantique', '44', 1),
(1159, 74, 'Loiret', '45', 1),
(1160, 74, 'Lot', '46', 1),
(1161, 74, 'Lot et Garonne', '47', 1),
(1162, 74, 'Lozère', '48', 1),
(1163, 74, 'Maine et Loire', '49', 1),
(1164, 74, 'Manche', '50', 1),
(1165, 74, 'Marne', '51', 1),
(1166, 74, 'Haute Marne', '52', 1),
(1167, 74, 'Mayenne', '53', 1),
(1168, 74, 'Meurthe et Moselle', '54', 1),
(1169, 74, 'Meuse', '55', 1),
(1170, 74, 'Morbihan', '56', 1),
(1171, 74, 'Moselle', '57', 1),
(1172, 74, 'Nièvre', '58', 1),
(1173, 74, 'Nord', '59', 1),
(1174, 74, 'Oise', '60', 1),
(1175, 74, 'Orne', '61', 1),
(1176, 74, 'Pas de Calais', '62', 1),
(1177, 74, 'Puy de Dôme', '63', 1),
(1178, 74, 'Pyrénées Atlantiques', '64', 1),
(1179, 74, 'Hautes Pyrénées', '65', 1),
(1180, 74, 'Pyrénées Orientales', '66', 1),
(1181, 74, 'Bas Rhin', '67', 1),
(1182, 74, 'Haut Rhin', '68', 1),
(1183, 74, 'Rhône', '69', 1),
(1184, 74, 'Haute Saône', '70', 1),
(1185, 74, 'Saône et Loire', '71', 1),
(1186, 74, 'Sarthe', '72', 1),
(1187, 74, 'Savoie', '73', 1),
(1188, 74, 'Haute Savoie', '74', 1),
(1189, 74, 'Paris', '75', 1),
(1190, 74, 'Seine Maritime', '76', 1),
(1191, 74, 'Seine et Marne', '77', 1),
(1192, 74, 'Yvelines', '78', 1),
(1193, 74, 'Deux Sèvres', '79', 1),
(1194, 74, 'Somme', '80', 1),
(1195, 74, 'Tarn', '81', 1),
(1196, 74, 'Tarn et Garonne', '82', 1),
(1197, 74, 'Var', '83', 1),
(1198, 74, 'Vaucluse', '84', 1),
(1199, 74, 'Vendée', '85', 1),
(1200, 74, 'Vienne', '86', 1),
(1201, 74, 'Haute Vienne', '87', 1),
(1202, 74, 'Vosges', '88', 1),
(1203, 74, 'Yonne', '89', 1),
(1204, 74, 'Territoire de Belfort', '90', 1),
(1205, 74, 'Essonne', '91', 1),
(1206, 74, 'Hauts de Seine', '92', 1),
(1207, 74, 'Seine St-Denis', '93', 1),
(1208, 74, 'Val de Marne', '94', 1),
(1209, 74, 'Val d Oise', '95', 1),
(1210, 76, 'Archipel des Marquises', 'M', 1),
(1211, 76, 'Archipel des Tuamotu', 'T', 1),
(1212, 76, 'Archipel des Tubuai', 'I', 1),
(1213, 76, 'Iles du Vent', 'V', 1),
(1214, 76, 'Iles Sous-le-Vent', 'S', 1),
(1215, 77, 'Iles Crozet', 'C', 1),
(1216, 77, 'Iles Kerguelen', 'K', 1),
(1217, 77, 'Ile Amsterdam', 'A', 1),
(1218, 77, 'Ile Saint-Paul', 'P', 1),
(1219, 77, 'Adelie Land', 'D', 1),
(1220, 78, 'Estuaire', 'ES', 1),
(1221, 78, 'Haut-Ogooue', 'HO', 1),
(1222, 78, 'Moyen-Ogooue', 'MO', 1),
(1223, 78, 'Ngounie', 'NG', 1),
(1224, 78, 'Nyanga', 'NY', 1),
(1225, 78, 'Ogooue-Ivindo', 'OI', 1),
(1226, 78, 'Ogooue-Lolo', 'OL', 1),
(1227, 78, 'Ogooue-Maritime', 'OM', 1),
(1228, 78, 'Woleu-Ntem', 'WN', 1),
(1229, 79, 'Banjul', 'BJ', 1),
(1230, 79, 'Basse', 'BS', 1),
(1231, 79, 'Brikama', 'BR', 1),
(1232, 79, 'Janjangbure', 'JA', 1),
(1233, 79, 'Kanifeng', 'KA', 1),
(1234, 79, 'Kerewan', 'KE', 1),
(1235, 79, 'Kuntaur', 'KU', 1),
(1236, 79, 'Mansakonko', 'MA', 1),
(1237, 79, 'Lower River', 'LR', 1),
(1238, 79, 'Central River', 'CR', 1),
(1239, 79, 'North Bank', 'NB', 1),
(1240, 79, 'Upper River', 'UR', 1),
(1241, 79, 'Western', 'WE', 1),
(1242, 80, 'Abkhazia', 'AB', 1),
(1243, 80, 'Ajaria', 'AJ', 1),
(1244, 80, 'Tbilisi', 'TB', 1),
(1245, 80, 'Guria', 'GU', 1),
(1246, 80, 'Imereti', 'IM', 1),
(1247, 80, 'Kakheti', 'KA', 1),
(1248, 80, 'Kvemo Kartli', 'KK', 1),
(1249, 80, 'Mtskheta-Mtianeti', 'MM', 1),
(1250, 80, 'Racha Lechkhumi and Kvemo Svanet', 'RL', 1),
(1251, 80, 'Samegrelo-Zemo Svaneti', 'SZ', 1),
(1252, 80, 'Samtskhe-Javakheti', 'SJ', 1),
(1253, 80, 'Shida Kartli', 'SK', 1),
(1254, 81, 'Baden-Württemberg', 'BAW', 1),
(1255, 81, 'Bayern', 'BAY', 1),
(1256, 81, 'Berlin', 'BER', 1),
(1257, 81, 'Brandenburg', 'BRG', 1),
(1258, 81, 'Bremen', 'BRE', 1),
(1259, 81, 'Hamburg', 'HAM', 1),
(1260, 81, 'Hessen', 'HES', 1),
(1261, 81, 'Mecklenburg-Vorpommern', 'MEC', 1),
(1262, 81, 'Niedersachsen', 'NDS', 1),
(1263, 81, 'Nordrhein-Westfalen', 'NRW', 1),
(1264, 81, 'Rheinland-Pfalz', 'RHE', 1),
(1265, 81, 'Saarland', 'SAR', 1),
(1266, 81, 'Sachsen', 'SAS', 1),
(1267, 81, 'Sachsen-Anhalt', 'SAC', 1),
(1268, 81, 'Schleswig-Holstein', 'SCN', 1),
(1269, 81, 'Thüringen', 'THE', 1),
(1270, 82, 'Ashanti Region', 'AS', 1),
(1271, 82, 'Brong-Ahafo Region', 'BA', 1),
(1272, 82, 'Central Region', 'CE', 1),
(1273, 82, 'Eastern Region', 'EA', 1),
(1274, 82, 'Greater Accra Region', 'GA', 1),
(1275, 82, 'Northern Region', 'NO', 1),
(1276, 82, 'Upper East Region', 'UE', 1),
(1277, 82, 'Upper West Region', 'UW', 1),
(1278, 82, 'Volta Region', 'VO', 1),
(1279, 82, 'Western Region', 'WE', 1),
(1280, 84, 'Attica', 'AT', 1),
(1281, 84, 'Central Greece', 'CN', 1),
(1282, 84, 'Central Macedonia', 'CM', 1),
(1283, 84, 'Crete', 'CR', 1),
(1284, 84, 'East Macedonia and Thrace', 'EM', 1),
(1285, 84, 'Epirus', 'EP', 1),
(1286, 84, 'Ionian Islands', 'II', 1),
(1287, 84, 'North Aegean', 'NA', 1),
(1288, 84, 'Peloponnesos', 'PP', 1),
(1289, 84, 'South Aegean', 'SA', 1),
(1290, 84, 'Thessaly', 'TH', 1),
(1291, 84, 'West Greece', 'WG', 1),
(1292, 84, 'West Macedonia', 'WM', 1),
(1293, 85, 'Avannaa', 'A', 1),
(1294, 85, 'Tunu', 'T', 1),
(1295, 85, 'Kitaa', 'K', 1),
(1296, 86, 'Saint Andrew', 'A', 1),
(1297, 86, 'Saint David', 'D', 1),
(1298, 86, 'Saint George', 'G', 1),
(1299, 86, 'Saint John', 'J', 1),
(1300, 86, 'Saint Mark', 'M', 1),
(1301, 86, 'Saint Patrick', 'P', 1),
(1302, 86, 'Carriacou', 'C', 1),
(1303, 86, 'Petit Martinique', 'Q', 1),
(1304, 89, 'Alta Verapaz', 'AV', 1),
(1305, 89, 'Baja Verapaz', 'BV', 1),
(1306, 89, 'Chimaltenango', 'CM', 1),
(1307, 89, 'Chiquimula', 'CQ', 1),
(1308, 89, 'El Peten', 'PE', 1),
(1309, 89, 'El Progreso', 'PR', 1),
(1310, 89, 'El Quiche', 'QC', 1),
(1311, 89, 'Escuintla', 'ES', 1),
(1312, 89, 'Guatemala', 'GU', 1),
(1313, 89, 'Huehuetenango', 'HU', 1),
(1314, 89, 'Izabal', 'IZ', 1),
(1315, 89, 'Jalapa', 'JA', 1),
(1316, 89, 'Jutiapa', 'JU', 1),
(1317, 89, 'Quetzaltenango', 'QZ', 1),
(1318, 89, 'Retalhuleu', 'RE', 1),
(1319, 89, 'Sacatepequez', 'ST', 1),
(1320, 89, 'San Marcos', 'SM', 1),
(1321, 89, 'Santa Rosa', 'SR', 1),
(1322, 89, 'Solola', 'SO', 1),
(1323, 89, 'Suchitepequez', 'SU', 1),
(1324, 89, 'Totonicapan', 'TO', 1),
(1325, 89, 'Zacapa', 'ZA', 1),
(1326, 90, 'Conakry', 'CNK', 1),
(1327, 90, 'Beyla', 'BYL', 1),
(1328, 90, 'Boffa', 'BFA', 1),
(1329, 90, 'Boke', 'BOK', 1),
(1330, 90, 'Coyah', 'COY', 1),
(1331, 90, 'Dabola', 'DBL', 1),
(1332, 90, 'Dalaba', 'DLB', 1),
(1333, 90, 'Dinguiraye', 'DGR', 1),
(1334, 90, 'Dubreka', 'DBR', 1),
(1335, 90, 'Faranah', 'FRN', 1),
(1336, 90, 'Forecariah', 'FRC', 1),
(1337, 90, 'Fria', 'FRI', 1),
(1338, 90, 'Gaoual', 'GAO', 1),
(1339, 90, 'Gueckedou', 'GCD', 1),
(1340, 90, 'Kankan', 'KNK', 1),
(1341, 90, 'Kerouane', 'KRN', 1),
(1342, 90, 'Kindia', 'KND', 1),
(1343, 90, 'Kissidougou', 'KSD', 1),
(1344, 90, 'Koubia', 'KBA', 1),
(1345, 90, 'Koundara', 'KDA', 1),
(1346, 90, 'Kouroussa', 'KRA', 1),
(1347, 90, 'Labe', 'LAB', 1),
(1348, 90, 'Lelouma', 'LLM', 1),
(1349, 90, 'Lola', 'LOL', 1),
(1350, 90, 'Macenta', 'MCT', 1),
(1351, 90, 'Mali', 'MAL', 1),
(1352, 90, 'Mamou', 'MAM', 1),
(1353, 90, 'Mandiana', 'MAN', 1),
(1354, 90, 'Nzerekore', 'NZR', 1),
(1355, 90, 'Pita', 'PIT', 1),
(1356, 90, 'Siguiri', 'SIG', 1),
(1357, 90, 'Telimele', 'TLM', 1),
(1358, 90, 'Tougue', 'TOG', 1),
(1359, 90, 'Yomou', 'YOM', 1),
(1360, 91, 'Bafata Region', 'BF', 1),
(1361, 91, 'Biombo Region', 'BB', 1),
(1362, 91, 'Bissau Region', 'BS', 1),
(1363, 91, 'Bolama Region', 'BL', 1),
(1364, 91, 'Cacheu Region', 'CA', 1),
(1365, 91, 'Gabu Region', 'GA', 1),
(1366, 91, 'Oio Region', 'OI', 1),
(1367, 91, 'Quinara Region', 'QU', 1),
(1368, 91, 'Tombali Region', 'TO', 1),
(1369, 92, 'Barima-Waini', 'BW', 1),
(1370, 92, 'Cuyuni-Mazaruni', 'CM', 1),
(1371, 92, 'Demerara-Mahaica', 'DM', 1),
(1372, 92, 'East Berbice-Corentyne', 'EC', 1),
(1373, 92, 'Essequibo Islands-West Demerara', 'EW', 1),
(1374, 92, 'Mahaica-Berbice', 'MB', 1),
(1375, 92, 'Pomeroon-Supenaam', 'PM', 1),
(1376, 92, 'Potaro-Siparuni', 'PI', 1),
(1377, 92, 'Upper Demerara-Berbice', 'UD', 1),
(1378, 92, 'Upper Takutu-Upper Essequibo', 'UT', 1),
(1379, 93, 'Artibonite', 'AR', 1),
(1380, 93, 'Centre', 'CE', 1),
(1381, 93, 'Grand Anse', 'GA', 1),
(1382, 93, 'Nord', 'ND', 1),
(1383, 93, 'Nord-Est', 'NE', 1),
(1384, 93, 'Nord-Ouest', 'NO', 1),
(1385, 93, 'Ouest', 'OU', 1),
(1386, 93, 'Sud', 'SD', 1),
(1387, 93, 'Sud-Est', 'SE', 1),
(1388, 94, 'Flat Island', 'F', 1),
(1389, 94, 'McDonald Island', 'M', 1),
(1390, 94, 'Shag Island', 'S', 1),
(1391, 94, 'Heard Island', 'H', 1),
(1392, 95, 'Atlantida', 'AT', 1),
(1393, 95, 'Choluteca', 'CH', 1),
(1394, 95, 'Colon', 'CL', 1),
(1395, 95, 'Comayagua', 'CM', 1),
(1396, 95, 'Copan', 'CP', 1),
(1397, 95, 'Cortes', 'CR', 1),
(1398, 95, 'El Paraiso', 'PA', 1),
(1399, 95, 'Francisco Morazan', 'FM', 1),
(1400, 95, 'Gracias a Dios', 'GD', 1),
(1401, 95, 'Intibuca', 'IN', 1),
(1402, 95, 'Islas de la Bahia (Bay Islands)', 'IB', 1),
(1403, 95, 'La Paz', 'PZ', 1),
(1404, 95, 'Lempira', 'LE', 1),
(1405, 95, 'Ocotepeque', 'OC', 1),
(1406, 95, 'Olancho', 'OL', 1),
(1407, 95, 'Santa Barbara', 'SB', 1),
(1408, 95, 'Valle', 'VA', 1),
(1409, 95, 'Yoro', 'YO', 1),
(1410, 96, 'Central and Western Hong Kong Island', 'HCW', 1),
(1411, 96, 'Eastern Hong Kong Island', 'HEA', 1),
(1412, 96, 'Southern Hong Kong Island', 'HSO', 1),
(1413, 96, 'Wan Chai Hong Kong Island', 'HWC', 1),
(1414, 96, 'Kowloon City Kowloon', 'KKC', 1),
(1415, 96, 'Kwun Tong Kowloon', 'KKT', 1),
(1416, 96, 'Sham Shui Po Kowloon', 'KSS', 1),
(1417, 96, 'Wong Tai Sin Kowloon', 'KWT', 1),
(1418, 96, 'Yau Tsim Mong Kowloon', 'KYT', 1),
(1419, 96, 'Islands New Territories', 'NIS', 1),
(1420, 96, 'Kwai Tsing New Territories', 'NKT', 1),
(1421, 96, 'North New Territories', 'NNO', 1),
(1422, 96, 'Sai Kung New Territories', 'NSK', 1),
(1423, 96, 'Sha Tin New Territories', 'NST', 1),
(1424, 96, 'Tai Po New Territories', 'NTP', 1),
(1425, 96, 'Tsuen Wan New Territories', 'NTW', 1),
(1426, 96, 'Tuen Mun New Territories', 'NTM', 1),
(1427, 96, 'Yuen Long New Territories', 'NYL', 1),
(1467, 98, 'Austurland', 'AL', 1),
(1468, 98, 'Hofuoborgarsvaeoi', 'HF', 1),
(1469, 98, 'Norourland eystra', 'NE', 1),
(1470, 98, 'Norourland vestra', 'NV', 1),
(1471, 98, 'Suourland', 'SL', 1),
(1472, 98, 'Suournes', 'SN', 1),
(1473, 98, 'Vestfiroir', 'VF', 1),
(1474, 98, 'Vesturland', 'VL', 1),
(1475, 99, 'Andaman and Nicobar Islands', 'AN', 1),
(1476, 99, 'Andhra Pradesh', 'AP', 1),
(1477, 99, 'Arunachal Pradesh', 'AR', 1),
(1478, 99, 'Assam', 'AS', 1),
(1479, 99, 'Bihar', 'BI', 1),
(1480, 99, 'Chandigarh', 'CH', 1),
(1481, 99, 'Dadra and Nagar Haveli', 'DA', 1),
(1482, 99, 'Daman and Diu', 'DM', 1),
(1483, 99, 'Delhi', 'DE', 1),
(1484, 99, 'Goa', 'GO', 1),
(1485, 99, 'Gujarat', 'GU', 1),
(1486, 99, 'Haryana', 'HA', 1),
(1487, 99, 'Himachal Pradesh', 'HP', 1),
(1488, 99, 'Jammu and Kashmir', 'JA', 1),
(1489, 99, 'Karnataka', 'KA', 1),
(1490, 99, 'Kerala', 'KE', 1),
(1491, 99, 'Lakshadweep Islands', 'LI', 1),
(1492, 99, 'Madhya Pradesh', 'MP', 1),
(1493, 99, 'Maharashtra', 'MA', 1),
(1494, 99, 'Manipur', 'MN', 1),
(1495, 99, 'Meghalaya', 'ME', 1),
(1496, 99, 'Mizoram', 'MI', 1),
(1497, 99, 'Nagaland', 'NA', 1),
(1498, 99, 'Orissa', 'OR', 1),
(1499, 99, 'Puducherry', 'PO', 1),
(1500, 99, 'Punjab', 'PU', 1),
(1501, 99, 'Rajasthan', 'RA', 1),
(1502, 99, 'Sikkim', 'SI', 1),
(1503, 99, 'Tamil Nadu', 'TN', 1),
(1504, 99, 'Tripura', 'TR', 1),
(1505, 99, 'Uttar Pradesh', 'UP', 1),
(1506, 99, 'West Bengal', 'WB', 1),
(1507, 100, 'Aceh', 'AC', 1),
(1508, 100, 'Bali', 'BA', 1),
(1509, 100, 'Banten', 'BT', 1),
(1510, 100, 'Bengkulu', 'BE', 1),
(1511, 100, 'Kalimantan Utara', 'BD', 1),
(1512, 100, 'Gorontalo', 'GO', 1),
(1513, 100, 'Jakarta', 'JK', 1),
(1514, 100, 'Jambi', 'JA', 1),
(1515, 100, 'Jawa Barat', 'JB', 1),
(1516, 100, 'Jawa Tengah', 'JT', 1),
(1517, 100, 'Jawa Timur', 'JI', 1),
(1518, 100, 'Kalimantan Barat', 'KB', 1),
(1519, 100, 'Kalimantan Selatan', 'KS', 1),
(1520, 100, 'Kalimantan Tengah', 'KT', 1),
(1521, 100, 'Kalimantan Timur', 'KI', 1),
(1522, 100, 'Kepulauan Bangka Belitung', 'BB', 1),
(1523, 100, 'Lampung', 'LA', 1),
(1524, 100, 'Maluku', 'MA', 1),
(1525, 100, 'Maluku Utara', 'MU', 1),
(1526, 100, 'Nusa Tenggara Barat', 'NB', 1),
(1527, 100, 'Nusa Tenggara Timur', 'NT', 1),
(1528, 100, 'Papua', 'PA', 1),
(1529, 100, 'Riau', 'RI', 1),
(1530, 100, 'Sulawesi Selatan', 'SN', 1),
(1531, 100, 'Sulawesi Tengah', 'ST', 1),
(1532, 100, 'Sulawesi Tenggara', 'SG', 1),
(1533, 100, 'Sulawesi Utara', 'SA', 1),
(1534, 100, 'Sumatera Barat', 'SB', 1),
(1535, 100, 'Sumatera Selatan', 'SS', 1),
(1536, 100, 'Sumatera Utara', 'SU', 1),
(1537, 100, 'Yogyakarta', 'YO', 1),
(1538, 101, 'Tehran', 'TEH', 1),
(1539, 101, 'Qom', 'QOM', 1),
(1540, 101, 'Markazi', 'MKZ', 1),
(1541, 101, 'Qazvin', 'QAZ', 1),
(1542, 101, 'Gilan', 'GIL', 1),
(1543, 101, 'Ardabil', 'ARD', 1),
(1544, 101, 'Zanjan', 'ZAN', 1),
(1545, 101, 'East Azarbaijan', 'EAZ', 1),
(1546, 101, 'West Azarbaijan', 'WEZ', 1),
(1547, 101, 'Kurdistan', 'KRD', 1),
(1548, 101, 'Hamadan', 'HMD', 1),
(1549, 101, 'Kermanshah', 'KRM', 1),
(1550, 101, 'Ilam', 'ILM', 1),
(1551, 101, 'Lorestan', 'LRS', 1),
(1552, 101, 'Khuzestan', 'KZT', 1),
(1553, 101, 'Chahar Mahaal and Bakhtiari', 'CMB', 1),
(1554, 101, 'Kohkiluyeh and Buyer Ahmad', 'KBA', 1),
(1555, 101, 'Bushehr', 'BSH', 1),
(1556, 101, 'Fars', 'FAR', 1),
(1557, 101, 'Hormozgan', 'HRM', 1),
(1558, 101, 'Sistan and Baluchistan', 'SBL', 1),
(1559, 101, 'Kerman', 'KRB', 1),
(1560, 101, 'Yazd', 'YZD', 1),
(1561, 101, 'Esfahan', 'EFH', 1),
(1562, 101, 'Semnan', 'SMN', 1),
(1563, 101, 'Mazandaran', 'MZD', 1),
(1564, 101, 'Golestan', 'GLS', 1),
(1565, 101, 'North Khorasan', 'NKH', 1),
(1566, 101, 'Razavi Khorasan', 'RKH', 1),
(1567, 101, 'South Khorasan', 'SKH', 1),
(1568, 102, 'Baghdad', 'BD', 1),
(1569, 102, 'Salah ad Din', 'SD', 1),
(1570, 102, 'Diyala', 'DY', 1),
(1571, 102, 'Wasit', 'WS', 1),
(1572, 102, 'Maysan', 'MY', 1),
(1573, 102, 'Al Basrah', 'BA', 1),
(1574, 102, 'Dhi Qar', 'DQ', 1),
(1575, 102, 'Al Muthanna', 'MU', 1),
(1576, 102, 'Al Qadisyah', 'QA', 1),
(1577, 102, 'Babil', 'BB', 1),
(1578, 102, 'Al Karbala', 'KB', 1),
(1579, 102, 'An Najaf', 'NJ', 1),
(1580, 102, 'Al Anbar', 'AB', 1),
(1581, 102, 'Ninawa', 'NN', 1),
(1582, 102, 'Dahuk', 'DH', 1),
(1583, 102, 'Arbil', 'AL', 1),
(1584, 102, 'At Ta mim', 'TM', 1),
(1585, 102, 'As Sulaymaniyah', 'SL', 1),
(1586, 103, 'Carlow', 'CA', 1),
(1587, 103, 'Cavan', 'CV', 1),
(1588, 103, 'Clare', 'CL', 1),
(1589, 103, 'Cork', 'CO', 1),
(1590, 103, 'Donegal', 'DO', 1),
(1591, 103, 'Dublin', 'DU', 1),
(1592, 103, 'Galway', 'GA', 1),
(1593, 103, 'Kerry', 'KE', 1),
(1594, 103, 'Kildare', 'KI', 1),
(1595, 103, 'Kilkenny', 'KL', 1),
(1596, 103, 'Laois', 'LA', 1),
(1597, 103, 'Leitrim', 'LE', 1),
(1598, 103, 'Limerick', 'LI', 1),
(1599, 103, 'Longford', 'LO', 1),
(1600, 103, 'Louth', 'LU', 1),
(1601, 103, 'Mayo', 'MA', 1),
(1602, 103, 'Meath', 'ME', 1),
(1603, 103, 'Monaghan', 'MO', 1),
(1604, 103, 'Offaly', 'OF', 1),
(1605, 103, 'Roscommon', 'RO', 1);
INSERT INTO `cc_zone` (`zone_id`, `country_id`, `name`, `code`, `status`) VALUES
(1606, 103, 'Sligo', 'SL', 1),
(1607, 103, 'Tipperary', 'TI', 1),
(1608, 103, 'Waterford', 'WA', 1),
(1609, 103, 'Westmeath', 'WE', 1),
(1610, 103, 'Wexford', 'WX', 1),
(1611, 103, 'Wicklow', 'WI', 1),
(1612, 104, 'Be er Sheva', 'BS', 1),
(1613, 104, 'Bika at Hayarden', 'BH', 1),
(1614, 104, 'Eilat and Arava', 'EA', 1),
(1615, 104, 'Galil', 'GA', 1),
(1616, 104, 'Haifa', 'HA', 1),
(1617, 104, 'Jehuda Mountains', 'JM', 1),
(1618, 104, 'Jerusalem', 'JE', 1),
(1619, 104, 'Negev', 'NE', 1),
(1620, 104, 'Semaria', 'SE', 1),
(1621, 104, 'Sharon', 'SH', 1),
(1622, 104, 'Tel Aviv (Gosh Dan)', 'TA', 1),
(1643, 106, 'Clarendon Parish', 'CLA', 1),
(1644, 106, 'Hanover Parish', 'HAN', 1),
(1645, 106, 'Kingston Parish', 'KIN', 1),
(1646, 106, 'Manchester Parish', 'MAN', 1),
(1647, 106, 'Portland Parish', 'POR', 1),
(1648, 106, 'Saint Andrew Parish', 'AND', 1),
(1649, 106, 'Saint Ann Parish', 'ANN', 1),
(1650, 106, 'Saint Catherine Parish', 'CAT', 1),
(1651, 106, 'Saint Elizabeth Parish', 'ELI', 1),
(1652, 106, 'Saint James Parish', 'JAM', 1),
(1653, 106, 'Saint Mary Parish', 'MAR', 1),
(1654, 106, 'Saint Thomas Parish', 'THO', 1),
(1655, 106, 'Trelawny Parish', 'TRL', 1),
(1656, 106, 'Westmoreland Parish', 'WML', 1),
(1657, 107, 'Aichi', 'AI', 1),
(1658, 107, 'Akita', 'AK', 1),
(1659, 107, 'Aomori', 'AO', 1),
(1660, 107, 'Chiba', 'CH', 1),
(1661, 107, 'Ehime', 'EH', 1),
(1662, 107, 'Fukui', 'FK', 1),
(1663, 107, 'Fukuoka', 'FU', 1),
(1664, 107, 'Fukushima', 'FS', 1),
(1665, 107, 'Gifu', 'GI', 1),
(1666, 107, 'Gumma', 'GU', 1),
(1667, 107, 'Hiroshima', 'HI', 1),
(1668, 107, 'Hokkaido', 'HO', 1),
(1669, 107, 'Hyogo', 'HY', 1),
(1670, 107, 'Ibaraki', 'IB', 1),
(1671, 107, 'Ishikawa', 'IS', 1),
(1672, 107, 'Iwate', 'IW', 1),
(1673, 107, 'Kagawa', 'KA', 1),
(1674, 107, 'Kagoshima', 'KG', 1),
(1675, 107, 'Kanagawa', 'KN', 1),
(1676, 107, 'Kochi', 'KO', 1),
(1677, 107, 'Kumamoto', 'KU', 1),
(1678, 107, 'Kyoto', 'KY', 1),
(1679, 107, 'Mie', 'MI', 1),
(1680, 107, 'Miyagi', 'MY', 1),
(1681, 107, 'Miyazaki', 'MZ', 1),
(1682, 107, 'Nagano', 'NA', 1),
(1683, 107, 'Nagasaki', 'NG', 1),
(1684, 107, 'Nara', 'NR', 1),
(1685, 107, 'Niigata', 'NI', 1),
(1686, 107, 'Oita', 'OI', 1),
(1687, 107, 'Okayama', 'OK', 1),
(1688, 107, 'Okinawa', 'ON', 1),
(1689, 107, 'Osaka', 'OS', 1),
(1690, 107, 'Saga', 'SA', 1),
(1691, 107, 'Saitama', 'SI', 1),
(1692, 107, 'Shiga', 'SH', 1),
(1693, 107, 'Shimane', 'SM', 1),
(1694, 107, 'Shizuoka', 'SZ', 1),
(1695, 107, 'Tochigi', 'TO', 1),
(1696, 107, 'Tokushima', 'TS', 1),
(1697, 107, 'Tokyo', 'TK', 1),
(1698, 107, 'Tottori', 'TT', 1),
(1699, 107, 'Toyama', 'TY', 1),
(1700, 107, 'Wakayama', 'WA', 1),
(1701, 107, 'Yamagata', 'YA', 1),
(1702, 107, 'Yamaguchi', 'YM', 1),
(1703, 107, 'Yamanashi', 'YN', 1),
(1704, 108, ' Amman', 'AM', 1),
(1705, 108, 'Ajlun', 'AJ', 1),
(1706, 108, 'Al  Aqabah', 'AA', 1),
(1707, 108, 'Al Balqa ', 'AB', 1),
(1708, 108, 'Al Karak', 'AK', 1),
(1709, 108, 'Al Mafraq', 'AL', 1),
(1710, 108, 'At Tafilah', 'AT', 1),
(1711, 108, 'Az Zarqa ', 'AZ', 1),
(1712, 108, 'Irbid', 'IR', 1),
(1713, 108, 'Jarash', 'JA', 1),
(1714, 108, 'Ma an', 'MA', 1),
(1715, 108, 'Madaba', 'MD', 1),
(1716, 109, 'Almaty', 'AL', 1),
(1717, 109, 'Almaty City', 'AC', 1),
(1718, 109, 'Aqmola', 'AM', 1),
(1719, 109, 'Aqtobe', 'AQ', 1),
(1720, 109, 'Astana City', 'AS', 1),
(1721, 109, 'Atyrau', 'AT', 1),
(1722, 109, 'Batys Qazaqstan', 'BA', 1),
(1723, 109, 'Bayqongyr City', 'BY', 1),
(1724, 109, 'Mangghystau', 'MA', 1),
(1725, 109, 'Ongtustik Qazaqstan', 'ON', 1),
(1726, 109, 'Pavlodar', 'PA', 1),
(1727, 109, 'Qaraghandy', 'QA', 1),
(1728, 109, 'Qostanay', 'QO', 1),
(1729, 109, 'Qyzylorda', 'QY', 1),
(1730, 109, 'Shyghys Qazaqstan', 'SH', 1),
(1731, 109, 'Soltustik Qazaqstan', 'SO', 1),
(1732, 109, 'Zhambyl', 'ZH', 1),
(1733, 110, 'Central', 'CE', 1),
(1734, 110, 'Coast', 'CO', 1),
(1735, 110, 'Eastern', 'EA', 1),
(1736, 110, 'Nairobi Area', 'NA', 1),
(1737, 110, 'North Eastern', 'NE', 1),
(1738, 110, 'Nyanza', 'NY', 1),
(1739, 110, 'Rift Valley', 'RV', 1),
(1740, 110, 'Western', 'WE', 1),
(1741, 111, 'Abaiang', 'AG', 1),
(1742, 111, 'Abemama', 'AM', 1),
(1743, 111, 'Aranuka', 'AK', 1),
(1744, 111, 'Arorae', 'AO', 1),
(1745, 111, 'Banaba', 'BA', 1),
(1746, 111, 'Beru', 'BE', 1),
(1747, 111, 'Butaritari', 'bT', 1),
(1748, 111, 'Kanton', 'KA', 1),
(1749, 111, 'Kiritimati', 'KR', 1),
(1750, 111, 'Kuria', 'KU', 1),
(1751, 111, 'Maiana', 'MI', 1),
(1752, 111, 'Makin', 'MN', 1),
(1753, 111, 'Marakei', 'ME', 1),
(1754, 111, 'Nikunau', 'NI', 1),
(1755, 111, 'Nonouti', 'NO', 1),
(1756, 111, 'Onotoa', 'ON', 1),
(1757, 111, 'Tabiteuea', 'TT', 1),
(1758, 111, 'Tabuaeran', 'TR', 1),
(1759, 111, 'Tamana', 'TM', 1),
(1760, 111, 'Tarawa', 'TW', 1),
(1761, 111, 'Teraina', 'TE', 1),
(1762, 112, 'Chagang-do', 'CHA', 1),
(1763, 112, 'Hamgyong-bukto', 'HAB', 1),
(1764, 112, 'Hamgyong-namdo', 'HAN', 1),
(1765, 112, 'Hwanghae-bukto', 'HWB', 1),
(1766, 112, 'Hwanghae-namdo', 'HWN', 1),
(1767, 112, 'Kangwon-do', 'KAN', 1),
(1768, 112, 'P yongan-bukto', 'PYB', 1),
(1769, 112, 'P yongan-namdo', 'PYN', 1),
(1770, 112, 'Ryanggang-do (Yanggang-do)', 'YAN', 1),
(1771, 112, 'Rason Directly Governed City', 'NAJ', 1),
(1772, 112, 'P yongyang Special City', 'PYO', 1),
(1773, 113, 'Ch ungch ong-bukto', 'CO', 1),
(1774, 113, 'Ch ungch ong-namdo', 'CH', 1),
(1775, 113, 'Cheju-do', 'CD', 1),
(1776, 113, 'Cholla-bukto', 'CB', 1),
(1777, 113, 'Cholla-namdo', 'CN', 1),
(1778, 113, 'Inch on-gwangyoksi', 'IG', 1),
(1779, 113, 'Kangwon-do', 'KA', 1),
(1780, 113, 'Kwangju-gwangyoksi', 'KG', 1),
(1781, 113, 'Kyonggi-do', 'KD', 1),
(1782, 113, 'Kyongsang-bukto', 'KB', 1),
(1783, 113, 'Kyongsang-namdo', 'KN', 1),
(1784, 113, 'Pusan-gwangyoksi', 'PG', 1),
(1785, 113, 'Soul-t ukpyolsi', 'SO', 1),
(1786, 113, 'Taegu-gwangyoksi', 'TA', 1),
(1787, 113, 'Taejon-gwangyoksi', 'TG', 1),
(1788, 114, 'Al  Asimah', 'AL', 1),
(1789, 114, 'Al Ahmadi', 'AA', 1),
(1790, 114, 'Al Farwaniyah', 'AF', 1),
(1791, 114, 'Al Jahra ', 'AJ', 1),
(1792, 114, 'Hawalli', 'HA', 1),
(1793, 115, 'Bishkek', 'GB', 1),
(1794, 115, 'Batken', 'B', 1),
(1795, 115, 'Chu', 'C', 1),
(1796, 115, 'Jalal-Abad', 'J', 1),
(1797, 115, 'Naryn', 'N', 1),
(1798, 115, 'Osh', 'O', 1),
(1799, 115, 'Talas', 'T', 1),
(1800, 115, 'Ysyk-Kol', 'Y', 1),
(1801, 116, 'Vientiane', 'VT', 1),
(1802, 116, 'Attapu', 'AT', 1),
(1803, 116, 'Bokeo', 'BK', 1),
(1804, 116, 'Bolikhamxai', 'BL', 1),
(1805, 116, 'Champasak', 'CH', 1),
(1806, 116, 'Houaphan', 'HO', 1),
(1807, 116, 'Khammouan', 'KH', 1),
(1808, 116, 'Louang Namtha', 'LM', 1),
(1809, 116, 'Louangphabang', 'LP', 1),
(1810, 116, 'Oudomxai', 'OU', 1),
(1811, 116, 'Phongsali', 'PH', 1),
(1812, 116, 'Salavan', 'SL', 1),
(1813, 116, 'Savannakhet', 'SV', 1),
(1814, 116, 'Vientiane', 'VI', 1),
(1815, 116, 'Xaignabouli', 'XA', 1),
(1816, 116, 'Xekong', 'XE', 1),
(1817, 116, 'Xiangkhoang', 'XI', 1),
(1818, 116, 'Xaisomboun', 'XN', 1),
(1852, 119, 'Berea', 'BE', 1),
(1853, 119, 'Butha-Buthe', 'BB', 1),
(1854, 119, 'Leribe', 'LE', 1),
(1855, 119, 'Mafeteng', 'MF', 1),
(1856, 119, 'Maseru', 'MS', 1),
(1857, 119, 'Mohale s Hoek', 'MH', 1),
(1858, 119, 'Mokhotlong', 'MK', 1),
(1859, 119, 'Qacha s Nek', 'QN', 1),
(1860, 119, 'Quthing', 'QT', 1),
(1861, 119, 'Thaba-Tseka', 'TT', 1),
(1862, 120, 'Bomi', 'BI', 1),
(1863, 120, 'Bong', 'BG', 1),
(1864, 120, 'Grand Bassa', 'GB', 1),
(1865, 120, 'Grand Cape Mount', 'CM', 1),
(1866, 120, 'Grand Gedeh', 'GG', 1),
(1867, 120, 'Grand Kru', 'GK', 1),
(1868, 120, 'Lofa', 'LO', 1),
(1869, 120, 'Margibi', 'MG', 1),
(1870, 120, 'Maryland', 'ML', 1),
(1871, 120, 'Montserrado', 'MS', 1),
(1872, 120, 'Nimba', 'NB', 1),
(1873, 120, 'River Cess', 'RC', 1),
(1874, 120, 'Sinoe', 'SN', 1),
(1875, 121, 'Ajdabiya', 'AJ', 1),
(1876, 121, 'Al  Aziziyah', 'AZ', 1),
(1877, 121, 'Al Fatih', 'FA', 1),
(1878, 121, 'Al Jabal al Akhdar', 'JA', 1),
(1879, 121, 'Al Jufrah', 'JU', 1),
(1880, 121, 'Al Khums', 'KH', 1),
(1881, 121, 'Al Kufrah', 'KU', 1),
(1882, 121, 'An Nuqat al Khams', 'NK', 1),
(1883, 121, 'Ash Shati ', 'AS', 1),
(1884, 121, 'Awbari', 'AW', 1),
(1885, 121, 'Az Zawiyah', 'ZA', 1),
(1886, 121, 'Banghazi', 'BA', 1),
(1887, 121, 'Darnah', 'DA', 1),
(1888, 121, 'Ghadamis', 'GD', 1),
(1889, 121, 'Gharyan', 'GY', 1),
(1890, 121, 'Misratah', 'MI', 1),
(1891, 121, 'Murzuq', 'MZ', 1),
(1892, 121, 'Sabha', 'SB', 1),
(1893, 121, 'Sawfajjin', 'SW', 1),
(1894, 121, 'Surt', 'SU', 1),
(1895, 121, 'Tarabulus (Tripoli)', 'TL', 1),
(1896, 121, 'Tarhunah', 'TH', 1),
(1897, 121, 'Tubruq', 'TU', 1),
(1898, 121, 'Yafran', 'YA', 1),
(1899, 121, 'Zlitan', 'ZL', 1),
(1900, 122, 'Vaduz', 'V', 1),
(1901, 122, 'Schaan', 'A', 1),
(1902, 122, 'Balzers', 'B', 1),
(1903, 122, 'Triesen', 'N', 1),
(1904, 122, 'Eschen', 'E', 1),
(1905, 122, 'Mauren', 'M', 1),
(1906, 122, 'Triesenberg', 'T', 1),
(1907, 122, 'Ruggell', 'R', 1),
(1908, 122, 'Gamprin', 'G', 1),
(1909, 122, 'Schellenberg', 'L', 1),
(1910, 122, 'Planken', 'P', 1),
(1911, 123, 'Alytus', 'AL', 1),
(1912, 123, 'Kaunas', 'KA', 1),
(1913, 123, 'Klaipeda', 'KL', 1),
(1914, 123, 'Marijampole', 'MA', 1),
(1915, 123, 'Panevezys', 'PA', 1),
(1916, 123, 'Siauliai', 'SI', 1),
(1917, 123, 'Taurage', 'TA', 1),
(1918, 123, 'Telsiai', 'TE', 1),
(1919, 123, 'Utena', 'UT', 1),
(1920, 123, 'Vilnius', 'VI', 1),
(1921, 124, 'Diekirch', 'DD', 1),
(1922, 124, 'Clervaux', 'DC', 1),
(1923, 124, 'Redange', 'DR', 1),
(1924, 124, 'Vianden', 'DV', 1),
(1925, 124, 'Wiltz', 'DW', 1),
(1926, 124, 'Grevenmacher', 'GG', 1),
(1927, 124, 'Echternach', 'GE', 1),
(1928, 124, 'Remich', 'GR', 1),
(1929, 124, 'Luxembourg', 'LL', 1),
(1930, 124, 'Capellen', 'LC', 1),
(1931, 124, 'Esch-sur-Alzette', 'LE', 1),
(1932, 124, 'Mersch', 'LM', 1),
(1933, 125, 'Our Lady Fatima Parish', 'OLF', 1),
(1934, 125, 'St. Anthony Parish', 'ANT', 1),
(1935, 125, 'St. Lazarus Parish', 'LAZ', 1),
(1936, 125, 'Cathedral Parish', 'CAT', 1),
(1937, 125, 'St. Lawrence Parish', 'LAW', 1),
(1938, 127, 'Antananarivo', 'AN', 1),
(1939, 127, 'Antsiranana', 'AS', 1),
(1940, 127, 'Fianarantsoa', 'FN', 1),
(1941, 127, 'Mahajanga', 'MJ', 1),
(1942, 127, 'Toamasina', 'TM', 1),
(1943, 127, 'Toliara', 'TL', 1),
(1944, 128, 'Balaka', 'BLK', 1),
(1945, 128, 'Blantyre', 'BLT', 1),
(1946, 128, 'Chikwawa', 'CKW', 1),
(1947, 128, 'Chiradzulu', 'CRD', 1),
(1948, 128, 'Chitipa', 'CTP', 1),
(1949, 128, 'Dedza', 'DDZ', 1),
(1950, 128, 'Dowa', 'DWA', 1),
(1951, 128, 'Karonga', 'KRG', 1),
(1952, 128, 'Kasungu', 'KSG', 1),
(1953, 128, 'Likoma', 'LKM', 1),
(1954, 128, 'Lilongwe', 'LLG', 1),
(1955, 128, 'Machinga', 'MCG', 1),
(1956, 128, 'Mangochi', 'MGC', 1),
(1957, 128, 'Mchinji', 'MCH', 1),
(1958, 128, 'Mulanje', 'MLJ', 1),
(1959, 128, 'Mwanza', 'MWZ', 1),
(1960, 128, 'Mzimba', 'MZM', 1),
(1961, 128, 'Ntcheu', 'NTU', 1),
(1962, 128, 'Nkhata Bay', 'NKB', 1),
(1963, 128, 'Nkhotakota', 'NKH', 1),
(1964, 128, 'Nsanje', 'NSJ', 1),
(1965, 128, 'Ntchisi', 'NTI', 1),
(1966, 128, 'Phalombe', 'PHL', 1),
(1967, 128, 'Rumphi', 'RMP', 1),
(1968, 128, 'Salima', 'SLM', 1),
(1969, 128, 'Thyolo', 'THY', 1),
(1970, 128, 'Zomba', 'ZBA', 1),
(1971, 129, 'Johor', 'MY-01', 1),
(1972, 129, 'Kedah', 'MY-02', 1),
(1973, 129, 'Kelantan', 'MY-03', 1),
(1974, 129, 'Labuan', 'MY-15', 1),
(1975, 129, 'Melaka', 'MY-04', 1),
(1976, 129, 'Negeri Sembilan', 'MY-05', 1),
(1977, 129, 'Pahang', 'MY-06', 1),
(1978, 129, 'Perak', 'MY-08', 1),
(1979, 129, 'Perlis', 'MY-09', 1),
(1980, 129, 'Pulau Pinang', 'MY-07', 1),
(1981, 129, 'Sabah', 'MY-12', 1),
(1982, 129, 'Sarawak', 'MY-13', 1),
(1983, 129, 'Selangor', 'MY-10', 1),
(1984, 129, 'Terengganu', 'MY-11', 1),
(1985, 129, 'Kuala Lumpur', 'MY-14', 1),
(1986, 130, 'Thiladhunmathi Uthuru', 'THU', 1),
(1987, 130, 'Thiladhunmathi Dhekunu', 'THD', 1),
(1988, 130, 'Miladhunmadulu Uthuru', 'MLU', 1),
(1989, 130, 'Miladhunmadulu Dhekunu', 'MLD', 1),
(1990, 130, 'Maalhosmadulu Uthuru', 'MAU', 1),
(1991, 130, 'Maalhosmadulu Dhekunu', 'MAD', 1),
(1992, 130, 'Faadhippolhu', 'FAA', 1),
(1993, 130, 'Male Atoll', 'MAA', 1),
(1994, 130, 'Ari Atoll Uthuru', 'AAU', 1),
(1995, 130, 'Ari Atoll Dheknu', 'AAD', 1),
(1996, 130, 'Felidhe Atoll', 'FEA', 1),
(1997, 130, 'Mulaku Atoll', 'MUA', 1),
(1998, 130, 'Nilandhe Atoll Uthuru', 'NAU', 1),
(1999, 130, 'Nilandhe Atoll Dhekunu', 'NAD', 1),
(2000, 130, 'Kolhumadulu', 'KLH', 1),
(2001, 130, 'Hadhdhunmathi', 'HDH', 1),
(2002, 130, 'Huvadhu Atoll Uthuru', 'HAU', 1),
(2003, 130, 'Huvadhu Atoll Dhekunu', 'HAD', 1),
(2004, 130, 'Fua Mulaku', 'FMU', 1),
(2005, 130, 'Addu', 'ADD', 1),
(2006, 131, 'Gao', 'GA', 1),
(2007, 131, 'Kayes', 'KY', 1),
(2008, 131, 'Kidal', 'KD', 1),
(2009, 131, 'Koulikoro', 'KL', 1),
(2010, 131, 'Mopti', 'MP', 1),
(2011, 131, 'Segou', 'SG', 1),
(2012, 131, 'Sikasso', 'SK', 1),
(2013, 131, 'Tombouctou', 'TB', 1),
(2014, 131, 'Bamako Capital District', 'CD', 1),
(2015, 132, 'Attard', 'ATT', 1),
(2016, 132, 'Balzan', 'BAL', 1),
(2017, 132, 'Birgu', 'BGU', 1),
(2018, 132, 'Birkirkara', 'BKK', 1),
(2019, 132, 'Birzebbuga', 'BRZ', 1),
(2020, 132, 'Bormla', 'BOR', 1),
(2021, 132, 'Dingli', 'DIN', 1),
(2022, 132, 'Fgura', 'FGU', 1),
(2023, 132, 'Floriana', 'FLO', 1),
(2024, 132, 'Gudja', 'GDJ', 1),
(2025, 132, 'Gzira', 'GZR', 1),
(2026, 132, 'Gargur', 'GRG', 1),
(2027, 132, 'Gaxaq', 'GXQ', 1),
(2028, 132, 'Hamrun', 'HMR', 1),
(2029, 132, 'Iklin', 'IKL', 1),
(2030, 132, 'Isla', 'ISL', 1),
(2031, 132, 'Kalkara', 'KLK', 1),
(2032, 132, 'Kirkop', 'KRK', 1),
(2033, 132, 'Lija', 'LIJ', 1),
(2034, 132, 'Luqa', 'LUQ', 1),
(2035, 132, 'Marsa', 'MRS', 1),
(2036, 132, 'Marsaskala', 'MKL', 1),
(2037, 132, 'Marsaxlokk', 'MXL', 1),
(2038, 132, 'Mdina', 'MDN', 1),
(2039, 132, 'Melliea', 'MEL', 1),
(2040, 132, 'Mgarr', 'MGR', 1),
(2041, 132, 'Mosta', 'MST', 1),
(2042, 132, 'Mqabba', 'MQA', 1),
(2043, 132, 'Msida', 'MSI', 1),
(2044, 132, 'Mtarfa', 'MTF', 1),
(2045, 132, 'Naxxar', 'NAX', 1),
(2046, 132, 'Paola', 'PAO', 1),
(2047, 132, 'Pembroke', 'PEM', 1),
(2048, 132, 'Pieta', 'PIE', 1),
(2049, 132, 'Qormi', 'QOR', 1),
(2050, 132, 'Qrendi', 'QRE', 1),
(2051, 132, 'Rabat', 'RAB', 1),
(2052, 132, 'Safi', 'SAF', 1),
(2053, 132, 'San Giljan', 'SGI', 1),
(2054, 132, 'Santa Lucija', 'SLU', 1),
(2055, 132, 'San Pawl il-Bahar', 'SPB', 1),
(2056, 132, 'San Gwann', 'SGW', 1),
(2057, 132, 'Santa Venera', 'SVE', 1),
(2058, 132, 'Siggiewi', 'SIG', 1),
(2059, 132, 'Sliema', 'SLM', 1),
(2060, 132, 'Swieqi', 'SWQ', 1),
(2061, 132, 'Ta Xbiex', 'TXB', 1),
(2062, 132, 'Tarxien', 'TRX', 1),
(2063, 132, 'Valletta', 'VLT', 1),
(2064, 132, 'Xgajra', 'XGJ', 1),
(2065, 132, 'Zabbar', 'ZBR', 1),
(2066, 132, 'Zebbug', 'ZBG', 1),
(2067, 132, 'Zejtun', 'ZJT', 1),
(2068, 132, 'Zurrieq', 'ZRQ', 1),
(2069, 132, 'Fontana', 'FNT', 1),
(2070, 132, 'Ghajnsielem', 'GHJ', 1),
(2071, 132, 'Gharb', 'GHR', 1),
(2072, 132, 'Ghasri', 'GHS', 1),
(2073, 132, 'Kercem', 'KRC', 1),
(2074, 132, 'Munxar', 'MUN', 1),
(2075, 132, 'Nadur', 'NAD', 1),
(2076, 132, 'Qala', 'QAL', 1),
(2077, 132, 'Victoria', 'VIC', 1),
(2078, 132, 'San Lawrenz', 'SLA', 1),
(2079, 132, 'Sannat', 'SNT', 1),
(2080, 132, 'Xagra', 'ZAG', 1),
(2081, 132, 'Xewkija', 'XEW', 1),
(2082, 132, 'Zebbug', 'ZEB', 1),
(2083, 133, 'Ailinginae', 'ALG', 1),
(2084, 133, 'Ailinglaplap', 'ALL', 1),
(2085, 133, 'Ailuk', 'ALK', 1),
(2086, 133, 'Arno', 'ARN', 1),
(2087, 133, 'Aur', 'AUR', 1),
(2088, 133, 'Bikar', 'BKR', 1),
(2089, 133, 'Bikini', 'BKN', 1),
(2090, 133, 'Bokak', 'BKK', 1),
(2091, 133, 'Ebon', 'EBN', 1),
(2092, 133, 'Enewetak', 'ENT', 1),
(2093, 133, 'Erikub', 'EKB', 1),
(2094, 133, 'Jabat', 'JBT', 1),
(2095, 133, 'Jaluit', 'JLT', 1),
(2096, 133, 'Jemo', 'JEM', 1),
(2097, 133, 'Kili', 'KIL', 1),
(2098, 133, 'Kwajalein', 'KWJ', 1),
(2099, 133, 'Lae', 'LAE', 1),
(2100, 133, 'Lib', 'LIB', 1),
(2101, 133, 'Likiep', 'LKP', 1),
(2102, 133, 'Majuro', 'MJR', 1),
(2103, 133, 'Maloelap', 'MLP', 1),
(2104, 133, 'Mejit', 'MJT', 1),
(2105, 133, 'Mili', 'MIL', 1),
(2106, 133, 'Namorik', 'NMK', 1),
(2107, 133, 'Namu', 'NAM', 1),
(2108, 133, 'Rongelap', 'RGL', 1),
(2109, 133, 'Rongrik', 'RGK', 1),
(2110, 133, 'Toke', 'TOK', 1),
(2111, 133, 'Ujae', 'UJA', 1),
(2112, 133, 'Ujelang', 'UJL', 1),
(2113, 133, 'Utirik', 'UTK', 1),
(2114, 133, 'Wotho', 'WTH', 1),
(2115, 133, 'Wotje', 'WTJ', 1),
(2116, 135, 'Adrar', 'AD', 1),
(2117, 135, 'Assaba', 'AS', 1),
(2118, 135, 'Brakna', 'BR', 1),
(2119, 135, 'Dakhlet Nouadhibou', 'DN', 1),
(2120, 135, 'Gorgol', 'GO', 1),
(2121, 135, 'Guidimaka', 'GM', 1),
(2122, 135, 'Hodh Ech Chargui', 'HC', 1),
(2123, 135, 'Hodh El Gharbi', 'HG', 1),
(2124, 135, 'Inchiri', 'IN', 1),
(2125, 135, 'Tagant', 'TA', 1),
(2126, 135, 'Tiris Zemmour', 'TZ', 1),
(2127, 135, 'Trarza', 'TR', 1),
(2128, 135, 'Nouakchott', 'NO', 1),
(2129, 136, 'Beau Bassin-Rose Hill', 'BR', 1),
(2130, 136, 'Curepipe', 'CU', 1),
(2131, 136, 'Port Louis', 'PU', 1),
(2132, 136, 'Quatre Bornes', 'QB', 1),
(2133, 136, 'Vacoas-Phoenix', 'VP', 1),
(2134, 136, 'Agalega Islands', 'AG', 1),
(2135, 136, 'Cargados Carajos Shoals (Saint Brandon Islands)', 'CC', 1),
(2136, 136, 'Rodrigues', 'RO', 1),
(2137, 136, 'Black River', 'BL', 1),
(2138, 136, 'Flacq', 'FL', 1),
(2139, 136, 'Grand Port', 'GP', 1),
(2140, 136, 'Moka', 'MO', 1),
(2141, 136, 'Pamplemousses', 'PA', 1),
(2142, 136, 'Plaines Wilhems', 'PW', 1),
(2143, 136, 'Port Louis', 'PL', 1),
(2144, 136, 'Riviere du Rempart', 'RR', 1),
(2145, 136, 'Savanne', 'SA', 1),
(2146, 138, 'Baja California Norte', 'BN', 1),
(2147, 138, 'Baja California Sur', 'BS', 1),
(2148, 138, 'Campeche', 'CA', 1),
(2149, 138, 'Chiapas', 'CI', 1),
(2150, 138, 'Chihuahua', 'CH', 1),
(2151, 138, 'Coahuila de Zaragoza', 'CZ', 1),
(2152, 138, 'Colima', 'CL', 1),
(2153, 138, 'Distrito Federal', 'DF', 1),
(2154, 138, 'Durango', 'DU', 1),
(2155, 138, 'Guanajuato', 'GA', 1),
(2156, 138, 'Guerrero', 'GE', 1),
(2157, 138, 'Hidalgo', 'HI', 1),
(2158, 138, 'Jalisco', 'JA', 1),
(2159, 138, 'Mexico', 'ME', 1),
(2160, 138, 'Michoacan de Ocampo', 'MI', 1),
(2161, 138, 'Morelos', 'MO', 1),
(2162, 138, 'Nayarit', 'NA', 1),
(2163, 138, 'Nuevo Leon', 'NL', 1),
(2164, 138, 'Oaxaca', 'OA', 1),
(2165, 138, 'Puebla', 'PU', 1),
(2166, 138, 'Queretaro de Arteaga', 'QA', 1),
(2167, 138, 'Quintana Roo', 'QR', 1),
(2168, 138, 'San Luis Potosi', 'SA', 1),
(2169, 138, 'Sinaloa', 'SI', 1),
(2170, 138, 'Sonora', 'SO', 1),
(2171, 138, 'Tabasco', 'TB', 1),
(2172, 138, 'Tamaulipas', 'TM', 1),
(2173, 138, 'Tlaxcala', 'TL', 1),
(2174, 138, 'Veracruz-Llave', 'VE', 1),
(2175, 138, 'Yucatan', 'YU', 1),
(2176, 138, 'Zacatecas', 'ZA', 1),
(2177, 139, 'Chuuk', 'C', 1),
(2178, 139, 'Kosrae', 'K', 1),
(2179, 139, 'Pohnpei', 'P', 1),
(2180, 139, 'Yap', 'Y', 1),
(2181, 140, 'Gagauzia', 'GA', 1),
(2182, 140, 'Chisinau', 'CU', 1),
(2183, 140, 'Balti', 'BA', 1),
(2184, 140, 'Cahul', 'CA', 1),
(2185, 140, 'Edinet', 'ED', 1),
(2186, 140, 'Lapusna', 'LA', 1),
(2187, 140, 'Orhei', 'OR', 1),
(2188, 140, 'Soroca', 'SO', 1),
(2189, 140, 'Tighina', 'TI', 1),
(2190, 140, 'Ungheni', 'UN', 1),
(2191, 140, 'St‚nga Nistrului', 'SN', 1),
(2192, 141, 'Fontvieille', 'FV', 1),
(2193, 141, 'La Condamine', 'LC', 1),
(2194, 141, 'Monaco-Ville', 'MV', 1),
(2195, 141, 'Monte-Carlo', 'MC', 1),
(2196, 142, 'Ulanbaatar', '1', 1),
(2197, 142, 'Orhon', '035', 1),
(2198, 142, 'Darhan uul', '037', 1),
(2199, 142, 'Hentiy', '039', 1),
(2200, 142, 'Hovsgol', '041', 1),
(2201, 142, 'Hovd', '043', 1),
(2202, 142, 'Uvs', '046', 1),
(2203, 142, 'Tov', '047', 1),
(2204, 142, 'Selenge', '049', 1),
(2205, 142, 'Suhbaatar', '051', 1),
(2206, 142, 'Omnogovi', '053', 1),
(2207, 142, 'Ovorhangay', '055', 1),
(2208, 142, 'Dzavhan', '057', 1),
(2209, 142, 'DundgovL', '059', 1),
(2210, 142, 'Dornod', '061', 1),
(2211, 142, 'Dornogov', '063', 1),
(2212, 142, 'Govi-Sumber', '064', 1),
(2213, 142, 'Govi-Altay', '065', 1),
(2214, 142, 'Bulgan', '067', 1),
(2215, 142, 'Bayanhongor', '069', 1),
(2216, 142, 'Bayan-Olgiy', '071', 1),
(2217, 142, 'Arhangay', '073', 1),
(2218, 143, 'Saint Anthony', 'A', 1),
(2219, 143, 'Saint Georges', 'G', 1),
(2220, 143, 'Saint Peter', 'P', 1),
(2221, 144, 'Agadir', 'AGD', 1),
(2222, 144, 'Al Hoceima', 'HOC', 1),
(2223, 144, 'Azilal', 'AZI', 1),
(2224, 144, 'Beni Mellal', 'BME', 1),
(2225, 144, 'Ben Slimane', 'BSL', 1),
(2226, 144, 'Boulemane', 'BLM', 1),
(2227, 144, 'Casablanca', 'CBL', 1),
(2228, 144, 'Chaouen', 'CHA', 1),
(2229, 144, 'El Jadida', 'EJA', 1),
(2230, 144, 'El Kelaa des Sraghna', 'EKS', 1),
(2231, 144, 'Er Rachidia', 'ERA', 1),
(2232, 144, 'Essaouira', 'ESS', 1),
(2233, 144, 'Fes', 'FES', 1),
(2234, 144, 'Figuig', 'FIG', 1),
(2235, 144, 'Guelmim', 'GLM', 1),
(2236, 144, 'Ifrane', 'IFR', 1),
(2237, 144, 'Kenitra', 'KEN', 1),
(2238, 144, 'Khemisset', 'KHM', 1),
(2239, 144, 'Khenifra', 'KHN', 1),
(2240, 144, 'Khouribga', 'KHO', 1),
(2241, 144, 'Laayoune', 'LYN', 1),
(2242, 144, 'Larache', 'LAR', 1),
(2243, 144, 'Marrakech', 'MRK', 1),
(2244, 144, 'Meknes', 'MKN', 1),
(2245, 144, 'Nador', 'NAD', 1),
(2246, 144, 'Ouarzazate', 'ORZ', 1),
(2247, 144, 'Oujda', 'OUJ', 1),
(2248, 144, 'Rabat-Sale', 'RSA', 1),
(2249, 144, 'Safi', 'SAF', 1),
(2250, 144, 'Settat', 'SET', 1),
(2251, 144, 'Sidi Kacem', 'SKA', 1),
(2252, 144, 'Tangier', 'TGR', 1),
(2253, 144, 'Tan-Tan', 'TAN', 1),
(2254, 144, 'Taounate', 'TAO', 1),
(2255, 144, 'Taroudannt', 'TRD', 1),
(2256, 144, 'Tata', 'TAT', 1),
(2257, 144, 'Taza', 'TAZ', 1),
(2258, 144, 'Tetouan', 'TET', 1),
(2259, 144, 'Tiznit', 'TIZ', 1),
(2260, 144, 'Ad Dakhla', 'ADK', 1),
(2261, 144, 'Boujdour', 'BJD', 1),
(2262, 144, 'Es Smara', 'ESM', 1),
(2263, 145, 'Cabo Delgado', 'CD', 1),
(2264, 145, 'Gaza', 'GZ', 1),
(2265, 145, 'Inhambane', 'IN', 1),
(2266, 145, 'Manica', 'MN', 1),
(2267, 145, 'Maputo (city)', 'MC', 1),
(2268, 145, 'Maputo', 'MP', 1),
(2269, 145, 'Nampula', 'NA', 1),
(2270, 145, 'Niassa', 'NI', 1),
(2271, 145, 'Sofala', 'SO', 1),
(2272, 145, 'Tete', 'TE', 1),
(2273, 145, 'Zambezia', 'ZA', 1),
(2274, 146, 'Ayeyarwady', 'AY', 1),
(2275, 146, 'Bago', 'BG', 1),
(2276, 146, 'Magway', 'MG', 1),
(2277, 146, 'Mandalay', 'MD', 1),
(2278, 146, 'Sagaing', 'SG', 1),
(2279, 146, 'Tanintharyi', 'TN', 1),
(2280, 146, 'Yangon', 'YG', 1),
(2281, 146, 'Chin State', 'CH', 1),
(2282, 146, 'Kachin State', 'KC', 1),
(2283, 146, 'Kayah State', 'KH', 1),
(2284, 146, 'Kayin State', 'KN', 1),
(2285, 146, 'Mon State', 'MN', 1),
(2286, 146, 'Rakhine State', 'RK', 1),
(2287, 146, 'Shan State', 'SH', 1),
(2288, 147, 'Caprivi', 'CA', 1),
(2289, 147, 'Erongo', 'ER', 1),
(2290, 147, 'Hardap', 'HA', 1),
(2291, 147, 'Karas', 'KR', 1),
(2292, 147, 'Kavango', 'KV', 1),
(2293, 147, 'Khomas', 'KH', 1),
(2294, 147, 'Kunene', 'KU', 1),
(2295, 147, 'Ohangwena', 'OW', 1),
(2296, 147, 'Omaheke', 'OK', 1),
(2297, 147, 'Omusati', 'OT', 1),
(2298, 147, 'Oshana', 'ON', 1),
(2299, 147, 'Oshikoto', 'OO', 1),
(2300, 147, 'Otjozondjupa', 'OJ', 1),
(2301, 148, 'Aiwo', 'AO', 1),
(2302, 148, 'Anabar', 'AA', 1),
(2303, 148, 'Anetan', 'AT', 1),
(2304, 148, 'Anibare', 'AI', 1),
(2305, 148, 'Baiti', 'BA', 1),
(2306, 148, 'Boe', 'BO', 1),
(2307, 148, 'Buada', 'BU', 1),
(2308, 148, 'Denigomodu', 'DE', 1),
(2309, 148, 'Ewa', 'EW', 1),
(2310, 148, 'Ijuw', 'IJ', 1),
(2311, 148, 'Meneng', 'ME', 1),
(2312, 148, 'Nibok', 'NI', 1),
(2313, 148, 'Uaboe', 'UA', 1),
(2314, 148, 'Yaren', 'YA', 1),
(2315, 149, 'Bagmati', 'BA', 1),
(2316, 149, 'Bheri', 'BH', 1),
(2317, 149, 'Dhawalagiri', 'DH', 1),
(2318, 149, 'Gandaki', 'GA', 1),
(2319, 149, 'Janakpur', 'JA', 1),
(2320, 149, 'Karnali', 'KA', 1),
(2321, 149, 'Kosi', 'KO', 1),
(2322, 149, 'Lumbini', 'LU', 1),
(2323, 149, 'Mahakali', 'MA', 1),
(2324, 149, 'Mechi', 'ME', 1),
(2325, 149, 'Narayani', 'NA', 1),
(2326, 149, 'Rapti', 'RA', 1),
(2327, 149, 'Sagarmatha', 'SA', 1),
(2328, 149, 'Seti', 'SE', 1),
(2329, 150, 'Drenthe', 'DR', 1),
(2330, 150, 'Flevoland', 'FL', 1),
(2331, 150, 'Friesland', 'FR', 1),
(2332, 150, 'Gelderland', 'GE', 1),
(2333, 150, 'Groningen', 'GR', 1),
(2334, 150, 'Limburg', 'LI', 1),
(2335, 150, 'Noord-Brabant', 'NB', 1),
(2336, 150, 'Noord-Holland', 'NH', 1),
(2337, 150, 'Overijssel', 'OV', 1),
(2338, 150, 'Utrecht', 'UT', 1),
(2339, 150, 'Zeeland', 'ZE', 1),
(2340, 150, 'Zuid-Holland', 'ZH', 1),
(2341, 152, 'Iles Loyaute', 'L', 1),
(2342, 152, 'Nord', 'N', 1),
(2343, 152, 'Sud', 'S', 1),
(2344, 153, 'Auckland', 'AUK', 1),
(2345, 153, 'Bay of Plenty', 'BOP', 1),
(2346, 153, 'Canterbury', 'CAN', 1),
(2347, 153, 'Coromandel', 'COR', 1),
(2348, 153, 'Gisborne', 'GIS', 1),
(2349, 153, 'Fiordland', 'FIO', 1),
(2350, 153, 'Hawke s Bay', 'HKB', 1),
(2351, 153, 'Marlborough', 'MBH', 1),
(2352, 153, 'Manawatu-Wanganui', 'MWT', 1),
(2353, 153, 'Mt Cook-Mackenzie', 'MCM', 1),
(2354, 153, 'Nelson', 'NSN', 1),
(2355, 153, 'Northland', 'NTL', 1),
(2356, 153, 'Otago', 'OTA', 1),
(2357, 153, 'Southland', 'STL', 1),
(2358, 153, 'Taranaki', 'TKI', 1),
(2359, 153, 'Wellington', 'WGN', 1),
(2360, 153, 'Waikato', 'WKO', 1),
(2361, 153, 'Wairarapa', 'WAI', 1),
(2362, 153, 'West Coast', 'WTC', 1),
(2363, 154, 'Atlantico Norte', 'AN', 1),
(2364, 154, 'Atlantico Sur', 'AS', 1),
(2365, 154, 'Boaco', 'BO', 1),
(2366, 154, 'Carazo', 'CA', 1),
(2367, 154, 'Chinandega', 'CI', 1),
(2368, 154, 'Chontales', 'CO', 1),
(2369, 154, 'Esteli', 'ES', 1),
(2370, 154, 'Granada', 'GR', 1),
(2371, 154, 'Jinotega', 'JI', 1),
(2372, 154, 'Leon', 'LE', 1),
(2373, 154, 'Madriz', 'MD', 1),
(2374, 154, 'Managua', 'MN', 1),
(2375, 154, 'Masaya', 'MS', 1),
(2376, 154, 'Matagalpa', 'MT', 1),
(2377, 154, 'Nuevo Segovia', 'NS', 1),
(2378, 154, 'Rio San Juan', 'RS', 1),
(2379, 154, 'Rivas', 'RI', 1),
(2380, 155, 'Agadez', 'AG', 1),
(2381, 155, 'Diffa', 'DF', 1),
(2382, 155, 'Dosso', 'DS', 1),
(2383, 155, 'Maradi', 'MA', 1),
(2384, 155, 'Niamey', 'NM', 1),
(2385, 155, 'Tahoua', 'TH', 1),
(2386, 155, 'Tillaberi', 'TL', 1),
(2387, 155, 'Zinder', 'ZD', 1),
(2388, 156, 'Abia', 'AB', 1),
(2389, 156, 'Abuja Federal Capital Territory', 'CT', 1),
(2390, 156, 'Adamawa', 'AD', 1),
(2391, 156, 'Akwa Ibom', 'AK', 1),
(2392, 156, 'Anambra', 'AN', 1),
(2393, 156, 'Bauchi', 'BC', 1),
(2394, 156, 'Bayelsa', 'BY', 1),
(2395, 156, 'Benue', 'BN', 1),
(2396, 156, 'Borno', 'BO', 1),
(2397, 156, 'Cross River', 'CR', 1),
(2398, 156, 'Delta', 'DE', 1),
(2399, 156, 'Ebonyi', 'EB', 1),
(2400, 156, 'Edo', 'ED', 1),
(2401, 156, 'Ekiti', 'EK', 1),
(2402, 156, 'Enugu', 'EN', 1),
(2403, 156, 'Gombe', 'GO', 1),
(2404, 156, 'Imo', 'IM', 1),
(2405, 156, 'Jigawa', 'JI', 1),
(2406, 156, 'Kaduna', 'KD', 1),
(2407, 156, 'Kano', 'KN', 1),
(2408, 156, 'Katsina', 'KT', 1),
(2409, 156, 'Kebbi', 'KE', 1),
(2410, 156, 'Kogi', 'KO', 1),
(2411, 156, 'Kwara', 'KW', 1),
(2412, 156, 'Lagos', 'LA', 1),
(2413, 156, 'Nassarawa', 'NA', 1),
(2414, 156, 'Niger', 'NI', 1),
(2415, 156, 'Ogun', 'OG', 1),
(2416, 156, 'Ondo', 'ONG', 1),
(2417, 156, 'Osun', 'OS', 1),
(2418, 156, 'Oyo', 'OY', 1),
(2419, 156, 'Plateau', 'PL', 1),
(2420, 156, 'Rivers', 'RI', 1),
(2421, 156, 'Sokoto', 'SO', 1),
(2422, 156, 'Taraba', 'TA', 1),
(2423, 156, 'Yobe', 'YO', 1),
(2424, 156, 'Zamfara', 'ZA', 1),
(2425, 159, 'Northern Islands', 'N', 1),
(2426, 159, 'Rota', 'R', 1),
(2427, 159, 'Saipan', 'S', 1),
(2428, 159, 'Tinian', 'T', 1),
(2429, 160, 'Akershus', 'AK', 1),
(2430, 160, 'Aust-Agder', 'AA', 1),
(2431, 160, 'Buskerud', 'BU', 1),
(2432, 160, 'Finnmark', 'FM', 1),
(2433, 160, 'Hedmark', 'HM', 1),
(2434, 160, 'Hordaland', 'HL', 1),
(2435, 160, 'More og Romdal', 'MR', 1),
(2436, 160, 'Nord-Trondelag', 'NT', 1),
(2437, 160, 'Nordland', 'NL', 1),
(2438, 160, 'Ostfold', 'OF', 1),
(2439, 160, 'Oppland', 'OP', 1),
(2440, 160, 'Oslo', 'OL', 1),
(2441, 160, 'Rogaland', 'RL', 1),
(2442, 160, 'Sor-Trondelag', 'ST', 1),
(2443, 160, 'Sogn og Fjordane', 'SJ', 1),
(2444, 160, 'Svalbard', 'SV', 1),
(2445, 160, 'Telemark', 'TM', 1),
(2446, 160, 'Troms', 'TR', 1),
(2447, 160, 'Vest-Agder', 'VA', 1),
(2448, 160, 'Vestfold', 'VF', 1),
(2449, 161, 'Ad Dakhiliyah', 'DA', 1),
(2450, 161, 'Al Batinah', 'BA', 1),
(2451, 161, 'Al Wusta', 'WU', 1),
(2452, 161, 'Ash Sharqiyah', 'SH', 1),
(2453, 161, 'Az Zahirah', 'ZA', 1),
(2454, 161, 'Masqat', 'MA', 1),
(2455, 161, 'Musandam', 'MU', 1),
(2456, 161, 'Zufar', 'ZU', 1),
(2457, 162, 'Balochistan', 'B', 1),
(2458, 162, 'Federally Administered Tribal Areas', 'T', 1),
(2459, 162, 'Islamabad Capital Territory', 'I', 1),
(2460, 162, 'North-West Frontier', 'N', 1),
(2461, 162, 'Punjab', 'P', 1),
(2462, 162, 'Sindh', 'S', 1),
(2463, 163, 'Aimeliik', 'AM', 1),
(2464, 163, 'Airai', 'AR', 1),
(2465, 163, 'Angaur', 'AN', 1),
(2466, 163, 'Hatohobei', 'HA', 1),
(2467, 163, 'Kayangel', 'KA', 1),
(2468, 163, 'Koror', 'KO', 1),
(2469, 163, 'Melekeok', 'ME', 1),
(2470, 163, 'Ngaraard', 'NA', 1),
(2471, 163, 'Ngarchelong', 'NG', 1),
(2472, 163, 'Ngardmau', 'ND', 1),
(2473, 163, 'Ngatpang', 'NT', 1),
(2474, 163, 'Ngchesar', 'NC', 1),
(2475, 163, 'Ngeremlengui', 'NR', 1),
(2476, 163, 'Ngiwal', 'NW', 1),
(2477, 163, 'Peleliu', 'PE', 1),
(2478, 163, 'Sonsorol', 'SO', 1),
(2479, 164, 'Bocas del Toro', 'BT', 1),
(2480, 164, 'Chiriqui', 'CH', 1),
(2481, 164, 'Cocle', 'CC', 1),
(2482, 164, 'Colon', 'CL', 1),
(2483, 164, 'Darien', 'DA', 1),
(2484, 164, 'Herrera', 'HE', 1),
(2485, 164, 'Los Santos', 'LS', 1),
(2486, 164, 'Panama', 'PA', 1),
(2487, 164, 'San Blas', 'SB', 1),
(2488, 164, 'Veraguas', 'VG', 1),
(2489, 165, 'Bougainville', 'BV', 1),
(2490, 165, 'Central', 'CE', 1),
(2491, 165, 'Chimbu', 'CH', 1),
(2492, 165, 'Eastern Highlands', 'EH', 1),
(2493, 165, 'East New Britain', 'EB', 1),
(2494, 165, 'East Sepik', 'ES', 1),
(2495, 165, 'Enga', 'EN', 1),
(2496, 165, 'Gulf', 'GU', 1),
(2497, 165, 'Madang', 'MD', 1),
(2498, 165, 'Manus', 'MN', 1),
(2499, 165, 'Milne Bay', 'MB', 1),
(2500, 165, 'Morobe', 'MR', 1),
(2501, 165, 'National Capital', 'NC', 1),
(2502, 165, 'New Ireland', 'NI', 1),
(2503, 165, 'Northern', 'NO', 1),
(2504, 165, 'Sandaun', 'SA', 1),
(2505, 165, 'Southern Highlands', 'SH', 1),
(2506, 165, 'Western', 'WE', 1),
(2507, 165, 'Western Highlands', 'WH', 1),
(2508, 165, 'West New Britain', 'WB', 1),
(2509, 166, 'Alto Paraguay', 'AG', 1),
(2510, 166, 'Alto Parana', 'AN', 1),
(2511, 166, 'Amambay', 'AM', 1),
(2512, 166, 'Asuncion', 'AS', 1),
(2513, 166, 'Boqueron', 'BO', 1),
(2514, 166, 'Caaguazu', 'CG', 1),
(2515, 166, 'Caazapa', 'CZ', 1),
(2516, 166, 'Canindeyu', 'CN', 1),
(2517, 166, 'Central', 'CE', 1),
(2518, 166, 'Concepcion', 'CC', 1),
(2519, 166, 'Cordillera', 'CD', 1),
(2520, 166, 'Guaira', 'GU', 1),
(2521, 166, 'Itapua', 'IT', 1),
(2522, 166, 'Misiones', 'MI', 1),
(2523, 166, 'Neembucu', 'NE', 1),
(2524, 166, 'Paraguari', 'PA', 1),
(2525, 166, 'Presidente Hayes', 'PH', 1),
(2526, 166, 'San Pedro', 'SP', 1),
(2527, 167, 'Amazonas', 'AM', 1),
(2528, 167, 'Ancash', 'AN', 1),
(2529, 167, 'Apurimac', 'AP', 1),
(2530, 167, 'Arequipa', 'AR', 1),
(2531, 167, 'Ayacucho', 'AY', 1),
(2532, 167, 'Cajamarca', 'CJ', 1),
(2533, 167, 'Callao', 'CL', 1),
(2534, 167, 'Cusco', 'CU', 1),
(2535, 167, 'Huancavelica', 'HV', 1),
(2536, 167, 'Huanuco', 'HO', 1),
(2537, 167, 'Ica', 'IC', 1),
(2538, 167, 'Junin', 'JU', 1),
(2539, 167, 'La Libertad', 'LD', 1),
(2540, 167, 'Lambayeque', 'LY', 1),
(2541, 167, 'Lima', 'LI', 1),
(2542, 167, 'Loreto', 'LO', 1),
(2543, 167, 'Madre de Dios', 'MD', 1),
(2544, 167, 'Moquegua', 'MO', 1),
(2545, 167, 'Pasco', 'PA', 1),
(2546, 167, 'Piura', 'PI', 1),
(2547, 167, 'Puno', 'PU', 1),
(2548, 167, 'San Martin', 'SM', 1),
(2549, 167, 'Tacna', 'TA', 1),
(2550, 167, 'Tumbes', 'TU', 1),
(2551, 167, 'Ucayali', 'UC', 1),
(2552, 168, 'Abra', 'ABR', 1),
(2553, 168, 'Agusan del Norte', 'ANO', 1),
(2554, 168, 'Agusan del Sur', 'ASU', 1),
(2555, 168, 'Aklan', 'AKL', 1),
(2556, 168, 'Albay', 'ALB', 1),
(2557, 168, 'Antique', 'ANT', 1),
(2558, 168, 'Apayao', 'APY', 1),
(2559, 168, 'Aurora', 'AUR', 1),
(2560, 168, 'Basilan', 'BAS', 1),
(2561, 168, 'Bataan', 'BTA', 1),
(2562, 168, 'Batanes', 'BTE', 1),
(2563, 168, 'Batangas', 'BTG', 1),
(2564, 168, 'Biliran', 'BLR', 1),
(2565, 168, 'Benguet', 'BEN', 1),
(2566, 168, 'Bohol', 'BOL', 1),
(2567, 168, 'Bukidnon', 'BUK', 1),
(2568, 168, 'Bulacan', 'BUL', 1),
(2569, 168, 'Cagayan', 'CAG', 1),
(2570, 168, 'Camarines Norte', 'CNO', 1),
(2571, 168, 'Camarines Sur', 'CSU', 1),
(2572, 168, 'Camiguin', 'CAM', 1),
(2573, 168, 'Capiz', 'CAP', 1),
(2574, 168, 'Catanduanes', 'CAT', 1),
(2575, 168, 'Cavite', 'CAV', 1),
(2576, 168, 'Cebu', 'CEB', 1),
(2577, 168, 'Compostela', 'CMP', 1),
(2578, 168, 'Davao del Norte', 'DNO', 1),
(2579, 168, 'Davao del Sur', 'DSU', 1),
(2580, 168, 'Davao Oriental', 'DOR', 1),
(2581, 168, 'Eastern Samar', 'ESA', 1),
(2582, 168, 'Guimaras', 'GUI', 1),
(2583, 168, 'Ifugao', 'IFU', 1),
(2584, 168, 'Ilocos Norte', 'INO', 1),
(2585, 168, 'Ilocos Sur', 'ISU', 1),
(2586, 168, 'Iloilo', 'ILO', 1),
(2587, 168, 'Isabela', 'ISA', 1),
(2588, 168, 'Kalinga', 'KAL', 1),
(2589, 168, 'Laguna', 'LAG', 1),
(2590, 168, 'Lanao del Norte', 'LNO', 1),
(2591, 168, 'Lanao del Sur', 'LSU', 1),
(2592, 168, 'La Union', 'UNI', 1),
(2593, 168, 'Leyte', 'LEY', 1),
(2594, 168, 'Maguindanao', 'MAG', 1),
(2595, 168, 'Marinduque', 'MRN', 1),
(2596, 168, 'Masbate', 'MSB', 1),
(2597, 168, 'Mindoro Occidental', 'MIC', 1),
(2598, 168, 'Mindoro Oriental', 'MIR', 1),
(2599, 168, 'Misamis Occidental', 'MSC', 1),
(2600, 168, 'Misamis Oriental', 'MOR', 1),
(2601, 168, 'Mountain', 'MOP', 1),
(2602, 168, 'Negros Occidental', 'NOC', 1),
(2603, 168, 'Negros Oriental', 'NOR', 1),
(2604, 168, 'North Cotabato', 'NCT', 1),
(2605, 168, 'Northern Samar', 'NSM', 1),
(2606, 168, 'Nueva Ecija', 'NEC', 1),
(2607, 168, 'Nueva Vizcaya', 'NVZ', 1),
(2608, 168, 'Palawan', 'PLW', 1),
(2609, 168, 'Pampanga', 'PMP', 1),
(2610, 168, 'Pangasinan', 'PNG', 1),
(2611, 168, 'Quezon', 'QZN', 1),
(2612, 168, 'Quirino', 'QRN', 1),
(2613, 168, 'Rizal', 'RIZ', 1),
(2614, 168, 'Romblon', 'ROM', 1),
(2615, 168, 'Samar', 'SMR', 1),
(2616, 168, 'Sarangani', 'SRG', 1),
(2617, 168, 'Siquijor', 'SQJ', 1),
(2618, 168, 'Sorsogon', 'SRS', 1),
(2619, 168, 'South Cotabato', 'SCO', 1),
(2620, 168, 'Southern Leyte', 'SLE', 1),
(2621, 168, 'Sultan Kudarat', 'SKU', 1),
(2622, 168, 'Sulu', 'SLU', 1),
(2623, 168, 'Surigao del Norte', 'SNO', 1),
(2624, 168, 'Surigao del Sur', 'SSU', 1),
(2625, 168, 'Tarlac', 'TAR', 1),
(2626, 168, 'Tawi-Tawi', 'TAW', 1),
(2627, 168, 'Zambales', 'ZBL', 1),
(2628, 168, 'Zamboanga del Norte', 'ZNO', 1),
(2629, 168, 'Zamboanga del Sur', 'ZSU', 1),
(2630, 168, 'Zamboanga Sibugay', 'ZSI', 1),
(2631, 170, 'Dolnoslaskie', 'DO', 1),
(2632, 170, 'Kujawsko-Pomorskie', 'KP', 1),
(2633, 170, 'Lodzkie', 'LO', 1),
(2634, 170, 'Lubelskie', 'LL', 1),
(2635, 170, 'Lubuskie', 'LU', 1),
(2636, 170, 'Malopolskie', 'ML', 1),
(2637, 170, 'Mazowieckie', 'MZ', 1),
(2638, 170, 'Opolskie', 'OP', 1),
(2639, 170, 'Podkarpackie', 'PP', 1),
(2640, 170, 'Podlaskie', 'PL', 1),
(2641, 170, 'Pomorskie', 'PM', 1),
(2642, 170, 'Slaskie', 'SL', 1),
(2643, 170, 'Swietokrzyskie', 'SW', 1),
(2644, 170, 'Warminsko-Mazurskie', 'WM', 1),
(2645, 170, 'Wielkopolskie', 'WP', 1),
(2646, 170, 'Zachodniopomorskie', 'ZA', 1),
(2647, 198, 'Saint Pierre', 'P', 1),
(2648, 198, 'Miquelon', 'M', 1),
(2649, 171, 'Açores', 'AC', 1),
(2650, 171, 'Aveiro', 'AV', 1),
(2651, 171, 'Beja', 'BE', 1),
(2652, 171, 'Braga', 'BR', 1),
(2653, 171, 'Bragança', 'BA', 1),
(2654, 171, 'Castelo Branco', 'CB', 1),
(2655, 171, 'Coimbra', 'CO', 1),
(2656, 171, 'Évora', 'EV', 1),
(2657, 171, 'Faro', 'FA', 1),
(2658, 171, 'Guarda', 'GU', 1),
(2659, 171, 'Leiria', 'LE', 1),
(2660, 171, 'Lisboa', 'LI', 1),
(2661, 171, 'Madeira', 'ME', 1),
(2662, 171, 'Portalegre', 'PO', 1),
(2663, 171, 'Porto', 'PR', 1),
(2664, 171, 'Santarém', 'SA', 1),
(2665, 171, 'Setúbal', 'SE', 1),
(2666, 171, 'Viana do Castelo', 'VC', 1),
(2667, 171, 'Vila Real', 'VR', 1),
(2668, 171, 'Viseu', 'VI', 1),
(2669, 173, 'Ad Dawhah', 'DW', 1),
(2670, 173, 'Al Ghuwayriyah', 'GW', 1),
(2671, 173, 'Al Jumayliyah', 'JM', 1),
(2672, 173, 'Al Khawr', 'KR', 1),
(2673, 173, 'Al Wakrah', 'WK', 1),
(2674, 173, 'Ar Rayyan', 'RN', 1),
(2675, 173, 'Jarayan al Batinah', 'JB', 1),
(2676, 173, 'Madinat ash Shamal', 'MS', 1),
(2677, 173, 'Umm Sa id', 'UD', 1),
(2678, 173, 'Umm Salal', 'UL', 1),
(2679, 175, 'Alba', 'AB', 1),
(2680, 175, 'Arad', 'AR', 1),
(2681, 175, 'Arges', 'AG', 1),
(2682, 175, 'Bacau', 'BC', 1),
(2683, 175, 'Bihor', 'BH', 1),
(2684, 175, 'Bistrita-Nasaud', 'BN', 1),
(2685, 175, 'Botosani', 'BT', 1),
(2686, 175, 'Brasov', 'BV', 1),
(2687, 175, 'Braila', 'BR', 1),
(2688, 175, 'Bucuresti', 'B', 1),
(2689, 175, 'Buzau', 'BZ', 1),
(2690, 175, 'Caras-Severin', 'CS', 1),
(2691, 175, 'Calarasi', 'CL', 1),
(2692, 175, 'Cluj', 'CJ', 1),
(2693, 175, 'Constanta', 'CT', 1),
(2694, 175, 'Covasna', 'CV', 1),
(2695, 175, 'Dimbovita', 'DB', 1),
(2696, 175, 'Dolj', 'DJ', 1),
(2697, 175, 'Galati', 'GL', 1),
(2698, 175, 'Giurgiu', 'GR', 1),
(2699, 175, 'Gorj', 'GJ', 1),
(2700, 175, 'Harghita', 'HR', 1),
(2701, 175, 'Hunedoara', 'HD', 1),
(2702, 175, 'Ialomita', 'IL', 1),
(2703, 175, 'Iasi', 'IS', 1),
(2704, 175, 'Ilfov', 'IF', 1),
(2705, 175, 'Maramures', 'MM', 1),
(2706, 175, 'Mehedinti', 'MH', 1),
(2707, 175, 'Mures', 'MS', 1),
(2708, 175, 'Neamt', 'NT', 1),
(2709, 175, 'Olt', 'OT', 1),
(2710, 175, 'Prahova', 'PH', 1),
(2711, 175, 'Satu-Mare', 'SM', 1),
(2712, 175, 'Salaj', 'SJ', 1),
(2713, 175, 'Sibiu', 'SB', 1),
(2714, 175, 'Suceava', 'SV', 1),
(2715, 175, 'Teleorman', 'TR', 1),
(2716, 175, 'Timis', 'TM', 1),
(2717, 175, 'Tulcea', 'TL', 1),
(2718, 175, 'Vaslui', 'VS', 1),
(2719, 175, 'Valcea', 'VL', 1),
(2720, 175, 'Vrancea', 'VN', 1),
(2721, 176, 'Abakan', 'AB', 1),
(2722, 176, 'Aginskoye', 'AG', 1),
(2723, 176, 'Anadyr', 'AN', 1),
(2724, 176, 'Arkahangelsk', 'AR', 1),
(2725, 176, 'Astrakhan', 'AS', 1),
(2726, 176, 'Barnaul', 'BA', 1),
(2727, 176, 'Belgorod', 'BE', 1),
(2728, 176, 'Birobidzhan', 'BI', 1),
(2729, 176, 'Blagoveshchensk', 'BL', 1),
(2730, 176, 'Bryansk', 'BR', 1),
(2731, 176, 'Cheboksary', 'CH', 1),
(2732, 176, 'Chelyabinsk', 'CL', 1),
(2733, 176, 'Cherkessk', 'CR', 1),
(2734, 176, 'Chita', 'CI', 1),
(2735, 176, 'Dudinka', 'DU', 1),
(2736, 176, 'Elista', 'EL', 1),
(2738, 176, 'Gorno-Altaysk', 'GA', 1),
(2739, 176, 'Groznyy', 'GR', 1),
(2740, 176, 'Irkutsk', 'IR', 1),
(2741, 176, 'Ivanovo', 'IV', 1),
(2742, 176, 'Izhevsk', 'IZ', 1),
(2743, 176, 'Kalinigrad', 'KA', 1),
(2744, 176, 'Kaluga', 'KL', 1),
(2745, 176, 'Kasnodar', 'KS', 1),
(2746, 176, 'Kazan', 'KZ', 1),
(2747, 176, 'Kemerovo', 'KE', 1),
(2748, 176, 'Khabarovsk', 'KH', 1),
(2749, 176, 'Khanty-Mansiysk', 'KM', 1),
(2750, 176, 'Kostroma', 'KO', 1),
(2751, 176, 'Krasnodar', 'KR', 1),
(2752, 176, 'Krasnoyarsk', 'KN', 1),
(2753, 176, 'Kudymkar', 'KU', 1),
(2754, 176, 'Kurgan', 'KG', 1),
(2755, 176, 'Kursk', 'KK', 1),
(2756, 176, 'Kyzyl', 'KY', 1),
(2757, 176, 'Lipetsk', 'LI', 1),
(2758, 176, 'Magadan', 'MA', 1),
(2759, 176, 'Makhachkala', 'MK', 1),
(2760, 176, 'Maykop', 'MY', 1),
(2761, 176, 'Moscow', 'MO', 1),
(2762, 176, 'Murmansk', 'MU', 1),
(2763, 176, 'Nalchik', 'NA', 1),
(2764, 176, 'Naryan Mar', 'NR', 1),
(2765, 176, 'Nazran', 'NZ', 1),
(2766, 176, 'Nizhniy Novgorod', 'NI', 1),
(2767, 176, 'Novgorod', 'NO', 1),
(2768, 176, 'Novosibirsk', 'NV', 1),
(2769, 176, 'Omsk', 'OM', 1),
(2770, 176, 'Orel', 'OR', 1),
(2771, 176, 'Orenburg', 'OE', 1),
(2772, 176, 'Palana', 'PA', 1),
(2773, 176, 'Penza', 'PE', 1),
(2774, 176, 'Perm', 'PR', 1),
(2775, 176, 'Petropavlovsk-Kamchatskiy', 'PK', 1),
(2776, 176, 'Petrozavodsk', 'PT', 1),
(2777, 176, 'Pskov', 'PS', 1),
(2778, 176, 'Rostov-na-Donu', 'RO', 1),
(2779, 176, 'Ryazan', 'RY', 1),
(2780, 176, 'Salekhard', 'SL', 1),
(2781, 176, 'Samara', 'SA', 1),
(2782, 176, 'Saransk', 'SR', 1),
(2783, 176, 'Saratov', 'SV', 1),
(2784, 176, 'Smolensk', 'SM', 1),
(2785, 176, 'St. Petersburg', 'SP', 1),
(2786, 176, 'Stavropol', 'ST', 1),
(2787, 176, 'Syktyvkar', 'SY', 1),
(2788, 176, 'Tambov', 'TA', 1),
(2789, 176, 'Tomsk', 'TO', 1),
(2790, 176, 'Tula', 'TU', 1),
(2791, 176, 'Tura', 'TR', 1),
(2792, 176, 'Tver', 'TV', 1),
(2793, 176, 'Tyumen', 'TY', 1),
(2794, 176, 'Ufa', 'UF', 1),
(2795, 176, 'Ul yanovsk', 'UL', 1),
(2796, 176, 'Ulan-Ude', 'UU', 1),
(2797, 176, 'Ust -Ordynskiy', 'US', 1),
(2798, 176, 'Vladikavkaz', 'VL', 1),
(2799, 176, 'Vladimir', 'VA', 1),
(2800, 176, 'Vladivostok', 'VV', 1),
(2801, 176, 'Volgograd', 'VG', 1),
(2802, 176, 'Vologda', 'VD', 1),
(2803, 176, 'Voronezh', 'VO', 1),
(2804, 176, 'Vyatka', 'VY', 1),
(2805, 176, 'Yakutsk', 'YA', 1),
(2806, 176, 'Yaroslavl', 'YR', 1),
(2807, 176, 'Yekaterinburg', 'YE', 1),
(2808, 176, 'Yoshkar-Ola', 'YO', 1),
(2809, 177, 'Butare', 'BU', 1),
(2810, 177, 'Byumba', 'BY', 1),
(2811, 177, 'Cyangugu', 'CY', 1),
(2812, 177, 'Gikongoro', 'GK', 1),
(2813, 177, 'Gisenyi', 'GS', 1),
(2814, 177, 'Gitarama', 'GT', 1),
(2815, 177, 'Kibungo', 'KG', 1),
(2816, 177, 'Kibuye', 'KY', 1),
(2817, 177, 'Kigali Rurale', 'KR', 1),
(2818, 177, 'Kigali-ville', 'KV', 1),
(2819, 177, 'Ruhengeri', 'RU', 1),
(2820, 177, 'Umutara', 'UM', 1),
(2821, 178, 'Christ Church Nichola Town', 'CCN', 1),
(2822, 178, 'Saint Anne Sandy Point', 'SAS', 1),
(2823, 178, 'Saint George Basseterre', 'SGB', 1),
(2824, 178, 'Saint George Gingerland', 'SGG', 1),
(2825, 178, 'Saint James Windward', 'SJW', 1),
(2826, 178, 'Saint John Capesterre', 'SJC', 1),
(2827, 178, 'Saint John Figtree', 'SJF', 1),
(2828, 178, 'Saint Mary Cayon', 'SMC', 1),
(2829, 178, 'Saint Paul Capesterre', 'CAP', 1),
(2830, 178, 'Saint Paul Charlestown', 'CHA', 1),
(2831, 178, 'Saint Peter Basseterre', 'SPB', 1),
(2832, 178, 'Saint Thomas Lowland', 'STL', 1),
(2833, 178, 'Saint Thomas Middle Island', 'STM', 1),
(2834, 178, 'Trinity Palmetto Point', 'TPP', 1),
(2835, 179, 'Anse-la-Raye', 'AR', 1),
(2836, 179, 'Castries', 'CA', 1),
(2837, 179, 'Choiseul', 'CH', 1),
(2838, 179, 'Dauphin', 'DA', 1),
(2839, 179, 'Dennery', 'DE', 1),
(2840, 179, 'Gros-Islet', 'GI', 1),
(2841, 179, 'Laborie', 'LA', 1),
(2842, 179, 'Micoud', 'MI', 1),
(2843, 179, 'Praslin', 'PR', 1),
(2844, 179, 'Soufriere', 'SO', 1),
(2845, 179, 'Vieux-Fort', 'VF', 1),
(2846, 180, 'Charlotte', 'C', 1),
(2847, 180, 'Grenadines', 'R', 1),
(2848, 180, 'Saint Andrew', 'A', 1),
(2849, 180, 'Saint David', 'D', 1),
(2850, 180, 'Saint George', 'G', 1),
(2851, 180, 'Saint Patrick', 'P', 1),
(2852, 181, 'A ana', 'AN', 1),
(2853, 181, 'Aiga-i-le-Tai', 'AI', 1),
(2854, 181, 'Atua', 'AT', 1),
(2855, 181, 'Fa asaleleaga', 'FA', 1),
(2856, 181, 'Gaga emauga', 'GE', 1),
(2857, 181, 'Gagaifomauga', 'GF', 1),
(2858, 181, 'Palauli', 'PA', 1),
(2859, 181, 'Satupa itea', 'SA', 1),
(2860, 181, 'Tuamasaga', 'TU', 1),
(2861, 181, 'Va a-o-Fonoti', 'VF', 1),
(2862, 181, 'Vaisigano', 'VS', 1),
(2863, 182, 'Acquaviva', 'AC', 1),
(2864, 182, 'Borgo Maggiore', 'BM', 1),
(2865, 182, 'Chiesanuova', 'CH', 1),
(2866, 182, 'Domagnano', 'DO', 1),
(2867, 182, 'Faetano', 'FA', 1),
(2868, 182, 'Fiorentino', 'FI', 1),
(2869, 182, 'Montegiardino', 'MO', 1),
(2870, 182, 'Citta di San Marino', 'SM', 1),
(2871, 182, 'Serravalle', 'SE', 1),
(2872, 183, 'Sao Tome', 'S', 1),
(2873, 183, 'Principe', 'P', 1),
(2874, 184, 'Al Bahah', 'BH', 1),
(2875, 184, 'Al Hudud ash Shamaliyah', 'HS', 1),
(2876, 184, 'Al Jawf', 'JF', 1),
(2877, 184, 'Al Madinah', 'MD', 1),
(2878, 184, 'Al Qasim', 'QS', 1),
(2879, 184, 'Ar Riyad', 'RD', 1),
(2880, 184, 'Ash Sharqiyah (Eastern)', 'AQ', 1),
(2881, 184, ' Asir', 'AS', 1),
(2882, 184, 'Ha il', 'HL', 1),
(2883, 184, 'Jizan', 'JZ', 1),
(2884, 184, 'Makkah', 'ML', 1),
(2885, 184, 'Najran', 'NR', 1),
(2886, 184, 'Tabuk', 'TB', 1),
(2887, 185, 'Dakar', 'DA', 1),
(2888, 185, 'Diourbel', 'DI', 1),
(2889, 185, 'Fatick', 'FA', 1),
(2890, 185, 'Kaolack', 'KA', 1),
(2891, 185, 'Kolda', 'KO', 1),
(2892, 185, 'Louga', 'LO', 1),
(2893, 185, 'Matam', 'MA', 1),
(2894, 185, 'Saint-Louis', 'SL', 1),
(2895, 185, 'Tambacounda', 'TA', 1),
(2896, 185, 'Thies', 'TH', 1),
(2897, 185, 'Ziguinchor', 'ZI', 1),
(2898, 186, 'Anse aux Pins', 'AP', 1),
(2899, 186, 'Anse Boileau', 'AB', 1),
(2900, 186, 'Anse Etoile', 'AE', 1),
(2901, 186, 'Anse Louis', 'AL', 1),
(2902, 186, 'Anse Royale', 'AR', 1),
(2903, 186, 'Baie Lazare', 'BL', 1),
(2904, 186, 'Baie Sainte Anne', 'BS', 1),
(2905, 186, 'Beau Vallon', 'BV', 1),
(2906, 186, 'Bel Air', 'BA', 1),
(2907, 186, 'Bel Ombre', 'BO', 1),
(2908, 186, 'Cascade', 'CA', 1),
(2909, 186, 'Glacis', 'GL', 1),
(2910, 186, 'Grand  Anse (on Mahe)', 'GM', 1),
(2911, 186, 'Grand  Anse (on Praslin)', 'GP', 1),
(2912, 186, 'La Digue', 'DG', 1),
(2913, 186, 'La Riviere Anglaise', 'RA', 1),
(2914, 186, 'Mont Buxton', 'MB', 1),
(2915, 186, 'Mont Fleuri', 'MF', 1),
(2916, 186, 'Plaisance', 'PL', 1),
(2917, 186, 'Pointe La Rue', 'PR', 1),
(2918, 186, 'Port Glaud', 'PG', 1),
(2919, 186, 'Saint Louis', 'SL', 1),
(2920, 186, 'Takamaka', 'TA', 1),
(2921, 187, 'Eastern', 'E', 1),
(2922, 187, 'Northern', 'N', 1),
(2923, 187, 'Southern', 'S', 1),
(2924, 187, 'Western', 'W', 1),
(2925, 189, 'Banskobystrický', 'BA', 1),
(2926, 189, 'Bratislavský', 'BR', 1),
(2927, 189, 'Košický', 'KO', 1),
(2928, 189, 'Nitriansky', 'NI', 1),
(2929, 189, 'Prešovský', 'PR', 1),
(2930, 189, 'Trenčiansky', 'TC', 1),
(2931, 189, 'Trnavský', 'TV', 1),
(2932, 189, 'Žilinský', 'ZI', 1),
(2933, 191, 'Central', 'CE', 1),
(2934, 191, 'Choiseul', 'CH', 1),
(2935, 191, 'Guadalcanal', 'GC', 1),
(2936, 191, 'Honiara', 'HO', 1),
(2937, 191, 'Isabel', 'IS', 1),
(2938, 191, 'Makira', 'MK', 1),
(2939, 191, 'Malaita', 'ML', 1),
(2940, 191, 'Rennell and Bellona', 'RB', 1),
(2941, 191, 'Temotu', 'TM', 1),
(2942, 191, 'Western', 'WE', 1),
(2943, 192, 'Awdal', 'AW', 1),
(2944, 192, 'Bakool', 'BK', 1),
(2945, 192, 'Banaadir', 'BN', 1),
(2946, 192, 'Bari', 'BR', 1),
(2947, 192, 'Bay', 'BY', 1),
(2948, 192, 'Galguduud', 'GA', 1),
(2949, 192, 'Gedo', 'GE', 1),
(2950, 192, 'Hiiraan', 'HI', 1),
(2951, 192, 'Jubbada Dhexe', 'JD', 1),
(2952, 192, 'Jubbada Hoose', 'JH', 1),
(2953, 192, 'Mudug', 'MU', 1),
(2954, 192, 'Nugaal', 'NU', 1),
(2955, 192, 'Sanaag', 'SA', 1),
(2956, 192, 'Shabeellaha Dhexe', 'SD', 1),
(2957, 192, 'Shabeellaha Hoose', 'SH', 1),
(2958, 192, 'Sool', 'SL', 1),
(2959, 192, 'Togdheer', 'TO', 1),
(2960, 192, 'Woqooyi Galbeed', 'WG', 1),
(2961, 193, 'Eastern Cape', 'EC', 1),
(2962, 193, 'Free State', 'FS', 1),
(2963, 193, 'Gauteng', 'GT', 1),
(2964, 193, 'KwaZulu-Natal', 'KN', 1),
(2965, 193, 'Limpopo', 'LP', 1),
(2966, 193, 'Mpumalanga', 'MP', 1),
(2967, 193, 'North West', 'NW', 1),
(2968, 193, 'Northern Cape', 'NC', 1),
(2969, 193, 'Western Cape', 'WC', 1),
(2970, 195, 'La Coruña', 'CA', 1),
(2971, 195, 'Álava', 'AL', 1),
(2972, 195, 'Albacete', 'AB', 1),
(2973, 195, 'Alicante', 'AC', 1),
(2974, 195, 'Almeria', 'AM', 1),
(2975, 195, 'Asturias', 'AS', 1),
(2976, 195, 'Ávila', 'AV', 1),
(2977, 195, 'Badajoz', 'BJ', 1),
(2978, 195, 'Baleares', 'IB', 1),
(2979, 195, 'Barcelona', 'BA', 1),
(2980, 195, 'Burgos', 'BU', 1),
(2981, 195, 'Cáceres', 'CC', 1),
(2982, 195, 'Cádiz', 'CZ', 1),
(2983, 195, 'Cantabria', 'CT', 1),
(2984, 195, 'Castellón', 'CL', 1),
(2985, 195, 'Ceuta', 'CE', 1),
(2986, 195, 'Ciudad Real', 'CR', 1),
(2987, 195, 'Córdoba', 'CD', 1),
(2988, 195, 'Cuenca', 'CU', 1),
(2989, 195, 'Girona', 'GI', 1),
(2990, 195, 'Granada', 'GD', 1),
(2991, 195, 'Guadalajara', 'GJ', 1),
(2992, 195, 'Guipúzcoa', 'GP', 1),
(2993, 195, 'Huelva', 'HL', 1),
(2994, 195, 'Huesca', 'HS', 1),
(2995, 195, 'Jaén', 'JN', 1),
(2996, 195, 'La Rioja', 'RJ', 1),
(2997, 195, 'Las Palmas', 'PM', 1),
(2998, 195, 'Leon', 'LE', 1),
(2999, 195, 'Lleida', 'LL', 1),
(3000, 195, 'Lugo', 'LG', 1),
(3001, 195, 'Madrid', 'MD', 1),
(3002, 195, 'Malaga', 'MA', 1),
(3003, 195, 'Melilla', 'ML', 1),
(3004, 195, 'Murcia', 'MU', 1),
(3005, 195, 'Navarra', 'NV', 1),
(3006, 195, 'Ourense', 'OU', 1),
(3007, 195, 'Palencia', 'PL', 1),
(3008, 195, 'Pontevedra', 'PO', 1),
(3009, 195, 'Salamanca', 'SL', 1),
(3010, 195, 'Santa Cruz de Tenerife', 'SC', 1),
(3011, 195, 'Segovia', 'SG', 1),
(3012, 195, 'Sevilla', 'SV', 1),
(3013, 195, 'Soria', 'SO', 1),
(3014, 195, 'Tarragona', 'TA', 1),
(3015, 195, 'Teruel', 'TE', 1),
(3016, 195, 'Toledo', 'TO', 1),
(3017, 195, 'Valencia', 'VC', 1),
(3018, 195, 'Valladolid', 'VD', 1),
(3019, 195, 'Vizcaya', 'VZ', 1),
(3020, 195, 'Zamora', 'ZM', 1),
(3021, 195, 'Zaragoza', 'ZR', 1),
(3022, 196, 'Central', 'CE', 1),
(3023, 196, 'Eastern', 'EA', 1),
(3024, 196, 'North Central', 'NC', 1),
(3025, 196, 'Northern', 'NO', 1),
(3026, 196, 'North Western', 'NW', 1),
(3027, 196, 'Sabaragamuwa', 'SA', 1),
(3028, 196, 'Southern', 'SO', 1),
(3029, 196, 'Uva', 'UV', 1),
(3030, 196, 'Western', 'WE', 1),
(3032, 197, 'Saint Helena', 'S', 1),
(3034, 199, 'A ali an Nil', 'ANL', 1),
(3035, 199, 'Al Bahr al Ahmar', 'BAM', 1),
(3036, 199, 'Al Buhayrat', 'BRT', 1),
(3037, 199, 'Al Jazirah', 'JZR', 1),
(3038, 199, 'Al Khartum', 'KRT', 1),
(3039, 199, 'Al Qadarif', 'QDR', 1),
(3040, 199, 'Al Wahdah', 'WDH', 1),
(3041, 199, 'An Nil al Abyad', 'ANB', 1),
(3042, 199, 'An Nil al Azraq', 'ANZ', 1),
(3043, 199, 'Ash Shamaliyah', 'ASH', 1),
(3044, 199, 'Bahr al Jabal', 'BJA', 1),
(3045, 199, 'Gharb al Istiwa iyah', 'GIS', 1),
(3046, 199, 'Gharb Bahr al Ghazal', 'GBG', 1),
(3047, 199, 'Gharb Darfur', 'GDA', 1),
(3048, 199, 'Gharb Kurdufan', 'GKU', 1),
(3049, 199, 'Janub Darfur', 'JDA', 1),
(3050, 199, 'Janub Kurdufan', 'JKU', 1),
(3051, 199, 'Junqali', 'JQL', 1),
(3052, 199, 'Kassala', 'KSL', 1),
(3053, 199, 'Nahr an Nil', 'NNL', 1),
(3054, 199, 'Shamal Bahr al Ghazal', 'SBG', 1),
(3055, 199, 'Shamal Darfur', 'SDA', 1),
(3056, 199, 'Shamal Kurdufan', 'SKU', 1),
(3057, 199, 'Sharq al Istiwa iyah', 'SIS', 1),
(3058, 199, 'Sinnar', 'SNR', 1),
(3059, 199, 'Warab', 'WRB', 1),
(3060, 200, 'Brokopondo', 'BR', 1),
(3061, 200, 'Commewijne', 'CM', 1),
(3062, 200, 'Coronie', 'CR', 1),
(3063, 200, 'Marowijne', 'MA', 1),
(3064, 200, 'Nickerie', 'NI', 1),
(3065, 200, 'Para', 'PA', 1),
(3066, 200, 'Paramaribo', 'PM', 1),
(3067, 200, 'Saramacca', 'SA', 1),
(3068, 200, 'Sipaliwini', 'SI', 1),
(3069, 200, 'Wanica', 'WA', 1),
(3070, 202, 'Hhohho', 'H', 1),
(3071, 202, 'Lubombo', 'L', 1),
(3072, 202, 'Manzini', 'M', 1),
(3073, 202, 'Shishelweni', 'S', 1),
(3074, 203, 'Blekinge', 'K', 1),
(3075, 203, 'Dalarna', 'W', 1),
(3076, 203, 'Gävleborg', 'X', 1),
(3077, 203, 'Gotland', 'I', 1),
(3078, 203, 'Halland', 'N', 1),
(3079, 203, 'Jämtland', 'Z', 1),
(3080, 203, 'Jönköping', 'F', 1),
(3081, 203, 'Kalmar', 'H', 1),
(3082, 203, 'Kronoberg', 'G', 1),
(3083, 203, 'Norrbotten', 'BD', 1),
(3084, 203, 'Örebro', 'T', 1),
(3085, 203, 'Östergötland', 'E', 1),
(3086, 203, 'Skåne', 'M', 1),
(3087, 203, 'Södermanland', 'D', 1),
(3088, 203, 'Stockholm', 'AB', 1),
(3089, 203, 'Uppsala', 'C', 1),
(3090, 203, 'Värmland', 'S', 1),
(3091, 203, 'Västerbotten', 'AC', 1),
(3092, 203, 'Västernorrland', 'Y', 1),
(3093, 203, 'Västmanland', 'U', 1),
(3094, 203, 'Västra Götaland', 'O', 1),
(3095, 204, 'Aargau', 'AG', 1),
(3096, 204, 'Appenzell Ausserrhoden', 'AR', 1),
(3097, 204, 'Appenzell Innerrhoden', 'AI', 1),
(3098, 204, 'Basel-Stadt', 'BS', 1),
(3099, 204, 'Basel-Landschaft', 'BL', 1),
(3100, 204, 'Bern', 'BE', 1),
(3101, 204, 'Fribourg', 'FR', 1),
(3102, 204, 'Genève', 'GE', 1),
(3103, 204, 'Glarus', 'GL', 1),
(3104, 204, 'Graubünden', 'GR', 1),
(3105, 204, 'Jura', 'JU', 1),
(3106, 204, 'Luzern', 'LU', 1),
(3107, 204, 'Neuchâtel', 'NE', 1),
(3108, 204, 'Nidwald', 'NW', 1),
(3109, 204, 'Obwald', 'OW', 1),
(3110, 204, 'St. Gallen', 'SG', 1),
(3111, 204, 'Schaffhausen', 'SH', 1),
(3112, 204, 'Schwyz', 'SZ', 1),
(3113, 204, 'Solothurn', 'SO', 1),
(3114, 204, 'Thurgau', 'TG', 1),
(3115, 204, 'Ticino', 'TI', 1),
(3116, 204, 'Uri', 'UR', 1),
(3117, 204, 'Valais', 'VS', 1),
(3118, 204, 'Vaud', 'VD', 1),
(3119, 204, 'Zug', 'ZG', 1),
(3120, 204, 'Zürich', 'ZH', 1),
(3121, 205, 'Al Hasakah', 'HA', 1),
(3122, 205, 'Al Ladhiqiyah', 'LA', 1),
(3123, 205, 'Al Qunaytirah', 'QU', 1),
(3124, 205, 'Ar Raqqah', 'RQ', 1),
(3125, 205, 'As Suwayda', 'SU', 1),
(3126, 205, 'Dara', 'DA', 1),
(3127, 205, 'Dayr az Zawr', 'DZ', 1),
(3128, 205, 'Dimashq', 'DI', 1),
(3129, 205, 'Halab', 'HL', 1),
(3130, 205, 'Hamah', 'HM', 1),
(3131, 205, 'Hims', 'HI', 1),
(3132, 205, 'Idlib', 'ID', 1),
(3133, 205, 'Rif Dimashq', 'RD', 1),
(3134, 205, 'Tartus', 'TA', 1),
(3135, 206, 'Chang-hua', 'CH', 1),
(3136, 206, 'Chia-i', 'CI', 1),
(3137, 206, 'Hsin-chu', 'HS', 1),
(3138, 206, 'Hua-lien', 'HL', 1),
(3139, 206, 'I-lan', 'IL', 1),
(3140, 206, 'Kao-hsiung county', 'KH', 1),
(3141, 206, 'Kin-men', 'KM', 1),
(3142, 206, 'Lien-chiang', 'LC', 1),
(3143, 206, 'Miao-li', 'ML', 1),
(3144, 206, 'Nan-t ou', 'NT', 1),
(3145, 206, 'P eng-hu', 'PH', 1),
(3146, 206, 'P ing-tung', 'PT', 1),
(3147, 206, 'T ai-chung', 'TG', 1),
(3148, 206, 'T ai-nan', 'TA', 1),
(3149, 206, 'T ai-pei county', 'TP', 1),
(3150, 206, 'T ai-tung', 'TT', 1),
(3151, 206, 'T ao-yuan', 'TY', 1),
(3152, 206, 'Yun-lin', 'YL', 1),
(3153, 206, 'Chia-i city', 'CC', 1),
(3154, 206, 'Chi-lung', 'CL', 1),
(3155, 206, 'Hsin-chu', 'HC', 1),
(3156, 206, 'T ai-chung', 'TH', 1),
(3157, 206, 'T ai-nan', 'TN', 1),
(3158, 206, 'Kao-hsiung city', 'KC', 1),
(3159, 206, 'T ai-pei city', 'TC', 1),
(3160, 207, 'Gorno-Badakhstan', 'GB', 1),
(3161, 207, 'Khatlon', 'KT', 1),
(3162, 207, 'Sughd', 'SU', 1),
(3163, 208, 'Arusha', 'AR', 1),
(3164, 208, 'Dar es Salaam', 'DS', 1),
(3165, 208, 'Dodoma', 'DO', 1),
(3166, 208, 'Iringa', 'IR', 1),
(3167, 208, 'Kagera', 'KA', 1);
INSERT INTO `cc_zone` (`zone_id`, `country_id`, `name`, `code`, `status`) VALUES
(3168, 208, 'Kigoma', 'KI', 1),
(3169, 208, 'Kilimanjaro', 'KJ', 1),
(3170, 208, 'Lindi', 'LN', 1),
(3171, 208, 'Manyara', 'MY', 1),
(3172, 208, 'Mara', 'MR', 1),
(3173, 208, 'Mbeya', 'MB', 1),
(3174, 208, 'Morogoro', 'MO', 1),
(3175, 208, 'Mtwara', 'MT', 1),
(3176, 208, 'Mwanza', 'MW', 1),
(3177, 208, 'Pemba North', 'PN', 1),
(3178, 208, 'Pemba South', 'PS', 1),
(3179, 208, 'Pwani', 'PW', 1),
(3180, 208, 'Rukwa', 'RK', 1),
(3181, 208, 'Ruvuma', 'RV', 1),
(3182, 208, 'Shinyanga', 'SH', 1),
(3183, 208, 'Singida', 'SI', 1),
(3184, 208, 'Tabora', 'TB', 1),
(3185, 208, 'Tanga', 'TN', 1),
(3186, 208, 'Zanzibar Central/South', 'ZC', 1),
(3187, 208, 'Zanzibar North', 'ZN', 1),
(3188, 208, 'Zanzibar Urban/West', 'ZU', 1),
(3189, 209, 'Amnat Charoen', 'Amnat Charoen', 1),
(3190, 209, 'Ang Thong', 'Ang Thong', 1),
(3191, 209, 'Ayutthaya', 'Ayutthaya', 1),
(3192, 209, 'Bangkok', 'Bangkok', 1),
(3193, 209, 'Buriram', 'Buriram', 1),
(3194, 209, 'Chachoengsao', 'Chachoengsao', 1),
(3195, 209, 'Chai Nat', 'Chai Nat', 1),
(3196, 209, 'Chaiyaphum', 'Chaiyaphum', 1),
(3197, 209, 'Chanthaburi', 'Chanthaburi', 1),
(3198, 209, 'Chiang Mai', 'Chiang Mai', 1),
(3199, 209, 'Chiang Rai', 'Chiang Rai', 1),
(3200, 209, 'Chon Buri', 'Chon Buri', 1),
(3201, 209, 'Chumphon', 'Chumphon', 1),
(3202, 209, 'Kalasin', 'Kalasin', 1),
(3203, 209, 'Kamphaeng Phet', 'Kamphaeng Phet', 1),
(3204, 209, 'Kanchanaburi', 'Kanchanaburi', 1),
(3205, 209, 'Khon Kaen', 'Khon Kaen', 1),
(3206, 209, 'Krabi', 'Krabi', 1),
(3207, 209, 'Lampang', 'Lampang', 1),
(3208, 209, 'Lamphun', 'Lamphun', 1),
(3209, 209, 'Loei', 'Loei', 1),
(3210, 209, 'Lop Buri', 'Lop Buri', 1),
(3211, 209, 'Mae Hong Son', 'Mae Hong Son', 1),
(3212, 209, 'Maha Sarakham', 'Maha Sarakham', 1),
(3213, 209, 'Mukdahan', 'Mukdahan', 1),
(3214, 209, 'Nakhon Nayok', 'Nakhon Nayok', 1),
(3215, 209, 'Nakhon Pathom', 'Nakhon Pathom', 1),
(3216, 209, 'Nakhon Phanom', 'Nakhon Phanom', 1),
(3217, 209, 'Nakhon Ratchasima', 'Nakhon Ratchasima', 1),
(3218, 209, 'Nakhon Sawan', 'Nakhon Sawan', 1),
(3219, 209, 'Nakhon Si Thammarat', 'Nakhon Si Thammarat', 1),
(3220, 209, 'Nan', 'Nan', 1),
(3221, 209, 'Narathiwat', 'Narathiwat', 1),
(3222, 209, 'Nong Bua Lamphu', 'Nong Bua Lamphu', 1),
(3223, 209, 'Nong Khai', 'Nong Khai', 1),
(3224, 209, 'Nonthaburi', 'Nonthaburi', 1),
(3225, 209, 'Pathum Thani', 'Pathum Thani', 1),
(3226, 209, 'Pattani', 'Pattani', 1),
(3227, 209, 'Phangnga', 'Phangnga', 1),
(3228, 209, 'Phatthalung', 'Phatthalung', 1),
(3229, 209, 'Phayao', 'Phayao', 1),
(3230, 209, 'Phetchabun', 'Phetchabun', 1),
(3231, 209, 'Phetchaburi', 'Phetchaburi', 1),
(3232, 209, 'Phichit', 'Phichit', 1),
(3233, 209, 'Phitsanulok', 'Phitsanulok', 1),
(3234, 209, 'Phrae', 'Phrae', 1),
(3235, 209, 'Phuket', 'Phuket', 1),
(3236, 209, 'Prachin Buri', 'Prachin Buri', 1),
(3237, 209, 'Prachuap Khiri Khan', 'Prachuap Khiri Khan', 1),
(3238, 209, 'Ranong', 'Ranong', 1),
(3239, 209, 'Ratchaburi', 'Ratchaburi', 1),
(3240, 209, 'Rayong', 'Rayong', 1),
(3241, 209, 'Roi Et', 'Roi Et', 1),
(3242, 209, 'Sa Kaeo', 'Sa Kaeo', 1),
(3243, 209, 'Sakon Nakhon', 'Sakon Nakhon', 1),
(3244, 209, 'Samut Prakan', 'Samut Prakan', 1),
(3245, 209, 'Samut Sakhon', 'Samut Sakhon', 1),
(3246, 209, 'Samut Songkhram', 'Samut Songkhram', 1),
(3247, 209, 'Sara Buri', 'Sara Buri', 1),
(3248, 209, 'Satun', 'Satun', 1),
(3249, 209, 'Sing Buri', 'Sing Buri', 1),
(3250, 209, 'Sisaket', 'Sisaket', 1),
(3251, 209, 'Songkhla', 'Songkhla', 1),
(3252, 209, 'Sukhothai', 'Sukhothai', 1),
(3253, 209, 'Suphan Buri', 'Suphan Buri', 1),
(3254, 209, 'Surat Thani', 'Surat Thani', 1),
(3255, 209, 'Surin', 'Surin', 1),
(3256, 209, 'Tak', 'Tak', 1),
(3257, 209, 'Trang', 'Trang', 1),
(3258, 209, 'Trat', 'Trat', 1),
(3259, 209, 'Ubon Ratchathani', 'Ubon Ratchathani', 1),
(3260, 209, 'Udon Thani', 'Udon Thani', 1),
(3261, 209, 'Uthai Thani', 'Uthai Thani', 1),
(3262, 209, 'Uttaradit', 'Uttaradit', 1),
(3263, 209, 'Yala', 'Yala', 1),
(3264, 209, 'Yasothon', 'Yasothon', 1),
(3265, 210, 'Kara', 'K', 1),
(3266, 210, 'Plateaux', 'P', 1),
(3267, 210, 'Savanes', 'S', 1),
(3268, 210, 'Centrale', 'C', 1),
(3269, 210, 'Maritime', 'M', 1),
(3270, 211, 'Atafu', 'A', 1),
(3271, 211, 'Fakaofo', 'F', 1),
(3272, 211, 'Nukunonu', 'N', 1),
(3273, 212, 'Ha apai', 'H', 1),
(3274, 212, 'Tongatapu', 'T', 1),
(3275, 212, 'Vava u', 'V', 1),
(3276, 213, 'Couva/Tabaquite/Talparo', 'CT', 1),
(3277, 213, 'Diego Martin', 'DM', 1),
(3278, 213, 'Mayaro/Rio Claro', 'MR', 1),
(3279, 213, 'Penal/Debe', 'PD', 1),
(3280, 213, 'Princes Town', 'PT', 1),
(3281, 213, 'Sangre Grande', 'SG', 1),
(3282, 213, 'San Juan/Laventille', 'SL', 1),
(3283, 213, 'Siparia', 'SI', 1),
(3284, 213, 'Tunapuna/Piarco', 'TP', 1),
(3285, 213, 'Port of Spain', 'PS', 1),
(3286, 213, 'San Fernando', 'SF', 1),
(3287, 213, 'Arima', 'AR', 1),
(3288, 213, 'Point Fortin', 'PF', 1),
(3289, 213, 'Chaguanas', 'CH', 1),
(3290, 213, 'Tobago', 'TO', 1),
(3291, 214, 'Ariana', 'AR', 1),
(3292, 214, 'Beja', 'BJ', 1),
(3293, 214, 'Ben Arous', 'BA', 1),
(3294, 214, 'Bizerte', 'BI', 1),
(3295, 214, 'Gabes', 'GB', 1),
(3296, 214, 'Gafsa', 'GF', 1),
(3297, 214, 'Jendouba', 'JE', 1),
(3298, 214, 'Kairouan', 'KR', 1),
(3299, 214, 'Kasserine', 'KS', 1),
(3300, 214, 'Kebili', 'KB', 1),
(3301, 214, 'Kef', 'KF', 1),
(3302, 214, 'Mahdia', 'MH', 1),
(3303, 214, 'Manouba', 'MN', 1),
(3304, 214, 'Medenine', 'ME', 1),
(3305, 214, 'Monastir', 'MO', 1),
(3306, 214, 'Nabeul', 'NA', 1),
(3307, 214, 'Sfax', 'SF', 1),
(3308, 214, 'Sidi', 'SD', 1),
(3309, 214, 'Siliana', 'SL', 1),
(3310, 214, 'Sousse', 'SO', 1),
(3311, 214, 'Tataouine', 'TA', 1),
(3312, 214, 'Tozeur', 'TO', 1),
(3313, 214, 'Tunis', 'TU', 1),
(3314, 214, 'Zaghouan', 'ZA', 1),
(3315, 215, 'Adana', 'ADA', 1),
(3316, 215, 'Adıyaman', 'ADI', 1),
(3317, 215, 'Afyonkarahisar', 'AFY', 1),
(3318, 215, 'Ağrı', 'AGR', 1),
(3319, 215, 'Aksaray', 'AKS', 1),
(3320, 215, 'Amasya', 'AMA', 1),
(3321, 215, 'Ankara', 'ANK', 1),
(3322, 215, 'Antalya', 'ANT', 1),
(3323, 215, 'Ardahan', 'ARD', 1),
(3324, 215, 'Artvin', 'ART', 1),
(3325, 215, 'Aydın', 'AYI', 1),
(3326, 215, 'Balıkesir', 'BAL', 1),
(3327, 215, 'Bartın', 'BAR', 1),
(3328, 215, 'Batman', 'BAT', 1),
(3329, 215, 'Bayburt', 'BAY', 1),
(3330, 215, 'Bilecik', 'BIL', 1),
(3331, 215, 'Bingöl', 'BIN', 1),
(3332, 215, 'Bitlis', 'BIT', 1),
(3333, 215, 'Bolu', 'BOL', 1),
(3334, 215, 'Burdur', 'BRD', 1),
(3335, 215, 'Bursa', 'BRS', 1),
(3336, 215, 'Çanakkale', 'CKL', 1),
(3337, 215, 'Çankırı', 'CKR', 1),
(3338, 215, 'Çorum', 'COR', 1),
(3339, 215, 'Denizli', 'DEN', 1),
(3340, 215, 'Diyarbakır', 'DIY', 1),
(3341, 215, 'Düzce', 'DUZ', 1),
(3342, 215, 'Edirne', 'EDI', 1),
(3343, 215, 'Elazığ', 'ELA', 1),
(3344, 215, 'Erzincan', 'EZC', 1),
(3345, 215, 'Erzurum', 'EZR', 1),
(3346, 215, 'Eskişehir', 'ESK', 1),
(3347, 215, 'Gaziantep', 'GAZ', 1),
(3348, 215, 'Giresun', 'GIR', 1),
(3349, 215, 'Gümüşhane', 'GMS', 1),
(3350, 215, 'Hakkari', 'HKR', 1),
(3351, 215, 'Hatay', 'HTY', 1),
(3352, 215, 'Iğdır', 'IGD', 1),
(3353, 215, 'Isparta', 'ISP', 1),
(3354, 215, 'İstanbul', 'IST', 1),
(3355, 215, 'İzmir', 'IZM', 1),
(3356, 215, 'Kahramanmaraş', 'KAH', 1),
(3357, 215, 'Karabük', 'KRB', 1),
(3358, 215, 'Karaman', 'KRM', 1),
(3359, 215, 'Kars', 'KRS', 1),
(3360, 215, 'Kastamonu', 'KAS', 1),
(3361, 215, 'Kayseri', 'KAY', 1),
(3362, 215, 'Kilis', 'KLS', 1),
(3363, 215, 'Kırıkkale', 'KRK', 1),
(3364, 215, 'Kırklareli', 'KLR', 1),
(3365, 215, 'Kırşehir', 'KRH', 1),
(3366, 215, 'Kocaeli', 'KOC', 1),
(3367, 215, 'Konya', 'KON', 1),
(3368, 215, 'Kütahya', 'KUT', 1),
(3369, 215, 'Malatya', 'MAL', 1),
(3370, 215, 'Manisa', 'MAN', 1),
(3371, 215, 'Mardin', 'MAR', 1),
(3372, 215, 'Mersin', 'MER', 1),
(3373, 215, 'Muğla', 'MUG', 1),
(3374, 215, 'Muş', 'MUS', 1),
(3375, 215, 'Nevşehir', 'NEV', 1),
(3376, 215, 'Niğde', 'NIG', 1),
(3377, 215, 'Ordu', 'ORD', 1),
(3378, 215, 'Osmaniye', 'OSM', 1),
(3379, 215, 'Rize', 'RIZ', 1),
(3380, 215, 'Sakarya', 'SAK', 1),
(3381, 215, 'Samsun', 'SAM', 1),
(3382, 215, 'Şanlıurfa', 'SAN', 1),
(3383, 215, 'Siirt', 'SII', 1),
(3384, 215, 'Sinop', 'SIN', 1),
(3385, 215, 'Şırnak', 'SIR', 1),
(3386, 215, 'Sivas', 'SIV', 1),
(3387, 215, 'Tekirdağ', 'TEL', 1),
(3388, 215, 'Tokat', 'TOK', 1),
(3389, 215, 'Trabzon', 'TRA', 1),
(3390, 215, 'Tunceli', 'TUN', 1),
(3391, 215, 'Uşak', 'USK', 1),
(3392, 215, 'Van', 'VAN', 1),
(3393, 215, 'Yalova', 'YAL', 1),
(3394, 215, 'Yozgat', 'YOZ', 1),
(3395, 215, 'Zonguldak', 'ZON', 1),
(3396, 216, 'Ahal Welayaty', 'A', 1),
(3397, 216, 'Balkan Welayaty', 'B', 1),
(3398, 216, 'Dashhowuz Welayaty', 'D', 1),
(3399, 216, 'Lebap Welayaty', 'L', 1),
(3400, 216, 'Mary Welayaty', 'M', 1),
(3401, 217, 'Ambergris Cays', 'AC', 1),
(3402, 217, 'Dellis Cay', 'DC', 1),
(3403, 217, 'French Cay', 'FC', 1),
(3404, 217, 'Little Water Cay', 'LW', 1),
(3405, 217, 'Parrot Cay', 'RC', 1),
(3406, 217, 'Pine Cay', 'PN', 1),
(3407, 217, 'Salt Cay', 'SL', 1),
(3408, 217, 'Grand Turk', 'GT', 1),
(3409, 217, 'South Caicos', 'SC', 1),
(3410, 217, 'East Caicos', 'EC', 1),
(3411, 217, 'Middle Caicos', 'MC', 1),
(3412, 217, 'North Caicos', 'NC', 1),
(3413, 217, 'Providenciales', 'PR', 1),
(3414, 217, 'West Caicos', 'WC', 1),
(3415, 218, 'Nanumanga', 'NMG', 1),
(3416, 218, 'Niulakita', 'NLK', 1),
(3417, 218, 'Niutao', 'NTO', 1),
(3418, 218, 'Funafuti', 'FUN', 1),
(3419, 218, 'Nanumea', 'NME', 1),
(3420, 218, 'Nui', 'NUI', 1),
(3421, 218, 'Nukufetau', 'NFT', 1),
(3422, 218, 'Nukulaelae', 'NLL', 1),
(3423, 218, 'Vaitupu', 'VAI', 1),
(3424, 219, 'Kalangala', 'KAL', 1),
(3425, 219, 'Kampala', 'KMP', 1),
(3426, 219, 'Kayunga', 'KAY', 1),
(3427, 219, 'Kiboga', 'KIB', 1),
(3428, 219, 'Luwero', 'LUW', 1),
(3429, 219, 'Masaka', 'MAS', 1),
(3430, 219, 'Mpigi', 'MPI', 1),
(3431, 219, 'Mubende', 'MUB', 1),
(3432, 219, 'Mukono', 'MUK', 1),
(3433, 219, 'Nakasongola', 'NKS', 1),
(3434, 219, 'Rakai', 'RAK', 1),
(3435, 219, 'Sembabule', 'SEM', 1),
(3436, 219, 'Wakiso', 'WAK', 1),
(3437, 219, 'Bugiri', 'BUG', 1),
(3438, 219, 'Busia', 'BUS', 1),
(3439, 219, 'Iganga', 'IGA', 1),
(3440, 219, 'Jinja', 'JIN', 1),
(3441, 219, 'Kaberamaido', 'KAB', 1),
(3442, 219, 'Kamuli', 'KML', 1),
(3443, 219, 'Kapchorwa', 'KPC', 1),
(3444, 219, 'Katakwi', 'KTK', 1),
(3445, 219, 'Kumi', 'KUM', 1),
(3446, 219, 'Mayuge', 'MAY', 1),
(3447, 219, 'Mbale', 'MBA', 1),
(3448, 219, 'Pallisa', 'PAL', 1),
(3449, 219, 'Sironko', 'SIR', 1),
(3450, 219, 'Soroti', 'SOR', 1),
(3451, 219, 'Tororo', 'TOR', 1),
(3452, 219, 'Adjumani', 'ADJ', 1),
(3453, 219, 'Apac', 'APC', 1),
(3454, 219, 'Arua', 'ARU', 1),
(3455, 219, 'Gulu', 'GUL', 1),
(3456, 219, 'Kitgum', 'KIT', 1),
(3457, 219, 'Kotido', 'KOT', 1),
(3458, 219, 'Lira', 'LIR', 1),
(3459, 219, 'Moroto', 'MRT', 1),
(3460, 219, 'Moyo', 'MOY', 1),
(3461, 219, 'Nakapiripirit', 'NAK', 1),
(3462, 219, 'Nebbi', 'NEB', 1),
(3463, 219, 'Pader', 'PAD', 1),
(3464, 219, 'Yumbe', 'YUM', 1),
(3465, 219, 'Bundibugyo', 'BUN', 1),
(3466, 219, 'Bushenyi', 'BSH', 1),
(3467, 219, 'Hoima', 'HOI', 1),
(3468, 219, 'Kabale', 'KBL', 1),
(3469, 219, 'Kabarole', 'KAR', 1),
(3470, 219, 'Kamwenge', 'KAM', 1),
(3471, 219, 'Kanungu', 'KAN', 1),
(3472, 219, 'Kasese', 'KAS', 1),
(3473, 219, 'Kibaale', 'KBA', 1),
(3474, 219, 'Kisoro', 'KIS', 1),
(3475, 219, 'Kyenjojo', 'KYE', 1),
(3476, 219, 'Masindi', 'MSN', 1),
(3477, 219, 'Mbarara', 'MBR', 1),
(3478, 219, 'Ntungamo', 'NTU', 1),
(3479, 219, 'Rukungiri', 'RUK', 1),
(3480, 220, 'Cherkas ka Oblast ', '71', 1),
(3481, 220, 'Chernihivs ka Oblast ', '74', 1),
(3482, 220, 'Chernivets ka Oblast ', '77', 1),
(3483, 220, 'Crimea', '43', 1),
(3484, 220, 'Dnipropetrovs ka Oblast ', '12', 1),
(3485, 220, 'Donets ka Oblast ', '14', 1),
(3486, 220, 'Ivano-Frankivs ka Oblast ', '26', 1),
(3487, 220, 'Khersons ka Oblast ', '65', 1),
(3488, 220, 'Khmel nyts ka Oblast ', '68', 1),
(3489, 220, 'Kirovohrads ka Oblast ', '35', 1),
(3490, 220, 'Kyiv', '30', 1),
(3491, 220, 'Kyivs ka Oblast ', '32', 1),
(3492, 220, 'Luhans ka Oblast ', '09', 1),
(3493, 220, 'L vivs ka Oblast ', '46', 1),
(3494, 220, 'Mykolayivs ka Oblast ', '48', 1),
(3495, 220, 'Odes ka Oblast ', '51', 1),
(3496, 220, 'Poltavs ka Oblast ', '53', 1),
(3497, 220, 'Rivnens ka Oblast ', '56', 1),
(3498, 220, 'Sevastopol ', '40', 1),
(3499, 220, 'Sums ka Oblast ', '59', 1),
(3500, 220, 'Ternopil s ka Oblast ', '61', 1),
(3501, 220, 'Vinnyts ka Oblast ', '05', 1),
(3502, 220, 'Volyns ka Oblast ', '07', 1),
(3503, 220, 'Zakarpats ka Oblast ', '21', 1),
(3504, 220, 'Zaporiz ka Oblast ', '23', 1),
(3505, 220, 'Zhytomyrs ka oblast ', '18', 1),
(3506, 221, 'Abu Dhabi', 'ADH', 1),
(3507, 221, ' Ajman', 'AJ', 1),
(3508, 221, 'Al Fujayrah', 'FU', 1),
(3509, 221, 'Ash Shariqah', 'SH', 1),
(3510, 221, 'Dubai', 'DU', 1),
(3511, 221, 'R as al Khaymah', 'RK', 1),
(3512, 221, 'Umm al Qaywayn', 'UQ', 1),
(3513, 222, 'Aberdeen', 'ABN', 1),
(3514, 222, 'Aberdeenshire', 'ABNS', 1),
(3515, 222, 'Anglesey', 'ANG', 1),
(3516, 222, 'Angus', 'AGS', 1),
(3517, 222, 'Argyll and Bute', 'ARY', 1),
(3518, 222, 'Bedfordshire', 'BEDS', 1),
(3519, 222, 'Berkshire', 'BERKS', 1),
(3520, 222, 'Blaenau Gwent', 'BLA', 1),
(3521, 222, 'Bridgend', 'BRI', 1),
(3522, 222, 'Bristol', 'BSTL', 1),
(3523, 222, 'Buckinghamshire', 'BUCKS', 1),
(3524, 222, 'Caerphilly', 'CAE', 1),
(3525, 222, 'Cambridgeshire', 'CAMBS', 1),
(3526, 222, 'Cardiff', 'CDF', 1),
(3527, 222, 'Carmarthenshire', 'CARM', 1),
(3528, 222, 'Ceredigion', 'CDGN', 1),
(3529, 222, 'Cheshire', 'CHES', 1),
(3530, 222, 'Clackmannanshire', 'CLACK', 1),
(3531, 222, 'Conwy', 'CON', 1),
(3532, 222, 'Cornwall', 'CORN', 1),
(3533, 222, 'Denbighshire', 'DNBG', 1),
(3534, 222, 'Derbyshire', 'DERBY', 1),
(3535, 222, 'Devon', 'DVN', 1),
(3536, 222, 'Dorset', 'DOR', 1),
(3537, 222, 'Dumfries and Galloway', 'DGL', 1),
(3538, 222, 'Dundee', 'DUND', 1),
(3539, 222, 'Durham', 'DHM', 1),
(3540, 222, 'East Ayrshire', 'ARYE', 1),
(3541, 222, 'East Dunbartonshire', 'DUNBE', 1),
(3542, 222, 'East Lothian', 'LOTE', 1),
(3543, 222, 'East Renfrewshire', 'RENE', 1),
(3544, 222, 'East Riding of Yorkshire', 'ERYS', 1),
(3545, 222, 'East Sussex', 'SXE', 1),
(3546, 222, 'Edinburgh', 'EDIN', 1),
(3547, 222, 'Essex', 'ESX', 1),
(3548, 222, 'Falkirk', 'FALK', 1),
(3549, 222, 'Fife', 'FFE', 1),
(3550, 222, 'Flintshire', 'FLINT', 1),
(3551, 222, 'Glasgow', 'GLAS', 1),
(3552, 222, 'Gloucestershire', 'GLOS', 1),
(3553, 222, 'Greater London', 'LDN', 1),
(3554, 222, 'Greater Manchester', 'MCH', 1),
(3555, 222, 'Gwynedd', 'GDD', 1),
(3556, 222, 'Hampshire', 'HANTS', 1),
(3557, 222, 'Herefordshire', 'HWR', 1),
(3558, 222, 'Hertfordshire', 'HERTS', 1),
(3559, 222, 'Highlands', 'HLD', 1),
(3560, 222, 'Inverclyde', 'IVER', 1),
(3561, 222, 'Isle of Wight', 'IOW', 1),
(3562, 222, 'Kent', 'KNT', 1),
(3563, 222, 'Lancashire', 'LANCS', 1),
(3564, 222, 'Leicestershire', 'LEICS', 1),
(3565, 222, 'Lincolnshire', 'LINCS', 1),
(3566, 222, 'Merseyside', 'MSY', 1),
(3567, 222, 'Merthyr Tydfil', 'MERT', 1),
(3568, 222, 'Midlothian', 'MLOT', 1),
(3569, 222, 'Monmouthshire', 'MMOUTH', 1),
(3570, 222, 'Moray', 'MORAY', 1),
(3571, 222, 'Neath Port Talbot', 'NPRTAL', 1),
(3572, 222, 'Newport', 'NEWPT', 1),
(3573, 222, 'Norfolk', 'NOR', 1),
(3574, 222, 'North Ayrshire', 'ARYN', 1),
(3575, 222, 'North Lanarkshire', 'LANN', 1),
(3576, 222, 'North Yorkshire', 'YSN', 1),
(3577, 222, 'Northamptonshire', 'NHM', 1),
(3578, 222, 'Northumberland', 'NLD', 1),
(3579, 222, 'Nottinghamshire', 'NOT', 1),
(3580, 222, 'Orkney Islands', 'ORK', 1),
(3581, 222, 'Oxfordshire', 'OFE', 1),
(3582, 222, 'Pembrokeshire', 'PEM', 1),
(3583, 222, 'Perth and Kinross', 'PERTH', 1),
(3584, 222, 'Powys', 'PWS', 1),
(3585, 222, 'Renfrewshire', 'REN', 1),
(3586, 222, 'Rhondda Cynon Taff', 'RHON', 1),
(3587, 222, 'Rutland', 'RUT', 1),
(3588, 222, 'Scottish Borders', 'BOR', 1),
(3589, 222, 'Shetland Islands', 'SHET', 1),
(3590, 222, 'Shropshire', 'SPE', 1),
(3591, 222, 'Somerset', 'SOM', 1),
(3592, 222, 'South Ayrshire', 'ARYS', 1),
(3593, 222, 'South Lanarkshire', 'LANS', 1),
(3594, 222, 'South Yorkshire', 'YSS', 1),
(3595, 222, 'Staffordshire', 'SFD', 1),
(3596, 222, 'Stirling', 'STIR', 1),
(3597, 222, 'Suffolk', 'SFK', 1),
(3598, 222, 'Surrey', 'SRY', 1),
(3599, 222, 'Swansea', 'SWAN', 1),
(3600, 222, 'Torfaen', 'TORF', 1),
(3601, 222, 'Tyne and Wear', 'TWR', 1),
(3602, 222, 'Vale of Glamorgan', 'VGLAM', 1),
(3603, 222, 'Warwickshire', 'WARKS', 1),
(3604, 222, 'West Dunbartonshire', 'WDUN', 1),
(3605, 222, 'West Lothian', 'WLOT', 1),
(3606, 222, 'West Midlands', 'WMD', 1),
(3607, 222, 'West Sussex', 'SXW', 1),
(3608, 222, 'West Yorkshire', 'YSW', 1),
(3609, 222, 'Western Isles', 'WIL', 1),
(3610, 222, 'Wiltshire', 'WLT', 1),
(3611, 222, 'Worcestershire', 'WORCS', 1),
(3612, 222, 'Wrexham', 'WRX', 1),
(3613, 223, 'Alabama', 'AL', 1),
(3614, 223, 'Alaska', 'AK', 1),
(3615, 223, 'American Samoa', 'AS', 1),
(3616, 223, 'Arizona', 'AZ', 1),
(3617, 223, 'Arkansas', 'AR', 1),
(3618, 223, 'Armed Forces Africa', 'AF', 1),
(3619, 223, 'Armed Forces Americas', 'AA', 1),
(3620, 223, 'Armed Forces Canada', 'AC', 1),
(3621, 223, 'Armed Forces Europe', 'AE', 1),
(3622, 223, 'Armed Forces Middle East', 'AM', 1),
(3623, 223, 'Armed Forces Pacific', 'AP', 1),
(3624, 223, 'California', 'CA', 1),
(3625, 223, 'Colorado', 'CO', 1),
(3626, 223, 'Connecticut', 'CT', 1),
(3627, 223, 'Delaware', 'DE', 1),
(3628, 223, 'District of Columbia', 'DC', 1),
(3629, 223, 'Federated States Of Micronesia', 'FM', 1),
(3630, 223, 'Florida', 'FL', 1),
(3631, 223, 'Georgia', 'GA', 1),
(3632, 223, 'Guam', 'GU', 1),
(3633, 223, 'Hawaii', 'HI', 1),
(3634, 223, 'Idaho', 'ID', 1),
(3635, 223, 'Illinois', 'IL', 1),
(3636, 223, 'Indiana', 'IN', 1),
(3637, 223, 'Iowa', 'IA', 1),
(3638, 223, 'Kansas', 'KS', 1),
(3639, 223, 'Kentucky', 'KY', 1),
(3640, 223, 'Louisiana', 'LA', 1),
(3641, 223, 'Maine', 'ME', 1),
(3642, 223, 'Marshall Islands', 'MH', 1),
(3643, 223, 'Maryland', 'MD', 1),
(3644, 223, 'Massachusetts', 'MA', 1),
(3645, 223, 'Michigan', 'MI', 1),
(3646, 223, 'Minnesota', 'MN', 1),
(3647, 223, 'Mississippi', 'MS', 1),
(3648, 223, 'Missouri', 'MO', 1),
(3649, 223, 'Montana', 'MT', 1),
(3650, 223, 'Nebraska', 'NE', 1),
(3651, 223, 'Nevada', 'NV', 1),
(3652, 223, 'New Hampshire', 'NH', 1),
(3653, 223, 'New Jersey', 'NJ', 1),
(3654, 223, 'New Mexico', 'NM', 1),
(3655, 223, 'New York', 'NY', 1),
(3656, 223, 'North Carolina', 'NC', 1),
(3657, 223, 'North Dakota', 'ND', 1),
(3658, 223, 'Northern Mariana Islands', 'MP', 1),
(3659, 223, 'Ohio', 'OH', 1),
(3660, 223, 'Oklahoma', 'OK', 1),
(3661, 223, 'Oregon', 'OR', 1),
(3662, 223, 'Palau', 'PW', 1),
(3663, 223, 'Pennsylvania', 'PA', 1),
(3664, 223, 'Puerto Rico', 'PR', 1),
(3665, 223, 'Rhode Island', 'RI', 1),
(3666, 223, 'South Carolina', 'SC', 1),
(3667, 223, 'South Dakota', 'SD', 1),
(3668, 223, 'Tennessee', 'TN', 1),
(3669, 223, 'Texas', 'TX', 1),
(3670, 223, 'Utah', 'UT', 1),
(3671, 223, 'Vermont', 'VT', 1),
(3672, 223, 'Virgin Islands', 'VI', 1),
(3673, 223, 'Virginia', 'VA', 1),
(3674, 223, 'Washington', 'WA', 1),
(3675, 223, 'West Virginia', 'WV', 1),
(3676, 223, 'Wisconsin', 'WI', 1),
(3677, 223, 'Wyoming', 'WY', 1),
(3678, 224, 'Baker Island', 'BI', 1),
(3679, 224, 'Howland Island', 'HI', 1),
(3680, 224, 'Jarvis Island', 'JI', 1),
(3681, 224, 'Johnston Atoll', 'JA', 1),
(3682, 224, 'Kingman Reef', 'KR', 1),
(3683, 224, 'Midway Atoll', 'MA', 1),
(3684, 224, 'Navassa Island', 'NI', 1),
(3685, 224, 'Palmyra Atoll', 'PA', 1),
(3686, 224, 'Wake Island', 'WI', 1),
(3687, 225, 'Artigas', 'AR', 1),
(3688, 225, 'Canelones', 'CA', 1),
(3689, 225, 'Cerro Largo', 'CL', 1),
(3690, 225, 'Colonia', 'CO', 1),
(3691, 225, 'Durazno', 'DU', 1),
(3692, 225, 'Flores', 'FS', 1),
(3693, 225, 'Florida', 'FA', 1),
(3694, 225, 'Lavalleja', 'LA', 1),
(3695, 225, 'Maldonado', 'MA', 1),
(3696, 225, 'Montevideo', 'MO', 1),
(3697, 225, 'Paysandu', 'PA', 1),
(3698, 225, 'Rio Negro', 'RN', 1),
(3699, 225, 'Rivera', 'RV', 1),
(3700, 225, 'Rocha', 'RO', 1),
(3701, 225, 'Salto', 'SL', 1),
(3702, 225, 'San Jose', 'SJ', 1),
(3703, 225, 'Soriano', 'SO', 1),
(3704, 225, 'Tacuarembo', 'TA', 1),
(3705, 225, 'Treinta y Tres', 'TT', 1),
(3706, 226, 'Andijon', 'AN', 1),
(3707, 226, 'Buxoro', 'BU', 1),
(3708, 226, 'Farg ona', 'FA', 1),
(3709, 226, 'Jizzax', 'JI', 1),
(3710, 226, 'Namangan', 'NG', 1),
(3711, 226, 'Navoiy', 'NW', 1),
(3712, 226, 'Qashqadaryo', 'QA', 1),
(3713, 226, 'Qoraqalpog iston Republikasi', 'QR', 1),
(3714, 226, 'Samarqand', 'SA', 1),
(3715, 226, 'Sirdaryo', 'SI', 1),
(3716, 226, 'Surxondaryo', 'SU', 1),
(3717, 226, 'Toshkent City', 'TK', 1),
(3718, 226, 'Toshkent Region', 'TO', 1),
(3719, 226, 'Xorazm', 'XO', 1),
(3720, 227, 'Malampa', 'MA', 1),
(3721, 227, 'Penama', 'PE', 1),
(3722, 227, 'Sanma', 'SA', 1),
(3723, 227, 'Shefa', 'SH', 1),
(3724, 227, 'Tafea', 'TA', 1),
(3725, 227, 'Torba', 'TO', 1),
(3726, 229, 'Amazonas', 'AM', 1),
(3727, 229, 'Anzoategui', 'AN', 1),
(3728, 229, 'Apure', 'AP', 1),
(3729, 229, 'Aragua', 'AR', 1),
(3730, 229, 'Barinas', 'BA', 1),
(3731, 229, 'Bolivar', 'BO', 1),
(3732, 229, 'Carabobo', 'CA', 1),
(3733, 229, 'Cojedes', 'CO', 1),
(3734, 229, 'Delta Amacuro', 'DA', 1),
(3735, 229, 'Dependencias Federales', 'DF', 1),
(3736, 229, 'Distrito Federal', 'DI', 1),
(3737, 229, 'Falcon', 'FA', 1),
(3738, 229, 'Guarico', 'GU', 1),
(3739, 229, 'Lara', 'LA', 1),
(3740, 229, 'Merida', 'ME', 1),
(3741, 229, 'Miranda', 'MI', 1),
(3742, 229, 'Monagas', 'MO', 1),
(3743, 229, 'Nueva Esparta', 'NE', 1),
(3744, 229, 'Portuguesa', 'PO', 1),
(3745, 229, 'Sucre', 'SU', 1),
(3746, 229, 'Tachira', 'TA', 1),
(3747, 229, 'Trujillo', 'TR', 1),
(3748, 229, 'Vargas', 'VA', 1),
(3749, 229, 'Yaracuy', 'YA', 1),
(3750, 229, 'Zulia', 'ZU', 1),
(3751, 230, 'An Giang', 'AG', 1),
(3752, 230, 'Bac Giang', 'BG', 1),
(3753, 230, 'Bac Kan', 'BK', 1),
(3754, 230, 'Bac Lieu', 'BL', 1),
(3755, 230, 'Bac Ninh', 'BC', 1),
(3756, 230, 'Ba Ria-Vung Tau', 'BR', 1),
(3757, 230, 'Ben Tre', 'BN', 1),
(3758, 230, 'Binh Dinh', 'BH', 1),
(3759, 230, 'Binh Duong', 'BU', 1),
(3760, 230, 'Binh Phuoc', 'BP', 1),
(3761, 230, 'Binh Thuan', 'BT', 1),
(3762, 230, 'Ca Mau', 'CM', 1),
(3763, 230, 'Can Tho', 'CT', 1),
(3764, 230, 'Cao Bang', 'CB', 1),
(3765, 230, 'Dak Lak', 'DL', 1),
(3766, 230, 'Dak Nong', 'DG', 1),
(3767, 230, 'Da Nang', 'DN', 1),
(3768, 230, 'Dien Bien', 'DB', 1),
(3769, 230, 'Dong Nai', 'DI', 1),
(3770, 230, 'Dong Thap', 'DT', 1),
(3771, 230, 'Gia Lai', 'GL', 1),
(3772, 230, 'Ha Giang', 'HG', 1),
(3773, 230, 'Hai Duong', 'HD', 1),
(3774, 230, 'Hai Phong', 'HP', 1),
(3775, 230, 'Ha Nam', 'HM', 1),
(3776, 230, 'Ha Noi', 'HI', 1),
(3777, 230, 'Ha Tay', 'HT', 1),
(3778, 230, 'Ha Tinh', 'HH', 1),
(3779, 230, 'Hoa Binh', 'HB', 1),
(3780, 230, 'Ho Chi Minh City', 'HC', 1),
(3781, 230, 'Hau Giang', 'HU', 1),
(3782, 230, 'Hung Yen', 'HY', 1),
(3783, 232, 'Saint Croix', 'C', 1),
(3784, 232, 'Saint John', 'J', 1),
(3785, 232, 'Saint Thomas', 'T', 1),
(3786, 233, 'Alo', 'A', 1),
(3787, 233, 'Sigave', 'S', 1),
(3788, 233, 'Wallis', 'W', 1),
(3789, 235, 'Abyan', 'AB', 1),
(3790, 235, 'Adan', 'AD', 1),
(3791, 235, 'Amran', 'AM', 1),
(3792, 235, 'Al Bayda', 'BA', 1),
(3793, 235, 'Ad Dali', 'DA', 1),
(3794, 235, 'Dhamar', 'DH', 1),
(3795, 235, 'Hadramawt', 'HD', 1),
(3796, 235, 'Hajjah', 'HJ', 1),
(3797, 235, 'Al Hudaydah', 'HU', 1),
(3798, 235, 'Ibb', 'IB', 1),
(3799, 235, 'Al Jawf', 'JA', 1),
(3800, 235, 'Lahij', 'LA', 1),
(3801, 235, 'Ma rib', 'MA', 1),
(3802, 235, 'Al Mahrah', 'MR', 1),
(3803, 235, 'Al Mahwit', 'MW', 1),
(3804, 235, 'Sa dah', 'SD', 1),
(3805, 235, 'San a', 'SN', 1),
(3806, 235, 'Shabwah', 'SH', 1),
(3807, 235, 'Ta izz', 'TA', 1),
(3812, 237, 'Bas-Congo', 'BC', 1),
(3813, 237, 'Bandundu', 'BN', 1),
(3814, 237, 'Equateur', 'EQ', 1),
(3815, 237, 'Katanga', 'KA', 1),
(3816, 237, 'Kasai-Oriental', 'KE', 1),
(3817, 237, 'Kinshasa', 'KN', 1),
(3818, 237, 'Kasai-Occidental', 'KW', 1),
(3819, 237, 'Maniema', 'MA', 1),
(3820, 237, 'Nord-Kivu', 'NK', 1),
(3821, 237, 'Orientale', 'OR', 1),
(3822, 237, 'Sud-Kivu', 'SK', 1),
(3823, 238, 'Central', 'CE', 1),
(3824, 238, 'Copperbelt', 'CB', 1),
(3825, 238, 'Eastern', 'EA', 1),
(3826, 238, 'Luapula', 'LP', 1),
(3827, 238, 'Lusaka', 'LK', 1),
(3828, 238, 'Northern', 'NO', 1),
(3829, 238, 'North-Western', 'NW', 1),
(3830, 238, 'Southern', 'SO', 1),
(3831, 238, 'Western', 'WE', 1),
(3832, 239, 'Bulawayo', 'BU', 1),
(3833, 239, 'Harare', 'HA', 1),
(3834, 239, 'Manicaland', 'ML', 1),
(3835, 239, 'Mashonaland Central', 'MC', 1),
(3836, 239, 'Mashonaland East', 'ME', 1),
(3837, 239, 'Mashonaland West', 'MW', 1),
(3838, 239, 'Masvingo', 'MV', 1),
(3839, 239, 'Matabeleland North', 'MN', 1),
(3840, 239, 'Matabeleland South', 'MS', 1),
(3841, 239, 'Midlands', 'MD', 1),
(3842, 105, 'Agrigento', 'AG', 1),
(3843, 105, 'Alessandria', 'AL', 1),
(3844, 105, 'Ancona', 'AN', 1),
(3845, 105, 'Aosta', 'AO', 1),
(3846, 105, 'Arezzo', 'AR', 1),
(3847, 105, 'Ascoli Piceno', 'AP', 1),
(3848, 105, 'Asti', 'AT', 1),
(3849, 105, 'Avellino', 'AV', 1),
(3850, 105, 'Bari', 'BA', 1),
(3851, 105, 'Belluno', 'BL', 1),
(3852, 105, 'Benevento', 'BN', 1),
(3853, 105, 'Bergamo', 'BG', 1),
(3854, 105, 'Biella', 'BI', 1),
(3855, 105, 'Bologna', 'BO', 1),
(3856, 105, 'Bolzano', 'BZ', 1),
(3857, 105, 'Brescia', 'BS', 1),
(3858, 105, 'Brindisi', 'BR', 1),
(3859, 105, 'Cagliari', 'CA', 1),
(3860, 105, 'Caltanissetta', 'CL', 1),
(3861, 105, 'Campobasso', 'CB', 1),
(3863, 105, 'Caserta', 'CE', 1),
(3864, 105, 'Catania', 'CT', 1),
(3865, 105, 'Catanzaro', 'CZ', 1),
(3866, 105, 'Chieti', 'CH', 1),
(3867, 105, 'Como', 'CO', 1),
(3868, 105, 'Cosenza', 'CS', 1),
(3869, 105, 'Cremona', 'CR', 1),
(3870, 105, 'Crotone', 'KR', 1),
(3871, 105, 'Cuneo', 'CN', 1),
(3872, 105, 'Enna', 'EN', 1),
(3873, 105, 'Ferrara', 'FE', 1),
(3874, 105, 'Firenze', 'FI', 1),
(3875, 105, 'Foggia', 'FG', 1),
(3876, 105, 'Forli-Cesena', 'FC', 1),
(3877, 105, 'Frosinone', 'FR', 1),
(3878, 105, 'Genova', 'GE', 1),
(3879, 105, 'Gorizia', 'GO', 1),
(3880, 105, 'Grosseto', 'GR', 1),
(3881, 105, 'Imperia', 'IM', 1),
(3882, 105, 'Isernia', 'IS', 1),
(3883, 105, 'L Aquila', 'AQ', 1),
(3884, 105, 'La Spezia', 'SP', 1),
(3885, 105, 'Latina', 'LT', 1),
(3886, 105, 'Lecce', 'LE', 1),
(3887, 105, 'Lecco', 'LC', 1),
(3888, 105, 'Livorno', 'LI', 1),
(3889, 105, 'Lodi', 'LO', 1),
(3890, 105, 'Lucca', 'LU', 1),
(3891, 105, 'Macerata', 'MC', 1),
(3892, 105, 'Mantova', 'MN', 1),
(3893, 105, 'Massa-Carrara', 'MS', 1),
(3894, 105, 'Matera', 'MT', 1),
(3896, 105, 'Messina', 'ME', 1),
(3897, 105, 'Milano', 'MI', 1),
(3898, 105, 'Modena', 'MO', 1),
(3899, 105, 'Napoli', 'NA', 1),
(3900, 105, 'Novara', 'NO', 1),
(3901, 105, 'Nuoro', 'NU', 1),
(3904, 105, 'Oristano', 'OR', 1),
(3905, 105, 'Padova', 'PD', 1),
(3906, 105, 'Palermo', 'PA', 1),
(3907, 105, 'Parma', 'PR', 1),
(3908, 105, 'Pavia', 'PV', 1),
(3909, 105, 'Perugia', 'PG', 1),
(3910, 105, 'Pesaro e Urbino', 'PU', 1),
(3911, 105, 'Pescara', 'PE', 1),
(3912, 105, 'Piacenza', 'PC', 1),
(3913, 105, 'Pisa', 'PI', 1),
(3914, 105, 'Pistoia', 'PT', 1),
(3915, 105, 'Pordenone', 'PN', 1),
(3916, 105, 'Potenza', 'PZ', 1),
(3917, 105, 'Prato', 'PO', 1),
(3918, 105, 'Ragusa', 'RG', 1),
(3919, 105, 'Ravenna', 'RA', 1),
(3920, 105, 'Reggio Calabria', 'RC', 1),
(3921, 105, 'Reggio Emilia', 'RE', 1),
(3922, 105, 'Rieti', 'RI', 1),
(3923, 105, 'Rimini', 'RN', 1),
(3924, 105, 'Roma', 'RM', 1),
(3925, 105, 'Rovigo', 'RO', 1),
(3926, 105, 'Salerno', 'SA', 1),
(3927, 105, 'Sassari', 'SS', 1),
(3928, 105, 'Savona', 'SV', 1),
(3929, 105, 'Siena', 'SI', 1),
(3930, 105, 'Siracusa', 'SR', 1),
(3931, 105, 'Sondrio', 'SO', 1),
(3932, 105, 'Taranto', 'TA', 1),
(3933, 105, 'Teramo', 'TE', 1),
(3934, 105, 'Terni', 'TR', 1),
(3935, 105, 'Torino', 'TO', 1),
(3936, 105, 'Trapani', 'TP', 1),
(3937, 105, 'Trento', 'TN', 1),
(3938, 105, 'Treviso', 'TV', 1),
(3939, 105, 'Trieste', 'TS', 1),
(3940, 105, 'Udine', 'UD', 1),
(3941, 105, 'Varese', 'VA', 1),
(3942, 105, 'Venezia', 'VE', 1),
(3943, 105, 'Verbano-Cusio-Ossola', 'VB', 1),
(3944, 105, 'Vercelli', 'VC', 1),
(3945, 105, 'Verona', 'VR', 1),
(3946, 105, 'Vibo Valentia', 'VV', 1),
(3947, 105, 'Vicenza', 'VI', 1),
(3948, 105, 'Viterbo', 'VT', 1),
(3949, 222, 'County Antrim', 'ANT', 1),
(3950, 222, 'County Armagh', 'ARM', 1),
(3951, 222, 'County Down', 'DOW', 1),
(3952, 222, 'County Fermanagh', 'FER', 1),
(3953, 222, 'County Londonderry', 'LDY', 1),
(3954, 222, 'County Tyrone', 'TYR', 1),
(3955, 222, 'Cumbria', 'CMA', 1),
(3956, 190, 'Pomurska', '1', 1),
(3957, 190, 'Podravska', '2', 1),
(3958, 190, 'Koroška', '3', 1),
(3959, 190, 'Savinjska', '4', 1),
(3960, 190, 'Zasavska', '5', 1),
(3961, 190, 'Spodnjeposavska', '6', 1),
(3962, 190, 'Jugovzhodna Slovenija', '7', 1),
(3963, 190, 'Osrednjeslovenska', '8', 1),
(3964, 190, 'Gorenjska', '9', 1),
(3965, 190, 'Notranjsko-kraška', '10', 1),
(3966, 190, 'Goriška', '11', 1),
(3967, 190, 'Obalno-kraška', '12', 1),
(3968, 33, 'Ruse', '', 1),
(3969, 101, 'Alborz', 'ALB', 1),
(3970, 21, 'Brussels-Capital Region', 'BRU', 1),
(3971, 138, 'Aguascalientes', 'AG', 1),
(3973, 242, 'Andrijevica', '01', 1),
(3974, 242, 'Bar', '02', 1),
(3975, 242, 'Berane', '03', 1),
(3976, 242, 'Bijelo Polje', '04', 1),
(3977, 242, 'Budva', '05', 1),
(3978, 242, 'Cetinje', '06', 1),
(3979, 242, 'Danilovgrad', '07', 1),
(3980, 242, 'Herceg-Novi', '08', 1),
(3981, 242, 'Kolašin', '09', 1),
(3982, 242, 'Kotor', '10', 1),
(3983, 242, 'Mojkovac', '11', 1),
(3984, 242, 'Nikšić', '12', 1),
(3985, 242, 'Plav', '13', 1),
(3986, 242, 'Pljevlja', '14', 1),
(3987, 242, 'Plužine', '15', 1),
(3988, 242, 'Podgorica', '16', 1),
(3989, 242, 'Rožaje', '17', 1),
(3990, 242, 'Šavnik', '18', 1),
(3991, 242, 'Tivat', '19', 1),
(3992, 242, 'Ulcinj', '20', 1),
(3993, 242, 'Žabljak', '21', 1),
(3994, 243, 'Belgrade', '00', 1),
(3995, 243, 'North Bačka', '01', 1),
(3996, 243, 'Central Banat', '02', 1),
(3997, 243, 'North Banat', '03', 1),
(3998, 243, 'South Banat', '04', 1),
(3999, 243, 'West Bačka', '05', 1),
(4000, 243, 'South Bačka', '06', 1),
(4001, 243, 'Srem', '07', 1),
(4002, 243, 'Mačva', '08', 1),
(4003, 243, 'Kolubara', '09', 1),
(4004, 243, 'Podunavlje', '10', 1),
(4005, 243, 'Braničevo', '11', 1),
(4006, 243, 'Šumadija', '12', 1),
(4007, 243, 'Pomoravlje', '13', 1),
(4008, 243, 'Bor', '14', 1),
(4009, 243, 'Zaječar', '15', 1),
(4010, 243, 'Zlatibor', '16', 1),
(4011, 243, 'Moravica', '17', 1),
(4012, 243, 'Raška', '18', 1),
(4013, 243, 'Rasina', '19', 1),
(4014, 243, 'Nišava', '20', 1),
(4015, 243, 'Toplica', '21', 1),
(4016, 243, 'Pirot', '22', 1),
(4017, 243, 'Jablanica', '23', 1),
(4018, 243, 'Pčinja', '24', 1),
(4020, 245, 'Bonaire', 'BO', 1),
(4021, 245, 'Saba', 'SA', 1),
(4022, 245, 'Sint Eustatius', 'SE', 1),
(4023, 248, 'Central Equatoria', 'EC', 1),
(4024, 248, 'Eastern Equatoria', 'EE', 1),
(4025, 248, 'Jonglei', 'JG', 1),
(4026, 248, 'Lakes', 'LK', 1),
(4027, 248, 'Northern Bahr el-Ghazal', 'BN', 1),
(4028, 248, 'Unity', 'UY', 1),
(4029, 248, 'Upper Nile', 'NU', 1),
(4030, 248, 'Warrap', 'WR', 1),
(4031, 248, 'Western Bahr el-Ghazal', 'BW', 1),
(4032, 248, 'Western Equatoria', 'EW', 1),
(4035, 129, 'Putrajaya', 'MY-16', 1),
(4036, 117, 'Ainaži, Salacgrīvas novads', '0661405', 1),
(4037, 117, 'Aizkraukle, Aizkraukles novads', '0320201', 1),
(4038, 117, 'Aizkraukles novads', '0320200', 1),
(4039, 117, 'Aizpute, Aizputes novads', '0640605', 1),
(4040, 117, 'Aizputes novads', '0640600', 1),
(4041, 117, 'Aknīste, Aknīstes novads', '0560805', 1),
(4042, 117, 'Aknīstes novads', '0560800', 1),
(4043, 117, 'Aloja, Alojas novads', '0661007', 1),
(4044, 117, 'Alojas novads', '0661000', 1),
(4045, 117, 'Alsungas novads', '0624200', 1),
(4046, 117, 'Alūksne, Alūksnes novads', '0360201', 1),
(4047, 117, 'Alūksnes novads', '0360200', 1),
(4048, 117, 'Amatas novads', '0424701', 1),
(4049, 117, 'Ape, Apes novads', '0360805', 1),
(4050, 117, 'Apes novads', '0360800', 1),
(4051, 117, 'Auce, Auces novads', '0460805', 1),
(4052, 117, 'Auces novads', '0460800', 1),
(4053, 117, 'Ādažu novads', '0804400', 1),
(4054, 117, 'Babītes novads', '0804900', 1),
(4055, 117, 'Baldone, Baldones novads', '0800605', 1),
(4056, 117, 'Baldones novads', '0800600', 1),
(4057, 117, 'Baloži, Ķekavas novads', '0800807', 1),
(4058, 117, 'Baltinavas novads', '0384400', 1),
(4059, 117, 'Balvi, Balvu novads', '0380201', 1),
(4060, 117, 'Balvu novads', '0380200', 1),
(4061, 117, 'Bauska, Bauskas novads', '0400201', 1),
(4062, 117, 'Bauskas novads', '0400200', 1),
(4063, 117, 'Beverīnas novads', '0964700', 1),
(4064, 117, 'Brocēni, Brocēnu novads', '0840605', 1),
(4065, 117, 'Brocēnu novads', '0840601', 1),
(4066, 117, 'Burtnieku novads', '0967101', 1),
(4067, 117, 'Carnikavas novads', '0805200', 1),
(4068, 117, 'Cesvaine, Cesvaines novads', '0700807', 1),
(4069, 117, 'Cesvaines novads', '0700800', 1),
(4070, 117, 'Cēsis, Cēsu novads', '0420201', 1),
(4071, 117, 'Cēsu novads', '0420200', 1),
(4072, 117, 'Ciblas novads', '0684901', 1),
(4073, 117, 'Dagda, Dagdas novads', '0601009', 1),
(4074, 117, 'Dagdas novads', '0601000', 1),
(4075, 117, 'Daugavpils', '0050000', 1),
(4076, 117, 'Daugavpils novads', '0440200', 1),
(4077, 117, 'Dobele, Dobeles novads', '0460201', 1),
(4078, 117, 'Dobeles novads', '0460200', 1),
(4079, 117, 'Dundagas novads', '0885100', 1),
(4080, 117, 'Durbe, Durbes novads', '0640807', 1),
(4081, 117, 'Durbes novads', '0640801', 1),
(4082, 117, 'Engures novads', '0905100', 1),
(4083, 117, 'Ērgļu novads', '0705500', 1),
(4084, 117, 'Garkalnes novads', '0806000', 1),
(4085, 117, 'Grobiņa, Grobiņas novads', '0641009', 1),
(4086, 117, 'Grobiņas novads', '0641000', 1),
(4087, 117, 'Gulbene, Gulbenes novads', '0500201', 1),
(4088, 117, 'Gulbenes novads', '0500200', 1),
(4089, 117, 'Iecavas novads', '0406400', 1),
(4090, 117, 'Ikšķile, Ikšķiles novads', '0740605', 1),
(4091, 117, 'Ikšķiles novads', '0740600', 1),
(4092, 117, 'Ilūkste, Ilūkstes novads', '0440807', 1),
(4093, 117, 'Ilūkstes novads', '0440801', 1),
(4094, 117, 'Inčukalna novads', '0801800', 1),
(4095, 117, 'Jaunjelgava, Jaunjelgavas novads', '0321007', 1),
(4096, 117, 'Jaunjelgavas novads', '0321000', 1),
(4097, 117, 'Jaunpiebalgas novads', '0425700', 1),
(4098, 117, 'Jaunpils novads', '0905700', 1),
(4099, 117, 'Jelgava', '0090000', 1),
(4100, 117, 'Jelgavas novads', '0540200', 1),
(4101, 117, 'Jēkabpils', '0110000', 1),
(4102, 117, 'Jēkabpils novads', '0560200', 1),
(4103, 117, 'Jūrmala', '0130000', 1),
(4104, 117, 'Kalnciems, Jelgavas novads', '0540211', 1),
(4105, 117, 'Kandava, Kandavas novads', '0901211', 1),
(4106, 117, 'Kandavas novads', '0901201', 1),
(4107, 117, 'Kārsava, Kārsavas novads', '0681009', 1),
(4108, 117, 'Kārsavas novads', '0681000', 1),
(4109, 117, 'Kocēnu novads ,bij. Valmieras)', '0960200', 1),
(4110, 117, 'Kokneses novads', '0326100', 1),
(4111, 117, 'Krāslava, Krāslavas novads', '0600201', 1),
(4112, 117, 'Krāslavas novads', '0600202', 1),
(4113, 117, 'Krimuldas novads', '0806900', 1),
(4114, 117, 'Krustpils novads', '0566900', 1),
(4115, 117, 'Kuldīga, Kuldīgas novads', '0620201', 1),
(4116, 117, 'Kuldīgas novads', '0620200', 1),
(4117, 117, 'Ķeguma novads', '0741001', 1),
(4118, 117, 'Ķegums, Ķeguma novads', '0741009', 1),
(4119, 117, 'Ķekavas novads', '0800800', 1),
(4120, 117, 'Lielvārde, Lielvārdes novads', '0741413', 1),
(4121, 117, 'Lielvārdes novads', '0741401', 1),
(4122, 117, 'Liepāja', '0170000', 1),
(4123, 117, 'Limbaži, Limbažu novads', '0660201', 1),
(4124, 117, 'Limbažu novads', '0660200', 1),
(4125, 117, 'Līgatne, Līgatnes novads', '0421211', 1),
(4126, 117, 'Līgatnes novads', '0421200', 1),
(4127, 117, 'Līvāni, Līvānu novads', '0761211', 1),
(4128, 117, 'Līvānu novads', '0761201', 1),
(4129, 117, 'Lubāna, Lubānas novads', '0701413', 1),
(4130, 117, 'Lubānas novads', '0701400', 1),
(4131, 117, 'Ludza, Ludzas novads', '0680201', 1),
(4132, 117, 'Ludzas novads', '0680200', 1),
(4133, 117, 'Madona, Madonas novads', '0700201', 1),
(4134, 117, 'Madonas novads', '0700200', 1),
(4135, 117, 'Mazsalaca, Mazsalacas novads', '0961011', 1),
(4136, 117, 'Mazsalacas novads', '0961000', 1),
(4137, 117, 'Mālpils novads', '0807400', 1),
(4138, 117, 'Mārupes novads', '0807600', 1),
(4139, 117, 'Mērsraga novads', '0887600', 1),
(4140, 117, 'Naukšēnu novads', '0967300', 1),
(4141, 117, 'Neretas novads', '0327100', 1),
(4142, 117, 'Nīcas novads', '0647900', 1),
(4143, 117, 'Ogre, Ogres novads', '0740201', 1),
(4144, 117, 'Ogres novads', '0740202', 1),
(4145, 117, 'Olaine, Olaines novads', '0801009', 1),
(4146, 117, 'Olaines novads', '0801000', 1),
(4147, 117, 'Ozolnieku novads', '0546701', 1),
(4148, 117, 'Pārgaujas novads', '0427500', 1),
(4149, 117, 'Pāvilosta, Pāvilostas novads', '0641413', 1),
(4150, 117, 'Pāvilostas novads', '0641401', 1),
(4151, 117, 'Piltene, Ventspils novads', '0980213', 1),
(4152, 117, 'Pļaviņas, Pļaviņu novads', '0321413', 1),
(4153, 117, 'Pļaviņu novads', '0321400', 1),
(4154, 117, 'Preiļi, Preiļu novads', '0760201', 1),
(4155, 117, 'Preiļu novads', '0760202', 1),
(4156, 117, 'Priekule, Priekules novads', '0641615', 1),
(4157, 117, 'Priekules novads', '0641600', 1),
(4158, 117, 'Priekuļu novads', '0427300', 1),
(4159, 117, 'Raunas novads', '0427700', 1),
(4160, 117, 'Rēzekne', '0210000', 1),
(4161, 117, 'Rēzeknes novads', '0780200', 1),
(4162, 117, 'Riebiņu novads', '0766300', 1),
(4163, 117, 'Rīga', '0010000', 1),
(4164, 117, 'Rojas novads', '0888300', 1),
(4165, 117, 'Ropažu novads', '0808400', 1),
(4166, 117, 'Rucavas novads', '0648500', 1),
(4167, 117, 'Rugāju novads', '0387500', 1),
(4168, 117, 'Rundāles novads', '0407700', 1),
(4169, 117, 'Rūjiena, Rūjienas novads', '0961615', 1),
(4170, 117, 'Rūjienas novads', '0961600', 1),
(4171, 117, 'Sabile, Talsu novads', '0880213', 1),
(4172, 117, 'Salacgrīva, Salacgrīvas novads', '0661415', 1),
(4173, 117, 'Salacgrīvas novads', '0661400', 1),
(4174, 117, 'Salas novads', '0568700', 1),
(4175, 117, 'Salaspils novads', '0801200', 1),
(4176, 117, 'Salaspils, Salaspils novads', '0801211', 1),
(4177, 117, 'Saldus novads', '0840200', 1),
(4178, 117, 'Saldus, Saldus novads', '0840201', 1),
(4179, 117, 'Saulkrasti, Saulkrastu novads', '0801413', 1),
(4180, 117, 'Saulkrastu novads', '0801400', 1),
(4181, 117, 'Seda, Strenču novads', '0941813', 1),
(4182, 117, 'Sējas novads', '0809200', 1),
(4183, 117, 'Sigulda, Siguldas novads', '0801615', 1),
(4184, 117, 'Siguldas novads', '0801601', 1),
(4185, 117, 'Skrīveru novads', '0328200', 1),
(4186, 117, 'Skrunda, Skrundas novads', '0621209', 1),
(4187, 117, 'Skrundas novads', '0621200', 1),
(4188, 117, 'Smiltene, Smiltenes novads', '0941615', 1),
(4189, 117, 'Smiltenes novads', '0941600', 1),
(4190, 117, 'Staicele, Alojas novads', '0661017', 1),
(4191, 117, 'Stende, Talsu novads', '0880215', 1),
(4192, 117, 'Stopiņu novads', '0809600', 1),
(4193, 117, 'Strenči, Strenču novads', '0941817', 1),
(4194, 117, 'Strenču novads', '0941800', 1),
(4195, 117, 'Subate, Ilūkstes novads', '0440815', 1),
(4196, 117, 'Talsi, Talsu novads', '0880201', 1),
(4197, 117, 'Talsu novads', '0880200', 1),
(4198, 117, 'Tērvetes novads', '0468900', 1),
(4199, 117, 'Tukuma novads', '0900200', 1),
(4200, 117, 'Tukums, Tukuma novads', '0900201', 1),
(4201, 117, 'Vaiņodes novads', '0649300', 1),
(4202, 117, 'Valdemārpils, Talsu novads', '0880217', 1),
(4203, 117, 'Valka, Valkas novads', '0940201', 1),
(4204, 117, 'Valkas novads', '0940200', 1),
(4205, 117, 'Valmiera', '0250000', 1),
(4206, 117, 'Vangaži, Inčukalna novads', '0801817', 1),
(4207, 117, 'Varakļāni, Varakļānu novads', '0701817', 1),
(4208, 117, 'Varakļānu novads', '0701800', 1),
(4209, 117, 'Vārkavas novads', '0769101', 1),
(4210, 117, 'Vecpiebalgas novads', '0429300', 1),
(4211, 117, 'Vecumnieku novads', '0409500', 1),
(4212, 117, 'Ventspils', '0270000', 1),
(4213, 117, 'Ventspils novads', '0980200', 1),
(4214, 117, 'Viesīte, Viesītes novads', '0561815', 1),
(4215, 117, 'Viesītes novads', '0561800', 1),
(4216, 117, 'Viļaka, Viļakas novads', '0381615', 1),
(4217, 117, 'Viļakas novads', '0381600', 1),
(4218, 117, 'Viļāni, Viļānu novads', '0781817', 1),
(4219, 117, 'Viļānu novads', '0781800', 1),
(4220, 117, 'Zilupe, Zilupes novads', '0681817', 1),
(4221, 117, 'Zilupes novads', '0681801', 1),
(4222, 43, 'Arica y Parinacota', 'AP', 1),
(4223, 43, 'Los Rios', 'LR', 1),
(4224, 220, 'Kharkivs ka Oblast ', '63', 1),
(4225, 118, 'Beirut', 'LB-BR', 1),
(4226, 118, 'Bekaa', 'LB-BE', 1),
(4227, 118, 'Mount Lebanon', 'LB-ML', 1),
(4228, 118, 'Nabatieh', 'LB-NB', 1),
(4229, 118, 'North', 'LB-NR', 1),
(4230, 118, 'South', 'LB-ST', 1),
(4231, 99, 'Telangana', 'TS', 1),
(4232, 44, 'Qinghai', 'QH', 1),
(4233, 100, 'Papua Barat', 'PB', 1),
(4234, 100, 'Sulawesi Barat', 'SR', 1),
(4235, 100, 'Kepulauan Riau', 'KR', 1),
(4236, 105, 'Barletta-Andria-Trani', 'BT', 1),
(4237, 105, 'Fermo', 'FM', 1),
(4238, 105, 'Monza Brianza', 'MB', 1),
(4239, 188, 'Central Area (CBD)', 'CE', 1),
(4240, 188, 'Jurong East', 'JE', 1),
(4241, 188, 'Bukit Timah', 'BT', 1),
(4242, 188, 'Bishan', 'BI', 1),
(4243, 188, 'Queenstown', 'QT', 1),
(4244, 188, 'Tampines', 'TP', 1),
(4245, 188, 'Woodlands', 'WD', 1),
(4246, 188, 'Changi', 'CG', 1),
(4247, 188, 'Serangoon', 'SN', 1),
(4248, 188, 'Clementi', 'CM', 1),
(4249, 188, 'Punggol', 'PG', 1),
(4250, 188, 'Pasir Ris', 'PR', 1),
(4251, 188, 'Sengkang', 'SK', 1),
(4252, 188, 'Yishun', 'YN', 1),
(4253, 188, 'Ang Mo Kio', 'AM', 1),
(4254, 188, 'Bukit Merah', 'BM', 1),
(4255, 188, 'Geylang', 'GL', 1),
(4256, 188, 'Kallang/Whampoa', 'KW', 1),
(4257, 188, 'Toa Payoh', 'TP', 1),
(4258, 188, 'Marine Parade', 'MP', 1),
(4259, 188, 'Bukit Panjang', 'BP', 1),
(4260, 188, 'Hougang', 'HG', 1),
(4261, 188, 'Bedok', 'BD', 1),
(4262, 188, 'Sembawang', 'SB', 1),
(4263, 188, 'Bukit Batok', 'BB', 1),
(4264, 188, 'Central Water Catchment', 'CW', 1),
(4265, 188, 'Downtown Core', 'DC', 1),
(4266, 188, 'Marina East', 'ME', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-05-22-123626', 'App\\Database\\Migrations\\Brand', 'default', 'App', 1685464270, 1),
(2, '2023-05-22-150429', 'App\\Database\\Migrations\\Country', 'default', 'App', 1685464271, 1),
(3, '2023-05-22-151238', 'App\\Database\\Migrations\\Coupon', 'default', 'App', 1685464271, 1),
(4, '2023-05-22-151257', 'App\\Database\\Migrations\\CouponCategory', 'default', 'App', 1685464272, 1),
(5, '2023-05-22-151323', 'App\\Database\\Migrations\\CouponHistory', 'default', 'App', 1685464272, 1),
(6, '2023-05-22-151335', 'App\\Database\\Migrations\\CouponProduct', 'default', 'App', 1685464273, 1),
(7, '2023-05-23-105911', 'App\\Database\\Migrations\\Customer', 'default', 'App', 1685464274, 1),
(8, '2023-05-24-064456', 'App\\Database\\Migrations\\Icons', 'default', 'App', 1685464275, 1),
(9, '2023-05-24-065000', 'App\\Database\\Migrations\\Modules', 'default', 'App', 1685464275, 1),
(10, '2023-05-24-065040', 'App\\Database\\Migrations\\ModulesSettings', 'default', 'App', 1685464275, 1),
(11, '2023-05-24-065103', 'App\\Database\\Migrations\\Newsletter', 'default', 'App', 1685464276, 1),
(12, '2023-05-24-065118', 'App\\Database\\Migrations\\Option', 'default', 'App', 1685464278, 1),
(13, '2023-05-24-100954', 'App\\Database\\Migrations\\OptionValue', 'default', 'App', 1685464280, 1),
(14, '2023-05-24-104629', 'App\\Database\\Migrations\\OrderStatus', 'default', 'App', 1685464281, 1),
(15, '2023-05-24-105248', 'App\\Database\\Migrations\\Pages', 'default', 'App', 1685464282, 1),
(16, '2023-05-24-110956', 'App\\Database\\Migrations\\PaymentMethod', 'default', 'App', 1685464282, 1),
(17, '2023-05-24-111019', 'App\\Database\\Migrations\\PaymentSettings', 'default', 'App', 1685464283, 1),
(18, '2023-05-24-111102', 'App\\Database\\Migrations\\Stores', 'default', 'App', 1685464283, 1),
(19, '2023-05-24-150707', 'App\\Database\\Migrations\\ProductCategory', 'default', 'App', 1685464284, 1),
(20, '2023-05-24-150746', 'App\\Database\\Migrations\\Products', 'default', 'App', 1685464285, 1),
(21, '2023-05-24-151806', 'App\\Database\\Migrations\\ProductAttributeGroup', 'default', 'App', 1685464285, 1),
(22, '2023-05-24-152142', 'App\\Database\\Migrations\\ProductAttribute', 'default', 'App', 1685464286, 1),
(23, '2023-05-25-041108', 'App\\Database\\Migrations\\ProductCategoryPopular', 'default', 'App', 1685464286, 1),
(24, '2023-05-25-045624', 'App\\Database\\Migrations\\ProductDescription', 'default', 'App', 1685464287, 1),
(25, '2023-05-25-050357', 'App\\Database\\Migrations\\ProductFeedback', 'default', 'App', 1685464288, 1),
(26, '2023-05-25-052018', 'App\\Database\\Migrations\\ProductFreeDelivery', 'default', 'App', 1685464289, 1),
(27, '2023-05-25-053249', 'App\\Database\\Migrations\\ProductOption', 'default', 'App', 1685464289, 1),
(28, '2023-05-25-053818', 'App\\Database\\Migrations\\ProductImage', 'default', 'App', 1685464290, 1),
(29, '2023-05-25-054119', 'App\\Database\\Migrations\\ProductRelated', 'default', 'App', 1685464291, 1),
(30, '2023-05-25-054346', 'App\\Database\\Migrations\\ProductSpecial', 'default', 'App', 1685464293, 1),
(31, '2023-05-25-054745', 'App\\Database\\Migrations\\ProductToCategory', 'default', 'App', 1685464294, 1),
(32, '2023-05-25-105607', 'App\\Database\\Migrations\\Roles', 'default', 'App', 1685464295, 1),
(33, '2023-05-25-110101', 'App\\Database\\Migrations\\Settings', 'default', 'App', 1685464296, 1),
(34, '2023-05-25-110441', 'App\\Database\\Migrations\\ShippingMethod', 'default', 'App', 1685464297, 1),
(35, '2023-05-25-110741', 'App\\Database\\Migrations\\ShippingSettings', 'default', 'App', 1685464299, 1),
(36, '2023-05-25-111345', 'App\\Database\\Migrations\\ThemeSettings', 'default', 'App', 1685464299, 1),
(37, '2023-05-25-115002', 'App\\Database\\Migrations\\Users', 'default', 'App', 1685464299, 1),
(38, '2023-05-25-115746', 'App\\Database\\Migrations\\Zone', 'default', 'App', 1685464300, 1),
(39, '2023-05-25-120456', 'App\\Database\\Migrations\\Address', 'default', 'App', 1685464300, 1),
(40, '2023-05-25-121036', 'App\\Database\\Migrations\\CustomerWishlist', 'default', 'App', 1685464301, 1),
(41, '2023-05-25-135327', 'App\\Database\\Migrations\\Order', 'default', 'App', 1685464301, 1),
(42, '2023-05-26-131922', 'App\\Database\\Migrations\\OrderHistory', 'default', 'App', 1685464302, 1),
(43, '2023-05-26-132515', 'App\\Database\\Migrations\\OrderItem', 'default', 'App', 1685464302, 1),
(44, '2023-06-01-060708', 'App\\Database\\Migrations\\ProductBoughtTogether', 'default', 'App', 1685600214, 2),
(60, '2023-06-01-062009', 'App\\Database\\Migrations\\AddDescriptionImage', 'default', 'App', 1686208934, 3),
(63, '2023-06-08-063145', 'App\\Database\\Migrations\\AddSidebarMenuHideShow', 'default', 'App', 1686209146, 4),
(64, '2023-06-25-074936', 'App\\Database\\Migrations\\OrderOption', 'default', 'App', 1687697171, 5),
(69, '2023-06-25-124827', 'App\\Database\\Migrations\\AddPrefixOnProductOption', 'default', 'App', 1687698037, 6),
(70, '2023-06-25-125740', 'App\\Database\\Migrations\\AddImageToPaymentMethod', 'default', 'App', 1687698040, 6),
(71, '2023-08-28-034531', 'App\\Database\\Migrations\\CreateWeightShippingSettingsTable', 'default', 'App', 1699888284, 7),
(72, '2023-08-29-131549', 'App\\Database\\Migrations\\CreateOrderCardDetailsTable', 'default', 'App', 1699888284, 7),
(73, '2023-10-01-055158', 'App\\Database\\Migrations\\CreateThemeColumnInThemeSettingsTable', 'default', 'App', 1699888284, 7),
(74, '2023-10-01-060028', 'App\\Database\\Migrations\\CreateProductCategoryShopByTableFT3', 'default', 'App', 1699888284, 7),
(75, '2023-11-12-100722', 'App\\Database\\Migrations\\CreateGeoZoneTable', 'default', 'App', 1699888284, 7),
(76, '2023-11-12-101205', 'App\\Database\\Migrations\\CreateGeoZoneDetailsTable', 'default', 'App', 1699888284, 7),
(77, '2023-11-12-110605', 'App\\Database\\Migrations\\CreateGeoZoneShippingRateTable', 'default', 'App', 1699888284, 7),
(78, '2023-11-27-151050', 'App\\Database\\Migrations\\CreatLabelColumInModuleSettings', 'default', 'App', 1701666068, 8),
(79, '2023-12-04-045113', 'App\\Database\\Migrations\\MWalletCreateCcCustomerLedgerTable', 'default', 'App', 1701666068, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cc_address`
--
ALTER TABLE `cc_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `cc_album`
--
ALTER TABLE `cc_album`
  ADD PRIMARY KEY (`album_id`);

--
-- Indexes for table `cc_album_details`
--
ALTER TABLE `cc_album_details`
  ADD PRIMARY KEY (`album_details_id`);

--
-- Indexes for table `cc_blog`
--
ALTER TABLE `cc_blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `cc_blog_carousel_image`
--
ALTER TABLE `cc_blog_carousel_image`
  ADD PRIMARY KEY (`blog_crassula_image_id`);

--
-- Indexes for table `cc_blog_comments`
--
ALTER TABLE `cc_blog_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_post_ID` (`blog_id`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`),
  ADD KEY `comment_parent` (`comment_parent_id`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `cc_brand`
--
ALTER TABLE `cc_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cc_category`
--
ALTER TABLE `cc_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `cc_country`
--
ALTER TABLE `cc_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `cc_coupon`
--
ALTER TABLE `cc_coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `cc_coupon_category`
--
ALTER TABLE `cc_coupon_category`
  ADD PRIMARY KEY (`coupon_category_id`);

--
-- Indexes for table `cc_coupon_history`
--
ALTER TABLE `cc_coupon_history`
  ADD PRIMARY KEY (`coupon_history_id`);

--
-- Indexes for table `cc_coupon_product`
--
ALTER TABLE `cc_coupon_product`
  ADD PRIMARY KEY (`coupon_product_id`);

--
-- Indexes for table `cc_coupon_shipping`
--
ALTER TABLE `cc_coupon_shipping`
  ADD PRIMARY KEY (`coupon_shipping_id`);

--
-- Indexes for table `cc_customer`
--
ALTER TABLE `cc_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `cc_customer_ledger`
--
ALTER TABLE `cc_customer_ledger`
  ADD PRIMARY KEY (`ledg_id`);

--
-- Indexes for table `cc_customer_point_history`
--
ALTER TABLE `cc_customer_point_history`
  ADD PRIMARY KEY (`ledg_id`);

--
-- Indexes for table `cc_customer_wishlist`
--
ALTER TABLE `cc_customer_wishlist`
  ADD PRIMARY KEY (`customer_wishlist_id`);

--
-- Indexes for table `cc_fund_request`
--
ALTER TABLE `cc_fund_request`
  ADD PRIMARY KEY (`fund_request_id`);

--
-- Indexes for table `cc_geo_zone`
--
ALTER TABLE `cc_geo_zone`
  ADD PRIMARY KEY (`geo_zone_id`);

--
-- Indexes for table `cc_geo_zone_details`
--
ALTER TABLE `cc_geo_zone_details`
  ADD PRIMARY KEY (`geo_zone_details_id`);

--
-- Indexes for table `cc_geo_zone_shipping_rate`
--
ALTER TABLE `cc_geo_zone_shipping_rate`
  ADD PRIMARY KEY (`cc_geo_zone_shipping_rate_id`);

--
-- Indexes for table `cc_icons`
--
ALTER TABLE `cc_icons`
  ADD PRIMARY KEY (`icon_id`);

--
-- Indexes for table `cc_modules`
--
ALTER TABLE `cc_modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `cc_module_settings`
--
ALTER TABLE `cc_module_settings`
  ADD PRIMARY KEY (`module_settings_id`);

--
-- Indexes for table `cc_newsletter`
--
ALTER TABLE `cc_newsletter`
  ADD PRIMARY KEY (`newsletter_id`);

--
-- Indexes for table `cc_offer`
--
ALTER TABLE `cc_offer`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `cc_offer_discount`
--
ALTER TABLE `cc_offer_discount`
  ADD PRIMARY KEY (`offer_discount_id`);

--
-- Indexes for table `cc_offer_on_product`
--
ALTER TABLE `cc_offer_on_product`
  ADD PRIMARY KEY (`offer_on_product_id`);

--
-- Indexes for table `cc_option`
--
ALTER TABLE `cc_option`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `cc_option_value`
--
ALTER TABLE `cc_option_value`
  ADD PRIMARY KEY (`option_value_id`);

--
-- Indexes for table `cc_order`
--
ALTER TABLE `cc_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `cc_order_card_details`
--
ALTER TABLE `cc_order_card_details`
  ADD PRIMARY KEY (`order_card_details_id`);

--
-- Indexes for table `cc_order_history`
--
ALTER TABLE `cc_order_history`
  ADD PRIMARY KEY (`order_history_id`);

--
-- Indexes for table `cc_order_item`
--
ALTER TABLE `cc_order_item`
  ADD PRIMARY KEY (`order_item`);

--
-- Indexes for table `cc_order_option`
--
ALTER TABLE `cc_order_option`
  ADD PRIMARY KEY (`order_option_id`);

--
-- Indexes for table `cc_order_status`
--
ALTER TABLE `cc_order_status`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indexes for table `cc_pages`
--
ALTER TABLE `cc_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `cc_payment_method`
--
ALTER TABLE `cc_payment_method`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `cc_payment_settings`
--
ALTER TABLE `cc_payment_settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `cc_products`
--
ALTER TABLE `cc_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `cc_product_attribute`
--
ALTER TABLE `cc_product_attribute`
  ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `cc_product_attribute_group`
--
ALTER TABLE `cc_product_attribute_group`
  ADD PRIMARY KEY (`attribute_group_id`);

--
-- Indexes for table `cc_product_bought_together`
--
ALTER TABLE `cc_product_bought_together`
  ADD PRIMARY KEY (`bought_together_id`);

--
-- Indexes for table `cc_product_category`
--
ALTER TABLE `cc_product_category`
  ADD PRIMARY KEY (`prod_cat_id`);

--
-- Indexes for table `cc_product_category_popular`
--
ALTER TABLE `cc_product_category_popular`
  ADD PRIMARY KEY (`prod_cat_popular_id`);

--
-- Indexes for table `cc_product_category_shop_by`
--
ALTER TABLE `cc_product_category_shop_by`
  ADD PRIMARY KEY (`prod_cat_shop_by_id`);

--
-- Indexes for table `cc_product_description`
--
ALTER TABLE `cc_product_description`
  ADD PRIMARY KEY (`product_desc_id`);

--
-- Indexes for table `cc_product_feedback`
--
ALTER TABLE `cc_product_feedback`
  ADD PRIMARY KEY (`product_feedback_id`);

--
-- Indexes for table `cc_product_free_delivery`
--
ALTER TABLE `cc_product_free_delivery`
  ADD PRIMARY KEY (`product_free_delivery_id`);

--
-- Indexes for table `cc_product_image`
--
ALTER TABLE `cc_product_image`
  ADD PRIMARY KEY (`product_image_id`);

--
-- Indexes for table `cc_product_option`
--
ALTER TABLE `cc_product_option`
  ADD PRIMARY KEY (`product_option_id`);

--
-- Indexes for table `cc_product_related`
--
ALTER TABLE `cc_product_related`
  ADD PRIMARY KEY (`product_related_id`);

--
-- Indexes for table `cc_product_special`
--
ALTER TABLE `cc_product_special`
  ADD PRIMARY KEY (`product_special_id`);

--
-- Indexes for table `cc_product_to_category`
--
ALTER TABLE `cc_product_to_category`
  ADD PRIMARY KEY (`product_to_cat_id`);

--
-- Indexes for table `cc_roles`
--
ALTER TABLE `cc_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `cc_settings`
--
ALTER TABLE `cc_settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `cc_shipping_method`
--
ALTER TABLE `cc_shipping_method`
  ADD PRIMARY KEY (`shipping_method_id`);

--
-- Indexes for table `cc_shipping_settings`
--
ALTER TABLE `cc_shipping_settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `cc_stores`
--
ALTER TABLE `cc_stores`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `cc_theme_settings`
--
ALTER TABLE `cc_theme_settings`
  ADD PRIMARY KEY (`theme_settings_id`);

--
-- Indexes for table `cc_users`
--
ALTER TABLE `cc_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `cc_weight_shipping_settings`
--
ALTER TABLE `cc_weight_shipping_settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `cc_zone`
--
ALTER TABLE `cc_zone`
  ADD PRIMARY KEY (`zone_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cc_address`
--
ALTER TABLE `cc_address`
  MODIFY `address_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cc_album`
--
ALTER TABLE `cc_album`
  MODIFY `album_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cc_album_details`
--
ALTER TABLE `cc_album_details`
  MODIFY `album_details_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `cc_blog`
--
ALTER TABLE `cc_blog`
  MODIFY `blog_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cc_blog_carousel_image`
--
ALTER TABLE `cc_blog_carousel_image`
  MODIFY `blog_crassula_image_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cc_blog_comments`
--
ALTER TABLE `cc_blog_comments`
  MODIFY `comment_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `cc_brand`
--
ALTER TABLE `cc_brand`
  MODIFY `brand_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cc_category`
--
ALTER TABLE `cc_category`
  MODIFY `cat_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cc_country`
--
ALTER TABLE `cc_country`
  MODIFY `country_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `cc_coupon`
--
ALTER TABLE `cc_coupon`
  MODIFY `coupon_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cc_coupon_category`
--
ALTER TABLE `cc_coupon_category`
  MODIFY `coupon_category_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cc_coupon_history`
--
ALTER TABLE `cc_coupon_history`
  MODIFY `coupon_history_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cc_coupon_product`
--
ALTER TABLE `cc_coupon_product`
  MODIFY `coupon_product_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cc_coupon_shipping`
--
ALTER TABLE `cc_coupon_shipping`
  MODIFY `coupon_shipping_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `cc_customer`
--
ALTER TABLE `cc_customer`
  MODIFY `customer_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cc_customer_ledger`
--
ALTER TABLE `cc_customer_ledger`
  MODIFY `ledg_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cc_customer_point_history`
--
ALTER TABLE `cc_customer_point_history`
  MODIFY `ledg_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cc_customer_wishlist`
--
ALTER TABLE `cc_customer_wishlist`
  MODIFY `customer_wishlist_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cc_fund_request`
--
ALTER TABLE `cc_fund_request`
  MODIFY `fund_request_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cc_geo_zone`
--
ALTER TABLE `cc_geo_zone`
  MODIFY `geo_zone_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cc_geo_zone_details`
--
ALTER TABLE `cc_geo_zone_details`
  MODIFY `geo_zone_details_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cc_geo_zone_shipping_rate`
--
ALTER TABLE `cc_geo_zone_shipping_rate`
  MODIFY `cc_geo_zone_shipping_rate_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cc_icons`
--
ALTER TABLE `cc_icons`
  MODIFY `icon_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `cc_modules`
--
ALTER TABLE `cc_modules`
  MODIFY `module_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cc_module_settings`
--
ALTER TABLE `cc_module_settings`
  MODIFY `module_settings_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cc_newsletter`
--
ALTER TABLE `cc_newsletter`
  MODIFY `newsletter_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cc_offer`
--
ALTER TABLE `cc_offer`
  MODIFY `offer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cc_offer_discount`
--
ALTER TABLE `cc_offer_discount`
  MODIFY `offer_discount_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `cc_offer_on_product`
--
ALTER TABLE `cc_offer_on_product`
  MODIFY `offer_on_product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cc_option`
--
ALTER TABLE `cc_option`
  MODIFY `option_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cc_option_value`
--
ALTER TABLE `cc_option_value`
  MODIFY `option_value_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cc_order`
--
ALTER TABLE `cc_order`
  MODIFY `order_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `cc_order_card_details`
--
ALTER TABLE `cc_order_card_details`
  MODIFY `order_card_details_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cc_order_history`
--
ALTER TABLE `cc_order_history`
  MODIFY `order_history_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `cc_order_item`
--
ALTER TABLE `cc_order_item`
  MODIFY `order_item` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `cc_order_option`
--
ALTER TABLE `cc_order_option`
  MODIFY `order_option_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `cc_order_status`
--
ALTER TABLE `cc_order_status`
  MODIFY `order_status_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cc_pages`
--
ALTER TABLE `cc_pages`
  MODIFY `page_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cc_payment_method`
--
ALTER TABLE `cc_payment_method`
  MODIFY `payment_method_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cc_payment_settings`
--
ALTER TABLE `cc_payment_settings`
  MODIFY `settings_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cc_products`
--
ALTER TABLE `cc_products`
  MODIFY `product_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `cc_product_attribute`
--
ALTER TABLE `cc_product_attribute`
  MODIFY `attribute_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `cc_product_attribute_group`
--
ALTER TABLE `cc_product_attribute_group`
  MODIFY `attribute_group_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cc_product_bought_together`
--
ALTER TABLE `cc_product_bought_together`
  MODIFY `bought_together_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `cc_product_category`
--
ALTER TABLE `cc_product_category`
  MODIFY `prod_cat_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `cc_product_category_popular`
--
ALTER TABLE `cc_product_category_popular`
  MODIFY `prod_cat_popular_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cc_product_category_shop_by`
--
ALTER TABLE `cc_product_category_shop_by`
  MODIFY `prod_cat_shop_by_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cc_product_description`
--
ALTER TABLE `cc_product_description`
  MODIFY `product_desc_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `cc_product_feedback`
--
ALTER TABLE `cc_product_feedback`
  MODIFY `product_feedback_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cc_product_free_delivery`
--
ALTER TABLE `cc_product_free_delivery`
  MODIFY `product_free_delivery_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cc_product_image`
--
ALTER TABLE `cc_product_image`
  MODIFY `product_image_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=612;

--
-- AUTO_INCREMENT for table `cc_product_option`
--
ALTER TABLE `cc_product_option`
  MODIFY `product_option_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT for table `cc_product_related`
--
ALTER TABLE `cc_product_related`
  MODIFY `product_related_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `cc_product_special`
--
ALTER TABLE `cc_product_special`
  MODIFY `product_special_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cc_product_to_category`
--
ALTER TABLE `cc_product_to_category`
  MODIFY `product_to_cat_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=774;

--
-- AUTO_INCREMENT for table `cc_roles`
--
ALTER TABLE `cc_roles`
  MODIFY `role_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cc_settings`
--
ALTER TABLE `cc_settings`
  MODIFY `settings_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cc_shipping_method`
--
ALTER TABLE `cc_shipping_method`
  MODIFY `shipping_method_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cc_shipping_settings`
--
ALTER TABLE `cc_shipping_settings`
  MODIFY `settings_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cc_stores`
--
ALTER TABLE `cc_stores`
  MODIFY `store_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cc_theme_settings`
--
ALTER TABLE `cc_theme_settings`
  MODIFY `theme_settings_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `cc_users`
--
ALTER TABLE `cc_users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cc_weight_shipping_settings`
--
ALTER TABLE `cc_weight_shipping_settings`
  MODIFY `settings_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cc_zone`
--
ALTER TABLE `cc_zone`
  MODIFY `zone_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4267;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
