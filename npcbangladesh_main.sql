-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 03, 2026 at 12:16 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `npcbangladesh_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` text NOT NULL,
  `short_des` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `f_image` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `createdBy` bigint(20) UNSIGNED NOT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `short_des`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `f_image`, `image`, `alt_name`, `publish_date`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'শারীরিক প্রতিবন্ধী ক্রিকেটারদের জন্য ট্রায়াল ও সিলেকশন ক্যাম্প: তারুণ্যের উৎসব ২০২৫-এ এনপিসি বাংলাদেশের উদ্যোগ', 'trial-selection-camp-physically-challenged-cricketers-2025', 'তারুণ্যের উৎসব ২০২৫ উপলক্ষে ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশ আয়োজিত শারীরিক প্রতিবন্ধী ক্রিকেটারদের ট্রায়াল ও সিলেকশন ক্যাম্পে অংশ নিতে দেশের বিভিন্ন বিভাগের ক্রিকেটারদের আমন্ত্রণ।', '<p>তারুণ্যের উৎসব ২০২৫-এর অংশ হিসেবে ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশ (এনপিসি বাংলাদেশ) দেশের শারীরিক প্রতিবন্ধী ক্রিকেটারদের জন্য একটি ট্রায়াল ও সিলেকশন ক্যাম্প আয়োজন করতে যাচ্ছে। এই উদ্যোগের মূল লক্ষ্য হলো দেশের বিভিন্ন প্রান্ত থেকে প্রতিভাবান শারীরিক প্রতিবন্ধী ক্রিকেটারদের শনাক্ত করা, তাদের ক্রীড়া দক্ষতা বিকাশে সহায়তা করা এবং জাতীয় পর্যায়ে প্রতিনিধিত্বের জন্য একটি সুস্পষ্ট ও কাঠামোবদ্ধ পথ তৈরি করা।</p><p>এই ক্যাম্পে বাংলাদেশের জাতীয় ক্রিকেট দলের বর্তমান ও সাবেক খ্যাতিমান ক্রিকেটারদের উপস্থিতি বিশেষ গুরুত্ব বহন করছে। তাঁরা অংশগ্রহণকারী ক্রিকেটারদের সঙ্গে সরাসরি মতবিনিময় করবেন, মাঠে তাদের পারফরম্যান্স পর্যবেক্ষণ করবেন এবং তরুণ ক্রিকেটারদের প্রয়োজনীয় দিকনির্দেশনা, উৎসাহ ও অনুপ্রেরণা প্রদান করবেন। অভিজ্ঞ এই ক্রিকেটারদের উপস্থিতি অংশগ্রহণকারীদের আত্মবিশ্বাস ও মানসিক শক্তি বৃদ্ধিতে গুরুত্বপূর্ণ ভূমিকা রাখবে বলে আশা করা হচ্ছে।</p><p>ক্যাম্পের আয়োজন সংক্রান্ত বিস্তারিত তথ্য অনুযায়ী, ট্রায়াল ও সিলেকশন ক্যাম্পটি অনুষ্ঠিত হবে আগামী <strong>১৯ ও ২০ আগস্ট ২০২৫ (মঙ্গলবার ও বুধবার)</strong>। প্রতিদিন সকাল <strong>১০টা থেকে বিকাল ৪টা</strong> পর্যন্ত কার্যক্রম চলবে। ভেন্যু হিসেবে নির্ধারণ করা হয়েছে ঢাকার <strong>বসুন্ধরা এরিনা ইনডোর ক্রিকেট কমপ্লেক্স</strong>।</p><p>অংশগ্রহণকারীদের সুবিধার্থে বিভাগভিত্তিক সময়সূচি নির্ধারণ করা হয়েছে। <strong>১৯ আগস্ট ২০২৫</strong> তারিখে চট্টগ্রাম, খুলনা, রাজশাহী ও ময়মনসিংহ বিভাগের ক্রিকেটাররা ট্রায়ালে অংশ নেবেন। পরদিন <strong>২০ আগস্ট ২০২৫</strong> তারিখে ঢাকা, বরিশাল, সিলেট ও রংপুর বিভাগের ক্রিকেটারদের জন্য ট্রায়াল অনুষ্ঠিত হবে।</p><p>এই ক্যাম্পে অংশগ্রহণকারী ক্রিকেটারদের জন্য থাকবে একটি সুসংগঠিত, স্বচ্ছ ও ন্যায়সংগত নির্বাচন প্রক্রিয়া। এর আওতায় ক্রিকেট ট্রায়াল আয়োজন করা হবে, যেখানে ব্যাটিং, বোলিং ও ফিল্ডিংয়ের ওপর পৃথকভাবে মূল্যায়ন করা হবে। অভিজ্ঞ ও যোগ্য মূল্যায়নকারীদের মাধ্যমে পারফরম্যান্সের ভিত্তিতে খেলোয়াড় নির্বাচন করা হবে, যাতে প্রকৃত প্রতিভাবান ক্রিকেটাররা এগিয়ে আসার সুযোগ পান।</p><p>সমগ্র ক্যাম্পটি একটি বন্ধুত্বপূর্ণ, উন্মুক্ত ও অন্তর্ভুক্তিমূলক পরিবেশে পরিচালিত হবে, যেখানে সকল অংশগ্রহণকারীর জন্য সমান সুযোগ নিশ্চিত করা হবে। এনপিসি বাংলাদেশের পক্ষ থেকে খেলোয়াড়দের জন্য প্রয়োজনীয় বিভিন্ন সুবিধা ও সহায়তার ব্যবস্থাও রাখা হয়েছে। এর মধ্যে রয়েছে অংশগ্রহণকারীদের জন্য অফিসিয়াল জার্সি, দুপুরের খাবার ও হালকা নাস্তার ব্যবস্থা। পাশাপাশি খেলোয়াড় ও দর্শনার্থীদের জন্য ভেন্যুটি থাকবে উন্মুক্ত ও স্বাগতপূর্ণ।</p><p>এই ট্রায়াল ও সিলেকশন ক্যাম্প বাংলাদেশের প্যারা ক্রিকেট উন্নয়নের ক্ষেত্রে একটি গুরুত্বপূর্ণ পদক্ষেপ হিসেবে বিবেচিত হচ্ছে। এটি শারীরিক প্রতিবন্ধী ক্রিকেটারদের প্রতিভা বিকাশের পাশাপাশি দেশের ক্রীড়াঙ্গনে অন্তর্ভুক্তিমূলক ক্রীড়া সংস্কৃতিকে আরও শক্তিশালী করতে গুরুত্বপূর্ণ ভূমিকা রাখবে।</p>', 'Trial & Selection Camp for Physically Challenged Cricketers | NPC Bangladesh 2025', 'Physically Challenged Cricketers Bangladesh, Para Cricket Bangladesh, NPC Bangladesh Trial Camp, Tarunyer Utshob 2025, Disability Cricket Bangladesh, Para Sports Bangladesh, Cricket Trial Camp Dhaka', 'NPC Bangladesh is organising a Trial and Selection Camp for physically challenged cricketers under Tarunyer Utshob 2025 to identify and develop national-level para cricket talent.', 'blogs/CUppqDzQR22t70tak6LIFAqjkijuWxkOVvtthz6c.jpg', 'blogs/mWVzM0Aq2qECdvSITKOXLKeFYLpyEFGkIXGVH4K8.jpg', 'তারুণ্যের উৎসব ২০২৫ উপলক্ষে শারীরিক প্রতিবন্ধী ক্রিকেটারদের জন্য এনপিসি বাংলাদেশের ট্রায়াল ও সিলেকশন ক্যাম্প', '2025-12-11 08:56:32', '1', 1, 1, '2025-12-13 08:56:32', '2026-01-10 07:33:30'),
(2, 'দুবাই ২০২৫ এশিয়ান ইয়ুথ প্যারা গেমসে বাংলাদেশের ঐতিহাসিক সাফল্য', 'dubai-2025-asian-youth-para-games-bangladesh-success', 'দুবাই ২০২৫ এশিয়ান ইয়ুথ প্যারা গেমসে বাংলাদেশের প্যারা অ্যাথলেটরা একাধিক স্বর্ণ ও ব্রোঞ্জ পদক জিতে দেশের প্যারালিম্পিক ইতিহাসে গৌরবোজ্জ্বল অধ্যায় যোগ করেছেন।', '<p data-start=\"489\" data-end=\"737\">দুবাইয়ে অনুষ্ঠিত এশিয়ান ইয়ুথ প্যারা গেমস ২০২৫ বাংলাদেশের প্যারা ক্রীড়াঙ্গনের ইতিহাসে এক স্মরণীয় অধ্যায় হয়ে থাকবে। সীমিত সুযোগ-সুবিধা ও নানা প্রতিবন্ধকতার মাঝেও বাংলাদেশের প্যারা অ্যাথলেটরা আন্তর্জাতিক অঙ্গনে নিজেদের সক্ষমতার উজ্জ্বল প্রমাণ দিয়েছেন।</p><p data-start=\"739\" data-end=\"998\">এই গেমসে বাংলাদেশের প্যারা অ্যাথলেট <strong data-start=\"775\" data-end=\"792\">চৈতি রাণী দেব</strong> অসাধারণ কৃতিত্ব স্থাপন করেন। তিনি জ্যাভলিন থ্রো ইভেন্টে এবং ১০০ মিটার দৌড়ে একটি করে মোট দুটি স্বর্ণপদক অর্জন করে ইতিহাস গড়েন। তাঁর এই ডাবল স্বর্ণ জয় বাংলাদেশের প্যারালিম্পিক আন্দোলনের জন্য একটি বড় মাইলফলক।</p><p data-start=\"1000\" data-end=\"1295\">প্যারা সাঁতারে দেশের আরেক গর্ব <strong data-start=\"1031\" data-end=\"1049\">মো. শহীদুল্লাহ</strong> ৫০ মিটার ফ্রিস্টাইলে স্বর্ণপদক এবং ১০০ মিটার ফ্রিস্টাইলে ব্রোঞ্জপদক অর্জন করে বাংলাদেশের পদক তালিকাকে আরও সমৃদ্ধ করেন। পাশাপাশি দলগত ইভেন্টে <strong data-start=\"1191\" data-end=\"1231\">বাংলাদেশ নারী হুইলচেয়ার বাস্কেটবল দল</strong> ব্রোঞ্জপদক জিতে দেশের প্যারা দলগত ক্রীড়ার সম্ভাবনাও তুলে ধরেছে।</p><p data-start=\"1297\" data-end=\"1595\">এই সাফল্য কেবল ব্যক্তিগত অর্জন নয়; এটি বাংলাদেশের প্যারা ক্রীড়াঙ্গনের জন্য এক ঐতিহাসিক অর্জন, যা দেশের হাজারো প্রতিবন্ধী ক্রীড়াবিদের স্বপ্ন ও সম্ভাবনার প্রতীক। চৈতি ও শহীদুল্লাহর সাফল্য প্রমাণ করে—সঠিক সহায়তা, প্রশিক্ষণ ও সুযোগ পেলে প্রতিবন্ধকতাকে জয় করে আন্তর্জাতিক পর্যায়ে শ্রেষ্ঠত্ব অর্জন সম্ভব।</p><p data-start=\"1597\" data-end=\"1867\">এই অর্জন একই সঙ্গে সরকার ও বেসরকারি প্রতিষ্ঠানের আরও শক্তিশালী সহযোগিতার প্রয়োজনীয়তাও তুলে ধরে। বাড়তি অর্থায়ন, অন্তর্ভুক্তিমূলক ক্রীড়া কর্মসূচি, সহজপ্রাপ্য প্রশিক্ষণ কেন্দ্র এবং দীর্ঘমেয়াদি উন্নয়ন কাঠামোর মাধ্যমে বাংলাদেশের প্যারালিম্পিক আন্দোলনকে আরও এগিয়ে নেওয়া সম্ভব।</p><p data-start=\"1869\" data-end=\"2072\">দুবাই ২০২৫ এশিয়ান ইয়ুথ প্যারা গেমসে বাংলাদেশের এই বিজয় অন্তর্ভুক্তিমূলক ক্রীড়া বিকাশে নতুন উদ্দীপনা সৃষ্টি করবে এবং দেশের প্যারা অ্যাথলেটদের অসামান্য সক্ষমতাকে জাতির সামনে আরও গর্বের সঙ্গে উপস্থাপন করবে।</p>', 'Dubai 2025 Asian Youth Para Games: Bangladesh’s Historic Success', 'Asian Youth Para Games 2025, Bangladesh Para Sports, Chaiti Rani Deb, Md Shohidullah, Bangladesh Paralympic, Para Athletics Bangladesh, Para Swimming Bangladesh, Wheelchair Basketball Bangladesh', 'Bangladesh achieves historic success at the Dubai 2025 Asian Youth Para Games with multiple gold and bronze medals in para athletics, swimming, and wheelchair basketball.', 'blogs/rTtqlPTstip2i4Zdr4lHS9f46NHP7wAmo6odB5Iq.jpg', 'blogs/HkIVKHNabhUzWuyqe3jV13UAyD6qMLyXP7O66yX4.png', 'বাংলাদেশের প্যারা অ্যাথলেটদের দুবাই ২০২৫ এশিয়ান ইয়ুথ প্যারা গেমসে স্বর্ণ ও ব্রোঞ্জ পদক অর্জনের মুহূর্ত', '2025-12-08 08:56:32', '1', 1, 1, '2025-12-13 08:56:32', '2025-12-23 13:44:10'),
(3, 'ফিজিক্যালি চ্যালেঞ্জড ক্রিকেট টুর্নামেন্ট ২০২৫: বাংলাদেশের অন্তর্ভুক্তিমূলক ক্রীড়ার নতুন অধ্যায়', 'physically-challenged-cricket-tournament-2025-bangladesh', 'ফিজিক্যালি চ্যালেঞ্জড ক্রিকেট টুর্নামেন্ট ২০২৫ শারীরিক প্রতিবন্ধী ক্রিকেটারদের জন্য একটি অন্তর্ভুক্তিমূলক ও প্রতিযোগিতামূলক প্ল্যাটফর্ম তৈরি করেছে, যেখানে ৮০ জন ক্রিকেটার ৪ দলে অংশগ্রহণ করেছেন।', '<p data-start=\"184\" data-end=\"882\">ফিজিক্যালি চ্যালেঞ্জড ক্রিকেটের মতো উদ্যোগ শুধু একটি টুর্নামেন্ট নয়, বরং বাংলাদেশের অন্তর্ভুক্তিমূলক ক্রীড়াঙ্গনের দীর্ঘমেয়াদি অগ্রযাত্রার অংশ। বাংলাদেশের প্রতিবন্ধী ক্রিকেটের শুরু ২০১৩ সালেই ঘটে, যখন রেডক্রস ও বিভিন্ন প্যারালিম্পিক সংগঠন শারীরিক প্রতিবন্ধী ক্রিকেট দল গঠনে কাজ শুরু করে। পরবর্তীতে ২০১৪ থেকে ২০১৭ পর্যন্ত বিভিন্ন ‘ট্যালেন্ট হান্ট ক্যাম্প’ ও প্রতিভা অনুসন্ধান কর্মসূচি আয়োজিত হয়, যেখানে আন্তর্জাতিক টুর্নামেন্টেও অংশ নেয় বাংলাদেশের প্রতিবন্ধী ক্রিকেট দল। ২০১৯ সালে ইংল্যান্ডে অনুষ্ঠিত পাঁচ জাতির সিরিজে বাংলাদেশ শারীরিক প্রতিবন্ধী ক্রিকেট দল অংশ নেয় এবং বিভিন্ন আন্তর্জাতিক ম্যাচ খেলেছে, যা দেশের প্যারাক্রিকেট উন্নয়নে গুরুত্বপূর্ণ ভূমিকা রেখেছে।&nbsp;</p><p data-start=\"884\" data-end=\"1304\">এই ধারাবাহিক অগ্রগতির ধারায় <strong data-start=\"912\" data-end=\"962\">ফিজিক্যালি চ্যালেঞ্জড ক্রিকেট টুর্নামেন্ট ২০২৫</strong> দেশের প্যারাক্রিকেট ইতিহাসে একটি উল্লেখযোগ্য ও স্মরণীয় আয়োজন হিসেবে দাঁড়িয়েছে। ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশ (এনপিসিবি) এবং বাংলাদেশ ক্রিকেট বোর্ড (বিসিবি)-এর ফিজিক্যালি চ্যালেঞ্জড ক্রিকেট উইং যৌথভাবে আয়োজিত এই টুর্নামেন্টে দেশের বিভিন্ন অঞ্চল থেকে আগত <strong data-start=\"1227\" data-end=\"1303\">৮০ জন শারীরিক প্রতিবন্ধী ক্রিকেটার ৪টি দলে ভাগ হয়ে প্রতিদ্বন্দ্বিতা করেন</strong>।</p><p data-start=\"1306\" data-end=\"1769\">টুর্নামেন্টটি <strong data-start=\"1320\" data-end=\"1338\">টি–১০ ফরম্যাটে</strong> অনুষ্ঠিত হয়েছে, যা খেলোয়াড়দের দক্ষতা, দলগত সমন্বয়, কৌশল ও ক্রীড়াসুলভ মনোভাব প্রদর্শনের জন্য একটি আদর্শ প্ল্যাটফর্ম তৈরি করে। ৩ ও ৪ ডিসেম্বর ২০২৫ তারিখে দেশের অন্যতম ক্রীড়া প্রশিক্ষণ কেন্দ্র <strong data-start=\"1529\" data-end=\"1578\">পুবেরগাঁও ক্রীড়া শিক্ষা প্রতিষ্ঠান (পিকেএসপি)</strong>-তে আয়োজিত এই টুর্নামেন্ট শারীরিক প্রতিবন্ধী ক্রিকেটারদের জন্য প্রতিভা বিকাশ, আত্মবিশ্বাস বৃদ্ধি এবং জাতীয় পর্যায়ে প্রতিনিধিত্ব করার সুযোগ নিশ্চিত করেছে।</p><p data-start=\"1771\" data-end=\"2199\">এই উদ্যোগ বাংলাদেশের প্যারাক্রীড়ায় একটি শক্ত ভিত তৈরি করেছে এবং আন্তর্জাতিক পর্যায়ে আরও সুযোগ তৈরি করার সম্ভাবনা জাগিয়েছে। এনপিসিবি ও বিসিবি ফিজিক্যালি চ্যালেঞ্জড ক্রিকেট উইং-এর নেতৃত্বে এই আয়োজন সফলভাবে সম্পন্ন হওয়ায় দেশের অন্তর্ভুক্তিমূলক ক্রীড়ার ভবিষ্যৎ আরও শক্তিশালী হয়েছে। অনুপ্রেরণাদায়ক এই টুর্নামেন্ট শারীরিক প্রতিবন্ধী ক্রীড়াবিদদের প্রতি সমাজের দৃষ্টি আকর্ষণ করেছে এবং তাদের খেলাধুলার অংশগ্রহণ ও উন্নয়নকে উৎসাহ যোগাচ্ছে।</p>', 'Physically Challenged Cricket Tournament 2025 | NPC Bangladesh', 'Physically Challenged Cricket Bangladesh, Para Cricket Bangladesh, NPC Bangladesh, Bangladesh Cricket Board Para Cricket, Inclusive Cricket Tournament, Para Sports Bangladesh, Bangladesh T-10 Cricket, PKSP Cricket Event', 'Physically Challenged Cricket Tournament 2025, organized by NPC Bangladesh and BCB Para Cricket Wing, brought together 80 athletes in 4 teams to promote inclusion, talent development, and competitive opportunities across Bangladesh.', 'blogs/6daIgwNzN1K1L8b0oh9ioTGB8V2zPAL4BdhxiKQZ.jpg', 'blogs/YvA3OdukA3GVAI9KDLaRLZVXyrYDFV1LdNK55NKD.jpg', 'ফিজিক্যালি চ্যালেঞ্জড ক্রিকেট টুর্নামেন্ট ২০২৫-এর সময় বাংলাদেশের শারীরিক প্রতিবন্ধী ক্রিকেটারদের খেলার মুহূর্ত', '2025-12-06 08:56:32', '1', 1, 1, '2025-12-13 08:56:32', '2025-12-23 14:04:15'),
(4, 'অদম্য সাহসের পাশে মুশফিক: ফিজিক্যাল চ্যালেঞ্জড ক্রিকেটারদের স্বপ্নের কথা', 'অদম্য সাহসের পাশে মুশফিক: ফিজিক্যাল চ্যালেঞ্জড ক্রিকেটারদের স্বপ্নের কথা', 'অদম্য সাহসের পাশে মুশফিক: ফিজিক্যাল চ্যালেঞ্জড ক্রিকেটারদের স্বপ্নের কথা', '<p data-path-to-node=\"3\">বাংলাদেশের ক্রিকেটে তামিম ইকবাল ও মুশফিকুর রহিম—দুটি বড় নাম। সম্প্রতি এই দুই তারকাকে দেখা গেল এক ভিন্ন ভিন্ন লড়াকু যোদ্ধাদের পাশে। গত মঙ্গলবার ফিজিক্যাল চ্যালেঞ্জড ক্রিকেটারদের ট্রায়াল দেখতে গিয়েছিলেন তামিম ইকবাল। আর গতকাল বুধবার সেই অনুপ্রেরণার মিছিলে যোগ দিলেন অভিজ্ঞ উইকেটকিপার ব্যাটার <b data-path-to-node=\"3\" data-index-in-node=\"290\"><strong>মুশফিকুর রহিম</strong></b>।</p><p data-path-to-node=\"4\">ক্রিকেটারদের ট্রায়াল মাঠে প্রায় আড়াই ঘণ্টা সময় কাটান মুশফিক। এটি কেবল একটি সাধারণ সফর ছিল না, বরং ছিল খেলোয়াড়দের প্রতি তার গভীর ভালোবাসা ও দায়বদ্ধতার বহিঃপ্রকাশ।</p><h3 data-path-to-node=\"5\">\"তারা আমাদের চেয়েও দ্বিগুণ ভালো কাজ করতে পারে\"</h3><p data-path-to-node=\"6\">দীর্ঘদিন পর এই অকুতোভয় ক্রিকেটারদের মাঝে ফিরে আসতে পেরে আবেগপ্রবণ হয়ে পড়েন মুশফিক। সংবাদমাধ্যমের সাথে আলাপকালে তিনি তাদের পরিবারের সংগ্রামের কথা তুলে ধরেন। মুশফিকের ভাষায়:</p><blockquote data-path-to-node=\"7\"><p data-path-to-node=\"7,0\"><i data-path-to-node=\"7,0\" data-index-in-node=\"0\">\"একদিক দিয়ে অনেক কষ্টও লাগে কারণ তাদের ফ্যামিলির লড়াইটা অন্যরকম। আমরা যেন তাদের সবসময় মানসিকভাবে ওই সাপোর্টটা দিতে পারি যে তারাও আমাদের মত একজন মানুষ। তারা চাইলেই আমাদের চাইতে আরও দ্বিগুণ ভালো কাজ করতে পারে।\"</i></p></blockquote><h3 data-path-to-node=\"8\">শুধু আলোচনা নয়, চাই বাস্তবায়ন</h3><p data-path-to-node=\"9\">বিসিবির ‘শেয়ার অ্যান্ড কেয়ার’ প্রোগ্রামে মুশফিক নিয়মিত অংশগ্রহণ করছেন। তবে তিনি বিশ্বাস করেন, কেবল আলোচনার টেবিলে বসে সুযোগ-সুবিধা বাড়ানো সম্ভব নয়। ভবিষ্যৎ প্রজন্মের জন্য একটি সুন্দর পরিবেশ নিশ্চিত করাই তার মূল লক্ষ্য। তিনি জোর দিয়ে বলেন যে:</p><ul data-path-to-node=\"10\"><li data-list-item-id=\"e07f8de4e9207af63ce77e08dd3f2072a\"><p data-path-to-node=\"10,0,0\"><b data-path-to-node=\"10,0,0\" data-index-in-node=\"0\"><strong>মাঠের সুবিধা:</strong></b> ক্রিকেটারদের জন্য নির্দিষ্ট মাঠ এবং অনুশীলনের পর্যাপ্ত সুযোগ থাকা জরুরি।</p></li><li data-list-item-id=\"e02641507cb87a7f36812a54a4b9e1a83\"><p data-path-to-node=\"10,1,0\"><b data-path-to-node=\"10,1,0\" data-index-in-node=\"0\"><strong>মানসম্মত পরিবেশ:</strong></b> যেন পরের প্রজন্মের খেলোয়াড়রা দেশের যেকোনো প্রান্তে গিয়ে অনায়াসে খেলতে পারে।</p></li><li data-list-item-id=\"e1350a8950cd133cff4f6e0f3ac75f70c\"><p data-path-to-node=\"10,2,0\"><b data-path-to-node=\"10,2,0\" data-index-in-node=\"0\"><strong>বিশ্বমানের প্রস্তুতি:</strong></b> বিশ্ব ক্রিকেট যে গতিতে এগিয়ে যাচ্ছে, সেই তুলনায় আমাদের পরিকাঠামো আরও উন্নত করা প্রয়োজন।</p></li></ul><h3 data-path-to-node=\"11\">এগিয়ে যাওয়ার স্বপ্ন</h3><p data-path-to-node=\"12\">মুশফিকুর রহিমের এই সফর আমাদের মনে করিয়ে দেয় যে, সীমাবদ্ধতা শরীরে থাকে, মনে নয়। বাংলাদেশ প্যারালিম্পিক কমিটি এবং বিসিবির সম্মিলিত প্রচেষ্টায় এই ক্রিকেটাররা আরও অনেক দূর এগিয়ে যাবে—এমনটাই প্রত্যাশা ভক্তদের।</p>', 'Bangladesh Paralympic Medal News', 'Para Athletics, Bangladesh medal, Paralympics', 'Bangladesh wins its first medal in the World Para Athletics Grand Prix.', 'blogs/4/images/f-image/blog_f_image_6952d6682e0f5.jpg', 'blogs/4/images/image/blog_image_6952d6682d3a6.jpg', 'অদম্য সাহসের পাশে মুশফিক: ফিজিক্যাল চ্যালেঞ্জড ক্রিকেটারদের স্বপ্নের কথা', '2025-12-03 08:56:32', '1', 1, 1, '2025-12-13 08:56:32', '2025-12-29 13:29:04'),
(5, 'ন্যাশনাল ইয়ুথ প্যারা গেমস ২০২৫-এ আমাদের বিজয়ীদের উদযাপন', 'ন্যাশনাল ইয়ুথ প্যারা গেমস ২০২৫-এ আমাদের বিজয়ীদের উদযাপন', 'National Youth Para Games 2025: Para Swimming Awards Ceremony', '<p>গ্যালারিভর্তি মানুষের করতালির শব্দ আর সুইমিং পুলের পানির ঝাপটায় অন্যরকম এক আবহ তৈরি হয়। গত ১০ অক্টোবর, ২০২৫, শুক্রবার মিরপুরের সৈয়দ নজরুল ইসলাম জাতীয় সুইমিং কমপ্লেক্সে ঠিক সেই উন্মাদনা আর প্রাণশক্তিই অনুভূত হয়েছে।</p><p>ন্যাশনাল ইয়ুথ প্যারা গেমস ২০২৫-এ অংশগ্রহণকারী আমাদের অদম্য তরুণ অ্যাথলেটদের উদযাপনের দিনটি ছিল সত্যিই স্মরণীয়। এই গেমস কেবল পদক জয়ের লড়াই নয়; বরং এটি বিশ্বকে দেখিয়ে দেওয়ার সুযোগ যে—দৃঢ় ইচ্ছা আর কঠোর পরিশ্রম থাকলে যেকোনো কিছুই সম্ভব।</p><h4>অনুপ্রেরণাময় এক সকাল</h4><p>অনুষ্ঠানটি শুরু হয় বাংলাদেশ ন্যাশনাল প্যারা অলিম্পিক কমিটির মহাসচিব ডা. মারুফ আহমেদ মৃদুল-এর উষ্ণ অভ্যর্থনার মধ্য দিয়ে। বিশ্বের দরবারে নিজেদের তুলে ধরতে প্রস্তুত এই একঝাঁক তরুণকে দেখে তিনি তাঁর গর্বের কথা ব্যক্ত করেন।</p><p>পুরস্কার বিতরণী শুরু হতেই দর্শকদের উত্তেজনা আরও বেড়ে যায়। অনুষ্ঠানে প্রধান অতিথি হিসেবে উপস্থিত ছিলেন বাংলাদেশ পুলিশের যুগ্ম কমিশনার এবং কমিটির সহ-সভাপতি মোহাম্মদ নাসিরুল ইসলাম। তিনি আমাদের মনে করিয়ে দেন যে, এই অ্যাথলেটরাই বাংলাদেশের প্রকৃত হিরো; যারা প্রমাণ করেছেন যে শারীরিক সীমাবদ্ধতা কখনো অদম্য স্পৃহার পথে বাধা হতে পারে না।</p><h4>আমাদের কমিউনিটির সমর্থন</h4><p>আমাদের এই যাত্রায় পাশে ছিলেন বেশ কয়েকজন বিশেষ বন্ধু ও সহযোগী। ফ্রেশওয়ে, স্পেশাল অলিম্পিকস বাংলাদেশ এবং বাংলাদেশ সুইমিং ফেডারেশনের নেতৃবৃন্দ বিজয়ীদের উৎসাহিত করতে উপস্থিত ছিলেন।</p><p>এই আয়োজনে বিশেষ সহযোগিতার জন্য ফ্রেশওয়ে (FreshWay)-কে অসংখ্য ধন্যবাদ। তাদের এই সমর্থন আমাদের তরুণদের নিজেদের প্রতিভা বিকাশে এক বড় প্ল্যাটফর্ম তৈরি করে দিয়েছে।</p><h4>সামনে আমাদের লক্ষ্য</h4><p>পুরস্কার নেওয়ার সময় অ্যাথলেটদের মুখে যে আনন্দের ঝিলিক দেখা যাচ্ছিল, তা ছিল অমূল্য। অনেকের জন্যই এটি কেবল শুরু। এই গেমস তাদের আন্তর্জাতিক অঙ্গনে বাংলাদেশের প্রতিনিধিত্ব করার মতো বড় স্বপ্নের পথে একটি শক্তিশালী সিঁড়ি হিসেবে কাজ করবে।</p><p>আমাদের সাঁতারুদের উদ্দেশ্যে বলছি: তোমরা দেখিয়ে দিয়েছ যে পানির কোনো বাধা নেই। আর আমাদের সমর্থক ও শুভাকাঙ্ক্ষীদের জানাচ্ছি আন্তরিক ধন্যবাদ। আপনাদের সাথে নিয়েই আমরা এক অন্তর্ভুক্তিমূলক এবং ক্রীড়াবান্ধব বাংলাদেশ গড়ে তুলছি।</p><p><i>আমাদের অ্যাথলেটদের স্বর্ণজয়ের লক্ষ্যের পরবর্তী আপডেট পেতে আমাদের সাথেই থাকুন!</i></p>', 'National Youth Para Games 2025: Para Swimming Awards Ceremony', 'National Youth Para Games 2025, Para Swimming Bangladesh, National Paralympic Committee of Bangladesh, FreshWay Agtech, Mirpur Swimming Complex, Para-athlete awards, Dr. Maruf Ahmed Mridul, Mohammod Nasirul Islam, Bangladesh Para Sports.', 'Celebrate the champions of the National Youth Para Games 2025 Para Swimming event in Mirpur. Featuring Chief Guest Mohammod Nasirul Islam. Powered by FreshWay.', 'blogs/5/images/f-image/blog_f_image_695599fe43017.jpg', 'blogs/5/images/image/blog_image_695599fe42706.jpg', 'National Youth Para Games 2025: Para Swimming Awards Ceremony', '2025-12-01 08:56:32', '1', 1, 1, '2025-12-13 08:56:32', '2026-01-24 06:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `createdBy` int(10) UNSIGNED DEFAULT NULL,
  `updatedBy` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `slug`, `parent_id`, `category_name`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `image`, `alt_name`, `sort_order`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'paralympic-sports', NULL, 'Paralympic Sports', NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', NULL, NULL, '2025-12-13 08:56:32', '2025-12-13 08:56:32'),
(2, 'athlete-stories', NULL, 'Athlete Stories', NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', NULL, NULL, '2025-12-13 08:56:32', '2025-12-13 08:56:32'),
(3, 'training-development', NULL, 'Training & Development', NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', NULL, NULL, '2025-12-13 08:56:32', '2025-12-13 08:56:32'),
(4, 'international-events', NULL, 'International Events', NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', NULL, NULL, '2025-12-13 08:56:32', '2025-12-13 08:56:32'),
(5, 'bangladesh-achievements', NULL, 'Bangladesh Achievements', NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', NULL, NULL, '2025-12-13 08:56:32', '2025-12-13 08:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `blog_category_maps`
--

CREATE TABLE `blog_category_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `blog_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_category_maps`
--

INSERT INTO `blog_category_maps` (`id`, `blog_id`, `blog_category_id`, `created_at`, `updated_at`) VALUES
(4, 4, 5, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 2, 4, NULL, NULL),
(7, 2, 5, NULL, NULL),
(8, 1, 3, NULL, NULL),
(9, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('national-paralympic-committee-of-bangladesh-cache-image_cache_00083089726803f2b445d8fb210e9916', 's:69:\"https://npcbangladesh.org/cache/00083089726803f2b445d8fb210e9916.webp\";', 1770358706),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0046a36325dc7548cf78e8ef3ba98ea6', 's:69:\"https://npcbangladesh.org/cache/0046a36325dc7548cf78e8ef3ba98ea6.webp\";', 1770358747),
('national-paralympic-committee-of-bangladesh-cache-image_cache_007c999af1aab1e194f5d52f5143ee28', 's:69:\"https://npcbangladesh.org/cache/007c999af1aab1e194f5d52f5143ee28.webp\";', 1770266339),
('national-paralympic-committee-of-bangladesh-cache-image_cache_00b27ce94fe0006b2a1d42d4d9d084e3', 's:69:\"https://npcbangladesh.org/cache/00b27ce94fe0006b2a1d42d4d9d084e3.webp\";', 1770358753),
('national-paralympic-committee-of-bangladesh-cache-image_cache_00b8bb7e095da3a28abf9aa9c6810813', 's:69:\"https://npcbangladesh.org/cache/00b8bb7e095da3a28abf9aa9c6810813.webp\";', 1770223617),
('national-paralympic-committee-of-bangladesh-cache-image_cache_00c743fd40a6b1b74ed81eeaf4aeca31', 's:69:\"https://npcbangladesh.org/cache/00c743fd40a6b1b74ed81eeaf4aeca31.webp\";', 1770358756),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0121a0e3db86fc77d79bca73ba982a77', 's:69:\"https://npcbangladesh.org/cache/0121a0e3db86fc77d79bca73ba982a77.webp\";', 1770265827),
('national-paralympic-committee-of-bangladesh-cache-image_cache_017b78eaaf8c28c19e0ed5d5210d69d4', 's:69:\"https://npcbangladesh.org/cache/017b78eaaf8c28c19e0ed5d5210d69d4.webp\";', 1770283153),
('national-paralympic-committee-of-bangladesh-cache-image_cache_01cc0d268bc4c46bbe5b1868f3f62059', 's:69:\"https://npcbangladesh.org/cache/01cc0d268bc4c46bbe5b1868f3f62059.webp\";', 1770098097),
('national-paralympic-committee-of-bangladesh-cache-image_cache_01d4e92439276bfb61a800dc9c29a980', 's:69:\"https://npcbangladesh.org/cache/01d4e92439276bfb61a800dc9c29a980.webp\";', 1770270046),
('national-paralympic-committee-of-bangladesh-cache-image_cache_01d578e515ccf13c0574ee981a1d20d3', 's:69:\"https://npcbangladesh.org/cache/01d578e515ccf13c0574ee981a1d20d3.webp\";', 1770282889),
('national-paralympic-committee-of-bangladesh-cache-image_cache_01e175a80e3e643bfb49650883f0043f', 's:69:\"https://npcbangladesh.org/cache/01e175a80e3e643bfb49650883f0043f.webp\";', 1770283047),
('national-paralympic-committee-of-bangladesh-cache-image_cache_021fab1a7037740d8f299b26fa69f651', 's:69:\"https://npcbangladesh.org/cache/021fab1a7037740d8f299b26fa69f651.webp\";', 1770100738),
('national-paralympic-committee-of-bangladesh-cache-image_cache_02635d2014c94dd36b880939aab49f09', 's:69:\"https://npcbangladesh.org/cache/02635d2014c94dd36b880939aab49f09.webp\";', 1770282962),
('national-paralympic-committee-of-bangladesh-cache-image_cache_02a6ea3538ac36e08c2ed9def95bd381', 's:69:\"https://npcbangladesh.org/cache/02a6ea3538ac36e08c2ed9def95bd381.webp\";', 1770266338),
('national-paralympic-committee-of-bangladesh-cache-image_cache_02c66eeb45847ea6d3ce43863ecf57bf', 's:69:\"https://npcbangladesh.org/cache/02c66eeb45847ea6d3ce43863ecf57bf.webp\";', 1770102507),
('national-paralympic-committee-of-bangladesh-cache-image_cache_033d231ff79b5aa8cfcd082333d10604', 's:69:\"https://npcbangladesh.org/cache/033d231ff79b5aa8cfcd082333d10604.webp\";', 1770101834),
('national-paralympic-committee-of-bangladesh-cache-image_cache_03742179e68e04bbf07dc113cedc9a34', 's:69:\"https://npcbangladesh.org/cache/03742179e68e04bbf07dc113cedc9a34.webp\";', 1770278357),
('national-paralympic-committee-of-bangladesh-cache-image_cache_03bae70c499b8d580fd165cf5d4b9852', 's:69:\"https://npcbangladesh.org/cache/03bae70c499b8d580fd165cf5d4b9852.webp\";', 1770283065),
('national-paralympic-committee-of-bangladesh-cache-image_cache_04435ed05d3ba40afa14f766f1442c8e', 's:69:\"https://npcbangladesh.org/cache/04435ed05d3ba40afa14f766f1442c8e.webp\";', 1770094642),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0473aeec5f05ba7b4bdc9274db767dd2', 's:69:\"https://npcbangladesh.org/cache/0473aeec5f05ba7b4bdc9274db767dd2.webp\";', 1770266323),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0505ff0145ef7883126579e4df264458', 's:69:\"https://npcbangladesh.org/cache/0505ff0145ef7883126579e4df264458.webp\";', 1770266342),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0524640ed0a51c2170d45528b8391feb', 's:69:\"https://npcbangladesh.org/cache/0524640ed0a51c2170d45528b8391feb.webp\";', 1770282981),
('national-paralympic-committee-of-bangladesh-cache-image_cache_057b4610dd89c7a5dcf651428f8a15b8', 's:69:\"https://npcbangladesh.org/cache/057b4610dd89c7a5dcf651428f8a15b8.webp\";', 1770266335),
('national-paralympic-committee-of-bangladesh-cache-image_cache_059a998871d04199de3d81869dad59ab', 's:69:\"https://npcbangladesh.org/cache/059a998871d04199de3d81869dad59ab.webp\";', 1770265815),
('national-paralympic-committee-of-bangladesh-cache-image_cache_05afc719c5b4926d42cf46e9e639b896', 's:69:\"https://npcbangladesh.org/cache/05afc719c5b4926d42cf46e9e639b896.webp\";', 1770282961),
('national-paralympic-committee-of-bangladesh-cache-image_cache_05cb1547b6b9f6d36aa0bb10a7ec5fcb', 's:69:\"https://npcbangladesh.org/cache/05cb1547b6b9f6d36aa0bb10a7ec5fcb.webp\";', 1770266347),
('national-paralympic-committee-of-bangladesh-cache-image_cache_05f0be76fb1561f4eae8dc59f560bbc5', 's:69:\"https://npcbangladesh.org/cache/05f0be76fb1561f4eae8dc59f560bbc5.webp\";', 1770282858),
('national-paralympic-committee-of-bangladesh-cache-image_cache_06ac6fa29d1a14c0dee8a41cda8e3da8', 's:69:\"https://npcbangladesh.org/cache/06ac6fa29d1a14c0dee8a41cda8e3da8.webp\";', 1770358709),
('national-paralympic-committee-of-bangladesh-cache-image_cache_06da7b3ab15b1411035dd58dcce5eac9', 's:69:\"https://npcbangladesh.org/cache/06da7b3ab15b1411035dd58dcce5eac9.webp\";', 1770358813),
('national-paralympic-committee-of-bangladesh-cache-image_cache_07148404b825b83256f06fc36ee5a8af', 's:69:\"https://npcbangladesh.org/cache/07148404b825b83256f06fc36ee5a8af.webp\";', 1770266235),
('national-paralympic-committee-of-bangladesh-cache-image_cache_073c616ab2fc66f21bce1878d9707fcc', 's:69:\"https://npcbangladesh.org/cache/073c616ab2fc66f21bce1878d9707fcc.webp\";', 1770098097),
('national-paralympic-committee-of-bangladesh-cache-image_cache_083167bb4436ab74bcaf698f474f8fa0', 's:69:\"https://npcbangladesh.org/cache/083167bb4436ab74bcaf698f474f8fa0.webp\";', 1770266339),
('national-paralympic-committee-of-bangladesh-cache-image_cache_08b0e6920a7c08e222e7440dc5e984db', 's:69:\"https://npcbangladesh.org/cache/08b0e6920a7c08e222e7440dc5e984db.webp\";', 1770100736),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0901814221be6fe82de1635b278343b0', 's:69:\"https://npcbangladesh.org/cache/0901814221be6fe82de1635b278343b0.webp\";', 1770358724),
('national-paralympic-committee-of-bangladesh-cache-image_cache_09178f25328788b89f30fdb739d8782f', 's:69:\"https://npcbangladesh.org/cache/09178f25328788b89f30fdb739d8782f.webp\";', 1770265810),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0968e6d75db484009f975283b7c02dd8', 's:69:\"https://npcbangladesh.org/cache/0968e6d75db484009f975283b7c02dd8.webp\";', 1770358829),
('national-paralympic-committee-of-bangladesh-cache-image_cache_09764f03590db237aaf12efdbcb848d5', 's:69:\"https://npcbangladesh.org/cache/09764f03590db237aaf12efdbcb848d5.webp\";', 1770266346),
('national-paralympic-committee-of-bangladesh-cache-image_cache_09fef373a4f92262d1ac28ebfc7689d6', 's:69:\"https://npcbangladesh.org/cache/09fef373a4f92262d1ac28ebfc7689d6.webp\";', 1770358742),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0a2f04f0c242f57d04023df8265816da', 's:69:\"https://npcbangladesh.org/cache/0a2f04f0c242f57d04023df8265816da.webp\";', 1770266335),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0a6320a39398d0fb96e59df3a40bef67', 's:69:\"https://npcbangladesh.org/cache/0a6320a39398d0fb96e59df3a40bef67.webp\";', 1770266329),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0b07d633bff766081a2f9717957121fb', 's:69:\"https://npcbangladesh.org/cache/0b07d633bff766081a2f9717957121fb.webp\";', 1770283049),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0b86922a3d184399be2dba90b9ea6729', 's:69:\"https://npcbangladesh.org/cache/0b86922a3d184399be2dba90b9ea6729.webp\";', 1770358700),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0bc90659707af1b2c72c81a74ff83ada', 's:69:\"https://npcbangladesh.org/cache/0bc90659707af1b2c72c81a74ff83ada.webp\";', 1770101802),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0c801b0949cbda4cf7dbe601df507237', 's:69:\"https://npcbangladesh.org/cache/0c801b0949cbda4cf7dbe601df507237.webp\";', 1770282771),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0cbbf4bbc7b578129cf7d8ba1b837766', 's:69:\"https://npcbangladesh.org/cache/0cbbf4bbc7b578129cf7d8ba1b837766.webp\";', 1770278981),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0d6d8bb9aca2ae204ad46af0cb8e4df0', 's:69:\"https://npcbangladesh.org/cache/0d6d8bb9aca2ae204ad46af0cb8e4df0.webp\";', 1770283060),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0e84b3ec0ec4dfdd2ba289728a9dfa7b', 's:69:\"https://npcbangladesh.org/cache/0e84b3ec0ec4dfdd2ba289728a9dfa7b.webp\";', 1770358777),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0e9040b8c0d44b8bf3684a312bcd5a6f', 's:69:\"https://npcbangladesh.org/cache/0e9040b8c0d44b8bf3684a312bcd5a6f.webp\";', 1770266341),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0ec046b778f561e4fd24fe01d0ae48f5', 's:69:\"https://npcbangladesh.org/cache/0ec046b778f561e4fd24fe01d0ae48f5.webp\";', 1770283142),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0edb71a2f1b15e223b8c7c3387bbc597', 's:69:\"https://npcbangladesh.org/cache/0edb71a2f1b15e223b8c7c3387bbc597.webp\";', 1770358782),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0f7c02895d2ffbac6caf6126466c07fc', 's:69:\"https://npcbangladesh.org/cache/0f7c02895d2ffbac6caf6126466c07fc.webp\";', 1770102172),
('national-paralympic-committee-of-bangladesh-cache-image_cache_0fcff99ef8707dabb7d4523d584964c0', 's:69:\"https://npcbangladesh.org/cache/0fcff99ef8707dabb7d4523d584964c0.webp\";', 1770223617),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1001522f5d10f2a41ba0c8fd65aeb6b3', 's:69:\"https://npcbangladesh.org/cache/1001522f5d10f2a41ba0c8fd65aeb6b3.webp\";', 1770283050),
('national-paralympic-committee-of-bangladesh-cache-image_cache_10af9ec96573459cf8a7519dc96bd350', 's:69:\"https://npcbangladesh.org/cache/10af9ec96573459cf8a7519dc96bd350.webp\";', 1770358743),
('national-paralympic-committee-of-bangladesh-cache-image_cache_10b59a0fd04e7b50e36316ad899e95f1', 's:69:\"https://npcbangladesh.org/cache/10b59a0fd04e7b50e36316ad899e95f1.webp\";', 1770094644),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1117bca4f89aa3adbc85b3bd8449c62a', 's:69:\"https://npcbangladesh.org/cache/1117bca4f89aa3adbc85b3bd8449c62a.webp\";', 1770358764),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1197a9d52d06ce542da6535dec271305', 's:69:\"https://npcbangladesh.org/cache/1197a9d52d06ce542da6535dec271305.webp\";', 1770283060),
('national-paralympic-committee-of-bangladesh-cache-image_cache_11bfd99e33cbe472bc09132564bab184', 's:69:\"https://npcbangladesh.org/cache/11bfd99e33cbe472bc09132564bab184.webp\";', 1770223592),
('national-paralympic-committee-of-bangladesh-cache-image_cache_11d7c9b511a85c83173c41f2bbad8a36', 's:69:\"https://npcbangladesh.org/cache/11d7c9b511a85c83173c41f2bbad8a36.webp\";', 1770199930),
('national-paralympic-committee-of-bangladesh-cache-image_cache_124f6d3554fc3377dba28f3d8cb3ef28', 's:69:\"https://npcbangladesh.org/cache/124f6d3554fc3377dba28f3d8cb3ef28.webp\";', 1770358820),
('national-paralympic-committee-of-bangladesh-cache-image_cache_12c84d32307fec238627c20e50b6028c', 's:69:\"https://npcbangladesh.org/cache/12c84d32307fec238627c20e50b6028c.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_130349fafa4fe7010bb898eb42768431', 's:69:\"https://npcbangladesh.org/cache/130349fafa4fe7010bb898eb42768431.webp\";', 1770266092),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1388d907abd5cdbc7017530fc914977c', 's:69:\"https://npcbangladesh.org/cache/1388d907abd5cdbc7017530fc914977c.webp\";', 1770282977),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1393c31240f575b7f00df13e6b01cf8b', 's:69:\"https://npcbangladesh.org/cache/1393c31240f575b7f00df13e6b01cf8b.webp\";', 1770265828),
('national-paralympic-committee-of-bangladesh-cache-image_cache_13b6829e01b0e4176e54ee61d5acac96', 's:69:\"https://npcbangladesh.org/cache/13b6829e01b0e4176e54ee61d5acac96.webp\";', 1770266328),
('national-paralympic-committee-of-bangladesh-cache-image_cache_13d78db2f4d53ecea6857a762c9f97ea', 's:69:\"https://npcbangladesh.org/cache/13d78db2f4d53ecea6857a762c9f97ea.webp\";', 1770358810),
('national-paralympic-committee-of-bangladesh-cache-image_cache_13dbbc94512eecab7cdec65d03acb70a', 's:69:\"https://npcbangladesh.org/cache/13dbbc94512eecab7cdec65d03acb70a.webp\";', 1770223720),
('national-paralympic-committee-of-bangladesh-cache-image_cache_14a1e5225d6f5d4d7216a4a64cfe9242', 's:69:\"https://npcbangladesh.org/cache/14a1e5225d6f5d4d7216a4a64cfe9242.webp\";', 1770265826),
('national-paralympic-committee-of-bangladesh-cache-image_cache_14a26361c396d3bc467349f3c849798a', 's:69:\"https://npcbangladesh.org/cache/14a26361c396d3bc467349f3c849798a.webp\";', 1770283046),
('national-paralympic-committee-of-bangladesh-cache-image_cache_14d0018d747b9ee059d90b5e9a0d6b4a', 's:69:\"https://npcbangladesh.org/cache/14d0018d747b9ee059d90b5e9a0d6b4a.webp\";', 1770194299),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1534dde124da1fbb6adad4f75aff113b', 's:69:\"https://npcbangladesh.org/cache/1534dde124da1fbb6adad4f75aff113b.webp\";', 1770358706),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1570a1932009ecc0df953e3335d99944', 's:69:\"https://npcbangladesh.org/cache/1570a1932009ecc0df953e3335d99944.webp\";', 1770704068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_15a3c3b0d9ed123cb2dd30d1ca1312ae', 's:69:\"https://npcbangladesh.org/cache/15a3c3b0d9ed123cb2dd30d1ca1312ae.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_167fec4d9fdd0424abe3ffdcd3b61bf4', 's:69:\"https://npcbangladesh.org/cache/167fec4d9fdd0424abe3ffdcd3b61bf4.webp\";', 1770358817),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1722e39ebf4e5727ae46fafe3b4c3e5a', 's:69:\"https://npcbangladesh.org/cache/1722e39ebf4e5727ae46fafe3b4c3e5a.webp\";', 1770358721),
('national-paralympic-committee-of-bangladesh-cache-image_cache_178a03f60b61fd5f3566c6dee86ad20e', 's:69:\"https://npcbangladesh.org/cache/178a03f60b61fd5f3566c6dee86ad20e.webp\";', 1770266230),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1793c1f6c5344fb4f147cf1673c3e7d5', 's:69:\"https://npcbangladesh.org/cache/1793c1f6c5344fb4f147cf1673c3e7d5.webp\";', 1770282890),
('national-paralympic-committee-of-bangladesh-cache-image_cache_17eee3b11044bc51fa0844e5236f8554', 's:69:\"https://npcbangladesh.org/cache/17eee3b11044bc51fa0844e5236f8554.webp\";', 1770101769),
('national-paralympic-committee-of-bangladesh-cache-image_cache_17fc54814662e421ad6819add065e087', 's:69:\"https://npcbangladesh.org/cache/17fc54814662e421ad6819add065e087.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_182836695c1c61ab2731addefaae086c', 's:69:\"https://npcbangladesh.org/cache/182836695c1c61ab2731addefaae086c.webp\";', 1770282874),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1899314e06df95fb9a2fbde6b1bde8a0', 's:69:\"https://npcbangladesh.org/cache/1899314e06df95fb9a2fbde6b1bde8a0.webp\";', 1770266345),
('national-paralympic-committee-of-bangladesh-cache-image_cache_18f7c84de0051df273f1a447d3ab63da', 's:69:\"https://npcbangladesh.org/cache/18f7c84de0051df273f1a447d3ab63da.webp\";', 1770101833),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1924d0fd2c34d1a0d6108bf6b2b60893', 's:69:\"https://npcbangladesh.org/cache/1924d0fd2c34d1a0d6108bf6b2b60893.webp\";', 1770358711),
('national-paralympic-committee-of-bangladesh-cache-image_cache_19b1185f441b69bdd0d38bf4a3225388', 's:69:\"https://npcbangladesh.org/cache/19b1185f441b69bdd0d38bf4a3225388.webp\";', 1770283047),
('national-paralympic-committee-of-bangladesh-cache-image_cache_19bfa7dc1c7359c2a49b51f5e2c765d4', 's:69:\"https://npcbangladesh.org/cache/19bfa7dc1c7359c2a49b51f5e2c765d4.webp\";', 1770283044),
('national-paralympic-committee-of-bangladesh-cache-image_cache_19f08ed760b6f04a89528d5f190c7e2c', 's:69:\"https://npcbangladesh.org/cache/19f08ed760b6f04a89528d5f190c7e2c.webp\";', 1770223617),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1b47520c8066ca01aace91f6281889e6', 's:69:\"https://npcbangladesh.org/cache/1b47520c8066ca01aace91f6281889e6.webp\";', 1770358731),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1b7ec64bfa6e48884f1b7529d289e780', 's:69:\"https://npcbangladesh.org/cache/1b7ec64bfa6e48884f1b7529d289e780.webp\";', 1770223617),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1ba68811a75eabe0a0445b5073ad360f', 's:69:\"https://npcbangladesh.org/cache/1ba68811a75eabe0a0445b5073ad360f.webp\";', 1770358826),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1bb5c37001115b0dad966eed687d928c', 's:69:\"https://npcbangladesh.org/cache/1bb5c37001115b0dad966eed687d928c.webp\";', 1770282890),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1bc54cad4209e59b6bdff67a6baa855a', 's:69:\"https://npcbangladesh.org/cache/1bc54cad4209e59b6bdff67a6baa855a.webp\";', 1770102508),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1bd05c004ed8192b37e951b493da41d5', 's:69:\"https://npcbangladesh.org/cache/1bd05c004ed8192b37e951b493da41d5.webp\";', 1770265828),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1bde00c012d029d7bbe5becd37da61cd', 's:69:\"https://npcbangladesh.org/cache/1bde00c012d029d7bbe5becd37da61cd.webp\";', 1770282969),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1c134f7d3287f3be389188b592ed4154', 's:69:\"https://npcbangladesh.org/cache/1c134f7d3287f3be389188b592ed4154.webp\";', 1770094642),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1c71c0e278a794956cb48c5f47d90ec5', 's:69:\"https://npcbangladesh.org/cache/1c71c0e278a794956cb48c5f47d90ec5.webp\";', 1770101919),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1d75c70261af27caca81e3ec999cf7ac', 's:69:\"https://npcbangladesh.org/cache/1d75c70261af27caca81e3ec999cf7ac.webp\";', 1770358769),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1d982add8c9c4aa71a15cf30bc18b6b4', 's:69:\"https://npcbangladesh.org/cache/1d982add8c9c4aa71a15cf30bc18b6b4.webp\";', 1770358807),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1da345f6628e11642e3f5d098b819214', 's:69:\"https://npcbangladesh.org/cache/1da345f6628e11642e3f5d098b819214.webp\";', 1770265814),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1dc1649bc94f9df0eb102ff43a231d63', 's:69:\"https://npcbangladesh.org/cache/1dc1649bc94f9df0eb102ff43a231d63.webp\";', 1770283046),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1ee902e7d0af9d39a436451c0fc432a7', 's:69:\"https://npcbangladesh.org/cache/1ee902e7d0af9d39a436451c0fc432a7.webp\";', 1770099872),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1ef0d4bab11f767bee9949a9076e1512', 's:69:\"https://npcbangladesh.org/cache/1ef0d4bab11f767bee9949a9076e1512.webp\";', 1770704070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1eff0b51f409a3cc90522ba5cb3a9e4b', 's:69:\"https://npcbangladesh.org/cache/1eff0b51f409a3cc90522ba5cb3a9e4b.webp\";', 1770283071),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1f6872989c857feb58c071fa69ccb8b9', 's:69:\"https://npcbangladesh.org/cache/1f6872989c857feb58c071fa69ccb8b9.webp\";', 1770358739),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1f6ff781929b34f3e1d6671057823dd3', 's:69:\"https://npcbangladesh.org/cache/1f6ff781929b34f3e1d6671057823dd3.webp\";', 1770223617),
('national-paralympic-committee-of-bangladesh-cache-image_cache_1fb0f3085f792df51cbf27e0dfa6650a', 's:69:\"https://npcbangladesh.org/cache/1fb0f3085f792df51cbf27e0dfa6650a.webp\";', 1770102300),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2026398fc82bc0b9034fc9701f9b4378', 's:69:\"https://npcbangladesh.org/cache/2026398fc82bc0b9034fc9701f9b4378.webp\";', 1770358812),
('national-paralympic-committee-of-bangladesh-cache-image_cache_203b78b8201b1dc05907fa904d1c0f56', 's:69:\"https://npcbangladesh.org/cache/203b78b8201b1dc05907fa904d1c0f56.webp\";', 1770112208),
('national-paralympic-committee-of-bangladesh-cache-image_cache_20d78a0d79f611a1b89aad841904fd58', 's:69:\"https://npcbangladesh.org/cache/20d78a0d79f611a1b89aad841904fd58.webp\";', 1770278357),
('national-paralympic-committee-of-bangladesh-cache-image_cache_20e07ab5fc06260c417768af099ed083', 's:69:\"https://npcbangladesh.org/cache/20e07ab5fc06260c417768af099ed083.webp\";', 1770283045),
('national-paralympic-committee-of-bangladesh-cache-image_cache_20f8b38440d34d61a22d5a1fd15ecae8', 's:69:\"https://npcbangladesh.org/cache/20f8b38440d34d61a22d5a1fd15ecae8.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2150552128283c73c6a0bc32e9229a2e', 's:69:\"https://npcbangladesh.org/cache/2150552128283c73c6a0bc32e9229a2e.webp\";', 1770358755),
('national-paralympic-committee-of-bangladesh-cache-image_cache_22635216db0f13aa588d78c36f415fb0', 's:69:\"https://npcbangladesh.org/cache/22635216db0f13aa588d78c36f415fb0.webp\";', 1770278363),
('national-paralympic-committee-of-bangladesh-cache-image_cache_230dd9299477f66aca7bb280bc149c2d', 's:69:\"https://npcbangladesh.org/cache/230dd9299477f66aca7bb280bc149c2d.webp\";', 1770283145),
('national-paralympic-committee-of-bangladesh-cache-image_cache_23a72672d5a0799af770cc4d7b623eff', 's:69:\"https://npcbangladesh.org/cache/23a72672d5a0799af770cc4d7b623eff.webp\";', 1770266317),
('national-paralympic-committee-of-bangladesh-cache-image_cache_23accfd4c8e7254ec15c8525124a4e8c', 's:69:\"https://npcbangladesh.org/cache/23accfd4c8e7254ec15c8525124a4e8c.webp\";', 1770282983),
('national-paralympic-committee-of-bangladesh-cache-image_cache_23c40891c0f752e02fa1a2dd2be2e3ff', 's:69:\"https://npcbangladesh.org/cache/23c40891c0f752e02fa1a2dd2be2e3ff.webp\";', 1770094701),
('national-paralympic-committee-of-bangladesh-cache-image_cache_247222ef6117cc9c784b08231fa6e108', 's:69:\"https://npcbangladesh.org/cache/247222ef6117cc9c784b08231fa6e108.webp\";', 1770358778),
('national-paralympic-committee-of-bangladesh-cache-image_cache_24a026c4ec38dc0e7e3acdbbf4e32891', 's:69:\"https://npcbangladesh.org/cache/24a026c4ec38dc0e7e3acdbbf4e32891.webp\";', 1770266343),
('national-paralympic-committee-of-bangladesh-cache-image_cache_24e1e33de1b8f15a815389206d8aeef3', 's:69:\"https://npcbangladesh.org/cache/24e1e33de1b8f15a815389206d8aeef3.webp\";', 1770278264),
('national-paralympic-committee-of-bangladesh-cache-image_cache_25a33d62bca189d7f922bb547a19ffee', 's:69:\"https://npcbangladesh.org/cache/25a33d62bca189d7f922bb547a19ffee.webp\";', 1770358732),
('national-paralympic-committee-of-bangladesh-cache-image_cache_25dc93043b45cf0d9eb7db8915573dad', 's:69:\"https://npcbangladesh.org/cache/25dc93043b45cf0d9eb7db8915573dad.webp\";', 1770283155),
('national-paralympic-committee-of-bangladesh-cache-image_cache_25e3cc171b9c5c1074466ac0151a3119', 's:69:\"https://npcbangladesh.org/cache/25e3cc171b9c5c1074466ac0151a3119.webp\";', 1770266339),
('national-paralympic-committee-of-bangladesh-cache-image_cache_261df15bba4fefd30c1cd14d0715cab1', 's:69:\"https://npcbangladesh.org/cache/261df15bba4fefd30c1cd14d0715cab1.webp\";', 1770266328),
('national-paralympic-committee-of-bangladesh-cache-image_cache_265b18ac2cd8f929657e8227dcd0f322', 's:69:\"https://npcbangladesh.org/cache/265b18ac2cd8f929657e8227dcd0f322.webp\";', 1770283147),
('national-paralympic-committee-of-bangladesh-cache-image_cache_26702e2c85bad0b3fdb00a40f54e361d', 's:69:\"https://npcbangladesh.org/cache/26702e2c85bad0b3fdb00a40f54e361d.webp\";', 1770266313),
('national-paralympic-committee-of-bangladesh-cache-image_cache_26f0035f1ff1faec9af898e3864d110a', 's:69:\"https://npcbangladesh.org/cache/26f0035f1ff1faec9af898e3864d110a.webp\";', 1770266320),
('national-paralympic-committee-of-bangladesh-cache-image_cache_27aca93d89351e54a392b15057a31d9c', 's:69:\"https://npcbangladesh.org/cache/27aca93d89351e54a392b15057a31d9c.webp\";', 1770358771),
('national-paralympic-committee-of-bangladesh-cache-image_cache_28b9f7dff2c68c24244fcf36431b4dde', 's:69:\"https://npcbangladesh.org/cache/28b9f7dff2c68c24244fcf36431b4dde.webp\";', 1770094702),
('national-paralympic-committee-of-bangladesh-cache-image_cache_29409ff4b71f005591bd7b38b0973490', 's:69:\"https://npcbangladesh.org/cache/29409ff4b71f005591bd7b38b0973490.webp\";', 1770278996),
('national-paralympic-committee-of-bangladesh-cache-image_cache_29b51fcac8e004d2ebbf47cc5ea6cbe1', 's:69:\"https://npcbangladesh.org/cache/29b51fcac8e004d2ebbf47cc5ea6cbe1.webp\";', 1770266323),
('national-paralympic-committee-of-bangladesh-cache-image_cache_29b63287d89f2cb95327c6e21bc059fb', 's:69:\"https://npcbangladesh.org/cache/29b63287d89f2cb95327c6e21bc059fb.webp\";', 1770282778),
('national-paralympic-committee-of-bangladesh-cache-image_cache_29c80de7e3142193b222ca35d18af31f', 's:69:\"https://npcbangladesh.org/cache/29c80de7e3142193b222ca35d18af31f.webp\";', 1770282887),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2afd8f365beadbce82ad26b3153e1f78', 's:69:\"https://npcbangladesh.org/cache/2afd8f365beadbce82ad26b3153e1f78.webp\";', 1770094702),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2b27f067772f306cf12ad41812cecb63', 's:69:\"https://npcbangladesh.org/cache/2b27f067772f306cf12ad41812cecb63.webp\";', 1770282977),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2b299f80bf120aed091e56b9d79aa504', 's:69:\"https://npcbangladesh.org/cache/2b299f80bf120aed091e56b9d79aa504.webp\";', 1770278320),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2baff953fe160d7399bc2418305e1fcc', 's:69:\"https://npcbangladesh.org/cache/2baff953fe160d7399bc2418305e1fcc.webp\";', 1770358714),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2bbd513f7003b6fa4da302a37f5ed1b3', 's:69:\"https://npcbangladesh.org/cache/2bbd513f7003b6fa4da302a37f5ed1b3.webp\";', 1770265822),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2bc7b86022c1647f60217e25bbd6b2fb', 's:69:\"https://npcbangladesh.org/cache/2bc7b86022c1647f60217e25bbd6b2fb.webp\";', 1770266241),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2c15168cba373537108578ad6ae9cc24', 's:69:\"https://npcbangladesh.org/cache/2c15168cba373537108578ad6ae9cc24.webp\";', 1770223617),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2c3e0ce82c75c43212b92a39ad7ed5a8', 's:69:\"https://npcbangladesh.org/cache/2c3e0ce82c75c43212b92a39ad7ed5a8.webp\";', 1770094642),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2c456e0b1a069ec039627b3bf7951303', 's:69:\"https://npcbangladesh.org/cache/2c456e0b1a069ec039627b3bf7951303.webp\";', 1770284159),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2c5d01c849bc03430d3b16fbecc55ef0', 's:69:\"https://npcbangladesh.org/cache/2c5d01c849bc03430d3b16fbecc55ef0.webp\";', 1770283139),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2c68492098067a6d0d0d009b610090f9', 's:69:\"https://npcbangladesh.org/cache/2c68492098067a6d0d0d009b610090f9.webp\";', 1770282962),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2cd9600ba82c6708754b34d866d01539', 's:69:\"https://npcbangladesh.org/cache/2cd9600ba82c6708754b34d866d01539.webp\";', 1770358763),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2d3995f5623e5294b422b3d7018aed0c', 's:69:\"https://npcbangladesh.org/cache/2d3995f5623e5294b422b3d7018aed0c.webp\";', 1770265818),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2d6d11765d21f466f69d719535a7f0a0', 's:69:\"https://npcbangladesh.org/cache/2d6d11765d21f466f69d719535a7f0a0.webp\";', 1770102099),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2d8b8cf9888c3283c11065cd20e33517', 's:69:\"https://npcbangladesh.org/cache/2d8b8cf9888c3283c11065cd20e33517.webp\";', 1770094642),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2dada7bb79d507735616da498059fb2c', 's:69:\"https://npcbangladesh.org/cache/2dada7bb79d507735616da498059fb2c.webp\";', 1770279083),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2e1c80b8ccd0aa4d8dedc883752749c9', 's:69:\"https://npcbangladesh.org/cache/2e1c80b8ccd0aa4d8dedc883752749c9.webp\";', 1770266305),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2e7b23ad6ef5b2e62b48a27cdbe88af4', 's:69:\"https://npcbangladesh.org/cache/2e7b23ad6ef5b2e62b48a27cdbe88af4.webp\";', 1770266329),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2ea27dc00e7f9695ac5ebb75add48305', 's:69:\"https://npcbangladesh.org/cache/2ea27dc00e7f9695ac5ebb75add48305.webp\";', 1770282942),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2ea58aa3b58e06080185147c0347c372', 's:69:\"https://npcbangladesh.org/cache/2ea58aa3b58e06080185147c0347c372.webp\";', 1770266328),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2f4caca43f744f8f237e05fa772a8311', 's:69:\"https://npcbangladesh.org/cache/2f4caca43f744f8f237e05fa772a8311.webp\";', 1770098097),
('national-paralympic-committee-of-bangladesh-cache-image_cache_2fc03d8ea37c82e3a83f1169a65fe5c7', 's:69:\"https://npcbangladesh.org/cache/2fc03d8ea37c82e3a83f1169a65fe5c7.webp\";', 1770283147),
('national-paralympic-committee-of-bangladesh-cache-image_cache_30350b17f413a6a3579b19b9c5c82f76', 's:69:\"https://npcbangladesh.org/cache/30350b17f413a6a3579b19b9c5c82f76.webp\";', 1770266336),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3055d3ec0239047fd6dec2d89726b556', 's:69:\"https://npcbangladesh.org/cache/3055d3ec0239047fd6dec2d89726b556.webp\";', 1770704068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3063fb89f835984e879808f917c67f0d', 's:69:\"https://npcbangladesh.org/cache/3063fb89f835984e879808f917c67f0d.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_306e7f479ee091812c1663b36adce5e3', 's:69:\"https://npcbangladesh.org/cache/306e7f479ee091812c1663b36adce5e3.webp\";', 1770358712),
('national-paralympic-committee-of-bangladesh-cache-image_cache_307ae95ce1c494d40e31fbb1b913130c', 's:69:\"https://npcbangladesh.org/cache/307ae95ce1c494d40e31fbb1b913130c.webp\";', 1770265818),
('national-paralympic-committee-of-bangladesh-cache-image_cache_30d017f89fd3db97dc89de9ced7d3b78', 's:69:\"https://npcbangladesh.org/cache/30d017f89fd3db97dc89de9ced7d3b78.webp\";', 1770298170),
('national-paralympic-committee-of-bangladesh-cache-image_cache_31504603f49b9dbf59f2440a1a510c4a', 's:69:\"https://npcbangladesh.org/cache/31504603f49b9dbf59f2440a1a510c4a.webp\";', 1770112208),
('national-paralympic-committee-of-bangladesh-cache-image_cache_31645f1a4af76f15cb0f8d1b5cd14054', 's:69:\"https://npcbangladesh.org/cache/31645f1a4af76f15cb0f8d1b5cd14054.webp\";', 1770358712),
('national-paralympic-committee-of-bangladesh-cache-image_cache_31c46e5b96797c064e77cbcb5ba620b2', 's:69:\"https://npcbangladesh.org/cache/31c46e5b96797c064e77cbcb5ba620b2.webp\";', 1770266241),
('national-paralympic-committee-of-bangladesh-cache-image_cache_32c9a9fe7f4157d0ba9cc28fc8a2f9ca', 's:69:\"https://npcbangladesh.org/cache/32c9a9fe7f4157d0ba9cc28fc8a2f9ca.webp\";', 1770265828),
('national-paralympic-committee-of-bangladesh-cache-image_cache_32ff4dcf4ba023a67bf66e2b8a2b28a6', 's:69:\"https://npcbangladesh.org/cache/32ff4dcf4ba023a67bf66e2b8a2b28a6.webp\";', 1770222217),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3384c5ef36cd71d542cc6103866379a1', 's:69:\"https://npcbangladesh.org/cache/3384c5ef36cd71d542cc6103866379a1.webp\";', 1770358758),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3391271a38a23124ddc9afe8414a1401', 's:69:\"https://npcbangladesh.org/cache/3391271a38a23124ddc9afe8414a1401.webp\";', 1770358777),
('national-paralympic-committee-of-bangladesh-cache-image_cache_33f36ec892ee3792165640019f0713c7', 's:69:\"https://npcbangladesh.org/cache/33f36ec892ee3792165640019f0713c7.webp\";', 1770358699),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3404aa8db3cfa7e8cda0de18abf38c9b', 's:69:\"https://npcbangladesh.org/cache/3404aa8db3cfa7e8cda0de18abf38c9b.webp\";', 1770266239),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3447c0a279c4c161433733d1baee4b4e', 's:69:\"https://npcbangladesh.org/cache/3447c0a279c4c161433733d1baee4b4e.webp\";', 1770266307),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3534856dc2e12b672192c86ac0c57b2b', 's:69:\"https://npcbangladesh.org/cache/3534856dc2e12b672192c86ac0c57b2b.webp\";', 1770278333),
('national-paralympic-committee-of-bangladesh-cache-image_cache_358c90ba233683b7f504a53369732bc3', 's:69:\"https://npcbangladesh.org/cache/358c90ba233683b7f504a53369732bc3.webp\";', 1770266315),
('national-paralympic-committee-of-bangladesh-cache-image_cache_35d7b232719dced6e30fdb5c823d8bdc', 's:69:\"https://npcbangladesh.org/cache/35d7b232719dced6e30fdb5c823d8bdc.webp\";', 1770112208),
('national-paralympic-committee-of-bangladesh-cache-image_cache_35ee855e705da62e69acbe5d458a753d', 's:69:\"https://npcbangladesh.org/cache/35ee855e705da62e69acbe5d458a753d.webp\";', 1770266347),
('national-paralympic-committee-of-bangladesh-cache-image_cache_35fdbe83605ba978a9260217340b0072', 's:69:\"https://npcbangladesh.org/cache/35fdbe83605ba978a9260217340b0072.webp\";', 1770704070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_360649bb3651d51b5f7a9258d6ac35ea', 's:69:\"https://npcbangladesh.org/cache/360649bb3651d51b5f7a9258d6ac35ea.webp\";', 1770283154),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3618fb75700a950d797b2ae2af53e255', 's:69:\"https://npcbangladesh.org/cache/3618fb75700a950d797b2ae2af53e255.webp\";', 1770222217),
('national-paralympic-committee-of-bangladesh-cache-image_cache_36277ba117bd0b9ede64d56d97d8b4b3', 's:69:\"https://npcbangladesh.org/cache/36277ba117bd0b9ede64d56d97d8b4b3.webp\";', 1770266326),
('national-paralympic-committee-of-bangladesh-cache-image_cache_366ef561b1e84848418f0ab85d044c1a', 's:69:\"https://npcbangladesh.org/cache/366ef561b1e84848418f0ab85d044c1a.webp\";', 1770223592),
('national-paralympic-committee-of-bangladesh-cache-image_cache_367730d9113d457bb0436407419091a8', 's:69:\"https://npcbangladesh.org/cache/367730d9113d457bb0436407419091a8.webp\";', 1770282889),
('national-paralympic-committee-of-bangladesh-cache-image_cache_377b5fec5fa63debe97aa7856bde6094', 's:69:\"https://npcbangladesh.org/cache/377b5fec5fa63debe97aa7856bde6094.webp\";', 1770358770),
('national-paralympic-committee-of-bangladesh-cache-image_cache_377b629cd1bd1fbb6ce4d0ce78602d44', 's:69:\"https://npcbangladesh.org/cache/377b629cd1bd1fbb6ce4d0ce78602d44.webp\";', 1770266343),
('national-paralympic-committee-of-bangladesh-cache-image_cache_37855d02ac5a782202fb05825a4f03ce', 's:69:\"https://npcbangladesh.org/cache/37855d02ac5a782202fb05825a4f03ce.webp\";', 1770282962),
('national-paralympic-committee-of-bangladesh-cache-image_cache_37e4f1063b531b43572936f649e1f732', 's:69:\"https://npcbangladesh.org/cache/37e4f1063b531b43572936f649e1f732.webp\";', 1770282960),
('national-paralympic-committee-of-bangladesh-cache-image_cache_37f25718de298d5e2c773a949807c155', 's:69:\"https://npcbangladesh.org/cache/37f25718de298d5e2c773a949807c155.webp\";', 1770278364),
('national-paralympic-committee-of-bangladesh-cache-image_cache_383dc5b54e9c4fb80b0fdb951afef2c1', 's:69:\"https://npcbangladesh.org/cache/383dc5b54e9c4fb80b0fdb951afef2c1.webp\";', 1770101802),
('national-paralympic-committee-of-bangladesh-cache-image_cache_38ac6041f4bd79defdd6a37b188c32d1', 's:69:\"https://npcbangladesh.org/cache/38ac6041f4bd79defdd6a37b188c32d1.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_394cd85e6af66927134ce52f97bc200a', 's:69:\"https://npcbangladesh.org/cache/394cd85e6af66927134ce52f97bc200a.webp\";', 1770283155),
('national-paralympic-committee-of-bangladesh-cache-image_cache_39b7cf5dcfa5bf624ab52815165dc5e1', 's:69:\"https://npcbangladesh.org/cache/39b7cf5dcfa5bf624ab52815165dc5e1.webp\";', 1770266333),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3a03246d7b6c3bf157bd2adcb0a81862', 's:69:\"https://npcbangladesh.org/cache/3a03246d7b6c3bf157bd2adcb0a81862.webp\";', 1770704068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3b527707716a6d0daf434058161acdf0', 's:68:\"https://npcbangladesh.org/cache/3b527707716a6d0daf434058161acdf0.png\";', 1770278357),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3c2cb704954ff09e1b6abd1b15ea8d90', 's:69:\"https://npcbangladesh.org/cache/3c2cb704954ff09e1b6abd1b15ea8d90.webp\";', 1770101805),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3c8b407099a6684e09f65091c4391157', 's:69:\"https://npcbangladesh.org/cache/3c8b407099a6684e09f65091c4391157.webp\";', 1770101833),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3cadbdb441a55fc8cac30bfc40b72ff7', 's:69:\"https://npcbangladesh.org/cache/3cadbdb441a55fc8cac30bfc40b72ff7.webp\";', 1770185387),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3cb0ee4a12d1d0178b86c89b5a109988', 's:69:\"https://npcbangladesh.org/cache/3cb0ee4a12d1d0178b86c89b5a109988.webp\";', 1770358768),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3ddcd938b8d093c57b80cc81dbe1c1e4', 's:69:\"https://npcbangladesh.org/cache/3ddcd938b8d093c57b80cc81dbe1c1e4.webp\";', 1770112208),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3de2d6acaca40defdea724d865e0cc00', 's:69:\"https://npcbangladesh.org/cache/3de2d6acaca40defdea724d865e0cc00.webp\";', 1770358824),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3e3a3095a6d9f139560ac46ab270f126', 's:69:\"https://npcbangladesh.org/cache/3e3a3095a6d9f139560ac46ab270f126.webp\";', 1770283047),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3e40bbca02a7909161f10473f74b7884', 's:69:\"https://npcbangladesh.org/cache/3e40bbca02a7909161f10473f74b7884.webp\";', 1770282772),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3e45d05343b7bdbb9418ed70250c5daa', 's:69:\"https://npcbangladesh.org/cache/3e45d05343b7bdbb9418ed70250c5daa.webp\";', 1770185386),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3ee71214a2a8b6e955f809ce56e17572', 's:69:\"https://npcbangladesh.org/cache/3ee71214a2a8b6e955f809ce56e17572.webp\";', 1770265816),
('national-paralympic-committee-of-bangladesh-cache-image_cache_3f434218400c7ac98789fdaa3bf03701', 's:69:\"https://npcbangladesh.org/cache/3f434218400c7ac98789fdaa3bf03701.webp\";', 1770282944),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4052b9a0fff6290fde2dd864a42734a8', 's:69:\"https://npcbangladesh.org/cache/4052b9a0fff6290fde2dd864a42734a8.webp\";', 1770358713),
('national-paralympic-committee-of-bangladesh-cache-image_cache_40efa0059476c8763dadd21442d7e2f7', 's:69:\"https://npcbangladesh.org/cache/40efa0059476c8763dadd21442d7e2f7.webp\";', 1770283064),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4124699757084a0b91087c37877cb168', 's:69:\"https://npcbangladesh.org/cache/4124699757084a0b91087c37877cb168.webp\";', 1770185387),
('national-paralympic-committee-of-bangladesh-cache-image_cache_41ccbc6bd368805dd478c0aa11dad9dc', 's:69:\"https://npcbangladesh.org/cache/41ccbc6bd368805dd478c0aa11dad9dc.webp\";', 1770103070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_421bace3163577f61f4c2929195c84fb', 's:69:\"https://npcbangladesh.org/cache/421bace3163577f61f4c2929195c84fb.webp\";', 1770282975),
('national-paralympic-committee-of-bangladesh-cache-image_cache_438f8ea05fe7c05701f723355f4e3d8c', 's:69:\"https://npcbangladesh.org/cache/438f8ea05fe7c05701f723355f4e3d8c.webp\";', 1770282961),
('national-paralympic-committee-of-bangladesh-cache-image_cache_43bf09c70c560313dac2c0acbb867cb2', 's:69:\"https://npcbangladesh.org/cache/43bf09c70c560313dac2c0acbb867cb2.webp\";', 1770101801),
('national-paralympic-committee-of-bangladesh-cache-image_cache_44068905cacd01c981c9537fab63d7eb', 's:69:\"https://npcbangladesh.org/cache/44068905cacd01c981c9537fab63d7eb.webp\";', 1770283146),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4415d123adcf7fddc1c54951eac4f2bd', 's:69:\"https://npcbangladesh.org/cache/4415d123adcf7fddc1c54951eac4f2bd.webp\";', 1770266339),
('national-paralympic-committee-of-bangladesh-cache-image_cache_444ce00ad8130266d9f93c261d1a42ac', 's:69:\"https://npcbangladesh.org/cache/444ce00ad8130266d9f93c261d1a42ac.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_44d024df2155a0875f0a72ff34c79d4a', 's:69:\"https://npcbangladesh.org/cache/44d024df2155a0875f0a72ff34c79d4a.webp\";', 1770282963),
('national-paralympic-committee-of-bangladesh-cache-image_cache_45aa7ff605faceee78ee06dbcafda583', 's:69:\"https://npcbangladesh.org/cache/45aa7ff605faceee78ee06dbcafda583.webp\";', 1770266331),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4642c9ebb3f5e400713bc6edfae9fc4e', 's:69:\"https://npcbangladesh.org/cache/4642c9ebb3f5e400713bc6edfae9fc4e.webp\";', 1770266329),
('national-paralympic-committee-of-bangladesh-cache-image_cache_46afe805264187ba4a022d4d16ab1026', 's:69:\"https://npcbangladesh.org/cache/46afe805264187ba4a022d4d16ab1026.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_479b6cf35a0a29675513e78b06eaf495', 's:69:\"https://npcbangladesh.org/cache/479b6cf35a0a29675513e78b06eaf495.webp\";', 1770185318),
('national-paralympic-committee-of-bangladesh-cache-image_cache_496e3732e690753a21a72facf3e4e7ac', 's:69:\"https://npcbangladesh.org/cache/496e3732e690753a21a72facf3e4e7ac.webp\";', 1770278263),
('national-paralympic-committee-of-bangladesh-cache-image_cache_497c422d96b1367e73e4a536b48b0acc', 's:69:\"https://npcbangladesh.org/cache/497c422d96b1367e73e4a536b48b0acc.webp\";', 1770278275),
('national-paralympic-committee-of-bangladesh-cache-image_cache_49d9400669b04f11259c7a523fa5728d', 's:69:\"https://npcbangladesh.org/cache/49d9400669b04f11259c7a523fa5728d.webp\";', 1770112208),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4a0992905b6b73281e57def64510544d', 's:69:\"https://npcbangladesh.org/cache/4a0992905b6b73281e57def64510544d.webp\";', 1770358726),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4a3f37ecd9d0947f957d6c39a7c08614', 's:69:\"https://npcbangladesh.org/cache/4a3f37ecd9d0947f957d6c39a7c08614.webp\";', 1770282778),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4a8730a01f89aced56d103627d3210fc', 's:69:\"https://npcbangladesh.org/cache/4a8730a01f89aced56d103627d3210fc.webp\";', 1770265815),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4b06926c80ffcedd5e6c20cd3ccc05a3', 's:69:\"https://npcbangladesh.org/cache/4b06926c80ffcedd5e6c20cd3ccc05a3.webp\";', 1770282888),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4b9c6cd0b29f9aa2f1d6f1178f052f2a', 's:69:\"https://npcbangladesh.org/cache/4b9c6cd0b29f9aa2f1d6f1178f052f2a.webp\";', 1770266312),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4c0ff014e0de7380082285bc8cfcc77b', 's:69:\"https://npcbangladesh.org/cache/4c0ff014e0de7380082285bc8cfcc77b.webp\";', 1770265828),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4c200ab3ecf5fb75b4ff17189f0e24bd', 's:69:\"https://npcbangladesh.org/cache/4c200ab3ecf5fb75b4ff17189f0e24bd.webp\";', 1770101768),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4c7cfc94ac4b6b0de11728579ed3e039', 's:69:\"https://npcbangladesh.org/cache/4c7cfc94ac4b6b0de11728579ed3e039.webp\";', 1770099865),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4cf79214faeff16e8a45f8e3d09f64bb', 's:69:\"https://npcbangladesh.org/cache/4cf79214faeff16e8a45f8e3d09f64bb.webp\";', 1770265818),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4d4ad69dde4726e19c29023cd69ea473', 's:69:\"https://npcbangladesh.org/cache/4d4ad69dde4726e19c29023cd69ea473.webp\";', 1770282889),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4de436f8ad9dfef7890c4713385468ff', 's:69:\"https://npcbangladesh.org/cache/4de436f8ad9dfef7890c4713385468ff.webp\";', 1770266334),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4dffead6288c7de1145f19730864b044', 's:69:\"https://npcbangladesh.org/cache/4dffead6288c7de1145f19730864b044.webp\";', 1770358746),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4e02321ebe006facb3b1719693ec538d', 's:69:\"https://npcbangladesh.org/cache/4e02321ebe006facb3b1719693ec538d.webp\";', 1770102132),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4e6b7a7db30986c70ab2c52d77a25c88', 's:69:\"https://npcbangladesh.org/cache/4e6b7a7db30986c70ab2c52d77a25c88.webp\";', 1770283071),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4ee9969a041f43feaa53b7846847674d', 's:69:\"https://npcbangladesh.org/cache/4ee9969a041f43feaa53b7846847674d.webp\";', 1770102131),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4ef614c3e1bf588d8e674f27b748bac2', 's:68:\"https://npcbangladesh.org/cache/4ef614c3e1bf588d8e674f27b748bac2.png\";', 1770278356),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4f8a8b8c6d3b967b93f43eefa654cbed', 's:69:\"https://npcbangladesh.org/cache/4f8a8b8c6d3b967b93f43eefa654cbed.webp\";', 1770704070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_4fff1ff4f591c2b1d7cb121c779d92f3', 's:69:\"https://npcbangladesh.org/cache/4fff1ff4f591c2b1d7cb121c779d92f3.webp\";', 1770266227),
('national-paralympic-committee-of-bangladesh-cache-image_cache_508c217e00bf2f5f3742f6e9b19bc3d7', 's:69:\"https://npcbangladesh.org/cache/508c217e00bf2f5f3742f6e9b19bc3d7.webp\";', 1770358808),
('national-paralympic-committee-of-bangladesh-cache-image_cache_51143870eeb1c27e04301ce31fe4fc91', 's:69:\"https://npcbangladesh.org/cache/51143870eeb1c27e04301ce31fe4fc91.webp\";', 1770266324),
('national-paralympic-committee-of-bangladesh-cache-image_cache_512e13d6ec8380b9db1d8ee4b5d7e729', 's:69:\"https://npcbangladesh.org/cache/512e13d6ec8380b9db1d8ee4b5d7e729.webp\";', 1770282982),
('national-paralympic-committee-of-bangladesh-cache-image_cache_51c92dcf19129b4e430757e3f902f2bb', 's:69:\"https://npcbangladesh.org/cache/51c92dcf19129b4e430757e3f902f2bb.webp\";', 1770358713),
('national-paralympic-committee-of-bangladesh-cache-image_cache_51c992600db4ed4af098f8f1fdb72eed', 's:69:\"https://npcbangladesh.org/cache/51c992600db4ed4af098f8f1fdb72eed.webp\";', 1770265815),
('national-paralympic-committee-of-bangladesh-cache-image_cache_51eb4641703f937d2624e2b0501c45ce', 's:69:\"https://npcbangladesh.org/cache/51eb4641703f937d2624e2b0501c45ce.webp\";', 1770101833),
('national-paralympic-committee-of-bangladesh-cache-image_cache_52dfe8243c9ff1051e71d1ebb4533659', 's:69:\"https://npcbangladesh.org/cache/52dfe8243c9ff1051e71d1ebb4533659.webp\";', 1770266314),
('national-paralympic-committee-of-bangladesh-cache-image_cache_53676a92ccdf1c9ae7d6cb5bb4ea6489', 's:69:\"https://npcbangladesh.org/cache/53676a92ccdf1c9ae7d6cb5bb4ea6489.webp\";', 1770278996),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5437bb3cee35901c8b77555546d6c4c0', 's:69:\"https://npcbangladesh.org/cache/5437bb3cee35901c8b77555546d6c4c0.webp\";', 1770279012),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5452ed405868b5c342ee7b696fae9cf5', 's:69:\"https://npcbangladesh.org/cache/5452ed405868b5c342ee7b696fae9cf5.webp\";', 1770282859),
('national-paralympic-committee-of-bangladesh-cache-image_cache_54f4a97e48662099595c9cffc1dc8422', 's:69:\"https://npcbangladesh.org/cache/54f4a97e48662099595c9cffc1dc8422.webp\";', 1770266333),
('national-paralympic-committee-of-bangladesh-cache-image_cache_550070896f18ff1a9dd28a4245aea733', 's:69:\"https://npcbangladesh.org/cache/550070896f18ff1a9dd28a4245aea733.webp\";', 1770266343),
('national-paralympic-committee-of-bangladesh-cache-image_cache_55317b52b68bfff1a9dffa98a481266f', 's:69:\"https://npcbangladesh.org/cache/55317b52b68bfff1a9dffa98a481266f.webp\";', 1770283141),
('national-paralympic-committee-of-bangladesh-cache-image_cache_568404f66f2a38dd6154dc00038d8658', 's:69:\"https://npcbangladesh.org/cache/568404f66f2a38dd6154dc00038d8658.webp\";', 1770283061),
('national-paralympic-committee-of-bangladesh-cache-image_cache_56c7f5849215aa55e4156b5e91eb44e4', 's:69:\"https://npcbangladesh.org/cache/56c7f5849215aa55e4156b5e91eb44e4.webp\";', 1770266345),
('national-paralympic-committee-of-bangladesh-cache-image_cache_57ac55ce81a190434e4387db43b3db64', 's:69:\"https://npcbangladesh.org/cache/57ac55ce81a190434e4387db43b3db64.webp\";', 1770266331),
('national-paralympic-committee-of-bangladesh-cache-image_cache_57c7160c2db832cdd4e668c69c60f9ac', 's:69:\"https://npcbangladesh.org/cache/57c7160c2db832cdd4e668c69c60f9ac.webp\";', 1770266336),
('national-paralympic-committee-of-bangladesh-cache-image_cache_57ea8b772aa1eb516544de8d312c0376', 's:69:\"https://npcbangladesh.org/cache/57ea8b772aa1eb516544de8d312c0376.webp\";', 1770094702),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5824778225890e7437ffd74ce43e932b', 's:69:\"https://npcbangladesh.org/cache/5824778225890e7437ffd74ce43e932b.webp\";', 1770288510);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('national-paralympic-committee-of-bangladesh-cache-image_cache_58916d5a48636aeac40022a55fd72a43', 's:69:\"https://npcbangladesh.org/cache/58916d5a48636aeac40022a55fd72a43.webp\";', 1770266305),
('national-paralympic-committee-of-bangladesh-cache-image_cache_59839d41bade0b616071ebc8d47f4666', 's:69:\"https://npcbangladesh.org/cache/59839d41bade0b616071ebc8d47f4666.webp\";', 1770358645),
('national-paralympic-committee-of-bangladesh-cache-image_cache_59997f7170d29ccbeb78de977ecc5c82', 's:69:\"https://npcbangladesh.org/cache/59997f7170d29ccbeb78de977ecc5c82.webp\";', 1770266332),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5a0c450ec4974216ed7b3b524f60de85', 's:69:\"https://npcbangladesh.org/cache/5a0c450ec4974216ed7b3b524f60de85.webp\";', 1770094701),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5a101de50ac1daffa5175018fd3c68e8', 's:69:\"https://npcbangladesh.org/cache/5a101de50ac1daffa5175018fd3c68e8.webp\";', 1770102131),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5af816dc97d13d5aa46331658a275328', 's:69:\"https://npcbangladesh.org/cache/5af816dc97d13d5aa46331658a275328.webp\";', 1770101833),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5bcb6501f9557571f2a428f2c3a08b7e', 's:69:\"https://npcbangladesh.org/cache/5bcb6501f9557571f2a428f2c3a08b7e.webp\";', 1770265670),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5c68f77d9320276a1d9f9d6c2e566f5b', 's:69:\"https://npcbangladesh.org/cache/5c68f77d9320276a1d9f9d6c2e566f5b.webp\";', 1770101929),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5c7370ef1a009009c02adfdc66f4567b', 's:69:\"https://npcbangladesh.org/cache/5c7370ef1a009009c02adfdc66f4567b.webp\";', 1770358765),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5d13492b0d853100d20172d2c3c7e206', 's:69:\"https://npcbangladesh.org/cache/5d13492b0d853100d20172d2c3c7e206.webp\";', 1770358761),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5d1bc457144fb729acb5521038aae1e2', 's:69:\"https://npcbangladesh.org/cache/5d1bc457144fb729acb5521038aae1e2.webp\";', 1770094701),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5d5fd063b9b2c036b66348a5be3c2a20', 's:69:\"https://npcbangladesh.org/cache/5d5fd063b9b2c036b66348a5be3c2a20.webp\";', 1770278321),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5e23c684cd31148c18f48527003283aa', 's:69:\"https://npcbangladesh.org/cache/5e23c684cd31148c18f48527003283aa.webp\";', 1770358828),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5e7cc51d78ab69ee7dfe660a6c73c97f', 's:69:\"https://npcbangladesh.org/cache/5e7cc51d78ab69ee7dfe660a6c73c97f.webp\";', 1770358779),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5e827c955a4391deb2068532355a56e6', 's:68:\"https://npcbangladesh.org/cache/5e827c955a4391deb2068532355a56e6.png\";', 1770278365),
('national-paralympic-committee-of-bangladesh-cache-image_cache_5fa922cd06dcbf83e0ed1c8d38af3f83', 's:69:\"https://npcbangladesh.org/cache/5fa922cd06dcbf83e0ed1c8d38af3f83.webp\";', 1770282875),
('national-paralympic-committee-of-bangladesh-cache-image_cache_60816b7802e1a0293c06c051e2f0591c', 's:69:\"https://npcbangladesh.org/cache/60816b7802e1a0293c06c051e2f0591c.webp\";', 1770095254),
('national-paralympic-committee-of-bangladesh-cache-image_cache_60c7eb492ac42181b3d1c83655a90a8b', 's:69:\"https://npcbangladesh.org/cache/60c7eb492ac42181b3d1c83655a90a8b.webp\";', 1770283147),
('national-paralympic-committee-of-bangladesh-cache-image_cache_60e1e5e803103b66b6effabd70267873', 's:69:\"https://npcbangladesh.org/cache/60e1e5e803103b66b6effabd70267873.webp\";', 1770102131),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6134a736ac42b13cc30ccd1181caf5fb', 's:69:\"https://npcbangladesh.org/cache/6134a736ac42b13cc30ccd1181caf5fb.webp\";', 1770266337),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6171256961bdcf840182796b05e607a8', 's:69:\"https://npcbangladesh.org/cache/6171256961bdcf840182796b05e607a8.webp\";', 1770283065),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6197e07b473b19bcfeead5dfadddd3ea', 's:69:\"https://npcbangladesh.org/cache/6197e07b473b19bcfeead5dfadddd3ea.webp\";', 1770265821),
('national-paralympic-committee-of-bangladesh-cache-image_cache_61cc4be9d16fa0110eceec95eb563f23', 's:69:\"https://npcbangladesh.org/cache/61cc4be9d16fa0110eceec95eb563f23.webp\";', 1770101834),
('national-paralympic-committee-of-bangladesh-cache-image_cache_61ede8d29c5f95d6b3945e1e86236e01', 's:69:\"https://npcbangladesh.org/cache/61ede8d29c5f95d6b3945e1e86236e01.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_61efc6620af074e66c24c75fb2f3bd80', 's:69:\"https://npcbangladesh.org/cache/61efc6620af074e66c24c75fb2f3bd80.webp\";', 1770266318),
('national-paralympic-committee-of-bangladesh-cache-image_cache_620812f8b3488d9c5e3d9c27ad5bb611', 's:69:\"https://npcbangladesh.org/cache/620812f8b3488d9c5e3d9c27ad5bb611.webp\";', 1770102508),
('national-paralympic-committee-of-bangladesh-cache-image_cache_625e945ca21943b8682103e88d6140df', 's:69:\"https://npcbangladesh.org/cache/625e945ca21943b8682103e88d6140df.webp\";', 1770094748),
('national-paralympic-committee-of-bangladesh-cache-image_cache_627f237ffe549554c2d1b3375694a6b6', 's:69:\"https://npcbangladesh.org/cache/627f237ffe549554c2d1b3375694a6b6.webp\";', 1770101766),
('national-paralympic-committee-of-bangladesh-cache-image_cache_637099299777e9fcf59879fa1c97e5cb', 's:69:\"https://npcbangladesh.org/cache/637099299777e9fcf59879fa1c97e5cb.webp\";', 1770283142),
('national-paralympic-committee-of-bangladesh-cache-image_cache_638ff6fd5a01df1723e5312ba4ea2d70', 's:69:\"https://npcbangladesh.org/cache/638ff6fd5a01df1723e5312ba4ea2d70.webp\";', 1770101833),
('national-paralympic-committee-of-bangladesh-cache-image_cache_63b7ef03a5d9395838fe9172a5f722d1', 's:69:\"https://npcbangladesh.org/cache/63b7ef03a5d9395838fe9172a5f722d1.webp\";', 1770223617),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6462875dd29a0fe427582ff49760f850', 's:69:\"https://npcbangladesh.org/cache/6462875dd29a0fe427582ff49760f850.webp\";', 1770358749),
('national-paralympic-committee-of-bangladesh-cache-image_cache_64a02f1cd2051096cd7737df2399f934', 's:69:\"https://npcbangladesh.org/cache/64a02f1cd2051096cd7737df2399f934.webp\";', 1770094642),
('national-paralympic-committee-of-bangladesh-cache-image_cache_654c98f1ce040e3e8017a1baeeae26d6', 's:69:\"https://npcbangladesh.org/cache/654c98f1ce040e3e8017a1baeeae26d6.webp\";', 1770358705),
('national-paralympic-committee-of-bangladesh-cache-image_cache_65eaf5e45f069054cc15e250da8c47f8', 's:69:\"https://npcbangladesh.org/cache/65eaf5e45f069054cc15e250da8c47f8.webp\";', 1770265826),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6667d8fbf6da77beb8890221ca8d53fc', 's:69:\"https://npcbangladesh.org/cache/6667d8fbf6da77beb8890221ca8d53fc.webp\";', 1770266319),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6679b6980232218bfc466add151d0c05', 's:69:\"https://npcbangladesh.org/cache/6679b6980232218bfc466add151d0c05.webp\";', 1770358807),
('national-paralympic-committee-of-bangladesh-cache-image_cache_673fa427a2f603deb2a6d08769584299', 's:69:\"https://npcbangladesh.org/cache/673fa427a2f603deb2a6d08769584299.webp\";', 1770283141),
('national-paralympic-committee-of-bangladesh-cache-image_cache_680b4e96306da9bfe0cdfd647b804ce2', 's:69:\"https://npcbangladesh.org/cache/680b4e96306da9bfe0cdfd647b804ce2.webp\";', 1770185387),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6820dac5f37b17c576a39cba31963edf', 's:69:\"https://npcbangladesh.org/cache/6820dac5f37b17c576a39cba31963edf.webp\";', 1770282964),
('national-paralympic-committee-of-bangladesh-cache-image_cache_69000845f6bd33c1e56d2b0c9a07ffac', 's:69:\"https://npcbangladesh.org/cache/69000845f6bd33c1e56d2b0c9a07ffac.webp\";', 1770266332),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6923391465dc3539c552d307789ec7f5', 's:69:\"https://npcbangladesh.org/cache/6923391465dc3539c552d307789ec7f5.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6948bbd3520c33729781920b92187a9a', 's:69:\"https://npcbangladesh.org/cache/6948bbd3520c33729781920b92187a9a.webp\";', 1770223720),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6a4b62bced53c8eb9bc292ca1713f3cb', 's:69:\"https://npcbangladesh.org/cache/6a4b62bced53c8eb9bc292ca1713f3cb.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6a53324064830cfb774920db602cf300', 's:69:\"https://npcbangladesh.org/cache/6a53324064830cfb774920db602cf300.webp\";', 1770278364),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6b07468af83d348a11bd601610dc6c39', 's:69:\"https://npcbangladesh.org/cache/6b07468af83d348a11bd601610dc6c39.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6b0e6f13dc5a0fd5643fc506cf3896ad', 's:69:\"https://npcbangladesh.org/cache/6b0e6f13dc5a0fd5643fc506cf3896ad.webp\";', 1770279012),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6b3608a61a5fc0ea4450d20e41ae8bac', 's:69:\"https://npcbangladesh.org/cache/6b3608a61a5fc0ea4450d20e41ae8bac.webp\";', 1770269646),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6d9e1a48bc1f1989deafdc26e7422002', 's:69:\"https://npcbangladesh.org/cache/6d9e1a48bc1f1989deafdc26e7422002.webp\";', 1770467574),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6da2f281ff607dcad64ce30230528ce5', 's:69:\"https://npcbangladesh.org/cache/6da2f281ff607dcad64ce30230528ce5.webp\";', 1770283145),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6da414fe87b4f4c27e0c21d3bf1e7952', 's:69:\"https://npcbangladesh.org/cache/6da414fe87b4f4c27e0c21d3bf1e7952.webp\";', 1770102300),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6e33ca8f80a614a5e4bc467079290243', 's:69:\"https://npcbangladesh.org/cache/6e33ca8f80a614a5e4bc467079290243.webp\";', 1770102131),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6fba50a1fc2871d323a3448b3b5dbb16', 's:69:\"https://npcbangladesh.org/cache/6fba50a1fc2871d323a3448b3b5dbb16.webp\";', 1770358726),
('national-paralympic-committee-of-bangladesh-cache-image_cache_6fca146dc33e1d066bd21066eb4a0d39', 's:69:\"https://npcbangladesh.org/cache/6fca146dc33e1d066bd21066eb4a0d39.webp\";', 1770282858),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7003b4b799f95c5367b30d14bfbf1e42', 's:69:\"https://npcbangladesh.org/cache/7003b4b799f95c5367b30d14bfbf1e42.webp\";', 1770223592),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7022424c86c535186cfc79ee52e46372', 's:69:\"https://npcbangladesh.org/cache/7022424c86c535186cfc79ee52e46372.webp\";', 1770282877),
('national-paralympic-committee-of-bangladesh-cache-image_cache_709b70d2223b9651c9c75e160ec8b8dd', 's:69:\"https://npcbangladesh.org/cache/709b70d2223b9651c9c75e160ec8b8dd.webp\";', 1770287898),
('national-paralympic-committee-of-bangladesh-cache-image_cache_709fd39217875219a19c73b4b7e2f01a', 's:69:\"https://npcbangladesh.org/cache/709fd39217875219a19c73b4b7e2f01a.webp\";', 1770266345),
('national-paralympic-committee-of-bangladesh-cache-image_cache_70f021b3c627812b762e6961b8ae6fc9', 's:69:\"https://npcbangladesh.org/cache/70f021b3c627812b762e6961b8ae6fc9.webp\";', 1770266346),
('national-paralympic-committee-of-bangladesh-cache-image_cache_70fa7defcac17e4ac62ecf799febe5da', 's:69:\"https://npcbangladesh.org/cache/70fa7defcac17e4ac62ecf799febe5da.webp\";', 1770283043),
('national-paralympic-committee-of-bangladesh-cache-image_cache_710484140b2f8c676ed21c96827c8ad8', 's:69:\"https://npcbangladesh.org/cache/710484140b2f8c676ed21c96827c8ad8.webp\";', 1770266236),
('national-paralympic-committee-of-bangladesh-cache-image_cache_716c4d78c729b2cc305a8bfcb4666c85', 's:69:\"https://npcbangladesh.org/cache/716c4d78c729b2cc305a8bfcb4666c85.webp\";', 1770098098),
('national-paralympic-committee-of-bangladesh-cache-image_cache_717b0f878d76e8b290c94023e46fe944', 's:69:\"https://npcbangladesh.org/cache/717b0f878d76e8b290c94023e46fe944.webp\";', 1770283147),
('national-paralympic-committee-of-bangladesh-cache-image_cache_71977890e4eb44d1944f70318f67275e', 's:69:\"https://npcbangladesh.org/cache/71977890e4eb44d1944f70318f67275e.webp\";', 1770102064),
('national-paralympic-committee-of-bangladesh-cache-image_cache_726cead7deef9d45aef6bbfa29052053', 's:69:\"https://npcbangladesh.org/cache/726cead7deef9d45aef6bbfa29052053.webp\";', 1770266239),
('national-paralympic-committee-of-bangladesh-cache-image_cache_72e500006f5e42a0f03a94e7f927b2fa', 's:69:\"https://npcbangladesh.org/cache/72e500006f5e42a0f03a94e7f927b2fa.webp\";', 1770266346),
('national-paralympic-committee-of-bangladesh-cache-image_cache_732f1741d76395a5586280817d572998', 's:69:\"https://npcbangladesh.org/cache/732f1741d76395a5586280817d572998.webp\";', 1770278264),
('national-paralympic-committee-of-bangladesh-cache-image_cache_736162eaa92e76c62ad2b3f6b089d665', 's:69:\"https://npcbangladesh.org/cache/736162eaa92e76c62ad2b3f6b089d665.webp\";', 1770358719),
('national-paralympic-committee-of-bangladesh-cache-image_cache_73859af17b34b610cf5bbbf0b51c615d', 's:69:\"https://npcbangladesh.org/cache/73859af17b34b610cf5bbbf0b51c615d.webp\";', 1770282942),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7386dcc3c2571013203ee977fe0b73cd', 's:69:\"https://npcbangladesh.org/cache/7386dcc3c2571013203ee977fe0b73cd.webp\";', 1770094701),
('national-paralympic-committee-of-bangladesh-cache-image_cache_73b588e05811c58b07410882290c47fb', 's:69:\"https://npcbangladesh.org/cache/73b588e05811c58b07410882290c47fb.webp\";', 1770266227),
('national-paralympic-committee-of-bangladesh-cache-image_cache_748d593ced751227a5ea9a0bcfb80dcd', 's:69:\"https://npcbangladesh.org/cache/748d593ced751227a5ea9a0bcfb80dcd.webp\";', 1770222216),
('national-paralympic-committee-of-bangladesh-cache-image_cache_74a69823f4b82613dd4feec6d7b454b8', 's:69:\"https://npcbangladesh.org/cache/74a69823f4b82613dd4feec6d7b454b8.webp\";', 1770278915),
('national-paralympic-committee-of-bangladesh-cache-image_cache_74de5ef687ab66c9121ceaf9344ce031', 's:69:\"https://npcbangladesh.org/cache/74de5ef687ab66c9121ceaf9344ce031.webp\";', 1770098097),
('national-paralympic-committee-of-bangladesh-cache-image_cache_75672a679990367ab6484c4fe8c7891b', 's:69:\"https://npcbangladesh.org/cache/75672a679990367ab6484c4fe8c7891b.webp\";', 1770266312),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7575a473570ae7e0cd88c09927a80fb8', 's:69:\"https://npcbangladesh.org/cache/7575a473570ae7e0cd88c09927a80fb8.webp\";', 1770358819),
('national-paralympic-committee-of-bangladesh-cache-image_cache_75954a193e237b9a2be023abad677581', 's:69:\"https://npcbangladesh.org/cache/75954a193e237b9a2be023abad677581.webp\";', 1770265818),
('national-paralympic-committee-of-bangladesh-cache-image_cache_75b8477f969087623fe6a38c1a2acbe5', 's:69:\"https://npcbangladesh.org/cache/75b8477f969087623fe6a38c1a2acbe5.webp\";', 1770266339),
('national-paralympic-committee-of-bangladesh-cache-image_cache_75ef05a17b62dcdb6da96e7f261f49cc', 's:69:\"https://npcbangladesh.org/cache/75ef05a17b62dcdb6da96e7f261f49cc.webp\";', 1770704068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_76fdb8a5e842f7075124ffeb321e058b', 's:69:\"https://npcbangladesh.org/cache/76fdb8a5e842f7075124ffeb321e058b.webp\";', 1770266092),
('national-paralympic-committee-of-bangladesh-cache-image_cache_774f32b3e0bc1d4ee11d7fc801ca6c8c', 's:69:\"https://npcbangladesh.org/cache/774f32b3e0bc1d4ee11d7fc801ca6c8c.webp\";', 1770282975),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7756b569e9c1e3fd050680977df2ea83', 's:69:\"https://npcbangladesh.org/cache/7756b569e9c1e3fd050680977df2ea83.webp\";', 1770358733),
('national-paralympic-committee-of-bangladesh-cache-image_cache_777380d61d1a0521015994aa4dcc496a', 's:69:\"https://npcbangladesh.org/cache/777380d61d1a0521015994aa4dcc496a.webp\";', 1770266235),
('national-paralympic-committee-of-bangladesh-cache-image_cache_782e3601ea0e023a05226bd4bf6841da', 's:69:\"https://npcbangladesh.org/cache/782e3601ea0e023a05226bd4bf6841da.webp\";', 1770358776),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7850a090628caab2c00d5f9b41ea6a37', 's:69:\"https://npcbangladesh.org/cache/7850a090628caab2c00d5f9b41ea6a37.webp\";', 1770102021),
('national-paralympic-committee-of-bangladesh-cache-image_cache_789f293af5d2d2afc740327d405890ca', 's:69:\"https://npcbangladesh.org/cache/789f293af5d2d2afc740327d405890ca.webp\";', 1770282968),
('national-paralympic-committee-of-bangladesh-cache-image_cache_795e0110599bee9775da4417bcc71c33', 's:69:\"https://npcbangladesh.org/cache/795e0110599bee9775da4417bcc71c33.webp\";', 1770278492),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7a0215a9e7aa68a1109fcc018aa6ef37', 's:69:\"https://npcbangladesh.org/cache/7a0215a9e7aa68a1109fcc018aa6ef37.webp\";', 1770358704),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7a4eaa8ee03df7e060f5cba3de105cc8', 's:69:\"https://npcbangladesh.org/cache/7a4eaa8ee03df7e060f5cba3de105cc8.webp\";', 1770100741),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7a591312035bbb33dbd3077690199191', 's:69:\"https://npcbangladesh.org/cache/7a591312035bbb33dbd3077690199191.webp\";', 1770101834),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7a7a5fb11c98a2af26d56e13bf6fa34b', 's:69:\"https://npcbangladesh.org/cache/7a7a5fb11c98a2af26d56e13bf6fa34b.webp\";', 1770282969),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7a8291d28e141100c8088a412b37e7ae', 's:69:\"https://npcbangladesh.org/cache/7a8291d28e141100c8088a412b37e7ae.webp\";', 1770266238),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7b557de08702ca5b017b4d6db23380b9', 's:69:\"https://npcbangladesh.org/cache/7b557de08702ca5b017b4d6db23380b9.webp\";', 1770704070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7c1f02c41a99479e8a28db9dd2c0a873', 's:69:\"https://npcbangladesh.org/cache/7c1f02c41a99479e8a28db9dd2c0a873.webp\";', 1770704068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7c27694c2c2903e20e95bd19d7da98ed', 's:69:\"https://npcbangladesh.org/cache/7c27694c2c2903e20e95bd19d7da98ed.webp\";', 1770358824),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7c61ee62b946276aca1603dc4244098a', 's:69:\"https://npcbangladesh.org/cache/7c61ee62b946276aca1603dc4244098a.webp\";', 1770266314),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7c6daa69f5c82d8f3a0aaf27a6cb98ed', 's:69:\"https://npcbangladesh.org/cache/7c6daa69f5c82d8f3a0aaf27a6cb98ed.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7d178a7e1526cf2ba5b41ae564b8246c', 's:69:\"https://npcbangladesh.org/cache/7d178a7e1526cf2ba5b41ae564b8246c.webp\";', 1770101801),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7d56b0140bfd48bcbfe8a18dcab99d81', 's:69:\"https://npcbangladesh.org/cache/7d56b0140bfd48bcbfe8a18dcab99d81.webp\";', 1770282889),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7da5ce80ced47c1ccdfdd14a73ded0f6', 's:69:\"https://npcbangladesh.org/cache/7da5ce80ced47c1ccdfdd14a73ded0f6.webp\";', 1770468053),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7e42e216c2158791166fe74605e052a1', 's:69:\"https://npcbangladesh.org/cache/7e42e216c2158791166fe74605e052a1.webp\";', 1770282968),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7e466807963eeabe82c16b8c0b67c4b9', 's:69:\"https://npcbangladesh.org/cache/7e466807963eeabe82c16b8c0b67c4b9.webp\";', 1770094643),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7e66117e69f668047cd5d316ba197911', 's:69:\"https://npcbangladesh.org/cache/7e66117e69f668047cd5d316ba197911.webp\";', 1770265817),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7eb943dc02cf1e34476e8f75c7c1079c', 's:69:\"https://npcbangladesh.org/cache/7eb943dc02cf1e34476e8f75c7c1079c.webp\";', 1770266347),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7f8338784f9e73d7d8ac754b04d232c8', 's:69:\"https://npcbangladesh.org/cache/7f8338784f9e73d7d8ac754b04d232c8.webp\";', 1770282961),
('national-paralympic-committee-of-bangladesh-cache-image_cache_7fc3325cca16c0010f09ced832e00bff', 's:69:\"https://npcbangladesh.org/cache/7fc3325cca16c0010f09ced832e00bff.webp\";', 1770283071),
('national-paralympic-committee-of-bangladesh-cache-image_cache_805441b64afd817403e5f16f34faf289', 's:69:\"https://npcbangladesh.org/cache/805441b64afd817403e5f16f34faf289.webp\";', 1770358727),
('national-paralympic-committee-of-bangladesh-cache-image_cache_813f07a33817397ecfb2bfb4af18a8ba', 's:69:\"https://npcbangladesh.org/cache/813f07a33817397ecfb2bfb4af18a8ba.webp\";', 1770358734),
('national-paralympic-committee-of-bangladesh-cache-image_cache_81bc7f6a027c4bc97fb1669ed9d72ece', 's:69:\"https://npcbangladesh.org/cache/81bc7f6a027c4bc97fb1669ed9d72ece.webp\";', 1770266092),
('national-paralympic-committee-of-bangladesh-cache-image_cache_81c3ef4cd29f950d074062560c48ea70', 's:69:\"https://npcbangladesh.org/cache/81c3ef4cd29f950d074062560c48ea70.webp\";', 1770266338),
('national-paralympic-committee-of-bangladesh-cache-image_cache_82c940791e0d38ada3674c56449d485c', 's:69:\"https://npcbangladesh.org/cache/82c940791e0d38ada3674c56449d485c.webp\";', 1770704069),
('national-paralympic-committee-of-bangladesh-cache-image_cache_82ca0bed251ef267207debbe6c5fab6c', 's:69:\"https://npcbangladesh.org/cache/82ca0bed251ef267207debbe6c5fab6c.webp\";', 1770468053),
('national-paralympic-committee-of-bangladesh-cache-image_cache_83360748162c04074431d503b77bacb0', 's:69:\"https://npcbangladesh.org/cache/83360748162c04074431d503b77bacb0.webp\";', 1770358782),
('national-paralympic-committee-of-bangladesh-cache-image_cache_835cdc8886eafbf171e5cbe2d9c07627', 's:69:\"https://npcbangladesh.org/cache/835cdc8886eafbf171e5cbe2d9c07627.webp\";', 1770358773),
('national-paralympic-committee-of-bangladesh-cache-image_cache_84031096dc5c1cb3520ddc818bf34b78', 's:69:\"https://npcbangladesh.org/cache/84031096dc5c1cb3520ddc818bf34b78.webp\";', 1770358831),
('national-paralympic-committee-of-bangladesh-cache-image_cache_841a863a0512f86f680163e846db0d1b', 's:69:\"https://npcbangladesh.org/cache/841a863a0512f86f680163e846db0d1b.webp\";', 1770358714),
('national-paralympic-committee-of-bangladesh-cache-image_cache_844d16850895117d0386317523ba5fa3', 's:69:\"https://npcbangladesh.org/cache/844d16850895117d0386317523ba5fa3.webp\";', 1770278236),
('national-paralympic-committee-of-bangladesh-cache-image_cache_867d0ef4b33d9a7afe0f0a7ccd865458', 's:69:\"https://npcbangladesh.org/cache/867d0ef4b33d9a7afe0f0a7ccd865458.webp\";', 1770266325),
('national-paralympic-committee-of-bangladesh-cache-image_cache_879049ca509fac31787f6f455a6c48c3', 's:69:\"https://npcbangladesh.org/cache/879049ca509fac31787f6f455a6c48c3.webp\";', 1770358827),
('national-paralympic-committee-of-bangladesh-cache-image_cache_87c062f9ae131b915300bf6081894791', 's:69:\"https://npcbangladesh.org/cache/87c062f9ae131b915300bf6081894791.webp\";', 1770279083),
('national-paralympic-committee-of-bangladesh-cache-image_cache_87ccee486f2380823bbebf874c56ce4b', 's:69:\"https://npcbangladesh.org/cache/87ccee486f2380823bbebf874c56ce4b.webp\";', 1770266323),
('national-paralympic-committee-of-bangladesh-cache-image_cache_87e063f60e340871e26f51a5b3eecaa3', 's:69:\"https://npcbangladesh.org/cache/87e063f60e340871e26f51a5b3eecaa3.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_887287a0d39553c872099dfb695e3bc8', 's:69:\"https://npcbangladesh.org/cache/887287a0d39553c872099dfb695e3bc8.webp\";', 1770279068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_88a15c7f762262d0e450ea8cca5bb3da', 's:69:\"https://npcbangladesh.org/cache/88a15c7f762262d0e450ea8cca5bb3da.webp\";', 1770358739),
('national-paralympic-committee-of-bangladesh-cache-image_cache_88a2bbaea91023904a65e9a6ed2aab8b', 's:69:\"https://npcbangladesh.org/cache/88a2bbaea91023904a65e9a6ed2aab8b.webp\";', 1770223720),
('national-paralympic-committee-of-bangladesh-cache-image_cache_890d986f5b32cf47f01f54abeee5eb7c', 's:69:\"https://npcbangladesh.org/cache/890d986f5b32cf47f01f54abeee5eb7c.webp\";', 1770265820),
('national-paralympic-committee-of-bangladesh-cache-image_cache_891e2eeb8380154ffce58713364a5b0c', 's:69:\"https://npcbangladesh.org/cache/891e2eeb8380154ffce58713364a5b0c.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_894ab88838e20536e27d18bffa52aa1a', 's:69:\"https://npcbangladesh.org/cache/894ab88838e20536e27d18bffa52aa1a.webp\";', 1770282983),
('national-paralympic-committee-of-bangladesh-cache-image_cache_89a2f7e45e739757dfae95937c28b5fd', 's:69:\"https://npcbangladesh.org/cache/89a2f7e45e739757dfae95937c28b5fd.webp\";', 1770102131),
('national-paralympic-committee-of-bangladesh-cache-image_cache_89c20a02338b37fae66fcc81e42a563c', 's:69:\"https://npcbangladesh.org/cache/89c20a02338b37fae66fcc81e42a563c.webp\";', 1770266319),
('national-paralympic-committee-of-bangladesh-cache-image_cache_89f04f8e610c08ea94c8edeb7b7c1840', 's:69:\"https://npcbangladesh.org/cache/89f04f8e610c08ea94c8edeb7b7c1840.webp\";', 1770282890),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8a50b3c718c67cd9801e300be75915bf', 's:69:\"https://npcbangladesh.org/cache/8a50b3c718c67cd9801e300be75915bf.webp\";', 1770358809),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8a57cafc8cf735e202993c4633c69f1f', 's:69:\"https://npcbangladesh.org/cache/8a57cafc8cf735e202993c4633c69f1f.webp\";', 1770358736),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8a65831028b44d65a9bb0338c105a7bf', 's:69:\"https://npcbangladesh.org/cache/8a65831028b44d65a9bb0338c105a7bf.webp\";', 1770282978),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8a7d69553f1d5da108233c04052e343b', 's:69:\"https://npcbangladesh.org/cache/8a7d69553f1d5da108233c04052e343b.webp\";', 1770358774),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8abe6e4575289e6133dba0480db8f42a', 's:69:\"https://npcbangladesh.org/cache/8abe6e4575289e6133dba0480db8f42a.webp\";', 1770222216),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8ad35c7a184fcfe089a5da8c4a8f7d11', 's:69:\"https://npcbangladesh.org/cache/8ad35c7a184fcfe089a5da8c4a8f7d11.webp\";', 1770222217),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8aee322ed3d3b41679c105dab33c5fe5', 's:69:\"https://npcbangladesh.org/cache/8aee322ed3d3b41679c105dab33c5fe5.webp\";', 1770358752),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8b3205d6253ae91a967f784a315bafcd', 's:69:\"https://npcbangladesh.org/cache/8b3205d6253ae91a967f784a315bafcd.webp\";', 1770266231),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8b51c0cddb051e316adb29f1ee78fb21', 's:69:\"https://npcbangladesh.org/cache/8b51c0cddb051e316adb29f1ee78fb21.webp\";', 1770283069),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8b7a8bddc4b3bdb420b9676f245f6df7', 's:69:\"https://npcbangladesh.org/cache/8b7a8bddc4b3bdb420b9676f245f6df7.webp\";', 1770098098),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8c56061e7bc3fa36eeb7ee62baa3a442', 's:69:\"https://npcbangladesh.org/cache/8c56061e7bc3fa36eeb7ee62baa3a442.webp\";', 1770358736),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8cbe5ffa0d2648ce8c44b730c21a60d7', 's:69:\"https://npcbangladesh.org/cache/8cbe5ffa0d2648ce8c44b730c21a60d7.webp\";', 1770358748),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8cc7b3a52f48bf3bcf90817f17fe8eaa', 's:69:\"https://npcbangladesh.org/cache/8cc7b3a52f48bf3bcf90817f17fe8eaa.webp\";', 1770282944),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8d4bedb0920631123d8ac7d44de03dd8', 's:69:\"https://npcbangladesh.org/cache/8d4bedb0920631123d8ac7d44de03dd8.webp\";', 1770358771),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8e46be4a2e6c7b0aad31904a24213800', 's:69:\"https://npcbangladesh.org/cache/8e46be4a2e6c7b0aad31904a24213800.webp\";', 1770283043),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8e9f24051c16b3da37367dc66ce468bf', 's:69:\"https://npcbangladesh.org/cache/8e9f24051c16b3da37367dc66ce468bf.webp\";', 1770283065),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8ee347cdd9762f79a9bfbce3bd77373c', 's:69:\"https://npcbangladesh.org/cache/8ee347cdd9762f79a9bfbce3bd77373c.webp\";', 1770266329),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8f020d50f3d197a670e120450458dc5b', 's:69:\"https://npcbangladesh.org/cache/8f020d50f3d197a670e120450458dc5b.webp\";', 1770283147),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8f839dec0e16510a033a706689121557', 's:69:\"https://npcbangladesh.org/cache/8f839dec0e16510a033a706689121557.webp\";', 1770094747),
('national-paralympic-committee-of-bangladesh-cache-image_cache_8fba5558cc10a791448c2e58cbb3b79b', 's:69:\"https://npcbangladesh.org/cache/8fba5558cc10a791448c2e58cbb3b79b.webp\";', 1770266092),
('national-paralympic-committee-of-bangladesh-cache-image_cache_90d18dd81f0296cd8be12ee58d9a55c2', 's:69:\"https://npcbangladesh.org/cache/90d18dd81f0296cd8be12ee58d9a55c2.webp\";', 1770283044),
('national-paralympic-committee-of-bangladesh-cache-image_cache_91b52bfbbbd93b82adfc22e32562e4e8', 's:69:\"https://npcbangladesh.org/cache/91b52bfbbbd93b82adfc22e32562e4e8.webp\";', 1770282958),
('national-paralympic-committee-of-bangladesh-cache-image_cache_922d5c56f9f0a9faa72a438bb876ddfd', 's:69:\"https://npcbangladesh.org/cache/922d5c56f9f0a9faa72a438bb876ddfd.webp\";', 1770266241),
('national-paralympic-committee-of-bangladesh-cache-image_cache_925fc06c348c42768e5e0c3567b96cbe', 's:69:\"https://npcbangladesh.org/cache/925fc06c348c42768e5e0c3567b96cbe.webp\";', 1770358760),
('national-paralympic-committee-of-bangladesh-cache-image_cache_926a7137c70900da7575da1baa2733cb', 's:69:\"https://npcbangladesh.org/cache/926a7137c70900da7575da1baa2733cb.webp\";', 1770358781),
('national-paralympic-committee-of-bangladesh-cache-image_cache_928555e8542c404dbe57c563c59d3831', 's:69:\"https://npcbangladesh.org/cache/928555e8542c404dbe57c563c59d3831.webp\";', 1770278275),
('national-paralympic-committee-of-bangladesh-cache-image_cache_928e4ee56d2146a722713ee48772e042', 's:69:\"https://npcbangladesh.org/cache/928e4ee56d2146a722713ee48772e042.webp\";', 1770358753),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9406faae08ccc77f5002e12aa1d4ea1e', 's:69:\"https://npcbangladesh.org/cache/9406faae08ccc77f5002e12aa1d4ea1e.webp\";', 1770266229),
('national-paralympic-committee-of-bangladesh-cache-image_cache_945a206db3f8748ab6f4cd30461ff7ae', 's:69:\"https://npcbangladesh.org/cache/945a206db3f8748ab6f4cd30461ff7ae.webp\";', 1770358775),
('national-paralympic-committee-of-bangladesh-cache-image_cache_94dfc3f55f9495e3fa4d671e02085629', 's:69:\"https://npcbangladesh.org/cache/94dfc3f55f9495e3fa4d671e02085629.webp\";', 1770266230),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9529ab945ae1e3c506e58491a5739eda', 's:69:\"https://npcbangladesh.org/cache/9529ab945ae1e3c506e58491a5739eda.webp\";', 1770266345),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9534849334f66dd7b93ff7342190defe', 's:69:\"https://npcbangladesh.org/cache/9534849334f66dd7b93ff7342190defe.webp\";', 1770102130),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9553c43a8b301cdc0dbf7f0a04ca7286', 's:69:\"https://npcbangladesh.org/cache/9553c43a8b301cdc0dbf7f0a04ca7286.webp\";', 1770266235),
('national-paralympic-committee-of-bangladesh-cache-image_cache_960f29ad0ca7dc3c596a2fa5dafabc14', 's:69:\"https://npcbangladesh.org/cache/960f29ad0ca7dc3c596a2fa5dafabc14.webp\";', 1770112207),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9635974b10b49d457fb3fd69df999bae', 's:69:\"https://npcbangladesh.org/cache/9635974b10b49d457fb3fd69df999bae.webp\";', 1770283154),
('national-paralympic-committee-of-bangladesh-cache-image_cache_968e3eaf2f46ad2a4b217ffd858b98f3', 's:69:\"https://npcbangladesh.org/cache/968e3eaf2f46ad2a4b217ffd858b98f3.webp\";', 1770282944),
('national-paralympic-committee-of-bangladesh-cache-image_cache_96c92f7720c662a01771a3050244f5c3', 's:69:\"https://npcbangladesh.org/cache/96c92f7720c662a01771a3050244f5c3.webp\";', 1770358740),
('national-paralympic-committee-of-bangladesh-cache-image_cache_96d2f9c0db68c60b5df3266bcbef5e4e', 's:69:\"https://npcbangladesh.org/cache/96d2f9c0db68c60b5df3266bcbef5e4e.webp\";', 1770094702),
('national-paralympic-committee-of-bangladesh-cache-image_cache_971252c60ece1fa7d0f5b3cb8033fbff', 's:69:\"https://npcbangladesh.org/cache/971252c60ece1fa7d0f5b3cb8033fbff.webp\";', 1770266239),
('national-paralympic-committee-of-bangladesh-cache-image_cache_981a732f2a988eb3b7ed75cc9b37b8e0', 's:69:\"https://npcbangladesh.org/cache/981a732f2a988eb3b7ed75cc9b37b8e0.webp\";', 1770704070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_984aab9d1bba29dc1076b1335c43f579', 's:69:\"https://npcbangladesh.org/cache/984aab9d1bba29dc1076b1335c43f579.webp\";', 1770358767),
('national-paralympic-committee-of-bangladesh-cache-image_cache_98500c9fe04bb4ec4307231c08d22173', 's:69:\"https://npcbangladesh.org/cache/98500c9fe04bb4ec4307231c08d22173.webp\";', 1770266299),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9857f924d92fa0bc7afde407ebe69dc6', 's:69:\"https://npcbangladesh.org/cache/9857f924d92fa0bc7afde407ebe69dc6.webp\";', 1770282978),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9892b1cc447574c357e3fbe2c28ce6ef', 's:69:\"https://npcbangladesh.org/cache/9892b1cc447574c357e3fbe2c28ce6ef.webp\";', 1770282982),
('national-paralympic-committee-of-bangladesh-cache-image_cache_98aea5ea6fdb1de81fc1076ec48612dd', 's:69:\"https://npcbangladesh.org/cache/98aea5ea6fdb1de81fc1076ec48612dd.webp\";', 1770094748),
('national-paralympic-committee-of-bangladesh-cache-image_cache_98f415285cda5b3d4c9a1b2a68c25eff', 's:69:\"https://npcbangladesh.org/cache/98f415285cda5b3d4c9a1b2a68c25eff.webp\";', 1770278910),
('national-paralympic-committee-of-bangladesh-cache-image_cache_991b4a14c34bf177ef612ee669447b99', 's:69:\"https://npcbangladesh.org/cache/991b4a14c34bf177ef612ee669447b99.webp\";', 1770283065),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9a9255160eb05766de93b4d681fe8e0b', 's:69:\"https://npcbangladesh.org/cache/9a9255160eb05766de93b4d681fe8e0b.webp\";', 1770704068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9ad51e72e7a98a48cefab7917020e290', 's:69:\"https://npcbangladesh.org/cache/9ad51e72e7a98a48cefab7917020e290.webp\";', 1770282982),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9b1b057da87d92fd7967e031d43bb683', 's:69:\"https://npcbangladesh.org/cache/9b1b057da87d92fd7967e031d43bb683.webp\";', 1770282961),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9b631a09a3a5c9e7982998d5130c2a99', 's:69:\"https://npcbangladesh.org/cache/9b631a09a3a5c9e7982998d5130c2a99.webp\";', 1770358744),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9c2b6cf54d34ffd2ac108200df6182ea', 's:69:\"https://npcbangladesh.org/cache/9c2b6cf54d34ffd2ac108200df6182ea.webp\";', 1770358814),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9c97b802ab805dc7c4e47a810bbe5b08', 's:69:\"https://npcbangladesh.org/cache/9c97b802ab805dc7c4e47a810bbe5b08.webp\";', 1770282889),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9ca5ac1f0552e4483b65d4e0a71a8805', 's:69:\"https://npcbangladesh.org/cache/9ca5ac1f0552e4483b65d4e0a71a8805.webp\";', 1770282859),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9ca9f476d3b49df736f73dc01ca79b6d', 's:69:\"https://npcbangladesh.org/cache/9ca9f476d3b49df736f73dc01ca79b6d.webp\";', 1770265822),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9caa3c2ce16a465cdf70931be382f944', 's:69:\"https://npcbangladesh.org/cache/9caa3c2ce16a465cdf70931be382f944.webp\";', 1770266319),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9d5e869331cca842855137ac5a141cdb', 's:69:\"https://npcbangladesh.org/cache/9d5e869331cca842855137ac5a141cdb.webp\";', 1770278275),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9e07b8bc2dcf908eb97941704a7b68c4', 's:69:\"https://npcbangladesh.org/cache/9e07b8bc2dcf908eb97941704a7b68c4.webp\";', 1770185328),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9ecfd3d500b472e8f54ffee6b04a443e', 's:69:\"https://npcbangladesh.org/cache/9ecfd3d500b472e8f54ffee6b04a443e.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9ef522577a929b60f96909a710aaba3b', 's:69:\"https://npcbangladesh.org/cache/9ef522577a929b60f96909a710aaba3b.webp\";', 1770102264),
('national-paralympic-committee-of-bangladesh-cache-image_cache_9fc5dd7e221a509e59eca61d801bdd1f', 's:69:\"https://npcbangladesh.org/cache/9fc5dd7e221a509e59eca61d801bdd1f.webp\";', 1770265725),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a010fea53e915359ac215927281f6ffc', 's:69:\"https://npcbangladesh.org/cache/a010fea53e915359ac215927281f6ffc.webp\";', 1770358725),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a0b1a4549e24ab5b2191fe5f1ec0aa03', 's:69:\"https://npcbangladesh.org/cache/a0b1a4549e24ab5b2191fe5f1ec0aa03.webp\";', 1770102507),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a19f2b71407ddcc56724609bb838fdfd', 's:69:\"https://npcbangladesh.org/cache/a19f2b71407ddcc56724609bb838fdfd.webp\";', 1770283139),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a2c0be609c270a2b4f341108b6d697f7', 's:69:\"https://npcbangladesh.org/cache/a2c0be609c270a2b4f341108b6d697f7.webp\";', 1770358717),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a2e872a870af3d96b12c9aa4b5bce7b3', 's:69:\"https://npcbangladesh.org/cache/a2e872a870af3d96b12c9aa4b5bce7b3.webp\";', 1770282982),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a3bd3af27c1ba898c959270c31cab284', 's:69:\"https://npcbangladesh.org/cache/a3bd3af27c1ba898c959270c31cab284.webp\";', 1770266238),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a4e8764e6023300c973d702dec7c49fd', 's:69:\"https://npcbangladesh.org/cache/a4e8764e6023300c973d702dec7c49fd.webp\";', 1770358707),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a54b03cd9182a148bbd904aa7fdfb86a', 's:69:\"https://npcbangladesh.org/cache/a54b03cd9182a148bbd904aa7fdfb86a.webp\";', 1770283064),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a6a9c7c7dfdfafd5db7be7d33d68df8d', 's:69:\"https://npcbangladesh.org/cache/a6a9c7c7dfdfafd5db7be7d33d68df8d.webp\";', 1770266344),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a6b4cf01e4d07b91cfa8489d44ad4fc8', 's:69:\"https://npcbangladesh.org/cache/a6b4cf01e4d07b91cfa8489d44ad4fc8.webp\";', 1770282779),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a6c8003af5e2b1b8baa54e35f68b5a2e', 's:69:\"https://npcbangladesh.org/cache/a6c8003af5e2b1b8baa54e35f68b5a2e.webp\";', 1770282856),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a6cce3d1c8f86785fae2695ae517fdf6', 's:69:\"https://npcbangladesh.org/cache/a6cce3d1c8f86785fae2695ae517fdf6.webp\";', 1770358718),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a6e6980636013699a34cf6320435cdb9', 's:69:\"https://npcbangladesh.org/cache/a6e6980636013699a34cf6320435cdb9.webp\";', 1770102131),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a6f4b71ec8e29b52107a25346e312dad', 's:69:\"https://npcbangladesh.org/cache/a6f4b71ec8e29b52107a25346e312dad.webp\";', 1770358741),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a778eadb9136b017f5fc9e87911cc6fb', 's:69:\"https://npcbangladesh.org/cache/a778eadb9136b017f5fc9e87911cc6fb.webp\";', 1770102151),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a79fedb9d69cfb19047211e409e7a68f', 's:69:\"https://npcbangladesh.org/cache/a79fedb9d69cfb19047211e409e7a68f.webp\";', 1770283142),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a8220d7d6f74c5acd9da58d8aab91f28', 's:69:\"https://npcbangladesh.org/cache/a8220d7d6f74c5acd9da58d8aab91f28.webp\";', 1770265725),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a8a4bed3ece8aee036da0259b411a48c', 's:69:\"https://npcbangladesh.org/cache/a8a4bed3ece8aee036da0259b411a48c.webp\";', 1770358818),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a8ec345cc77f8d31e07cd6c630db2214', 's:69:\"https://npcbangladesh.org/cache/a8ec345cc77f8d31e07cd6c630db2214.webp\";', 1770358746),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a90648d3d308126aa5322bdcd1249723', 's:69:\"https://npcbangladesh.org/cache/a90648d3d308126aa5322bdcd1249723.webp\";', 1770102733),
('national-paralympic-committee-of-bangladesh-cache-image_cache_a98443a65fead98646f91fe0b22d151a', 's:69:\"https://npcbangladesh.org/cache/a98443a65fead98646f91fe0b22d151a.webp\";', 1770282968),
('national-paralympic-committee-of-bangladesh-cache-image_cache_aa1000157b01b92a2ec64f16b0faff4b', 's:69:\"https://npcbangladesh.org/cache/aa1000157b01b92a2ec64f16b0faff4b.webp\";', 1770358828),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ab1b0f0aa4734955db03529a58a9cf28', 's:69:\"https://npcbangladesh.org/cache/ab1b0f0aa4734955db03529a58a9cf28.webp\";', 1770358835),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ab1e82130d03186dc9ef6ecfe3531d1b', 's:69:\"https://npcbangladesh.org/cache/ab1e82130d03186dc9ef6ecfe3531d1b.webp\";', 1770265818),
('national-paralympic-committee-of-bangladesh-cache-image_cache_abe0695dceeac7c666c717daa5d1bab5', 's:69:\"https://npcbangladesh.org/cache/abe0695dceeac7c666c717daa5d1bab5.webp\";', 1770358811),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ac45f97b0c097528df2e5de87a3f2f6e', 's:69:\"https://npcbangladesh.org/cache/ac45f97b0c097528df2e5de87a3f2f6e.webp\";', 1770278236),
('national-paralympic-committee-of-bangladesh-cache-image_cache_acb8a56d513801801486456ae9255900', 's:69:\"https://npcbangladesh.org/cache/acb8a56d513801801486456ae9255900.webp\";', 1770358761),
('national-paralympic-committee-of-bangladesh-cache-image_cache_acd9ed3c044f5cff99846ba9182a1fce', 's:69:\"https://npcbangladesh.org/cache/acd9ed3c044f5cff99846ba9182a1fce.webp\";', 1770266099),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ad37378578dbc25651415750b0b07f08', 's:69:\"https://npcbangladesh.org/cache/ad37378578dbc25651415750b0b07f08.webp\";', 1770100740),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ad795373f5e524bf37361a43b7b807d9', 's:69:\"https://npcbangladesh.org/cache/ad795373f5e524bf37361a43b7b807d9.webp\";', 1770358720),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ad7ea4ba78f60c5a18f5c640d670d31a', 's:69:\"https://npcbangladesh.org/cache/ad7ea4ba78f60c5a18f5c640d670d31a.webp\";', 1770278839),
('national-paralympic-committee-of-bangladesh-cache-image_cache_adfcecc502dcadf900a63fded08ca9d4', 's:69:\"https://npcbangladesh.org/cache/adfcecc502dcadf900a63fded08ca9d4.webp\";', 1770358719),
('national-paralympic-committee-of-bangladesh-cache-image_cache_aec0335b70a7332db0ff41b038675ffc', 's:69:\"https://npcbangladesh.org/cache/aec0335b70a7332db0ff41b038675ffc.webp\";', 1770358728),
('national-paralympic-committee-of-bangladesh-cache-image_cache_aedf062bfc8eab99cfbaa926c7ae0b9d', 's:69:\"https://npcbangladesh.org/cache/aedf062bfc8eab99cfbaa926c7ae0b9d.webp\";', 1770283071),
('national-paralympic-committee-of-bangladesh-cache-image_cache_af6c1ed30b5e091f0c8b5b381d394e8d', 's:69:\"https://npcbangladesh.org/cache/af6c1ed30b5e091f0c8b5b381d394e8d.webp\";', 1770094701),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b02f145e7198a7db62c6e41633eda636', 's:69:\"https://npcbangladesh.org/cache/b02f145e7198a7db62c6e41633eda636.webp\";', 1770282944),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b034ea8c0a6d68bedd416e1e5ff8a497', 's:69:\"https://npcbangladesh.org/cache/b034ea8c0a6d68bedd416e1e5ff8a497.webp\";', 1770358757),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b0a3c948a0b6ed9d5dc073319e8250cb', 's:69:\"https://npcbangladesh.org/cache/b0a3c948a0b6ed9d5dc073319e8250cb.webp\";', 1770358703),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b0cbe5610f1c3514a1a8813c9c192cdf', 's:69:\"https://npcbangladesh.org/cache/b0cbe5610f1c3514a1a8813c9c192cdf.webp\";', 1770288536),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b1ed5ca711ff85b7658842f44ef6b882', 's:69:\"https://npcbangladesh.org/cache/b1ed5ca711ff85b7658842f44ef6b882.webp\";', 1770704069),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b22dc2f1a4ed2f3b86dd58618348c4f6', 's:69:\"https://npcbangladesh.org/cache/b22dc2f1a4ed2f3b86dd58618348c4f6.webp\";', 1770282875),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b238c6c346a7f9524ac5f6ccd980ba14', 's:69:\"https://npcbangladesh.org/cache/b238c6c346a7f9524ac5f6ccd980ba14.webp\";', 1770278332),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b27ad584c7372a4cbb565afe9092542d', 's:69:\"https://npcbangladesh.org/cache/b27ad584c7372a4cbb565afe9092542d.webp\";', 1770101834),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b28a3498e07da74c07afabf1f52dcc4c', 's:69:\"https://npcbangladesh.org/cache/b28a3498e07da74c07afabf1f52dcc4c.webp\";', 1770358715),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b3c2cdc96b1ea237c9f9c5c057d360ff', 's:69:\"https://npcbangladesh.org/cache/b3c2cdc96b1ea237c9f9c5c057d360ff.webp\";', 1770283059),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b3ed4a87b53f76ee5f9cd96a72682fbb', 's:69:\"https://npcbangladesh.org/cache/b3ed4a87b53f76ee5f9cd96a72682fbb.webp\";', 1770266232),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b404679c93b4c6c55059cdc709ef7f31', 's:69:\"https://npcbangladesh.org/cache/b404679c93b4c6c55059cdc709ef7f31.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b43058c750ec7bf320618b066e6f09b4', 's:69:\"https://npcbangladesh.org/cache/b43058c750ec7bf320618b066e6f09b4.webp\";', 1770358811),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b48c93df04624695d3e1127985423925', 's:69:\"https://npcbangladesh.org/cache/b48c93df04624695d3e1127985423925.webp\";', 1770283060),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b4be9f794c3cdda3466de3f64ba7c240', 's:69:\"https://npcbangladesh.org/cache/b4be9f794c3cdda3466de3f64ba7c240.webp\";', 1770283070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b4c478808dc937249d4a32ca332517eb', 's:69:\"https://npcbangladesh.org/cache/b4c478808dc937249d4a32ca332517eb.webp\";', 1770283066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b541077bfe35d0bd526e2484899034f5', 's:69:\"https://npcbangladesh.org/cache/b541077bfe35d0bd526e2484899034f5.webp\";', 1770358759),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b572d4c91a66552f979de76f073c8883', 's:69:\"https://npcbangladesh.org/cache/b572d4c91a66552f979de76f073c8883.webp\";', 1770283065),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b5fb787668474e8dc019669c583001bd', 's:69:\"https://npcbangladesh.org/cache/b5fb787668474e8dc019669c583001bd.webp\";', 1770266342),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b61b9c523d82e50cded4dea4ddaf1ef4', 's:68:\"https://npcbangladesh.org/cache/b61b9c523d82e50cded4dea4ddaf1ef4.png\";', 1770278364),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b6e893a72b662f44db1c4bf4e4aeaf6f', 's:69:\"https://npcbangladesh.org/cache/b6e893a72b662f44db1c4bf4e4aeaf6f.webp\";', 1770358821),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b78a0198a494e185f9abe25a233c50cb', 's:69:\"https://npcbangladesh.org/cache/b78a0198a494e185f9abe25a233c50cb.webp\";', 1770265818),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b7c3de6d38e56850841c746e34d74f37', 's:69:\"https://npcbangladesh.org/cache/b7c3de6d38e56850841c746e34d74f37.webp\";', 1770265671),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b7e1bced5a377fb9abe366e1fc2d618b', 's:69:\"https://npcbangladesh.org/cache/b7e1bced5a377fb9abe366e1fc2d618b.webp\";', 1770358766),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b9740e9e241a7b945f7b3a146d723bb1', 's:69:\"https://npcbangladesh.org/cache/b9740e9e241a7b945f7b3a146d723bb1.webp\";', 1770283147),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b97bd7c96e7ac8183fbcf9ab38eceb94', 's:69:\"https://npcbangladesh.org/cache/b97bd7c96e7ac8183fbcf9ab38eceb94.webp\";', 1770265819),
('national-paralympic-committee-of-bangladesh-cache-image_cache_b9b6ca2b3c3890324fc14261abe888fd', 's:69:\"https://npcbangladesh.org/cache/b9b6ca2b3c3890324fc14261abe888fd.webp\";', 1770266241),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ba27aaf1a8b4c9f9f4cbfef18b929ae7', 's:69:\"https://npcbangladesh.org/cache/ba27aaf1a8b4c9f9f4cbfef18b929ae7.webp\";', 1770266230),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ba49820c6fbebcba6baaa675e4263c31', 's:69:\"https://npcbangladesh.org/cache/ba49820c6fbebcba6baaa675e4263c31.webp\";', 1770704066),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bacccd657f77d225785c9a7b5f066849', 's:69:\"https://npcbangladesh.org/cache/bacccd657f77d225785c9a7b5f066849.webp\";', 1770266297),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bb0a9dc2bbbe56b1fa5c077277bca93e', 's:69:\"https://npcbangladesh.org/cache/bb0a9dc2bbbe56b1fa5c077277bca93e.webp\";', 1770101804);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('national-paralympic-committee-of-bangladesh-cache-image_cache_bb3259909539d48b3b969a59c8e6c21d', 's:69:\"https://npcbangladesh.org/cache/bb3259909539d48b3b969a59c8e6c21d.webp\";', 1770282977),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bb3c6af4b7f87bc0ae31f6b0c619db98', 's:69:\"https://npcbangladesh.org/cache/bb3c6af4b7f87bc0ae31f6b0c619db98.webp\";', 1770283044),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bbf08b78899c34ee473e5f5eec981496', 's:69:\"https://npcbangladesh.org/cache/bbf08b78899c34ee473e5f5eec981496.webp\";', 1770266342),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bcb2a343d476c35c4df33465bdc47d46', 's:69:\"https://npcbangladesh.org/cache/bcb2a343d476c35c4df33465bdc47d46.webp\";', 1770266304),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bce0dc154a3eb5800a7d1f45e28f05ae', 's:69:\"https://npcbangladesh.org/cache/bce0dc154a3eb5800a7d1f45e28f05ae.webp\";', 1770283060),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bd4137a551f1352a500d34395e93be90', 's:69:\"https://npcbangladesh.org/cache/bd4137a551f1352a500d34395e93be90.webp\";', 1770358825),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bd44b10c35ea6edecb77372af7e38eee', 's:69:\"https://npcbangladesh.org/cache/bd44b10c35ea6edecb77372af7e38eee.webp\";', 1770358773),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bdb5ce4d8e6452d8dd74ce7d704946ea', 's:69:\"https://npcbangladesh.org/cache/bdb5ce4d8e6452d8dd74ce7d704946ea.webp\";', 1770222217),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bea505ff6ef1f4bd9f0b8a105113e95e', 's:69:\"https://npcbangladesh.org/cache/bea505ff6ef1f4bd9f0b8a105113e95e.webp\";', 1770102508),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bed2c68e533a5da618603a9fdcc4f69a', 's:69:\"https://npcbangladesh.org/cache/bed2c68e533a5da618603a9fdcc4f69a.webp\";', 1770237535),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bf327da91a116594403eedcbf30c72b5', 's:69:\"https://npcbangladesh.org/cache/bf327da91a116594403eedcbf30c72b5.webp\";', 1770283142),
('national-paralympic-committee-of-bangladesh-cache-image_cache_bf74ac479554ff76467faf14dc317c78', 's:69:\"https://npcbangladesh.org/cache/bf74ac479554ff76467faf14dc317c78.webp\";', 1770266092),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c0f67ead9c9e6abdd25d10f1df906a88', 's:69:\"https://npcbangladesh.org/cache/c0f67ead9c9e6abdd25d10f1df906a88.webp\";', 1770279012),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c133912445a90286e5c26cec6eea4e08', 's:69:\"https://npcbangladesh.org/cache/c133912445a90286e5c26cec6eea4e08.webp\";', 1770266235),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c13f59506fa7b549c0ba1d626ae1d95e', 's:69:\"https://npcbangladesh.org/cache/c13f59506fa7b549c0ba1d626ae1d95e.webp\";', 1770283065),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c1527692ce02867e8723c232b8aecc1a', 's:69:\"https://npcbangladesh.org/cache/c1527692ce02867e8723c232b8aecc1a.webp\";', 1770266241),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c2710eaca59e248f0290a539430398e2', 's:69:\"https://npcbangladesh.org/cache/c2710eaca59e248f0290a539430398e2.webp\";', 1770288348),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c2a65874ac8811d1deb1de66ab38aab9', 's:69:\"https://npcbangladesh.org/cache/c2a65874ac8811d1deb1de66ab38aab9.webp\";', 1770278492),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c2d49e9c288b961b77ece2d1ecb90441', 's:69:\"https://npcbangladesh.org/cache/c2d49e9c288b961b77ece2d1ecb90441.webp\";', 1770282977),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c33f2894e8a24c9a2317cbbf406f5730', 's:69:\"https://npcbangladesh.org/cache/c33f2894e8a24c9a2317cbbf406f5730.webp\";', 1770283155),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c36f5a44e539a86e1230c8b605f87f55', 's:69:\"https://npcbangladesh.org/cache/c36f5a44e539a86e1230c8b605f87f55.webp\";', 1770223617),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c38f3458a37184a59aa4ea9e29cb5645', 's:69:\"https://npcbangladesh.org/cache/c38f3458a37184a59aa4ea9e29cb5645.webp\";', 1770266312),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c3acdd36c3286fc31173a78861de64d9', 's:69:\"https://npcbangladesh.org/cache/c3acdd36c3286fc31173a78861de64d9.webp\";', 1770358702),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c43fc65eb6f1d85a079c41d1e99fa960', 's:69:\"https://npcbangladesh.org/cache/c43fc65eb6f1d85a079c41d1e99fa960.webp\";', 1770278456),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c45afb7eee41731b68861fa5952e7d79', 's:69:\"https://npcbangladesh.org/cache/c45afb7eee41731b68861fa5952e7d79.webp\";', 1770358817),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c57c5b152d8903c7dc5ae0541d1ad9b4', 's:69:\"https://npcbangladesh.org/cache/c57c5b152d8903c7dc5ae0541d1ad9b4.webp\";', 1770282983),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c5ab3c4246cf1bd887b400764698d852', 's:69:\"https://npcbangladesh.org/cache/c5ab3c4246cf1bd887b400764698d852.webp\";', 1770282768),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c652ce5f34f91d1331b0746172ad732b', 's:69:\"https://npcbangladesh.org/cache/c652ce5f34f91d1331b0746172ad732b.webp\";', 1770265680),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c67717cd1f8d3e810bb3f4a8c9d03913', 's:69:\"https://npcbangladesh.org/cache/c67717cd1f8d3e810bb3f4a8c9d03913.webp\";', 1770358722),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c694a97a5f9791ee82cf7688d3ebcc2a', 's:69:\"https://npcbangladesh.org/cache/c694a97a5f9791ee82cf7688d3ebcc2a.webp\";', 1770283045),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c6a29cedeabda8b447212c6277718569', 's:69:\"https://npcbangladesh.org/cache/c6a29cedeabda8b447212c6277718569.webp\";', 1770266092),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c6dc199882d523534783bef9317e2e02', 's:69:\"https://npcbangladesh.org/cache/c6dc199882d523534783bef9317e2e02.webp\";', 1770266330),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c703119f96636009a2337b516fdb3f96', 's:69:\"https://npcbangladesh.org/cache/c703119f96636009a2337b516fdb3f96.webp\";', 1770265822),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c708c64efbf9a791ca823ec30de11298', 's:69:\"https://npcbangladesh.org/cache/c708c64efbf9a791ca823ec30de11298.webp\";', 1770266324),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c7291262b3dbc0b996e2427332949f68', 's:69:\"https://npcbangladesh.org/cache/c7291262b3dbc0b996e2427332949f68.webp\";', 1770185387),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c7a3e06b5259717aebb748a71ffe0b09', 's:69:\"https://npcbangladesh.org/cache/c7a3e06b5259717aebb748a71ffe0b09.webp\";', 1770282859),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c7efefccf0e912ba6df74500b4427f61', 's:69:\"https://npcbangladesh.org/cache/c7efefccf0e912ba6df74500b4427f61.webp\";', 1770283060),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c7f4b7912a01289db065685bc7672cbe', 's:69:\"https://npcbangladesh.org/cache/c7f4b7912a01289db065685bc7672cbe.webp\";', 1770358750),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c80f3c37808d13d133de32f3f5bcf947', 's:69:\"https://npcbangladesh.org/cache/c80f3c37808d13d133de32f3f5bcf947.webp\";', 1770102131),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c857b046a0bb9e318af44d0e82d214cc', 's:69:\"https://npcbangladesh.org/cache/c857b046a0bb9e318af44d0e82d214cc.webp\";', 1770283142),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c8bc5cbbb5636d86fec1b5c580e6eab7', 's:69:\"https://npcbangladesh.org/cache/c8bc5cbbb5636d86fec1b5c580e6eab7.webp\";', 1770101834),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c8e5d878e0b047db07c7a0ae4d5c2322', 's:69:\"https://npcbangladesh.org/cache/c8e5d878e0b047db07c7a0ae4d5c2322.webp\";', 1770278996),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c96346e0e73bb67220303bab98f1fd9c', 's:69:\"https://npcbangladesh.org/cache/c96346e0e73bb67220303bab98f1fd9c.webp\";', 1770185387),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c98a4311315c7268a21acbd1623ff50c', 's:69:\"https://npcbangladesh.org/cache/c98a4311315c7268a21acbd1623ff50c.webp\";', 1770112208),
('national-paralympic-committee-of-bangladesh-cache-image_cache_c998912937fc58ff91d6793b2c657d71', 's:68:\"https://npcbangladesh.org/cache/c998912937fc58ff91d6793b2c657d71.png\";', 1770167065),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ca13d4703ec5acbb12c7a9a810f19c38', 's:69:\"https://npcbangladesh.org/cache/ca13d4703ec5acbb12c7a9a810f19c38.webp\";', 1770284417),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ca6a87e84d267a453581814f4fd5c3a6', 's:69:\"https://npcbangladesh.org/cache/ca6a87e84d267a453581814f4fd5c3a6.webp\";', 1770265820),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cb6b0959120ac18a421b7cfd2528f579', 's:69:\"https://npcbangladesh.org/cache/cb6b0959120ac18a421b7cfd2528f579.webp\";', 1770266339),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cbcb0d5ef8f4d887c9bbbc92731327c7', 's:69:\"https://npcbangladesh.org/cache/cbcb0d5ef8f4d887c9bbbc92731327c7.webp\";', 1770283059),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cc1ace320c891f5d3edf3559f8099929', 's:69:\"https://npcbangladesh.org/cache/cc1ace320c891f5d3edf3559f8099929.webp\";', 1770266331),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cc4cfb6b4e3af1b255ad75f5b7b21065', 's:69:\"https://npcbangladesh.org/cache/cc4cfb6b4e3af1b255ad75f5b7b21065.webp\";', 1770282875),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cc5061df3f98d9c711584a413082c1d2', 's:69:\"https://npcbangladesh.org/cache/cc5061df3f98d9c711584a413082c1d2.webp\";', 1770265815),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ccce4b4f25be4fe20c55968a0e4281c8', 's:69:\"https://npcbangladesh.org/cache/ccce4b4f25be4fe20c55968a0e4281c8.webp\";', 1770265656),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cce88b59af579153a56f717ba9f84ca6', 's:69:\"https://npcbangladesh.org/cache/cce88b59af579153a56f717ba9f84ca6.webp\";', 1770270316),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cd06768504b94d49e6243a0adf5285bd', 's:69:\"https://npcbangladesh.org/cache/cd06768504b94d49e6243a0adf5285bd.webp\";', 1770358735),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cd4f9faf938d2618b35d254db259ffbf', 's:69:\"https://npcbangladesh.org/cache/cd4f9faf938d2618b35d254db259ffbf.webp\";', 1770101804),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cd774132082b43e3d3f9228a1424e717', 's:69:\"https://npcbangladesh.org/cache/cd774132082b43e3d3f9228a1424e717.webp\";', 1770358754),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cd7981d5840f22e5fd2aafd128e254cc', 's:69:\"https://npcbangladesh.org/cache/cd7981d5840f22e5fd2aafd128e254cc.webp\";', 1770358758),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cde82f2e62669574409c2f997cf21a2e', 's:69:\"https://npcbangladesh.org/cache/cde82f2e62669574409c2f997cf21a2e.webp\";', 1770358716),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cdedca86ba1f379566f5af3eb810cceb', 's:69:\"https://npcbangladesh.org/cache/cdedca86ba1f379566f5af3eb810cceb.webp\";', 1770266342),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ce29663623e34a000f10ea24a1c7618b', 's:69:\"https://npcbangladesh.org/cache/ce29663623e34a000f10ea24a1c7618b.webp\";', 1770358737),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ce3d5170ac418505dd2d3e7c5d4a0600', 's:69:\"https://npcbangladesh.org/cache/ce3d5170ac418505dd2d3e7c5d4a0600.webp\";', 1770266336),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ce7f93678ef93461fdecb74d04b5c781', 's:69:\"https://npcbangladesh.org/cache/ce7f93678ef93461fdecb74d04b5c781.webp\";', 1770358730),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ce86cc414034fcaea5173e96cef3f437', 's:69:\"https://npcbangladesh.org/cache/ce86cc414034fcaea5173e96cef3f437.webp\";', 1770689130),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ce88636c8614879c72a151a1b53ed39a', 's:69:\"https://npcbangladesh.org/cache/ce88636c8614879c72a151a1b53ed39a.webp\";', 1770098097),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cf0dac4449f162ad43e7189d6425cafb', 's:69:\"https://npcbangladesh.org/cache/cf0dac4449f162ad43e7189d6425cafb.webp\";', 1770094642),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cf207444b900be243a57ef4573228397', 's:69:\"https://npcbangladesh.org/cache/cf207444b900be243a57ef4573228397.webp\";', 1770358780),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cf4db8ebd2ddb1d29bd4962134480ffa', 's:69:\"https://npcbangladesh.org/cache/cf4db8ebd2ddb1d29bd4962134480ffa.webp\";', 1770278981),
('national-paralympic-committee-of-bangladesh-cache-image_cache_cfdbc5d57857dacd150b92084dbc7e98', 's:69:\"https://npcbangladesh.org/cache/cfdbc5d57857dacd150b92084dbc7e98.webp\";', 1770266316),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d01e92f79db0c66d304e8c6fee5329b4', 's:69:\"https://npcbangladesh.org/cache/d01e92f79db0c66d304e8c6fee5329b4.webp\";', 1770283069),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d064efe04f53d829af8bb5979b8a1156', 's:69:\"https://npcbangladesh.org/cache/d064efe04f53d829af8bb5979b8a1156.webp\";', 1770265825),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d06be6b635e299009be3a0746b15689a', 's:69:\"https://npcbangladesh.org/cache/d06be6b635e299009be3a0746b15689a.webp\";', 1770283049),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d0e929305d550d5a7784faf556d6c080', 's:69:\"https://npcbangladesh.org/cache/d0e929305d550d5a7784faf556d6c080.webp\";', 1770265814),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d1bd15cd4b283cbdaef7cafc326652bb', 's:69:\"https://npcbangladesh.org/cache/d1bd15cd4b283cbdaef7cafc326652bb.webp\";', 1770282857),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d242500bae85da84fac6f15a3c20b9cf', 's:69:\"https://npcbangladesh.org/cache/d242500bae85da84fac6f15a3c20b9cf.webp\";', 1770358729),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d24e74e478e30e30924cc4a24455998c', 's:69:\"https://npcbangladesh.org/cache/d24e74e478e30e30924cc4a24455998c.webp\";', 1770282857),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d2df5fb5171260f48e20e951d61c640c', 's:69:\"https://npcbangladesh.org/cache/d2df5fb5171260f48e20e951d61c640c.webp\";', 1770094701),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d2fd9022fb8131a0f13cec49ea42b2c6', 's:69:\"https://npcbangladesh.org/cache/d2fd9022fb8131a0f13cec49ea42b2c6.webp\";', 1770358822),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d37dedc931a8e76eccb6de758f2666fe', 's:69:\"https://npcbangladesh.org/cache/d37dedc931a8e76eccb6de758f2666fe.webp\";', 1770358751),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d4abb170e2b3ef5497040714f615ced4', 's:69:\"https://npcbangladesh.org/cache/d4abb170e2b3ef5497040714f615ced4.webp\";', 1770266320),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d538484d5834f6d32473cf51a4b45b6c', 's:69:\"https://npcbangladesh.org/cache/d538484d5834f6d32473cf51a4b45b6c.webp\";', 1770101766),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d5d09c8948b05aaf5699fe0fe8437cb5', 's:69:\"https://npcbangladesh.org/cache/d5d09c8948b05aaf5699fe0fe8437cb5.webp\";', 1770102064),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d5e4e25d45f1b1c805ffb46af49f5c62', 's:69:\"https://npcbangladesh.org/cache/d5e4e25d45f1b1c805ffb46af49f5c62.webp\";', 1770704070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d5e60cdccf41cd593c796fa1f67bd5f7', 's:69:\"https://npcbangladesh.org/cache/d5e60cdccf41cd593c796fa1f67bd5f7.webp\";', 1770266238),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d66dacf6debbe4c9c9408a1c9fa5a57d', 's:69:\"https://npcbangladesh.org/cache/d66dacf6debbe4c9c9408a1c9fa5a57d.webp\";', 1770102300),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d73d693d958aac8006093e87f9d86910', 's:69:\"https://npcbangladesh.org/cache/d73d693d958aac8006093e87f9d86910.webp\";', 1770266343),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d7abb2013146ae672cb434b7a8719959', 's:69:\"https://npcbangladesh.org/cache/d7abb2013146ae672cb434b7a8719959.webp\";', 1770358731),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d7c706b5433e1925ed5dce499fd7ad00', 's:69:\"https://npcbangladesh.org/cache/d7c706b5433e1925ed5dce499fd7ad00.webp\";', 1770266345),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d8182b902aed6b895fa96f4f140a81d2', 's:69:\"https://npcbangladesh.org/cache/d8182b902aed6b895fa96f4f140a81d2.webp\";', 1770098097),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d8ca6911c2e688c5307b95dadf592362', 's:69:\"https://npcbangladesh.org/cache/d8ca6911c2e688c5307b95dadf592362.webp\";', 1770282943),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d9610cf5c8d0d2a98a4abf54c6590f8b', 's:69:\"https://npcbangladesh.org/cache/d9610cf5c8d0d2a98a4abf54c6590f8b.webp\";', 1770101912),
('national-paralympic-committee-of-bangladesh-cache-image_cache_d9e3404c0524c184c280fff93bdb9fb4', 's:69:\"https://npcbangladesh.org/cache/d9e3404c0524c184c280fff93bdb9fb4.webp\";', 1770266237),
('national-paralympic-committee-of-bangladesh-cache-image_cache_da90b9053eab8939df65aa719be36a6f', 's:69:\"https://npcbangladesh.org/cache/da90b9053eab8939df65aa719be36a6f.webp\";', 1770282944),
('national-paralympic-committee-of-bangladesh-cache-image_cache_db100f341013b7966d4e2a1bf193c4da', 's:69:\"https://npcbangladesh.org/cache/db100f341013b7966d4e2a1bf193c4da.webp\";', 1770266334),
('national-paralympic-committee-of-bangladesh-cache-image_cache_db221e5271b77b0145f161be3552f873', 's:69:\"https://npcbangladesh.org/cache/db221e5271b77b0145f161be3552f873.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dbc3005bae8c56c596dac9fce82712a1', 's:69:\"https://npcbangladesh.org/cache/dbc3005bae8c56c596dac9fce82712a1.webp\";', 1770101802),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dbca49f40b271c18c3ebea3b5eac23fe', 's:69:\"https://npcbangladesh.org/cache/dbca49f40b271c18c3ebea3b5eac23fe.webp\";', 1770283071),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dbdb08fc0fe023df6e56270268b4110d', 's:69:\"https://npcbangladesh.org/cache/dbdb08fc0fe023df6e56270268b4110d.webp\";', 1770102064),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dcc3c79f0698ec72370d7cf7c6f7376c', 's:69:\"https://npcbangladesh.org/cache/dcc3c79f0698ec72370d7cf7c6f7376c.webp\";', 1770278332),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dd12c4f75f1308b9d67249c664ebfd8b', 's:69:\"https://npcbangladesh.org/cache/dd12c4f75f1308b9d67249c664ebfd8b.webp\";', 1770279068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dd14020f25af53cce111a87ee5bc88e0', 's:69:\"https://npcbangladesh.org/cache/dd14020f25af53cce111a87ee5bc88e0.webp\";', 1770269716),
('national-paralympic-committee-of-bangladesh-cache-image_cache_de696f7b6149de9ea1eef4513dd56a04', 's:69:\"https://npcbangladesh.org/cache/de696f7b6149de9ea1eef4513dd56a04.webp\";', 1770358708),
('national-paralympic-committee-of-bangladesh-cache-image_cache_de7686ac12581db01a320cbf5ef8e958', 's:69:\"https://npcbangladesh.org/cache/de7686ac12581db01a320cbf5ef8e958.webp\";', 1770266092),
('national-paralympic-committee-of-bangladesh-cache-image_cache_de86a16c5c722de211b7515b6664da17', 's:69:\"https://npcbangladesh.org/cache/de86a16c5c722de211b7515b6664da17.webp\";', 1770358815),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dea4749dcb3bd409f98491126f1341e9', 's:69:\"https://npcbangladesh.org/cache/dea4749dcb3bd409f98491126f1341e9.webp\";', 1770222217),
('national-paralympic-committee-of-bangladesh-cache-image_cache_df3b2b1743389aca7b02f35c291c7e92', 's:69:\"https://npcbangladesh.org/cache/df3b2b1743389aca7b02f35c291c7e92.webp\";', 1770358830),
('national-paralympic-committee-of-bangladesh-cache-image_cache_df4df86fd05d7feea8065a8bc66bd4c1', 's:69:\"https://npcbangladesh.org/cache/df4df86fd05d7feea8065a8bc66bd4c1.webp\";', 1770282856),
('national-paralympic-committee-of-bangladesh-cache-image_cache_df562bc94d0908e4dc79a9ee38b58b1e', 's:69:\"https://npcbangladesh.org/cache/df562bc94d0908e4dc79a9ee38b58b1e.webp\";', 1770358820),
('national-paralympic-committee-of-bangladesh-cache-image_cache_df62e353b542ea8acfe976a03b3033af', 's:69:\"https://npcbangladesh.org/cache/df62e353b542ea8acfe976a03b3033af.webp\";', 1770282875),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dfb561c2446b47be961653b6caf60470', 's:69:\"https://npcbangladesh.org/cache/dfb561c2446b47be961653b6caf60470.webp\";', 1770265826),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dfe49786627f71b92883ed85bb068a05', 's:69:\"https://npcbangladesh.org/cache/dfe49786627f71b92883ed85bb068a05.webp\";', 1770282856),
('national-paralympic-committee-of-bangladesh-cache-image_cache_dffad478ba6b7e4a6d3328a779359529', 's:69:\"https://npcbangladesh.org/cache/dffad478ba6b7e4a6d3328a779359529.webp\";', 1770704068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e062876d469c5429d173f0a2c6862557', 's:69:\"https://npcbangladesh.org/cache/e062876d469c5429d173f0a2c6862557.webp\";', 1770094642),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e0a2193d456f778732af30e42614bd13', 's:69:\"https://npcbangladesh.org/cache/e0a2193d456f778732af30e42614bd13.webp\";', 1770282960),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e0e211527434e7141a11c0a59b4d7d60', 's:69:\"https://npcbangladesh.org/cache/e0e211527434e7141a11c0a59b4d7d60.webp\";', 1770265828),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e1aaf481ae43b3b144540782c9c7e32d', 's:69:\"https://npcbangladesh.org/cache/e1aaf481ae43b3b144540782c9c7e32d.webp\";', 1770266336),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e2107e201fb8a5a69a57151ff002c653', 's:69:\"https://npcbangladesh.org/cache/e2107e201fb8a5a69a57151ff002c653.webp\";', 1770704070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e21e3e864d6ac016a42a1f5da8e22f28', 's:69:\"https://npcbangladesh.org/cache/e21e3e864d6ac016a42a1f5da8e22f28.webp\";', 1770266241),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e236d367f1360815ce463625ffde7c85', 's:69:\"https://npcbangladesh.org/cache/e236d367f1360815ce463625ffde7c85.webp\";', 1770265825),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e26cdcd2a75cf484f0ab1849541387da', 's:69:\"https://npcbangladesh.org/cache/e26cdcd2a75cf484f0ab1849541387da.webp\";', 1770222217),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e28e970232b5a21fb00caba76e9f568d', 's:69:\"https://npcbangladesh.org/cache/e28e970232b5a21fb00caba76e9f568d.webp\";', 1770099826),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e32ce5d570bbd425f77ce2bcb994deff', 's:69:\"https://npcbangladesh.org/cache/e32ce5d570bbd425f77ce2bcb994deff.webp\";', 1770094748),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e3393c89806b22918c2c95b252a20eca', 's:69:\"https://npcbangladesh.org/cache/e3393c89806b22918c2c95b252a20eca.webp\";', 1770282977),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e341e7d7a8bb902273ad9b4d81dacd7f', 's:69:\"https://npcbangladesh.org/cache/e341e7d7a8bb902273ad9b4d81dacd7f.webp\";', 1770283069),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e3846268b59766f40fb292f9ea691f65', 's:69:\"https://npcbangladesh.org/cache/e3846268b59766f40fb292f9ea691f65.webp\";', 1770101768),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e3f34378fc2dd5cfb8d7b2e933d9e703', 's:69:\"https://npcbangladesh.org/cache/e3f34378fc2dd5cfb8d7b2e933d9e703.webp\";', 1770266319),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e40dd2cb5ca1007c950ca1b9a064255a', 's:69:\"https://npcbangladesh.org/cache/e40dd2cb5ca1007c950ca1b9a064255a.webp\";', 1770278332),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e425311506cc7c4e881bb65a71df4444', 's:69:\"https://npcbangladesh.org/cache/e425311506cc7c4e881bb65a71df4444.webp\";', 1770266345),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e439faa02e68164af9a374c449b43fbc', 's:69:\"https://npcbangladesh.org/cache/e439faa02e68164af9a374c449b43fbc.webp\";', 1770266317),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e4840a5cf900fb48f457910229fd1d41', 's:69:\"https://npcbangladesh.org/cache/e4840a5cf900fb48f457910229fd1d41.webp\";', 1770265815),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e4d01fb7310c686f2f580e844ce6aa0b', 's:69:\"https://npcbangladesh.org/cache/e4d01fb7310c686f2f580e844ce6aa0b.webp\";', 1770358741),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e4df52095e094e7ec2f869026fe88b26', 's:69:\"https://npcbangladesh.org/cache/e4df52095e094e7ec2f869026fe88b26.webp\";', 1770282856),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e4f0f3bff100a9b77af02049b64a4263', 's:69:\"https://npcbangladesh.org/cache/e4f0f3bff100a9b77af02049b64a4263.webp\";', 1770358814),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e5c277e847b7a964a115e4f961e5e56d', 's:69:\"https://npcbangladesh.org/cache/e5c277e847b7a964a115e4f961e5e56d.webp\";', 1770222217),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e679bfcbc77175035e692b37ea73a33e', 's:69:\"https://npcbangladesh.org/cache/e679bfcbc77175035e692b37ea73a33e.webp\";', 1770101912),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e69089402b05da9b5ae15452f6a5cc1f', 's:69:\"https://npcbangladesh.org/cache/e69089402b05da9b5ae15452f6a5cc1f.webp\";', 1770112208),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e6d9606e24cd9509218ce77a6c2a3a38', 's:69:\"https://npcbangladesh.org/cache/e6d9606e24cd9509218ce77a6c2a3a38.webp\";', 1770185318),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e74f9628e5e3f6d9cf125e6752832a84', 's:69:\"https://npcbangladesh.org/cache/e74f9628e5e3f6d9cf125e6752832a84.webp\";', 1770265818),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e7546d5ab5bfe2f15afd6a7cd05fb5c1', 's:69:\"https://npcbangladesh.org/cache/e7546d5ab5bfe2f15afd6a7cd05fb5c1.webp\";', 1770278996),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e79b3d3ceea5b17f06b0ca29c03ad830', 's:69:\"https://npcbangladesh.org/cache/e79b3d3ceea5b17f06b0ca29c03ad830.webp\";', 1770282980),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e7cbce831266cdde602ebeaae017d501', 's:69:\"https://npcbangladesh.org/cache/e7cbce831266cdde602ebeaae017d501.webp\";', 1770284469),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e7e614baacac222d0e6050a83b06c449', 's:69:\"https://npcbangladesh.org/cache/e7e614baacac222d0e6050a83b06c449.webp\";', 1770102019),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e802fd3c40e444f4ad45ddc625536cce', 's:69:\"https://npcbangladesh.org/cache/e802fd3c40e444f4ad45ddc625536cce.webp\";', 1770266332),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e81261cfcc4ea009d8525d9461338a7c', 's:69:\"https://npcbangladesh.org/cache/e81261cfcc4ea009d8525d9461338a7c.webp\";', 1770358816),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e82e314914316e04d278fbbda0d36639', 's:69:\"https://npcbangladesh.org/cache/e82e314914316e04d278fbbda0d36639.webp\";', 1770266092),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e892a4dd44bd3a15e1467209c5b83385', 's:69:\"https://npcbangladesh.org/cache/e892a4dd44bd3a15e1467209c5b83385.webp\";', 1770102064),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e8df93bfb83a9ed86ac8b82a459d637a', 's:69:\"https://npcbangladesh.org/cache/e8df93bfb83a9ed86ac8b82a459d637a.webp\";', 1770704070),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e8ef4607bb0b18768008a6f37f4b1eff', 's:69:\"https://npcbangladesh.org/cache/e8ef4607bb0b18768008a6f37f4b1eff.webp\";', 1770358745),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e9bb660030f0f719444a83b56906c55c', 's:69:\"https://npcbangladesh.org/cache/e9bb660030f0f719444a83b56906c55c.webp\";', 1770266332),
('national-paralympic-committee-of-bangladesh-cache-image_cache_e9bbd7f8280c5b15312fe22e90415301', 's:69:\"https://npcbangladesh.org/cache/e9bbd7f8280c5b15312fe22e90415301.webp\";', 1770266234),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ea4f249ae46fe39e1ae8c08e0d5d8ef7', 's:69:\"https://npcbangladesh.org/cache/ea4f249ae46fe39e1ae8c08e0d5d8ef7.webp\";', 1770102020),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ea5862ff991f77955a25e0b425a20ac8', 's:69:\"https://npcbangladesh.org/cache/ea5862ff991f77955a25e0b425a20ac8.webp\";', 1770283142),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ea59d5afdf4854e57957246d24583d2a', 's:69:\"https://npcbangladesh.org/cache/ea59d5afdf4854e57957246d24583d2a.webp\";', 1770358723),
('national-paralympic-committee-of-bangladesh-cache-image_cache_eac6abdbb64bba27e613a520f87f5c55', 's:69:\"https://npcbangladesh.org/cache/eac6abdbb64bba27e613a520f87f5c55.webp\";', 1770282859),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ead36ac0cd458249bb10764f1b757da1', 's:69:\"https://npcbangladesh.org/cache/ead36ac0cd458249bb10764f1b757da1.webp\";', 1770282779),
('national-paralympic-committee-of-bangladesh-cache-image_cache_eaff02e6ae6f954972673943dd33de9f', 's:69:\"https://npcbangladesh.org/cache/eaff02e6ae6f954972673943dd33de9f.webp\";', 1770266328),
('national-paralympic-committee-of-bangladesh-cache-image_cache_eb0943f53bdcd8ce1539086447739c78', 's:69:\"https://npcbangladesh.org/cache/eb0943f53bdcd8ce1539086447739c78.webp\";', 1770358823),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ebd2c10bba08453d98ec55ce75b7060f', 's:69:\"https://npcbangladesh.org/cache/ebd2c10bba08453d98ec55ce75b7060f.webp\";', 1770282857),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ece47556742606043526639025be4ace', 's:69:\"https://npcbangladesh.org/cache/ece47556742606043526639025be4ace.webp\";', 1770270175),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ed575a131a611845dbda530ba839e149', 's:69:\"https://npcbangladesh.org/cache/ed575a131a611845dbda530ba839e149.webp\";', 1770266314),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ed59c74443494c263470140efb81bd05', 's:69:\"https://npcbangladesh.org/cache/ed59c74443494c263470140efb81bd05.webp\";', 1770282968),
('national-paralympic-committee-of-bangladesh-cache-image_cache_edbf3e4349b8ae81d8bcdef952c600bb', 's:69:\"https://npcbangladesh.org/cache/edbf3e4349b8ae81d8bcdef952c600bb.webp\";', 1770282970),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ee22a72d4536b79294c93a338952bbe7', 's:69:\"https://npcbangladesh.org/cache/ee22a72d4536b79294c93a338952bbe7.webp\";', 1770358762),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ee43385c720714c103b4706a02602dd0', 's:69:\"https://npcbangladesh.org/cache/ee43385c720714c103b4706a02602dd0.webp\";', 1770358734),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ee5da5f5f71b792a150d0009be3e158c', 's:69:\"https://npcbangladesh.org/cache/ee5da5f5f71b792a150d0009be3e158c.webp\";', 1770266238),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ee68caf382c8dce0f56f24af8dc7f732', 's:69:\"https://npcbangladesh.org/cache/ee68caf382c8dce0f56f24af8dc7f732.webp\";', 1770358721),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ef0373440e819df1e56f3e19cdefd2fc', 's:69:\"https://npcbangladesh.org/cache/ef0373440e819df1e56f3e19cdefd2fc.webp\";', 1770094643),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ef2beec62cb138e942b18107817d43f1', 's:69:\"https://npcbangladesh.org/cache/ef2beec62cb138e942b18107817d43f1.webp\";', 1770282780),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f082ae42871c0f83dc164a2b28065207', 's:69:\"https://npcbangladesh.org/cache/f082ae42871c0f83dc164a2b28065207.webp\";', 1770279068),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f0abed52b345d8d2811e7c343f82d739', 's:69:\"https://npcbangladesh.org/cache/f0abed52b345d8d2811e7c343f82d739.webp\";', 1770358765),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f1300cff7d1bc1a80e8c4603c2201af3', 's:69:\"https://npcbangladesh.org/cache/f1300cff7d1bc1a80e8c4603c2201af3.webp\";', 1770270317),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f15ea17f1f676c02c5e51f5da8d695bc', 's:69:\"https://npcbangladesh.org/cache/f15ea17f1f676c02c5e51f5da8d695bc.webp\";', 1770265814),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f38fb5bb50502e4748bf85f58c3373ba', 's:69:\"https://npcbangladesh.org/cache/f38fb5bb50502e4748bf85f58c3373ba.webp\";', 1770265828),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f408da3c5163af0067a59f8fcf5d2fb4', 's:69:\"https://npcbangladesh.org/cache/f408da3c5163af0067a59f8fcf5d2fb4.webp\";', 1770101766),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f4a255e0f5dd9f06193e99ee075a0eb4', 's:69:\"https://npcbangladesh.org/cache/f4a255e0f5dd9f06193e99ee075a0eb4.webp\";', 1770358701),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f5c20fa2028d09ed058dedf449b08138', 's:69:\"https://npcbangladesh.org/cache/f5c20fa2028d09ed058dedf449b08138.webp\";', 1770278275),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f5c2e0bf2e1a28be5f23f1c8e0cbe08b', 's:69:\"https://npcbangladesh.org/cache/f5c2e0bf2e1a28be5f23f1c8e0cbe08b.webp\";', 1770266091),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f5cbc793e7f8ccc70f509f8009dc943a', 's:69:\"https://npcbangladesh.org/cache/f5cbc793e7f8ccc70f509f8009dc943a.webp\";', 1770266320),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f5ea3922f1eebf393a1a2a650858f9a9', 's:69:\"https://npcbangladesh.org/cache/f5ea3922f1eebf393a1a2a650858f9a9.webp\";', 1770266324),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f62c61270a002ab50bb102de945ffbf4', 's:69:\"https://npcbangladesh.org/cache/f62c61270a002ab50bb102de945ffbf4.webp\";', 1770266322),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f6b2fb0955d1d3bb34c5022007e89705', 's:69:\"https://npcbangladesh.org/cache/f6b2fb0955d1d3bb34c5022007e89705.webp\";', 1770102065),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f6c6441870e64675c8359682442a86b2', 's:69:\"https://npcbangladesh.org/cache/f6c6441870e64675c8359682442a86b2.webp\";', 1770288349),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f7b53ac748957814c70d10164c9c0f43', 's:69:\"https://npcbangladesh.org/cache/f7b53ac748957814c70d10164c9c0f43.webp\";', 1770282958),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f80181e4acec7425465ddcafc56f97d6', 's:69:\"https://npcbangladesh.org/cache/f80181e4acec7425465ddcafc56f97d6.webp\";', 1770102131),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f8bebb7e556cfec3c9a02e7d14815b7a', 's:69:\"https://npcbangladesh.org/cache/f8bebb7e556cfec3c9a02e7d14815b7a.webp\";', 1770266237),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f9b25ac8708462a63424693a98355b62', 's:69:\"https://npcbangladesh.org/cache/f9b25ac8708462a63424693a98355b62.webp\";', 1770282892),
('national-paralympic-committee-of-bangladesh-cache-image_cache_f9da9e23217824eaaf967b3abafd0c8d', 's:69:\"https://npcbangladesh.org/cache/f9da9e23217824eaaf967b3abafd0c8d.webp\";', 1770704069),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fa20e5732252c88bd8f142afc2e68583', 's:69:\"https://npcbangladesh.org/cache/fa20e5732252c88bd8f142afc2e68583.webp\";', 1770278330),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fb6a79155fa13b6ed122b81170cba853', 's:69:\"https://npcbangladesh.org/cache/fb6a79155fa13b6ed122b81170cba853.webp\";', 1770266307),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fba4f2275510e06557e91ab3b567dcb4', 's:69:\"https://npcbangladesh.org/cache/fba4f2275510e06557e91ab3b567dcb4.webp\";', 1770282858),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fcab112f7b252828a115aad1769ec6f1', 's:69:\"https://npcbangladesh.org/cache/fcab112f7b252828a115aad1769ec6f1.webp\";', 1770282892),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fccaae85fe482f244dd91b2fcdfb4106', 's:69:\"https://npcbangladesh.org/cache/fccaae85fe482f244dd91b2fcdfb4106.webp\";', 1770266331),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fd1cf2e6936397824880a361880c2efc', 's:69:\"https://npcbangladesh.org/cache/fd1cf2e6936397824880a361880c2efc.webp\";', 1770102043),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fd4949e215d4d2defc24831ffc8f6a8d', 's:69:\"https://npcbangladesh.org/cache/fd4949e215d4d2defc24831ffc8f6a8d.webp\";', 1770266313),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fdd26a876c9caa820620b205ff808deb', 's:69:\"https://npcbangladesh.org/cache/fdd26a876c9caa820620b205ff808deb.webp\";', 1770282857),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fde2dd907e0ce2ad683247b5c3ee23a8', 's:69:\"https://npcbangladesh.org/cache/fde2dd907e0ce2ad683247b5c3ee23a8.webp\";', 1770282970),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fde70aec9799ef0d50e6c9aeb5d77507', 's:69:\"https://npcbangladesh.org/cache/fde70aec9799ef0d50e6c9aeb5d77507.webp\";', 1770278364),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ff9872f8266f33aa7fd5f15eef95bcec', 's:69:\"https://npcbangladesh.org/cache/ff9872f8266f33aa7fd5f15eef95bcec.webp\";', 1770358772),
('national-paralympic-committee-of-bangladesh-cache-image_cache_ffe97387b966b06108edad8b0fad16c7', 's:69:\"https://npcbangladesh.org/cache/ffe97387b966b06108edad8b0fad16c7.webp\";', 1770358698),
('national-paralympic-committee-of-bangladesh-cache-image_cache_fff78375df7fd0554ada09c54e5330d8', 's:69:\"https://npcbangladesh.org/cache/fff78375df7fd0554ada09c54e5330d8.webp\";', 1770358703),
('national-paralympic-committee-of-bangladesh-cache-settings', 'a:38:{s:7:\"address\";s:105:\"National Sports Council \r\nOld Building, Room #202 (1st Floor)\r\n62/3 Purana Paltan, Dkaka-1000, Bangladesh\";s:5:\"email\";s:22:\"info@npcbangladesh.org\";s:5:\"phone\";s:34:\"+880 1336097353;  +880 1777-131517\";s:5:\"state\";s:3:\"322\";s:10:\"store_logo\";s:59:\"settings/store_logo/store_logo_1768926805_696fae5511e6f.png\";s:10:\"store_icon\";s:59:\"settings/store_icon/store_icon_1769319953_6975ae11d3804.png\";s:11:\"footer_logo\";s:61:\"settings/footer_logo/footer_logo_1768926805_696fae55845e1.png\";s:13:\"mail_protocol\";s:4:\"smtp\";s:12:\"mail_address\";s:23:\"imranertaza12@gmail.com\";s:9:\"smtp_host\";s:17:\"npcbangladesh.org\";s:13:\"smtp_username\";s:25:\"contact@npcbangladesh.org\";s:13:\"smtp_password\";s:12:\"NWQJb5+RRv%8\";s:9:\"smtp_port\";s:3:\"465\";s:12:\"smtp_timeout\";s:3:\"300\";s:11:\"smtp_crypto\";s:3:\"ssl\";s:6:\"fb_url\";s:46:\"https://www.facebook.com/BangladeshParalympic/\";s:11:\"twitter_url\";s:24:\"https://twitter.com/npcb\";s:12:\"linkedin_url\";s:46:\"https://www.linkedin.com/company/npcbangladesh\";s:13:\"instagram_url\";s:30:\"https://www.instagram.com/npcb\";s:10:\"meta_title\";s:43:\"National Paralympic Committee of Bangladesh\";s:12:\"meta_keyword\";s:37:\"NPCB, Paralympics, Bangladesh, Sports\";s:16:\"meta_description\";s:72:\"Official site of the National Paralympic Committee of Bangladesh (NPCB).\";s:11:\"meta_author\";s:10:\"NPCB Admin\";s:18:\"meta_news_keywords\";s:47:\"NPCB, Paralympics, Bangladesh, Sports, Athletes\";s:7:\"og_type\";s:7:\"article\";s:8:\"og_title\";s:12:\"NPCB Article\";s:14:\"og_description\";s:81:\"Discover the latest updates from the National Paralympic Committee of Bangladesh.\";s:8:\"og_image\";s:55:\"settings/og_image/og_image_1767534539_695a6fcbf108c.png\";s:14:\"og_image_width\";s:4:\"1200\";s:15:\"og_image_height\";s:3:\"630\";s:12:\"twitter_card\";s:19:\"summary_large_image\";s:13:\"twitter_title\";s:4:\"NPCB\";s:19:\"twitter_description\";s:68:\"Follow updates from the National Paralympic Committee of Bangladesh.\";s:13:\"twitter_image\";s:65:\"settings/twitter_image/twitter_image_1767534539_695a6fcbf2fd3.png\";s:14:\"twitter_domain\";s:26:\"https://npcbangladesh.org/\";s:10:\"brand_name\";s:43:\"National Paralympic Committee of Bangladesh\";s:10:\"breadcrumb\";s:49:\"settings/breadcrumb_1766415619_69495d03dcc4b.webp\";s:9:\"send_from\";s:25:\"contact@npcbangladesh.org\";}', 2084852828);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('national-paralympic-committee-of-bangladesh-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:69:{i:0;a:4:{s:1:\"a\";s:1:\"1\";s:1:\"b\";s:14:\"view-dashboard\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:1;a:4:{s:1:\"a\";s:1:\"2\";s:1:\"b\";s:10:\"view-users\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:2;a:4:{s:1:\"a\";s:1:\"3\";s:1:\"b\";s:12:\"create-users\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";s:1:\"4\";s:1:\"b\";s:12:\"update-users\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";s:1:\"5\";s:1:\"b\";s:12:\"delete-users\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";s:1:\"6\";s:1:\"b\";s:16:\"update-user-role\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";s:1:\"7\";s:1:\"b\";s:10:\"view-posts\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:7;a:4:{s:1:\"a\";s:1:\"8\";s:1:\"b\";s:12:\"create-posts\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:8;a:4:{s:1:\"a\";s:1:\"9\";s:1:\"b\";s:10:\"edit-posts\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:9;a:4:{s:1:\"a\";s:2:\"10\";s:1:\"b\";s:12:\"delete-posts\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";s:2:\"11\";s:1:\"b\";s:13:\"publish-posts\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:11;a:4:{s:1:\"a\";s:2:\"12\";s:1:\"b\";s:10:\"view-pages\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:12;a:4:{s:1:\"a\";s:2:\"13\";s:1:\"b\";s:12:\"create-pages\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:13;a:4:{s:1:\"a\";s:2:\"14\";s:1:\"b\";s:10:\"edit-pages\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:14;a:4:{s:1:\"a\";s:2:\"15\";s:1:\"b\";s:12:\"delete-pages\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";s:2:\"16\";s:1:\"b\";s:13:\"publish-pages\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:16;a:4:{s:1:\"a\";s:2:\"17\";s:1:\"b\";s:15:\"view-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:17;a:4:{s:1:\"a\";s:2:\"18\";s:1:\"b\";s:17:\"create-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:18;a:4:{s:1:\"a\";s:2:\"19\";s:1:\"b\";s:15:\"edit-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:19;a:4:{s:1:\"a\";s:2:\"20\";s:1:\"b\";s:17:\"delete-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";s:2:\"21\";s:1:\"b\";s:13:\"view-settings\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:21;a:4:{s:1:\"a\";s:2:\"22\";s:1:\"b\";s:15:\"update-settings\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:22;a:4:{s:1:\"a\";s:2:\"23\";s:1:\"b\";s:20:\"view-news-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:23;a:4:{s:1:\"a\";s:2:\"24\";s:1:\"b\";s:22:\"create-news-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:24;a:4:{s:1:\"a\";s:2:\"25\";s:1:\"b\";s:20:\"edit-news-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:25;a:4:{s:1:\"a\";s:2:\"26\";s:1:\"b\";s:22:\"delete-news-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:4:{s:1:\"a\";s:2:\"27\";s:1:\"b\";s:20:\"view-blog-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:27;a:4:{s:1:\"a\";s:2:\"28\";s:1:\"b\";s:22:\"create-blog-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:28;a:4:{s:1:\"a\";s:2:\"29\";s:1:\"b\";s:20:\"edit-blog-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:29;a:4:{s:1:\"a\";s:2:\"30\";s:1:\"b\";s:22:\"delete-blog-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:30;a:4:{s:1:\"a\";s:2:\"31\";s:1:\"b\";s:14:\"view-galleries\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:31;a:4:{s:1:\"a\";s:2:\"32\";s:1:\"b\";s:16:\"create-galleries\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:32;a:4:{s:1:\"a\";s:2:\"33\";s:1:\"b\";s:14:\"edit-galleries\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:33;a:4:{s:1:\"a\";s:2:\"34\";s:1:\"b\";s:16:\"delete-galleries\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:34;a:4:{s:1:\"a\";s:2:\"35\";s:1:\"b\";s:17:\"publish-galleries\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:35;a:4:{s:1:\"a\";s:2:\"36\";s:1:\"b\";s:11:\"view-events\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:36;a:4:{s:1:\"a\";s:2:\"37\";s:1:\"b\";s:13:\"create-events\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:37;a:4:{s:1:\"a\";s:2:\"38\";s:1:\"b\";s:11:\"edit-events\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:38;a:4:{s:1:\"a\";s:2:\"39\";s:1:\"b\";s:13:\"delete-events\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:39;a:4:{s:1:\"a\";s:2:\"40\";s:1:\"b\";s:22:\"view-events-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:40;a:4:{s:1:\"a\";s:2:\"41\";s:1:\"b\";s:24:\"create-events-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:41;a:4:{s:1:\"a\";s:2:\"42\";s:1:\"b\";s:22:\"edit-events-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:42;a:4:{s:1:\"a\";s:2:\"43\";s:1:\"b\";s:24:\"delete-events-categories\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:43;a:4:{s:1:\"a\";s:2:\"44\";s:1:\"b\";s:12:\"view-notices\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:44;a:4:{s:1:\"a\";s:2:\"45\";s:1:\"b\";s:14:\"create-notices\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:45;a:4:{s:1:\"a\";s:2:\"46\";s:1:\"b\";s:12:\"edit-notices\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:46;a:4:{s:1:\"a\";s:2:\"47\";s:1:\"b\";s:14:\"delete-notices\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:47;a:4:{s:1:\"a\";s:2:\"48\";s:1:\"b\";s:12:\"view-players\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:48;a:4:{s:1:\"a\";s:2:\"49\";s:1:\"b\";s:14:\"create-players\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:49;a:4:{s:1:\"a\";s:2:\"50\";s:1:\"b\";s:12:\"edit-players\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:50;a:4:{s:1:\"a\";s:2:\"51\";s:1:\"b\";s:14:\"delete-players\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:51;a:4:{s:1:\"a\";s:2:\"52\";s:1:\"b\";s:12:\"view-results\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:52;a:4:{s:1:\"a\";s:2:\"53\";s:1:\"b\";s:14:\"create-results\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:53;a:4:{s:1:\"a\";s:2:\"54\";s:1:\"b\";s:12:\"edit-results\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:54;a:4:{s:1:\"a\";s:2:\"55\";s:1:\"b\";s:14:\"delete-results\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:55;a:4:{s:1:\"a\";s:2:\"56\";s:1:\"b\";s:9:\"view-news\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:56;a:4:{s:1:\"a\";s:2:\"57\";s:1:\"b\";s:11:\"create-news\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:57;a:4:{s:1:\"a\";s:2:\"58\";s:1:\"b\";s:9:\"edit-news\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:58;a:4:{s:1:\"a\";s:2:\"59\";s:1:\"b\";s:11:\"delete-news\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:59;a:4:{s:1:\"a\";s:2:\"60\";s:1:\"b\";s:12:\"publish-news\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:60;a:4:{s:1:\"a\";s:2:\"61\";s:1:\"b\";s:9:\"view-blog\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:61;a:4:{s:1:\"a\";s:2:\"62\";s:1:\"b\";s:11:\"create-blog\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:62;a:4:{s:1:\"a\";s:2:\"63\";s:1:\"b\";s:9:\"edit-blog\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:63;a:4:{s:1:\"a\";s:2:\"64\";s:1:\"b\";s:11:\"delete-blog\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:64;a:4:{s:1:\"a\";s:2:\"65\";s:1:\"b\";s:12:\"publish-blog\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:65;a:4:{s:1:\"a\";s:2:\"66\";s:1:\"b\";s:15:\"manage-frontend\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:66;a:4:{s:1:\"a\";s:2:\"67\";s:1:\"b\";s:24:\"manage-committee-members\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:67;a:4:{s:1:\"a\";s:2:\"68\";s:1:\"b\";s:12:\"manage-menus\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:68;a:4:{s:1:\"a\";s:2:\"69\";s:1:\"b\";s:18:\"update-permissions\";s:1:\"c\";s:4:\"user\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";s:1:\"1\";s:1:\"b\";s:11:\"super-admin\";s:1:\"c\";s:4:\"user\";}i:1;a:3:{s:1:\"a\";s:1:\"2\";s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:4:\"user\";}i:2;a:3:{s:1:\"a\";s:1:\"3\";s:1:\"b\";s:6:\"editor\";s:1:\"c\";s:4:\"user\";}i:3;a:3:{s:1:\"a\";s:1:\"4\";s:1:\"b\";s:6:\"viewer\";s:1:\"c\";s:4:\"user\";}}}', 1769747243);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `breadcrumb` varchar(500) NOT NULL,
  `description` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `createdBy` int(10) UNSIGNED DEFAULT NULL,
  `updatedBy` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `category_name`, `slug`, `breadcrumb`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `image`, `alt_name`, `sort_order`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Para Athletics', 'athletics', 'Para Athletics', 'Bangladesh Para Athletics covers track and field events for athletes with physical disabilities in Bangladesh. Governed by the National Paralympic Committee of Bangladesh (NPCB), para athletics is one of the core paralympic sports, focusing on speed, strength, endurance, and technique through structured training programs, national competitions, and international representation.', 'Bangladesh Para Athletics | NPCB | Para Sports Bangladesh', 'Explore Bangladesh Para Athletics, featuring para athletes, track and field events, national championships, records, and international participation under NPCB.', 'Bangladesh para athletics, para athletics Bangladesh, NPCB athletics, paralympic athletics Bangladesh, disability athletics Bangladesh, para runners Bangladesh, para sports Bangladesh', 'categories/aruqzNHIVOkVMK3DkUF4lDL9beavMwLcmTKYUfLx.png', 'Bangladesh Para Athletics', 1, '1', 1, 1, '2025-12-13 08:56:30', '2026-01-08 06:11:38'),
(2, NULL, 'Amputee Football', 'football', 'Amputee Football', 'Bangladesh Para Football represents competitive football for athletes with physical disabilities in Bangladesh. Organized under the guidance of the National Paralympic Committee of Bangladesh (NPCB) in collaboration with relevant football authorities, para football promotes inclusion, teamwork, and high-performance sport through structured training programs, national competitions, and international participation.', 'Bangladesh Para Football | NPCB | Para Sports Bangladesh', 'Discover Bangladesh Para Football, featuring para football teams, national tournaments, athlete development programs, and international participation under NPCB.', 'Bangladesh para football, para football Bangladesh, NPCB football, paralympic football Bangladesh, disability football Bangladesh, para athletes Bangladesh, para sports Bangladesh', 'categories/6BQTiEg9a5IQORhAxxuRsYseYMeZUFS82yoy0Vuj.png', 'Bangladesh Para Football', 2, '1', 1, 1, '2025-12-13 08:56:30', '2026-01-08 06:10:12'),
(3, NULL, 'Physically Challenged Cricket', 'cricket', 'Physically Challenged Cricket', 'Bangladesh Para Cricket represents competitive cricket for athletes with physical disabilities in Bangladesh. Organized under the supervision of the National Paralympic Committee of Bangladesh (NPCB) in collaboration with the Bangladesh Cricket Board (BCB), para cricket aims to promote inclusion, talent development, and national as well as international participation through structured tournaments and training programs.', 'Bangladesh Para Cricket | NPCB & BCB | Para Sports Bangladesh', 'Learn about Bangladesh Para Cricket, including para cricket tournaments, national teams, player development, and activities organized by NPCB and BCB.', 'Bangladesh para cricket, para cricket Bangladesh, NPCB cricket, BCB para cricket, paralympic cricket Bangladesh, disability cricket Bangladesh, para sports Bangladesh', 'categories/Kw9n5PhJGkoE6yg1Y6c0pChwqi2AqBlHngugixCr.png', 'Bangladesh Para Cricket', 3, '1', 1, 1, '2025-12-13 08:56:30', '2026-01-08 06:09:11'),
(4, NULL, 'Para Badminton', 'badminton', 'Para Badminton', 'Bangladesh Para Badminton represents competitive badminton for athletes with physical disabilities in Bangladesh. Governed by the National Paralympic Committee of Bangladesh (NPCB) in coordination with relevant sports authorities, para badminton promotes inclusivity, skill development, and international participation through national tournaments, training programs, and talent identification initiatives.', 'Bangladesh Para Badminton | NPCB | Para Sports Bangladesh', 'Explore Bangladesh Para Badminton, featuring para badminton athletes, national competitions, training programs, and international representation under NPCB.', 'Bangladesh para badminton, para badminton Bangladesh, NPCB badminton, paralympic badminton Bangladesh, disability badminton Bangladesh, para athletes Bangladesh, para sports Bangladesh', 'categories/TUJ87m3jyO7NBukRW9jrtaAOXkEJE2o8AmAzxN0n.png', 'Badminton Alt', 4, '1', 1, 1, '2025-12-13 08:56:30', '2026-01-08 06:11:00'),
(5, NULL, 'Para Swimming', 'swimming', 'Para Swimming', 'Bangladesh Para Swimming represents competitive swimming for athletes with physical disabilities in Bangladesh. Governed by the National Paralympic Committee of Bangladesh (NPCB), the sport aims to promote inclusion, talent development, and international representation through structured training, national competitions, and global participation.', 'Bangladesh Para Swimming | NPCB | Para Sports Bangladesh', 'Explore Bangladesh Para Swimming, featuring national events, para swimmers, competitions, and development initiatives under the National Paralympic Committee of Bangladesh.', 'Bangladesh para swimming, para swimming Bangladesh, NPCB swimming, Bangladesh paralympic swimming, para athletes Bangladesh, disability swimming Bangladesh, para sports Bangladesh', 'categories/T8sMxOWq66Kfr0A84wkkOg5mTAgBFeWYj5xm7qAj.png', 'Bangladesh Para Swimming', 5, '1', 1, 1, '2025-12-13 08:56:30', '2026-01-08 06:11:57'),
(6, NULL, 'Para Archery', 'archery', 'Para Archery', 'Bangladesh Para Archery focuses on competitive archery for athletes with physical disabilities in Bangladesh. Managed under the guidance of the National Paralympic Committee of Bangladesh (NPCB), para archery promotes equal opportunity, precision sport excellence, and international participation through structured training programs and international-level competitions.', 'Bangladesh Para Archery | NPCB | Para Sports Bangladesh', 'Discover Bangladesh Para Archery, featuring para archers, national competitions, training initiatives, and international participation under the National Paralympic Committee of Bangladesh.', 'Bangladesh para archery, para archery Bangladesh, NPCB archery, paralympic archery Bangladesh, para archers Bangladesh, disability archery Bangladesh, para sports Bangladesh', 'categories/i84awz3NTyUg3BWv0oXO3IM0jzwQraWAzQ4ZY7gJ.png', 'Bangladesh Para Swimming', 6, '1', 1, 1, '2025-12-27 01:57:31', '2026-01-08 06:12:12'),
(7, NULL, 'Goalball', 'goalball', 'Goalball', 'Goalball', 'Goalball', 'Goalball', 'Goalball', 'posts/category/7/cat_image_69529883749b2.png', 'Goalball', 2, '0', 1, NULL, '2025-12-29 09:04:35', '2026-01-10 07:40:01'),
(8, NULL, 'Boccia', 'boccia', 'Boccia', 'Boccia', 'Boccia', 'Boccia', 'Boccia', 'posts/category/8/cat_image_69529a1dd9bde.png', 'Boccia', 1, '0', 1, NULL, '2025-12-29 09:11:25', '2026-01-10 07:40:15'),
(10, NULL, 'Para Taekwondo', 'para-taekwondo', 'Para Taekwondo', NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', 1, 1, '2026-01-08 06:06:39', '2026-01-17 02:06:08'),
(11, NULL, 'Para Table Tennis', 'para-table-tennis', 'Para Table Tennis', NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', 1, 1, '2026-01-08 06:07:01', '2026-01-15 03:00:23'),
(13, NULL, 'Wheelchair Basketball', 'wheelchair-basketball', 'Wheelchair Basketball', NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', 1, NULL, '2026-01-08 06:30:22', '2026-01-08 06:30:22'),
(15, 15, 'Classification', 'para-archery-classification', 'Classification', 'Classification is a unique framework used in Para sports to ensure fair and meaningful competition. It minimizes the impact of an athlete\'s impairment on the race or match outcome, ensuring that victory is determined by skill, fitness, power, and tactical ability—just like in any other sport.\r\n\r\nWhile other sports use weight classes (like Judo) or age categories (like marathons), Para sports use Sport Classes to group athletes with similar activity limitations together.\r\n\r\n \r\n\r\nTo be eligible for a Sport Class through NPC Bangladesh, an athlete must:\r\n\r\nHave an Underlying Health Condition: This must lead to one of the ten eligible impairments (such as impaired muscle power, limb deficiency, or vision impairment).\r\nMeet the Minimum Impairment Criteria (MIC): Each sport has a specific \"starting point\" for how much an impairment must affect athletic performance to be eligible.\r\nProvide Diagnostic Information: Athletes must provide medical documentation from a certified doctor in Bangladesh as part of the local evaluation process.', 'Classification', 'Classification', 'Classification', NULL, 'Classification', 0, '1', 1, 1, '2026-01-15 13:04:08', '2026-01-15 13:21:14'),
(16, 2, 'Blind Football', 'blind-football', 'Blind Football', 'Blind Football', 'Blind Football', 'Blind Football', 'Blind Football', NULL, 'Blind Football', 0, '1', 1, NULL, '2026-01-18 02:23:31', '2026-01-18 02:23:31'),
(17, NULL, 'Para powerlifting', 'para-powerlifting', 'Para powerlifting', 'Para powerlifting', 'Para powerlifting', 'Para powerlifting', 'Para powerlifting', NULL, 'Para powerlifting', 0, '1', 1, NULL, '2026-01-18 02:28:45', '2026-01-18 02:28:45'),
(18, NULL, 'Shooting Para sport', 'shooting-para-sport', 'Shooting Para sport', 'Shooting Para sport', 'Shooting Para sport', 'Shooting Para sport', 'Shooting Para sport', NULL, 'Shooting Para sport', 0, '1', 1, NULL, '2026-01-18 02:40:29', '2026-01-18 02:40:29'),
(19, NULL, 'Wheelchair Tennis', 'wheelchair-tennis', 'Wheelchair Tennis', 'Wheelchair Tennis', 'Wheelchair Tennis', 'Wheelchair Tennis', 'Wheelchair Tennis', NULL, 'Wheelchair Tennis', 0, '1', 1, NULL, '2026-01-18 02:49:54', '2026-01-18 02:49:54'),
(20, NULL, 'Sitting Volleyball', 'sitting-volleyball', 'Sitting Volleyball', 'Sitting Volleyball', 'Sitting Volleyball', 'Sitting Volleyball', 'Sitting Volleyball', NULL, 'Sitting Volleyball', 0, '1', 1, NULL, '2026-01-18 03:42:00', '2026-01-18 03:42:00'),
(21, NULL, 'NON-PARALYMPIC SPORTS', 'non-paralympic-sports', 'NON-PARALYMPIC SPORTS', 'NON-PARALYMPIC SPORTS', 'NON-PARALYMPIC SPORTS', 'NON-PARALYMPIC SPORTS', 'NON-PARALYMPIC SPORTS', NULL, 'NON-PARALYMPIC SPORTS', 0, '1', 1, NULL, '2026-01-18 04:19:07', '2026-01-18 04:19:07');

-- --------------------------------------------------------

--
-- Table structure for table `category_maps`
--

CREATE TABLE `category_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_maps`
--

INSERT INTO `category_maps` (`id`, `post_id`, `category_id`, `created_at`, `updated_at`) VALUES
(19, 9, 1, NULL, NULL),
(22, 11, 2, NULL, NULL),
(42, 20, 2, NULL, NULL),
(49, 23, 5, NULL, NULL),
(51, 24, 1, NULL, NULL),
(81, 18, 3, NULL, NULL),
(85, 22, 4, NULL, NULL),
(109, 24, 6, NULL, NULL),
(110, 25, 6, NULL, NULL),
(111, 25, 1, NULL, NULL),
(112, 28, 11, NULL, NULL),
(113, 29, 13, NULL, NULL),
(114, 30, 10, NULL, NULL),
(115, 26, 8, NULL, NULL),
(116, 27, 8, NULL, NULL),
(119, 37, 11, NULL, NULL),
(120, 38, 15, NULL, NULL),
(121, 39, 15, NULL, NULL),
(122, 40, 15, NULL, NULL),
(123, 41, 15, NULL, NULL),
(124, 42, 15, NULL, NULL),
(125, 43, 15, NULL, NULL),
(126, 20, 16, NULL, NULL),
(127, 44, 3, NULL, NULL),
(128, 44, 21, NULL, NULL),
(129, 45, 21, NULL, NULL),
(130, 46, 15, NULL, NULL),
(131, 47, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `committee_members`
--

CREATE TABLE `committee_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `createdBy` bigint(20) UNSIGNED DEFAULT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `committee_members`
--

INSERT INTO `committee_members` (`id`, `name`, `designation`, `description`, `slug`, `image`, `order`, `status`, `created_at`, `updated_at`, `createdBy`, `updatedBy`) VALUES
(2, 'Mustafa Kamal Shaheen', 'Vice President -1', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\">&nbsp;A passionate advocate for disability-inclusive sports, Mustafa Kamal Shaheen supports national programs and helps strengthen partnerships with local and global stakeholders.</span></p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e1a75fc9747f536ad1fb7da26f1e06428\"><span style=\"background-color:transparent;color:#000000;\">Supports national program development</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e05186204de4adab7b60371b646ade1f0\"><span style=\"background-color:transparent;color:#000000;\">Strengthens international and regional sports relations</span></li><li data-list-item-id=\"ed0eb46dfcb702a4e5cf2bbbda5d15fa0\"><span style=\"background-color:transparent;color:#000000;\">Advises on athlete development strategies</span><br>&nbsp;</li></ul>', 'mustafa-kamal-shaheen-vice-president--1', 'committee_members/2/images/committee_member_image_6972691bcb65d.jpg', 2, 1, '2025-12-13 08:56:32', '2026-01-22 12:14:51', NULL, 1),
(3, 'Mohammad Nasirul Islam', 'Vice President -2', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span></p><p><span style=\"background-color:transparent;color:#000000;\">Mohammad Nasirul Islam brings strong organizational experience, working to ensure smooth coordination of para-sports activities and events across Bangladesh.</span><br>&nbsp;</p><p>&nbsp;</p><p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ebe65390618f8f25415398c369912108d\"><span style=\"background-color:transparent;color:#000000;\">Assists in policy-making and operations</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ede66e4e928f542aca4c2cf76085982fd\"><span style=\"background-color:transparent;color:#000000;\">Oversees regional para-sports initiatives</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e82c4d5657da90564c2316ce9bea5f646\"><span style=\"background-color:transparent;color:#000000;\">Guides event and competition planning</span></li></ul>', 'mohammad-nasirul-islam-vice-president--2', 'committee_members/3/images/committee_member_image_6972692e7bea9.jpg', 3, 1, '2025-12-13 08:56:32', '2026-01-22 12:15:10', NULL, 1),
(4, 'Dr. Maruf Ahmed Mridul', 'Secretary General', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;</strong>As Secretary General, Dr. Maruf Ahmed Mridul manages day-to-day operations and ensures the effective execution of NPC Bangladesh’s mission and programs.</span></p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e4c2246acd3cb5e3e376596890aaab4a9\"><span style=\"background-color:transparent;color:#000000;\">Leads administration and communications</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e22b20dc7ab126b797b20159d7796ae02\"><span style=\"background-color:transparent;color:#000000;\">Coordinates with national and international bodies</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e716edb4749a7b62eea01646969e08ae1\"><span style=\"background-color:transparent;color:#000000;\">Implements strategic and operational decisions</span></li></ul>', 'dr.-maruf-ahmed-mridul-secretary-general', 'committee_members/4/images/committee_member_image_6972694d3709b.jpg', 4, 1, '2025-12-13 08:56:32', '2026-01-22 12:15:41', NULL, 1),
(5, 'Md. Sanuar Hossain', 'Joint Secretary General', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\">Md. Sanuar Hossain assists the Secretariat with administrative work and supports the coordination of national para-sports activities.</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e4748108cd68326ddeb413e432b705550\"><span style=\"background-color:transparent;color:#000000;\">Supports coordination of meetings and events</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e333bb4be3a6192bdee73323ff5b0354c\"><span style=\"background-color:transparent;color:#000000;\">Oversees communication flow within committees</span></li><li data-list-item-id=\"ecaec2c77520194ff3dbab0915a7c7c9b\"><span style=\"background-color:transparent;color:#000000;\">Assists Secretariat operations</span><br>&nbsp;</li></ul>', 'md.-sanuar-hossain-joint-secretary-general', 'committee_members/5/images/committee_member_image_6972695f52ce0.jpg', 5, 1, '2025-12-13 08:56:32', '2026-01-22 12:15:59', NULL, 1),
(6, 'Md. Asiful Hasan Masud', 'Treasurer', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\">&nbsp;Md. Asiful Hasan Masud ensures transparent financial management, budgeting, and resource allocation for NPC Bangladesh’s programs and events.</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e06bff94d806095434301b09c73c7ac1f\"><span style=\"background-color:transparent;color:#000000;\">Manages financial planning and reports</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e3e3a0e045211048d44408aa26bb8d58c\"><span style=\"background-color:transparent;color:#000000;\">Ensures compliance and transparency</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ef2c893778a9bf7c2adda2fa8956e7b15\"><span style=\"background-color:transparent;color:#000000;\">Oversees funding and budgeting</span></li></ul>', 'md.-asiful-hasan-masud-treasurer', 'committee_members/6/images/committee_member_image_69726a21aa0c7.png', 6, 1, '2025-12-13 08:56:32', '2026-01-22 12:19:13', NULL, 1),
(7, 'Dr. Mohammad Sohrab', 'Member-1', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span></p><p><span style=\"background-color:transparent;color:#000000;\">Dr. Mohammad Sohrab contributes his expertise to organizational planning and para-sports development in Bangladesh.</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e2917fee458f27c8fe175bd9129c33e3a\"><span style=\"background-color:transparent;color:#000000;\">Supports technical and medical guidance</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"eea164ae6565a03a1da0adcc5f3e2c9a6\"><span style=\"background-color:transparent;color:#000000;\">Advises on athlete welfare</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e22a6a8d68bbd2676b31a7354566cad9d\"><span style=\"background-color:transparent;color:#000000;\">Assists in program design</span></li></ul>', 'dr.-mohammad-sohrab-member-1', 'committee_members/7/images/committee_member_image_69726a3a45e75.jpg', 7, 1, '2025-12-13 08:56:32', '2026-01-22 12:19:38', NULL, 1),
(8, 'Md. Saif Uddin', 'Member-2', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;</strong>Md. Saif Uddin works closely with the leadership to strengthen community outreach and promote inclusive sports opportunities.</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ee32addb3dfbf2870bbee222bf9e4a0f6\"><span style=\"background-color:transparent;color:#000000;\">Supports local-level sports initiatives</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ec1aba4cac2ecf5f713eade481a0a806d\"><span style=\"background-color:transparent;color:#000000;\">Helps coordinate community programs</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"eb7cf1bafd31bc252a830d3b715c46b7c\"><span style=\"background-color:transparent;color:#000000;\">Assists leadership in event operations</span></li></ul>', 'md.-saif-uddin-member-2', 'committee_members/8/images/committee_member_image_69726b59619a1.jpg', 8, 1, '2025-12-13 08:56:32', '2026-01-22 12:24:25', NULL, 1),
(9, 'Mir Enayet Hossain', 'Member-3', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\">Mir Enayet Hossain plays an important role in supporting organizational decisions and program growth within NPC Bangladesh..</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"eb3a854411905822979244207cf82003e\"><span style=\"background-color:transparent;color:#000000;\">Assists in planning and organizing events</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e8dfc670f1721fd82b55a8554e3297bf1\"><span style=\"background-color:transparent;color:#000000;\">Supports administrative activities</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"eda4f1b6156b4c4a2c7be099c85a90e9e\"><span style=\"background-color:transparent;color:#000000;\">Works to promote para-sports engagement</span></li></ul>', 'mir-enayet-hossain-member-3', 'committee_members/9/images/committee_member_image_69726b71b5985.jpg', 9, 1, '2025-12-13 08:56:32', '2026-01-22 12:24:49', NULL, 1),
(10, 'Md. Hedaetul Aziz (Monna)', 'Member-4', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\">Md. Hedaetul Aziz (Monna) contributes to operational decision-making and works to ensure strong regional representation in para-sports.</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e958714d258c6ea64008359b73ef0e453\"><span style=\"background-color:transparent;color:#000000;\">Works with regional coordinators</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e1b229dcd88816dd8be9f13606bb6a3a1\"><span style=\"background-color:transparent;color:#000000;\">Supports competition management</span></li><li data-list-item-id=\"e757f29fd770f319aab6c1e3d3b7674ed\"><span style=\"background-color:transparent;color:#000000;\">Promotes inclusivity and athlete access</span><br>&nbsp;</li></ul>', 'md.-hedaetul-aziz-(monna)-member-4', 'committee_members/10/images/committee_member_image_69726b81ab684.jpg', 10, 1, '2025-12-13 08:56:32', '2026-01-22 12:25:05', NULL, 1),
(11, 'Pappu Lal Modak', 'Member-5', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\">&nbsp;Pappu Lal Modak assists with community programs and provides support to national para-sport events.</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"edbe61f1bbfeb1574952a1a41f6bfea05\"><span style=\"background-color:transparent;color:#000000;\">Helps organize national competitions</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"eaee6f2bf1d9f54b73fec91a438a0cb06\"><span style=\"background-color:transparent;color:#000000;\">Supports grassroots sports activities</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ee5c88ee926d4324593f415a2d3c2b000\"><span style=\"background-color:transparent;color:#000000;\">Works with athlete outreach teams</span></li></ul>', 'pappu-lal-modak-member-5', 'committee_members/11/images/committee_member_image_69726b927e0b7.jpg', 11, 1, '2025-12-13 08:56:32', '2026-01-22 12:25:22', NULL, 1),
(12, 'Md. Anwar Kabir Chowdhury', 'Member-6', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br>Md. Anwar Kabir Chowdhury<span style=\"background-color:transparent;color:#000000;\"> is dedicated to promoting awareness and helping NPC Bangladesh expand its networks.</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ec1a26172f1253f4b692eb152b41e75ea\"><span style=\"background-color:transparent;color:#000000;\">Strengthens stakeholder relationships</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ed699205b092b21094fb9811c38b91fbd\"><span style=\"background-color:transparent;color:#000000;\">Supports awareness and communication initiatives</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e3d546f7ba5c1df42e0ea4980ea6f75d3\"><span style=\"background-color:transparent;color:#000000;\">Assists in organizing events</span></li></ul>', 'md.-anwar-kabir-chowdhury-member-6', 'committee_members/12/images/committee_member_image_69726ba32edfc.jpg', 12, 1, '2025-12-13 08:56:32', '2026-01-22 12:25:39', NULL, 1),
(13, 'Salim Rahman', 'Member-7', '<p><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Bio:</strong></span><br><span style=\"background-color:transparent;color:#000000;\">&nbsp;Salim Rahman plays a key role in supporting organizational activities and promoting para-sports development.</span></p><p>&nbsp;</p><p><br><span style=\"background-color:transparent;color:#000000;\"><strong>&nbsp;Responsibilities:</strong></span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e1b2e44b2daa34d3cac23af3b3db286df\"><span style=\"background-color:transparent;color:#000000;\">Helps with event planning and execution</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ee4c34e74c683173c40d2a6759a36df0d\"><span style=\"background-color:transparent;color:#000000;\">Supports communication and outreach</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e96c1a061f2bc0525ea6821b59a669bd1\"><span style=\"background-color:transparent;color:#000000;\">Assists leadership in various administrative duties</span></li></ul>', 'salim-rahman-member-7', 'committee_members/13/images/committee_member_image_69726bb531ae1.jpg', 13, 1, '2025-12-13 08:56:32', '2026-01-22 12:25:57', NULL, 1),
(14, 'Md. Masudul Hassn', 'President', NULL, 'create-committee-member', 'committee_members/14/images/committee_member_image_6972690c79547.jpg', 1, 1, '2026-01-14 00:46:06', '2026-01-22 12:14:36', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '2=Previous,0=Running, 1=Upcoming',
  `event_scope` tinyint(1) DEFAULT 0 COMMENT '	0 = national, 1 = international, 2 = National Non-Sports Events',
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `createdBy` bigint(20) UNSIGNED NOT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_category_id`, `title`, `slug`, `description`, `featured_image`, `banner_image`, `start_date`, `end_date`, `type`, `event_scope`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(12, 2, 'Executive Committee Meeting', 'executive-committee-meeting', '<h2><strong>Executive Committee Meeting</strong></h2><p>&nbsp;</p><p>&nbsp;</p><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-100902-AM_1768056697.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-100902-AM-1_1768056739.jpeg\"></figure>', 'events/12/images/featured/featured_696267cb0fe24.jpeg', 'events/12/images/banner/banner_69626bdee7512.jpeg', '2025-02-02 03:00:00', NULL, 1, 0, '1', 1, 1, '2025-12-13 08:56:31', '2026-01-16 04:22:54'),
(31, 2, 'National Seminar on Para Sports', 'national-seminar-on-para-sports', '<p><span style=\"background-color:transparent;color:#262936;\">14 August 2025 | National Sports Council Auditorium, Dhaka</span></p><p><span style=\"background-color:transparent;color:#262936;\">The National Paralympic Committee (NPC Bangladesh), in collaboration with the Ministry of Youth and Sports, successfully conducted the National Seminar on Para Sports. Held at the National Sports Council Auditorium, the event brought together athletes, coaches, sports federations, and disability advocates to discuss the future roadmap for inclusive sports in the country.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Fostering Inclusion and Excellence</span></h4><p><span style=\"background-color:transparent;color:#262936;\">The seminar aimed to raise awareness about the professionalization of Para sports in Bangladesh. Discussions focused on bridging the gap between grassroots participation and international competition. Key stakeholders emphasized that Para sports are not merely recreational activities but a platform for national pride and athletic excellence.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Strategic Objectives for 2025-2026</span></h4><p><span style=\"background-color:transparent;color:#262936;\">The session highlighted several strategic priorities for NPC Bangladesh:</span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e62e4daee8ecb5b3f47b25e3eebd968d7\"><span style=\"background-color:transparent;color:#262936;\">Infrastructure Accessibility: Ensuring that national sports complexes are equipped with \"universal design\" features to accommodate athletes with various impairments.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e52996ec66eb72984c9eb0177eec56916\"><span style=\"background-color:transparent;color:#262936;\">Talent Identification: Launching a nationwide hunt for young talent to prepare for the Asian Youth Para Games and other major international qualifiers.</span></li></ul><h4><span style=\"background-color:transparent;color:#262936;\">Empowering the Next Generation</span></h4><p><span style=\"background-color:transparent;color:#262936;\">A highlight of the seminar was a panel discussion featuring veteran Para-athletes who shared their journeys of overcoming physical and social barriers. The Ministry of Youth and Sports reaffirmed its commitment to increasing budgetary allocations for Para sports and providing modern equipment to district-level sports associations.</span></p><p>&nbsp;</p><p>&nbsp;</p><p><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-18-at-53819-PM_1769024013.jpeg\"></p><p><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-18-at-53817-PM_1769024043.jpeg\"></p><p><br>&nbsp;</p>', 'events/31/images/featured/featured_69712a4c5c894.jpeg', NULL, NULL, NULL, 2, 2, '1', 1, 1, '2026-01-21 11:22:36', '2026-01-21 13:34:36'),
(32, 2, 'Para Athletics Training Camp', 'para-athletics-training_camp', '<p><span style=\"background-color:transparent;color:#262936;\">The journey toward international glory began with the Para Athletics Training Camp, held from September 3 to September 24, 2025. Hosted at the Bangladesh Krira Shikkha Protishthan (BKSP), the nation’s premier sports institute, this 21-day residential program focused on high-performance conditioning and technical mastery.</span></p><p><span style=\"background-color:transparent;color:#262936;\">Under the guidance of expert coaches, our athletes underwent rigorous physical preparation and skill-specific drills. This camp was a critical phase in the NPC Bangladesh\'s strategy to identify top talent and build the mental resilience required for elite competition. The intensive training provided at BKSP served as the primary engine for the record-breaking performances later seen on the world stage, proving that professional preparation is the heartbeat of athletic achievement.</span></p><p><br>&nbsp;</p>', 'events/32/images/featured/featured_69710ba74b0c7.png', NULL, NULL, NULL, 2, 2, '1', 1, 1, '2026-01-21 11:23:51', '2026-01-21 11:23:51'),
(33, 2, 'Classification in Para Sports', 'classification_in-para-sports', '<p><span style=\"background-color:transparent;color:#262936;\">13 October 2025 | National Stadium Conference Room</span></p><p><span style=\"background-color:transparent;color:#262936;\">The National Paralympic Committee (NPC Bangladesh) successfully hosted a pivotal seminar on Classification in Para Sports at the National Stadium. This event served as a critical educational platform for athletes, coaches, and sports administrators to understand the complex framework that ensures fairness and integrity across all Paralympic disciplines.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">The Backbone of Fair Play</span></h4><p><span style=\"background-color:transparent;color:#262936;\">Classification is the cornerstone of the Paralympic movement. It is the process by which athletes are grouped by the degree to which their impairment impacts their athletic performance. The primary goal is to ensure that winning is determined by an athlete’s skill, fitness, and power—not by the severity of their disability.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Highlights from the Session</span></h4><p><span style=\"background-color:transparent;color:#262936;\">Led by technical experts and medical professionals, the symposium covered the three essential steps of the Athlete Evaluation process:</span></p><ol><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e5419dcf445a6db671f12f3b67fdf691e\"><span style=\"background-color:transparent;color:#262936;\">Eligibility: Verifying the athlete has one of the ten recognized impairment types (such as impaired muscle power, limb deficiency, or vision impairment).</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ee02f489c78da0f965e047965e9d4d15d\"><span style=\"background-color:transparent;color:#262936;\">Minimum Impairment Criteria: Ensuring the impairment significantly affects sport-specific performance.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e54de4a61afdde65848df20ef1007f724\"><span style=\"background-color:transparent;color:#262936;\">Sport Class Allocation: Assigning athletes to a specific \"Sport Class\" (e.g., T11 for track athletes with total vision impairment or F57 for field athletes in seated positions) to ensure they compete against others with similar functional abilities.</span></li></ol><h4><span style=\"background-color:transparent;color:#262936;\">Advancing Bangladesh’s Para-Athletes</span></h4><p><span style=\"background-color:transparent;color:#262936;\">With the 2025 IPC Classification Code now in effect, this session was vital for our national preparation for upcoming international events, including the Asian Youth Para Games. By aligning our national standards with the International Paralympic Committee (IPC) guidelines, NPC Bangladesh remains committed to empowering our athletes to excel on the global stage through transparent and accurate classification.</span></p><p>&nbsp;</p><h4><span style=\"background-color:transparent;color:#262936;\">\"Proper classification is not just a rule; it is the guarantee of a level playing field for every dreamer with a disability.\" — NPC Bangladesh Secretariat.</span></h4><p><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-18-at-54253-PM_1769024264.jpeg\"></p>', 'events/33/images/featured/featured_69712b1e5407c.jpeg', NULL, NULL, NULL, 2, 2, '1', 1, 1, '2026-01-21 11:25:19', '2026-01-21 13:38:06'),
(34, 2, 'Amputee Football Training', 'amputee_football-training', '<p><span style=\"background-color:transparent;color:#262936;\">30 October – 6 November 2025 | Shaheed Farhan Faiyaz Playground, Dhaka</span></p><p><span style=\"background-color:transparent;color:#262936;\">The National Paralympic Committee (NPC Bangladesh) successfully concluded a specialized eight-day intensive training camp for amputee footballers. Held at the newly inaugurated Shaheed Farhan Faiyaz Playground—a dedicated facility for athletes with disabilities, this camp served as a major step toward professionalizing the sport in Bangladesh and preparing our national squad for the 2025 Asian Amputee Football Championship.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Specialized Coaching and Skill Building</span></h4><p><span style=\"background-color:transparent;color:#262936;\">Amputee football is a fast-paced and physically demanding sport that requires incredible upper-body strength and balance. The training sessions focused on technical mastery under the World Amputee Football Federation (WAFF) standards, including:</span></p><ol><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ec0e2f75bc67170a4645e9695818123a6\"><span style=\"background-color:transparent;color:#262936;\">Crutch Coordination: Mastering the \"three-point\" movement to allow for rapid acceleration and ball control without using the crutches to touch the ball.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e2e6645ba6bdc037f798e1e3cd9c73b0d\"><span style=\"background-color:transparent;color:#262936;\">One-Legged Technical Drills: Focusing on passing accuracy, shooting power, and spatial awareness for outfield players.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ed3de14b5bf63fb2bb1c8add6de09a46b\"><span style=\"background-color:transparent;color:#262936;\">Goalkeeper Training: Specialized drills for single-arm amputee goalkeepers to maximize agility and goal coverage within the penalty area.</span></li></ol><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-53357-PM_1769095205.jpeg\"></figure>', 'events/34/images/featured/featured_6972404f64d85.jpeg', NULL, NULL, NULL, 2, 2, '1', 1, 1, '2026-01-21 11:26:27', '2026-01-22 09:20:47'),
(35, 2, '25-day Training Program in 7 Sports Disciplines', '25-day-training-program-in-7-sports-disciplines', '<p><span style=\"background-color:transparent;color:#262936;\">12 November – 7 December 2025 | Savar, Mirpur, Tongi &amp; Dhaka</span></p><p><span style=\"background-color:transparent;color:#262936;\">NPC Bangladesh successfully concluded a landmark 25-day high-performance training camp across seven sports disciplines. This comprehensive program was designed to sharpen the technical skills and physical conditioning of our elite Para-athletes as they prepare for major international competitions in 2026.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Specialized Venues &amp; Disciplines</span></h4><p><span style=\"background-color:transparent;color:#262936;\">To ensure world-class standards, training was decentralized across the nation’s premier sporting hubs:</span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"edc9aead7f7810a045f97d699d1f2cb90\"><span style=\"background-color:transparent;color:#262936;\">Archery: Hosted at the Archery Training Center, Tongi, focusing on precision and technical form.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ecf18508d64b81567453ab3009e717d92\"><span style=\"background-color:transparent;color:#262936;\">Athletics &amp; Wheelchair Basketball: Conducted at the Bangladesh Institute of Sports Education (BKSP), Savar, utilizing their professional tracks and courts.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ee2696e908bfd0bdfcec9e0024fc76db9\"><span style=\"background-color:transparent;color:#262936;\">Swimming: Held at the Syed Nazrul Islam National Swimming Complex, Mirpur, for stroke refinement and endurance.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e9c75b796b107ff486a27a3361b04c641\"><span style=\"background-color:transparent;color:#262936;\">Badminton &amp; Table Tennis: Athletes gathered at the Shaheed Tajuddin Ahmed Indoor Stadium for agility and tactical drills.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ebf68cfca2537554080a2e0098acd372d\"><span style=\"background-color:transparent;color:#262936;\">Taekwondo: Specialized training was held at the Taekwondo Federation Indoor Hall.</span></li></ul><h4><span style=\"background-color:transparent;color:#262936;\">Impact and Development</span></h4><p><span style=\"background-color:transparent;color:#262936;\">This 25-day initiative provided athletes with access to expert coaching, modern equipment, and scientific training methods. By training at BKSP and other national federations, our Para-athletes benefited from an elite environment that fostered both individual growth and team unity. This program serves as a vital foundation for the upcoming Asian Para Games selection process.</span></p><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-09-at-102114-AM-1_1769094936.jpeg\"></figure><p><br>&nbsp;</p>', 'events/35/images/featured/featured_69723f6a6d062.jpeg', NULL, NULL, NULL, 2, 2, '1', 1, 1, '2026-01-21 11:28:06', '2026-01-22 09:16:58'),
(36, 2, '34th International Day of Persons with Disabilities and 27th National Disability Day 2025', '34th-international-day-of-persons-with-disabilities-and-27th-national-disability-day_2025', '<p><span style=\"background-color:transparent;color:#262936;\">3 December 2025 | BCB Academy Building, Sher-e-Bangla National Cricket Stadium, Mirpur</span></p><p><span style=\"background-color:transparent;color:#262936;\">NPC Bangladesh joined the global community in celebrating the 34th International Day of Persons with Disabilities and the 27th National Disability Day. This year’s event was held at the prestigious BCB Academy Building, symbolizing the powerful intersection of sports and social inclusion.</span></p><p><span style=\"background-color:transparent;color:#262936;\">The celebration highlighted that true social progress can only be achieved when the rights and leadership of persons with disabilities are at the center of national development. The gathering at the Bangladesh Cricket Board (BCB) premises served as a reminder that sports are a universal language that can dismantle barriers and challenge stereotypes.</span></p><p><br>&nbsp;</p><figure class=\"image\"><img src=\"/public//storage/uploads/IMG_4081_1768829639_1769094209.jpg\"></figure>', 'events/36/images/featured/featured_69723d594ad52.jpg', NULL, NULL, NULL, 2, 2, '1', 1, 1, '2026-01-21 11:32:34', '2026-01-22 09:08:09'),
(37, 2, 'Gwangju 2025 World Archery Para Championships', 'gwangju-2025-world-archery-para-championships', '<p><span style=\"background-color:transparent;color:#262936;\">22–28 September 2025 | Gwangju, Republic of Korea</span></p><p><span style=\"background-color:transparent;color:#262936;\">Bangladesh proudly marked its presence on the world stage at the 2025 World Archery Para Championships in Gwangju, Korea. Competing among 239 elite archers from 47 nations, our three-member athlete delegation demonstrated exceptional resilience and technical skill, further establishing Bangladesh as a rising force in international Para-archery.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Historical Performance: A Semifinal Breakthrough</span></h4><p><span style=\"background-color:transparent;color:#262936;\">The highlight of the championship was the stellar performance of our top-ranked archer, who successfully navigated through the elimination rounds to reach the semifinals. This achievement represents a historic milestone for NPC Bangladesh, marking the first time a Bangladeshi Para-archer has advanced to the final four in a World Championship setting.</span></p><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-53527-PM-1_1769093984.jpeg\"></figure><p><br>&nbsp;</p>', 'events/37/images/featured/featured_69712be833f49.png', NULL, NULL, NULL, 2, 1, '1', 1, 1, '2026-01-21 11:51:27', '2026-01-22 08:59:55'),
(38, 2, 'World Para Athletics Championship New Delhi 2025', 'world-para-athletics-championship-new-delhi-2025', '<p><span style=\"background-color:transparent;color:#262936;\">27 September – 5 October 2025 | Jawaharlal Nehru Stadium, New Delhi, India</span></p><p><span style=\"background-color:transparent;color:#262936;\">Bangladesh proudly participated in the 12th edition of the World Para Athletics Championships, joining over 2,000 athletes from 104 nations. Competing at the iconic Jawaharlal Nehru Stadium, our three-athlete delegation showcased remarkable grit and competitive spirit on one of the world’s most prestigious stages for Para-sports.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">National Milestone: 7th in the World</span></h4><p><span style=\"background-color:transparent;color:#262936;\">The championship was highlighted by a historic performance from Md Selim Reza in the Men’s High Jump T44 event. Competing against a world-class field, Selim Reza cleared a height of 1.79m to secure 7th place globally. In doing so, he also set a new Personal Best (PB), demonstrating the continuous growth of Bangladesh\'s technical standards in vertical jumps.</span></p><p><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-55043-PM_1769093896.jpeg\" width=\"521\" height=\"1156\"></p><p><br>&nbsp;</p>', 'events/38/images/featured/featured_69712c79e42c5.jpeg', NULL, NULL, NULL, 2, 1, '1', 1, 1, '2026-01-21 11:52:08', '2026-01-22 08:58:31'),
(39, 2, 'Japan Para Badminton International 2025', 'japan-para-badminton-international-2025', '<p><span style=\"background-color:transparent;color:#262936;\">24 October – 10 November 2025 | Shizuoka &amp; Tokyo, Japan</span></p><p><span style=\"background-color:transparent;color:#262936;\">Bangladesh achieved a significant breakthrough on the international circuit at the HULIC DAIHATSU Japan Para Badminton International 2025. Competing against a formidable field of world-class shuttlers, our two-member athlete delegation demonstrated exceptional skill and determination, further cementing Bangladesh\'s presence in the global Para-badminton arena.</span></p><h4><span style=\"background-color:transparent;color:hsl(0,0%,0%);\">Bronze Medal Success</span></h4><p><span style=\"background-color:transparent;color:#262936;\">The tournament was highlighted by a historic podium finish, with one of our elite athletes securing the Bronze Medal. This achievement is particularly noteworthy as the Japan International is a Tier-2 sanctioned event on the BWF Para Badminton World Circuit, attracting top-seeded players from powerhouse nations like Japan, India, and Indonesia.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Highlights:</span></h4><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e4f2792ac71cd3e01f05761b16a232c3b\"><span style=\"background-color:transparent;color:#262936;\">Athletes Representing Bangladesh: 2</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e6b91abc8a5390e06cde4f63d186237b3\"><span style=\"background-color:transparent;color:#262936;\">Major Achievement: 1 Bronze Medal (Individual/Doubles category).</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e6c5cfa372cf6506d1fc277b7159c1cf7\"><span style=\"background-color:transparent;color:#262936;\">Level of Competition: Our athletes faced rigorous matches at the Kusanagi Sports Complex, adapting to high-speed international play and technical floor conditions.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e80cd3d2720180e4e25b9322af554f6a2\"><span style=\"background-color:transparent;color:#262936;\">Strategic Growth: This medal follows our continued development in the sport, building on the foundations of the Bangladesh-Japan Friendship Para Badminton initiatives.</span></li></ul><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-53729-PM_1769091705.jpeg\"></figure>', 'events/39/images/featured/featured_69712dcad6161.png', NULL, NULL, NULL, 2, 1, '1', 1, 1, '2026-01-21 11:53:34', '2026-01-22 08:21:55'),
(40, 2, 'Chefs de Mission Seminar Aichi-Nagoya 2026 Asian Para Games', 'chefs-de-mission-seminar-aichi-nagoya-2026-asian-para-games', '<p><span style=\"background-color:transparent;color:#262936;\">27–30 October 2025 | Nagoya, Japan</span></p><p><span style=\"background-color:transparent;color:#262936;\">As the \"One Year to Go\" countdown began for the 5th Asian Para Games, two representatives from NPC Bangladesh joined delegates from 31 National Paralympic Committees in Japan for the official Chefs de Mission (CDM) Seminar. This high-level gathering was the first major milestone in ensuring that our national contingent is fully prepared for the games, which will be held from 18–24 October 2026.</span></p><p><span style=\"background-color:transparent;color:#262936;\">During the four-day seminar, our representatives engaged in detailed briefings with the Aichi-Nagoya Asian Games Organising Committee (AINAGOC) and the Asian Paralympic Committee (APC). Key focus areas included:</span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ed108487f3bc6724a1bb480688b8b5907\"><span style=\"background-color:transparent;color:#262936;\">Operational Logistics: Updates on accreditation, transport, and the innovative \"floating village\" accommodation concepts.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e5b8196b402c9b8dfee2393aa4e36045a\"><span style=\"background-color:transparent;color:#262936;\">Venue Inspections: Direct visits to the Paloma Mizuho Stadium (Para Athletics and Ceremonies) and the newly built Aichi International Arena.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ec0e260d1e009aff02af998228af030e6\"><span style=\"background-color:transparent;color:#262936;\">Classification &amp; Competition: Finalizing sport-specific entry timelines and reviewing the latest classification requirements to ensure our athletes meet all international standards.</span></li></ul><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-53249-PM_1769093642.jpeg\"></figure>', 'events/40/images/featured/featured_69712def443ff.jpeg', NULL, NULL, NULL, 2, 1, '1', 1, 1, '2026-01-21 11:54:24', '2026-01-22 08:54:21'),
(41, 2, 'Dubai 2025 Asian Youth Para Games', 'dubai-2025-asian-youth-para-games', '<p><span style=\"background-color:transparent;color:#262936;\">Bangladesh celebrated its most successful international campaign at the 5th Asian Youth Para Games. A determined contingent of 25 athletes represented the nation, securing a historic total of 5 medals (3 Gold, 2 Bronze) against elite competition from across Asia.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Performance Highlights:</span></h4><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ea6be359857f02cb8593001ddd86830c2\"><span style=\"background-color:transparent;color:#262936;\">Chaiti Rani Deb (Athletics): Delivered a standout performance, winning two Gold medals in the Girls’ Javelin Throw and the 100m Sprint.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e511db9a6e61bc6c741c5021cdf3a188e\"><span style=\"background-color:transparent;color:#262936;\">Mohammad Shahidullah (Swimming): Displayed incredible speed in the pool, clinching Gold in the 50m Freestyle and Bronze in the 100m Freestyle.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e0f51648ee83f1e49fc8c6cba70acaaa2\"><span style=\"background-color:transparent;color:#262936;\">Team Success: Our youth athletes showed immense growth, contributing to a final tally that placed Bangladesh among the top performing emerging nations.</span></li></ul><h4><span style=\"background-color:transparent;color:#262936;\">A New Era for Bangladesh</span></h4><p><span style=\"background-color:transparent;color:#262936;\">This milestone achievement reflects the success of our recent intensive training programs at BKSP. By ranking 20th overall, these young ambassadors have proven that Bangladesh is a rising power in Para sports. NPC Bangladesh remains committed to nurturing this \"Golden Generation\" as they transition toward the senior international circuit and the 2026 Asian Para Games.</span></p><p>&nbsp;</p><h4><span style=\"background-color:transparent;color:#262936;\">\"Our youth have redefined what is possible, bringing home glory and proving that talent knows no boundaries.\" — NPC Bangladesh Secretariat.</span></h4><figure class=\"image image_resized\" style=\"width:100%;\"><img style=\"aspect-ratio:500/279;\" src=\"/public//storage/uploads/STRIDE-1_1769093726.png\" width=\"500\" height=\"279\"></figure>', 'events/41/images/featured/featured_69712e3be6195.png', NULL, NULL, NULL, 2, 1, '1', 1, 1, '2026-01-21 11:55:35', '2026-01-22 08:56:02'),
(42, 2, 'Physically Challenged Cricket Trial and Selection Camp', 'physically-challenged-cricket-trial-and-selection-camp', '<p><span style=\"background-color:transparent;color:#000000;\">19–20 August 2025 | Bashundhara Arena Indoor Cricket Complex, Dhaka</span></p><p><span style=\"background-color:transparent;color:#000000;\">As part of the \"Celebrating Youth Festival 2025,\" NPC Bangladesh organized a two-day Physically Challenged Cricket Trial and Selection Camp. This initiative aimed to scout high-potential talent from all eight divisions to strengthen the national pipeline for specially-abled cricket.</span></p><p><span style=\"background-color:transparent;color:#000000;\">The camp was held at the state-of-the-art Bashundhara Arena, giving participants access to world-class seven-lane AstroTurf, advanced bowling machines, and video analysis support. To inspire the young cricketers, several icons of Bangladesh cricket visited the sessions:</span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e9054c74b584b8e46cdb3a2d143fa833b\"><span style=\"background-color:transparent;color:#000000;\">Tamim Iqbal and Habibul Bashar attended the opening day to encourage players from the Chattogram, Khulna, Rajshahi, and Mymensingh divisions.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e61d65083947ed7d07d44c5619255046a\"><span style=\"background-color:transparent;color:#000000;\">Mushfiqur Rahim visited on the second day, praising the professional infrastructure and the passion of the athletes.&nbsp;</span></li></ul><p><span style=\"background-color:transparent;color:#000000;\">The selection focused on technical proficiency and game awareness. Athletes were evaluated for their ability to adapt standard cricket mechanics to their unique physical profiles. The top performers identified during these trials will form the core of the national youth pool, receiving specialized long-term training to represent Bangladesh on the international stage.</span></p><p><br>&nbsp;</p><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-54950-PM-5_1769100802.jpeg\"></figure>', 'events/42/images/featured/featured_6972560f51c97.jpeg', NULL, NULL, NULL, 2, 0, '1', 1, 1, '2026-01-21 13:03:35', '2026-01-22 10:53:35'),
(43, 2, 'National Para Badminton Championship 2025', 'national-para-badminton-championship-2025', '<p><span style=\"background-color:transparent;color:#000000;\">21–22 August 2025 | Shaheed Tajuddin Ahmad Indoor Stadium, Dhaka</span></p><p><span style=\"background-color:transparent;color:#000000;\">The National Para Badminton Championship 2025 was successfully held at the Shaheed Tajuddin Ahmad Indoor Stadium, showcasing the high level of skill and competitiveness among the nation\'s best para-shuttlers. Organized by the National Paralympic Committee of Bangladesh, the event served as a major platform for athletes to vie for national titles and ranking points.</span></p><p><span style=\"background-color:transparent;color:#000000;\">The championship featured matches across various international classifications defined by the Badminton World Federation (BWF):</span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e45c7f91445294b962c8f70f5f8c22d13\"><span style=\"background-color:transparent;color:#000000;\">Wheelchair Classes (WH1–WH2): Demonstrating incredible upper-body strength and tactical maneuvering.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e0c66527eedd4b62af3aabc719d047395\"><span style=\"background-color:transparent;color:#000000;\">Standing Classes (SL3–SL4, SU5): Fast-paced matches emphasizing agility, balance, and rapid court coverage.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e8703aab5369c3bcd69e25842b85c7c39\"><span style=\"background-color:transparent;color:#000000;\">Short Stature Class (SH6): High-energy rallies showcasing technical precision and speed.</span></li></ul><p><span style=\"background-color:transparent;color:#000000;\">This tournament was a critical component of the national selection process for the Japan Para Badminton International 2025 and the upcoming 2026 Asian Para Games. Coaches and technical officials monitored the performance of 60+ athletes to identify top talent for the high-performance training camps at BKSP. The event also highlighted the growth of the sport in Bangladesh, with a significant increase in youth participation compared to previous years.</span></p><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-54211-PM-11_1769100669.jpeg\"></figure>', 'events/43/images/featured/featured_6972558d05974.jpeg', NULL, NULL, NULL, 2, 0, '1', 1, 1, '2026-01-21 13:05:36', '2026-01-22 10:51:25'),
(44, 2, 'National Para Table Tennis Championship 2025', 'national-para-table-tennis-championship-2025', '<p><span style=\"background-color:transparent;color:#000000;\">4–5 September 2025 | Shaheed Tajuddin Ahmad Indoor Stadium, Dhaka</span></p><p><span style=\"background-color:transparent;color:#000000;\">The National Para Table Tennis Championship 2025 was successfully held at the Shaheed Tajuddin Ahmad Indoor Stadium, bringing together the nation’s finest para-paddlers. This two-day event served as a critical platform for athletes to demonstrate their agility, precision, and competitive drive in a professional setting.</span></p><p><span style=\"background-color:transparent;color:#000000;\">In accordance with ITTF Para Table Tennis regulations, the tournament featured multiple categories to ensure fair competition based on functional ability:</span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"eddf809c9228aef38c97666ecc952183a\"><span style=\"background-color:transparent;color:#000000;\">Wheelchair Classes (1–5): Intense matches showcasing rapid chair movement and tactical ball placement.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"eb8b38aa32385af9565e89e50b632f88f\"><span style=\"background-color:transparent;color:#000000;\">Standing Classes (6–10): High-speed rallies emphasizing balance and reflex speed.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ecc4252ead62bb4a1bc90d3abd7770f9d\"><span style=\"background-color:transparent;color:#000000;\">Intellectual Impairment Class (11): Focusing on technical consistency and mental focus.</span></li></ul><p><span style=\"background-color:transparent;color:#000000;\">The championship was not only a battle for national titles but also a key selection trial for the 2026 Asian Para Games in Japan. Technical observers from NPC Bangladesh monitored the performances to identify a core group of players for an upcoming advanced training camp. The high level of skill displayed by our youth players.</span></p><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-54401-PM-12_1769100558.jpeg\"></figure>', 'events/44/images/featured/featured_6972551aae2f3.jpeg', NULL, NULL, NULL, 2, 0, '1', 1, 1, '2026-01-21 13:08:32', '2026-01-22 10:49:30'),
(45, 2, 'National Wheelchair Basketball Championship 2025', 'national-wheelchair-basketball-championship-2025', '<p><span style=\"background-color:transparent;color:#000000;\">15–16 September 2025 | CRP, Chapain, Savar</span></p><p><span style=\"background-color:transparent;color:#000000;\">The National Wheelchair Basketball Championship 2025 was successfully held at the Centre for the Rehabilitation of the Paralysed (CRP) in Savar. Organized by NPC Bangladesh in collaboration with CRP, the tournament brought together the country’s top wheelchair basketball teams for two days of intense, high-speed competition.</span></p><p><span style=\"background-color:transparent;color:#000000;\">As the pioneer institution for spinal cord injury rehabilitation in Bangladesh, CRP provided the ideal world-class basketball facility for this event. The tournament utilized specialized sports wheelchairs and followed International Wheelchair Basketball Federation (IWBF) standards, ensuring that our athletes competed under global regulations.</span></p><h4><span style=\"background-color:transparent;color:#000000;\">Highlights</span></h4><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e8b90a3bce317111f8b043c0fa042ee0f\"><span style=\"background-color:transparent;color:#000000;\">Technical Excellence: Teams showcased advanced tactical play, including chair-to-chair picking and precision mid-range shooting.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e62897a95b09171ec6d33f93ab8c35117\"><span style=\"background-color:transparent;color:#000000;\">Selection for Aichi-Nagoya: Technical observers used the matches to evaluate players for the national pool in preparation for the 2026 Asian Para Games.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e7de097d6f6b0452aeddde7e0f4e9d834\"><span style=\"background-color:transparent;color:#000000;\">Community Spirit: The event served as a powerful demonstration of mobility and athletic empowerment, drawing a large crowd of supporters and fellow athletes.</span></li></ul><p><span style=\"background-color:transparent;color:#000000;\">This championship is part of a broader mission to professionalize wheelchair basketball in Bangladesh. By hosting the event at the CRP, NPC Bangladesh reinforced the link between rehabilitation and elite competitive sports, providing a platform for athletes to transition from recovery to national representation.</span></p><p><br>&nbsp;</p><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-54827-PM-1_1769100394.jpeg\"></figure>', 'events/45/images/featured/featured_69725479a3949.jpeg', NULL, NULL, NULL, 2, 0, '1', 1, 1, '2026-01-21 13:13:15', '2026-01-22 10:46:51'),
(46, 2, 'National Youth Para Games 2025', 'national-youth-para-games-2025', '<p><span style=\"background-color:transparent;color:#000000;\">10–11 October 2025 | Multiple Venues, Dhaka</span></p><p><span style=\"background-color:transparent;color:#000000;\">NPC Bangladesh successfully organized the National Youth Para Games, a premier multi-sport event aimed at identifying and nurturing the next generation of para-sporting talent. Over two action-packed days, hundreds of young athletes from across the country competed in three core disciplines, showcasing extraordinary skill and competitive spirit.</span></p><h3><span style=\"background-color:transparent;color:#000000;\">Venues and Disciplines</span></h3><p><span style=\"background-color:transparent;color:#000000;\">To provide a professional competition environment, the games were distributed across Dhaka’s top sports complexes:</span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e2da771eda58bf4c1f8d1177653e28b68\"><span style=\"background-color:transparent;color:#000000;\">Para Athletics: Held at the National Stadium, featuring track and field events including sprints, long jump, and javelin throw.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"e3a10d3241774155f53a343930bcc53b0\"><span style=\"background-color:transparent;color:#000000;\">Para Swimming: Hosted at the Syed Nazrul Islam National Swimming Complex, with events covering various distances in freestyle, backstroke, and breaststroke.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;\" data-list-item-id=\"ea1f7b32c38cc97cd7c7c2b2c0d4be363\"><span style=\"background-color:transparent;color:#000000;\">Para Taekwondo: Conducted at the National Taekwondo Federation Ground, focusing on <i>Kyorugi</i> (sparring) and <i>Poomsae</i> (forms).</span></li></ul><p>&nbsp;</p><p><span style=\"background-color:transparent;color:#000000;\">The primary objective of these Games was to scout high-potential athletes for the 2025 Asian Youth Para Games in Dubai. Technical committees conducted rigorous functional classifications during the event to ensure athletes were placed in the correct categories for fair competition.</span></p><p><span style=\"background-color:transparent;color:#000000;\">The record-breaking participation at this year\'s National Youth Para Games reflects the growing interest in inclusive sports and serves as a vital stepping stone for our athletes to transition from grassroots levels to the international podium.</span></p><p><br>&nbsp;</p><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-54055-PM-1_1769100264.jpeg\"></figure>', 'events/46/images/featured/featured_697253f0a8b24.jpeg', NULL, NULL, NULL, 2, 0, '1', 1, 1, '2026-01-21 13:16:12', '2026-01-22 10:44:32'),
(47, 2, 'National Amputee Football Carnival 2025', 'national-amputee-football-carnival-2025', '<p><span style=\"background-color:transparent;color:#262936;\">20 October 2025 | Shaheed Farhan Faiyaz Playground, Dhaka</span></p><p><span style=\"background-color:transparent;color:#262936;\">NPC Bangladesh successfully organized the National Amputee Football Carnival, a high-energy event dedicated to celebrating the agility and spirit of amputee footballers from across the country. Hosted at the Shaheed Farhan Faiyaz Playground, the carnival served as both a competitive tournament and a talent scouting platform for the national squad.</span></p><p><span style=\"background-color:transparent;color:#262936;\">The event featured fast-paced matches played under World Amputee Football Federation (WAFF) rules. Spectators witnessed remarkable displays of \"three-point\" movement coordination and powerful strikes. The carnival highlighted the unique technical aspects of the sport, where outfield players use metal crutches to move with incredible speed while maintaining precise ball control with their single functional leg.</span></p><p><span style=\"background-color:transparent;color:#262936;\">Highlights&nbsp;</span></p><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ed6315e0c5922229c4878a94b6183814c\"><span style=\"background-color:transparent;color:#262936;\">Mass Participation: The carnival brought together regional teams, fostering a sense of community and healthy competition among veteran players and newcomers.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e2554aa769c731ae91420105c33eac5e0\"><span style=\"background-color:transparent;color:#262936;\">Skill Showcases: In addition to the main tournament, individual skills challenges including \"Longest Kick\" and \"Precision Passing\"—were held to identify specialized talent.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"ed652860a82097bb5edd64967e6bc4f57\"><span style=\"background-color:transparent;color:#262936;\">National Selection: Technical observers used the matches to shortlist high-potential athletes for the intensive training camp held later in the month.</span></li></ul><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-53358-PM-1_1769096363.jpeg\"></figure>', 'events/47/images/featured/featured_697244e21f024.jpeg', NULL, NULL, NULL, 2, 0, '1', 1, 1, '2026-01-21 13:18:00', '2026-01-22 09:40:18'),
(49, 2, 'BCB–NPC Physically Challenged Cricket Tournament 2025', 'bcbnpc-physically-challenged-cricket-tournament-2025', '<p><span style=\"background-color:transparent;color:#262936;\">3–4 December 2025 | Pubergan Krira Shikkha Protishthan, Rupganj, Narayanganj</span></p><p><span style=\"background-color:transparent;color:#262936;\">To commemorate the 34th International Day of Persons with Disabilities, the Bangladesh Cricket Board (BCB) and NPC Bangladesh jointly organized a specialized T20 cricket tournament. Held at the Pubergan Krira Shikkha Protishthan in Narayanganj, the event showcased the immense talent and competitive spirit of cricketers with physical challenges from across the country.</span></p><p><span style=\"background-color:transparent;color:#262936;\">The tournament featured four regional teams competing in a knockout format. The matches were played under official International Council of Physically Challenged Cricket (ICPCC) regulations, ensuring a professional environment for all participants. The event served as a vital platform for national selectors to monitor the progress of players identified during the August trials at Bashundhara Arena.</span></p><h4><span style=\"background-color:transparent;color:#262936;\">Highlights:</span></h4><ul><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e324542e4a3629461ff97bfc9fb049391\"><span style=\"background-color:transparent;color:#262936;\">High-Intensity Competition: The final match saw a thrilling display of power-hitting and agile fielding, proving that physical impairment is no barrier to athletic brilliance.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e6a497a50f064fbc83acc94f18a047399\"><span style=\"background-color:transparent;color:#262936;\">Inclusive Partnership: The collaboration between the BCB and NPC Bangladesh highlights a unified commitment to integrating Para-cricket into the national mainstream.</span></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:#262936;\" data-list-item-id=\"e31d1070bb17d97857b083f829706cda0\"><span style=\"background-color:transparent;color:#262936;\">Community Impact: Beyond the scores, the tournament raised significant awareness in the Narayanganj district about the professional capabilities of athletes with disabilities.</span></li></ul><figure class=\"image\"><img src=\"/public//storage/uploads/WhatsApp-Image-2026-01-18-at-54719-PM_1769096059.jpeg\"></figure>', 'events/49/images/featured/featured_69724452e9be8.jpeg', NULL, NULL, NULL, 2, 0, '1', 1, 1, '2026-01-21 13:20:22', '2026-01-22 09:37:54');

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

CREATE TABLE `event_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `createdBy` bigint(20) UNSIGNED NOT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_categories`
--

INSERT INTO `event_categories` (`id`, `slug`, `parent_id`, `category_name`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `image`, `alt_name`, `sort_order`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'music', NULL, 'Music', 'Music related events and articles', 'Music', 'Latest Music news, updates, and events', 'concerts,live music,festivals', 'https://placehold.co/600x400?text=Music', 'Music Alt', 1, '0', 1, 1, '2025-12-13 08:56:31', '2026-01-18 13:58:15'),
(2, 'sports', NULL, 'Sports', 'Sports related events and articles', 'Sports', 'Latest Sports news, updates, and events', 'football,cricket,basketball', 'https://placehold.co/600x400?text=Sports', 'Sports Alt', 2, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(3, 'business', NULL, 'Business', 'Business related events and articles', 'Business', 'Latest Business news, updates, and events', 'corporate,entrepreneurship,markets', 'https://placehold.co/600x400?text=Business', 'Business Alt', 3, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(4, 'technology', NULL, 'Technology', 'Technology related events and articles', 'Technology', 'Latest Technology news, updates, and events', 'gadgets,innovation,startups', 'https://placehold.co/600x400?text=Technology', 'Technology Alt', 4, '0', 1, 1, '2025-12-13 08:56:31', '2026-01-18 13:58:22'),
(5, 'entertainment', NULL, 'Entertainment', 'Entertainment related events and articles', 'Entertainment', 'Latest Entertainment news, updates, and events', 'movies,music,celebrities', 'https://placehold.co/600x400?text=Entertainment', 'Entertainment Alt', 5, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(6, 'health', NULL, 'Health', 'Health related events and articles', 'Health', 'Latest Health news, updates, and events', 'wellness,fitness,medicine', 'https://placehold.co/600x400?text=Health', 'Health Alt', 6, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(7, 'lifestyle', NULL, 'Lifestyle', 'Lifestyle related events and articles', 'Lifestyle', 'Latest Lifestyle news, updates, and events', 'travel,food,culture', 'https://placehold.co/600x400?text=Lifestyle', 'Lifestyle Alt', 7, '0', 1, 1, '2025-12-13 08:56:31', '2026-01-18 13:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `thumb` varchar(100) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `scope` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = National, 1 = International, 2 = Non Sports',
  `createdBy` int(11) DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `name`, `thumb`, `alt_name`, `sort_order`, `status`, `scope`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'Para Sport Classification', 'gallery/thumbs/XU2MHJoAZuvsIC74jZPv01dx6wU7cPUyXkry6zjW.jpg', 'Para Sport Classification', 10, 1, 2, 1, NULL, '2025-12-13 08:56:31', '2026-01-24 01:41:51'),
(2, 'National Youth Para Games 2025', 'gallery/thumbs/s6L4pzY07xgadDA2M6F6gJxVTH19qKXWbJotSGwL.jpg', 'National Youth Para Games 2025', 15, 1, 0, 1, NULL, '2025-12-13 08:56:31', '2026-01-23 11:27:59'),
(3, 'National Wheelchair Basketball Championship 2025', 'gallery/thumbs/aMNYGo5FlqdPYmQbGQKBotI2viLo4m40ZvOLApgI.jpg', 'NATIONAL WHEELCHAIR BASKETBALL CHAMPIONSHIP 2025', 16, 1, 0, 1, NULL, '2025-12-13 08:56:31', '2026-01-24 01:08:07'),
(4, 'Para Swimming', 'gallery/thumbs/f4t72njJE9Tj4l4nfiuqCDqCxiSFmP30YAccbRny.jpg', 'Para Swimming', 0, 0, 0, 1, NULL, '2025-12-13 08:56:31', '2026-01-24 01:59:45'),
(5, 'National Para Table Tennis Championship 2025', 'gallery/thumbs/cetjka5Y3YdUcKpXoJOwrkL8ZDQwfySZYBlQI9JR.jpg', 'Table Tennis Training & Tournament Day 1', 18, 1, 0, NULL, NULL, '2025-12-26 00:17:22', '2026-01-23 11:25:27'),
(6, 'National Para Table Tennis Championship 2025 Day 2', 'gallery/6/thumbs/IyxjVFNTosDKCtDibrPnyGn8hdcpNbxndJkAeIli.jpg', 'Table Tennis Training & Tournament Day 2', 0, 0, 0, NULL, NULL, '2025-12-26 03:52:56', '2026-01-24 01:55:07'),
(7, 'Physically Challenged Cricket Trail and Selection Camp 2025', 'gallery/7/thumbs/swwEjnXTkzdAyn5bndjKUG8yca1NrlxIJhEVwbde.jpg', 'Physically Challenged Cricket Trail and Selection Camp 2025', 0, 0, 0, NULL, NULL, '2026-01-06 08:06:33', '2026-01-24 01:59:41'),
(8, 'National Para Badminton Championship 2025', 'gallery/8/thumbs/7wQkyoboJ2guL8dz4GgN6xUik4Y1ELXAJZV5S1hV.jpg', 'National Para Badminton Championship 2025', 19, 1, 0, NULL, NULL, '2026-01-06 08:38:23', '2026-01-23 11:24:00'),
(9, 'News Paper Cutting', 'gallery/9/thumbs/NwvpbW2pB0na7dM3KIz27S5ZzD6mQeW8A8w7Ycu7.jpg', 'News Paper Cutting', 21, 0, 0, NULL, NULL, '2026-01-06 09:23:29', '2026-01-24 01:42:12'),
(11, 'Chefs de Mission Seminar Aichi-Nagoya 2026 Asian Para Games', 'gallery/11/thumbs/s95DyKZWQZ0sFejkWpp31JKHsanz0eGbhks2pa57.jpg', 'Aichi-Nagoya 2026 Asian Para Games', 3, 1, 1, NULL, NULL, '2026-01-18 13:10:52', '2026-01-24 01:56:57'),
(12, 'Dubai 2025 Asian Youth Para Games', 'gallery/12/thumbs/0Gi9iBdafHmES9tt6ue8vRUPmYVujiEcSSqiFppx.jpg', 'Dubai 2025 Asian Youth Para Games', 2, 1, 1, NULL, NULL, '2026-01-18 13:16:00', '2026-01-24 01:57:16'),
(13, 'Gwangju 2025 World Archery Para Championships', 'gallery/13/thumbs/tr9H380zlhUDIdFqSgsrLi7AfzUSRO8R6CK64MzI.png', 'Gwangju 2025 World Archery Para Championships', 6, 1, 1, NULL, NULL, '2026-01-18 13:20:59', '2026-01-24 01:55:57'),
(14, 'World Para Athletics Championship New Delhi 2025', 'gallery/14/thumbs/96IUlyV301yNfOpZ89vqyl4Yx7UC7LD5bLD2jZJD.jpg', 'World Para Athletics Championship New Delhi 2025', 5, 1, 1, NULL, NULL, '2026-01-18 13:24:54', '2026-01-24 01:56:15'),
(15, 'Japan Para Badminton International 2025', 'gallery/15/thumbs/9f5lNpcl5SfMy8TDRrfby5N6LLbHh0x5FPgBhQxF.jpg', 'Japan Para Badminton International 2025', 4, 1, 1, NULL, NULL, '2026-01-18 13:33:23', '2026-01-24 01:56:35'),
(16, 'National Seminar on Para Sports', 'gallery/16/thumbs/5Adgzw1RRyamxztw7FVRjVA6OnEsPFqRgIFHrVtd.jpg', 'National Seminar on Para Sports', 12, 1, 2, NULL, NULL, '2026-01-19 02:57:04', '2026-01-24 01:39:40'),
(17, 'National Amputee Football Carnival', 'gallery/17/thumbs/RpFCFXJMSSEhM4L9BtdTDj957bRPAFsYfQ0nJd3o.jpg', 'National Amputee Football Carnival', 14, 1, 0, NULL, NULL, '2026-01-19 03:36:08', '2026-01-23 11:27:24'),
(21, 'Physically Challenged Cricket Trial and Selection Camp', 'gallery/21/thumbs/6Dnc4waTLUWooy6lwED0keYls8pNjDP8O8UGd2SW.jpg', 'Physically Challenged Cricket Trial and Selection Camp', 20, 1, 0, NULL, NULL, '2026-01-23 11:15:12', '2026-01-23 11:30:28'),
(22, 'BCB–NPC Physically Challenged Cricket Tournament', 'gallery/22/thumbs/nnW9qbSKacaiuGO15jsNVPnSxNsrBUJ64u2X32QL.jpg', 'BCB–NPC Physically Challenged Cricket Tournament', 13, 1, 0, NULL, NULL, '2026-01-23 11:30:06', '2026-01-23 11:30:31'),
(23, 'Para Athletics Training Camp', 'gallery/23/thumbs/buZXuPEoUadvCBh58iSztYCoRymZ096n9WHVJlu9.jpg', 'Para Athletics Training Camp', 11, 1, 2, NULL, NULL, '2026-01-23 11:39:09', '2026-01-24 01:39:23'),
(24, 'Amputee Football Training', 'gallery/24/thumbs/Xu3wZ2vRCf2kdA0Z3HisexrTrMFl8BCywGLu1kZS.jpg', 'Amputee Football Training', 9, 1, 0, NULL, NULL, '2026-01-24 01:44:37', '2026-01-28 22:43:59'),
(25, '25-day Training Program in 7 Sports Disciplines', 'gallery/25/thumbs/YsYu4AjlEoqb5eM0wBSTdoRlZApHhU9td4s6yNJs.jpg', '25-day Training Program in 7 Sports Disciplines', 8, 1, 2, NULL, NULL, '2026-01-24 01:49:25', '2026-01-28 23:42:53'),
(26, '34th International Day of Persons with Disabilities and 27th National Disability Day 2025', 'gallery/26/thumbs/vgXm850QKFZVYc6vw5Hv12cj6Avg6QuA8co2WfYh.jpg', '34th International Day of Persons with Disabilities and 27th National Disability Day 2025', 7, 1, 2, NULL, NULL, '2026-01-24 01:50:54', '2026-01-28 23:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_details`
--

CREATE TABLE `gallery_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallery_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(155) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_details`
--

INSERT INTO `gallery_details` (`id`, `gallery_id`, `image`, `alt_name`, `sort_order`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(35, 1, 'gallery/details/EpUofGnY5rTaOv9DKBi4vOP1dLx7BP8XOUYi8EqB.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:05:50', '2025-12-25 23:40:34'),
(36, 1, 'gallery/details/UxoBXcw9yYa4esMI11809cboL26QAX6daSyhoqYO.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:06:40', '2025-12-25 23:40:49'),
(37, 1, 'gallery/details/q6fbAv8jJaCNwEuQK4KZYlo0fgTwGMdMJN2rrbGQ.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:07:42', '2025-12-25 23:40:55'),
(38, 1, 'gallery/details/uEwFftjxlMBVfaZTC1oqBtq9br5De9WtcAyg4NfU.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:08:01', '2025-12-25 23:40:42'),
(39, 1, 'gallery/details/PXTq8FUjl1hIXYUfzRsBTvBUe1ErmA6642bNVPfS.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:08:15', '2025-12-25 23:41:02'),
(40, 1, 'gallery/details/cZ3CSYwV1yqR8KajfM4yIysL2Ayc8tTSZEe3xeML.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:08:32', '2025-12-25 23:41:16'),
(41, 1, 'gallery/details/ngtRTRR0HcjvvLxL0aQPOFa0BCJ8gbr0z4mEpTEB.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:09:04', '2025-12-25 23:41:11'),
(42, 1, 'gallery/details/26WAbvYl0d6Hk21xnDSE41Ig6KPo98GazI5YXBYE.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:09:22', '2025-12-25 23:41:06'),
(43, 1, 'gallery/details/Tcy2OHButQFdPK4acNKboLmWCXYy6gBEWZTGYo65.jpg', 'Para Sport Classification', 0, 1, NULL, '2025-12-25 09:09:52', '2025-12-25 23:41:22'),
(100, 4, 'gallery/details/ZrcNoqiwz28MtvxOcuIXrpmNFK2Xe0YfiwhwCRM1.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:56:27', '2025-12-25 23:56:27'),
(101, 4, 'gallery/details/vqPqB73UMpHrpfYHo1R7O41JnM11unxjAVxTHUZS.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:56:47', '2025-12-25 23:56:47'),
(102, 4, 'gallery/details/zUuCMiWBoiE8M9DvKMAlPromQ3yskJHsxEmKMvW1.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:56:57', '2025-12-26 00:05:34'),
(103, 4, 'gallery/details/ehd99ssSqsubaOYIzRaYeKriWufeyob4tLpj5kL2.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:57:10', '2025-12-26 00:05:42'),
(104, 4, 'gallery/details/Ca3vJZzdxFBVvR5ioQgYnrvhKmDCsA7XuzDYHtU9.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:57:25', '2025-12-26 00:05:28'),
(105, 4, 'gallery/details/ogHSs91b5LBqILWurgH3QVuxayw1NZ8bUq50R0Jm.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:59:03', '2025-12-25 23:59:03'),
(106, 4, 'gallery/details/7RFUNR7z76GmsxMmQ7rWAswhF3vGa8KxXRCe4W0g.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:59:28', '2025-12-25 23:59:28'),
(107, 4, 'gallery/details/63Yt3k8WVNBSjpiIYBvVZmIuQhAGmpo0oP0stAiv.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:59:46', '2025-12-26 00:05:23'),
(108, 4, 'gallery/details/Elxw0TbLB6F9jHxXIwfBD54qLahjmb4Y6BNEtjMn.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-25 23:59:57', '2025-12-26 00:05:17'),
(109, 4, 'gallery/details/ScVl7EisKUdFO32tCP3SXVu3lkWgMSBuTGMWmpLA.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:00:10', '2025-12-26 00:05:12'),
(111, 4, 'gallery/details/JQ5wgOdbQG5DIv6oRTBnnjGOguRHjVdM4l4USi9d.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:01:17', '2025-12-26 00:01:17'),
(112, 4, 'gallery/details/JmCirAvoP715b7vz4EfdmlcLcRkUGttxkqo1mAR5.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:01:43', '2025-12-26 00:01:43'),
(113, 4, 'gallery/details/fqqLmwxRHmM3WqpMpKQhxcpKZrcr6zkBR0Dbsyy9.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:02:04', '2025-12-26 00:02:04'),
(114, 4, 'gallery/details/eozYFf44MKf9wF1BzYMgUp4WxV7G8M5zlRKyH2bu.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:02:38', '2025-12-26 00:02:38'),
(115, 4, 'gallery/details/yGrYaDzujpxJ1yRvZT55p6Ta1XRko55HsTqX0pCS.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:02:48', '2025-12-26 00:02:48'),
(116, 4, 'gallery/details/Mr0s1w5n3HJfDi87bBQCYUhIKXvu67K52o3Ig8SX.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:03:12', '2025-12-26 00:03:12'),
(118, 4, 'gallery/details/fXxSg6YUhrVXcu5LTvvD5y7e8p5r0ifv0zGY2noF.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:03:41', '2025-12-26 00:03:41'),
(119, 4, 'gallery/details/EfV2I9Rp73qne2O0aN8BCkF61RJ8V3ifMIfjpAxQ.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:04:01', '2025-12-26 00:04:01'),
(121, 4, 'gallery/details/UPMlUO0n4a5zBSRFgTYhki0svu1jzhrbDWTbeCf4.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:04:57', '2025-12-26 00:04:57'),
(122, 4, 'gallery/details/Ip2id2IAZBffd976gJtXIyk36XMGLz90NVhhoIG0.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:08:27', '2025-12-26 00:08:27'),
(123, 4, 'gallery/details/P9JlKuhLVSkFWfZHAb0iJpgWHdnVTGUSd7RN6AFV.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:08:41', '2025-12-26 00:08:41'),
(124, 4, 'gallery/details/fCjHJjz9zy5wPEneICKKjW1vsN2LUxP93zbMoZCG.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:08:53', '2025-12-26 00:08:53'),
(125, 4, 'gallery/details/GZ5Cs9vRKKAoKklH3sURjN3Su9OVADuo52dLW0sH.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:09:06', '2025-12-26 00:09:06'),
(126, 4, 'gallery/details/yyWDu0190mamEowsPyy5DQvu0YY2uWQJaX6gLXTn.jpg', 'Para Swimming', 0, 1, NULL, '2025-12-26 00:09:20', '2025-12-26 00:09:40'),
(154, 6, 'gallery/details/GIcrg5HEMdoUmcdt4m25mc16NMTQbHrnMuX0U5GO.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:17:48', '2025-12-26 04:17:48'),
(155, 6, 'gallery/details/GnHNKVQOFOAGH62BOeVwhfvnA42IBx1SVc9A4XkK.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:18:09', '2025-12-26 04:18:09'),
(156, 6, 'gallery/details/yeH6kEGIilUtz3mhBXzhCrDttsXbkHGaQ09tyLEm.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:18:23', '2025-12-26 04:18:23'),
(157, 6, 'gallery/details/dcZc9X0q50ermTzFmfci5enhcWucXc4r5lakOiCa.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:24:03', '2025-12-26 04:24:03'),
(158, 6, 'gallery/details/GD9w0hHDh8WJdczPNKhgHRJYv2CZK2BySIBfSMyZ.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:24:20', '2025-12-26 04:24:20'),
(159, 6, 'gallery/details/vij6W5PUExhHihW1iVryYZFsnD8tyIZsSqt4MROa.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:24:34', '2025-12-26 04:24:34'),
(160, 6, 'gallery/details/OpTwreUwhUCcQ3ACPFGlbADdvOIS0qx5hoDp6vUz.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:25:04', '2025-12-26 04:25:04'),
(161, 6, 'gallery/details/31O7nyRTo14dWZ8F1LFdKezt8gPKwG8j0MVi3IKn.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:25:35', '2025-12-26 04:25:35'),
(162, 6, 'gallery/details/ZclruzR7uBEctnWijhxwzSZ2AOS15GalwjocB6LD.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:26:02', '2025-12-26 04:26:02'),
(163, 6, 'gallery/details/99P18eh2DwwG8JqG2JwMJVStztQzYGPDBRuwPJNR.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:26:21', '2025-12-26 04:26:21'),
(164, 6, 'gallery/details/vwHDK0DTZXdklPBzKo8chyiBsx4pyOQ8vAcIWBxY.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:27:24', '2025-12-26 04:27:24'),
(165, 6, 'gallery/details/NYXm0R6EeWTNmYWZVqzwj8XbVHfuKRQ9g3bi0DzG.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:56:16', '2025-12-26 04:56:16'),
(166, 6, 'gallery/details/WKj9ELBrWbXWtu2ZK78CNL4GuqyrRpvNKJELeunF.jpg', NULL, 0, 1, NULL, '2025-12-26 04:56:54', '2025-12-26 04:56:54'),
(167, 6, 'gallery/details/ux9NCv0m9vdTYWWNrydshSir9f4jcJd2WuGJTLFe.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 04:57:40', '2025-12-26 04:57:40'),
(168, 6, 'gallery/details/sRrWtIzWFWumisM4HtsP442DMNTddfNduemPgOGg.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:10:53', '2025-12-26 05:10:53'),
(169, 6, 'gallery/details/lBN1lFiuHrlQ2Jy3ZpySfiXjLgBfE6CRS6bqs8Ju.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:11:07', '2025-12-26 05:11:07'),
(170, 6, 'gallery/details/NRPPoQ1wxPDQU9hQNmygo2UCcLNo2pJHML0gOelG.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:11:32', '2025-12-26 05:11:32'),
(171, 6, 'gallery/details/aLFMmv4GpZMGh7Rm8W8apyKQNKcEo5AnohipVqnR.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:12:02', '2025-12-26 05:12:02'),
(172, 6, 'gallery/details/fPZFQ0HAJ7hVmvsQEFpcpZXdyU44Z9SaC8y5fZwa.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:12:24', '2025-12-26 05:12:24'),
(173, 6, 'gallery/details/CbPbc0SZxGmHDyp3atEMqkCYcREhSvZPSTK5eOnC.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:12:43', '2025-12-26 05:12:43'),
(174, 6, 'gallery/details/bo7MfECtC8mB53b6MptlZlcFyq47apOmGGE2dCw9.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:13:03', '2025-12-26 05:13:03'),
(175, 6, 'gallery/details/nYVYqrkDig0XALcacwAA2d7GmHbgdCTrJRJarbGj.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:13:23', '2025-12-26 05:13:23'),
(176, 6, 'gallery/details/8UsrTtKb90YDFscNkKux7my0Q7EUh5cUhm6zHRyy.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:14:04', '2025-12-26 05:14:04'),
(177, 6, 'gallery/details/bLmV4HVkBuAxKKIjhHluwLddQdxH67obDsLUHmlD.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:14:23', '2025-12-26 05:14:23'),
(178, 6, 'gallery/details/beynOaKoe0Um8KDjv0f5x20oywYS3SMW0yz5hg6X.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:14:37', '2025-12-26 05:14:37'),
(179, 6, 'gallery/details/abyRF2bLjgzO08JuPSgeHb6qoMKM896QYuFHFvpA.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:14:57', '2025-12-26 05:14:57'),
(180, 6, 'gallery/details/2vD1ig8uz0URjVH6gGxjhne9yQQZ3xI3qEn7FRJs.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:15:20', '2025-12-26 05:15:20'),
(181, 6, 'gallery/details/d0tYFbLihLOOxgW7J6xrId2akFUGnYRa2IZgup0C.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:15:42', '2025-12-26 05:15:42'),
(182, 6, 'gallery/details/QQBT33UKq9PyTUp87IYjnf27hnexEwakkaXsk8py.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:16:01', '2025-12-26 05:16:01'),
(183, 6, 'gallery/details/9smGMyZVv0ZyPs5tp6VutXZxvIYwlsGO6YLoNXDH.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:16:16', '2025-12-26 05:16:16'),
(184, 6, 'gallery/details/6ev2mawxfCkVUUbs2OVTD1DDFVS6u4ZkDxvuc7sD.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:16:39', '2025-12-26 05:16:39'),
(185, 6, 'gallery/details/QIhKB6jj3Bq75FZHhOmd46kqIUf349LG1pZjcxEN.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:17:00', '2025-12-26 05:17:00'),
(186, 6, 'gallery/details/TMUuOUCSwgQuesKRlZZKBJpSDvrUQyYar70sL46z.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:17:35', '2025-12-26 05:17:35'),
(187, 6, 'gallery/details/u0IgojxrXChQ0R1UHGr6NGPAUhxCXw4cF2L2pwO4.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:17:51', '2025-12-26 05:17:51'),
(188, 6, 'gallery/details/G1Uny4xepxJnzLmOABee1rGg9qaoCzup9N0wCy2W.jpg', 'Table Tennis Training & Tournament', 0, 1, NULL, '2025-12-26 05:18:12', '2025-12-26 05:18:12'),
(189, 7, 'gallery/7/details\\/189/NxxyVPPnvhSKpay5lUxkOiRoqILQ22mLglipgX2a.jpg', NULL, 0, 1, NULL, '2026-01-06 08:12:59', '2026-01-06 08:13:01'),
(190, 7, 'gallery/7/details\\/190/HRprLvg7aUpEeoB8KY3LhkNhhz1OP17RJ2gdF0by.jpg', NULL, 0, 1, NULL, '2026-01-06 08:13:19', '2026-01-06 08:13:19'),
(191, 7, 'gallery/7/details\\/191/Voo2rdInBy2YEVuvKw30offw5hp4V1Cto7dgOw0b.jpg', NULL, 0, 1, NULL, '2026-01-06 08:13:30', '2026-01-06 08:13:30'),
(192, 7, 'gallery/7/details\\/192/0Rdj7K9f3UtC2uaOrl7bhKkHBZpSrHWKI3UAzqu1.jpg', NULL, 0, 1, NULL, '2026-01-06 08:13:40', '2026-01-06 08:13:40'),
(193, 7, 'gallery/7/details\\/193/PTUcEdkJwvWaliZVZenUIH7b9ESno8edUtLp13Iv.jpg', NULL, 0, 1, NULL, '2026-01-06 08:13:50', '2026-01-06 08:13:50'),
(194, 7, 'gallery/7/details\\/194/79OrOcAfDjGJ2bYY8mVCBDYEjxFAlwc3s5gGPgIl.jpg', NULL, 0, 1, NULL, '2026-01-06 08:14:19', '2026-01-06 08:14:19'),
(195, 7, 'gallery/7/details\\/195/JB921OPlrc1yQ5azzNoPKsPHZ3IfjBGW2S1ANUgr.jpg', NULL, 0, 1, NULL, '2026-01-06 08:14:43', '2026-01-06 08:14:43'),
(196, 7, 'gallery/7/details\\/196/Mc1zigXSqr5xDfPbUQlVdCkic9dgDFPVdUZldG4G.jpg', NULL, 0, 1, NULL, '2026-01-06 08:14:55', '2026-01-06 08:14:55'),
(197, 7, 'gallery/7/details\\/197/I4oYnh5ixbN4atFFbjZNUCfa6s71hk0DyLqNMJwn.jpg', NULL, 0, 1, NULL, '2026-01-06 08:15:10', '2026-01-06 08:15:10'),
(198, 7, 'gallery/7/details\\/198/9fqONlzjqv36cx3tqTnLhdsS3EDAw7UnHzKzgYI0.jpg', NULL, 0, 1, NULL, '2026-01-06 08:15:23', '2026-01-06 08:15:23'),
(199, 7, 'gallery/7/details\\/199/Z96GocmnquMpinfSeB1e4GuxkfxrsrHZUbD0zXnk.jpg', NULL, 0, 1, NULL, '2026-01-06 08:15:36', '2026-01-06 08:15:36'),
(200, 7, 'gallery/7/details\\/200/MOtNpDTtUaLOmSyAo5MFFloVEvpzoW9lt7tGIMRq.jpg', NULL, 0, 1, NULL, '2026-01-06 08:15:47', '2026-01-06 08:15:47'),
(201, 7, 'gallery/7/details\\/201/k7xEtvgTP2wMzZBB8F0e4wE4RitmKcljYZXzaQce.jpg', NULL, 0, 1, NULL, '2026-01-06 08:16:00', '2026-01-06 08:16:00'),
(202, 7, 'gallery/7/details\\/202/70z3oPFRWN2KNVMLXg9eYwrBt7lenLmcTqAf4sR1.jpg', NULL, 0, 1, NULL, '2026-01-06 08:16:20', '2026-01-06 08:16:20'),
(203, 7, 'gallery/7/details\\/203/4CnLyLxA52mHO3ygXaToP9N4zek4DY0mLL4HeU1Y.jpg', NULL, 0, 1, NULL, '2026-01-06 08:17:34', '2026-01-06 08:17:34'),
(204, 7, 'gallery/7/details\\/204/Lj0QbHVRVOXM8x6LN1j5pj6T9BEu725fEPM3P1aI.jpg', NULL, 0, 1, NULL, '2026-01-06 08:20:17', '2026-01-06 08:20:17'),
(205, 7, 'gallery/7/details\\/205/QCu0KW61Zhc8VTB4TUJjfnblHC50xYi2J0yWCL9G.jpg', NULL, 0, 1, NULL, '2026-01-06 08:22:23', '2026-01-06 08:22:23'),
(206, 7, 'gallery/7/details\\/206/5OHngfDQoKsggU2NTYyzdP4kfxFtbdyD1qBYddFC.jpg', NULL, 0, 1, NULL, '2026-01-06 08:22:51', '2026-01-06 08:22:51'),
(207, 7, 'gallery/7/details\\/207/v40m7Fgp4ra1fChNI8Xtbs37C4d5eGmo15qOYOPq.jpg', NULL, 0, 1, NULL, '2026-01-06 08:23:04', '2026-01-06 08:23:04'),
(208, 7, 'gallery/7/details\\/208/uzfjmFiToQxjKtp9ovLvufkRiEPC2APXE3W7LR2E.jpg', NULL, 0, 1, NULL, '2026-01-06 08:23:18', '2026-01-06 08:23:18'),
(209, 7, 'gallery/7/details\\/209/60lL72zYho8janSbrzwEbRWFPxiChm5qaMj6kk4H.jpg', NULL, 0, 1, NULL, '2026-01-06 08:23:30', '2026-01-06 08:23:30'),
(228, 9, 'gallery/9/details\\/228/XMz6UJLzLULxqVeNGt3Vh7RVeHA1XtG9SlElT46R.jpg', NULL, 0, 1, NULL, '2026-01-06 09:23:54', '2026-01-06 09:23:54'),
(229, 9, 'gallery/9/details\\/229/BHtktrYVh5Oe5zbVzOPXOr3AT5pIn0Joi9tnvckY.jpg', NULL, 0, 1, NULL, '2026-01-06 09:24:07', '2026-01-06 09:24:07'),
(230, 9, 'gallery/9/details\\/230/1kjpueZbd7o7eIdmhWNSFSD31PIq2NVMsaSLYRJN.jpg', NULL, 0, 1, NULL, '2026-01-06 09:24:16', '2026-01-06 09:24:16'),
(231, 9, 'gallery/9/details\\/231/XyuEvuLZ8ghQx1QK86JzSYrSE0PmVl4goLeW2iVE.jpg', NULL, 0, 1, NULL, '2026-01-06 09:24:25', '2026-01-06 09:24:25'),
(232, 9, 'gallery/9/details\\/232/Wi8W8033LEa8yIsOzRVG9zzwHhErOUBNY6T6NHi6.jpg', NULL, 0, 1, NULL, '2026-01-06 09:24:37', '2026-01-06 09:24:37'),
(233, 9, 'gallery/9/details\\/233/8LgiGJt39Rxz5wZyHBCuor3LkOn7oTA0Frki7APU.jpg', NULL, 0, 1, NULL, '2026-01-06 09:24:48', '2026-01-06 09:24:48'),
(234, 9, 'gallery/9/details\\/234/n5CNur9nM6xGBpVlCDZLlMPVvSB9VDD2Swr0uxNT.jpg', NULL, 0, 1, NULL, '2026-01-06 09:25:02', '2026-01-06 09:25:02'),
(235, 9, 'gallery/9/details\\/235/TRAt5UPxnJhowcsicJYhkJtef7emTnlYxcN1IfS8.jpg', NULL, 0, 1, NULL, '2026-01-06 09:25:11', '2026-01-06 09:25:11'),
(236, 9, 'gallery/9/details\\/236/Jn9ltAOCS7LN9JxpYyX2V22nAKBBZ2w3Ya9dPQkR.jpg', NULL, 0, 1, NULL, '2026-01-06 09:25:21', '2026-01-06 09:25:21'),
(237, 9, 'gallery/9/details\\/237/f4fap5SBOY2Z5g2mOIviMIAavH50cNraQZzZnIQo.jpg', NULL, 0, 1, NULL, '2026-01-06 09:25:43', '2026-01-06 09:25:43'),
(238, 9, 'gallery/9/details\\/238/OmSHJwz3jH6MdRyA0lKwLz9ucJvNgjWKwO1k6pPP.jpg', NULL, 0, 1, NULL, '2026-01-06 09:26:00', '2026-01-06 09:26:00'),
(239, 9, 'gallery/9/details\\/239/2yk7yTZmPMOIWKPJjSEPvEaJdkrKdBipr84fwjpp.jpg', NULL, 0, 1, NULL, '2026-01-06 09:26:21', '2026-01-06 09:26:21'),
(240, 9, 'gallery/9/details\\/240/jtSlV7oURXCWtGhLfUvdtG9qX6mMqhG7y2Au09D7.jpg', NULL, 0, 1, NULL, '2026-01-06 09:26:49', '2026-01-06 09:26:49'),
(241, 9, 'gallery/9/details\\/241/2h1ezkU2SGD6bVYV7Z7TEwTNLX7DFE3RgXN2K9ih.jpg', NULL, 0, 1, NULL, '2026-01-06 09:27:05', '2026-01-06 09:27:05'),
(242, 9, 'gallery/9/details\\/242/dJC2NqDQMrKEr9rhc7CbHbPxjgS7NAfEq5h8BNuZ.jpg', NULL, 0, 1, NULL, '2026-01-06 09:27:21', '2026-01-06 09:27:21'),
(243, 9, 'gallery/9/details\\/243/FYD7nDcKyJpZ62FyYgKjz085tLfZA3Modtl7mYid.jpg', NULL, 0, 1, NULL, '2026-01-06 09:27:36', '2026-01-06 09:27:37'),
(244, 9, 'gallery/9/details\\/244/M0hUAa26akQY2A0MTj0vcg2NcXX5xSkLu33dsqa8.jpg', NULL, 0, 1, NULL, '2026-01-06 09:28:03', '2026-01-06 09:28:04'),
(245, 9, 'gallery/9/details\\/245/5eB7PNoZQBFn3IqIBbBQIMgcJcN10xbEdeDGEmdg.jpg', NULL, 0, 1, NULL, '2026-01-06 09:28:20', '2026-01-06 09:28:20'),
(246, 9, 'gallery/9/details\\/246/OudJDt5WFEp9pFscSQNrQWeJhoeLixVYDwRfFVfs.jpg', NULL, 0, 1, NULL, '2026-01-06 09:28:55', '2026-01-06 09:28:55'),
(247, 9, 'gallery/9/details\\/247/HuMyZoZ1VqtBEecTAWp47GjLDcsM2NHuPQ0OSRyh.jpg', NULL, 0, 1, NULL, '2026-01-06 10:04:35', '2026-01-06 10:04:35'),
(248, 9, 'gallery/9/details\\/248/yEn7fYvOibk8SstMSOgiz5vzxgMG9teCzTVDzqfd.jpg', NULL, 0, 1, NULL, '2026-01-06 10:04:51', '2026-01-06 10:04:51'),
(249, 9, 'gallery/9/details\\/249/22ml7q6a9QThe1n5MGiKwycvhEupSZKfHpRYWA9s.jpg', NULL, 0, 1, NULL, '2026-01-06 10:05:02', '2026-01-06 10:05:02'),
(250, 9, 'gallery/9/details\\/250/IpzUEmlM0Lebx4Nrzxyrz9t8fhdvaekAjgZkSe73.jpg', NULL, 0, 1, NULL, '2026-01-06 10:05:14', '2026-01-06 10:05:14'),
(251, 9, 'gallery/9/details\\/251/5iOb7fCngWnb3T5Odx0y65VLUfSYt7Oy7jMSK5mD.jpg', NULL, 0, 1, NULL, '2026-01-06 10:05:26', '2026-01-06 10:05:26'),
(252, 9, 'gallery/9/details\\/252/EauWZGByK3Ee00nTQDZV77qatCwxAS44sx25lhny.jpg', NULL, 0, 1, NULL, '2026-01-06 10:05:37', '2026-01-06 10:05:37'),
(253, 9, 'gallery/9/details\\/253/CeCjDRATJdTsFvsqZXm44GZqUOZXJaAfes1fHxFK.jpg', NULL, 0, 1, NULL, '2026-01-06 10:05:50', '2026-01-06 10:05:51'),
(254, 9, 'gallery/9/details\\/254/MnwULoT31b9g1dlasOikh6PEGC9zCCTxNefZQXh7.jpg', NULL, 0, 1, NULL, '2026-01-06 10:06:08', '2026-01-06 10:06:09'),
(255, 9, 'gallery/9/details\\/255/UN1HfrO3TeKy1Z8uOVIqiCBDZPhxiuYOqDQfuNCB.jpg', NULL, 0, 1, NULL, '2026-01-06 10:06:23', '2026-01-06 10:06:24'),
(256, 9, 'gallery/9/details\\/256/Vlx8x6klossqKppPeX6qIBx3SqAkswj9kThK6CzY.jpg', NULL, 0, 1, NULL, '2026-01-06 10:06:47', '2026-01-06 10:06:47'),
(257, 9, 'gallery/9/details\\/257/w4PcJoNr9NCYBQRX7BF2HAfrQDQ22JOuF7yINO02.jpg', NULL, 0, 1, NULL, '2026-01-06 10:06:59', '2026-01-06 10:06:59'),
(258, 9, 'gallery/9/details\\/258/kqq93gaAeCjGk2zL5xRJSCxXLeuW7HJJUSj2o269.jpg', NULL, 0, 1, NULL, '2026-01-06 10:07:15', '2026-01-06 10:07:15'),
(259, 9, 'gallery/9/details\\/259/80ou4f2r0bKOhAol4isyxjd5OJjwcpXVwvOIQnb9.jpg', NULL, 0, 1, NULL, '2026-01-06 10:07:27', '2026-01-06 10:07:27'),
(260, 9, 'gallery/9/details\\/260/oRmqYimXL74NviFcyMym1rjJXr6MW9NhdVMsDHoh.jpg', NULL, 0, 1, NULL, '2026-01-06 10:07:47', '2026-01-06 10:07:47'),
(261, 11, 'gallery/11/details\\/261/iOEGFs5FApYCXqoTh82GHcOAfFS7XttdSiHA9OaY.jpg', 'Aichi-Nagoya 2026 Asian Para Games', 0, 1, NULL, '2026-01-18 13:11:47', '2026-01-18 13:11:47'),
(262, 11, 'gallery/11/details\\/262/t1CqJsoFY28ZZ7u4tHKgqSkUo3Q7sFehbYBPtwG4.jpg', 'Aichi-Nagoya 2026 Asian Para Games', 0, 1, NULL, '2026-01-18 13:12:17', '2026-01-18 13:12:18'),
(263, 11, 'gallery/11/details\\/263/5jdu8zOFC8l2P6NwIaePAtcdRYyU5zJz11MUxqiA.jpg', 'Aichi-Nagoya 2026 Asian Para Games', 0, 1, NULL, '2026-01-18 13:12:43', '2026-01-18 13:12:50'),
(264, 11, 'gallery/11/details\\/264/W0S8RJZ5TfMFe3IWTz81kgpMmKNAgpPk4hfrxYuv.jpg', 'Aichi-Nagoya 2026 Asian Para Games', 0, 1, NULL, '2026-01-18 13:13:10', '2026-01-18 13:13:10'),
(265, 11, 'gallery/11/details\\/265/VonjXuGxu3Xp1VZyRWFYoxoLXTU9UQ2I4tr5RAiB.jpg', 'Aichi-Nagoya 2026 Asian Para Games', 0, 1, NULL, '2026-01-18 13:13:29', '2026-01-18 13:13:29'),
(266, 12, 'gallery/12/details\\/266/lChrJg27tV0GAgPN2kEw8Zg3MHeyOkpiRkyGmSdh.jpg', NULL, 0, 1, NULL, '2026-01-18 13:16:40', '2026-01-18 13:16:40'),
(267, 12, 'gallery/12/details\\/267/4zMod78zzqtdjQgkLzmLgGk8KUTFeAvnYNjV0XlN.jpg', 'Dubai 2025 Asian Youth Para Games', 0, 1, NULL, '2026-01-18 13:16:55', '2026-01-18 13:16:55'),
(268, 12, 'gallery/12/details\\/268/5tRSY8UFaHY1h3vmIVyv37ZtZBjKKpywd8C9Bbwj.jpg', NULL, 0, 1, NULL, '2026-01-18 13:17:28', '2026-01-18 13:17:28'),
(269, 12, 'gallery/12/details\\/269/Q561lDyMTo3FH78vC1GblKaWj7OsShZUc88gBaqm.jpg', NULL, 0, 1, NULL, '2026-01-18 13:17:45', '2026-01-18 13:17:45'),
(270, 12, 'gallery/12/details\\/270/Y6hNxjtuVconyELEoWs7W6uH8pKwxnLBAVgEuDiO.jpg', 'Dubai 2025 Asian Youth Para Games', 0, 1, NULL, '2026-01-18 13:18:02', '2026-01-18 13:18:02'),
(271, 12, 'gallery/12/details\\/271/qKsXiArEAEuYW7d2xeEw1NX4tTBUYVVhbawWHEU7.jpg', NULL, 0, 1, NULL, '2026-01-18 13:18:28', '2026-01-18 13:18:28'),
(272, 12, 'gallery/12/details\\/272/XeNl0ZlMEwESyTxQeBtmcXCnlXq8uLcmN3kWzaZj.jpg', NULL, 0, 1, NULL, '2026-01-18 13:18:51', '2026-01-18 13:18:51'),
(273, 12, 'gallery/12/details\\/273/RKKeAUbe8CnzMZ5dpF4GTr1p3nytPvhAkt8e4oqi.jpg', NULL, 0, 1, NULL, '2026-01-18 13:19:08', '2026-01-18 13:19:08'),
(274, 13, 'gallery/13/details\\/274/HY2xOypqYGMlBoLa7Rtu4A0IsDodaqTgUD4wx112.jpg', 'Gwangju 2025 World Archery Para Championships', 0, 1, NULL, '2026-01-18 13:21:50', '2026-01-18 13:21:50'),
(275, 13, 'gallery/13/details\\/275/xw335sxDOfrWXOpm78eKI81kcuOPdLYmHWgVHlRg.jpg', 'Gwangju 2025 World Archery Para Championships', 0, 1, NULL, '2026-01-18 13:22:09', '2026-01-18 13:22:09'),
(276, 13, 'gallery/13/details\\/276/RRjROunpdSbAfYOfDGFbOkNwpYcFrneqJdRnWyJ8.jpg', 'Gwangju 2025 World Archery Para Championships', 0, 1, NULL, '2026-01-18 13:22:34', '2026-01-18 13:22:34'),
(277, 13, 'gallery/13/details\\/277/1wn3D91FkOfqvcqyUBBtPaF9XAjtpNDvZxylRRh8.jpg', NULL, 0, 1, NULL, '2026-01-18 13:22:58', '2026-01-18 13:22:58'),
(278, 13, 'gallery/13/details\\/278/BPyvWjIHfDMkrHARXXhsXsWf9CGMTvCS5UKUGdfm.jpg', NULL, 0, 1, NULL, '2026-01-18 13:23:22', '2026-01-18 13:23:22'),
(279, 13, 'gallery/13/details\\/279/vcQod6GgElfOYB7z9OLclBRaJwVNpp3LJZbnlnqk.jpg', 'Gwangju 2025 World Archery Para Championships', 0, 1, NULL, '2026-01-18 13:23:42', '2026-01-18 13:23:42'),
(280, 14, 'gallery/14/details\\/280/Z65dCkWtA3wn4rztoamYvYSfi65LXjFFIwpk8JOe.jpg', 'World Para Athletics Championship New Delhi 2025', 0, 1, NULL, '2026-01-18 13:25:36', '2026-01-18 13:25:36'),
(281, 14, 'gallery/14/details\\/281/R3jVK91xbwOLMvo8NxVo5zbOKCYLUsGTV5B4tjpo.jpg', 'World Para Athletics Championship New Delhi 2025', 0, 1, NULL, '2026-01-18 13:25:59', '2026-01-18 13:25:59'),
(282, 14, 'gallery/14/details\\/282/WLGI4yR5Tz9pAchQjo0FP92DgWPL9I04V6FXJhqT.jpg', NULL, 0, 1, NULL, '2026-01-18 13:26:21', '2026-01-18 13:26:21'),
(283, 14, 'gallery/14/details\\/283/u7is1FGBi6RfOOSSvmIluHBwgHpmwXyDMMw9iilG.jpg', NULL, 0, 1, NULL, '2026-01-18 13:26:36', '2026-01-18 13:26:36'),
(284, 14, 'gallery/14/details\\/284/c8mrSvN0qXUGLHbZ7dKT4hiS2pkDmByXBLfcSokb.jpg', NULL, 0, 1, NULL, '2026-01-18 13:26:52', '2026-01-18 13:26:52'),
(285, 14, 'gallery/14/details\\/285/4HJh8D4ZaL3dW76QThrNnbiprs1JlfdE7cpHPgA4.jpg', NULL, 0, 1, NULL, '2026-01-18 13:27:17', '2026-01-18 13:27:17'),
(286, 14, 'gallery/14/details\\/286/DGZDZiFZZaGNoBx0izmveUZtVXC2xUFVAv49OzJL.jpg', NULL, 0, 1, NULL, '2026-01-18 13:27:34', '2026-01-18 13:27:34'),
(287, 15, 'gallery/15/details\\/287/FyQLW9HK4YfJuO3bU4NYWKmt32yBNm1Kh2D2DEzz.jpg', NULL, 0, 1, NULL, '2026-01-18 13:35:23', '2026-01-18 13:35:23'),
(288, 15, 'gallery/15/details\\/288/0DcLNlLvBZNqnEm34Nw9BlCH9IBQJXVJEpIQfwLH.jpg', NULL, 0, 1, NULL, '2026-01-18 13:35:41', '2026-01-18 13:35:41'),
(289, 15, 'gallery/15/details\\/289/b7VVnSU4Cw3gnDNuzgbVj8v8DaCqUOXVvwUg3vY3.jpg', NULL, 0, 1, NULL, '2026-01-18 13:35:53', '2026-01-18 13:35:53'),
(290, 15, 'gallery/15/details\\/290/NxksqZdovaZ50vBpOVC0ZUHIJZmrby1IRxzvfPB9.jpg', NULL, 0, 1, NULL, '2026-01-18 13:36:15', '2026-01-18 13:36:15'),
(291, 15, 'gallery/15/details\\/291/3BgeSVUDb6qrDUTPGay5YMSUvOCDSRuJBth9CI82.jpg', NULL, 0, 1, NULL, '2026-01-18 13:36:31', '2026-01-18 13:36:32'),
(292, 15, 'gallery/15/details\\/292/mADO0FbKXG0CPqmyVepN4F2Pf5nUql5qYv236oEE.jpg', NULL, 0, 1, NULL, '2026-01-18 13:36:44', '2026-01-18 13:36:44'),
(293, 7, 'gallery/7/details\\/293/XrNu48xfDm01jz5aFMUHQbfwbdNprjIBI4bctYfg.jpg', NULL, 0, 1, NULL, '2026-01-18 13:46:18', '2026-01-18 13:46:18'),
(294, 7, 'gallery/7/details\\/294/kxZb0iLeZ4gFxFoPANtXOVQWze8phkysAOdeNfpI.jpg', NULL, 0, 1, NULL, '2026-01-18 13:46:28', '2026-01-18 13:46:28'),
(295, 7, 'gallery/7/details\\/295/jot5RxLjcRP7VsC65xfjq7db7zOmargRe6enwdn7.jpg', NULL, 0, 1, NULL, '2026-01-18 13:47:32', '2026-01-18 13:47:32'),
(296, 7, 'gallery/7/details\\/296/Y7AagMQ5apG3zry720B0VTGzv898vcmSONzyjvWP.jpg', NULL, 0, 1, NULL, '2026-01-18 13:48:02', '2026-01-18 13:48:02'),
(297, 16, 'gallery/16/details\\/297/i9QMwbzt5radhfZ1BPHomu8EWEeF403jHwFGErii.jpg', NULL, 0, 1, NULL, '2026-01-19 02:58:28', '2026-01-19 02:58:28'),
(298, 16, 'gallery/16/details\\/298/AtHS5YSuoevt1UAoJvFu9gvT97Q1MNZuiSzNTIim.jpg', NULL, 0, 1, NULL, '2026-01-19 03:16:28', '2026-01-19 03:16:28'),
(299, 16, 'gallery/16/details\\/299/knY1YVHns4AYJAvGLy00KfX40L0hDgImn78o0I5q.jpg', NULL, 0, 1, NULL, '2026-01-19 03:16:46', '2026-01-19 03:16:46'),
(300, 16, 'gallery/16/details\\/300/ceEnWl98gX8hMnkb0uS0lPGc0LucYhr5MVW8SAaP.jpg', NULL, 0, 1, NULL, '2026-01-19 03:17:11', '2026-01-19 03:17:11'),
(301, 8, 'gallery/8/details\\/301/Nq1CGQGCdEt8FejMAwvIcR7vjElhOlwMyZsA2CdN.jpg', NULL, 0, 1, NULL, '2026-01-19 03:24:06', '2026-01-19 03:24:06'),
(302, 8, 'gallery/8/details\\/302/PiiphFb7jfHWnOApIVdeiJP6HkdfojD0jHh2doOp.jpg', NULL, 0, 1, NULL, '2026-01-19 03:24:16', '2026-01-19 03:24:16'),
(305, 17, 'gallery/17/details\\/305/tfa3AAsYFvUyNZC8uhvm7HYj1oSKeQbaYqXCuc3E.jpg', NULL, 0, 1, NULL, '2026-01-19 03:37:15', '2026-01-19 03:37:15'),
(306, 17, 'gallery/17/details\\/306/Bc9YwOVEMXdi91gYsqyhTUCgTS2LU7nZ1INl9gpl.jpg', NULL, 0, 1, NULL, '2026-01-19 03:37:47', '2026-01-19 03:37:47'),
(307, 17, 'gallery/17/details\\/307/6OgBG5mHzCnMmUgIghY1bOVjgNflxqcfeSb08hmu.jpg', NULL, 0, 1, NULL, '2026-01-19 03:38:08', '2026-01-19 03:38:08'),
(308, 17, 'gallery/17/details\\/308/9L3j3MWmQMU3vJnyjO3izuZA6kESpRkmm8t5SuQ6.jpg', NULL, 0, 1, NULL, '2026-01-19 03:38:42', '2026-01-19 03:38:42'),
(309, 17, 'gallery/17/details\\/309/MdI0o8eHE1BL8olV7cBiIsyZq3W59Oxmc3O2srBk.jpg', NULL, 0, 1, NULL, '2026-01-19 03:39:34', '2026-01-19 03:39:34'),
(310, 17, 'gallery/17/details\\/310/UhQW3bB9dnA3XvSBnN1mKvt3yzZuRDdO4dEkcYDH.jpg', NULL, 0, 1, NULL, '2026-01-19 03:40:25', '2026-01-19 03:40:25'),
(311, 17, 'gallery/17/details\\/311/jlFjual0BqXoZ3KUgzRrs1gHJQbYQTzFfVN6DbLN.jpg', NULL, 0, 1, NULL, '2026-01-19 03:40:53', '2026-01-19 03:40:53'),
(312, 17, 'gallery/17/details\\/312/JdHFJXJu8bf8qX0wASNmtIPJJ78WLlCabNCevPiV.jpg', NULL, 0, 1, NULL, '2026-01-19 03:45:02', '2026-01-19 03:45:02'),
(313, 17, 'gallery/17/details\\/313/Y7qwpcKYtlp0JZTeRv3CBPpRyxCQumJoEX8f4AqM.jpg', NULL, 0, 1, NULL, '2026-01-19 03:45:27', '2026-01-19 03:45:27'),
(314, 17, 'gallery/17/details\\/314/I3xlTBdPaRovshKe77q7NHrvJ2qrrVexfqDZwqCI.jpg', NULL, 0, 1, NULL, '2026-01-19 03:45:54', '2026-01-19 03:45:54'),
(315, 17, 'gallery/17/details\\/315/gIHcUaIKgPX7FRc9EOrRgrvqPxvoDuxxpZlBhIlX.jpg', NULL, 0, 1, NULL, '2026-01-19 04:41:28', '2026-01-19 04:41:28'),
(316, 21, 'gallery/21/details\\/316/tdxhyce8EeyxUvSYHFWrbBr0YwEUrgJcMtyHnge8.jpg', NULL, 0, 1, NULL, '2026-01-23 13:22:22', '2026-01-23 13:22:22'),
(317, 21, 'gallery/21/details\\/317/4IsesBelFCgtwGursbmLVXR1SYH1HXXZN4bNHgNO.jpg', NULL, 0, 1, NULL, '2026-01-23 13:23:01', '2026-01-23 13:23:01'),
(318, 21, 'gallery/21/details\\/318/LN3FrjdOPSHO1fTpveaRIoRfzlrSAMGGvW1Brb5j.jpg', NULL, 0, 1, NULL, '2026-01-23 13:24:11', '2026-01-23 13:24:11'),
(319, 21, 'gallery/21/details\\/319/ETrKWZ6qQsFzIxLTdHfFWBUAMWtAxgBWzphht7X8.jpg', NULL, 0, 1, NULL, '2026-01-23 13:24:30', '2026-01-23 13:24:30'),
(320, 21, 'gallery/21/details\\/320/Hcv3eC0igSoxVk6e4IxWT4egC8QmRxwtCyvoDf2T.jpg', NULL, 0, 1, NULL, '2026-01-23 13:24:46', '2026-01-23 13:24:46'),
(321, 21, 'gallery/21/details\\/321/4msnJoi7cd9SduZ1dK8hGXNjlEBXPcSC7L0BzNR8.jpg', NULL, 0, 1, NULL, '2026-01-23 13:25:07', '2026-01-23 13:25:07'),
(322, 21, 'gallery/21/details\\/322/qQ16ru9PHur5FwPAM4cGNCxliwboTUfKQ3XJAoG7.jpg', NULL, 0, 1, NULL, '2026-01-23 13:25:59', '2026-01-23 13:25:59'),
(323, 21, 'gallery/21/details\\/323/V6mGn6MXLKcoRJkzt6VRGxKHEm8LDucWzo32aDXZ.jpg', NULL, 0, 1, NULL, '2026-01-23 13:26:28', '2026-01-23 13:26:28'),
(324, 21, 'gallery/21/details\\/324/ZK5qyK4gfi6sInszQHFfpD1YYEy8Sv88nFiwP8Ai.jpg', NULL, 0, 1, NULL, '2026-01-23 13:27:03', '2026-01-23 13:27:03'),
(325, 21, 'gallery/21/details\\/325/YxWb8rZFksDacloazj3oDyi1YwsPNfVZiIGmGyP6.jpg', NULL, 0, 1, NULL, '2026-01-23 13:33:02', '2026-01-23 13:33:02'),
(326, 21, 'gallery/21/details\\/326/Csl43rGhVFnckQM7zimZdcM3BmWmqLltGP1x7fAA.jpg', NULL, 0, 1, NULL, '2026-01-23 13:33:26', '2026-01-23 13:33:26'),
(327, 21, 'gallery/21/details\\/327/4L6lzgwhJIm2IlrD668Bikk8VraHtk6HLsr7zL89.jpg', NULL, 0, 1, NULL, '2026-01-23 13:42:24', '2026-01-23 13:42:24'),
(328, 21, 'gallery/21/details\\/328/227QGR6fnD2hfUuqBaKkRW2RYd0AcHxHIAfqoBZL.jpg', NULL, 0, 1, NULL, '2026-01-23 13:44:17', '2026-01-23 13:44:17'),
(329, 21, 'gallery/21/details\\/329/9OPKP6CU4W1HSiNTrISmjlc4gUcFjL2aMW9SQVqn.jpg', NULL, 0, 1, NULL, '2026-01-23 13:45:27', '2026-01-23 13:45:27'),
(330, 21, 'gallery/21/details\\/330/XCe076e4J7YBTJOpnXKzGlqbEufBS9cfBcWZkOgi.jpg', NULL, 0, 1, NULL, '2026-01-23 13:53:21', '2026-01-23 13:53:23'),
(331, 21, 'gallery/21/details\\/331/MB5nrY4hkruAVSfHQhUh0hchhrpk2JxJJHNlGtQ7.jpg', NULL, 0, 1, NULL, '2026-01-23 13:54:54', '2026-01-23 13:54:54'),
(332, 21, 'gallery/21/details\\/332/k4D2bghxq4ipiyXEu6uBAHwDbH6KVogDBkgWdRav.jpg', NULL, 0, 1, NULL, '2026-01-23 14:05:37', '2026-01-23 14:05:37'),
(333, 21, 'gallery/21/details\\/333/o979nTQd9dY0ddOkfXZIExJFqo7EY2Y95SXoS95c.jpg', NULL, 0, 1, NULL, '2026-01-23 14:05:58', '2026-01-23 14:05:58'),
(334, 21, 'gallery/21/details\\/334/7fEth1GedTnVKSmOXTsWJgMyBFUjKwAll2ZfJ2RG.jpg', NULL, 0, 1, NULL, '2026-01-23 14:06:18', '2026-01-23 14:06:18'),
(335, 21, 'gallery/21/details\\/335/pJS7T3rG11EkPvmK4mcKmzWjFSMLYMsAfULasPrE.jpg', NULL, 0, 1, NULL, '2026-01-23 14:06:36', '2026-01-23 14:06:36'),
(336, 21, 'gallery/21/details\\/336/C1IzXgBymekNw5xdx8hGEjVP2W11Tsbt47QOBKp4.jpg', NULL, 0, 1, NULL, '2026-01-23 14:07:11', '2026-01-23 14:07:11'),
(337, 8, 'gallery/8/details\\/337/eujldr3vx8BCaSev9kvNNdl5ftvWKgiZJBhvgDyE.jpg', NULL, 0, 1, NULL, '2026-01-23 15:25:04', '2026-01-23 15:25:04'),
(338, 8, 'gallery/8/details\\/338/YqmzqmvXFbrNqPI1s1YSr966WqdzLm56IqfURlYG.jpg', NULL, 0, 1, NULL, '2026-01-23 15:25:46', '2026-01-23 15:25:46'),
(339, 8, 'gallery/8/details\\/339/f56f1gr9P44EZSDxEZEvnCaiqmGgCegcWWDPwohz.jpg', NULL, 0, 1, NULL, '2026-01-23 15:26:36', '2026-01-23 15:26:36'),
(341, 8, 'gallery/8/details\\/341/P9PFgpRxQOHW0qkKdyobKTWXCC3oajnIWUcI2OlU.jpg', NULL, 0, 1, NULL, '2026-01-23 15:27:20', '2026-01-23 15:27:20'),
(342, 8, 'gallery/8/details\\/342/gINac414YF8yQklOTcM3F9sAjjTTn5QmZ4i41zIi.jpg', NULL, 0, 1, NULL, '2026-01-23 15:28:28', '2026-01-23 15:28:28'),
(343, 8, 'gallery/8/details\\/343/b6VWyenw3sOTLXMUdLCuP8b2tdbkrVpAQzuLEavx.jpg', NULL, 0, 1, NULL, '2026-01-23 15:29:05', '2026-01-23 15:29:05'),
(344, 8, 'gallery/8/details\\/344/QBgYJiBWlEfSCtJusxhyjQKQ0fvzNLuldQFqmhpC.jpg', NULL, 0, 1, NULL, '2026-01-23 15:29:57', '2026-01-23 15:29:57'),
(345, 8, 'gallery/8/details\\/345/Om2NhhoeMGLXr6VwpLmtKkfVntoqib5rk8tnGm36.jpg', NULL, 0, 1, NULL, '2026-01-23 15:30:44', '2026-01-23 15:30:44'),
(346, 8, 'gallery/8/details\\/346/sV5UygohtmRKx1GRd78ONZSZyh6GXvYUHfqQPXKq.jpg', NULL, 0, 1, NULL, '2026-01-23 15:31:40', '2026-01-23 15:31:40'),
(347, 5, 'gallery/5/details\\/347/s4ZTjF30HrsqccKitVAVaPo4mG13hRBE1JczllYo.jpg', NULL, 0, 1, NULL, '2026-01-23 15:36:16', '2026-01-23 15:36:16'),
(348, 5, 'gallery/5/details\\/348/qCS3IneW7HrUMNlA2lsIA2l87hjJxs5U39v5vtnk.jpg', NULL, 0, 1, NULL, '2026-01-23 15:36:36', '2026-01-23 15:36:36'),
(349, 5, 'gallery/5/details\\/349/AXPCCqTVLuyln2PTDUe1ebSGEr9TeCyOXujETh41.jpg', NULL, 0, 1, NULL, '2026-01-23 15:37:00', '2026-01-23 15:37:00'),
(350, 5, 'gallery/5/details\\/350/iXyeGw3nkKtG9n9ZUbEUIydUs1W8ZX8BrAPk0YS3.jpg', NULL, 0, 1, NULL, '2026-01-23 15:37:45', '2026-01-23 15:37:45'),
(351, 5, 'gallery/5/details\\/351/F22TpsZ59jh2oXA1OU44eo7rrdwRrDXHgBY7nwe1.jpg', NULL, 0, 1, NULL, '2026-01-23 15:38:27', '2026-01-23 15:38:27'),
(352, 5, 'gallery/5/details\\/352/ZqkziI5lzmO1L6m4k5wEKnzoW6OZ2qh6C1rhyepv.jpg', NULL, 0, 1, NULL, '2026-01-23 15:39:26', '2026-01-23 15:39:26'),
(353, 5, 'gallery/5/details\\/353/oE2sHRjO3HtHk2MZj23OuYzlDL30Tq4QnDXdGh3m.jpg', NULL, 0, 1, NULL, '2026-01-23 15:39:52', '2026-01-23 15:39:52'),
(354, 5, 'gallery/5/details\\/354/OXZTpY50vNWTygUBU23wIRxVdIQ0YJHBbmpobxtr.jpg', NULL, 0, 1, NULL, '2026-01-23 15:40:41', '2026-01-23 15:40:41'),
(355, 5, 'gallery/5/details\\/355/GOlbAYIsW2Z17mZP1sEzXTuIu8qttDaZFTwoxFnU.jpg', NULL, 0, 1, NULL, '2026-01-23 15:41:57', '2026-01-23 15:41:57'),
(356, 5, 'gallery/5/details\\/356/aWOrjJp7UsU7Em4jgSJF4C36oYKOMuwrAj5IWnbZ.jpg', NULL, 0, 1, NULL, '2026-01-23 15:42:31', '2026-01-23 15:42:31'),
(357, 2, 'gallery/2/details\\/357/y1Uk62LpLn6WyCQ9wPcpDFYLQvXOyeAxvMcWVe5l.jpg', NULL, 0, 1, NULL, '2026-01-23 15:52:58', '2026-01-23 15:52:58'),
(358, 2, 'gallery/2/details\\/358/L3a3F4iA3sJ5ZgmpPLtpeqkdpUWCXpp1Yzozfrts.jpg', NULL, 0, 1, NULL, '2026-01-23 15:53:30', '2026-01-23 15:53:30'),
(359, 2, 'gallery/2/details\\/359/Gw5uvJMDb79O1HfK63mPPOh48IlJSAlJXtDAR6KI.jpg', NULL, 0, 1, NULL, '2026-01-23 15:54:04', '2026-01-23 15:54:04'),
(360, 2, 'gallery/2/details\\/360/ucSEi3YW9a1MctwQoFVBDZWjabdDtM790j2tO2dA.jpg', NULL, 0, 1, NULL, '2026-01-23 15:54:40', '2026-01-23 15:54:40'),
(361, 2, 'gallery/2/details\\/361/PHvVPVhrKzaf70PUwvH9SGqyW4AriaSdOrfsxVsz.jpg', NULL, 0, 1, NULL, '2026-01-23 15:55:08', '2026-01-23 15:55:08'),
(362, 2, 'gallery/2/details\\/362/Os5XLqhIPTQQQdqxE7WX2yEDXxDstw3Np6757oyL.jpg', NULL, 0, 1, NULL, '2026-01-23 15:55:33', '2026-01-23 15:55:33'),
(363, 2, 'gallery/2/details\\/363/YrFsbFyZV2a1iRqpGIOQPK672uNJO8hALZODzuZB.jpg', NULL, 0, 1, NULL, '2026-01-23 15:55:58', '2026-01-23 15:55:58'),
(364, 2, 'gallery/2/details\\/364/Feq1AcFxdsZS8mXzjBB13315clkICywLXnfVGn9X.jpg', NULL, 0, 1, NULL, '2026-01-23 15:56:30', '2026-01-23 15:56:30'),
(365, 2, 'gallery/2/details\\/365/OulVFFQwgA9LHC3euFNOYzylnmQJ2VZY61uCf1am.jpg', NULL, 0, 1, NULL, '2026-01-23 15:57:04', '2026-01-23 15:57:04'),
(366, 2, 'gallery/2/details\\/366/r3ncPYeXPz2vLNU97BEmQK2XnJyEuKkc8yQc7OvP.jpg', NULL, 0, 1, NULL, '2026-01-23 15:58:40', '2026-01-23 15:58:40'),
(367, 2, 'gallery/2/details\\/367/otIiMGe9kR5st5zkvg2jcelHCKi6uOlgp7iGzhPL.jpg', NULL, 0, 1, NULL, '2026-01-23 15:59:10', '2026-01-23 15:59:10'),
(368, 2, 'gallery/2/details\\/368/htmNOK8CfEk6jgJlR2IqAkd1TQabaYlafYzkRVC8.jpg', NULL, 0, 1, NULL, '2026-01-23 15:59:31', '2026-01-23 15:59:32'),
(369, 2, 'gallery/2/details\\/369/23dueuZTS2oxM9NJmdx0xxZVmKWOYMFyG1d7BwWM.jpg', NULL, 0, 1, NULL, '2026-01-23 15:59:49', '2026-01-23 15:59:49'),
(370, 2, 'gallery/2/details\\/370/wzhQRlTXqRQXWzLJDSBfKWBDsIv8ZdniNah8bKao.jpg', NULL, 0, 1, NULL, '2026-01-23 16:00:13', '2026-01-23 16:00:13'),
(371, 2, 'gallery/2/details\\/371/Dpq114zrBXq9dtqAXtYHpUfIdX3vNdtDTE9CHImd.jpg', NULL, 0, 1, NULL, '2026-01-23 16:00:34', '2026-01-23 16:00:34'),
(372, 16, 'gallery/16/details\\/372/JeHipw06Wgpy7IJEbQe1uoGH11beIC6DKq6e3Dyj.jpg', NULL, 0, 1, NULL, '2026-01-24 00:58:47', '2026-01-24 00:58:47'),
(373, 3, 'gallery/3/details\\/373/O20i8264BU1V26S0mvt2E8oTfJPgPrJZ848DAWVS.jpg', NULL, 0, 1, NULL, '2026-01-24 01:04:25', '2026-01-24 01:04:25'),
(374, 3, 'gallery/3/details\\/374/K0xlt1Ldwvj8rj2BZ0Q2ZWoAV65MI9XkMU2j2QCb.jpg', NULL, 0, 1, NULL, '2026-01-24 01:04:46', '2026-01-24 01:04:46'),
(375, 3, 'gallery/3/details\\/375/jYFFa7lXjLP2Ht070gdHUMj64vTpngFb0Z8HMPho.jpg', NULL, 0, 1, NULL, '2026-01-24 01:05:23', '2026-01-24 01:05:23'),
(376, 3, 'gallery/3/details\\/376/4wVCGibqs8NgXmtPVBkN8Kf6YIhATbEMbbmJIOmT.jpg', NULL, 0, 1, NULL, '2026-01-24 01:05:40', '2026-01-24 01:05:40'),
(377, 3, 'gallery/3/details\\/377/UQ2NfHFIhTmc98EbDq8o07aPU7ibbwWvhJOaiUSu.jpg', NULL, 0, 1, NULL, '2026-01-24 01:05:55', '2026-01-24 01:05:55'),
(378, 3, 'gallery/3/details\\/378/fPHdJBIxZgUgDm2IF3aVPmQ94yeRLNPu52AsJlSv.jpg', NULL, 0, 1, NULL, '2026-01-24 01:06:12', '2026-01-24 01:06:12'),
(379, 3, 'gallery/3/details\\/379/GpCU4d1mLrsekGsmc94v2NCtcXVg4YiXxbp4fcnU.jpg', NULL, 0, 1, NULL, '2026-01-24 01:06:26', '2026-01-24 01:06:26'),
(380, 3, 'gallery/3/details\\/380/KyKGPkoyKxrIo4qWCt0UMrEDWLuYB6sf4JmZ04q7.jpg', NULL, 0, 1, NULL, '2026-01-24 01:06:40', '2026-01-24 01:06:40'),
(381, 3, 'gallery/3/details\\/381/OORXytyccpjVyYFzeLBIF6UcpDSqWXtiQIgKNqki.jpg', NULL, 0, 1, NULL, '2026-01-24 01:06:58', '2026-01-24 01:06:58'),
(382, 3, 'gallery/3/details\\/382/GALVgzEQetdFEvMSjkfYTki5vBVyBfDs0jwExmpq.jpg', NULL, 0, 1, NULL, '2026-01-24 01:07:13', '2026-01-24 01:07:13'),
(383, 3, 'gallery/3/details\\/383/QYMAhNVnEjr7wdnVA4VfnnpMSMpteYlXSFfXwaIX.jpg', NULL, 0, 1, NULL, '2026-01-24 01:07:41', '2026-01-24 01:07:42'),
(384, 3, 'gallery/3/details\\/384/FMyWCQdQIbM3jgO4Tu7L2CXvVV2ZkbixTqrgvsiO.jpg', NULL, 0, 1, NULL, '2026-01-24 01:07:49', '2026-01-24 01:07:49'),
(385, 3, 'gallery/3/details\\/385/XCDi6itxJodg0ZBxmPXGn0SAymvs4vW0rlpPi8RK.jpg', NULL, 0, 1, NULL, '2026-01-24 01:08:02', '2026-01-24 01:08:02'),
(386, 22, 'gallery/22/details\\/386/6CTKTt4Qon60BMzioyuq6yQuIuzLkqNOP6t5Nvfl.jpg', NULL, 0, 1, NULL, '2026-01-24 01:21:50', '2026-01-24 01:21:51'),
(387, 22, 'gallery/22/details\\/387/J8EQEPN6k6etIMrlCga0lbX7llJ0fRSnX19U31X5.jpg', NULL, 0, 1, NULL, '2026-01-24 01:22:05', '2026-01-24 01:22:05'),
(388, 22, 'gallery/22/details\\/388/1FrTqrXiuq8jZNzgw25z915PqCawwVvdO7Bzdo7u.jpg', NULL, 0, 1, NULL, '2026-01-24 01:22:26', '2026-01-24 01:22:26'),
(389, 22, 'gallery/22/details\\/389/k2st4prRYx51TrCgBv9oaXZS1TR6CFTcJehzbhkT.jpg', NULL, 0, 1, NULL, '2026-01-24 01:22:45', '2026-01-24 01:22:46'),
(390, 22, 'gallery/22/details\\/390/rOlcJFsFGyCdZtBlpPisKL7q4FYx2q2FJsK2Nrb3.jpg', NULL, 0, 1, NULL, '2026-01-24 01:23:14', '2026-01-24 01:23:15'),
(391, 22, 'gallery/22/details\\/391/7QuekiNgmiK3BwPjqfocWgixkO4cS1IhNvkfXtwR.jpg', NULL, 0, 1, NULL, '2026-01-24 01:24:39', '2026-01-24 01:24:39'),
(392, 22, 'gallery/22/details\\/392/KDTYWbsmqZE5N1K0JCeYAKXIbbEo7GsAKCwzNI20.jpg', NULL, 0, 1, NULL, '2026-01-24 01:26:44', '2026-01-24 01:26:44'),
(393, 22, 'gallery/22/details\\/393/1GQGpDAQa0cdjhTcXvidTsOGk7JpH1uYzKlxZ7ua.jpg', NULL, 0, 1, NULL, '2026-01-24 01:28:24', '2026-01-24 01:28:24'),
(394, 22, 'gallery/22/details\\/394/0GULAE2ynMkJRurqsX5nlBKmuVJq7K0o6ykeTlNA.jpg', NULL, 0, 1, NULL, '2026-01-24 01:33:22', '2026-01-24 01:33:22'),
(395, 22, 'gallery/22/details\\/395/9rK4PwZgnxTvYgw8pZ4bLAkN7ZsdCHUUbHLWLzkB.jpg', NULL, 0, 1, NULL, '2026-01-24 01:33:41', '2026-01-24 01:33:41'),
(396, 22, 'gallery/22/details\\/396/mHb5GAB3Xs84Pg79CpCgFmXiNjIrkXN7Ld09uaUF.jpg', NULL, 0, 1, NULL, '2026-01-24 01:33:58', '2026-01-24 01:33:58'),
(397, 22, 'gallery/22/details\\/397/NFHC7Fx0gaGlQpshdWrOkfIbWfvb1sCrsiJGjEkO.jpg', NULL, 0, 1, NULL, '2026-01-24 01:34:20', '2026-01-24 01:34:21'),
(398, 22, 'gallery/22/details\\/398/eMZEhdxrPnVAYWnUDp8McAHloDmAhhPqJSNZdvNo.jpg', NULL, 0, 1, NULL, '2026-01-24 01:34:45', '2026-01-24 01:34:45'),
(399, 22, 'gallery/22/details\\/399/TftHcrp0WC1s91cZSVRYV7IES8KoFbWi8Ay3ogak.jpg', NULL, 0, 1, NULL, '2026-01-24 01:35:04', '2026-01-24 01:35:04'),
(400, 22, 'gallery/22/details\\/400/ndKVFs2zKztPRGAIvkTvNFRt3MloVrMcwioECa5g.jpg', NULL, 0, 1, NULL, '2026-01-24 01:35:23', '2026-01-24 01:35:23'),
(401, 22, 'gallery/22/details\\/401/bBZnfvrESOtQD8PfD6fbfaOi7XskNYYJQoHCQ1PO.jpg', NULL, 0, 1, NULL, '2026-01-24 01:35:45', '2026-01-24 01:35:45'),
(402, 22, 'gallery/22/details\\/402/kdxHvtgTG6k1Iv7ByQXTJ27vzHrrX2qnkMj7V1HC.jpg', NULL, 0, 1, NULL, '2026-01-24 01:36:19', '2026-01-24 01:36:19'),
(403, 22, 'gallery/22/details\\/403/tJLFxLDGsACEDrbbDAafB5Xnf83fQI4ioTF1Qxmd.jpg', NULL, 0, 1, NULL, '2026-01-24 01:36:39', '2026-01-24 01:36:39'),
(404, 22, 'gallery/22/details\\/404/9RtX7iKOHlcTvtRrl1AOMMWUSfRZwk2LWeF97apa.jpg', NULL, 0, 1, NULL, '2026-01-24 01:36:57', '2026-01-24 01:36:57'),
(405, 22, 'gallery/22/details\\/405/0ak12qVVobLMMe3mwMpxXvOiZ9MFLooOcieyxl8D.jpg', NULL, 0, 1, NULL, '2026-01-24 01:37:15', '2026-01-24 01:37:15'),
(406, 12, 'gallery/12/details\\/406/Y0lZ9V6LSbfSsffhMQOXIWJeKheInaQzyn6aZimN.jpg', NULL, 0, 1, NULL, '2026-01-24 01:59:23', '2026-01-24 01:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `position`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 'Main Header', 'header', 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(2, 'INFORMATION', 'footer', 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(3, 'NEWS', 'footer', 0, '2025-12-13 08:56:31', '2026-01-15 08:53:48'),
(4, 'Floating Top Menu', 'Floating Top', 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(5, 'Important Links', 'footer', 1, '2026-01-15 08:45:53', '2026-01-15 08:47:04');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `link_type` enum('page','category','url') NOT NULL DEFAULT 'url',
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `url` text DEFAULT NULL,
  `page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `name`, `icon`, `link_type`, `category_id`, `url`, `page_id`, `enabled`, `parent_id`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Home', '', 'url', NULL, '/', NULL, 1, NULL, 1, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(2, 1, 'About', 'fas fa-info-circle', 'url', NULL, '#', NULL, 1, NULL, 2, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(3, 1, 'About Us', NULL, 'url', NULL, '/pages/about-us', NULL, 1, 2, 1, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(4, 1, 'History', NULL, 'url', NULL, '/pages/history', NULL, 1, 2, 2, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(5, 1, 'EC Committee', NULL, 'page', NULL, NULL, 18, 1, 2, 4, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(6, 1, 'Parasports', 'fas fa-futbol', 'url', NULL, NULL, NULL, 1, NULL, 3, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(7, 1, 'Para Athletics', NULL, 'category', 1, 'https://npcbangladesh.org/post-categories/athletics', NULL, 1, 6, 2, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(8, 1, 'Amputee Football', NULL, 'page', 2, NULL, 44, 1, 65, 2, '2025-12-13 08:56:31', '2026-01-28 23:34:31'),
(9, 1, 'Physically Challenged Cricket', NULL, 'category', 3, NULL, 34, 1, 65, 1, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(10, 1, 'Para Badminton', NULL, 'category', 4, 'https://npcbangladesh.org/post-categories/badminton', NULL, 1, 6, 3, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(11, 1, 'Para Swimming', NULL, 'category', 5, 'https://npcbangladesh.org/post-categories/swimming', NULL, 1, 6, 10, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(12, 1, 'Events & Fixtures', 'fas fa-calendar-alt', 'url', NULL, '#', NULL, 1, NULL, 5, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(13, 1, 'Upcoming Events', NULL, 'page', NULL, NULL, 14, 1, 12, 2, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(14, 1, 'Previous Events', NULL, 'page', NULL, NULL, 15, 1, 12, 1, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(15, 1, 'Match Fixtures', NULL, 'url', NULL, '/match-fixtures', NULL, 1, 12, 5, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(16, 1, 'Result', NULL, 'page', NULL, NULL, 13, 1, 12, 3, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(17, 1, 'News & Updates', 'fas fa-newspaper', 'url', NULL, '#', NULL, 1, NULL, 7, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(18, 1, 'Notice Board', NULL, 'url', NULL, '/notice-board', NULL, 1, 17, 1, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(19, 1, 'News', NULL, 'url', NULL, '/news-and-updates', NULL, 1, 17, 2, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(20, 1, 'Spotlights', NULL, 'url', NULL, '/spotlights', NULL, 1, 17, 3, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(21, 1, 'Blog', NULL, 'url', NULL, '/blogs', NULL, 1, 17, 4, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(22, 1, 'Gallery', '', 'url', NULL, '/photo-gallery', NULL, 1, NULL, 10, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(23, 1, 'Contact', 'fas fa-envelope', 'page', NULL, NULL, 2, 1, NULL, 12, '2025-12-13 08:56:31', '2026-01-25 00:10:39'),
(24, 2, 'About Us', NULL, 'page', NULL, NULL, 1, 1, NULL, 1, '2025-12-13 08:56:31', '2026-01-15 12:55:48'),
(25, 2, 'History', NULL, 'page', NULL, NULL, 3, 1, NULL, 2, '2025-12-13 08:56:31', '2026-01-15 12:55:48'),
(26, 2, 'Mission & Vision', NULL, 'page', NULL, NULL, 6, 1, NULL, 3, '2025-12-13 08:56:31', '2026-01-15 12:55:48'),
(27, 2, 'Executive Committee', NULL, 'page', NULL, NULL, 18, 1, NULL, 4, '2025-12-13 08:56:31', '2026-01-15 12:55:48'),
(28, 2, 'FAQs', NULL, 'page', NULL, NULL, 17, 1, NULL, 8, '2025-12-13 08:56:31', '2026-01-15 12:55:48'),
(29, 3, 'News', NULL, 'url', NULL, 'https://npcbangladesh.org/news-and-updates', 16, 1, NULL, 1, '2025-12-13 08:56:31', '2026-01-01 04:35:12'),
(30, 3, 'Athletes', NULL, 'page', NULL, NULL, 10, 1, NULL, 2, '2025-12-13 08:56:31', '2026-01-01 02:05:49'),
(31, 3, 'Event', NULL, 'page', NULL, NULL, 14, 1, NULL, 3, '2025-12-13 08:56:31', '2026-01-01 02:05:49'),
(32, 3, 'Sports', NULL, 'page', NULL, NULL, 4, 1, NULL, 4, '2025-12-13 08:56:31', '2026-01-01 02:06:34'),
(33, 1, 'Athlete Profile', NULL, 'page', NULL, NULL, 10, 1, 2, 7, '2025-12-24 00:05:39', '2026-01-25 00:10:39'),
(34, 1, 'Goalball', NULL, 'category', 7, NULL, NULL, 1, 6, 6, '2025-12-29 08:57:08', '2026-01-25 00:10:39'),
(35, 1, 'Boccia', NULL, 'category', 8, NULL, NULL, 1, 6, 5, '2025-12-29 09:01:10', '2026-01-25 00:10:39'),
(36, 1, 'Sub Committee', NULL, 'page', NULL, NULL, 7, 1, 2, 5, '2025-12-30 05:13:48', '2026-01-25 00:10:39'),
(37, 1, 'Mission Vision', NULL, 'page', NULL, NULL, 6, 1, 2, 3, '2025-12-30 05:14:05', '2026-01-25 00:10:39'),
(38, 1, 'Operation Team', NULL, 'page', NULL, NULL, 8, 1, 2, 6, '2025-12-30 05:14:43', '2026-01-25 00:10:39'),
(39, 1, 'Training & Education', NULL, 'page', NULL, NULL, 5, 0, NULL, 8, '2025-12-30 05:24:44', '2026-01-25 00:10:39'),
(40, 1, 'Accounts & Finance', NULL, 'page', NULL, NULL, 11, 1, NULL, 9, '2025-12-30 05:26:04', '2026-01-25 00:10:39'),
(41, 1, 'Sponsorship', NULL, 'page', NULL, NULL, 12, 1, NULL, 11, '2025-12-30 05:27:25', '2026-01-25 00:10:39'),
(42, 1, 'Para Taekwondo', NULL, 'category', 10, '/', NULL, 1, 6, 12, '2026-01-08 06:20:24', '2026-01-25 00:10:39'),
(43, 1, 'Para Archery', NULL, 'category', 6, '/', NULL, 1, 6, 1, '2026-01-08 06:23:10', '2026-01-25 00:10:39'),
(44, 1, 'Para Table Tennis', NULL, 'category', 11, '/', NULL, 1, 6, 11, '2026-01-08 06:23:15', '2026-01-25 00:10:39'),
(45, 1, 'Wheelchair Basketball', NULL, 'category', 13, NULL, NULL, 1, 6, 13, '2026-01-08 06:29:05', '2026-01-25 00:10:39'),
(46, 1, 'Training & Education', NULL, 'page', NULL, '/', 5, 1, 12, 4, '2026-01-14 06:15:16', '2026-01-25 00:10:39'),
(47, 1, 'Classification by category', NULL, 'category', 15, 'https://npcbangladesh.org/post-categories/para-archery-classification', 25, 1, 52, 1, '2026-01-15 01:26:29', '2026-01-25 00:10:39'),
(48, 2, 'Education and Research', NULL, 'page', NULL, NULL, 26, 1, NULL, 5, '2026-01-15 08:42:04', '2026-01-15 12:55:48'),
(49, 5, 'International Paralympic Committee (IPC)', NULL, 'url', NULL, 'https://www.paralympic.org/', NULL, 1, NULL, 0, '2026-01-15 08:47:42', '2026-01-15 08:52:04'),
(50, 5, 'Asian Paralympic Committee (APC)', NULL, 'url', NULL, 'https://asianparalympic.org/', NULL, 1, NULL, 0, '2026-01-15 08:49:41', '2026-01-15 08:51:03'),
(51, 5, 'DIS', NULL, 'url', NULL, 'https://www.dis.gov.bd/', NULL, 1, NULL, 0, '2026-01-15 09:02:53', '2026-01-15 09:03:07'),
(52, 1, 'Classification', NULL, 'page', NULL, '/', 25, 1, NULL, 4, '2026-01-15 09:30:54', '2026-01-25 00:10:39'),
(53, 2, 'Rehabilitation', NULL, 'page', NULL, NULL, 29, 1, NULL, 6, '2026-01-15 11:03:23', '2026-01-15 15:36:54'),
(54, 1, 'Impact', NULL, 'page', NULL, NULL, 27, 1, NULL, 6, '2026-01-15 12:01:42', '2026-01-25 00:10:39'),
(55, 2, 'Anti-doping', NULL, 'page', NULL, NULL, 28, 1, NULL, 7, '2026-01-15 12:55:33', '2026-01-15 15:24:31'),
(56, 1, 'Classification', NULL, 'category', 15, NULL, NULL, 1, 47, 1, '2026-01-15 13:12:04', '2026-01-25 00:10:39'),
(57, 1, 'National Sports Activities', NULL, 'page', NULL, '/', 30, 1, 14, 1, '2026-01-16 11:01:47', '2026-01-25 00:10:39'),
(58, 1, 'International Participation', NULL, 'page', NULL, NULL, 31, 1, 14, 2, '2026-01-16 11:03:58', '2026-01-25 00:10:39'),
(59, 1, 'National Non-Sports Events', NULL, 'page', NULL, NULL, 35, 1, 14, 3, '2026-01-18 01:56:37', '2026-01-25 00:10:39'),
(60, 1, 'Blind Football', NULL, 'category', 16, NULL, NULL, 1, 6, 4, '2026-01-18 02:24:07', '2026-01-25 00:10:39'),
(61, 1, 'Para Powerlifting', NULL, 'category', 17, NULL, NULL, 1, 6, 7, '2026-01-18 02:27:54', '2026-01-25 00:10:39'),
(62, 1, 'Shooting Para sport', NULL, 'category', 18, NULL, NULL, 1, 6, 8, '2026-01-18 02:39:41', '2026-01-25 00:10:39'),
(63, 1, 'Wheelchair Tennis', NULL, 'category', 19, NULL, NULL, 1, 6, 14, '2026-01-18 02:49:16', '2026-01-25 00:10:39'),
(64, 1, 'Sitting Volleyball', NULL, 'category', 20, NULL, NULL, 1, 6, 9, '2026-01-18 03:41:02', '2026-01-25 00:10:39'),
(65, 1, 'NON-PARALYMPIC SPORTS', NULL, 'category', 21, NULL, 33, 1, 6, 15, '2026-01-18 03:43:26', '2026-01-25 00:10:39'),
(66, 1, 'National Non-Sports Events', NULL, 'page', NULL, NULL, 40, 1, 22, 3, '2026-01-23 11:08:26', '2026-01-25 00:10:39'),
(67, 1, 'International Participation', NULL, 'page', NULL, NULL, 42, 1, 22, 1, '2026-01-23 11:08:45', '2026-01-25 00:10:39'),
(68, 1, 'National Sports Activities', NULL, 'page', NULL, NULL, 41, 1, 22, 2, '2026-01-23 11:09:02', '2026-01-25 00:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_26_092402_create_personal_access_tokens_table', 1),
(5, '2025_10_26_101634_create_permission_tables', 1),
(6, '2025_11_03_132709_create_posts_table', 1),
(7, '2025_11_03_132717_create_pages_table', 1),
(8, '2025_11_06_055546_create_settings_table', 1),
(9, '2025_11_09_144337_create_categories_table', 1),
(10, '2025_11_12_064511_create_menus_table', 1),
(11, '2025_11_12_064833_create_menu_items_table', 1),
(12, '2025_11_17_135016_create_event_categories_table', 1),
(13, '2025_11_17_135115_create_events_table', 1),
(14, '2025_11_17_151810_create_gallery_table', 1),
(15, '2025_11_17_152652_create_gallery_details_table', 1),
(16, '2025_11_18_122343_create_notices_table', 1),
(17, '2025_11_19_075318_create_news_categories_table', 1),
(18, '2025_11_24_132044_create_news_table', 1),
(19, '2025_11_24_144516_create_news_category_maps_table', 1),
(20, '2025_11_25_085628_create_category_maps_table', 1),
(21, '2025_11_29_105325_create_results_table', 1),
(22, '2025_12_07_123236_create_sections_table', 1),
(23, '2025_12_08_110028_create_committee_members_table', 1),
(24, '2025_12_09_121058_create_blogs_table', 1),
(25, '2025_12_09_121346_create_blog_categories_table', 1),
(26, '2025_12_09_121645_create_blog_category_maps_table', 1),
(27, '2025_12_10_124550_create_sliders_table', 1),
(28, '2025_12_13_051149_create_players_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `slug` text NOT NULL,
  `short_des` varchar(255) NOT NULL,
  `f_image` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `createdBy` bigint(20) UNSIGNED NOT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `news_title`, `slug`, `short_des`, `f_image`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `image`, `alt_name`, `publish_date`, `status`, `featured`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh shine with three golds', 'bangladesh-shine-with-three-golds', 'Bangladesh’s para athletes created history at the Asian Youth Para Games 2025 in Dubai, winning five medals—three gold and two bronze—marking the nation’s biggest youth-level para sports achievement.', 'news/LpoJ8TmVBHlQ14FHC9uIgebov93Pn1d9uG4Vr7x2.jpg', '<p style=\"margin-left:0px;text-align:justify;\">Bangladesh’s para athletes made history at the Asian Youth Para Games 2025 in Dubai, returning with an impressive haul of five medals — three gold and two bronze — marking a significant milestone for the nation’s para sports movement.</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">Leading the charge was Chaiti Rani Deb, who exhibited remarkable talent and determination by claiming two gold medals. Despite her small stature, Chaiti dominated the javelin throw with a best effort of 11 metres and followed it up with a stunning gold in the 100-metre sprint, showcasing her versatility and grit.</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">Mohammad Shahidullah was another star performer whose inspiring journey captivated the nation. Competing with a single leg, Shahidullah took gold in the 50-metre freestyle swimming event and secured a bronze in the 100-metre freestyle, exemplifying resilience and exceptional athletic ability.</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">Success also came in team events, as the women’s wheelchair basketball team clinched a bronze medal, further solidifying Bangladesh’s growing stature in continental para sports.</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">This five-medal haul marks the most significant achievement by the National Paralympic Committee of Bangladesh (NPC Bangladesh) at any Asian youth-level competition.&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:!important;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">The medal-winning contingent is scheduled to return to Bangladesh on Monday at 11:00 am, arriving at Hazrat Shahjalal International Airport, where a warm reception awaits them in celebration of their success.</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\"><a href=\"https://www.daily-sun.com/sports/846044/bangladesh-shine-with-three-golds\">https://www.daily-sun.com/sports/846044/bangladesh-shine-with-three-golds</a></p>', 'Historic Success for Bangladesh at Asian Youth Para Games 2025', 'Asian Youth Para Games 2025, Bangladesh Para Athletes, Bangladesh Para Sports, Chaiti Rani Deb, Mohammad Shahidullah, Bangladesh Gold Medals, Para Athletics Bangladesh, Para Swimming Bangladesh, Wheelchair Basketball Bangladesh, National Paralympic Committee of Bangladesh, NPC Bangladesh, Bangladesh Para Team, Para Games Dubai, Bangladesh Sports News, Para Athletes Success', 'Bangladesh’s para athletes made history at the 2025 Asian Youth Para Games, winning 5 medals, including 3 gold, highlighting the nation’s para sports success.', 'news/120CNcrJ7Wv5eOpR5YetzSUxJXUKysNtECTndRym.jpg', 'Esports Bangladesh', '2025-12-11 08:56:31', 1, 1, 1, 1, '2025-12-13 08:56:31', '2026-01-07 04:59:02'),
(2, 'এশিয়ান ইয়ুথ প্যারা গেমসে বাংলাদেশের সাফল্য: ৫ পদক জয়ী দলকে রাষ্ট্রদূত ও কনসাল জেনারেল শুভেচ্ছা', 'এশিয়ান-ইয়ুথ-প্যারা-গেমসে-বাংলাদেশের-সাফল্য:-৫-পদক-জয়ী-দলকে-রাষ্ট্রদূত-ও-কনসাল-জেনারেল-শুভেচ্ছা', 'দুবাইয়ে অনুষ্ঠিত এশিয়ান ইয়ুথ প্যারা গেমসে বাংলাদেশের প্যারা ক্রীড়াবিদরা ইতিহাস সৃষ্টি করেছেন। চৈতী রানী দেব ও শহীদুল্লাহ নেতৃত্বে দলটি তিনটি স্বর্ণ ও দুটি ব্রোঞ্জসহ মোট পাঁচটি পদক জিতে দেশের জন্য গৌরব বয়ে এনেছেন।', 'news/UF9CmvBBDUer3W7uenH1QQHMYuBKhqa9dQLJPfsF.jpg', '<p style=\"margin-left:0px;text-align:justify;\">দুবাইয়ে অনুষ্ঠিত এশিয়ান ইয়ুথ প্যারা গেমসে এক ঐতিহাসিক সাফল্য অর্জন করেছে বাংলাদেশের শারীরিক প্রতিবন্ধী ক্রীড়াবিদরা। তিনটি স্বর্ণ ও দুটি ব্রোঞ্জসহ মোট পাঁচটি পদক জিতে দেশের জন্য এক অনন্য গৌরব নিয়ে আসছেন এই অদম্য ক্রীড়াবিদরা। পদকজয়ী এই দলটি আজ (সোমবার) সকাল ১১টায় হযরত শাহজালাল আন্তর্জাতিক বিমান বন্দরে এসে পৌঁছবে।</p><p style=\"margin-left:0px;text-align:justify;\">স্বাভাবিক ক্রীড়াবিদরা যেখানে এশিয়ান পর্যায়ে পদক জিততে হিমশিম খান, সেখানে প্যারা গেমসের মঞ্চে লাল-সবুজের পতাকা উঁচিয়ে ধরেছেন এই শারীরিক প্রতিবন্ধী তারকারা। এই সাফল্যের মূল কান্ডারি হলেন দুইজন অদম্য ক্রীড়াবিদ: চৈতী রানী দেব এবং শহিদুল্লাহ।</p><p style=\"margin-left:0px;text-align:justify;\">চৈতী রানী দেব উচ্চতায় খুবই ছোট এই ক্রীড়াবিদ একাই দুটি স্বর্ণপদক জিতেছেন। তিনি জ্যাভলিন থ্রোতে ১১ মিটার দূরত্বে বর্শা নিক্ষেপ করে একটি এবং ১০০ মিটার স্প্রিন্টে আরেকটি স্বর্ণপদক অর্জন করেন।</p><p style=\"margin-left:0px;text-align:justify;\">সাধারণ মানুষের মতো দু’টি পা না থাকা সত্ত্বেও, শুধুমাত্র এক পায়ে সাঁতর কেটে শহিদুল্লাহ দেশের জন্য একটি স্বর্ণ ও একটি ব্রোঞ্জ পদক ছিনিয়ে এনেছেন। তিনি ৫০ মিটার ফ্রিস্টাইলে স্বর্ণ এবং ১০০ মিটার ফ্রিস্টাইলে একটি ব্রোঞ্জ পদক জেতেন।<br>এছাড়া, মেয়েদের হুইলচেয়ার বাস্কেটবল দলও একটি ব্রোঞ্জ পদক অর্জন করেছে।</p><p style=\"margin-left:0px;text-align:justify;\">এদিকে দুবাই আন্তর্জাতিক বিমানবন্দরে পদকজয়ী এই ক্রীড়াবিদদের ফুলের তোড়া দিয়ে উষ্ণ শুভেচ্ছা জানান আমিরাতে নিযুক্ত বাংলাদেশের রাষ্ট্রদূত তারেক আহমেদ এবং কনসাল জেনারেল মুহাম্মদ রাশেদুজ্জামান।</p><p style=\"margin-left:0px;text-align:justify;\">এসময় দেশের জন্য এই গৌরব বয়ে আনায় প্রবাসী বাংলাদেশিদের পক্ষ থেকে এই অদম্য ক্রীড়াবিদদের শুভেচ্ছা জানিয়েছেন।</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\"><a href=\"https://amadermuktokantho.com/%E0%A6%8F%E0%A6%B6%E0%A6%BF%E0%A6%AF%E0%A6%BC%E0%A6%BE%E0%A6%A8-%E0%A6%87%E0%A6%AF%E0%A6%BC%E0%A7%81%E0%A6%A5-%E0%A6%AA%E0%A7%8D%E0%A6%AF%E0%A6%BE%E0%A6%B0%E0%A6%BE-%E0%A6%97%E0%A7%87%E0%A6%AE/\">https://amadermuktokantho.com/%E0%A6%8F%E0%A6%B6%E0%A6%BF%E0%A6%AF%E0%A6%BC%E0%A6%BE%E0%A6%A8-%E0%A6%87%E0%A6%AF%E0%A6%BC%E0%A7%81%E0%A6%A5-%E0%A6%AA%E0%A7%8D%E0%A6%AF%E0%A6%BE%E0%A6%B0%E0%A6%BE-%E0%A6%97%E0%A7%87%E0%A6%AE/</a></p>', 'Bangladesh Wins 3 Gold and 2 Bronze at Asian Youth Para Games 2025', 'Asian Youth Para Games 2025, Bangladesh Para Athletes, Chaiti Rani Deb, Mohammad Shahidullah, Bangladesh Para Sports, Bangladesh Gold Medal, Para Swimming Bangladesh, Para Athletics Bangladesh, Wheelchair Basketball Bangladesh, NPC Bangladesh, Bangladesh Para Team, Dubai Para Games, Para Athletes Bangladesh, Bangladesh Sports News, Para Games Achievement', 'Bangladesh’s para athletes made history at the 2025 Asian Youth Para Games, winning 5 medals, including 3 gold, marking a major milestone for the nation’s para sports.', 'news/BSEjnixTH3DosYE6ANMSeil4aNIasr2vVzTLplp3.jpg', 'World Games', '2025-12-08 08:56:31', 1, 1, 1, 1, '2025-12-13 08:56:31', '2026-01-07 04:54:45'),
(3, 'দুবাইয়ে চৈতী-শহিদুল্লাহর তিন স্বর্ণপদক অর্জন', 'দুবাইয়ে-চৈতী-শহিদুল্লাহর-তিন-স্বর্ণপদক-অর্জন', 'চৈতী রাণী দেব ও মো. শহীদুল্লাহ নেতৃত্বে বাংলাদেশ জিতল ৩ স্বর্ণ ও ২ ব্রোঞ্জ পদক, ২০২৫ এশিয়ান ইয়ুথ প্যারা গেমসে দেশের প্যারা ক্রীড়াঙ্গনে ইতিহাস সৃষ্টি করে।', 'news/ETrHEv2e2VrvU0NgacmwQorCB1syHSixUaLclqsh.jpg', '<p data-pm-slice=\"0 0 []\">দুবাইয়ে অনুষ্ঠিত এশিয়ান ইয়ুথ প্যারা গেমসের জ্যাভলিন থ্রো এবং ১০০ মিটার দৌড়ে একটি করে মোট দুটি স্বর্ণপদক জিতেছেন বাংলাদেশের চৈতি রাণী দেব। সাঁতারের ৫০ মিটার ফ্রি স্টাইলে স্বর্ণপদক এবং ১০০ মিটার ফ্রি স্টাইলে ব্রোঞ্জ জয় করেছেন মো. শহীদুল্লাহ। মেয়েদের হুইলচেয়ার বাস্কেটবল টিম খেলায় ব্রোঞ্জ পেয়েছে বাংলাদেশ।</p><p>বাংলাদেশের প্রতিভাবান এই অ্যাথলেটদের অসাধারণ অর্জন তাঁদের দৃঢ় মনোবল, অধ্যবসায় ও অনন্য ক্রীড়া দক্ষতার উৎকৃষ্ট প্রমাণ। চৈতি ও শহীদুল্লাহর সাফল্য শুধু ব্যক্তিগত মাইলফলক নয়; এটি বাংলাদেশের প্যারা ক্রীড়াঙ্গনের জন্য এক ঐতিহাসিক অর্জন, যা দেশের সকল প্রতিবন্ধী ক্রীড়াবিদের সম্ভাবনার উজ্জ্বল প্রতীক।</p><p>চৈতি ও শহীদুল্লাহর সাফল্য সরকার ও বেসরকারি প্রতিষ্ঠানের আরও শক্তিশালী সহযোগিতা ও সমর্থনের প্রয়োজনীয়তা তুলে ধরে। বাংলাদেশের প্যারা অলিম্পিক আন্দোলনকে এগিয়ে নিতে বাড়তি অর্থায়ন, অন্তর্ভুক্তিমূলক ক্রীড়া কর্মসূচি, সহজপ্রাপ্য প্রশিক্ষণ কেন্দ্র এবং প্রতিবন্ধী অ্যাথলেটদের জন্য দীর্ঘমেয়াদি উন্নয়ন কাঠামো অত্যন্ত জরুরি। সম্মিলিত উদ্যোগই নিশ্চিত করতে পারে দেশের প্রত্যন্ত অঞ্চলের প্রতিশ্রুতিশীল অ্যাথলেটরা তাঁদের সর্বোচ্চ সম্ভাবনা বাস্তবায়নের সুযোগ পাবেন।</p><p>দুবাই ২০২৫ এশিয়ান ইয়ুথ প্যারা গেমসে তাঁদের বিজয় বাংলাদেশের প্যারালিম্পিক অগ্রযাত্রায় গুরুত্বপূর্ণ মাইলফলক, যা অন্তর্ভুক্তিমূলক ক্রীড়া বিকাশে নতুন উদ্দীপনা সঞ্চার করবে এবং দেশের প্যারা অ্যাথলেটদের অসামান্য সক্ষমতাকে জাতির সামনে আরও উজ্জ্বলভাবে উপস্থাপন করবে।</p>', 'Bangladesh Wins 3 Gold and 2 Bronze at 2025 Asian Youth Para Games', 'Bangladesh Para Athletes, Asian Youth Para Games 2025, Chaiti Rani Deb, Mohammad Shahidullah, Bangladesh Para Sports, Gold Medal Bangladesh, Bronze Medal Bangladesh, Para Swimming Bangladesh, Para Athletics Bangladesh, Wheelchair Basketball Bangladesh, NPC Bangladesh, Bangladesh Para Team, Dubai Para Games, Para Athletes Success, Inclusive Sports Bangladesh', 'Bangladesh’s para athletes made history at the 2025 Asian Youth Para Games, winning 3 gold and 2 bronze medals, marking a major milestone in national para sports.', 'news/62YDeasZqgQI7XZGMD9G5GN649p0sZPBSi1lxPBr.jpg', 'Gaming Industry', '2025-12-06 08:56:31', 0, 0, 1, 1, '2025-12-13 08:56:31', '2026-01-01 04:09:59'),
(4, 'বাংলাদেশি অ্যাথলেট চৈতি রাণী দেব দুবাই এশিয়ান ইয়ুথ প্যারা গেমসে স্বর্ণপদক অর্জন', 'বাংলাদেশি-অ্যাথলেট-চৈতি-রাণী-দেব-দুবাই-এশিয়ান-ইয়ুথ-প্যারা-গেমসে-স্বর্ণপদক-অর্জন', 'মৌলভীবাজারের চৈতি রাণী দেব দুবাই এশিয়ান ইয়ুথ প্যারা গেমসে জ্যাভেলিন ইভেন্টে স্বর্ণপদক জিতে বাংলাদেশের প্যারা ক্রীড়াঙ্গনে ঐতিহাসিক সাফল্য অর্জন করেছেন।', 'news/4/images/f-image/news_f_image_6955ed8b4b49f.jpg', '<p style=\"margin-left:0px;text-align:justify;\">মৌলভীবাজারের শ্রীমঙ্গলের প্রান্তিক জনপদ থেকে উঠে আসা প্রতিভাবান প্যারা অ্যাথলেট চৈতি রাণী দেব দুবাইয়ে অনুষ্ঠিত এশিয়ান ইয়ুথ প্যারা গেমসে জ্যাভেলিন ইভেন্টে স্বর্ণপদক জিতেছে। চৈতির সাফল্য শুধু ব্যক্তিগত মাইলফলক নয়; এটি বাংলাদেশের প্যারা ক্রীড়াঙ্গনের জন্য এক অবিস্মরণীয় অর্জন।</p><p style=\"margin-left:0px;text-align:justify;\">প্যারালিম্পিক গেমসে “জেভলিন থ্রো”তে ব্রোঞ্জ মেডেল পেয়েছে বলে প্রথমে ঘোষণা আসে। পরে তার ফলাফলকে চ্যালেঞ্জ করা হলে সেটি পরিবর্তন হয়, অতঃপর সে “গোল্ড মেডেল” অর্জন করে দেশের মান উজ্জ্বল করে। চৈতী যেন এক বিস্ময়।</p><p style=\"margin-left:0px;text-align:justify;\">এবার বিশ্ব প্যারা অলিম্পিক গেমস ২০২৫ অনুষ্ঠিত হচ্ছে “দুবাই”য়ে। শনিবার থেকে শুরু এ গেমসে আমাদের শ্রীমঙ্গলের ভূনবীর দশরথ হাইস্কুল এন্ড কলেজের ৮ম শ্রেণির ছাত্রী “চৈতী” বাংলাদেশের হয়ে প্রতিনিধিত্ব করছে।</p><p style=\"margin-left:0px;text-align:justify;\">ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশ (এনপিসি বাংলাদেশ) ২০২৫ জাতীয় যুব প্যারা গেমস চলাকালে কঠোর প্রতিভা অনুসন্ধান কার্যক্রমের মাধ্যমে চৈতির সম্ভাবনা শনাক্ত করে।</p><p style=\"margin-left:0px;text-align:justify;\">চৈতি এক মাসব্যাপী নিবিড় প্রশিক্ষণ ক্যাম্পে অংশগ্রহণ করে। যেখানে প্রশিক্ষকরা তার দক্ষতা শানিত করা, শারীরিক সক্ষমতা বৃদ্ধি এবং আন্তর্জাতিক প্রতিযোগিতার উপযোগী প্রস্তুতি নিশ্চিত করতে নিবিড়ভাবে সহায়তা করেন। এই পরিকল্পিত ও কাঠামোবদ্ধ প্রস্তুতি চৈতির প্রাকৃতিক প্রতিভাকে আন্তর্জাতিক মানে উন্নীত করতে গুরুত্বপূর্ণ ভূমিকা রাখে।</p><p style=\"margin-left:0px;text-align:justify;\">এনপিসি বাংলাদেশ এক বিবৃতিতে জানায়, ‘চৈতির অর্জন প্রমাণ করে—প্রতিভার প্রাথমিক শনাক্তকরণ, পদ্ধতিগত প্রশিক্ষণ অত্যন্ত গুরুত্বপূর্ণ। পাশাপাশি জাতীয় পর্যায়ে প্যারা অ্যাথলেটদের প্রতি নিয়মিত বিনিয়োগ অপরিহার্য। যথাযথ লালন-পালন, আধুনিক সুবিধা ও উচ্চমানে প্রশিক্ষণ নিশ্চিত করা হলে বাংলাদেশের আরো বহু প্যারা অ্যাথলেট বিশ্বমঞ্চে সাফল্য অর্জন করতে সক্ষম হবেন।’</p><p style=\"margin-left:0px;text-align:justify;\">অভাবনীয় এই সাফল্যে আবেগাপ্লুত হয়ে ভূনবীর দশরথ হাইস্কুল এন্ড কলেজের অধ্যক্ষ ঝলক চক্রবর্তী বলেন, চৈতী শুধু শ্রীমঙ্গলের বাংলাদেশের হয়ে প্রতিনিধিত্ব করছে। আজ থেকে দশরথ পরিবারের নামটি শুধু দেশের নয় সারা বিশ্বের মানচিত্রে তুলে দেওয়ায় তাকে নিয়ে আমাদের গর্বের যেন শেষ নেই । এগিয়ে যাও চৈতী। আমরা সকলে প্রতি মুহূর্তে শুধুই তোমার সাথেই আছি।</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\"><a href=\"https://ukbdtv.com/news/119246\">https://ukbdtv.com/news/119246</a></p>', 'Chaiti Rani Deb Wins Gold at 2025 Asian Youth Para Games', 'Chaiti Rani Deb, Bangladesh Para Athletes, Asian Youth Para Games 2025, Bangladesh Para Sports, Bangladesh Gold Medal, Para Athletics Bangladesh, Javelin Throw, National Paralympic Committee Bangladesh, NPC Bangladesh, Bangladesh Para Team, Dubai Para Games, Para Athletes Success, Inclusive Sports Bangladesh, Youth Para Games Bangladesh', 'Chaiti Rani Deb from Bangladesh wins gold in javelin at the 2025 Asian Youth Para Games in Dubai, marking a historic achievement in national para sports.', 'news/4/images/image/news_image_6955ed3e6a803.jpg', 'News', '2025-12-03 08:56:31', 1, 1, 1, 1, '2025-12-13 08:56:31', '2026-01-07 04:53:20'),
(5, 'প্যারা ক্রীড়াবিদদের সুযোগ-সুবিধা বাড়ানোর আহ্বান', 'প্যারা-ক্রীড়াবিদদের-সুযোগ-সুবিধা-বাড়ানোর-আহ্বান', 'প্যারা ক্রীড়াবিদদের সীমিত সুযোগ-সুবিধা বাড়ানোর আহ্বান জানিয়েছেন ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের সাধারণ সম্পাদক ড. মারুফ আহমেদ মৃদুল।', 'news/GH6lvFvgRKYffQzSdaKehfdz4VPfZpP4f1P7pbbg.png', '<p>বাংলাদেশের ক্রীড়াঙ্গনে বাকিদের মতো অবদান রেখে চলছেন প্যারা ক্রীড়াবিদরা। তুলনামূলক সুযোগ-সুবিধা সীমিত। তারা পর্যাপ্ত সুযোগ-সুবিধা পেলে আরও সফলতা অর্জন করতে আত্মবিশ্বাসী হবেন। তাই এদের সুযোগ-সুবিধা বাড়ানোর আহ্বান জানিয়েছেন ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের সাধারন সম্পাদক ড. মারুফ আহমেদ মৃদুল। বৃহস্পতিবার জাতীয় ক্রীড়া পরিষদের মিলনায়তনে তারুণ্যের উৎসব ও জুলাই গণঅভ্যুত্থান উপলক্ষ্যে প্যারা স্পোর্টস বিষয়ক সেমিনার ও বিশেষ সভায় এমন কথা বলেন তিনি। ড. মারুফ আহমেদ মৃদুল বলেন, ‘প্যারা অলিম্পিকে বাংলাদেশের প্যারা খেলোয়াড়রা অন্যদের চেয়ে বেশি সফলতার স্বাক্ষর রাখছেন। তাই প্যারা খেলোয়াড়দের দিকে আরো বেশি মনোযোগ ও সুযোগ-সুবিধা বেশি প্রয়োজন। এ বিষয়টি নিয়েই আমাদের কাজ করতে হবে।’</p><p style=\"margin-left:0px;text-align:justify;\">ড. মারুফ আহমেদ আরও বলেন, ‘বিদেশের মাটি থেকে সাধারন ক্রীড়াবিদরা যে পদক জিতে আনেন, তারচেয়ে অনেক বেশি পদক আনেন প্যারা ক্রীড়াবিদরা। তাই সাফল্যের নিরিখে প্যারা ক্রীড়াবিদদের সুযোগ সুবিধা আরও বেশি পাওয়া উচিত।’</p><p style=\"margin-left:0px;text-align:justify;\">সভায় আরও বক্তব্য রাখেন খাদ্য মন্ত্রণালয়ের সচিব ও ন্যাশনাল প্যারা অলিম্পিক কমিটি অব বাংলাদেশের সভাপতি মো. মাসুদুল হাসান, জাতীয় ক্রিকেট দলের সাবেক অধিনায়ক হাবিবুল বাশার সুমন, সাবেক ক্রিকেটার জাবেদ ওমর বেলিম ও সানোয়ার হোসেন। এছাড়া বাংলাদেশ আরচারি ফেডারেশনের সাধারন সম্পাদক তানভীর আহমেদ প্যারা আরচারি ও বিশ্ব আরচারি চ্যাম্পিয়নশিপে নিজের প্রথম অভিজ্ঞতার কথা বলেন।</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\"><a href=\"https://www.dailyamardesh.com/sports/amdj6oe3gceev\">https://www.dailyamardesh.com/sports/amdj6oe3gceev</a></p>', 'প্যারা ক্রীড়াবিদদের সুযোগ-সুবিধা বাড়ানোর আহ্বান ড. মারুফ আহমেদ মৃদুলের', 'Bangladesh para sports, para athletes Bangladesh, Paralympic Bangladesh, National Paralympic Committee of Bangladesh, Dr. Maruf Ahmed Mridul, para sports seminar, Bangladesh sports', 'null', 'news/zO13N0KA509lKXmvRVgezVv2elo5in7BeNrlS3ex.png', 'প্যারা ক্রীড়াবিদদের সুযোগ-সুবিধা', '2025-12-01 08:56:31', 1, 0, 1, 1, '2025-12-13 08:56:31', '2026-01-07 04:44:13'),
(6, 'আম্পুটি ফুটবল উৎসব', 'আম্পুটি-ফুটবল-উৎসব', 'কেউ স্ক্র্যাচে ভর করে খেলেছে। আবার কেউ লাঠি হাতে ভর দিয়েই ফুটবল নিয়ে মেতেছে। শারীরিক এমন প্রতিবন্ধী ফুটবলারদের এক ফুটবল উৎসবে মেতে উঠেন ৪৫ জন আম্পুটি ফুটবলার।', 'news/ZaHiqqgticBFbOtIJ92hlT4fkMiiXvGc2mAfV1Io.jpg', '<p style=\"text-align:justify;\">সোমবার ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের (এনপিসি) আয়োজনে জাতীয় সংসদ ভবনের পাশে ফাইয়াজ স্টেডিয়ামে দিনব্যাপী ফুটবল প্রশিক্ষণ ও ট্র্রায়াল শেষে ২০ জনকে প্রাথমিকভাবে বাছাই করা হয়। যারা আগামীতে ঘরোয়া ও আন্তর্জাতিক আসর মাতাবেন।</p><p style=\"text-align:justify;\">সাবেক তারকা ফুটবলার কায়সার হামিদ অঙ্গহীন ফুটবলারদের অনুষ্ঠানে এসে আবেগে আপ্লুত। তার কথা, ‘আমাদের আল্লাহ সব দিয়েছেন। আমরা দেশের তারকা হয়েছি ফুটবল খেলে। তবে শারীরিকভাবে প্রতিবন্ধীরাও যে এত ভাল ফুটবল খেলে, তা এখানে না আসলে দেখতে পেতাম না। আমি এই খেলোয়াড়দের সঙ্গে থাকব সব সময়।’</p><p style=\"text-align:justify;\">খেলা শেষে বিজয়ীদের হাতে পুরস্কার তুলে দেন যুব ও ক্রীড়া মন্ত্রণালয়ের অতিরিক্ত সচিব মো. সেলিম ফকির ও কায়সার হামিদ। এ সময় সাবেক ফুটবলার মামুনুল ইসলাম, ম্যাঙ্গোলাইন পিএলসির ব্যবস্থাপনা পরিচালক ইয়াকুব সুজন ভূঁইয়া, স্পোর্টস ফর হোপ অ্যান্ড ইন্ডিপেন্ডেন্সের প্রতিষ্ঠাতা ও সিইও শারমিন ফারহান, আইসিআরসির ম্যানেজার সুভাষ সিনহা, এনপিসির সাধারন সম্পাদক ড. মারুফ আহমেদ এবং যুগ্ম সম্পাদক ও সাবেক ক্রিকেটার সানোয়ার হোসেন উপস্থিত ছিলেন।</p><p style=\"text-align:justify;\">&nbsp;</p><p style=\"text-align:justify;\"><a href=\"https://dailyinqilab.com/sports/football/821997\">https://dailyinqilab.com/sports/football/821997</a></p>', '20 Amputee Footballers Selected After NPC Bangladesh Trial', 'Bangladesh amputee football, para football Bangladesh, National Paralympic Committee of Bangladesh, amputee football trial, Fayaz Stadium Dhaka, Kaisar Hamid, para sports Bangladesh', 'After a day-long training and trial organized by the National Paralympic Committee of Bangladesh at Fayaz Stadium, 20 amputee footballers were initially selected to represent the country in future domestic and international competitions.', 'news/OoKEjbU54yDibdOM91j7JiflkjCUXnxbMZX24GfD.jpg', 'Amputee football training and trial organized by NPCB', '2025-11-28 08:56:31', 1, 0, 1, 1, '2025-12-13 08:56:31', '2026-01-07 04:39:22'),
(7, 'তাজউদ্দিন ইনডোর স্টেডিয়ামে প্যারা ব্যাডমিন্টন শুরু', 'তাজউদ্দিন ইনডোর স্টেডিয়ামে প্যারা ব্যাডমিন্টন শুরু', 'শারীরিক প্রতিবন্ধী অ্যাথলেটরা শহীদ তাজউদ্দীন আহমদ ইনডোর স্টেডিয়ামে প্যারা ব্যাডমিন্টন প্রতিযোগিতায় অংশ নিয়ে উৎসাহের সঙ্গে খেলা শেষ করলেন, এবং বিজয়ীদের হাতে পুরস্কার তুলে দেওয়া হলো।', 'news/MylL0306IHhRmiDLucCkQMYst6gIhmEkQRWMVSGb.png', '<p style=\"text-align:justify;\"><strong>ক্রীড়া বার্তা পরিবেশক</strong><br><span style=\"color:rgb(173,167,167);\">বৃহস্পতিবার, ২১ আগস্ট ২০২৫</span></p><p style=\"text-align:justify;\">বৃহস্পতিবার,(২১ আগস্ট ২০২৫)শহিদ তাজউদ্দিন আহমেদ ইনডোর স্টেডিয়ামে শুরু হয়েছে জাতীয় প্যারা ব্যাডমিন্টন চ্যাম্পিয়নশিপের খেলা। ঢাকা এবং দেশের বিভিন্ন জেলার প্রায় একশ’ প্যারা শাটলার খেলতে এসেছেন দুদিনব্যাপী এই টুর্নামেন্টে। এর আগে প্রতিযোগিতার উদ্বোধন করেন জাতীয় ব্যাডমিন্টনের চার সেরা শাটলার খন্দকার আবদুস সোয়াদ, গৌরব সিংহ, উর্মি আক্তার ও নাছিমা খাতুন। তাদেরকে একমঞ্চে নিয়ে আসেন ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের সাধারন সম্পাদক ড. মারুফ আহমেদ মৃদুল।</p><p style=\"text-align:justify;\">প্যারা শাটলারদের উৎসাহ দিতে আসেন জুলাইযোদ্ধা জাভেদ ইকরাম লিওন। গত বছরের ৪ আগষ্ট কাওরানবাজারে অফিস থেকে নেমে বাসায় যাওয়ার সময় যোগ দেন ছাত্র-জনতার গণআন্দোলনে। এরপর বাঁ পায়ে গুলিবিদ্ধ হন তিনি। প্যারা শাটলাদের খেলা দেখতে এসে তিনি বলেন, ‘এখন আমিও তাদের মতো। তাই এ প্যারা শাটলাদেরকে উৎসাহ দিতে এসেছি এখানে।’</p><p style=\"text-align:justify;\">ইয়ামিনের কথা, ‘আমি বিশ্ব আসর থেকে পদক জিতেছি। র‌্যাংকিংয়েও অনেক উন্নতি করেছি। কিন্তু ২০২৩ সালের পর আর কোথাও খেলার জন্য ডাক পাইনি।’ তিনি যোগ করেন, ‘দোকান চালিয়ে খেলতে আসি। যদি আমাদেরকে বেতন দেয়া হতো, তাহলে আমরা প্যারা ব্যাডমিন্টনে আরও বেশি সময় দিয়ে দেশের জন্য আরও পদক জিতে আনতে পারতাম।’ ইয়ামিনের বড় বোনের স্বামী আশরাফ আলী এবার ইয়ামিনের সতীর্থ। তারও উচ্চতা ইয়ামিনের সমান। আশরাফ আলীর কথা, ‘আমরা খেলতে চাই। তবে সে ব্যবস্থা করতে হবে। তবেই না বিদেশ থেকে আমরা পদক আনতে পারব।’</p><p style=\"text-align:justify;\">পাবনার সুজানগরের ছেলে আলমগীর হোসেন মোস্তাকিম। ডান হাত স্বাভাবিকের চেয়ে ছোট। এ নিয়েই সংগ্রাম করে যাচ্ছেন তিনি। পড়ছেন মিরপুর সরকারী বাংলা কলেজে রাষ্ট্রবিজ্ঞান বিভাগে। ছোটবেলায় বন্ধুদের খুনসুটি মনে করে আলমগীর বলেন, ‘ছোটবেলায় যখন বন্ধুদের সঙ্গে খেলতাম, অনুপ্রেরণার বদলে জুটতো মানসিক নির্যাতন।</p><p style=\"text-align:justify;\">বন্ধুরা বলত, যত ভালো খেলিস না কেন কখনো ভালো কোনো জায়গায় যেতে পারবি না।’ তবে র‌্যাকেট হাতে ভালোই খেলছেন তিনি। আলমগীরের কথা, ‘সরকার যদি আমাদের জন্য ভালো কিছু করত, তাহলে আমাদের কারো মুখাপেক্ষি হতে হতো না। আমরা দেশের জন্য সুনাম বয়ে আনতে চাই। এটা যেন নিয়মিত আয়োজন হয়।’</p><p style=\"text-align:justify;\">&nbsp;</p><p style=\"text-align:justify;\">&nbsp;</p><p style=\"text-align:justify;\"><a href=\"https://sangbad.net.bd/news/sports/2025/156013/\">https://sangbad.net.bd/news/sports/2025/156013/</a></p>', 'Para Badminton Competition Concludes at Shaheed Tajuddin Ahmed Indoor Stadium', 'Para Badminton Bangladesh, Shaheed Tajuddin Ahmed Indoor Stadium, Bangladesh Para Athletes, Para Sports Bangladesh, SL-4 Event, SH-6 Event, Wheelchair Badminton, Bangladesh Para Team, Para Athletes Awards, Bangladesh Sports News, NPC Bangladesh, Para Badminton Competition', 'Bangladesh’s para athletes concluded the para badminton competition at Shaheed Tajuddin Ahmed Indoor Stadium, with winners receiving awards and recognition.', 'news/V7LTg4vAFbH678QVMch8WttZOAHNadtYoCi1yqjq.png', 'Bangladesh para athletes competing in para badminton', '2025-11-25 08:56:31', 1, 0, 1, 1, '2025-12-13 08:56:31', '2026-01-07 04:37:51'),
(8, 'ফুলেল সংবর্ধনায় সিক্ত চৈতী-শহিদুল্লাহ', 'ফুলেল-সংবর্ধনায়-সিক্ত-চৈতী-শহিদুল্লাহ', 'মঙ্গলবার সকাল ১১টা। শারীরিক প্রতিবন্ধীদের নিয়ে বিমান বাংলাদেশ এয়ারলাইন্সের বিমানটি অবতরন করে হযরত শাহজালাল আন্তর্জাতিক বিমানবন্দরে।', 'news/7LiX9pThqdhcgKkFYmLuAQDy1mlRIJdt57isFNU6.jpg', '<p style=\"text-align:justify;\">চৈতী রানী দুটি সোনার পদক গলায় এবং শহিদুল্লাহ একটি করে স্বর্ণ ও ব্রোঞ্জপদক গলায় নিয়ে ভিভিআইপি গেট দিয়ে বের হন। ব্রোঞ্জের পদক গলায় ছিল হুইলচেয়ার বাস্কেটবলের মেয়েদের।</p><p style=\"text-align:justify;\">তাদেরকে ফুলেল শুভেচ্ছায় বরন করে নেন জাতীয় ক্রীড়া পরিষদের পরিচালক (ক্রীড়া) আমিনুল এহসান, বাংলাদেশ অলিম্পিক অ্যাসোসিয়েশনের (বিওএ) মহাসচিব জোবায়েদুর রহমান রানা ও উপমহাসচিব এমএ কুদ্দুস খান। দুবাইয়ে ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের ইতিহাসে দুর্দান্ত এই সাফল্যে নড়েচড়ে বসেছে বিওএ ও এনএসসি।</p><p style=\"text-align:justify;\">বিওএর মহাসচিব জোবায়েদুর রহমান জানান, এই অর্জনকে নিয়মিত সাফল্য বানিয়ে নিতে, আরো দায়িত্বশীল পরিকল্পনা হাতে নিতে চান তারা। তার কথা, ‘তাদের এই অসাধারণ অর্জন দৃঢ় মনোবল, অধ্যবসায় ও অনন্য ক্রীড়া দক্ষতার উৎকৃষ্ট প্রমাণ। চৈতি ও শহীদুল্লাহর সাফল্য শুধু ব্যক্তিগত মাইলফলক নয়, এটি বাংলাদেশের প্যারা ক্রীড়াঙ্গনের জন্য এক ঐতিহাসিক অর্জন, যা দেশের সকল প্রতিবন্ধী ক্রীড়াবিদের সম্ভাবনার উজ্জ্বল প্রতীক।’</p><p style=\"text-align:justify;\">এশিয়ান ইয়ুথ প্যারা গেমসে জ্যাভলিন থ্রো ও একশো মিটার দৌড়ে স্বর্ণ জেতেন চৈতি রাণী, সুইমিংয়ে ৫০ মিটার ফ্রি স্টাইলে স্বর্ণ ও ১০০ মিটার ফ্রি স্টাইলে ব্রোঞ্জ জেতেন শহীদুল্লাহ। দলগত ইভেন্ট হুইলচেয়ার বাস্কেটবলে ব্রোঞ্জ জেতে বাংলাদেশ।&nbsp;</p><p style=\"text-align:justify;\">এ সময় ন্যাশনাল প্যারলিম্পিক কমিটি অব বাংলাদেশের মহাসচিব ড. মারুফ আহমেদ মৃদুল ও যুগ্ম মহাসচিব সানোয়ার হোসেন দলের সঙ্গে ছিলেন।<br>&nbsp;</p><p style=\"text-align:justify;\">&nbsp;</p><p style=\"text-align:justify;\"><a href=\"https://protidinerbangladesh.com/index.php/sports/157229/%E0%A6%AB%E0%A7%81%E0%A6%B2%E0%A7%87%E0%A6%B2-%E0%A6%B8%E0%A6%82%E0%A6%AC%E0%A6%B0%E0%A7%8D%E0%A6%A7%E0%A6%A8%E0%A6%BE%E0%A7%9F-%E0%A6%B8%E0%A6%BF%E0%A6%95%E0%A7%8D%E0%A6%A4-%E0%A6%9A%E0%A7%88%E0%A6%A4%E0%A7%80%E0%A6%B6%E0%A6%B9%E0%A7%80%E0%A6%A6%E0%A7%81%E0%A6%B2%E0%A7%8D%E0%A6%B2%E0%A6%BE%E0%A6%B9\">https://protidinerbangladesh.com/index.php/sports/157229/%E0%A6%AB%E0%A7%81%E0%A6%B2%E0%A7%87%E0%A6%B2-%E0%A6%B8%E0%A6%82%E0%A6%AC%E0%A6%B0%E0%A7%8D%E0%A6%A7%E0%A6%A8%E0%A6%BE%E0%A7%9F-%E0%A6%B8%E0%A6%BF%E0%A6%95%E0%A7%8D%E0%A6%A4-%E0%A6%9A%E0%A7%88%E0%A6%A4%E0%A7%80%E0%A6%B6%E0%A6%B9%E0%A7%80%E0%A6%A6%E0%A7%81%E0%A6%B2%E0%A7%8D%E0%A6%B2%E0%A6%BE%E0%A6%B9</a></p>', 'Historic Success for Bangladesh at Asian Youth Para Games', 'Asian Youth Para Games, Bangladesh Para Sports, Chaiti Rani, Shahidullah, Bangladesh Gold Medal, Para Athletics Bangladesh, Para Swimming Bangladesh, Javelin Throw Para, 100m Sprint Para, Wheelchair Basketball Bangladesh, National Paralympic Committee of Bangladesh, NPC Bangladesh, Bangladesh Olympic Association, BOA, National Sports Council Bangladesh, Para Athletes Bangladesh, Bronze Medal Bangladesh, Para Games Dubai, Bangladesh Para Team Success', 'Bangladesh celebrates historic success at the Asian Youth Para Games as Chaiti Rani and Shahidullah win gold medals, boosting the nation’s para sports achievements.', 'news/8/images/image/news_image_695139e47431b.jpeg', 'Expedite facilis imp', '2025-12-14 10:41:45', 1, 1, 1, 1, '2025-12-14 04:41:45', '2026-01-07 05:02:36'),
(9, 'National Youth Para Games 2025 kick off in Dhaka', 'national-youth-para-games-2025-kick-off-in-dhaka', 'The two-day National Youth Para Games 2025 kicked off on Friday with a colorful and inspiring opening ceremony at the Dhaka National Stadium, bringing together more than 200 young athletes with physical disabilities from across the country.', 'news/9/images/f-image/news_f_image_6959666796579.png', '<p style=\"margin-left:0px;\">The event, organized under the Ministry of Youth and Sports and the National Paralympic Committee of Bangladesh (NPC), features competitions in swimming, athletics, and taekwondo.</p><p style=\"margin-left:0px;\">Participants, aged 12 to 20, are competing not only for medals but also for a chance to represent Bangladesh at the Asian Youth Para Games in Dubai later this year.</p><p style=\"margin-left:0px;\">The opening ceremony was inaugurated by Mahbub Ul Alam, secretary of the Ministry of Youth and Sports. Dignitaries present included Kazi Nazrul Islam, executive director of the National Sports Council; former national cricket captain Habibul Bashar; coaches Sanowar Hossain and Javed Omar Belim, and Dr Maruf Ahmed Mridul, secretary of the NPC.</p><p style=\"margin-left:0px;\">“These young athletes have immense potential to bring glory to Bangladesh on the international stage,” said Mahbub Ul Alam during his speech. “With proper training and continuous support, they can achieve excellence in global competitions.”</p><p style=\"margin-left:0px;\">Dr Maruf Ahmed Mridul emphasized that the event is also a crucial selection platform.</p><p style=\"margin-left:0px;\">“The top-performing athletes from this competition will be chosen to represent Bangladesh at the Asian Youth Para Games in Dubai this December,” he said.</p><p style=\"margin-left:0px;\">Earlier in the day, swimming competitions were held at the Syed Nazrul Islam National Swimming Complex, where young swimmers displayed exceptional perseverance and skill. The winners included Pallab Karmakar (Boys S-7), Sumaiya (Girls S-7), Tawhid Kabir (Boys S-14), Akiya (Girls S-14), Sakib Ahmed (Boys S-9), Sagar (Boys S-13), Labib Al Jaris (Boys S-8) and Nasrin (Girls S-8).</p><p style=\"margin-left:0px;\">The final day of the event, Saturday, will feature athletics events at the Dhaka National Stadium and taekwondo competitions at the National Sports Council Gymnasium.</p><p style=\"margin-left:0px;\">With cheers, applause, and heartfelt enthusiasm, the National Youth Para Games has become more than just a sporting event; it stands as a celebration of resilience, inclusion, and the unstoppable spirit of Bangladesh’s youth.</p><p style=\"margin-left:0px;\">&nbsp;</p><p style=\"margin-left:0px;\"><a href=\"https://www.dhakatribune.com/bangladesh/393659/national-youth-para-games-2025-kick-off-in-dhaka\">https://www.dhakatribune.com/bangladesh/393659/national-youth-para-games-2025-kick-off-in-dhaka</a></p>', 'National Youth Para Games 2025 Kicks Off in Dhaka: Path to Dubai Asian Games', 'National Youth Para Games 2025, Paralympic Committee of Bangladesh, Bangladesh para-athletes, Asian Youth Para Games Dubai, Ministry of Youth and Sports Bangladesh, disabled sports Bangladesh, National Youth Para swimming winners, Dr. Maruf Ahmed Mridul, Dhaka National Stadium sports event.', 'Over 200 young athletes competed in the National Youth Para Games 2025 in Dhaka, vying for medals and a spot in the upcoming Dubai Asian Youth Para Games. Organized by the NPC Bangladesh, the event celebrates resilience in swimming, athletics, and taekwondo.', 'news/9/images/image/news_image_695966679084b.png', 'Opening ceremony of National Youth Para Games 2025 at Dhaka National Stadium with young athletes.', '2026-01-03 18:56:39', 1, 1, 1, 1, '2026-01-03 12:56:39', '2026-01-07 05:03:32'),
(10, 'National Youth Para Games 2025 kick off in Dhaka', 'national-youth-para-games', 'The two-day National Youth Para Games 2025 kicked off on Friday with a colorful and inspiring opening ceremony at the Dhaka National Stadium, bringing together more than 200 young athletes with physical disabilities from across the country.', 'news/10/images/f-image/news_f_image_695966e4afe27.png', '<p style=\"margin-left:0px;\">The event, organized under the Ministry of Youth and Sports and the National Paralympic Committee of Bangladesh (NPC), features competitions in swimming, athletics, and taekwondo.</p><p style=\"margin-left:0px;\">Participants, aged 12 to 20, are competing not only for medals but also for a chance to represent Bangladesh at the Asian Youth Para Games in Dubai later this year.</p><p style=\"margin-left:0px;\">The opening ceremony was inaugurated by Mahbub Ul Alam, secretary of the Ministry of Youth and Sports. Dignitaries present included Kazi Nazrul Islam, executive director of the National Sports Council; former national cricket captain Habibul Bashar; coaches Sanowar Hossain and Javed Omar Belim, and Dr Maruf Ahmed Mridul, secretary of the NPC.</p><p style=\"margin-left:0px;\">“These young athletes have immense potential to bring glory to Bangladesh on the international stage,” said Mahbub Ul Alam during his speech. “With proper training and continuous support, they can achieve excellence in global competitions.”</p><p style=\"margin-left:0px;\">Dr Maruf Ahmed Mridul emphasized that the event is also a crucial selection platform.</p><p style=\"margin-left:0px;\">“The top-performing athletes from this competition will be chosen to represent Bangladesh at the Asian Youth Para Games in Dubai this December,” he said.</p><p style=\"margin-left:0px;\">Earlier in the day, swimming competitions were held at the Syed Nazrul Islam National Swimming Complex, where young swimmers displayed exceptional perseverance and skill. The winners included Pallab Karmakar (Boys S-7), Sumaiya (Girls S-7), Tawhid Kabir (Boys S-14), Akiya (Girls S-14), Sakib Ahmed (Boys S-9), Sagar (Boys S-13), Labib Al Jaris (Boys S-8) and Nasrin (Girls S-8).</p><p style=\"margin-left:0px;\">The final day of the event, Saturday, will feature athletics events at the Dhaka National Stadium and taekwondo competitions at the National Sports Council Gymnasium.</p><p style=\"margin-left:0px;\">With cheers, applause, and heartfelt enthusiasm, the National Youth Para Games has become more than just a sporting event; it stands as a celebration of resilience, inclusion, and the unstoppable spirit of Bangladesh’s youth.</p>', 'National Youth Para Games 2025 Kicks Off in Dhaka: Path to Dubai Asian Games', 'National Youth Para Games 2025, Paralympic Committee of Bangladesh, Bangladesh para-athletes, Asian Youth Para Games Dubai, Ministry of Youth and Sports Bangladesh, disabled sports Bangladesh, National Youth Para swimming winners, Dr. Maruf Ahmed Mridul, Dhaka National Stadium sports event.', 'Over 200 young athletes competed in the National Youth Para Games 2025 in Dhaka, vying for medals and a spot in the upcoming Dubai Asian Youth Para Games. Organized by the NPC Bangladesh, the event celebrates resilience in swimming, athletics, and taekwondo.', 'news/10/images/image/news_image_695966e4a962b.png', 'Opening ceremony of National Youth Para Games 2025 at Dhaka National Stadium with young athletes.', '2026-01-03 18:58:44', 0, 0, 1, 1, '2026-01-03 12:58:44', '2026-01-03 13:00:45'),
(11, 'সুইমিং দিয়ে জাতীয় যুব প্যারা গেমস শুরু', 'সুইমিং দিয়ে জাতীয় যুব প্যারা গেমস শুরু', 'তিনটি ইভেন্টে প্রায় দুই শতাধিক শারীরিক প্রতিবন্ধী ক্রীড়াবিদদের অংশগ্রহনে শুরু হয়েছে জাতীয় যুব প্যারা গেমস। ১২-২০ বছর বয়সী ক্রীড়াবিদরা অংশ নিচ্ছেন সুইমিং, দৌড় ও তায়কোয়ান্দো প্রতিযোগিতায়।', 'news/11/images/f-image/news_f_image_695cddadedcc4.jpeg', '<p style=\"text-align:justify;\">শুক্রবার পড়ন্ত বিকালে ঢাকা জাতীয় স্টেডিয়ামে দুই দিনব্যাপী প্রতিযোগিতার উদ্বোধন করেন যুব ও ক্রীড়া মন্ত্রণালয়ের সচিব মাহবুব উল আলম। এ সময় জাতীয় ক্রীড়া পরিষদের নির্বাহী পরিচালক কাজী নজরুল ইসলাম, জাতীয় ক্রিকেট দলের সাবেক অধিনায়ক হাবিবুল বাশার, সানোয়ার হোসেন ও জাভেদ ওমর বেলিম এবং ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের (এনপিসি) মহাসচিব ড. মারুফ আহমেদ মৃদুল উপস্থিত ছিলেন।</p><p style=\"text-align:justify;\">প্রধান অতিথির বক্তব্যে মাহবুব উল আলম বলেন, ‘শারীরিক এই প্রতিবন্ধী খেলোয়াড়রাই বিদেশ থেকে পদক এনে দিতে পারবে। তবে সে জন্য তাদেরকে আরও ভাল খেলা উপহার দিতে হবে। শিখতে হবে। তাহলেই তারা পারবে।’ জাতীয় ক্রীড়া পরিষদের নির্বাহী পরিচালক কাজী নজরুল ইসলাম বলেন, ‘শারীরিক প্রতিবন্ধী হলেও দেশের জন্য নিয়মিত সুনাম বয়ে আনছে তারা। ভবিষ্যতেও আনবে বলে আমার বিশ্বাস। তাদেরকে সব রকম সহযোগিতা করতে আমরা প্রস্তুত।’</p><p style=\"text-align:justify;\">এনপিসির মহাসচিব ড. মারুফ আহমেদের কথা, ‘আগামী ডিসেম্বরে দুবাইয়ে অনুষ্ঠিত হবে এশিয়ান যুব প্যারা গেমস। ওই গেমসের জন্য সেরা মানের ক্রীড়াবিদ বাছাই করব আমরা।</p><p style=\"text-align:justify;\"><span style=\"background-color:rgb(249,249,251);color:rgb(82,82,82);\">এর আগে সকালে শহিদ সৈয়দ নজরুল ইসলাম সুইমিং কমপ্লেক্সে অনুষ্ঠিত হয় সাঁতার ইভেন্ট। ছেলেদের এস-৭ ইভেন্টে পল্লব কর্মকার, মেয়েদের এই ইভেন্টে সুমাইয়া, ছেলেদের এস-১৪ ইভেন্টে তৌহিদ কবির, মেয়েদের এই ইভেন্টে আকিয়া, ছেলেদের এস-৯ ইভেন্টে সাকিব আহমেদ, এস-১৩ ইভেন্টে সাগর, এস-৮ ইভেন্টে লাবিব আল জারিস ও মেয়েদের এস-৮ ইভেন্টে নাসরিন স্বর্ণপদক জেতেন।</span></p><p style=\"text-align:justify;\">পুরস্কার বিতরণ অনুষ্ঠানে প্রধান অতিথি হিসেবে উপস্থিত ছিলেন বাংলাদেশ পুলিশের সম্মানিত যৌথ কমিশনার ও ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের সহ-সভাপতি মোহাম্মদ নাসিরুল ইসলাম। বিশেষ অতিথি হিসেবে উপস্থিত ছিলেন স্পন্সর প্রতিষ্ঠান ফ্রেশওয়ে এগটেক লিমিটেড-এর নির্বাহী পরিচালক আমরীন বশির এবং ব্যবস্থাপনা পরিচালক এবিএম ওবায়েদুল্লাহ। এছাড়া স্পেশাল অলিম্পিকস বাংলাদেশের জাতীয় পরিচালক ফারুকুল ইসলাম, বাংলাদেশ সুইমিং ফেডারেশনের যুগ্ম সম্পাদক নিবেদিতা দাস এবং কোষাধ্যক্ষ মেজর (অব.) মো. আতিকুর রহমানও উপস্থিত ছিলেন বিশেষ অতিথি হিসেবে।</p><p style=\"text-align:justify;\"><br>অনুষ্ঠানে স্বাগত বক্তব্য প্রদান করেন এনপিসি বাংলাদেশের মহাসচিব ডা. মারুফ আহমেদ মৃদুল। অনুষ্ঠানটি সঞ্চালনা করেন হুইলচেয়ার ব্যবহারকারী ও এনপিসি বাংলাদেশের নির্বাহী সদস্য জনাব মো. হেদায়েতুল আজিজ, যার অংশগ্রহণ এই গেমসের অন্তর্ভুক্তিমূলক চেতনার প্রতীক।</p><p style=\"text-align:justify;\">আগামীকাল শনিবার গেমসের শেষ দিনে ঢাকা জাতীয় স্টেডিয়ামে অ্যাথলেটিক্স এবং জাতীয় ক্রীড়া পরিষদের জিমন্যাশিয়ামে তায়কোয়ান্দো ডিসিপ্লিনের খেলা অনুষ্ঠিত হবে।</p><p style=\"text-align:justify;\">&nbsp;</p><p style=\"text-align:justify;\"><a href=\"https://www.jugantor.com/sports/1014531\">https://www.jugantor.com/sports/1014531</a></p>', NULL, NULL, NULL, 'news/11/images/image/news_image_695cddade9d31.jpeg', NULL, '2026-01-06 10:02:21', 1, 0, 1, 1, '2026-01-06 04:02:21', '2026-01-07 05:07:10'),
(12, 'শুরু হলো ন্যাশনাল হুইলচেয়ার বাস্কেটবল চ্যাম্পিয়নশিপ ২০২৫', 'শুরু হলো ন্যাশনাল হুইলচেয়ার বাস্কেটবল চ্যাম্পিয়নশিপ ২০২৫', 'News Clips', 'news/12/images/f-image/news_f_image_695e1c6f70a64.png', '<figure class=\"media\"><div data-oembed-url=\"https://youtube.com/shorts/5P8LPUG2yD8?si=mH1JMqZ6BHsoT7jX\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/5P8LPUG2yD8\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, 'news/12/images/image/news_image_695e1c6f6fe59.png', NULL, '2026-01-07 08:37:57', 1, 0, 1, 1, '2026-01-07 02:37:57', '2026-01-07 03:47:28'),
(13, 'পরিচয় হোক শুধু ক্রিকেটার- তামিম ইকবাল', 'পরিচয় হোক শুধু ক্রিকেটার- তামিম ইকবাল', 'ফিজিক্যালি চ্যালেঞ্জড বা ওমেন্স ক্রিকেট ট্যাগ নয় পরিচয় হোক শুধু ক্রিকেটার- তামিম ইকবাল | Tamim Iqbal', 'news/13/images/f-image/news_f_image_695e2c63718c8.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://www.youtube.com/watch?v=DX7YCtMWv0I\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/DX7YCtMWv0I\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, 'news/13/images/image/news_image_695e2c636c839.PNG', NULL, '2026-01-07 09:50:27', 1, 0, 1, 1, '2026-01-07 03:50:27', '2026-01-07 03:50:27'),
(14, 'ক্রিকেটকে এগিয়ে নিতে সকলকে এগিয়ে আসার আহ্বান তামিমের', 'ক্রিকেটকে এগিয়ে নিতে সকলকে এগিয়ে আসার আহ্বান তামিমের', 'ভেদাভেদ ভুলে ক্রিকেটকে এগিয়ে নিতে সকলকে এগিয়ে আসার আহ্বান তামিমের | Tamim | BCB | Jamuna Sports', 'news/14/images/f-image/news_f_image_695e2d2c0891e.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://www.youtube.com/watch?v=5dROfwAaTOs\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/5dROfwAaTOs\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, 'news/14/images/image/news_image_695e2d2c03021.PNG', NULL, '2026-01-07 09:53:48', 1, 0, 1, 1, '2026-01-07 03:53:48', '2026-01-07 03:53:48'),
(15, 'জাতীয় যুব প্যারা গেমস', 'জাতীয় যুব প্যারা গেমস', 'জাতীয় যুব প্যারা গেমস | নিজেদের সক্ষমতা প্রমাণে শারীরিক প্রতিবন্ধীরা', 'news/15/images/f-image/news_f_image_695e2dfc4cb31.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://www.youtube.com/watch?v=ukGyNyK-Jvg\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/ukGyNyK-Jvg\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, 'news/15/images/image/news_image_695e2dfc428b1.PNG', NULL, '2026-01-07 09:57:16', 1, 0, 1, 1, '2026-01-07 03:57:16', '2026-01-07 03:57:16'),
(16, 'শুরু হলো ন্যাশনাল ইয়ুথ প্যারা গেমস!', 'শুরু হলো ন্যাশনাল ইয়ুথ প্যারা গেমস!', 'মায়ের হাত ধরে ন্যাশনাল স্টেডিয়ামে মেয়ে; শুরু হলো ন্যাশনাল ইয়ুথ প্যারা গেমস! | T Sports News', 'news/16/images/f-image/news_f_image_695e2e8b76ed4.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://www.youtube.com/watch?v=H7qwB-AJpN4\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/H7qwB-AJpN4\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, 'news/16/images/image/news_image_695e2e8b72519.PNG', NULL, '2026-01-07 09:59:39', 1, 0, 1, 1, '2026-01-07 03:59:39', '2026-01-07 03:59:39'),
(17, 'শারীরিক প্রতিবন্ধী ক্রীড়াবিদদের নিয়ে শুরু হলো জাতীয় যুব প্যারা গেমস', 'শারীরিক প্রতিবন্ধী ক্রীড়াবিদদের নিয়ে শুরু হলো জাতীয় যুব প্যারা গেমস', 'শারীরিক প্রতিবন্ধী ক্রীড়াবিদদের নিয়ে শুরু হলো জাতীয় যুব প্যারা গেমস | PARA OLYMPIC | Jamuna TV', 'news/17/images/f-image/news_f_image_695e2f17da57b.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://youtu.be/x0PzWHlWmrM?si=3MWEhjEnKS9BTQar\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/x0PzWHlWmrM\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, 'news/17/images/image/news_image_695e2f17d5c9d.PNG', NULL, '2026-01-07 10:01:59', 1, 0, 1, 1, '2026-01-07 04:01:59', '2026-01-07 04:01:59'),
(18, 'প্যারা স্পোর্টস বিষয়ক সেমিনারে সাবেক ক্রিকেটাররা', 'প্যারা স্পোর্টস বিষয়ক সেমিনারে সাবেক ক্রিকেটাররা', 'তারুণ্যের উৎসব ও জুলাই গণঅভ্যুত্থান দিবস উপলক্ষে প্যারা স্পোর্টস বিষয়ক সেমিনারে সাবেক ক্রিকেটাররা', 'news/18/images/f-image/news_f_image_695e2fd934d7d.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://youtu.be/IDf3OfJ368U?si=d9k_f_aZQGeqPur3\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/IDf3OfJ368U\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, 'news/18/images/image/news_image_695e2fd930396.PNG', NULL, '2026-01-07 10:05:13', 1, 0, 1, 1, '2026-01-07 04:05:13', '2026-01-07 04:05:13'),
(19, 'জাতীয় প্যারা ব্যাডমিন্টন চ্যাম্পিয়নশিপ', 'জাতীয় প্যারা ব্যাডমিন্টন চ্যাম্পিয়নশিপ', 'শারীরিক প্রতিবন্ধীরা জয় করেছেন জাতীয় প্যারা ব্যাডমিন্টন চ্যাম্পিয়নশিপ! | DBC NEWS Specail', 'news/19/images/f-image/news_f_image_695e30865b337.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://youtu.be/x0DRJ4aRwYU?si=kctS_2MkXoE67nVe\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/x0DRJ4aRwYU\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, 'news/19/images/image/news_image_695e31011cab9.PNG', NULL, '2026-01-07 10:08:06', 1, 0, 1, 1, '2026-01-07 04:08:06', '2026-01-07 04:10:09'),
(20, 'প্যারা ব্যাডমিন্টনে দেশের ইতিহাসে প্রথম আয়োজন', 'প্যারা ব্যাডমিন্টনে দেশের ইতিহাসে প্রথম আয়োজন', 'প্যারা ব্যাডমিন্টনে দেশের ইতিহাসে প্রথম আয়োজন | Para Badminton | Para Olympics | Somoy Sports', 'news/20/images/f-image/news_f_image_695e31f216924.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://youtu.be/OiVw560Tan4?si=OBfj7hA7cxv5l87M\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/OiVw560Tan4\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, NULL, NULL, '2026-01-07 10:14:10', 1, 0, 1, 1, '2026-01-07 04:14:10', '2026-01-07 04:14:10'),
(21, 'সফলভাবে আয়োজিত হয়েছে \"ন্যাশনাল প্যারা ব্যাডমিন্টন চ্যাম্পিয়নশিপ', 'সফলভাবে আয়োজিত হয়েছে \"ন্যাশনাল প্যারা ব্যাডমিন্টন চ্যাম্পিয়নশিপ', 'এনপিসি বাংলাদেশের উদ্যোগে সফলভাবে আয়োজিত হয়েছে \"ন্যাশনাল প্যারা ব্যাডমিন্টন চ্যাম্পিয়নশিপ\"  Channel i Sports', 'news/21/images/f-image/news_f_image_695e32c6419f6.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://youtu.be/E67poRJXORg?si=5tS7lQ7rOFqyE6f6\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/E67poRJXORg\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, NULL, NULL, '2026-01-07 10:17:42', 1, 0, 1, 1, '2026-01-07 04:17:42', '2026-01-07 04:17:42'),
(22, 'প্যারা অ্যাথলেটদের নিয়ে ভিন্ন ভাবনা', 'প্যারা অ্যাথলেটদের নিয়ে ভিন্ন ভাবনা', 'প্যারা অ্যাথলেটদের নিয়ে ভিন্ন ভাবনা | Para Athletes | Deepto Sports', 'news/22/images/f-image/news_f_image_695e33741452c.PNG', '<figure class=\"media\"><div data-oembed-url=\"https://youtu.be/ODQXgj1N-Go?si=hjU6HtD4eSY7P3wH\"><div style=\"position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/ODQXgj1N-Go\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen=\"\"></iframe></div></div></figure>', NULL, NULL, NULL, NULL, NULL, '2026-01-07 10:20:36', 1, 0, 1, 1, '2026-01-07 04:20:36', '2026-01-07 04:20:36'),
(24, 'News Paper Cutting', 'news-paper-cutting', 'News Paper Cutting', 'news/24/images/f-image/news_f_image_695eba78ca702.jpeg', '<p>News Paper Cutting</p><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23247-PM_1767880028.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23246-PM_1767880026.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23245-PM_1767880025.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23245-PM-1_1767880022.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23242-PM_1767880021.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23242-PM-1_1767880019.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23241-PM_1767880017.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23240-PM_1767880017.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23236-PM_1767880013.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23235-PM_1767880012.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23231-PM_1767880011.jpeg\"></figure><p>&nbsp;</p><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23229-PM_1767880007.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23228-PM_1767880007.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23228-PM-2_1767880006.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23228-PM-1_1767880005.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23227-PM_1767880004.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23221-PM_1767880003.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23219-PM_1767880002.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23219-PM-1_1767880001.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23215-PM_1767880000.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23214-PM_1767879999.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23214-PM-1_1767879997.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2025-10-27-at-23213-PM_1767879995.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/5_1767879994.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/4_1767879993.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/3_1767879992.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/2_1767879986.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/1_1767879986.jpeg\"></figure>', NULL, NULL, NULL, NULL, NULL, '2026-01-07 19:56:40', 1, 0, 1, 1, '2026-01-07 13:56:40', '2026-01-08 07:59:46'),
(25, 'Dubai 2025 Asian Youth Para Games', 'dubai-2025-asian-youth-para-games', 'Team Bangladesh achievement', 'news/25/images/f-image/news_f_image_696240554a0aa.png', '<p><strong>Historic Gold:</strong> <strong>Chaiti Rani Deb</strong> made history by winning Bangladesh\'s first-ever gold medal at the Games in the <strong>Javelin Throw</strong> (Para Athletics). She later secured a second gold in the <strong>100m race</strong>.</p><p>&nbsp;</p><p><strong>Swimming Success:</strong> <strong>Md Shahidullah</strong> delivered an outstanding performance in the pool, winning <strong>Gold</strong> in the 50m freestyle and a <strong>Bronze</strong> in the 100m freestyle.</p>', NULL, NULL, NULL, 'news/25/images/image/news_image_6962405546093.jpeg', NULL, '2026-01-10 12:04:37', 0, 0, 1, 1, '2026-01-10 06:04:37', '2026-01-10 21:51:47'),
(26, 'Team Bangladesh on Dubai 2025 Asian Youth Para Games', 'team-bangladesh-on-dubai-2025-asian-youth-para-games', 'Team-bangladesh-on-dubai-2025-asian-youth-para-games', 'news/26/images/f-image/news_f_image_6962669c2ec36.jpg', '<figure class=\"image\"><img src=\"/public/storage/uploads/Bangladesh-at-the-Team-Parade-during-the-Dubai-2025-Asian-Youth-Para-Games-1536x1022_1768056402.jpg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-10-at-83913-PM_1768055995.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-101253-AM_1768056000.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-101253-AM-1_1768055998.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/image_1768055996.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/sdaae-693bfba253521_1768056332.jpg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/untitled-1-20251213225234_1768056332.jpg\"></figure>', NULL, NULL, NULL, NULL, NULL, '2026-01-10 14:47:55', 1, 0, 1, 1, '2026-01-10 08:47:55', '2026-01-10 08:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

CREATE TABLE `news_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `createdBy` int(10) UNSIGNED DEFAULT NULL,
  `updatedBy` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_categories`
--

INSERT INTO `news_categories` (`id`, `slug`, `parent_id`, `category_name`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `image`, `alt_name`, `sort_order`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'games', NULL, 'Games', 'Games related news and articles', 'Games', 'Latest Games news, updates and analysis', 'government,elections,policy', 'https://placehold.co/600x400?text=Games', 'Games Alt', 1, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-22 12:00:51'),
(2, 'spotlight', 2, 'Spotlights', 'Bangladesh shine with three golds.\r\nBangladesh’s para athletes made history at the Asian Youth Para Games 2025 in Dubai, returning with an impressive haul of five medals — three gold and two bronze — marking a significant milestone for the nation’s para sports movement.', 'Spotlight', 'Bangladesh’s para athletes achieved a historic success at the Asian Youth Para Games 2025 in Dubai, winning five medals including three gold and two bronze, marking the nation’s biggest youth-level para sports achievement.', 'Bangladesh para athletes, Asian Youth Para Games 2025, NPC Bangladesh, para sports Bangladesh, para athletics, Bangladesh sports news, Dubai para games, youth para athletes', 'news_categories/VhW8ruIDq8xev3uzWmcO6kEBUTqMrh0la6JqenUL.jpg', 'Spotlight Alt', 1, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-22 12:16:22'),
(3, 'technology', NULL, 'Technology', 'Technology related news and articles', 'Technology', 'Latest Technology news, updates and analysis', 'tech,innovation,startups', 'https://placehold.co/600x400?text=Technology', 'Technology Alt', 3, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(4, 'sports', NULL, 'Sports', 'Sports related news and articles', 'Sports', 'Latest Sports news, updates and analysis', 'football,cricket,basketball', 'https://placehold.co/600x400?text=Sports', 'Sports Alt', 4, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31'),
(5, 'entertainment', NULL, 'Entertainment', 'Entertainment related news and articles', 'Entertainment', 'Latest Entertainment news, updates and analysis', 'movies,music,celebrities', 'https://placehold.co/600x400?text=Entertainment', 'Entertainment Alt', 5, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-13 08:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `news_category_maps`
--

CREATE TABLE `news_category_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `news_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_category_maps`
--

INSERT INTO `news_category_maps` (`id`, `news_id`, `news_category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 4, NULL, NULL),
(3, 3, 3, NULL, NULL),
(4, 3, 2, NULL, NULL),
(5, 4, 3, NULL, NULL),
(6, 4, 1, NULL, NULL),
(7, 5, 1, NULL, NULL),
(8, 6, 4, NULL, NULL),
(9, 6, 1, NULL, NULL),
(12, 8, 4, NULL, NULL),
(13, 7, 5, NULL, NULL),
(15, 9, 4, NULL, NULL),
(17, 10, 4, NULL, NULL),
(24, 11, 1, NULL, NULL),
(25, 11, 2, NULL, NULL),
(26, 12, 5, NULL, NULL),
(27, 13, 4, NULL, NULL),
(28, 14, 4, NULL, NULL),
(29, 15, 4, NULL, NULL),
(30, 16, 4, NULL, NULL),
(31, 17, 4, NULL, NULL),
(32, 18, 4, NULL, NULL),
(33, 19, 4, NULL, NULL),
(34, 20, 4, NULL, NULL),
(35, 21, 4, NULL, NULL),
(36, 22, 4, NULL, NULL),
(38, 24, 4, NULL, NULL),
(39, 25, 2, NULL, NULL),
(40, 26, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = General Notice, 1 = Match Fixtures',
  `createdBy` bigint(20) UNSIGNED DEFAULT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `slug`, `description`, `file`, `status`, `type`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'Office Will Remain Closed on Friday', 'office-will-remain-closed-on-friday', '<p>The office will remain closed due to maintenance work.</p>', 'notices/kCkaF40cVHhix3nQx2TH0ncaHS9LpA6yQVBvh9jU.pdf', '1', 0, 1, 1, '2025-12-13 08:56:31', '2025-12-23 00:44:12'),
(7, 'Physically Challenged Cricket Tournament 2025', 'physically-challenged-cricket-tournament-2025', '<p><meta charset=\"utf-8\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-a8e3a1e3-7fff-10ef-3b35-6d0af492d37c\"><span style=\"font-family:Roboto,sans-serif;font-size:13.999999999999998pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Physically Challenged Cricket Tournament 2025</strong></span></b></span></p>', 'notices/RrVvvXS7hRJsnOI05kBfT2kj3hRFTV43esfLGjpp.pdf', '1', 1, 1, 1, '2025-12-23 00:40:27', '2025-12-27 07:06:04'),
(8, 'গভীর শোক প্রকাশ', 'গভীর শোক প্রকাশ', '<p><span style=\"color:hsl(0,0%,0%);\">গভীর শোক প্রকাশ</span><br><span style=\"color:hsl(0,0%,0%);\">গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের সাবেক প্রধানমন্ত্রী, দেশনেত্রী ও বিএনপির চেয়ারপার্সন বেগম খালেদা জিয়া আজ ৩০ ডিসেম্বর ২০২৫, মঙ্গলবার ভোর ৬টায় এভারকেয়ার হাসপাতালে ইন্তেকাল করেছেন (ইন্না লিল্লাহি ওয়া ইন্না ইলাইহি রাজিউন)।</span><br><span style=\"color:hsl(0,0%,0%);\">বাংলাদেশ ও জাতির এই ক্রান্তিকালে তাঁর প্রয়াণে একটি অপূরণীয় শূন্যতা সৃষ্টি হলো।</span><br><span style=\"color:hsl(0,0%,0%);\">ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের পক্ষ থেকে আমরা গভীর শোক প্রকাশ করছি এবং শোকসন্তপ্ত পরিবার ও দেশবাসীর প্রতি সমবেদনা জানাচ্ছি। মহান আল্লাহ তায়ালা মরহুমার বিদেহী আত্মাকে জান্নাতুল ফেরদৌস নসীব করুন—আমীন।</span></p>', 'notices/8/notice_file_69558ac4d0e54.pdf', '1', 0, 1, 1, '2025-12-31 14:25:23', '2025-12-31 14:42:44'),
(9, 'New Delhi World Para Athletics Championship 2025', 'new-delhi-world-para-athletics-championship-2025', '<p>null</p>', 'notices/9/notice_file_69623cafd3b11.pdf', '1', 0, 1, 1, '2026-01-10 05:49:03', '2026-01-10 07:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `temp` varchar(255) DEFAULT 'default',
  `page_title` varchar(255) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `breadcrumb` varchar(500) NOT NULL,
  `short_des` varchar(255) DEFAULT NULL,
  `page_description` longtext DEFAULT '',
  `f_image` varchar(255) DEFAULT '',
  `meta_title` varchar(255) DEFAULT '',
  `meta_description` varchar(255) DEFAULT '',
  `meta_keyword` varchar(255) DEFAULT '',
  `status` enum('Active','Inactive') NOT NULL,
  `createdBy` bigint(20) UNSIGNED NOT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `temp`, `page_title`, `slug`, `breadcrumb`, `short_des`, `page_description`, `f_image`, `meta_title`, `meta_description`, `meta_keyword`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'default', 'About Us', 'about-us', 'About Us', 'Excepturi omnis sit voluptates qui iure facere ea qui iste est possimus vel non.', '<p>The National Paralympic Committee of Bangladesh (NPC Bangladesh) is a para-athlete-centered non-profit national organization, affiliated with <a href=\"https://www.paralympic.org/?_gl=1*1lg15x9*_up*MQ..*_gs*MQ..&amp;gclid=Cj0KCQiAg63LBhDtARIsAJygHZ6iVv6p_N21JNHDNbverKWDLuSK9nOPNEIByT5DFIEwssKwLpu11mQaAv8YEALw_wcB&amp;gbraid=0AAAAADt-_l2khHtCXPyK07zx25yjrxirt\">International Paralympic Committee</a> (IPC) and <a href=\"https://asianparalympic.org/\">Asian Paralympic Committee</a> (APC). The committee operates under the Bangladesh Sports Council of the Ministry of Youth and Sports of the Government of the People Republic of Bangladesh. NPC Bangladesh was formed in&nbsp;1981 as a non-profit national organization for para-athletes. NPC Bangladesh had first sent a team to the 2004 Summer Paralympics in Athens.&nbsp;</p><p>NPC Bangladesh is the national governing body for the Paralympic Movement in Bangladesh and responsible for promoting the Paralympic values of courage, determination, inspiration, and equality in alignment with IPC. NPC Bangladesh works to develop sports opportunities for people with disabilities from beginner to elite levels.&nbsp;</p>', 'pages/1/image_69654047dd991.jpg', 'Est facilis tenetur rerum ipsum esse impedit.', 'Quae molestiae hic illum voluptas aut quos natus aut repellendus et ipsum qui saepe ipsum.', 'qui, laudantium, omnis, eaque, officia, sequi', 'Active', 1, 1, '2025-12-13 08:56:30', '2026-01-18 01:47:37'),
(2, 'default', 'Contact Us', 'contact-us', 'Contact Us', 'Contact Us', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(33,37,41);\"><span style=\"-webkit-text-stroke-width:0px;display:inline !important;float:none;font-family:&quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;letter-spacing:normal;orphans:2;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><strong>Contact Us</strong></span></span></p>', 'pages/X0D14JzRiv0cAX3gwAdjpE0ZKcrEUPUPFT1xmnWV.png', 'Contact Us', 'Contact Us', 'Contact Us', 'Active', 1, 1, '2025-12-13 08:56:30', '2025-12-23 05:07:41'),
(3, 'default', 'History', 'history', 'History', 'Aspernatur debitis voluptas molestias molestiae eos at ab accusamus quia.', '<p>The history of the National Paralympic Committee of Bangladesh (NPC Bangladesh)&nbsp;was formed in&nbsp;1981. Bangladesh\'s debut at the Summer Paralympics was in 2004, where it sent one athlete to compete in athletics. The NPCB was formally established in 2004 and became the official national organization for para-sports, affiliated with the International Paralympic Committee (IPC). The country has since participated in every Summer Paralympics.</p>', 'pages/0TUGLJLSU7MAY0mxhUayLkvrgGCZgxNB6H9MtiFt.jpg', 'Aperiam et reprehenderit praesentium rerum quidem eos.', 'Facere iure eius aut sit aspernatur adipisci rerum veritatis molestias est qui atque sapiente quaerat pariatur sit dolorum soluta.', 'commodi, laboriosam, eos, laborum, amet, rerum', 'Active', 1, 1, '2025-12-13 08:56:30', '2026-01-18 01:36:23'),
(4, 'default', 'Sports', 'sports', 'Sports', 'Sunt nihil repellat quo eius nihil doloremque aut qui ut voluptatibus soluta cum neque corporis non.', '<p><meta charset=\"utf-8\"></p><h2 style=\"line-height:1.38;margin-bottom:4pt;margin-top:18pt;\" dir=\"ltr\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:17pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Summer Paralympic Sports</strong></span></b></span></h2><h3 style=\"line-height:1.38;margin-bottom:4pt;margin-top:14pt;\" dir=\"ltr\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:13pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Ball &amp; Team Sports</strong></span></b></span></h3><ul style=\"margin-bottom:0;margin-top:0;padding-inline-start:48px;\"><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e6abff6cebe846aa7023e3c76c58363c8\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:12pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Blind Football</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e12882ec6597c5936a64e7b13103978b7\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Goalball</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e936b31d311156f839016a4dcfd53cab1\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Sitting Volleyball</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"eee74aa6d2dbf91a3eb04ffd096fb686a\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:12pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Wheelchair Basketball</strong></span></b></span></p></li></ul><h3 style=\"line-height:1.38;margin-bottom:4pt;margin-top:14pt;\" dir=\"ltr\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:13pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Racket &amp; Court Sports</strong></span></b></span></h3><ul style=\"margin-bottom:0;margin-top:0;padding-inline-start:48px;\"><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e54e358c8c74d56505cc0d19f705622bd\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:12pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Badminton</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e424d1c772f82748db7ca4b0d58099983\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Table Tennis</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e756a509722f12916e0d8434cd3507dfa\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Table Tennis (Standing / Adaptive)</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"ea15ed69b27db96abc798854c3fc7af1d\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:12pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Wheelchair Fencing</strong></span></b></span></p></li></ul><h3 style=\"line-height:1.38;margin-bottom:4pt;margin-top:14pt;\" dir=\"ltr\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:13pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Strength &amp; Combat Sports</strong></span></b></span></h3><ul style=\"margin-bottom:0;margin-top:0;padding-inline-start:48px;\"><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e241e7b80b3ea7ff1ada687065f5d83d8\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:12pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Powerlifting</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"ef2c14cc0731192792dfead8c5a1d4bb2\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Judo</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e991fe6163e7ace762cde0596bd0a85bb\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:12pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Taekwondo</strong></span></b></span></p></li></ul><h3 style=\"line-height:1.38;margin-bottom:4pt;margin-top:14pt;\" dir=\"ltr\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:13pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Athletics &amp; Endurance Sports</strong></span></b></span></h3><ul style=\"margin-bottom:0;margin-top:0;padding-inline-start:48px;\"><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"eaa4c6b412c5a7ca4e34ef569c674b91e\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:12pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Athletics (Track &amp; Field)</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e2787f213388683003de7c3e8244a2927\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Triathlon</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e69db29332ae5d18895ecef25cd78563c\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:12pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Cycling (Road / Track)</strong></span></b></span></p></li></ul><h3 style=\"line-height:1.38;margin-bottom:4pt;margin-top:14pt;\" dir=\"ltr\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:13pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Precision &amp; Target Sports</strong></span></b></span></h3><ul style=\"margin-bottom:0;margin-top:0;padding-inline-start:48px;\"><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e775023b520ad079cc877ec95029f01b2\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:12pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Archery</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e55f669ef0183529fe8aef74663d4fe6c\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Shooting Para Sport</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"eade9a1d45120328265c95754ae711fb2\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:12pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Boccia</strong></span></b></span></p></li></ul><h3 style=\"line-height:1.38;margin-bottom:4pt;margin-top:14pt;\" dir=\"ltr\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:13pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Water Sports</strong></span></b></span></h3><ul style=\"margin-bottom:0;margin-top:0;padding-inline-start:48px;\"><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e8191a23d2a2b6faaa16a42a8bcb9c9ae\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:12pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Swimming</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e5d726ff2807773320d139520f793d190\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:0pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Canoe</strong></span></b></span></p></li><li class=\"ck-list-marker-bold ck-list-marker-color\" style=\"--ck-content-list-marker-color:#000000;background-color:transparent;color:#000000;font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;font-weight:400;list-style-type:disc;text-decoration:none;vertical-align:baseline;white-space:pre;\" data-list-item-id=\"e4475d65ba24e1334e1b8dcd55f595d81\" dir=\"ltr\" aria-level=\"1\"><p style=\"line-height:1.38;margin-bottom:12pt;margin-top:0pt;\" dir=\"ltr\" role=\"presentation\"><span style=\"background-color:transparent;color:#000000;\"><b style=\"font-weight:normal;\" id=\"docs-internal-guid-9e457ed5-7fff-58e7-2de7-a78fce3c7cdf\"><span style=\"font-family:Arial,sans-serif;font-size:11pt;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre-wrap;\"><strong>Para Rowing</strong></span></b></span></p></li></ul>', 'pages/vep2Sb1sifKEkLEmOktCHfY5u2T440ABahMVSG5K.png', 'Quidem et quam et ex.', 'Ut voluptatum ullam architecto molestiae dolore assumenda consequatur mollitia quae dignissimos molestiae et repellat tempora ut vel eum harum quia iusto et necessitatibus et adipisci.', 'adipisci, non, omnis, tempora, suscipit, aperiam', 'Active', 1, 1, '2025-12-13 08:56:30', '2025-12-27 13:55:37'),
(5, 'default', 'Training & Education', 'tranding-education', 'Training & Education', 'Training & Education', '<p>National Paralympic Committee of Bangladesh (NPC Bangladesh) is committed to the continuous growth of our sporting community. Through our Training &amp; Education wing, we ensure that athletes, coaches, and officials are equipped with the latest international knowledge, ethical standards, and technical expertise.</p><h3><strong>1. Anti-Doping: Play True</strong></h3><p>Integrity is the foundation of Paralympic sport. We strictly adhere to the <strong>WADA (World Anti-Doping Agency)</strong> and <strong>IPC</strong> Anti-Doping Codes to ensure a fair and clean competitive environment.</p><ul><li data-list-item-id=\"e4e7db3b3d7182ad60e3935dbc972fcf7\"><strong>Education:</strong> We provide mandatory workshops on prohibited substances and the \"Clean Sport\" philosophy.</li><li data-list-item-id=\"edd0bf10e8a9e27cc4b1f47c0062df085\"><strong>Rights &amp; Responsibilities:</strong> Every athlete is responsible for what they consume. We assist in understanding the Therapeutic Use Exemption (TUE) process for necessary medications.</li><li data-list-item-id=\"e4853ab21a9e9ca5fb3aede5b446f082b\"><strong>Testing:</strong> We coordinate with national and international authorities for \"In-Competition\" and \"Out-of-Competition\" testing.</li></ul><h3><strong>2. Coaching: Building Excellence</strong></h3><p>Our coaches are the architects of our athletes\' success. The BPC focuses on creating a pathway for coaches to gain international certification.</p><ul><li data-list-item-id=\"e6e948bea778f9f8b3a12caeb40154053\"><strong>Specialized Training:</strong> Focus on adaptive training techniques for different impairment groups.</li><li data-list-item-id=\"eaa060c1c9e8a9b4d3e02878839f2567f\"><strong>Technical Workshops:</strong> Regular seminars led by international experts to keep our coaches updated on global sporting trends.</li><li data-list-item-id=\"e144ad4e8f5e78af6b54811a6a1c0af23\"><strong>Certification:</strong> Facilitating IPC-recognized courses to raise the standard of coaching across all districts.</li></ul><h3><strong>3. Athlete Classification: Ensuring Fairness</strong></h3><p>Classification is the unique heart of Para-sport. It groups athletes into \"Sport Classes\" based on how much their impairment affects their athletic performance to ensure that winning is determined by skill and fitness.</p><ul><li data-list-item-id=\"edc829895270a4642033bafff625d65ce\"><strong>The Process:</strong> Athletes undergo medical and technical assessments by certified classifiers.</li><li data-list-item-id=\"e6426fd893ac6343a44e844d0c95aef06\"><strong>National Database:</strong> Maintaining an updated record of national classifications for local tournaments.</li><li data-list-item-id=\"e2a85891c028b04ff87a6b6b5e85efb7d\"><strong>Pathway to International:</strong> Preparing athletes for international classification panels at major Games like the Asian Para Games and Paralympics.</li></ul><h3><strong>4. Athlete Selection Criteria</strong></h3><p>To represent the Red and Green on the global stage, athletes must meet rigorous standards. Selection is based on a transparent and merit-based framework.</p><ul><li data-list-item-id=\"ed547bce891f5a8f386b9fc535e5e87c4\"><strong>Performance Standards:</strong> Achieving the Minimum Entry Standard (MES) or Minimum Qualification Standard (MQS) set by the IPC.</li><li data-list-item-id=\"ecfc88cbd05bfbc6062af132fd4c86e47\"><strong>Discipline &amp; Attendance:</strong> Evaluation of the athlete\'s commitment during national training camps.</li><li data-list-item-id=\"e31751f473a2e4853e092db120afde0b6\"><strong>Fitness &amp; Readiness:</strong> Final medical clearance and physical fitness tests conducted by the BPC high-performance team.</li></ul><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><h4>Specialized Mentorship for Para-Athletic Success:</h4><p><img class=\"image_resized\" style=\"aspect-ratio:1200/1599;width:48.77%;\" src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-102113-AM_1768036950.jpeg\" width=\"1200\" height=\"1599\"></p><p><img class=\"image_resized\" style=\"aspect-ratio:1200/1599;width:49.1%;\" src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-102115-AM_1768036919.jpeg\" width=\"1200\" height=\"1599\"></p><p><img class=\"image_resized\" style=\"aspect-ratio:1200/1599;width:48.99%;\" src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-102114-AM-3_1768036928.jpeg\" width=\"1200\" height=\"1599\"></p><p><img class=\"image_resized\" style=\"aspect-ratio:1600/1200;width:68.63%;\" src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-102114-AM_1768036942.jpeg\" width=\"1600\" height=\"1200\"></p><p><img class=\"image_resized\" style=\"aspect-ratio:1156/521;width:69.08%;\" src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-102114-AM-4_1768036921.jpeg\" width=\"1156\" height=\"521\"></p><p><img class=\"image_resized\" style=\"aspect-ratio:1280/960;width:68.85%;\" src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-102114-AM-2_1768036934.jpeg\" width=\"1280\" height=\"960\"></p><p><img class=\"image_resized\" style=\"aspect-ratio:1170/637;width:69.08%;\" src=\"/public/storage/uploads/WhatsApp-Image-2026-01-09-at-102114-AM-1_1768036937.jpeg\" width=\"1170\" height=\"637\"></p>', 'pages/5/image_6955098029f51.jpg', 'Tranding & Education', 'Tranding & Education', 'Tranding & Education', 'Active', 2, 2, '2025-12-30 06:12:15', '2026-01-18 01:34:06'),
(6, 'about', 'Our mission and vision', 'our-mission-and-vision', 'Our mission and vision', 'Our mission and vision', '<p><span style=\"color:hsl(0, 0%, 0%);\">To empower Bangladesh’s Para athletes to excel in global competitions, sparking national pride and inspiring the entire country through their success.&nbsp;</span></p><p><span style=\"color:hsl(0, 0%, 0%);\">To build an inclusive society where people with impairments have equal opportunities, using Para Sports to change perceptions and break down social barriers.</span></p>', 'pages/6/image_6954d3e14ad22.jpg', 'Our mission and vision', 'The mission & vision of the National Paralympic Committee of Bangladesh (NPCB) is aligned with International Paralympic Committee\'s mission & vision.', 'Our mission and vision', 'Active', 1, 1, '2025-12-30 22:41:09', '2026-01-10 07:36:23'),
(7, 'default', 'Sub Committee', 'standing-committee', 'Sub Committee', 'Sub Committee', '<p><a href=\"https://npcbangladesh.org/public/storage/uploads/Standing-Committee-Member-pdf_1768102446.pdf\">📄 PDF: Standing-Committee-Member-pdf_1768102446.pdf</a></p><p>&nbsp;</p><p>The <strong>Sub Committee</strong> serves as the permanent strategic backbone of the Bangladesh Paralympic Committee. Composed of dedicated leaders and visionary administrators, the committee provides continuous oversight, expert deliberation, and policy-making to ensure the sustainable development of Para-sports across the nation.</p><p>&nbsp;</p><h3>Core Strategic Responsibilities</h3><ul><li data-list-item-id=\"efe05375b9102fddcfce1f6e34ef9a3d0\"><strong>Policy &amp; Governance:</strong> Defining the long-term roadmap for Para-sports in Bangladesh and ensuring alignment with International Paralympic Committee (IPC) standards.</li><li data-list-item-id=\"e19edd15a41e2ac603e945d893bc1b5c2\"><strong>Athlete Advocacy:</strong> Safeguarding the rights, health, and welfare of every Para-athlete through inclusive and accessible regulations.</li><li data-list-item-id=\"ecdbab63551dd2f2e6226efd3ae5eb19a\"><strong>Resource Management:</strong> Allocating technical and financial support for national training camps and specialized coaching.</li><li data-list-item-id=\"e21461eec0f29878bdaccff33f536f61b\"><strong>Strategic Growth:</strong> Expanding the reach of the Paralympic movement to all districts, ensuring talent is discovered in every corner of Bangladesh.</li></ul>', 'pages/7/image_69623bff62059.jpeg', 'Standing Committee', 'Standing Committee', 'Standing Committee', 'Active', 1, 1, '2025-12-30 22:46:41', '2026-01-18 01:38:28'),
(8, 'default', 'Operation Team', 'management-team', 'Operation Team', 'Strategic Execution', '<h4>The Operations Team: Turning Vision into Victory</h4><p>The <strong>Operations Team</strong> serves as the strategic heart of the National Paralympic Committee of Bangladesh. Our primary role is to bridge the gap between big ideas and real-world results. We take the organization’s long-term vision and translate it into a clear, actionable roadmap that leads our athletes to the podium.</p><h4>What We Do</h4><p>We are responsible for synchronizing every department within the NPCB. Whether it is coordinating with coaches, managing budgets, or communicating with international sports bodies, we ensure that everyone is moving in the same direction. We manage the \"logistics of excellence\"—ensuring that training camps are ready, equipment is world-class, and travel to international events like the Asian Youth Para Games is seamless.</p><h4>Our Role in Strategic Execution</h4><p>Strategy without action is just a dream. Our team specializes in <strong>Strategic Execution</strong>, which means we take the NPCB’s goals such as increasing medal counts or expanding para-sports nationwide—and break them down into daily tasks. We monitor progress, solve problems before they arise, and make sure resources are used efficiently.</p><h4>How We Build Success</h4><p>We develop strategies by analyzing past performances and forecasting future needs. By staying organized and data-driven, we create an environment where coaches can teach and athletes can compete without distractions. When a Bangladeshi athlete stands on the podium with a gold medal, it is the result of a meticulously executed plan managed by the Operations Team.</p>', NULL, 'Management Team', 'Management Team', 'Management Team', 'Active', 1, 1, '2025-12-30 22:50:20', '2026-01-19 05:48:39'),
(10, 'players', 'Athlete profile', 'athletics-profile', 'Athlete profile', 'Athlete profile', '<p>\"Driven by an unbreakable spirit and the pride of the Red and Green, this athlete represents the pinnacle of resilience. From the local training grounds of Bangladesh to the international arena, every stride and every effort is a testament to the power of the human will. A true ambassador of Paralympic values, they continue to redefine what is possible, proving that with determination, there are no limits to excellence.\"</p>', 'pages/10/image_6954da25b0a01.png', 'Athletics Profile', 'Athletics Profile', 'Athletics Profile', 'Active', 1, 1, '2025-12-30 22:53:44', '2026-01-10 21:11:41'),
(11, 'default', 'Accounts & Finance', 'accounts-finance', 'Accounts & Finance', 'Accounts & Finance', '<p>The Finance Department of the Bangladesh Paralympic Committee (BPC) is dedicated to the ethical management and strategic allocation of financial resources. We ensure that every fund received—whether from the Government of Bangladesh, international grants, or corporate sponsorships—is directed toward the development of our athletes and the advancement of the Paralympic movement.</p><h4><strong>Our Financial Philosophy</strong></h4><p>We operate under a framework of complete transparency and fiscal responsibility. By maintaining rigorous audit standards and digital tracking, we ensure that our financial operations support the long-term sustainability of Para-sports in Bangladesh.</p><h4><strong>Core Financial Pillars</strong></h4><ul><li data-list-item-id=\"e3b0498459be689a4cfe70f64aad51d70\"><strong>1. Transparent Budgeting:</strong> Our annual budgets are carefully planned to prioritize athlete training, equipment procurement, and participation in international competitions (such as the Asian Para Games and Paralympics).</li><li data-list-item-id=\"e95a560ea3b66aa78729934446c6d0065\"><strong>2. Audit &amp; Compliance:</strong> To maintain the highest level of integrity, our accounts undergo regular internal and external audits. We comply with the financial regulations of the Government of Bangladesh and the International Paralympic Committee (IPC).</li><li data-list-item-id=\"e5a17b5abbb56d42a90ab99783c0c791b\"><strong>3. Resource Optimization:</strong> We focus on maximizing the impact of every Taka. From grassroots talent hunts to high-performance training camps, funds are managed to ensure maximum benefit for the athletic community.</li><li data-list-item-id=\"e9a61f490c26dce626a2c31fec6ed47ab\"><strong>4. Grant &amp; Sponsorship Management:</strong> We provide detailed reporting to our partners and sponsors, ensuring that all contributions are utilized according to the agreed-upon strategic goals and development programs.</li></ul>', 'pages/11/image_697270aa6a96f.png', 'Accounts & Finance', 'Accounts & Finance', 'Accounts & Finance', 'Active', 1, 1, '2025-12-30 23:29:04', '2026-01-22 12:47:06'),
(12, 'default', 'Sponsorship', 'sponsorship', 'Sponsorship', 'sponsorship', '<h4><strong>Partner With Us: Sponsorship Opportunities</strong></h4><p>At the NPC Bangladesh, we believe that \"Change Starts with Sport.\" When your brand partners with the NPC Bangladesh, you are not just sponsoring a tournament; you are empowering athletes who redefine the limits of human potential.</p><p>&nbsp;</p><h4>Exclusive Sponsorship Tiers</h4><p>Our tiered partnership structure is designed to offer measurable Return on Investment (ROI) while aligning with your brand’s prestige.</p><figure class=\"table\"><table><thead><tr><th><strong>Benefit Category</strong></th><th><strong>Platinum Partner</strong></th><th><strong>Gold Partner</strong></th><th><strong>Silver Partner</strong></th></tr></thead><tbody><tr><td><strong>Annual Contribution</strong></td><td><strong>BDT 1,500,000</strong></td><td><strong>BDT 1,000,000</strong></td><td><strong>BDT 500,000</strong></td></tr><tr><td><strong>National Team Kit</strong></td><td>Primary Logo (Chest/Belly)</td><td>Secondary Logo (Sleeves)</td><td>Associate Logo (Shorts)</td></tr><tr><td><strong>Event Visibility</strong></td><td>Title Branding at All Events</td><td>Lead Branding at Major Events</td><td>Category Branding</td></tr><tr><td><strong>Digital Presence</strong></td><td>Dedicated Page + Monthly PR</td><td>Website Logo + Social Media</td><td>Website Logo</td></tr><tr><td><strong>Network Access</strong></td><td>VIP Box at All Events</td><td>4 VIP Passes</td><td>2 VIP Passes</td></tr><tr><td><strong>Recognition</strong></td><td>Lifetime Achievement Award</td><td>Annual Excellence Award</td><td>Appreciation Plaque</td></tr></tbody></table></figure><h4>Specialized Partnership Categories</h4><p>Beyond traditional tiers, we offer unique avenues for collaboration that allow your company to showcase its specific strengths:</p><h4>1. Principal Mission Partner</h4><p>Become the foundational pillar of the Paralympic Movement in Bangladesh. Principal Partners have a long-term (3–5 years) seat at the table, helping shape the strategic growth of Para sports from the grassroots to the Olympic stage.</p><h4>2. Technical &amp; Apparel Partner</h4><p>Equip our champions. This category is for sports brands and garment manufacturers.</p><ul><li data-list-item-id=\"e95259170578b666b9d9a5f6e8eb78ec7\"><strong>On-Field Kits:</strong> Official jerseys, tracksuits, and training gear.</li><li data-list-item-id=\"e105c3836086dc61d7e521df0343574c8\"><strong>Technical Equipment:</strong> Specialized wheelchairs, prosthetics, and archery/table tennis gear.</li><li data-list-item-id=\"ed6b35587f847eba38185b9a76267b7db\"><strong>Benefit:</strong> Your brand is seen in every high-action photograph and broadcast of our athletes.</li></ul><h4>3. Corporate Social Responsibility (CSR)</h4><p>For companies dedicated to Social Impact and the UN Sustainable Development Goals (SDGs), we offer \"Project-Based\" partnerships:</p><ul><li data-list-item-id=\"e9f3a1856048423b426a66fce48cba071\"><strong>Rural Talent Hunt:</strong> Fund a scout program in all 64 districts to find the next champion.</li><li data-list-item-id=\"edb5640b0557ea708888e4b2fd553c2f6\"><strong>\"Para-Sport for All\":</strong> Sponsor community centers that make sports accessible to children with disabilities.</li><li data-list-item-id=\"e1d4665a7c3468fb1f1b96645c035c5a1\"><strong>Empowerment Grants:</strong> Directly fund an athlete’s nutrition, education, and international travel.</li></ul><p>&nbsp;</p><p>&nbsp;</p><h4>The Partnership Advantage: Why NPC Bangladesh?</h4><h4>Global &amp; Local Visibility</h4><p>Paralympic sport is one of the fastest-growing media properties in the world. As our athletes compete in the Asian Para Games and the Paralympics, your brand travels with the \"Red and Green\" flag, reaching millions of viewers across TV and digital platforms.</p><h4>Brand Integrity &amp; Social Equity</h4><p>Aligning with NPCB demonstrates a genuine commitment to <strong>Diversity, Equity, and Inclusion (DEI)</strong>. It transforms your brand from a \"product seller\" to a \"social leader,\" earning the trust and loyalty of socially conscious consumers in Bangladesh.</p><h4>Employee Engagement &amp; Pride</h4><p>Boost staff morale by involving your employees in the Paralympic journey. We offer \"Inclusion Workshops\" and \"Meet-the-Hero\" sessions for our partners\' corporate teams, fostering a culture of resilience and determination within your workplace.</p><p>&nbsp;</p><p>&nbsp;</p><h4>How to Join the Mission</h4><p>We welcome partnerships from all legally registered companies in Bangladesh that share our values of <strong>Inclusion, Determination, and Excellence.</strong></p><p><strong>Contact Our Partnership Desk:</strong></p><ul><li data-list-item-id=\"e6bce552d97d289504e4fa784c65cdd50\">&nbsp;<strong>Email:</strong> <a href=\"mailto:info@npcbangladesh.org\">info@npcbangladesh.org</a></li><li data-list-item-id=\"e965b137d8ae5ef976fa4f3972f92c2d6\"><strong>Phone:</strong><a href=\"tel:+880 1336097353;  +880 1777-131517\">+880 1336097353; +880 1777-131517</a></li><li class=\"ck-list-marker-color\" style=\"--ck-content-list-marker-color:hsl(0,0%,0%);\" data-list-item-id=\"ead317cfe83afe88b3fa5e4d0e0c1c1e8\"><span style=\"color:hsl(0,0%,0%);\"><strong>Office:</strong> </span><a href=\"https://www.google.com/maps/place/National+Sports+Council+Tower./@23.7299772,90.4114077,17z/data=!3m1!4b1!4m6!3m5!1s0x3755b8585e4fd495:0xf6874fa01d3397fc!8m2!3d23.7299772!4d90.4139826!16s%2Fg%2F1yfjss609?entry=ttu&amp;g_ep=EgoyMDI2MDExMy4wIKXMDSoASAFQAw%3D%3D\"><span style=\"color:hsl(0,0%,0%);\">National Sports Council Old Building, Room #202 (1st Floor) 62/3 Purana Paltan, Dkaka-1000, Bangladesh</span></a></li></ul><p>&nbsp;</p><h2><strong>Ready to make history?</strong></h2>', 'pages/12/image_69550f8586cde.jpg', 'Accounts & Finance', 'Accounts & Finance', 'Accounts & Finance', 'Active', 1, 1, '2025-12-30 23:31:12', '2026-01-18 13:07:10'),
(13, 'result', 'Result', 'result', 'Result', 'result', '<h4><strong>Results &amp; Rankings</strong></h4><p>Welcome to the official results hub of the Bangladesh Paralympic Committee. This page serves as a record of the incredible feats, broken records, and podium finishes achieved by our Para-athletes across national and international stages.</p>', 'pages/13/image_69551130da5eb.jpg', 'result', 'result', 'result', 'Active', 1, 1, '2025-12-30 23:35:34', '2025-12-31 06:04:00'),
(14, 'events', 'Upcoming Event', 'upcoming-event', 'Upcoming Event', 'Upcoming Event', '<p>The track is where our journey begins. At the Bangladesh Paralympic Committee, \"Upcoming Event\" represent the relentless preparation of our athletes as they train for national glory and international podiums. Every lap run in practice is a step toward the Red and Green flag flying high in stadiums around the world.</p>', 'pages/14/image_696c881f7cfd2.jpg', 'Upcoming Event', 'Upcoming Event', 'Upcoming Event', 'Active', 1, 1, '2025-12-30 23:38:09', '2026-01-27 01:09:13'),
(15, 'past-events', 'Previous Events', 'past-event', 'Previous Events', 'Previous Events', '<p>Every finish line crossed is a part of our history. This archive celebrates the milestones, competitions, and community programs that have shaped the Paralympic movement in Bangladesh. From local talent hunts to the world’s biggest sporting stages, these are the moments where our athletes proved that <strong>\"Impossible is Nothing.\"</strong></p>', 'pages/15/image_69557b89d59fe.jpg', 'Past Event', 'Past Event', 'Past Event', 'Active', 1, 1, '2025-12-31 00:13:40', '2026-01-18 11:46:27'),
(16, 'default', 'Corporate', 'corporate', 'Corporate', 'Corporate', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-01 02:05:04', '2026-01-01 02:05:04');
INSERT INTO `pages` (`id`, `temp`, `page_title`, `slug`, `breadcrumb`, `short_des`, `page_description`, `f_image`, `meta_title`, `meta_description`, `meta_keyword`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(17, 'default', 'Frequently Asked Questions', 'frequently-asked-questions', 'Frequently Asked Questions', 'Frequently Asked Questions', '<h4>1. What is Classification?</h4><p>Classification is a unique framework used in Para sports to ensure fair and meaningful competition. It minimizes the impact of an athlete\'s impairment on the race or match outcome, ensuring that victory is determined by skill, fitness, power, and tactical ability just like in any other sport.</p><p>While other sports use weight classes (like Judo) or age categories (like marathons), Para sports use <strong>Sport Classes</strong> to group athletes with similar activity limitations together.</p><p>&nbsp;</p><h4>2. Who is eligible to compete in Para sport in Bangladesh?</h4><p>To be eligible for a Sport Class through NPC Bangladesh, an athlete must:</p><ul><li data-list-item-id=\"e5ce27819f58ec41663b57d82aa7fa0d3\"><strong>Have an Underlying Health Condition:</strong> This must lead to one of the ten eligible impairments (such as impaired muscle power, limb deficiency, or vision impairment).</li><li data-list-item-id=\"ec36341ebb8a0f94227928cc235cac6c2\"><strong>Meet the Minimum Impairment Criteria (MIC):</strong> Each sport has a specific \"starting point\" for how much an impairment must affect athletic performance to be eligible.</li><li data-list-item-id=\"e09367dac2fa457734ab7d33580ed48b8\"><p><strong>Provide Diagnostic Information:</strong> Athletes must provide medical documentation from a certified doctor in Bangladesh as part of the local evaluation process.</p><p>&nbsp;</p></li></ul><h4>3. How do I start my journey as a Para athlete in Bangladesh?</h4><p>If you are interested in competing, your first step is to contact <strong>NPC Bangladesh</strong> or your specific National Sport Federation. We can guide you toward local training camps and national-level classification sessions.</p><p>&nbsp;</p><h4>4. When and where are athletes classified?</h4><p>Classification usually happens in two stages:</p><ol><li data-list-item-id=\"e465cb9ea15183444f0727f4705f89621\"><strong>National Classification:</strong> Conducted in Dhaka or at regional sports complexes before national championships.</li><li data-list-item-id=\"e7767d514c020781e575137268e23fd8a\"><p><strong>International Classification:</strong> <span style=\"background-color:transparent;color:#262936;\">If you are selected for the national team, you will undergo evaluation by international panels according to (</span><a href=\"https://www.paralympic.org/classification-by-sport\"><span style=\"background-color:transparent;color:#262936;\">IPC Standard</span></a><span style=\"background-color:transparent;color:#262936;\">) immediately preceding major international events.</span></p><p>&nbsp;</p></li></ol><h4>5. Which Para sports are currently active in Bangladesh?</h4><p>Bangladesh has a growing Para sports scene. Currently, we have active programs in:</p><ul><li data-list-item-id=\"e1264771ea89cf4c2626711cf3959587a\"><strong>Para Athletics</strong> (Track and Field)</li><li class=\"ck-list-marker-bold\" data-list-item-id=\"e041577e9edab843c71a0147acd516f83\"><strong>Para Swimming</strong></li><li class=\"ck-list-marker-bold\" data-list-item-id=\"efba1d0591876ffaf484a3d7d68994235\"><strong>Wheelchair Basketball</strong></li><li class=\"ck-list-marker-bold\" data-list-item-id=\"eb1f51c65a415eb65da5f6f0199873890\"><strong>Para Archery</strong></li><li class=\"ck-list-marker-bold\" data-list-item-id=\"edd982e3acb78f7239f35e2b76ebda709\"><strong>Para Badminton</strong></li><li class=\"ck-list-marker-bold\" data-list-item-id=\"e3a182bf6eb9cb3e7d2c42b816eaca409\"><strong>Para Table tennis&nbsp;</strong></li><li class=\"ck-list-marker-bold\" data-list-item-id=\"e0c3fc23bb1b056ebdb81351324fdf5d7\"><strong>Amputee Football</strong></li><li class=\"ck-list-marker-bold\" data-list-item-id=\"e22e0818d9b2adf35f08df5f5e7e1885f\"><p><strong>Physical Disabled Cricket</strong></p><p>&nbsp;</p></li></ul><h4>6. Do I need to be re-classified?</h4><p>Yes, in some cases. Athletes with progressive conditions or those who are very young may be given a <strong>\"Review\"</strong> status, meaning they need to be seen again after a few years. Once an impairment is stable, you may receive a <strong>\"Confirmed\"</strong> status.</p><p>&nbsp;</p><h4>7. Can I bring someone with me to my Classification session?</h4><p>Yes. Every athlete is encouraged to bring one<strong> Representative</strong> (such as family member) to support them during the evaluation.&nbsp;</p><p>&nbsp;</p><h4>&nbsp;</h4>', 'pages/17/image_6957c590a323d.jpg', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-01 02:08:10', '2026-01-17 03:56:28'),
(18, 'ec-committee', 'Executive Committee', 'executive-committee', 'Executive Committee', 'Executive Committee', '<p>The Executive Committee of the National Paralympic Committee of Bangladesh provides strategic leadership and governance to advance para-sports nationwide. The leadership structure is carefully designed to ensure strong international representation, effective regional coordination, and transparent, accountable administration.</p><p>The Committee is responsible for representing Bangladesh within the global Paralympic movement, promoting athlete development through technical, medical, and operational support, and ensuring sound governance through financial accountability and policy oversight. It also plays a key role in expanding inclusive para-sports programmers at regional and grassroots levels, fostering broad participation and sustainable growth.</p>', 'pages/18/image_695cdca09830a.png', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-03 07:12:03', '2026-01-17 03:52:23'),
(25, 'default', 'Classification', 'classification', 'Classification', 'Classification', '<p style=\"margin-left:0px;\">Classification is a unique framework used in Para sports to ensure fair and meaningful competition. It minimizes the impact of an athlete\'s impairment on the race or match outcome, ensuring that victory is determined by skill, fitness, power, and tactical ability—just like in any other sport.</p><p style=\"margin-left:0px;\">While other sports use weight classes (like Judo) or age categories (like marathons), Para sports use <strong>Sport Classes</strong> to group athletes with similar activity limitations together.</p><p style=\"margin-left:0px;\">&nbsp;</p><p style=\"margin-left:0px;\">To be eligible for a Sport Class through NPC Bangladesh, an athlete must:</p><ul><li data-list-item-id=\"e5ce27819f58ec41663b57d82aa7fa0d3\"><strong>Have an Underlying Health Condition:</strong> This must lead to one of the ten eligible impairments (such as impaired muscle power, limb deficiency, or vision impairment).</li><li data-list-item-id=\"ec36341ebb8a0f94227928cc235cac6c2\"><strong>Meet the Minimum Impairment Criteria (MIC):</strong> Each sport has a specific \"starting point\" for how much an impairment must affect athletic performance to be eligible.</li><li data-list-item-id=\"e09367dac2fa457734ab7d33580ed48b8\"><p style=\"margin-left:0px;\"><strong>Provide Diagnostic Information:</strong> Athletes must provide medical documentation from a certified doctor in Bangladesh as part of the local evaluation process.</p></li></ul>', NULL, NULL, NULL, NULL, 'Active', 1, 1, '2026-01-15 07:30:16', '2026-01-15 07:43:54'),
(26, 'default', 'Education and Research', 'education-and-research', 'Education and Research', 'Building Knowledge, Empowering Excellence', '<p>The National Paralympic Committee (NPC) of Bangladesh is committed to being a center of excellence for knowledge in Para sports. We believe that sustainable success on the podium is driven by scientific research, continuous education, and the development of specialized expertise.</p><h2>🎓 Our Educational Mission</h2><p>Education is the key to transforming the Para sport landscape in Bangladesh. Our programs are designed to empower the \"Team Behind the Athlete\"—coaches, officials, classifiers, and volunteers.</p><h3><strong>1. Coaching Certification Programs</strong></h3><p>In collaboration with International Federations (IFs) and the IPC Academy, we host workshops to train coaches in adaptive sports techniques.</p><ul><li data-list-item-id=\"e18baaa75c8933cdccfe4ee284a7d593a\"><strong>Level 1 &amp; 2 Certifications:</strong> Specialized training in Para Athletics, Swimming, and Archery.</li><li data-list-item-id=\"ec646f746077bebe01640ac7ec06a4515\"><strong>Adaptive Physiology:</strong> Understanding the unique physical requirements of athletes with different impairments.</li></ul><h3><strong>2. Classifier Training</strong></h3><p>To grow Para sports locally, Bangladesh needs a strong pool of national classifiers. We provide educational pathways for medical professionals (Physiotherapists and Doctors) to become certified National Classifiers.</p><h3><strong>3. Safe Sport &amp; Ethics</strong></h3><p>Education on Anti-Doping (WADA), Safeguarding, and the Rights of Persons with Disabilities is mandatory for all our members to ensure a safe and fair sporting environment.</p><h2>🔬 Research &amp; Innovation</h2><p>NPC Bangladesh actively encourages research that improves the performance, health, and inclusion of persons with disabilities in the country.</p><h3><strong>Current Research Focus Areas:</strong></h3><ul><li data-list-item-id=\"e4ed982c681950f6153e8f6a2d45dab96\"><strong>Adaptive Equipment Innovation:</strong> Researching low-cost, high-performance sports equipment (like wheelchairs and prosthetics) that can be manufactured locally in Bangladesh.</li><li data-list-item-id=\"e81171aa01c4b324e7c66465569aee3a7\"><strong>Sports Nutrition:</strong> Developing dietary guidelines specifically for Para athletes using locally available Bangladeshi food sources.</li><li data-list-item-id=\"eb180e5d85aaf4243fb1d7c56fc44aa25\"><strong>Socio-Economic Impact:</strong> Studying how participation in Para sports improves the employment and social integration of individuals in rural and urban Bangladesh.</li><li data-list-item-id=\"ed353994cded2aed15c402032d1ea5278\"><p><strong>Biomechanics in Para Sport:</strong> Analyzing movement patterns to optimize performance for athletes with limb deficiencies or spinal cord injuries.</p><p>&nbsp;</p><p>&nbsp;</p></li></ul><h2>🤝 Academic Partnerships</h2><p>We bridge the gap between the field and the lab by partnering with national and international institutions.</p><ul><li data-list-item-id=\"ee6e7b7d2e8e15c2c0ebbc4c331c76c59\"><strong>University Collaborations:</strong> Partnering with Physical Education departments and Medical Colleges across Bangladesh for data collection and specialized studies.</li><li data-list-item-id=\"e2fba5f4a084c3f03952ecb1577628a56\"><strong>International Knowledge Exchange:</strong> Sharing research findings with the IPC Research and Education and the Asian Para Committee.</li></ul><h2>📚 Resources for Students &amp; Researchers</h2><p>Are you a student or a researcher interested in Para sports? NPC Bangladesh provides:</p><ul><li data-list-item-id=\"ea45ef01364725c558f86034b7728ed08\"><strong>Access to Data:</strong> Aggregated statistics on Para sports participation in Bangladesh.</li><li data-list-item-id=\"eb7a6803b00de36085523e84da1325d00\"><strong>Internship Opportunities:</strong> Hands-on experience in sports management and athlete evaluation.</li><li data-list-item-id=\"ec6c11b7aea552994a87048c2b9a692c8\"><strong>Guest Lectures:</strong> Our experts are available for seminars on disability inclusion and adaptive sports science.</li></ul><blockquote><p><strong>\"Without research, there is no progress. Without education, there is no future.\"</strong> NPC Bangladesh is dedicated to ensuring that our athletes are backed by the best minds and the latest science.</p></blockquote>', NULL, NULL, NULL, NULL, 'Active', 1, 1, '2026-01-15 08:43:22', '2026-01-15 15:41:50'),
(27, 'default', 'Impact', 'impact', 'impact', NULL, '<h2>Transforming Lives Through Para Sport in Bangladesh</h2><p>At the National Paralympic Committee of Bangladesh (NPC Bangladesh), we believe that sport is more than just competition it is a powerful catalyst for social change. Our mission is to drive long-lasting, structural, and systemic improvements in the lives of persons with disabilities across Bangladesh through the Paralympic Movement.</p><h3>Grounded in Global and National Standards</h3><p>Our Impact Strategy is aligned with the UN Convention on the Rights of Persons with Disabilities (UNCRPD) and the Sustainable Development Goals (SDGs). We adopt the social model of disability, focusing on removing societal barriers rather than focusing on \"limitations.\" By doing so, we aim to show how NPC Bangladesh’s activities contribute to a world where disability does not dictate a person’s potential.</p><h3>Our Strategic Focus</h3><p>By measuring and demonstrating the legacy of our athletes and our participation in the Paralympic Games, we aim to:</p><ul><li data-list-item-id=\"eb79a2c946bd64e60a94b53eeb0f1bb74\"><strong>Empower Athletes:</strong> Providing the training, resources, and platforms for Bangladeshi Para athletes to excel on the world stage.</li><li data-list-item-id=\"e72c26633c04d1a359894f82e62d6178e\"><strong>Advocate for Inclusion:</strong> Partnering with government bodies, NGOs, and like-minded institutions to focus national attention on the systemic changes required for disability inclusion in Bangladesh.</li><li data-list-item-id=\"e17423fbd8349e467d9d689ca0ff79dda\"><strong>Challenge Perceptions:</strong> Using the excellence of our athletes to change the way the Bangladeshi public views disability moving from sympathy to empowerment.</li><li data-list-item-id=\"e9ee71f0520204db237538bfcac765a93\"><strong>Strengthen the Movement:</strong> Supporting local clubs and regional organizations to build a sustainable grassroots foundation for Para sports across all districts.</li></ul><p>&nbsp;</p><h3>Driving Change Beyond the Field</h3><p>We don\'t just measure success by medals, but by the lives changed off the field. NPC Bangladesh advocates for accessible infrastructure, inclusive education, and equal employment opportunities. We work tirelessly to ensure that the \"Paralympic Effect\" reaches every corner of the country, from the capital to the most rural communities.</p><p>&nbsp;</p>', NULL, NULL, NULL, NULL, 'Active', 1, 1, '2026-01-15 12:50:54', '2026-01-18 01:42:57'),
(28, 'default', 'Anti-Doping', 'anti-doping', 'Anti-Doping', 'Anti-Doping', '<h4>Protecting Clean Sport: Roles and Responsibilities</h4><p>In the Paralympic Movement, integrity and fair play are our core values. Every person involved in Para sports in Bangladesh—whether on the field or in the support box—is bound by the <strong>World Anti-Doping Code</strong>. Understanding your specific responsibilities is the first step toward a successful and clean career.</p><h4>🏃 For Athletes: Your Body, Your Responsibility</h4><p>As an athlete, the principle of <strong>\"Strict Liability\"</strong> applies. This means you are solely responsible for any prohibited substance found in your system, regardless of how it got there.</p><p><strong>Your Primary Responsibilities:</strong></p><ul><li data-list-item-id=\"ec77b5aee4075cc21220148ec2c4fa39b\"><strong>Stay Informed:</strong> Know and follow all anti-doping policies and the current <strong>WADA Prohibited List</strong>.</li><li data-list-item-id=\"eb248d83f7d61d5bc8c05f066aaed3989\"><strong>Be Available:</strong> You must be available for testing at all times (both in-competition and out-of-competition).</li><li data-list-item-id=\"e800016a4645fafdec03fca7f04dab87b\"><strong>Strict Intake Control:</strong> Take 100% responsibility for anything you eat, drink, or use. \"I didn\'t know\" is not a valid defense.</li><li data-list-item-id=\"e90132de49a76ca93c09102aa23a17c87\"><strong>Educate Your Doctors:</strong> Inform all medical personnel that you are a Para athlete and must not be prescribed anything on the Prohibited List.</li><li data-list-item-id=\"e05a067a10f31c96b2bd7fbbdc7fd2cbd\"><strong>Check Your Treatments:</strong> Ensure any medical treatment or medication received does not violate anti-doping rules.</li><li data-list-item-id=\"e56b50e63510954991ca374494258f6fe\"><strong>Full Disclosure:</strong> Disclose if you have committed an Anti-Doping Rule Violation (ADRV) within the last 10 years.</li><li data-list-item-id=\"e22f7259143784fee384eef7e896dbd8e\"><strong>Cooperate:</strong> You must cooperate fully with anti-doping organizations (like the <strong>Bangladesh Anti-Doping Agency</strong>) during investigations.</li></ul><h4>📋 For Athlete Support Personnel (ASP)</h4><p>This includes coaches, trainers, managers, agents, medical staff, and even parents. You play a critical role in the athlete’s success and are equally bound by the rules.</p><p><strong>Your Primary Responsibilities:</strong></p><ul><li data-list-item-id=\"edaf06be95c3826bc7f4e37fb98fec04b\"><strong>Comply with Rules:</strong> Be knowledgeable of the anti-doping rules that apply to you and the athletes you support.</li><li data-list-item-id=\"ef1bcad39959499f4087a8bd74d0b503c\"><strong>Support Testing:</strong> Cooperate with Doping Control Officers (DCOs) when your athletes are being tested.</li><li data-list-item-id=\"e96023df5ef525330909e54a01901c527\"><strong>Be a Role Model:</strong> Use your influence to foster a culture of \"clean sport\" and discourage the use of performance-enhancing substances.</li><li data-list-item-id=\"ea5fa49a4e3f65b434debea3457a6518d\"><strong>Disclose History:</strong> Inform the NPC or International Federation if you have committed an ADRV in the last 10 years.</li><li data-list-item-id=\"eba0b953b4793d0d253cd3c413eaf960b\"><strong>Total Cooperation:</strong> Assist in any investigations regarding rule violations.</li><li data-list-item-id=\"e4a937cbfa816e6512a48d17783ab3fc9\"><strong>No Prohibited Possession:</strong> Do not use or possess any prohibited substance or method without a valid, documented medical justification.</li></ul><h4><strong>🛡️ Critical Checklist for All Members</strong></h4><ol><li data-list-item-id=\"e72887d66c765c57c455cba46eb6b3227\"><strong>Check Your Meds:</strong> Use the <a href=\"https://www.globaldro.com\">Global DRO</a> tool to check if your medication is banned.</li><li data-list-item-id=\"e3631c9d0b82df2765e63315661a679b0\"><strong>TUE (Therapeutic Use Exemption):</strong> If you have a legitimate medical condition that requires a banned substance, you must apply for a <strong>TUE</strong> <i>before</i> you compete.</li><li data-list-item-id=\"e0edd1685383611ebf5de0d5a63ec5a3b\"><strong>Supplement Warning:</strong> Be extremely cautious with supplements. Many contain \"hidden\" banned ingredients not listed on the label.</li></ol><blockquote><p><strong>Our Promise:</strong> NPC Bangladesh stands for \"Clean Sport.\" We are here to support our athletes in navigating these rules so they can compete with pride and honor.</p></blockquote><h4><strong>Need Assistance?</strong></h4><p>If you have questions about a specific medication or need to report a concern, please contact the <strong>NPC Bangladesh Anti-Doping Department</strong> immediately.</p>', '', 'Anti-Doping', 'Anti-Doping', 'Anti-Doping', 'Active', 1, 1, '2026-01-15 15:24:07', '2026-01-15 15:24:07'),
(29, 'default', 'Rehabilitation', 'rehabilitation', 'Rehabilitation', 'The Gateway to Para Sport', '<h4>The Gateway to Para Sport</h4><p>At the National Paralympic Committee of Bangladesh (NPC Bangladesh), we believe that rehabilitation is not just about recovery—it is the foundation of a new beginning. History shows that the global Paralympic Movement was born out of rehabilitation programs, and in Bangladesh, we continue this legacy by using sport as a powerful tool for physical, psychological, and social restoration.</p><h3><strong>Our Philosophy: From Therapy to Track</strong></h3><p>For a person with a disability, rehabilitation is the first step toward reclaiming independence. While traditional medical rehabilitation focuses on daily living activities, <strong>Sports-Based Rehabilitation</strong> takes it a step further. By engaging in Para sports, individuals improve their cardiovascular health, muscle strength, and coordination while building the confidence needed to transition from a \"patient\" to an \"athlete.\"</p><h3><strong>Key Pillars of our Rehabilitation Framework</strong></h3><h4><strong>1. Physical Restoration &amp; Physiotherapy</strong></h4><p>We work alongside leading rehabilitation centers in Bangladesh to ensure that athletes receive specialized physiotherapy. This includes:</p><ul><li data-list-item-id=\"efd8b59af6bcabdfc349801a7fa3b6892\"><strong>Functional Mobility:</strong> Enhancing the ability to use wheelchairs, prosthetics, or braces with athletic precision.</li><li data-list-item-id=\"e4b6ca0194dd105b9425e15d864382a57\"><strong>Injury Prevention:</strong> Tailored strength and conditioning programs to protect the joints and muscles of Para athletes.</li><li data-list-item-id=\"e98357b401da0d4883018f85ba625c02d\"><strong>Specialized Care:</strong> Access to experts in spinal cord injury, limb deficiency, and neurological rehabilitation.</li></ul><h4><strong>2. Psychological Resilience</strong></h4><p>Recovery is as much mental as it is physical. Participating in Para sports during the rehabilitation phase helps combat depression and isolation. It provides a sense of community, a goal to strive for, and a \"competitive spirit\" that speeds up the overall healing process.</p><h4><strong>3. Adaptive Equipment &amp; Technology</strong></h4><p>Rehabilitation at NPC Bangladesh involves the use of specialized adaptive technology. We assist athletes in finding and fitting the right equipment—whether it is a racing wheelchair, a sports prosthetic, or assistive devices for archery and shooting—to ensure their body and equipment work in perfect harmony.</p><h3><strong>Our Partnership with CRP and Beyond</strong></h3><p>NPC Bangladesh maintains a close relationship with the <strong>Centre for the Rehabilitation of the Paralyzed (CRP)</strong> and other national institutes. These partnerships allow us to:</p><ul><li data-list-item-id=\"ef880f9b8f38f8afcc94404f1a4482880\">Identify \"Grassroots Talent\" during the early stages of medical rehabilitation.</li><li data-list-item-id=\"e681de686dd2a0017f071c11a3c2412ff\">Provide a pathway for individuals to move from hospital-based recreation to national-level competition.</li><li data-list-item-id=\"eebdf49255006a7c2d9556e42ad155b03\">Train healthcare professionals on the specific needs of high-performance Para athletes.</li></ul><h3><strong>Start Your Journey Today</strong></h3><p>If you or someone you know is currently in rehabilitation and wants to explore the world of Para sports, NPC Bangladesh is here to guide you. Sport is a universal language of hope, and your disability is not a boundary—it is the starting line of your Paralympic story.</p><p>&nbsp;</p><p>&nbsp;</p><blockquote><h4><strong>\"Sport has the power to change the world. It has the power to inspire. It has the power to unite people in a way that little else does.\"</strong>&nbsp;</h4><p>— <i>Sir Ludwig Guttmann, Founder of the Paralympic Movement.</i></p></blockquote><p>&nbsp;</p><p>&nbsp;</p>', NULL, NULL, NULL, NULL, 'Active', 1, 1, '2026-01-15 15:35:11', '2026-01-18 01:43:57'),
(30, 'previous-national-events', 'National Sports Activities', 'national-sports-activities', 'National Sports Activities', 'National Sports Activities', NULL, NULL, NULL, NULL, NULL, 'Active', 1, 1, '2026-01-18 02:12:30', '2026-01-19 05:51:13'),
(31, 'previous-international-events', 'International Participation', 'international-participation', 'International Participation', 'International Participation', NULL, NULL, NULL, NULL, NULL, 'Active', 1, 1, '2026-01-18 02:13:01', '2026-01-19 06:27:09'),
(32, 'default', 'Training & Others', 'training-others', 'Training & Others', 'Training & Others', '<p>Training &amp; Others</p>', '', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-18 02:21:15', '2026-01-18 02:21:15'),
(33, 'default', 'NON-PARALYMPIC SPORTS', 'non-paralympic-sports', 'NON-PARALYMPIC SPORTS', 'NON-PARALYMPIC SPORTS', '<p>NON-PARALYMPIC SPORTS</p>', '', 'NON-PARALYMPIC SPORTS', 'NON-PARALYMPIC SPORTS', 'NON-PARALYMPIC SPORTS', 'Active', 1, 1, '2026-01-18 03:44:39', '2026-01-18 03:44:39'),
(34, 'default', 'Physically Challenged Cricket', 'physically-challenged-cricket', 'Physically Challenged Cricket', 'Physically Challenged Cricket', '<p><span style=\"background-color:rgb(249,249,249);color:rgb(33,37,41);\">Physically Challenged Cricket</span></p>', 'pages/34/image_696caeb4c1822.jpg', 'Physically Challenged Cricket', 'Physically Challenged Cricket', 'Physically Challenged Cricket', 'Active', 1, 1, '2026-01-18 03:55:47', '2026-01-18 03:58:12'),
(35, 'previous-national-non-sports-events', 'National Non-Sports Events', 'national-non-sports-events', 'National Non-Sports Events', NULL, NULL, '', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-19 05:43:24', '2026-01-19 05:43:24'),
(40, 'gallery-national-non-sports-events', 'National Non-Sports Events Gallery', 'national-non-sports-events-gallery', 'National Non-Sports Events Gallery', NULL, NULL, '', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-24 23:52:41', '2026-01-24 23:52:41'),
(41, 'gallery-national-sports-activities', 'National Sports Activities Gallery', 'national-sports-activities-gallery', 'National Sports Activities Gallery', NULL, NULL, '', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-24 23:53:23', '2026-01-24 23:53:23'),
(42, 'gallery-international-participation', 'International Participation Gallery', 'international-participation-gallery', 'International Participation Gallery', NULL, NULL, '', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-24 23:54:00', '2026-01-24 23:54:00'),
(44, 'default', 'Amputee Football', 'amputee-football', 'Amputee Football', 'Amputee Football', '<p>When you think of football, you might picture packed stadiums and star players. But there\'s a version of the beautiful game that combines incredible athleticism, strategic brilliance, and an inspiring display of human spirit: Amputee Football. This isn\'t just a sport; it\'s a testament to the power of determination, pushing boundaries and captivating audiences worldwide.</p><p>Just recently, the sport made global headlines when Polish player Marcin Oleksy won the prestigious FIFA Puskás Award for the best goal of the year in 2023. His incredible bicycle kick wasn\'t just a moment of brilliance for amputee football, but a historic milestone, proving that skill knows no limits and can stand shoulder-to-shoulder with the world\'s greatest athletes.</p><h4>How It\'s Played: The Basics</h4><p>Amputee football is a dynamic disabled sport played by two teams of seven players each: six outfield players and one goalkeeper.</p><ul><li data-list-item-id=\"e82ef15e1a8859e31ddaa5c1afbca1ea7\">Outfield players have lower extremity amputations and use Loftstrand (forearm) crutches, playing without their prostheses. Their agility and balance on crutches are truly astounding!</li><li data-list-item-id=\"edeedf11989fc21c1754cae45585e982a\">Goalkeepers have an upper extremity amputation.</li></ul><h4>The Rules That Make It Unique</h4><p>While the objective is the same – score more goals than your opponent – amputee football has some distinct rules that add to its unique flair:</p><ul><li data-list-item-id=\"e9f5237c0f293325c617208dc351349cf\">Crutches are Part of the Play (with a twist!): Outfield players use crutches for mobility, but if the ball intentionally touches a player\'s crutch, it\'s considered a handball and penalized accordingly.</li><li data-list-item-id=\"e2ab3f2cf7e89e3dc2437d4e9b20490d3\">No Offside Rule: Forget about offside traps! The absence of an offside rule means faster-paced action and more goal-scoring opportunities, keeping fans on the edge of their seats.</li><li data-list-item-id=\"ea024b0ee3be28899c1ddd5ff88111284\">The Residual Limb: Players are forbidden from using their residual limb to control, kick, or advance the ball. This ensures fair play and highlights the incredible skill required to maneuver the ball with one leg.</li><li data-list-item-id=\"e788914fb560bb32cefb71250fcc2ab8c\">Smaller Pitch, Intense Action: The game is typically played on a smaller field, around 60m x 40m, with smaller goals. This compact size ensures constant action and makes every pass and shot critical.</li><li data-list-item-id=\"e430b2fbf8ddc8980c8f5068aa854f433\">Match Duration: Matches consist of two intense 25-minute halves, with a 10-minute break in between.</li></ul><h4>The Global Stage</h4><p>The sport boasts a strong international presence, with national teams competing in thrilling tournaments. The current reigning world champion is Turkey, who lifted the trophy in the 2022 Amputee Football World Cup.</p>', 'pages/44/image_697af124624bf.jpeg', NULL, NULL, NULL, 'Active', 1, 1, '2026-01-28 23:33:24', '2026-01-28 23:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view-dashboard', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(2, 'view-users', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(3, 'create-users', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(4, 'update-users', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(5, 'delete-users', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(6, 'update-user-role', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(7, 'view-posts', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(8, 'create-posts', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(9, 'edit-posts', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(10, 'delete-posts', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(11, 'publish-posts', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(12, 'view-pages', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(13, 'create-pages', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(14, 'edit-pages', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(15, 'delete-pages', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(16, 'publish-pages', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(17, 'view-categories', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(18, 'create-categories', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(19, 'edit-categories', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(20, 'delete-categories', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(21, 'view-settings', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(22, 'update-settings', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(23, 'view-news-categories', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(24, 'create-news-categories', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(25, 'edit-news-categories', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(26, 'delete-news-categories', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(27, 'view-blog-categories', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(28, 'create-blog-categories', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(29, 'edit-blog-categories', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(30, 'delete-blog-categories', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(31, 'view-galleries', 'user', '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(32, 'create-galleries', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(33, 'edit-galleries', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(34, 'delete-galleries', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(35, 'publish-galleries', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(36, 'view-events', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(37, 'create-events', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(38, 'edit-events', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(39, 'delete-events', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(40, 'view-events-categories', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(41, 'create-events-categories', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(42, 'edit-events-categories', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(43, 'delete-events-categories', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(44, 'view-notices', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(45, 'create-notices', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(46, 'edit-notices', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(47, 'delete-notices', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(48, 'view-players', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(49, 'create-players', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(50, 'edit-players', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(51, 'delete-players', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(52, 'view-results', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(53, 'create-results', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(54, 'edit-results', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(55, 'delete-results', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(56, 'view-news', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(57, 'create-news', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(58, 'edit-news', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(59, 'delete-news', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(60, 'publish-news', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(61, 'view-blog', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(62, 'create-blog', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(63, 'edit-blog', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(64, 'delete-blog', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(65, 'publish-blog', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(66, 'manage-frontend', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(67, 'manage-committee-members', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(68, 'manage-menus', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(69, 'update-permissions', 'user', '2025-12-13 08:56:30', '2025-12-13 08:56:30');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(76, 'App\\Models\\User', 2, 'admin-token', '3753b094a42cec69265fc32a097d43eb7ab6ccbea8f97a0121c22620088e0b55', '[\"*\"]', '2026-01-19 09:09:11', NULL, '2026-01-10 08:35:45', '2026-01-19 09:09:11'),
(77, 'App\\Models\\User', 2, 'admin-token', '17be091ae86f16354c35d282c3c7cc8bf6357ced5f839fe3aa5a32461eff2308', '[\"*\"]', '2026-01-10 19:52:03', NULL, '2026-01-10 19:49:48', '2026-01-10 19:52:03'),
(82, 'App\\Models\\User', 2, 'admin-token', '1ead6c329e1fcbb96c31252903bf219186c726bbe83e494d83f3e8d33aaa4ea7', '[\"*\"]', '2026-01-28 23:29:38', NULL, '2026-01-20 10:04:44', '2026-01-28 23:29:38'),
(85, 'App\\Models\\User', 2, 'admin-token', '00c82c9577027be1a5bc81fe637bc3d976590bf0dbfe83b3ead15ce1f3bb85c1', '[\"*\"]', '2026-01-21 04:50:04', NULL, '2026-01-21 04:50:03', '2026-01-21 04:50:04'),
(101, 'App\\Models\\User', 1, 'admin-token', '692385e3e6c968dfe1bf7fc24f969d710391c70ccaa7e29c93e58f530b8ba092', '[\"*\"]', '2026-02-03 00:14:38', NULL, '2026-01-26 23:44:08', '2026-02-03 00:14:38'),
(102, 'App\\Models\\User', 1, 'admin-token', 'c37579d925174fc5a35ae965c623af93d3bf6b4a1c1380752697da6729bff178', '[\"*\"]', '2026-01-28 23:48:15', NULL, '2026-01-28 23:30:33', '2026-01-28 23:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sport` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `hometown` varchar(255) DEFAULT NULL,
  `asian_ranking` varchar(50) DEFAULT NULL,
  `national_ranking` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `createdBy` bigint(20) UNSIGNED DEFAULT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `name`, `sport`, `position`, `team`, `image`, `birthdate`, `country`, `height`, `weight`, `hometown`, `asian_ranking`, `national_ranking`, `age`, `slug`, `status`, `created_at`, `updated_at`, `createdBy`, `updatedBy`) VALUES
(5, 'Jhuma Akhter', 'Para Archery', 'Para Archery – Women', 'Bangladesh Para Archery Team', 'players/wfQ0etFarStFfIo6HWbzPz2WMrSuiHtMUFuHFAwl.png', '2005-10-13', 'Bangladesh', '123', '59', 'Khulna', '5655', '28', NULL, 'jhuma-akhter-para-archery-women-para-archery-20', 1, '2025-12-24 12:50:28', '2025-12-31 05:16:17', NULL, 1),
(6, 'Chaiti Rani Deb', 'Javelin Throw', 'Javelin Thrower', 'Bangladesh Para Athletics', 'players/X5yWgtsVS1Z826pKIC1fq1r5LMeUULS0SxbKbrce.jpg', '2008-07-17', 'null', '122', '36', 'Khustia', '963', '9', NULL, 'chaiti-rani-deb-javelin-thrower-javelin-throw-17', 1, '2025-12-24 12:50:28', '2025-12-24 07:05:03', NULL, NULL),
(7, 'Md. Shohidullah', 'Para Swimming', 'Para Swimmer', 'Bangladesh Para Swimming Team', 'players/6JELpR7TIwLW9PzgCuHS8MQ3HJoAna43r4daYkZt.jpg', '2001-12-26', 'Bangladesh', '136', '65', 'Dhaka', '79654', '852', NULL, 'md-shohidullah-para-swimmer-para-swimming-23', 1, '2025-12-24 12:50:28', '2025-12-24 07:15:26', NULL, NULL),
(9, 'Ali Imam', 'Para Badminton', 'Front/Back and Side-by-Side', 'Team Bangladesh Para Badminton', 'players/9/images/player_image_696272380d7bb.jpeg', '2002-01-01', 'Bangladesh', '533', '58', 'Chattagram', NULL, NULL, NULL, 'ali-imam-frontback-and-side-by-side-para-badminton-24', 1, '2026-01-10 09:37:28', '2026-01-10 09:37:28', 1, 1),
(10, 'Joyotu Dhor', 'Para Badminton', 'Position: Front/Back and Side-by-Side', 'Bangladesh', 'players/10/images/player_image_696272df149c9.jpeg', '2020-01-01', 'Bangladesh', '408', '60', 'Dhaka', NULL, NULL, NULL, 'joyotu-dhor-position-frontback-and-side-by-side-para-badminton-6', 1, '2026-01-10 09:40:15', '2026-01-10 09:40:15', 1, 1),
(11, 'Shormi Akter', 'Unknown', 'Unknown', 'Unknown', 'players/11/images/player_image_696276c45fd0b.jpeg', '2010-12-01', 'Bangladesh', '300', '35', 'dhk', 'null', 'null', NULL, 'shormi-akter-unknown-unknown-15', 1, '2026-01-10 09:56:52', '2026-01-10 22:29:37', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `slug` text NOT NULL,
  `short_des` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `f_image` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `createdBy` bigint(20) UNSIGNED NOT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_title`, `slug`, `short_des`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `f_image`, `image`, `alt_name`, `publish_date`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(9, 'এশিয়ান ইয়ুথ প্যারা গেমসে বাংলাদেশের স্বর্ণপদক জয়', 'এশিয়ান-ইয়ুথ-প্যারা-গেমসে-বাংলাদেশের-স্বর্ণপদক-জয়', 'দুবাই ২০২৫ এশিয়ান ইয়ুথ প্যারা গেমসে চৈতি রাণী দেবের স্বর্ণপদক জয় বাংলাদেশের প্যারালিম্পিক ইতিহাসে এক অনন্য মাইলফলক।', '<p>মৌলভীবাজারের শ্রীমঙ্গলের প্রান্তিক সম্প্রদায় থেকে উঠে আসা প্রতিভাবান প্যারা অ্যাথলেট চৈতি রাণী দেব দুবাইয়ে অনুষ্ঠিত এশিয়ান ইয়ুথ প্যারা গেমস ২০২৫-এ জ্যাভেলিন ইভেন্টে স্বর্ণপদক জিতে বাংলাদেশকে গৌরবান্বিত করেছেন। তার এই অসাধারণ অর্জন তার দৃঢ় মনোবল, অধ্যবসায় ও অনন্য ক্রীড়া দক্ষতার উৎকৃষ্ট প্রমাণ। চৈতির সাফল্য শুধু ব্যক্তিগত মাইলফলক নয়; এটি বাংলাদেশের প্যারা ক্রীড়াঙ্গনের জন্য এক ঐতিহাসিক অর্জন, যা দেশের সকল প্রতিবন্ধী ক্রীড়াবিদের সম্ভাবনার উজ্জ্বল প্রতীক।</p><p><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.87);\">সীমিত সুযোগ-সুবিধার এক প্রত্যন্ত অঞ্চল থেকে আন্তর্জাতিক মঞ্চে উত্তরণ— চৈতির এই যাত্রা অনুপ্রেরণাদায়ী ও রূপান্তরমূলক। তাঁর সাফল্য সহস্রাধিক প্রতিবন্ধী তরুণ ক্রীড়াবিদের জন্য শক্তিশালী অনুপ্রেরণা হিসেবে কাজ করবে, প্রমাণ করবে যে সঠিক সহায়তা, প্রশিক্ষণ ও সুযোগ পেলে শ্রেষ্ঠত্ব অর্জন সম্ভব। আজ তিনি দেশের এক অনুকরণীয় ব্যক্তিত্ব, যার সাফল্যের গল্প আশা, সক্ষমতা ও ক্ষমতায়নের বার্তা বহন করে।&nbsp;</span></p><p style=\"margin-left:0px;\">ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশ (এনপিসি বাংলাদেশ) ২০২৫ জাতীয় যুব প্যারা গেমস চলাকালে কঠোর প্রতিভা অনুসন্ধান কার্যক্রমের মাধ্যমে চৈতির সম্ভাবনা শনাক্ত করে। নির্বাচনের পর তিনি এক মাসব্যাপী নিবিড় প্রশিক্ষণ ক্যাম্পে অংশগ্রহণ করেন, যেখানে অভিজ্ঞ কোচ ও প্রশিক্ষকরা তার দক্ষতা শানিত করা, শারীরিক সক্ষমতা বৃদ্ধি এবং আন্তর্জাতিক প্রতিযোগিতার উপযোগী প্রস্তুতি নিশ্চিত করতে নিবিড়ভাবে সহায়তা করেন। এই পরিকল্পিত ও কাঠামোবদ্ধ প্রস্তুতি চৈতির প্রাকৃতিক প্রতিভাকে আন্তর্জাতিক মানে উন্নীত করতে গুরুত্বপূর্ণ ভূমিকা রাখে।&nbsp;</p><p style=\"margin-left:0px;\">&nbsp;</p><p style=\"margin-left:0px;\">এনপিসি বাংলাদেশ দৃঢ়ভাবে বিশ্বাস করে যে, চৈতির অর্জন প্রমাণ করে— প্রতিভার প্রাথমিক শনাক্তকরণ, পদ্ধতিগত প্রশিক্ষণ এবং প্যারা অ্যাথলেটদের প্রতি নিয়মিত বিনিয়োগ অপরিহার্য। যথাযথ লালনপালন, আধুনিক সুবিধা ও উচ্চমানে প্রশিক্ষণ নিশ্চিত করা হলে বাংলাদেশের আরো বহু প্যারা অ্যাথলেট বিশ্বমঞ্চে সাফল্য অর্জন করতে সক্ষম হবেন।&nbsp;</p><p style=\"margin-left:0px;\">চৈতি রাণী দেবের সাফল্য সরকার ও বেসরকারি প্রতিষ্ঠানের আরও শক্তিশালী সহযোগিতা ও সমর্থনের প্রয়োজনীয়তা তুলে ধরে। বাংলাদেশের প্যারালিম্পিক আন্দোলনকে এগিয়ে নিতে বাড়তি অর্থায়ন, অন্তর্ভুক্তিমূলক ক্রীড়া কর্মসূচি, সহজপ্রাপ্য প্রশিক্ষণ কেন্দ্র এবং প্রতিবন্ধী অ্যাথলেটদের জন্য দীর্ঘমেয়াদি উন্নয়ন কাঠামো অত্যন্ত জরুরি। সম্মিলিত উদ্যোগই নিশ্চিত করতে পারে দেশের প্রত্যন্ত অঞ্চলের প্রতিশ্রুতিশীল অ্যাথলেটরা তাদের সর্বোচ্চ সম্ভাবনা বাস্তবায়নের সুযোগ পাবেন।&nbsp;</p><p style=\"margin-left:0px;\">&nbsp;</p><p style=\"margin-left:0px;\">দুবাই ২০২৫ এশিয়ান ইয়ুথ প্যারা গেমসে চৈতি রাণী দেবের বিজয় বাংলাদেশের প্যারালিম্পিক অগ্রযাত্রায় এক গুরুত্বপূর্ণ মাইলফলক, যা অন্তর্ভুক্তিমূলক ক্রীড়া বিকাশে নতুন উদ্দীপনা সঞ্চার করবে এবং দেশের প্যারা অ্যাথলেটদের অসামান্য সক্ষমতাকে জাতির সামনে আরও উজ্জ্বলভাবে উপস্থাপন করবে।</p>', 'চৈতি রাণী দেবের স্বর্ণজয়: দুবাই এশিয়ান ইয়ুথ প্যারা গেমসে বাংলাদেশের গর্ব', 'Chaiti Rani Deb, Bangladesh Para Athletics, Asian Youth Para Games 2025, NPC Bangladesh, Bangladesh Paralympic, Para Athlete Bangladesh, Disability Sports Bangladesh, Para Games Dubai, Inclusive Sports, Youth Para Athlete', 'Chaiti Rani Deb’s gold medal at the Dubai 2025 Asian Youth Para Games marks a historic milestone for Bangladesh’s Paralympic journey. Rising from a remote region with limited facilities, her success highlights the power of early talent identification, structured training, and inclusive sports development for para athletes.', 'posts/CJV5v4FNTKEgb9N0EJRgPETQ5FfPXQDjqiFqny6p.jpg', 'posts/9/images/image/image_69558f33ce2ad.jpg', 'এশিয়ান ইয়ুথ প্যারা গেমসে বাংলাদেশের স্বর্ণপদক জয়', '2025-11-16 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2025-12-31 15:01:39'),
(11, 'Bangladesh Amputee Football Team Gears Up for Asian Championship 2025', 'bangladesh-amputee-football-team-gears-up-for-asian-championship-2025', 'The Bangladesh Amputee Football Team', '<p>Bangladesh Amputee Football Team Gears Up for Asian Championship 2025</p><p><strong>The Bangladesh Amputee Football Team was seen in high spirits on Saturday morning as they continued their final training sessions ahead of the upcoming Asian Amputee Football Championship 2025, scheduled</strong> to take place from November 9 to 15 in Jakarta, Indonesia.</p><p>During the morning practice held at the Mohammadpur Shahid Park in Dhaka, players were seen warming up, strategizing, and fine-tuning their coordination under the supervision of team officials. The spirited session reflected both determination and unity as the athletes prepared to represent Bangladesh on the continental stage.</p><p>This year’s championship will feature nine national teams, including Bangladesh, Indonesia, Iran, Japan, Iraq, Malaysia, Syria, Uzbekistan, and Yemen. The top four teams will qualify for the 2026 Amputee Football World Cup in Costa Rica.</p><p>Team representatives expressed optimism about Bangladesh’s prospects, highlighting the players’ resilience and dedication despite limited facilities. The event marks a significant milestone for the nation’s growing para-sports movement, giving amputee athletes a global platform to showcase their strength and skill.</p><p>The World Amputee Football Federation (WAFF) is organizing the championship in collaboration with local sports authorities in Indonesia.</p><p>Credit : Ratul Hasan Shuvo</p>', 'Bangladesh Wins Gold and Bronze at Asian Youth Para Games 2025', 'Bangladesh para athletes, Asian Youth Para Games 2025, Chaiti Rani Deb, Md. Shahidullah, wheelchair basketball, para sports Bangladesh, NPC Bangladesh, para athletics, javelin throw, freestyle swimming', 'Bangladesh para athletes achieved historic success at the 2025 Asian Youth Para Games in Dubai, winning two golds and one bronze, including gold for Chaiti Rani Deb in javelin throw and Md. Shahidullah in 50m freestyle.', 'posts/11/images/f-image/f_image_695592b26e367.jpg', 'posts/11/images/image/image_695592b26d8dc.jpg', 'Bangladesh Wins Gold and Bronze at Asian Youth Para Games 2025', '2025-11-19 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2025-12-31 15:16:34'),
(18, 'Physically Challenged Cricket Tournament 2025', 'physically-challenged-cricket-tournament-2025', 'Latest update in cricket.', '<p><span style=\"color:hsl(0, 0%, 0%);\">Celebrating 34th International &amp; 27th National Day of Persons with Disabilities and Physically Challenged Cricket Tournament 2025</span></p><p><br>&nbsp;</p>', 'Cricket T20 League Highlights', 'cricket, sports, results', 'Detailed coverage and insights about cricket.', 'posts/18/images/f-image/f_image_69558df21f195.jpg', 'posts/18/images/image/image_69558e933433d.jpg', NULL, '2025-11-21 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2025-12-31 14:58:59'),
(20, 'Amputee Football Carnival 2025', 'amputee-football-carnival-2025', 'Amputee Football Carnival 2025', '<p><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.9);\">⚽️Amputee Football Carnival 2025</span><br><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.9);\">👉Selection &amp; Trial Camp : 20 October, 2025</span><br><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.9);\">🏆WAFF World Cup Qualifiers</span><br><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.9);\">👏Jakarta/Indonesia 2025</span></p>', 'Fitness Tips for Cricketers', 'cricket, sports, results', 'Detailed coverage and insights about cricket.', 'posts/20/images/f-image/f_image_695593ffd00ba.jfif', 'posts/20/images/image/image_695593ffcf671.jpg', 'Amputee Football Carnival 2025 image', '2025-11-16 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2025-12-31 15:22:07'),
(22, 'National para badminton championships 2025', 'national-para-badminton-championships-2025', 'national para badminton championships 2025', '<p><span style=\"color:rgb(10,54,35);\">প্রথমবারের মতো সম্পন্ন হলো প্যারা ব্যাডমিন্টন প্রতিযোগিতা ও বাছাই পর্ব। যেখান থেকে আন্তর্জাতিক টুর্নামেন্টে অংশ নেয়ার জন্য তৈরী করা হবে শাটলার পুল। জানিয়েছেন বাংলাদেশ প্যারা অলিম্পিক কমিটির মহাসচিব ড. মারুফ আহমেদ মৃদুল। এমন টুর্নামেন্টে অংশ নিতে পেরে উচ্ছসিত দেশের বিভিন্ন প্রান্ত থেকে আসা খেলোয়াড়রা। তাদের উন্নত প্রশিক্ষনের জন্য বিদেশি কোচ নিয়োগ দেয়া হবে বলে জানিয়েছেন প্যারা অলিম্পিক কমিটির সহ-সভাপতি ও ডিবি প্রধান নাসিরুল ইসলাম।</span></p>', 'Badminton Doubles Tournament Recap', 'badminton, sports, results', 'Detailed coverage and insights about badminton.', 'posts/22/images/f-image/f_image_6955957241021.jpg', 'posts/22/images/image/image_6955957240562.jpg', 'badminton image', '2025-11-30 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2026-01-15 13:18:34'),
(23, 'Para swimming', 'para-swimming', 'Para swimming', '<h4><strong>Champions Crowned at National Youth Para Games 2025 Swimming Ceremony</strong></h4><p>The <strong>Syed Nazrul Islam National Swimming Complex</strong> in Mirpur resonated with the spirit of triumph on <strong>October 10, 2025</strong>, as the <strong>National Paralympic Committee (NPC) of Bangladesh</strong> hosted the official Prize Giving Ceremony for the <strong>National Youth Para Games 2025 Para Swimming</strong> events.</p><h4><strong>A Celebration of Grit and Excellence</strong></h4><p>The ceremony marked the conclusion of a high-energy competition where young Para-athletes from across the country showcased extraordinary talent. The event, <strong>Powered by FreshWay</strong>, highlighted the NPC’s commitment to fostering inclusion through elite sports.</p><p>The proceedings began with a warm <strong>Welcome Speech</strong> by <strong>Dr. Maruf Ahmed Mridul</strong>, Secretary General of the National Paralympic Committee of Bangladesh, who praised the athletes for their dedication and the parents for their unwavering support.</p><h4><strong>Honored Guests and Leadership</strong></h4><p>The ceremony was graced by a distinguished panel of guests from the law enforcement, corporate, and sporting sectors:</p><ul><li data-list-item-id=\"e2e60b99b0a24b4a9c056f8740f389b42\"><strong>Chief Guest:</strong> <strong>Mohammod Nasirul Islam</strong>, Joint Commissioner of Bangladesh Police and Vice-President of the National Paralympic Committee of Bangladesh. He commended the athletes\' resilience and emphasized the importance of sports in building a more inclusive society.</li><li class=\"ck-list-marker-bold\" data-list-item-id=\"ec37fd8a24ac682d2eaaba49fba0495f1\"><strong>Special Guests of Honor:</strong><ul><li data-list-item-id=\"ea451384f12e716e110c3438bd45a2bb1\"><strong>Amreen Bashir</strong>, Executive Director, Freshway Agtech.</li><li data-list-item-id=\"ee4051b6f5c295739044a289f987eb081\"><strong>ABM Obaidullah</strong>, Managing Director, Freshway Agtech.</li><li data-list-item-id=\"e6c0275d3cde8e6c8a3361ed7c989709f\"><strong>Faruqul Islam</strong>, National Director, Special Olympics Bangladesh.</li><li data-list-item-id=\"e8dbfab994713f669a320e280cfb03c0a\"><strong>Nibedita Das</strong>, Joint Secretary, Bangladesh Swimming Federation.</li><li data-list-item-id=\"ec5ee1030868765d7ee99e07fe08e41a7\"><strong>Major (retd.) Md. Atiqur Rahman</strong>, Treasurer, Bangladesh Swimming Federation.</li></ul></li></ul><h4><strong>Empowering the Future</strong></h4><p>The presence of leaders from the <strong>Bangladesh Swimming Federation</strong> and <strong>Special Olympics Bangladesh</strong> underscored a unified front in the development of aquatic sports for individuals with disabilities. As medals were draped around the necks of the young champions, the atmosphere was one of pure inspiration.</p><p>This event was successfully organized by the <strong>National Paralympic Committee of Bangladesh</strong>, continuing its mission to empower the next generation of Para-sport stars.</p><h4><strong>Quick Event Summary</strong></h4><ul><li data-list-item-id=\"e37f2a6c6b929c3a975fe77ffe65bfb74\"><strong>Event:</strong> National Youth Para Games 2025 (Para Swimming)</li><li data-list-item-id=\"e50b29414908aa0efefbc4c9f7045392c\"><strong>Date:</strong> 10 October 2025</li><li data-list-item-id=\"e4bcb1f0335a65bbbfaaf4e58b456378f\"><strong>Venue:</strong> Syed Nazrul Islam National Swimming Complex, Mirpur-2, Dhaka</li><li data-list-item-id=\"ef01a987344e195757e9b5a53ddb39001\"><strong>Organizer:</strong> National Paralympic Committee of Bangladesh</li><li data-list-item-id=\"e50316934759b26069d43095a46b1bd50\"><strong>Lead Sponsor:</strong> FreshWay</li></ul>', 'National Youth Para Games 2025: Para Swimming Prize Giving Ceremony', 'National Youth Para Games 2025, Para Swimming Bangladesh, National Paralympic Committee of Bangladesh, FreshWay Agtech, Syed Nazrul Islam National Swimming Complex, Para-athlete awards Dhaka, Bangladesh Police sports, Special Olympics Bangladesh.', 'Highlights from the National Youth Para Games 2025 Para Swimming Prize Giving Ceremony at Mirpur Swimming Complex. Chief Guest: Mohammod Nasirul Islam. Powered by FreshWay.', 'posts/23/images/f-image/f_image_695597ebc393d.jfif', 'posts/23/images/image/image_695597ebc2cf6.jpg', 'Para swimming', '2025-12-11 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2025-12-31 15:38:51'),
(24, 'Joma Akter: Bangladesh’s Historic Path to Paris 2024 Paralympics', 'joma-akter-bangladeshs-historic-path-to-paris-2024-paralympics', 'Discover Joma Akter\'s  journey from wheelchair basketball to archery stardom.', '<p><a href=\"https://www.worldarchery.sport/athlete/49261\">Joma Akter</a> always yearned for making a name for herself and Bangladesh since the beginning of her para sport journey.</p><p>It didn’t take much time for her to realise her long-cherished dream of qualifying for the Paralympic Games with a third-place finish <a href=\"https://www.worldarchery.sport/competition/28002/\">at the final qualification tournament for Paris 2024</a> in Dubai in March.</p><p>It was historical and highly promising for the country –&nbsp;exactly one year after <a href=\"https://www.worldarchery.sport/news/201100/\">a new para archery federation was launched in Bangladesh</a> –&nbsp;and Akter who began playing the sport only six months ago.&nbsp;</p><p>The 20-year-old, certainly, was flabbergasted on the development.</p><p>“I’m so happy, I don’t have words to express my feeling, it’s one of the proudest moments for me,” said an ecstatic Akter after her efforts gave new hopes and dreams for the nation.</p><p>She also shared her nerve-wrecking experience playing in her only second international para archery tournament –&nbsp;she finished ninth at the <a href=\"https://www.worldarchery.sport/competition/24846\">Hangzhou 2022 Asian Para Games </a>in October.</p><p>“When I was aiming, I had little difficulty due to the light,” she explained. “Moreover, I was very nervous to shoot alongside such experienced players. But I settled down gradually.”</p><p>“Next time, if I get a chance to play in a big stage – I can do better. It was a great learning experience today.”&nbsp;</p><p>Akter won one of the two Olympic places on offer in the compound women’s open final quota event defeating <a href=\"https://www.worldarchery.sport/athlete/15357\">Teresa Wallace</a> from USA in the bronze final.</p><p>She comprised a squad of two men and two women in Dubai, after the team had just made its international debut with five competitors at the Asian Para Games a few months ago.</p><p>“Getting the chance to play at the Asian Para Games as our first international event was a milestone,” said Joma, who was part of the women’s wheelchair basketball team in Bangladesh for two years before switching to para archery much like her teammate <a href=\"https://www.worldarchery.sport/athlete/49177\">Rupali Akter</a>, a recurver.</p><p>“It was very motivating to meet the big names in the sport and witness their game. It built my confidence and improved my temperament level.”</p><p>“It was a big learning experience for all of us – playing in such a big stage and meeting the stars,” added Rupali, seconding Joma’s emotion. “We are so thankful to our coaches and Bangladesh Para Archery Federation for giving us the opportunity.”</p><p>“The Hangzhou 2022 Games instilled the drive to do something in my career,” the 22-year-old said.</p><p>Joma also admitted of her inclination for archery since she was introduced to the sport following her spinal cord injury in 2018.</p><p>“I was involved with sports since my accident, but I was more comfortable playing archery considering my disability. Besides I felt it has better future.”</p><p>The 20-year-old lost in the second round in Hangzhou and won a bronze medal competing against able-bodied archers in a national ranking tournament in Bangladesh, before getting the Paralympic quota in Dubai.</p><p>Para archery started in Bangladesh only last year after the National Paralympic Committee became the 45th national organisation to be included in the Paralympic fold at International Paralympic Committee general assembly in Bahrain in September 2022.</p><p>And in a short span of time, the nation’s para archers have shown a lot of promise and determination to excel on the world stage, taking a leaf out of their able-body counterparts’ success in recent times that included <a href=\"https://www.worldarchery.sport/athlete/14168\">Ruman Shana</a> becoming the <a href=\"https://www.worldarchery.sport/news/170843/\">first archer from Bangladesh to qualify a quota place for the Olympic Games</a>.&nbsp;</p><p>The Bangladesh Para Archery Federation’s founding president&nbsp;<a href=\"https://www.worldarchery.sport/athlete/17573\">Kazi Rajib Uddin Ahmed Chapol</a>, who is also general secretary of the <a href=\"https://www.worldarchery.sport/member/ban/\">Bangladesh Archery Federation</a>, acknowledged the dedication and determination of his support team and the athletes for the amazing results they have delivered.&nbsp;</p><p>He, however, has called for support for the development of the sport in the South Asian nation.</p><p>“[It] is a newly formed association, we have a good committee, and everyone is working hard in putting a structure in place,” he explained. “I can also see a lot of potential among our archers who are keen to not just participate in international events but learn and grow as a player.”</p><p>“Our journey has just begun, and to become better and grow in the sport, we need support from the government and the international federation.”</p><p>Currently, the national federation boasts 12 para archers, five of whom have proudly participated at the last year’s Asian Para Games, who reside and train at the Bangladesh Kreeda Sheekha Pratisthan, the national sports institute in Savar, about 28 kilometres north-west of the capital, Dhaka.</p><p>They not only train with the abled-bodies archers of Bangladesh,&nbsp;but also compete in various national level events, including the one held recently to promote archers on International Women’s Day.</p><p>“Archery is a famous sport in Bangladesh with infrastructure and training undergoing in the Army, Air Force and national sports institute,” explained para coach Nishit Das, an important figure in Bangladesh archery coaching structure. “Playing together with the abled body archers is a big boost for the para archers and good preparation for their skills and technique.”</p><p>Support for para archery in Bangladesh is coming from private organisations that sponsored the entire trip for the archers and support staff in Dubai, for example.</p><p>“We are very thankful to them for trusting our efforts,” he added, hoping that more support will come on board after this result. “Our aim was to qualify for the Paralympics and now we aim to put up a strong show in Paris.”</p><p>For the South Asian nation, the first target was achieved in Dubai, but the journey has just begun.&nbsp;</p><p>“Our archers have a long way to go,” coach Das concluded.</p>', 'Joma Akter: Bangladesh’s Historic Path to Paris 2024 Paralympics', 'Joma Akter, Bangladesh Para Archery, Paris 2024 Paralympics, Bangladesh Para Archery Federation, Dubai 2024 Qualification, Rupali Akter, Kazi Rajib Uddin Ahmed Chapol, Para-athlete success story, Archery Bangladesh, National Paralympic Committee Bangladesh.', 'Meet Joma Akter, the para-archer who secured Bangladesh’s first Paralympic quota for Paris 2024. Discover her journey from wheelchair basketball to archery stardom.', 'posts/24/images/f-image/f_image_69559c25c94db.jfif', 'posts/24/images/image/image_69559c25c8ca7.jfif', 'Joma Akter: Bangladesh’s Historic Path to Paris 2024 Paralympics', '2025-11-15 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2025-12-31 15:56:53'),
(25, 'World Archery Para Championships', 'world-archery-para-championships', 'World Archery Para Championships', '<p>The <strong>Gwangju 2025 World Archery Para Championships</strong> held from September 22 to 28, 2025, served as a historic stage for Bangladesh, continuing the momentum from Joma Akter’s breakthrough in early 2024.</p><p>Following its official entry into the international Para-archery scene, Bangladesh sent a focused delegation to Gwangju to compete among 239 athletes from 47 nations. The event was a vital platform for our archers to gain experience against the world\'s best, including stars from China and India.</p><h3><strong>Event Overview: Gwangju 2025</strong></h3><ul><li data-list-item-id=\"e5ef6701c5f043ad5acf7ee934a490026\"><strong>Venue:</strong> Gwangju International Archery Center, Republic of Korea.</li><li data-list-item-id=\"e13af2df77d80eba1280c049c9fc71b53\"><strong>Bangladesh\'s Participation:</strong> Building on the success of the Dubai 2024 qualifiers, the team focused on the <strong>Compound and Recurve</strong> categories.</li><li data-list-item-id=\"e42358623215f99cbf95e2bc6b984ee20\"><strong>Key Focus:</strong> The championships were essential for maintaining international world rankings and preparing for the <strong>Nagoya 2026 Asian Para Games</strong>.</li><li data-list-item-id=\"eaaad7bf5c37c948d99fcd592916d2b90\"><strong>Global Standard:</strong> The competition was fierce, with <strong>China</strong> leading the medal table (12 medals) and <strong>India</strong> following closely (5 medals), setting a high benchmark for our developing squad.</li></ul><h3><strong>The Road Ahead</strong></h3><p>While the national team continues to refine its technical skills at the <strong>BKSP training camp</strong> in Savar, the Gwangju championships provided invaluable exposure to \"Finals Court\" pressure. The experience gained in Korea has directly influenced our current training cycles, specifically focusing on mental composure and adapting to different lighting conditions—challenges</p>', 'World Archery Para Championships', 'Bangladesh Paralympic Committee, National Paralympic Committee Bangladesh, Para Sports Bangladesh, Disabled Sports Dhaka, NPC Bangladesh, Inclusive Sports Bangladesh, National Para Games', 'World Archery Para Championships', 'posts/25/images/f-image/f_image_69559e263c8a5.jpg', 'posts/25/images/image/image_69559e263bf99.jpg', 'World Archery Para Championships', '2025-11-26 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2025-12-31 16:05:26'),
(26, 'Top Badminton Players of the Year', 'top-badminton-players-of-the-year', 'Latest update in badminton.', '<p>This post covers badminton related news and updates.</p>', 'Top Badminton Players of the Year', 'badminton, sports, results', 'Detailed coverage and insights about badminton.', 'posts/aZd8K3YzklN9glVWQaRVkcbYkCrcs44PEfUvFqmz.png', 'posts/6lFynmVIwzQrvN3efAZDwA1luCsiQ6u8dP5jJfSg.png', 'badminton image', '2025-12-13 08:56:30', '0', 1, 1, '2025-12-13 08:56:30', '2025-12-31 16:05:46'),
(27, 'Badminton Championship Highlights', 'badminton-championship-highlights', 'Latest update in badminton.', '<p>This post covers badminton related news and updates.</p>', 'Badminton Championship Highlights', 'badminton, sports, results', 'Detailed coverage and insights about badminton.', 'posts/sTPpTvSKYL3E439kF1F5Z85Fqxn3GOTK8ZBVLAPo.png', 'posts/9r66Qj3C2JuiNd33JOuaXnyHnXGrkEedpAqiHkt5.png', 'badminton image', '2025-12-09 08:56:30', '0', 1, 1, '2025-12-13 08:56:30', '2025-12-31 16:05:51'),
(28, 'প্যারা টেবিল টেনিস ট্রেনিং ও প্রতিযোগিতা ২০২৪', 'প্যারা টেবিল টেনিস ট্রেনিং ও প্রতিযোগিতা ২০২৪', 'প্যারা টেবিল টেনিস ট্রেনিং ও প্রতিযোগিতা ২০২৪', '<p><span style=\"color:rgb(31,31,31);\">প্যারা টেবিল টেনিস ট্রেনিং ও প্রতিযোগিতা ২০২৪\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">আগামী ১০-১১ জুন ২০২৪ অনুষ্ঠিতব্য প্যারা টেবিল টেনিস ট্রেনিং ও টুর্নামেন্টে অংশগ্রহণ করতে ইচ্ছুক হুইলচেয়ার ব্যবহারকারী, হাত বা পায়ের আংশিক কিংবা পূর্ণ অঙ্গহানি- এমন পুরুষ বা মহিলা খেলোয়াড়দের ০৯ জুন ২০২৪ রোজ রবিবার রাত ১০ টার মধ্যে নিম্নে উল্লেখিত ফোন নম্বরে এসএমএস-এর মাধ্যমে প্রাথমিক রেজিস্ট্রেশন সম্পন্ন করার আহ্বান জানানো যাচ্ছে।\r\n</span></p><p><span style=\"color:rgb(31,31,31);\"><strong>উল্লেখ্য- টুর্নামেন্টের দিন প্রত্যেক নিবন্ধিত খেলোয়াড়দের প্রতিবন্ধিতার ধরণ ও খেলার অভিজ্ঞতা উল্লেখপূর্বক একটি জীবন বৃত্তান্ত জমা দিতে হবে।</strong>\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">প্যারা টেবিল টেনিস রেজিস্ট্রেশনের জন্য এসএমএস করুন- ০১৭৭০৩৪৭৬৩৯\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">রেজিস্ট্রেশন সম্পন্ন করতে যেসকল তথ্য এসএমএস করতে হবে,\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">১। খেলোয়াড়ের নাম\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">২। খেলোয়াড়ের প্রতিবন্ধিতার ধরণ\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">৩। খেলোয়াড়ের ফোন নম্বর\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">৪। খেলোয়াড়ের ওয়াটস অ্যাপ নম্বর\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">৫। খেলোয়াড়ের বর্তমান বয়স\r\n</span></p><p><span style=\"color:rgb(31,31,31);\">৬। খেলোয়াড়ের বর্তমান ঠিকানা</span></p>', 'Para Table Tennis', 'Para Table Tennis, sports, results', 'Detailed coverage and insights about Para Table Tennis.', 'posts/28/images/f-image/f_image_696374ccf323b.jpg', 'posts/28/images/image/image_696374ccefc9f.jpg', 'Para Table Tennis', '2025-11-26 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2026-01-11 04:00:45'),
(29, 'ন্যাশনাল হুইলচেয়ার বাস্কেটবল চ্যাম্পিয়নশিপ ২০২৫', 'ন্যাশনাল হুইলচেয়ার বাস্কেটবল চ্যাম্পিয়নশিপ ২০২৫', 'এনপিসি বাংলাদেশ এর উদ্যোগে, ন্যাশনাল হুইলচেয়ার বাস্কেটবল চ্যাম্পিয়নশিপ ২০২৫', '<h4><span style=\"color:hsl(0, 0%, 0%);\"><strong><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb8/1/16/1f3c0.png\" alt=\"🏀\" width=\"16\" height=\"16\"> </strong></span><span style=\"background-color:rgb(248,249,250);color:rgb(31,31,31);\"><strong>National Wheelchair Basketball Championship 2025</strong></span><br><br><span style=\"color:hsl(0, 0%, 0%);\">To celebrate the festival of youth, the National Wheelchair Basketball Championship will be held for para athletes under the initiative of the National Paralympic Committee of Bangladesh (NPC Bangladesh).</span><br><br><span style=\"color:hsl(0, 0%, 0%);\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t2d/1/16/1f4cd.png\" alt=\"📍\" width=\"16\" height=\"16\"> Location: CRP, Chapain, Savar.\r\n</span></h4><h4><span style=\"color:hsl(0, 0%, 0%);\">⏰ Time &amp; 📅 Date:</span><br><span style=\"color:hsl(0, 0%, 0%);\">September 15, 2025 (Monday): 7:30 AM to 8 PM\r\n</span></h4><h4><span style=\"color:hsl(0, 0%, 0%);\">September 16, 2025 (Tuesday): 7:30 AM to 5 PM</span></h4><p>&nbsp;</p><p>&nbsp;</p><h4><span style=\"color:hsl(0, 0%, 0%);\"><strong>Chief Guest\r\n: Valerie Ann Taylor</strong>\r\n</span></h4><p><span style=\"color:hsl(0, 0%, 0%);\">Founder &amp; Coordinator\r\nCentre for the Rehabilitation of the Paralysed (CRP)\r\n</span></p><h4><span style=\"color:hsl(0, 0%, 0%);\"><strong>Special Guest\r\n: Dr. Mohammad Sohrab Hossain</strong>\r\n</span></h4><p><span style=\"color:hsl(0, 0%, 0%);\">Executive Director\r\nCentre for the Rehabilitation of the Paralysed (CRP)&nbsp;</span></p><p><span style=\"color:hsl(0, 0%, 0%);\">Executive Member, National Paralympic Committee of Bangladesh\r\n</span></p><h4><span style=\"color:hsl(0,0%,0%);\"><strong>Special Guest :&nbsp;</strong></span><span style=\"color:hsl(0, 0%, 0%);\"><strong>Subhash Sinha</strong>\r\n</span></h4><p><span style=\"color:hsl(0, 0%, 0%);\">Health and Physical Rehabilitation Project Manager (PRP)\r\n</span></p><p><span style=\"color:hsl(0, 0%, 0%);\">International Committee of Red Cross (ICRC), Bangladesh\r\n</span></p><h4><span style=\"color:hsl(0, 0%, 0%);\"><strong>Welcome Speech\r\n: Dr. Maruf Ahmed Mridul</strong>\r\n</span></h4><p><span style=\"color:hsl(0, 0%, 0%);\">Secretary General\r\nNational Paralympic Committee of Bangladesh</span></p><p>&nbsp;</p><figure class=\"image\"><img src=\"/public/storage/uploads/547372079_779074324717022_5471709936743153031_n_1768126726.jpg\"></figure><p>&nbsp;</p><p>&nbsp;</p>', 'Swimming Gala Results', 'swimming, sports, results', 'Detailed coverage and insights about swimming.', 'posts/29/images/f-image/f_image_69637da8d332c.jpg', 'posts/dHhR1AFQ5tEmQCv9mWINdJ4vEz160vEMXXzzmRrH.png', 'swimming image', '2025-11-25 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2026-01-11 04:40:08'),
(30, 'Youth Para Taekwondo', 'youth-para-taekwondo', 'Youth Para Taekwondo', '<figure class=\"media\"><div data-oembed-url=\"https://npcbangladesh.org/public/storage/uploads/AQOMvaIbmJSd5vsYr3K0CAZoshczDJTldDZPr-mzLugaAVr2rlcsV37l-eYiK-PqLqJeFPKHbWFa4DNOnyEL7AzUdZDlW2Yzd81iaQdqyA_1768131859.mp4\"><div style=\"padding-bottom: 20px;\">\r\n                        <video controls=\"\" style=\"width: 100%; height: 100%;\">\r\n                            <source src=\"https://npcbangladesh.org/public/storage/uploads/AQOMvaIbmJSd5vsYr3K0CAZoshczDJTldDZPr-mzLugaAVr2rlcsV37l-eYiK-PqLqJeFPKHbWFa4DNOnyEL7AzUdZDlW2Yzd81iaQdqyA_1768131859.mp4\" type=\"video/mp4\">\r\n                        </video>\r\n                    </div></div></figure>', 'How to Perfect Your Butterfly Stroke', 'swimming, sports, results', 'Detailed coverage and insights about swimming.', 'posts/30/images/f-image/f_image_69638d5042363.jpg', 'posts/30/images/image/image_69638d5041a46.jpg', 'swimming image', '2025-11-21 08:56:30', '1', 1, 1, '2025-12-13 08:56:30', '2026-01-11 05:45:36'),
(37, 'Table tennis Event Dubai', 'table-tennis-event-dubai', 'Table tenni', '<figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-14-at-62721-PM_1768496239.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-14-at-62726-PM_1768496233.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-14-at-62725-PM_1768496234.jpeg\"></figure><figure class=\"image\"><img src=\"/public/storage/uploads/WhatsApp-Image-2026-01-14-at-62723-PM_1768496236.jpeg\"></figure>', NULL, NULL, NULL, 'posts/37/images/f-image/f_image_69691cda7ed7d.jpeg', NULL, 'Table tenni', '2026-01-15 16:59:05', '1', 1, 1, '2026-01-15 10:59:05', '2026-01-15 10:59:06'),
(38, 'Para Archery Classification', 'para-archery-classification', 'Para Archery Classification', '<p>Classification is a fundamental part of Para Archery that ensures fair and equal competition for all athletes. It is the formal process of assessing an athlete’s impairment to determine their eligibility and to group them according to the impact their impairment has on archery performance. By categorizing athletes with similar activity limitations together, the system ensures that at the heart of the Paralympic Movement, it is the athlete’s skill, fitness, and focus that determine the winner—not the degree of their disability.</p><h3>How Classification Works</h3><p>The Para Archery classification system serves three primary purposes:</p><ul><li data-list-item-id=\"ecd23fdb3b1fd3b0481d06b10dcfd6d4e\"><strong>Determining Eligibility:</strong> Assessing if an athlete has an eligible impairment type to compete.</li><li data-list-item-id=\"e0b56af878d4346012119a846e1173123\"><strong>Grouping Athletes:</strong> Placing athletes into specific competition classes (such as W1 or Open) based on the severity of their impairment to maintain a balanced field.</li><li data-list-item-id=\"ec4dd20b69678a29cfca0b1c9e1b8c789\"><strong>Assistive Devices:</strong> Defining whether an athlete is permitted to use specific assistive equipment (such as stools, wheelchairs, or release aids) during competition.</li></ul><h3>National and International Standards</h3><p>In alignment with the <strong>International Paralympic Committee (IPC)</strong> and <strong>World Archery</strong> standards, classification is conducted at both the national level for domestic events and the international level for global representation. It is important to note that while an athlete may be classified to use an assistive device for support, they must meet specific criteria to be eligible for Para Archery competition.</p><h3>Get Started with NPC Bangladesh</h3><p>Are you an aspiring archer? If you are interested in being classified to use assistive devices or to compete in Para Archery sanctioned events, we are here to guide you. NPC Bangladesh works closely with national archery experts to facilitate the classification process.</p><p><strong>Contact the National Paralympic Committee of Bangladesh today to learn more about the next classification session and how you can begin your journey in Para Archery.</strong></p>', 'Para Archery Classification', 'Para Archery Classification', 'Para Archery Classification', 'posts/38/images/f-image/f_image_69693a9e7c1c9.png', NULL, 'Para Archery Classification', '2026-01-15 19:06:06', '1', 1, 1, '2026-01-15 13:06:06', '2026-01-15 13:06:06'),
(39, 'Para Athletics Classification', 'para-athletics-classification', 'Para Athletics Classification', '<h2>A Comprehensive Guide</h2><p>At the National Paralympic Committee (NPC) of Bangladesh, we adhere to the <strong>World Para Athletics Classification Rules and Regulations</strong>. Classification is essential to ensure that competition is fair and that success is determined by an athlete\'s skill and preparation. To be eligible, an athlete must have an eligible impairment that meets the minimum criteria established by World Para Athletics.</p><h2>1. Eligible Impairment Types</h2><p>There are <strong>10 eligible impairment types</strong> in Para Athletics, categorized into physical, vision, and intellectual impairments:</p><figure class=\"table\"><table><thead><tr><th><p style=\"margin-left:0px;\"><strong>Impairment Category</strong></p></th><th><p style=\"margin-left:0px;\"><strong>Description</strong></p></th></tr></thead><tbody><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Impaired Muscle Power</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Reduced ability to voluntarily contract muscles (e.g., Spinal cord injury, Polio, Spina Bifida).</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Impaired Passive Range of Movement</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Systematic restriction of movement in one or more joints.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Limb Deficiency</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Total or partial absence of bones or joints due to trauma, illness, or congenital conditions.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Leg Length Difference</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Significant difference in leg length due to growth disturbance or trauma.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Short Stature</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Reduced length in the bones of the upper limbs, lower limbs, and/or trunk.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Hypertonia</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Abnormal increase in muscle tension (e.g., Cerebral Palsy, Stroke).</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Ataxia</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Lack of muscle coordination of movements (e.g., Multiple Sclerosis).</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Athetosis</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Continual slow involuntary movements.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Vision Impairment</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Reduced or no vision caused by damage to the eye structure or optical nerves.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Intellectual Impairment</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Restrictions in intellectual functioning and adaptive behavior appearing before age 18.</span></p></td></tr></tbody></table></figure><p>&nbsp;</p><h2>Documentation and Requirements</h2><p>It is the responsibility of the athlete and NPC Bangladesh to ensure all medical documentation is submitted correctly via the <strong>SDMS online system</strong>.</p><ul><li data-list-item-id=\"efaf5e80cc1147cca2f5946ba21da986a\"><strong>Physical &amp; Vision Impairment:</strong> Must submit a completed <strong>Medical Diagnostics Form (MDF)</strong> along with all relevant supporting medical evidence.</li><li data-list-item-id=\"e4a1eb4b882cf73021fa77dfa16addf2d\"><strong>Intellectual Impairment:</strong> Must meet the <strong>VIRTUS II 1 Eligibility Criteria</strong> and be listed on the VIRTUS International Eligibility Master list. A <strong>TSAL-Q form</strong> must also be submitted.</li></ul><blockquote><p><strong>Important Note:</strong> All classification processes follow the <strong>World Para Athletics Classification Rules and Regulations (February 2023)</strong>. Proper documentation is mandatory before any athlete can be officially classified for competition.</p></blockquote>', 'Para Athletics Classification', 'Para Athletics Classification', 'Para Athletics Classification', 'posts/39/images/f-image/f_image_696942706ce0d.jpg', NULL, 'Para Athletics Classification', '2026-01-15 19:39:28', '1', 1, 1, '2026-01-15 13:39:28', '2026-01-15 13:39:28'),
(40, 'Para Badminton Classification', 'para-badminton-classification', 'Para Badminton Classification', '<p>At the National Paralympic Committee (NPC) of Bangladesh, we are committed to providing a level playing field for all Para Badminton athletes. Classification is the essential process that groups athletes into specific <strong>Sport Classes</strong> based on how their impairment affects their badminton movements. This ensures that success is determined by skill, fitness, and strategy rather than the level of impairment.</p><h2>The Classification Process</h2><p>The process is conducted by certified BWF (Badminton World Federation) classifiers and consists of two main parts:</p><ol><li data-list-item-id=\"efc9c26cb00728ef910ed305cee9f30c9\"><strong>Medical Examination:</strong> A review of the athlete\'s medical records and a physical assessment.</li><li data-list-item-id=\"e732331e3ac7a0b8dec55a1b734cdec02\"><strong>On-Court Assessment:</strong> The athlete performs specific badminton movements and shots to show the classifiers their range of motion and technical ability.</li></ol><p>Upon completion, players are assigned a <strong>Sport Class</strong> and a <strong>Sport Class Status</strong> (which tells you when your next evaluation is needed).</p><h2>BWF Para Badminton Sport Classes</h2><p>Athletes in Bangladesh can compete in one of the following six international classes:</p><h3>♿ Wheelchair Classes</h3><ul><li data-list-item-id=\"e12ec380a33425bc8f2c6b127797cfb7f\"><strong>WH 1:</strong> For players with impairments in both lower limbs and trunk function. A wheelchair is required.</li><li data-list-item-id=\"ed1e506cc6023696078647d5b5a9db7f7\"><strong>WH 2:</strong> For players with impairments in one or both lower limbs but minimal or no impairment of the trunk.</li></ul><h3>🏸 Standing Classes</h3><ul><li data-list-item-id=\"e2712cbcc6b82af079b24238ac448f8d1\"><strong>SL 3 (Standing Lower):</strong> Players must play standing and have a significant impairment in one or both lower limbs, often affecting balance.</li><li data-list-item-id=\"eb6f3cfc47985130072f90e2260fa260c\"><strong>SL 4 (Standing Lower):</strong> Players have a lesser impairment compared to SL 3, with minimal impairment in walking or running balance.</li><li data-list-item-id=\"ee74a6a999deca9a937a640a68f3b299f\"><strong>SU 5 (Standing Upper):</strong> Players have an impairment of the upper limbs (playing or non-playing arm).</li></ul><h3>🧍 Short Stature Class</h3><ul><li data-list-item-id=\"e9a0c63ae58ea84bf43d1ec6dd05a0b18\"><strong>SH 6:</strong> For athletes who have a short stature due to a genetic condition (often referred to as dwarfism).</li></ul>', 'Para Badminton Classification', 'Para Badminton Classification', 'Para Badminton Classification', 'posts/40/images/f-image/f_image_696944a073887.png', NULL, 'Para Badminton Classification', '2026-01-15 19:48:48', '1', 1, 1, '2026-01-15 13:48:48', '2026-01-15 13:48:48'),
(41, 'Para Table Tennis Classification', 'para-table-tennis-classification', 'Para Table Tennis Classification', '<p>At NPC Bangladesh, we follow the <strong>ITTF (International Table Tennis Federation)</strong> and <strong>IPC</strong> standards to ensure fair competition. In Para Table Tennis, classification is divided into three main groups: <strong>Wheelchair (Classes 1–5)</strong>, <strong>Standing (Classes 6–10)</strong>, and <strong>Intellectual Impairment (Class 11)</strong>.</p><h4><strong>The 11 Sport Classes</strong></h4><figure class=\"table\"><table><thead><tr><th><p style=\"margin-left:0px;\"><strong>Category</strong></p></th><th><p style=\"margin-left:0px;\"><strong>Class</strong></p></th><th><p style=\"margin-left:0px;\"><strong>Typical Impairment Profile</strong></p></th></tr></thead><tbody><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Wheelchair</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>1–2</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Significant impairment in the playing arm and no sitting balance.</span></p></td></tr><tr><td>&nbsp;</td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>3–5</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Full arm function but varying levels of trunk control and sitting balance.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Standing</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>6–8</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Severe to moderate impairments of both legs and/or the playing arm.</span></p></td></tr><tr><td>&nbsp;</td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>9–10</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">Mild impairments in legs or playing arm; includes those with short stature.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Intellectual</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>11</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">For athletes with an intellectual impairment (must meet VIRTUS criteria).</span></p></td></tr></tbody></table></figure><h3>&nbsp;</h3><h4><strong>Procedure for New Players (Status: \"New\")</strong></h4><p>If you are a Bangladeshi athlete preparing for your first international tournament, you must be evaluated by the ITTF-PTT. Follow these steps:</p><ul><li data-list-item-id=\"e8ffffd2781de0fa3eaf748bb69c63f13\"><strong>Step 1: Registration</strong> – Submit a scanned copy of your passport and a headshot to NPC Bangladesh to receive your Player ID.</li><li data-list-item-id=\"ec0b80165535942e8bac59ad3e230bf04\"><strong>Step 2: Medical Documentation</strong> – For <strong>Physical Impairment (Classes 1-10)</strong>, a certified health professional must sign the <strong>Medical Diagnostics Form (MDF)</strong>. For <strong>Intellectual Impairment (Class 11)</strong>, you must provide a <strong>VIRTUS Eligibility Number</strong>.</li><li data-list-item-id=\"eb1508974d78c0e2b78c394d55f8251ab\"><strong>Step 3: Consent</strong> – Sign the <strong>Athlete Consent Form</strong> (Guardian signature required if under 18).</li><li data-list-item-id=\"ef228818ed0151c27f5def867e92da32b\"><strong>Step 4: Submission</strong> – Documents must be submitted at least one month before your first competition.</li></ul>', 'Para Table Tennis Classification', 'Para Table Tennis Classification', 'Para Table Tennis Classification', 'posts/41/images/f-image/f_image_6969478adff59.png', NULL, 'Para Table Tennis Classification', '2026-01-15 20:01:14', '1', 1, 1, '2026-01-15 14:01:14', '2026-01-15 14:01:14');
INSERT INTO `posts` (`id`, `post_title`, `slug`, `short_des`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `f_image`, `image`, `alt_name`, `publish_date`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(42, 'Para Swimming Classification', 'para-swimming-classification', 'Fairness in the Water', '<p>At the National Paralympic Committee (NPC) of Bangladesh, we follow the <strong>World Para Swimming Rules and Regulations</strong>. Classification ensures that success in the pool is determined by an athlete’s skill, fitness, and power, rather than the impact of their impairment.</p><p>Through classification, athletes are grouped into <strong>\"Sport Classes\"</strong> based on how their impairment affects their ability to perform different swimming strokes.</p><h4>1. Eligible Impairment Groups</h4><p>Para Swimming caters to three main groups, which include 10 specific impairment types:</p><ul><li data-list-item-id=\"ecdf95519590b3b61b983e39fe7676807\"><strong>Physical Impairment (Classes 1–10):</strong> Includes impaired muscle power, limb deficiency, hypertonia, ataxia, athetosis, short stature, and impaired range of movement.</li><li data-list-item-id=\"e9fd35efc4f04e91ef8a6a1dd1109969f\"><strong>Vision Impairment (Classes 11–13):</strong> Ranging from total blindness to partial sight.</li><li data-list-item-id=\"e6a15d7a6aeea6e7f47226d2874f25c75\"><strong>Intellectual Impairment (Class 14):</strong> For athletes with restrictions in intellectual functioning and adaptive behavior.</li></ul><h4>2. Understanding Sport Class Prefixes</h4><p>Swimming classes are identified by a prefix that indicates the stroke:</p><ul><li data-list-item-id=\"e9a9a37e0c07f71b0bb8c3b481a437b70\"><strong>S:</strong> Freestyle, Butterfly, and Backstroke.</li><li data-list-item-id=\"e280fb3bf4fddb79600b221fdc73c2f14\"><strong>SB:</strong> Breaststroke.</li><li data-list-item-id=\"e2afcb243b3d7003637bd17b79a798f4d\"><strong>SM:</strong> Individual Medley (calculated based on the S and SB classes).</li></ul><h4>Physical Impairment (S1–S10 / SB1–SB9)</h4><p>The lower the number, the more severe the activity limitation.</p><ul><li data-list-item-id=\"e4fd17eab1ecb73b11ba1e268397943d0\"><strong>S1/SB1:</strong> Swimmers with significant loss of muscle power or control in all four limbs and trunk.</li><li data-list-item-id=\"e00a94ef5763c650380521c3096a84985\"><strong>S10/SB9:</strong> Swimmers with minimal eligible physical impairments, such as the loss of a hand or a limited hip joint.</li></ul><h4>Vision Impairment (S11–S13)</h4><ul><li data-list-item-id=\"e2b2c2086168e2b3703771cfc07578be9\"><strong>S11:</strong> Athletes with very low visual acuity or no light perception. <strong>Requirement:</strong> Must wear <strong>blackened goggles</strong> and use a <strong>tapper</strong> (support staff who signals when the swimmer is approaching the wall).</li><li data-list-item-id=\"e5927bf24e9f37ececd5957164c26c3ab\"><strong>S12:</strong> Higher visual acuity than S11; tappers are optional.</li><li data-list-item-id=\"e6f7a9bd77321fafe22c0f85f921f4ef9\"><strong>S13:</strong> Least severe vision impairment; tappers are optional.</li></ul><h4>Intellectual Impairment (S14)</h4><ul><li data-list-item-id=\"e56b3e4fb515c7dc5ebaa23ef37983cc8\"><strong>S14:</strong> Athletes who have difficulties with pattern recognition, sequencing, and memory, which impacts their reaction time and stroke efficiency.</li></ul><h4>3. The Evaluation Process</h4><p>To receive a classification, Bangladeshi athletes must undergo a three-part evaluation:</p><ol><li data-list-item-id=\"e8669ab3f708b63a9a5f3165bcd2311d4\"><strong>Bench Test:</strong> A medical classifier assesses muscle strength, joint range, or limb length.</li><li data-list-item-id=\"e02d04880f718b0665bb76d7843b490ac\"><strong>Water Test:</strong> A technical classifier observes the athlete performing strokes and turns in the pool.</li><li data-list-item-id=\"eddebb87545cc0806cc7ba6cf18b18309\"><strong>Competition Observation:</strong> Classifiers watch the athlete during an actual race to confirm the class is accurate under \"race conditions.\"</li></ol><h4>4. Required Documents for Bangladeshi Athletes</h4><p>Before attending an international or national classification session, athletes must submit the following via NPC Bangladesh:</p><ul><li data-list-item-id=\"e4e3f529bc69d2154a6b22a4efaadbab5\"><strong>Medical Diagnostics Form (MDF):</strong> Must be filled out by a specialized doctor (Ophthalmologist for VI, Neurologist/Orthopedist for PI).</li><li data-list-item-id=\"e1083eb9254c2ad93037dbd812e3a8606\"><strong>Consent Form:</strong> Signed by the athlete (and parent/guardian if under 18).</li><li data-list-item-id=\"e719adc9e4ee89f7b5c0589059ff55480\"><strong>Supporting Evidence:</strong> Hospital records, X-rays, or MRI results.</li><li data-list-item-id=\"ef3154a40ff4fc7fa1f664b7a9e53de34\"><strong>VIRTUS Number (for S14):</strong> Proof of registration on the VIRTUS International Eligibility Master List.</li></ul><p>&nbsp;</p><p><a href=\"https://www.paralympic.org/sites/default/files/2024-08/2022%20World%20Para%20Swimming%20Classification%20Rules%20and%20Regulations_FINAL.pdf\">World Para Swimming Rules and Regulations August 2022</a></p>', NULL, NULL, NULL, 'posts/42/images/f-image/f_image_69694ab77ea2e.png', NULL, 'Para Swimming Classification', '2026-01-15 20:14:46', '1', 1, 1, '2026-01-15 14:14:46', '2026-01-15 14:14:47'),
(43, 'Wheelchair Basketball Classification', 'wheelchair-basketball-classification', 'The Points System Explained', '<p>At the National Paralympic Committee (NPC) of Bangladesh, we follow the <strong>International Wheelchair Basketball Federation (IWBF) 2021 Rules</strong>. Classification in this sport is unique: it is not about how well you play, but your <strong>functional capacity</strong> to perform basketball skills—pushing, pivoting, shooting, and rebounding—while maintaining balance in your chair.</p><h4>1. The Two Pillars of Eligibility</h4><p>To compete internationally for Bangladesh, an athlete must meet two criteria:</p><ul><li data-list-item-id=\"e446321a24a89529a8058dbffdc532962\"><strong>Eligible Impairment:</strong> Must have an underlying health condition resulting in one of the following: Impaired Muscle Power, Impaired Range of Movement, Limb Deficiency, Leg Length Difference, Hypertonia, Ataxia, or Athetosis.</li><li data-list-item-id=\"e5515ecbfae4fb6fa9d3e5dfd61484ead\"><strong>Minimum Impairment Criteria (MIC):</strong> The impairment must be significant enough that it limits the athlete\'s ability to play \"stand-up\" basketball.</li></ul><h4>2. The 8 Sport Classes (1.0 – 4.5)</h4><p>Players are assigned a point value from <strong>1.0 to 4.5</strong>. These points represent a player’s <strong>\"Volume of Action\"</strong>—how far they can lean and move their trunk without losing balance.</p><figure class=\"table\"><table><thead><tr><th><p style=\"margin-left:0px;\"><strong>Point</strong></p></th><th><p style=\"margin-left:0px;\"><strong>Description of Movement</strong></p></th></tr></thead><tbody><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>1.0</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>No trunk control.</strong> Players cannot lean forward or sideways and usually have high backrests or straps for stability.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>2.0</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Partial trunk control.</strong> Can lean forward and rotate the upper body but cannot lean sideways.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>3.0</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Strong forward movement.</strong> Can lean fully forward and rotate but cannot lean to the sides without losing balance.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>4.0</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>Full movement with limitations.</strong> Can lean forward, rotate, and lean to <strong>one side</strong> comfortably.</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>4.5</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>No restriction.</strong> Can lean forward, rotate, and lean to <strong>both sides</strong> fully. (e.g., players with lower-leg amputations).</span></p></td></tr><tr><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\"><strong>0.5 increments</strong></span></p></td><td><p style=\"margin-left:0px;\"><span style=\"background-color:rgba(0,0,0,0);color:rgb(31,31,31);\">(1.5, 2.5, 3.5) These are used for athletes whose functional ability falls between the major classes.</span></p></td></tr></tbody></table></figure><h4>&nbsp;</h4><h4>3. The 14-Point Team Balance Rule</h4><p>This is the most important rule for coaches! To ensure a fair mix of players with different disability levels, the <strong>total points of the five players on the court cannot exceed 14.0.</strong></p><ul><li data-list-item-id=\"e3f4f119df78a8557713d0bfd3b762e44\">If a coach plays five \"4.5\" players, the total would be 22.5 (Illegal).</li><li data-list-item-id=\"e6da934d4e69bacb88af77d636e47f4c4\">A balanced lineup might include a 1.0, 2.0, 3.0, 3.5, and 4.5 (Total = 14.0).</li><li data-list-item-id=\"e2d97cfee01563d332a5ab018c53c1980\"><strong>Penalty:</strong> If a team exceeds 14 points, a technical foul is charged to the bench.</li></ul>', 'Wheelchair Basketball Classification', 'Wheelchair Basketball Classification', 'Wheelchair Basketball Classification', 'posts/43/images/f-image/f_image_69694e2368dc4.png', NULL, 'Wheelchair Basketball Classification', '2026-01-15 20:29:23', '1', 1, 1, '2026-01-15 14:29:23', '2026-01-15 14:29:23'),
(44, 'Physically Challenged Cricket', 'physically-challenged-cricket', 'Physically Challenged Cricket', '<p><span style=\"background-color:rgb(249,249,249);color:rgb(33,37,41);\">Physically Challenged Cricket</span></p>', 'Physically Challenged Cricket', 'Physically Challenged Cricket', 'Physically Challenged Cricket', 'posts/44/images/f-image/f_image_696cb657230f4.png', NULL, 'Physically Challenged Cricket', '2026-01-18 09:51:24', '1', 1, 1, '2026-01-18 03:51:24', '2026-01-18 04:30:47'),
(45, 'Amputee Football', 'amputee-football', 'Amputee Football', '<p><span style=\"background-color:rgb(249,249,249);color:rgb(33,37,41);\">Amputee Football</span></p>', NULL, NULL, NULL, 'posts/45/images/f-image/f_image_696cb753e0e2d.PNG', NULL, NULL, '2026-01-18 10:34:59', '1', 1, 1, '2026-01-18 04:34:59', '2026-01-18 04:34:59'),
(46, 'Wheelchair Tennis Classification', 'wheelchair-tennis-classification', 'Wheelchair Tennis Classification', '<p>Wheelchair Tennis Classification</p><p><span style=\"background-color:rgb(255,255,255);color:rgb(35,45,52);\">This sport class is designated for athletes, who have a significant and permanent impairment of one or both legs and normal arm function. This profile may match with athletes with paraplegia or leg amputations, for example.</span></p><p>&nbsp;</p><p style=\"margin-left:0px;\"><strong>Quad Class</strong></p><p style=\"margin-left:0px;\">Players in this class have an impairment affecting their playing arm as well as their legs. This limits their ability to handle the racket and to move in the wheelchair. You will find that players may use tape to securely grip the racket.</p><p style=\"margin-left:0px;\">&nbsp;</p><p style=\"margin-left:0px;\">Athletes with these impairments are eligible to compete in wheelchair tennis:</p><ul><li data-list-item-id=\"e3b5c02ac6cb762011291716a76ae9317\"><p style=\"margin-left:0px;\">•Impaired muscle power</p></li><li data-list-item-id=\"ea88e5a123e5bd9b1e5394fb319c1b0ee\"><p style=\"margin-left:0px;\">•Athetosis</p></li><li data-list-item-id=\"e57b1658316f2078129bfce065afe90e6\"><p style=\"margin-left:0px;\">•Impaired passive range of movement</p></li><li data-list-item-id=\"e7ef8e6ce5e5a53ae94eed389ac12918a\"><p style=\"margin-left:0px;\">•Hypertonia</p></li><li data-list-item-id=\"e11df69986d5ccacbc28d1041402c942c\"><p style=\"margin-left:0px;\">•Limb deficiency</p></li><li data-list-item-id=\"e5de32d1ce1b9eb90580ee5e25516bcf0\"><p style=\"margin-left:0px;\">•Ataxia</p></li><li data-list-item-id=\"ebac3a90add89a597d766bb119f96f8be\"><p style=\"margin-left:0px;\">•Leg length difference</p></li></ul>', 'Wheelchair Tennis Classification', 'Wheelchair Tennis Classification', 'Wheelchair Tennis Classification', 'posts/46/images/f-image/f_image_696d2a96b2c1e.png', NULL, NULL, '2026-01-18 18:46:46', '1', 1, 1, '2026-01-18 12:46:46', '2026-01-18 12:46:46'),
(47, 'Classification of Para Taekwondo', 'classification-of-para-taekwondo', 'Classification of Para Taekwondo', '<p><a href=\"https://www.worldtaekwondo.org/att_file_up/para/v16%20Guide%20WT%20Para%20classificaiton%20guide%20to%20icons%20and%20infographics.pdf\">PARA TAEKWONDO CLASSIFICATION GUIDE</a></p><p>&nbsp;</p>', 'Classification of Para Taekwondo', 'Classification of Para Taekwondo', 'Classification of Para Taekwondo', 'posts/47/images/f-image/f_image_696d2de25f50f.jpg', NULL, 'Classification of Para Taekwondo', '2026-01-18 18:59:28', '1', 1, 1, '2026-01-18 12:59:28', '2026-01-18 13:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=national, 1=international',
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `createdBy` bigint(20) UNSIGNED DEFAULT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `title`, `slug`, `description`, `file`, `type`, `status`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh Wins Three Golds and a Bronze at Asian Youth Para Games Dubai 2025', 'bangladesh-wins-three-golds-and-a-bronze-at-asian-youth-para-games-dubai-2025', '<p>Bangladesh delivered an outstanding performance at the Dubai 2025 Asian Youth Para Games, securing multiple medals across athletics, swimming, and team sports. Chaiti Rani Deb claimed two gold medals in Javelin Throw and the 100m sprint, marking a historic achievement for Bangladesh Para Athletics. Para swimmer Md. Shohidullah added to the medal tally with a gold medal in the 50m freestyle and a bronze medal in the 100m freestyle. In team events, the Bangladesh Women’s Wheelchair Basketball Team earned a bronze medal. These achievements highlight the athletes’ determination, discipline, and the growing strength of Bangladesh’s Paralympic movement on the international stage.</p>', 'results/1/result_file_69631b9b89344.jpeg', 1, '1', 1, 1, '2025-12-13 08:56:31', '2026-01-10 21:42:53'),
(6, 'Physically Challenged Cricket Tournament 2025', 'physically-challenged-cricket-tournament-2025', '<h3><strong>Meghna Team: The Undisputed Champions</strong></h3><p>The tournament reached its thrilling conclusion with the <strong>Meghna Team</strong> emerging as the <strong>Champions</strong>. Their victory is a testament to the skill, discipline, and \"Tiger spirit\" that defines Bangladesh cricket. We extend our heartfelt congratulations to the players of Meghna Team for their historic performance.</p>', 'results/6/result_file_6955c56737875.jpg', 0, '1', 1, 1, '2025-12-13 08:56:31', '2025-12-31 18:52:55'),
(7, 'New Delhi World Para Athletics Championship 2025', 'new-delhi-world-para-athletics-championship-2025', 'null', 'results/7/result_file_69623d3171c2a.pdf', 1, '1', 1, 1, '2026-01-10 05:51:13', '2026-01-22 02:12:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(2, 'admin', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(3, 'editor', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28'),
(4, 'viewer', 'user', '2025-12-13 08:56:28', '2025-12-13 08:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 4),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(11, 3),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(13, 1),
(13, 2),
(13, 3),
(14, 1),
(14, 2),
(14, 3),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(16, 3),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(18, 1),
(18, 2),
(18, 3),
(19, 1),
(19, 2),
(19, 3),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(21, 4),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(24, 1),
(24, 2),
(24, 3),
(25, 1),
(25, 2),
(25, 3),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(28, 1),
(28, 2),
(28, 3),
(29, 1),
(29, 2),
(29, 3),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(32, 1),
(32, 2),
(32, 3),
(33, 1),
(33, 2),
(33, 3),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(35, 3),
(36, 1),
(36, 2),
(36, 3),
(36, 4),
(37, 1),
(37, 2),
(37, 3),
(38, 1),
(38, 2),
(38, 3),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(40, 3),
(40, 4),
(41, 1),
(41, 2),
(41, 3),
(42, 1),
(42, 2),
(42, 3),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(44, 3),
(44, 4),
(45, 1),
(45, 2),
(45, 3),
(46, 1),
(46, 2),
(46, 3),
(47, 1),
(47, 2),
(48, 1),
(48, 2),
(49, 1),
(49, 2),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(52, 1),
(52, 2),
(52, 3),
(52, 4),
(53, 1),
(53, 2),
(53, 3),
(54, 1),
(54, 2),
(54, 3),
(55, 1),
(55, 2),
(56, 1),
(56, 2),
(56, 3),
(56, 4),
(57, 1),
(57, 2),
(57, 3),
(58, 1),
(58, 2),
(58, 3),
(59, 1),
(59, 2),
(59, 3),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(61, 3),
(61, 4),
(62, 1),
(62, 2),
(62, 3),
(63, 1),
(63, 2),
(63, 3),
(64, 1),
(64, 2),
(64, 3),
(65, 1),
(65, 2),
(66, 1),
(66, 2),
(67, 1),
(67, 2),
(68, 1),
(68, 2),
(69, 1),
(69, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `createdBy` bigint(20) UNSIGNED DEFAULT NULL,
  `updatedBy` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `data`, `created_at`, `updated_at`, `createdBy`, `updatedBy`) VALUES
(1, 'about_vision', '{\"title\":\"Vision\",\"content\":\"<p>To enable Para athletes in Bangladesh to achieve sporting excellence and inspire excite Bangladesh.<\\/p>\",\"home_content\":null,\"image\":\"sections\\/1\\/images\\/section_image_69674c8949c01.png\"}', '2025-12-13 08:56:32', '2026-01-14 01:58:01', NULL, 1),
(2, 'about_mission_vision', '{\"title\":\"Our mission and vision\",\"content\":\"<p class=\\\"content-text text-white opacity-75\\\">The mission &amp; vision of the National Paralympic Committee of Bangladesh (NPCB) is aligned with International Paralympic Committee\'s mission &amp; vision. NPCB promotes the Paralympic movement within the country, enabling Para athletes to achieve sporting excellence.<\\/p>\",\"image\":\"web\\/about\\/9FY9ERtc5zHbXIc67TxfqD5I3c43fqzq1NOcGfxj.jpg\",\"home_content\":\"<p class=\\\"content-text text-dark-emphasis\\\">\\n                        The mission & vision of the National Paralympic Committee of Bangladesh (NPCB) is aligned with\\n                        International Paralympic Committee\'s mission & vision. NPCB promotes the Paralympic movement\\n                        within the country, enabling Para athletes to achieve sporting excellence.\\n                    <\\/p>\"}', '2025-12-13 08:56:32', '2025-12-22 08:14:43', NULL, NULL),
(3, 'about_mission', '{\"title\":\"Mission\",\"content\":\"<p>To make for a more inclusive society for people with an impairment through Para Sports.<\\/p>\",\"home_content\":null,\"image\":\"web\\/about\\/Yt1zGcCMvaXHeci9heoRGEcUAsLoLp6wAaYdEo3R.png\"}', '2025-12-13 08:56:32', '2026-01-10 22:26:18', NULL, 1),
(4, 'history_history', '{\"title\":\"History\",\"image\":\"web\\/history\\/description.png\",\"content\":\" <p class=\\\"content-text text-white opacity-75\\\">The history of the National Paralympic Committee of Bangladesh (NPCB) was formed in 1981. Bangladesh\'s debut at the Summer Paralympics was in 2004, where it sent one athlete to compete in athletics. The NPCB was formally established in 2004 and became the official national organization for para-sports, affiliated with the International Paralympic Committee (IPC). The country has since participated in every Summer Paralympics, though it has yet to win a medal.<\\/p>\\n                    <ul class=\\\" ps-3 text-white opacity-75 content-tex\\\">\\n                        <li class=\\\" t mb-4\\\"><strong>2004: <\\/strong>Bangladesh makes its first appearance at the 2004 Athens Summer Paralympics, sending a single athlete to compete in the men\'s 400m T46 event.<\\/li>\\n\\n                        <li class=\\\"mb-4\\\"><strong>2004: <\\/strong>The National Paralympic Committee of Bangladesh is officially established.<\\/li>\\n                        \\n                        <li class=\\\"mb-4\\\"><strong>2008: <\\/strong>Abdul Quader Suman represents Bangladesh at the Beijing Paralympics, competing in the men\'s 100m T12.<\\/li>\\n\\n                        <li class=\\\"mb-4\\\"><strong>2012-2024: <\\/strong>Bangladesh continues its participation in the Summer Paralympics.<\\/li>\\n\\n                        <li class=\\\"mb-4\\\"><strong>2022: <\\/strong> NPCB is granted provisional membership status by the International Paralympic Committee (IPC)..<\\/li>\\n                        <li class=\\\"mb-4\\\"><strong>Present: <\\/strong> The organization continues its work as a para-athlete-centered, non-profit national organization based in Dhaka.<\\/li>\\n                <\\/ul>\"}', '2025-12-13 08:56:32', '2025-12-13 08:56:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0caNWwiiSxnRxAPJz2q7ZPu0ibiRi9vnrFCXcFWM', NULL, '47.128.118.21', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWdjNjlSTDI1REh3RkZ2MkhDZTBZUUNMcDM4NlRKdkF0aUlNdnlrTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTIxOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvMTYvZGV0YWlscy8vMjk5L2tuWTFZVkhuczRBWUpBdkdMeTAwS2ZYNDBMMGhEZ0ltbjc4bzBJNXEuanBnIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770089898),
('1SIJKd2JaZRYI81CmkwzrnG9Aah4Qn0b6PlNBWyX', NULL, '170.106.161.78', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieVY5TGVPZTdJYjR5UTgzczR6WGU2Z2hCdnl0NWlWN3FjV2VMSkdzZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9wb3N0LWNhdGVnb3JpZXMvd2hlZWxjaGFpci10ZW5uaXMiO3M6NToicm91dGUiO3M6MTU6InBvc3QtY2F0ZWdvcmllcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770089012),
('2OhW8RDnC5VjiC8oKBIoKpLLWTYfncBBCPnOZAnm', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0w2R2NFZTc1TGU2eUJ1TjdybGlVN1RNMGFrcDA2UnJ3WEpCTTV3NSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9nYWxsZXJ5LWRldGFpbHMvMSI7czo1OiJyb3V0ZSI7czoxNToiZ2FsbGVyeS1kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080630),
('3VZhgg9V4cmJoJvz4oDn9puhGEufEH5C95AJVYBO', NULL, '47.128.125.140', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2RKSFVSWWxTTkRCWjBjdHZGYUcyMkRoREtqY3E0Q09ncWMwRkZVVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODA6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9wbGF5ZXJzL2podW1hLWFraHRlci1wYXJhLWFyY2hlcnktd29tZW4tcGFyYS1hcmNoZXJ5LTIwIjtzOjU6InJvdXRlIjtzOjE0OiJwbGF5ZXIuZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770094500),
('4gMIbYDoExVFJNC6Qluqc6j51ehifLe92FEu6OQZ', NULL, '54.39.0.154', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjlHNTcxM3RTV0Y4QXVwUWpMbktDSERvWjdiQWQ4Z0JKVW0wektzaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODU6Imh0dHBzOi8vbnBjYmFuZ2xhZGVzaC5vcmcvZXZlbnRzL2JjYm5wYy1waHlzaWNhbGx5LWNoYWxsZW5nZWQtY3JpY2tldC10b3VybmFtZW50LTIwMjUiO3M6NToicm91dGUiO3M6MTM6ImV2ZW50LWRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770097013),
('53b4PnRVZXKXFIFeqQiX9M6WC54G6bqmT1PidNpg', NULL, '15.235.27.145', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkFBN25xMXA0alZSMzV5T09TSlNtam5YVWRaU0JLbmx6dEQ4b0lZeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzI6Imh0dHBzOi8vbnBjYmFuZ2xhZGVzaC5vcmcvZXZlbnRzL25hdGlvbmFsLWFtcHV0ZWUtZm9vdGJhbGwtY2Fybml2YWwtMjAyNSI7czo1OiJyb3V0ZSI7czoxMzoiZXZlbnQtZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770095046),
('7dL5BAWlFk4AGRWxSWWMr64V3SUfg2uE1l3v5pzf', NULL, '47.128.118.21', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVpoZlQwM0tEbno0WFdCTkluemI4TkZTRHR5bjJaeDlORDh1ZGpnaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTIxOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvMTYvZGV0YWlscy8vMjk4L0F0SFM1WVN1b2V2dDFVQW9KdkZ1OWd2VDk3UTFNTlp1aVN6TlRJaW0uanBnIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770089898),
('7fWN3GL7HhnZhxNgjP9lJ6nUvegfhc5vFaRVAjlw', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiblA4ejYwTmc4YXlVQ2FLdFRxeGdXZnB4RUIyVU1iSGVxU2ZBQXo1QSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy9xNmZiQXY4akphQ053RXVRSzRLWllsbzBmZ1R3R01kTUpOMnJyYkdRLmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080632),
('9NJObAuyqbtjDqomOUwQAUzy9lIZTOtSql7BGLL8', NULL, '52.167.144.147', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVNpcWdJZklnUmxTSEJNVjl0Uk1SZ21UQkNqOHo3TWxnVUkyY1FmYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vd3d3Lm5wY2JhbmdsYWRlc2gub3JnL3Bvc3QtY2F0ZWdvcmllcy9hdGhsZXRpY3MiO3M6NToicm91dGUiO3M6MTU6InBvc3QtY2F0ZWdvcmllcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770082295),
('bG74aAK5CrIjsTTuUfEwMwz7v3mhmfR0CxLTj2lM', NULL, '43.131.39.179', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3dRUGllckp0dTMxREQySU0wM3dUbUJpU01zNXBDaEFtNGZvWjhQQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9wYWdlcy9uYXRpb25hbC1ub24tc3BvcnRzLWV2ZW50cy1nYWxsZXJ5IjtzOjU6InJvdXRlIjtzOjEyOiJwYWdlLmRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770089574),
('cI0LnnqxSQnomSK9SkIDVg7iMuGj8TrKZuQ2W3Ok', NULL, '69.171.230.10', 'meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHoxMnpKcEs1c1pOVlRDc1NpZDdPcVg1VzBHOTVkbjRScEFnU05mMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjY6Imh0dHBzOi8vd3d3Lm5wY2JhbmdsYWRlc2gub3JnL3Nwb3J0cy9waHlzaWNhbGx5LWNoYWxsZW5nZWQtY3JpY2tldCI7czo1OiJyb3V0ZSI7czoxNDoic3BvcnRzLWRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770086134),
('Cpzm2QTQm8WjwkGpAbBsbebsMCexXMquee3TomYt', NULL, '47.128.123.153', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVlRoZ3F2cElTYzBCaW1xbDcwS1VUZFk0VGhtZ3FZUTZsb2hNRXQyMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODA6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9ldmVudHMvd29ybGQtcGFyYS1hdGhsZXRpY3MtY2hhbXBpb25zaGlwLW5ldy1kZWxoaS0yMDI1IjtzOjU6InJvdXRlIjtzOjEzOiJldmVudC1kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770092717),
('D5YMj7sExxiGALyMnXnGPZ9HKdCsULgSM2NB1dBu', NULL, '47.128.125.140', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0ZrcDluMlVqQUNSamI3QXVLcG1QZm1kUDR4Q1RzMHFJZFhYdHNQciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA1OiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzI2Mi8yMjUvd2VicC9zdG9yYWdlL3BsYXllcnMvd2ZRMGV0RmFyU3RGZklvNkhXYnpQejJXTXJTdWlIdE1VRnVIRkF3bC5wbmciO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770094502),
('dNyUwMOSX6m2Yjg6seNGpBtCFhwAZ5njYdT1htiV', NULL, '192.36.109.96', 'Mozilla/5.0 (Linux; U; Android 13; sk-sk; Xiaomi 11T Pro Build/TKQ1.220829.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.4.0-g', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzVNc2w0aVFpVlRvNWd3SEI0Q1F2T2U4enY4YXcyMm9IdDhqVXNMMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZyI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770083957),
('EFBWKstX0NGoBo0FeaYefUVqXzlOiYevBPkbOGML', NULL, '49.51.183.220', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTk1GMkxwOVoxbFFoOUgycjJjNzlMYVNNUnVyOXRHejN0eEwyRDJxYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzI2Mi8yMzAvd2VicC9zdG9yYWdlL3Bvc3RzLzIzL2ltYWdlcy9mLWltYWdlL2ZfaW1hZ2VfNjk1NTk3ZWJjMzkzZC5qZmlmIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770093769),
('EIhfEgVrrIqm4DqNXptYeOIBKQjUs9pbna2PGrHE', NULL, '103.153.174.43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUx3cXpldlVXVzl4ZmRjTGNZNXVqZTlyeVJxOVZnRE5jR0RmcG44SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vbnBjYmFuZ2xhZGVzaC5vcmciO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770099388),
('FptCufgR7AcqKomVvuyY7MWJnEawEh0v1NSThRJ1', NULL, '192.36.109.89', 'Mozilla/5.0 (Linux; U; Android 13; sk-sk; Xiaomi 11T Pro Build/TKQ1.220829.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.4.0-g', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOEQ2SWxYS1Bhd1AyTlVEb1VtREFIOEY4SGxlcnFzSUlLSjYxQUJpYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzk1OiJodHRwOi8vbnBjYmFuZ2xhZGVzaC5vcmcvbmV3cy1hbmQtdXBkYXRlcy8lRTAlQTYlOEYlRTAlQTYlQjYlRTAlQTYlQkYlRTAlQTYlQUYlRTAlQTYlQkMlRTAlQTYlQkUlRTAlQTYlQTgtJUUwJUE2JTg3JUUwJUE2JUFGJUUwJUE2JUJDJUUwJUE3JTgxJUUwJUE2JUE1LSVFMCVBNiVBQSVFMCVBNyU4RCVFMCVBNiVBRiVFMCVBNiVCRSVFMCVBNiVCMCVFMCVBNiVCRS0lRTAlQTYlOTclRTAlQTclODclRTAlQTYlQUUlRTAlQTYlQjglRTAlQTclODctJUUwJUE2JUFDJUUwJUE2JUJFJUUwJUE2JTgyJUUwJUE2JUIyJUUwJUE2JUJFJUUwJUE2JUE2JUUwJUE3JTg3JUUwJUE2JUI2JUUwJUE3JTg3JUUwJUE2JUIwLSVFMCVBNiVCOCVFMCVBNiVCRSVFMCVBNiVBQiVFMCVBNiVCMiVFMCVBNyU4RCVFMCVBNiVBRjotJUUwJUE3JUFCLSVFMCVBNiVBQSVFMCVBNiVBNiVFMCVBNiU5NS0lRTAlQTYlOUMlRTAlQTYlQUYlRTAlQTYlQkMlRTAlQTclODAtJUUwJUE2JUE2JUUwJUE2JUIyJUUwJUE2JTk1JUUwJUE3JTg3LSVFMCVBNiVCMCVFMCVBNiVCRSVFMCVBNiVCNyVFMCVBNyU4RCVFMCVBNiU5RiVFMCVBNyU4RCVFMCVBNiVCMCVFMCVBNiVBNiVFMCVBNyU4MiVFMCVBNiVBNC0lRTAlQTYlOTMtJUUwJUE2JTk1JUUwJUE2JUE4JUUwJUE2JUI4JUUwJUE2JUJFJUUwJUE2JUIyLSVFMCVBNiU5QyVFMCVBNyU4NyVFMCVBNiVBOCVFMCVBNiVCRSVFMCVBNiVCMCVFMCVBNyU4NyVFMCVBNiVCMi0lRTAlQTYlQjYlRTAlQTclODElRTAlQTYlQUQlRTAlQTclODclRTAlQTYlOUElRTAlQTclOEQlRTAlQTYlOUIlRTAlQTYlQkUiO3M6NToicm91dGUiO3M6MjQ6Im5ld3MtYW5kLXVwZGF0ZXMtZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770083958),
('fv6TnADtgngFtsK7dlgoUcajNRZTaMa8Q0rOnmCe', NULL, '47.128.118.21', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHR5WnN6ZDJmZTVsS3RRNjlVdVhKVmtvOFQ3dFNmT3Brd3RUYThYViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTIxOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvMTYvZGV0YWlscy8vMzcyL0plSGlwdzA2V2dweTdJSkViUWUxdW9HSDExYmVJQzZES3E2ZTNEeWouanBnIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770089898),
('G3qVCsyOYbIm9wE8kwvHZiwdC4jVNZ3mZAePh8vx', NULL, '170.106.179.68', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidG5BVUtRNkl4ZVpUbkpiemk1Zm5DVVhOTzRVbk9VaUR2cWpCRUx3VCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZyI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770083951),
('GD79vk4vxe0Y3gDdTP9PT3puCdi0zXviaVlRPYqi', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVRNMUVlcllwaUdwQnkzWWxlNlFWYWd0N3ZxeHpDTnVoanFQVzR5UyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy8yNldBYnZZbDBkNkhrMjF4bkRTRTQxSWc2S1BvOThHYXpJNVlYQllFLmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080633),
('GiKLlXs8mvutSUEysqlAgu6cO7gHaBBZsUDY6Les', NULL, '47.128.118.21', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2RCSmk2NHROZUJnZHRrWDI5SlJ6T2FMQnU0aGxPS1JXR3g0QWpTOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTIxOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvMTYvZGV0YWlscy8vMzAwL2NlRW5XbDk4Z1g4aE1ua2IwdVMwbFBHYzBMdWNZaHI1TVZXOFNBYVAuanBnIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770089898),
('gtYyiSrdVgX27C2CE9V5lBGOwby00s83cFr11VDC', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0IzalpEeEZGSGtXQkVZOVBDamFFMHFUdUpXRWpBV3lBUTB1SVhNQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy9UY3kyT0hCdXRRRmRQSzRhY05LYm9MbVdDWFl5NmdCRVdaVEdZbzY1LmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080633),
('hdFRYD9ecLypcybCQfwA7SDHmFu0PHdmztBGh3po', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXU3TnFkRzk2WW1HZHJObWdMbmlPaDhtVkM3YzhZZWpwMWVacmJQbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy91RXdGZnRqeGxNQlZmYVpUQzFvcUJ0cTlicjVEZTlXdGNBeWc0TmZVLmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080632),
('jgcyMLDTYnMNcx6ff6m4xwDnax799nxZyhm1nPfS', NULL, '192.36.109.129', 'Mozilla/5.0 (Linux; U; Android 13; sk-sk; Xiaomi 11T Pro Build/TKQ1.220829.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.4.0-g', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWswRGU1Wm1lS0prTGNZZzZSV0FtT3k2VDRCVFVYRjY5dTlWRUM1QyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjgzOiJodHRwOi8vbnBjYmFuZ2xhZGVzaC5vcmcvbmV3cy1hbmQtdXBkYXRlcy8lRTAlQTYlQUMlRTAlQTYlQkUlRTAlQTYlODIlRTAlQTYlQjIlRTAlQTYlQkUlRTAlQTYlQTYlRTAlQTclODclRTAlQTYlQjYlRTAlQTYlQkYtJUUwJUE2JTg1JUUwJUE3JThEJUUwJUE2JUFGJUUwJUE2JUJFJUUwJUE2JUE1JUUwJUE2JUIyJUUwJUE3JTg3JUUwJUE2JTlGLSVFMCVBNiU5QSVFMCVBNyU4OCVFMCVBNiVBNCVFMCVBNiVCRi0lRTAlQTYlQjAlRTAlQTYlQkUlRTAlQTYlQTMlRTAlQTclODAtJUUwJUE2JUE2JUUwJUE3JTg3JUUwJUE2JUFDLSVFMCVBNiVBNiVFMCVBNyU4MSVFMCVBNiVBQyVFMCVBNiVCRSVFMCVBNiU4Ny0lRTAlQTYlOEYlRTAlQTYlQjYlRTAlQTYlQkYlRTAlQTYlQUYlRTAlQTYlQkMlRTAlQTYlQkUlRTAlQTYlQTgtJUUwJUE2JTg3JUUwJUE2JUFGJUUwJUE2JUJDJUUwJUE3JTgxJUUwJUE2JUE1LSVFMCVBNiVBQSVFMCVBNyU4RCVFMCVBNiVBRiVFMCVBNiVCRSVFMCVBNiVCMCVFMCVBNiVCRS0lRTAlQTYlOTclRTAlQTclODclRTAlQTYlQUUlRTAlQTYlQjglRTAlQTclODctJUUwJUE2JUI4JUUwJUE3JThEJUUwJUE2JUFDJUUwJUE2JUIwJUUwJUE3JThEJUUwJUE2JUEzJUUwJUE2JUFBJUUwJUE2JUE2JUUwJUE2JTk1LSVFMCVBNiU4NSVFMCVBNiVCMCVFMCVBNyU4RCVFMCVBNiU5QyVFMCVBNiVBOCI7czo1OiJyb3V0ZSI7czoyNDoibmV3cy1hbmQtdXBkYXRlcy1kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770083959),
('Jh8yQlKdoMq5UwlnSuIlr16x19n7woLXWnu1sfcW', NULL, '43.166.224.244', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZkNraFpNa1pCMG1IeEhFeWJ0RFFiZ2xNWlN3MWdhdnNBbTFBWE1ScCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9nYWxsZXJ5LWRldGFpbHMvMjMiO3M6NToicm91dGUiO3M6MTU6ImdhbGxlcnktZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770092615),
('JRMwdC0UdiYqW2x0GF2auO5ALbXmFnZGd5NKPTA6', NULL, '40.77.167.58', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTGFkWFIxWHVJejVMcWN2RTRIalBKUmNmVmxlR2VxY3BLZFRLRWVERSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzg6Imh0dHBzOi8vd3d3Lm5wY2JhbmdsYWRlc2gub3JnL2V4ZWN1dGl2ZS1jb21taXR0ZWUvZHIuLW1vaGFtbWFkLXNvaHJhYi1tZW1iZXItMSI7czo1OiJyb3V0ZSI7czoyNToiY29tbWl0dGVlLW1lbWJlcnMtZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770090708),
('k5u60OwQuCj8r2YIXegD8RDR0P1pnStrcv2oTw33', NULL, '47.128.118.21', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXVTMDBaQjhUbXZjTURaSExjZkJHRlJFNDhPUjFrMm9uanFZeWtFTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTIxOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvMTYvZGV0YWlscy8vMjk3L2k5UU13Ynp0NXJhZGhmWjFCUEhvbXU4RVdFZUY0MDNqSHdGR0VyaWkuanBnIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770089898),
('L30oQUyl1AvuFnGCIcfXEyMyOB3bme1P6DSZIWIG', NULL, '40.77.167.13', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1dPUHIwWnoxRTU1eHZjc0VMZGNLOFhjUkRwTFlFVjJSWFE1Q3FCRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vd3d3Lm5wY2JhbmdsYWRlc2gub3JnL3Nwb3J0cy9wYXJhLXN3aW1taW5nIjtzOjU6InJvdXRlIjtzOjE0OiJzcG9ydHMtZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770083116),
('L50r3CjiGUENJ2LrHnn6UzLcn7jUqBLhD9xuMw9s', NULL, '47.128.31.7', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnd1dmx4VmgzMGZndlRiQVN4bXRPOXNJTVU5MDZZdG1HUklmeWs2VyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9zcG9ydHMvcGFyYS1zd2ltbWluZyI7czo1OiJyb3V0ZSI7czoxNDoic3BvcnRzLWRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770084328),
('l7FAPSxNVjrzeWYwWCi152wOxbFbPjlMuJZbDTAi', NULL, '146.190.171.73', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia2lxTVdDdnJIdDlxdUlJOWM4dGw3OFZNWUpDcWl5SUJwOGpTbzJvaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vd3d3Lm5wY2JhbmdsYWRlc2gub3JnIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770096542),
('lgjijsDrydRyygU1pGeVz6vJSrWc9gAxmbJqPj4W', NULL, '213.176.16.157', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0pJY2hLbDhzamVaN3FENDNqNU1uZE8xbURZakJDQUxySTBZZkRUQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vbnBjYmFuZ2xhZGVzaC5vcmcvYWRtaW4vaW5kZXgucGhwIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770080068),
('LR2KTdSaluhNpNiQqR0DJrxh2UpUq8QJYBUbMZz7', NULL, '40.77.167.123', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0pXUmNLNWdvZlRhZ083SjJ3cGZOSTZrbDBLOExQOXZWamprWXNIYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHBzOi8vd3d3Lm5wY2JhbmdsYWRlc2gub3JnL3Bvc3QtY2F0ZWdvcmllcy9wYXJhLXRhZWt3b25kbyI7czo1OiJyb3V0ZSI7czoxNToicG9zdC1jYXRlZ29yaWVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770095744),
('lrU30hUS0WrYc1A7jLHvw5SQqU8jL0uvo2oLs51h', NULL, '43.157.38.131', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieDhQNGIwejcxc21va09vTHprQkg0SjVHWVU1amFzYkw5VDg4U09JOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODY6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9ldmVudHMvcGh5c2ljYWxseS1jaGFsbGVuZ2VkLWNyaWNrZXQtdHJpYWwtYW5kLXNlbGVjdGlvbi1jYW1wIjtzOjU6InJvdXRlIjtzOjEzOiJldmVudC1kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770087748),
('MBu2FSarXNIDWpWqUHVX8TNqvJzqWXTTjV27ggIf', NULL, '43.135.36.201', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnhqMklFd3NPZ2RCZGRzYnhLYXBNaFd6UHhHMkZmcVQ5ZmRoNkdsZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTA6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9uZXdzLWFuZC11cGRhdGVzL25hdGlvbmFsLXlvdXRoLXBhcmEtZ2FtZXMtMjAyNS1raWNrLW9mZi1pbi1kaGFrYSI7czo1OiJyb3V0ZSI7czoyNDoibmV3cy1hbmQtdXBkYXRlcy1kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770086533),
('mqS6oJS0HlDXaeH2fcZnY7KNGqvcrExx4BGhDM0V', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFhYb05NR0xxTkxuUUNwQnUxWnVKcFMyZmV6eVdJRXRKMGduaG5CUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy9uZ3RSVFJSMEhjanZ2THhMMGFRUE9GYTBCQ0o4Z2JyMHo0bUVwVEVCLmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080633),
('ndXyGIHTxCZXmYgBAHsXnqrggCOs3Gf7jw90r4Wv', NULL, '43.152.72.244', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibVl2dm9FMVZnVU9odFRkMHpkaEpPaUpLVHdKUldNVkIzMlFPUzdxMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmcvYmxvZ3MiO3M6NToicm91dGUiO3M6NToiYmxvZ3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770097414),
('njPyJcOBzXZiXjp86ioa118jkF5621GEVj0R42zi', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicE83bjFiSm1XQm9QTFRZZk50andFM1JqMFhIcHZRcVBFNm81VFFjMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy9FcFVvZkduWTVyVGFPdjlES0JpNHZPUDFkTHg3QlA4WE9VWWk4RXFCLmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080632),
('nusOEPNWXemMAKchSjgSrwkxeRllRIYH4IOJJRJS', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGNvNmJqR3pVUndzbGZQOGVOc0s1Y01McHplTno0aHpFME4xWmlkZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy9QWFRxOEZVamwxaElYWVVmelJzQlR2QlVlMUVybUE2NjQyYk5WUGZTLmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080633),
('nXsgiGtdQoaFvCjYvDI5eknarSe89ONixhh1Sv5w', NULL, '47.128.31.7', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWDZmU245d2l5bWc4SFlUVWJ0T3ZMNTNiV0w2U3NwRmg5Nk1RQlhHRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vbnBjYmFuZ2xhZGVzaC5vcmcvaW1hZ2UvMTE0MC8zNzUvd2VicC9zdG9yYWdlL3Bvc3RzLzIzL2ltYWdlcy9pbWFnZS9pbWFnZV82OTU1OTdlYmMyY2Y2LmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770084330),
('ohXy5ly5ULds9gM8n8q9YSEDceUerEgZuiSksQ7r', NULL, '47.128.118.21', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWl3WGNON0hMWm1pOVBXbTJsT3E5VjRldHBBRGQ2VFN2Tk92ekFyOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9nYWxsZXJ5LWRldGFpbHMvMTYiO3M6NToicm91dGUiO3M6MTU6ImdhbGxlcnktZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770089894),
('OQ6wX3T9SdpVH2Os44UGLIrWDai5oBf2yGLLePP2', NULL, '43.157.38.228', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXZVdzdyVkd3b1M2eVEzRHFOaFpUTTZ5ZmFnRFM5cTVJOVVRT3M0WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9wb3N0LWNhdGVnb3JpZXMvd2hlZWxjaGFpci1iYXNrZXRiYWxsIjtzOjU6InJvdXRlIjtzOjE1OiJwb3N0LWNhdGVnb3JpZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770088323),
('OqbLoFdTBVQbYj8Fgn7LonLp8KQQokqIaUYUA4bz', NULL, '43.156.156.96', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUTMzN0dpbVdiaU9ITG92MzZvcDRPVDFPUU13NE53Mjl2WEFYcERpSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9wb3N0LWNhdGVnb3JpZXMvc3dpbW1pbmciO3M6NToicm91dGUiO3M6MTU6InBvc3QtY2F0ZWdvcmllcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770090129),
('pxMQ2EtxsZaXxyKkitbGqjvd5PjCJ98wsYct6tym', NULL, '54.39.6.146', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEdqWktWSHVCVk5raUoxS3ZWSDlnc3pabWY0ZXdRZnJLS2xoeTdoOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vbnBjYmFuZ2xhZGVzaC5vcmcvZXZlbnRzL3BoeXNpY2FsbHktY2hhbGxlbmdlZC1jcmlja2V0LXRyaWFsLWFuZC1zZWxlY3Rpb24tY2FtcCI7czo1OiJyb3V0ZSI7czoxMzoiZXZlbnQtZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770092979),
('QSFGLo4A43lQsHNjDtdbyJIUBDYenmrHNQFl8p8S', NULL, '192.36.109.123', 'Mozilla/5.0 (Linux; U; Android 13; sk-sk; Xiaomi 11T Pro Build/TKQ1.220829.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/14.4.0-g', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia05jb3FpeXhFRkg1VExUTmc3VTlvSzB2REdHakRMeFVObG9CWHI1TCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjIzOiJodHRwOi8vbnBjYmFuZ2xhZGVzaC5vcmcvYmxvZ3MvJUUwJUE2JTg1JUUwJUE2JUE2JUUwJUE2JUFFJUUwJUE3JThEJUUwJUE2JUFGJTIwJUUwJUE2JUI4JUUwJUE2JUJFJUUwJUE2JUI5JUUwJUE2JUI4JUUwJUE3JTg3JUUwJUE2JUIwJTIwJUUwJUE2JUFBJUUwJUE2JUJFJUUwJUE2JUI2JUUwJUE3JTg3JTIwJUUwJUE2JUFFJUUwJUE3JTgxJUUwJUE2JUI2JUUwJUE2JUFCJUUwJUE2JUJGJUUwJUE2JTk1OiUyMCVFMCVBNiVBQiVFMCVBNiVCRiVFMCVBNiU5QyVFMCVBNiVCRiVFMCVBNiU5NSVFMCVBNyU4RCVFMCVBNiVBRiVFMCVBNiVCRSVFMCVBNiVCMiUyMCVFMCVBNiU5QSVFMCVBNyU4RCVFMCVBNiVBRiVFMCVBNiVCRSVFMCVBNiVCMiVFMCVBNyU4NyVFMCVBNiU5RSVFMCVBNyU4RCVFMCVBNiU5QyVFMCVBNiVBMSUyMCVFMCVBNiU5NSVFMCVBNyU4RCVFMCVBNiVCMCVFMCVBNiVCRiVFMCVBNiU5NSVFMCVBNyU4NyVFMCVBNiU5RiVFMCVBNiVCRSVFMCVBNiVCMCVFMCVBNiVBNiVFMCVBNyU4NyVFMCVBNiVCMCUyMCVFMCVBNiVCOCVFMCVBNyU4RCVFMCVBNiVBQyVFMCVBNiVBQSVFMCVBNyU4RCVFMCVBNiVBOCVFMCVBNyU4NyVFMCVBNiVCMCUyMCVFMCVBNiU5NSVFMCVBNiVBNSVFMCVBNiVCRSI7czo1OiJyb3V0ZSI7czoxMzoiYmxvZ3MtZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770083960),
('quQlnINBBuiTWm0X2BNVymJ0YZm6aNQbl3HLMXNC', NULL, '57.141.18.112', 'meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnZMZWdXSHlJZ2xBNk84TUhVaGY3bnZLeVdtTzFONGlhVTNMbzNJSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODE6Imh0dHBzOi8vbnBjYmFuZ2xhZGVzaC5vcmcvcGxheWVycy9qaHVtYS1ha2h0ZXItcGFyYS1hcmNoZXJ5LXdvbWVuLXBhcmEtYXJjaGVyeS0yMCI7czo1OiJyb3V0ZSI7czoxNDoicGxheWVyLmRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770091194),
('QXDLJKhpZ197nQ5aU4Om1xq0B6o92LBKuBpI3Nrg', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRjl3NEpCT25odnlnVUtKYVdRaWpxR2VHV21jamJ0b09qV3IyYkhBNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy9jWjNDU1l3VjF5cVI4S2FqZk00eUl5c0wyQXljOHRUU1pFZTN4ZU1MLmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080632),
('RitDJF8mqAmtaQ6wK6dyfxHZcKU6sGTHdPtmZSnm', NULL, '40.77.167.123', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXJ3TGF4aHZKWTBmTU9HWnQ2Rm9vQWtSVVpDZmx0eFNwZ1IxZUN2USI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vd3d3Lm5wY2JhbmdsYWRlc2gub3JnL3Bvc3QtY2F0ZWdvcmllcy9zd2ltbWluZyI7czo1OiJyb3V0ZSI7czoxNToicG9zdC1jYXRlZ29yaWVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770076848),
('RrbG0DudFynwjUnW5iiIUHKHWT4gBnvA3KOD0nEd', NULL, '69.171.230.36', 'meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaHdNT1NkZTlXNnFGMlcwdnNHME1BZVBkSXJ0a3RvbWQ1ZHY3NjhrMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmcvcG9zdC1jYXRlZ29yaWVzL2NyaWNrZXQiO3M6NToicm91dGUiO3M6MTU6InBvc3QtY2F0ZWdvcmllcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770086134),
('syLEgFUs7mhfcoiSiJVHR2xQOoAflN7iGSbgjrwN', NULL, '52.167.144.225', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEp0MXg4bWI0T2hTZFkxTFZaWHRFWFlrVHpVYm5NQjZxZXd1b0xqSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmcvcG9zdC1jYXRlZ29yaWVzL2dvYWxiYWxsIjtzOjU6InJvdXRlIjtzOjE1OiJwb3N0LWNhdGVnb3JpZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770097630),
('T5ljcIAZqxV0hD43xwESiGdBmBckMdcgxiaBAxQy', NULL, '43.135.186.135', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidXNoZFVzODZsZDN2M05NU3kyMGFkYUEyWElsbG9sTFNKOFA1TjZjdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTM6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmcvYmxvZ3MvdHJpYWwtc2VsZWN0aW9uLWNhbXAtcGh5c2ljYWxseS1jaGFsbGVuZ2VkLWNyaWNrZXRlcnMtMjAyNSI7czo1OiJyb3V0ZSI7czoxMzoiYmxvZ3MtZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770097948),
('TgCb1gpf10AZcD0Ea18US2opX0bwvaRJR14oPNU3', NULL, '146.190.171.73', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0pzQlp6cGcyOU5OUU45MGx2eW5xVDhuMThZTU5SM2VkdzlpVTVZUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmciO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770096541),
('TlvmjVh3yn8bv3jw2d85xwU0frUn8lsvEZCjxU06', NULL, '43.157.67.70', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWtWMjRnZUdlSlRqMUo0clMwaFpIT2k0OUJvQ2JPWldoY3htQmFidyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9nYWxsZXJ5LWRldGFpbHMvMTYiO3M6NToicm91dGUiO3M6MTU6ImdhbGxlcnktZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770093148),
('UjRwwia96iVmHaLwvL4gZtFM3JqMSgWgNjQTGtOD', NULL, '40.77.167.48', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRE9tOWF0MzNmMVEyTG04bEFEY0pHS2FpUkIybUlIdDhiT2lwV0lDZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmcvcG9zdC1jYXRlZ29yaWVzL3N3aW1taW5nIjtzOjU6InJvdXRlIjtzOjE1OiJwb3N0LWNhdGVnb3JpZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770086734),
('wdwVSdIkZ1FJ5YrB3Wm4EBcBJC6GY9Lsvwiit75K', NULL, '47.128.49.196', 'Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibmZnQmNjRVZpb1ZzWEpodzNRaUt6MUZId1F4dlF4Zzd4T0xxWElKMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTEzOiJodHRwczovL25wY2JhbmdsYWRlc2gub3JnL2ltYWdlLzQwMC8zMDAvd2VicC9zdG9yYWdlL2dhbGxlcnkvZGV0YWlscy9VeG9CWGN3OXlZYTRlc01JMTE4MDljYm9MMjZRQVg2ZGFTeWhvcVlPLmpwZyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080632),
('WJrG6HiMcbukcA1eTmi01KasUTWTzR3pT3QDOZ22', NULL, '43.163.206.70', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUktVYVphUkRQeDZuUXdUU1VXNVAxcDljR2xPaDhrVmtzN0J0TmR3byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njk6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmcvZXZlbnRzL2R1YmFpLTIwMjUtYXNpYW4teW91dGgtcGFyYS1nYW1lcyI7czo1OiJyb3V0ZSI7czoxMzoiZXZlbnQtZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770095520),
('x5VkEB0iHhqaZk8uZlfiBzo8O5FwZOSjotpuRRnU', NULL, '40.77.167.48', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmRRWU5UcENFYUxRNElwN3hrNXBxTUJXdVAzanZaajlZSkMyNHNkbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmcvcG9zdC1jYXRlZ29yaWVzL3BhcmEtdGFla3dvbmRvIjtzOjU6InJvdXRlIjtzOjE1OiJwb3N0LWNhdGVnb3JpZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770083419),
('XA4SswurH8iHHGBKSw6icT3Sn31euSupBE3L8Xsq', NULL, '110.166.71.39', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2VxdVJOeW9vVUtoeWpRV2kwZHlvR1JETml5WTZrMFNMaElsNU9ETSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZyI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770080772),
('XXpsSbHrHvh0HG0s7HDJNWRlFeQLHVfJ8n879lNp', NULL, '43.153.35.128', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVdLOWZnUzJ3WUEwbEVVSUVGZnRGNGU0cG9ySWRLcGhGMTQ3dUNsdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9wYWdlcy9zcG9uc29yc2hpcCI7czo1OiJyb3V0ZSI7czoxMjoicGFnZS5kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770090803),
('Ycf9Keo3RsMG2J2V7Aa5X1HdWupsi4W92WEGlwo3', NULL, '43.153.10.13', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWnhFbGpKYzhQQmdTS2V3cWxwSnZqeFB6TzlNZmV1SEFpZmVYT3VDaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly93d3cubnBjYmFuZ2xhZGVzaC5vcmciO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770094220),
('zaxc5HGh32mOdjuz70UsRi2awj8feLWfSmXwsMqX', NULL, '43.135.134.127', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkNmcFBjeWd1S2RYZjdmRm90SjhhZnc4UmIwSHlpanhxdzZidDJvUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9ucGNiYW5nbGFkZXNoLm9yZy9ydW5uaW5nLWV2ZW50cyI7czo1OiJyb3V0ZSI7czoxNDoicnVubmluZy1ldmVudHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770087160),
('zI6dCvClVVjBsr6petnD17xF3ek4D2I4Uo4MuV6B', NULL, '40.77.167.53', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2pHZ0VCS2JNcXl2cnJUbnRTcGZ5Z0NwelJTQ3luNnRsQm5CUXhNWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHBzOi8vd3d3Lm5wY2JhbmdsYWRlc2gub3JnL2V4ZWN1dGl2ZS1jb21taXR0ZWUvbWQuLWFzaWZ1bC1oYXNhbi1tYXN1ZC10cmVhc3VyZXIiO3M6NToicm91dGUiO3M6MjU6ImNvbW1pdHRlZS1tZW1iZXJzLWRldGFpbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770088815);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(155) NOT NULL,
  `title` varchar(155) NOT NULL,
  `value` varchar(155) NOT NULL,
  `createdBy` bigint(20) UNSIGNED NOT NULL,
  `updatedBy` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `label`, `title`, `value`, `createdBy`, `updatedBy`, `created_at`, `updated_at`) VALUES
(1, 'address', 'Address', 'National Sports Council \r\nOld Building, Room #202 (1st Floor)\r\n62/3 Purana Paltan, Dkaka-1000, Bangladesh', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(2, 'email', 'Email', 'info@npcbangladesh.org', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(3, 'phone', 'Phone', '+880 1336097353;  +880 1777-131517', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(4, 'state', 'State', '322', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(5, 'store_logo', 'Store Logo', 'settings/store_logo/store_logo_1768926805_696fae5511e6f.png', 1, 2, '2025-12-13 08:56:30', '2026-01-20 10:33:25'),
(6, 'store_icon', 'Store Icon', 'settings/store_icon/store_icon_1769319953_6975ae11d3804.png', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:45:53'),
(7, 'footer_logo', 'Footer Logo', 'settings/footer_logo/footer_logo_1768926805_696fae55845e1.png', 1, 2, '2025-12-13 08:56:30', '2026-01-20 10:33:25'),
(8, 'mail_protocol', 'Mail Protocol', 'smtp', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(9, 'mail_address', 'Mail Address', 'imranertaza12@gmail.com', 1, 1, '2025-12-13 08:56:30', '2026-01-26 23:47:02'),
(10, 'smtp_host', 'SMTP Host', 'npcbangladesh.org', 1, 1, '2025-12-13 08:56:30', '2026-01-26 23:23:20'),
(11, 'smtp_username', 'SMTP Username', 'contact@npcbangladesh.org', 1, 1, '2025-12-13 08:56:30', '2026-01-26 23:23:20'),
(12, 'smtp_password', 'SMTP Password', 'NWQJb5+RRv%8', 1, 1, '2025-12-13 08:56:30', '2026-01-26 23:45:05'),
(13, 'smtp_port', 'SMTP Port', '465', 1, 1, '2025-12-13 08:56:30', '2026-01-26 23:45:21'),
(14, 'smtp_timeout', 'SMTP Timeout', '300', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(15, 'smtp_crypto', 'SMTP Crypto', 'ssl', 1, 1, '2025-12-13 08:56:30', '2026-01-26 23:45:21'),
(16, 'fb_url', 'Facebook', 'https://www.facebook.com/BangladeshParalympic/', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(17, 'twitter_url', 'Twitter', 'https://twitter.com/npcb', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(18, 'linkedin_url', 'Linkedin', 'https://www.linkedin.com/company/npcbangladesh', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(19, 'instagram_url', 'Instagram', 'https://www.instagram.com/npcb', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(20, 'meta_title', 'Meta Title', 'National Paralympic Committee of Bangladesh', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(21, 'meta_keyword', 'Meta Keyword', 'NPCB, Paralympics, Bangladesh, Sports', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(22, 'meta_description', 'Meta Description', 'Official site of the National Paralympic Committee of Bangladesh (NPCB).', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(23, 'meta_author', 'Meta Author', 'NPCB Admin', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(24, 'meta_news_keywords', 'News Keywords', 'NPCB, Paralympics, Bangladesh, Sports, Athletes', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(25, 'og_type', 'OG Type', 'article', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(26, 'og_title', 'OG Title', 'NPCB Article', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(27, 'og_description', 'OG Description', 'Discover the latest updates from the National Paralympic Committee of Bangladesh.', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(28, 'og_image', 'OG Image', 'settings/og_image/og_image_1767534539_695a6fcbf108c.png', 1, 1, '2025-12-13 08:56:30', '2026-01-04 07:48:59'),
(29, 'og_image_width', 'OG Image Width', '1200', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(30, 'og_image_height', 'OG Image Height', '630', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(31, 'twitter_card', 'Twitter Card', 'summary_large_image', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(32, 'twitter_title', 'Twitter Title', 'NPCB', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(33, 'twitter_description', 'Twitter Description', 'Follow updates from the National Paralympic Committee of Bangladesh.', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(34, 'twitter_image', 'Twitter Image', 'settings/twitter_image/twitter_image_1767534539_695a6fcbf2fd3.png', 1, 1, '2025-12-13 08:56:30', '2026-01-04 07:48:59'),
(35, 'twitter_domain', 'Twitter Domain', 'https://npcbangladesh.org/', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(36, 'brand_name', 'Brand Name', 'National Paralympic Committee of Bangladesh', 1, 1, '2025-12-13 08:56:30', '2026-01-24 23:43:36'),
(37, 'breadcrumb', 'Breadcrumb', 'settings/breadcrumb_1766415619_69495d03dcc4b.webp', 1, 1, '2025-12-13 08:56:30', '2025-12-13 08:56:30'),
(38, 'send_from', 'Send From', 'contact@npcbangladesh.org', 1, 1, '2025-12-13 08:56:30', '2026-01-26 23:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `enabled` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `key`, `image`, `title`, `description`, `link`, `order`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 'banner_section', 'sliders/1/images/banner_image_69706bc3a44f3.jpg', 'Three golds for Bangladesh at Asian Youth Para Games', 'Bangladesh’s para-athletes delivered a landmark performance at the Asian Youth Para Games in Dubai, winning two gold medals and one bronze in one of the country’s most successful outings at the event.', 'https://tob.news/another-gold-for-bangladesh-at-asian-youth-para-games/', 1, 1, '2025-12-13 08:56:32', '2026-01-21 00:01:39'),
(2, 'banner_section', 'sliders/2/images/banner_image_6956084adde00.jpg', 'Asian Youth Para Games 2025, Dubai', 'Asian Youth Para Games', 'https://www.facebook.com/share/v/1EwvqbxGZ1/', 5, 1, '2025-12-13 08:56:32', '2025-12-31 23:38:18'),
(3, 'banner_section', 'sliders/3/images/banner_image_69560f6dc8b60.jpg', 'Bangladesh paralympic team at Asian Youth Para Games 2025, Dubai', 'Carrying the national flag with pride, our young para-athletes take center stage at the Asian Youth Para Games 2025. This ceremony marks the beginning of a journey fueled by resilience, sportsmanship,', 'https://www.facebook.com/BangladeshParalympic/posts/asian-youth-para-games-2025asian-paralympic-committee-national-paralympic-commit/848034277821026/', 2, 1, '2025-12-13 08:56:32', '2026-01-01 00:08:45'),
(4, 'banner_section', 'sliders/4/images/banner_image_695605dae8262.jpg', 'An absolute honor to meet with Andrew Parsons, President of the International Paralympic Committee.', 'An absolute honor to meet with Andrew Parsons, President of the International Paralympic Committee.', 'https://www.facebook.com/BangladeshParalympic', 2, 1, '2025-12-23 08:00:43', '2025-12-31 23:27:54'),
(5, 'banner_section', 'sliders/5/images/banner_image_69560dd332b64.jpg', 'Warm greetings with the President of the Asian Paralympic Committee', 'A productive meeting and warm greetings with the President of the Asian Paralympic Committee, Majid Rashed.', 'https://www.facebook.com/BangladeshParalympic', 2, 1, '2025-12-31 23:17:37', '2026-01-01 00:01:55'),
(6, 'banner_section', 'sliders/6/images/banner_image_695645eea54ee.jpg', 'President BPC Md. Masudul Hassan handing over crest at Amputee Football Festival', 'President BPC Md. Masudul Hassan handing over crest at Amputee Football Festival', 'https://www.facebook.com/BangladeshParalympic', 6, 1, '2026-01-01 04:01:18', '2026-01-01 04:01:18'),
(7, 'banner_section', 'sliders/7/images/banner_image_696243e554c1c.jpeg', 'The Physically Challenged Cricket Tournament is organized by the National Paralympic Committee of Bangladesh.', 'বিসিবির ফিজিক্যাল চ্যালেঞ্জড ক্রিকেট উইং এবং এনপিসিরি সহায়তায় জাপান প্যারা ব্যাডমিন্টন ইন্টারন্যাশনালে অসাধারণ নৈপুণ্য দেখিয়ে ব্রোঞ্জজয়ী আলী ইমাম ও জয়তুধরকে আনুষ্ঠানিক স্বীকৃতি দেওয়া হয়', 'https://shorturl.at/79Sab', 7, 1, '2026-01-10 06:19:49', '2026-01-10 21:07:38'),
(8, 'banner_section', 'sliders/8/images/banner_image_696244861bc91.jpeg', 'National Youth Para Games begin on the dream stage of disabled youth', 'তিনটি ইভেন্টে দুই শতাধিক শারীরিক প্রতিবন্ধী ক্রীড়াবিদের অংশগ্রহণে শুরু হয়েছে জাতীয় যুব প্যারা গেমস। ১২ থেকে ২০ বছর বয়সী তরুণ ক্রীড়াবিদরা অংশ নিচ্ছেন সাঁতার, দৌড় ও তায়কোয়ান্দো প্রতিযোগিতায়।\r\n\r\nশুক্রবার পড়ন্ত বিকেলে ঢাকা জাতীয় স্টেডিয়ামে দুই দিনব্যাপী এই প্রতিযোগিতার উদ্বোধন করেন যুব ও ক্রীড়া মন্ত্রণালয়ের সচিব মাহবুব উল আলম। উদ্বোধনী অনুষ্ঠানে উপস্থিত ছিলেন জাতীয় ক্রীড়া পরিষদের নির্বাহী পরিচালক কাজী নজরুল ইসলাম, জাতীয় ক্রিকেট দলের সাবেক অধিনায়ক হাবিবুল বাশার, সানোয়ার হোসেন, জাভেদ ওমর বেলিম এবং ন্যাশনাল প্যারালিম্পিক কমিটি অব বাংলাদেশের (এনপিসি) মহাসচিব ডা. মারুফ আহমেদ মৃদুল।', 'https://uttarbhumi.com/Sport/14959', 8, 1, '2026-01-10 06:22:30', '2026-01-10 21:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super@gmail.com', NULL, '$2y$12$afYnqgtfYFq8ThjpJRUKpu9WJl5xR749H3Qstgit2IyUsQmgKG1lm', NULL, '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(2, 'Admin', 'admin@gmail.com', NULL, '$2y$12$AzpBZVAYIDITSMZAf9MCsuxo75Du0AddAvLVJl.hbyMON6rqJcjzG', NULL, '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(3, 'Editor', 'editor@gmail.com', NULL, '$2y$12$f9qYqFDTpMe/LotH2fgiC.51qYTTaiMCaUkhmi9eEZvGtD7faESeS', NULL, '2025-12-13 08:56:29', '2025-12-13 08:56:29'),
(4, 'Viewer', 'viewer@gmail.com', NULL, '$2y$12$YIQisaqCvfncai2BUuHt5.DdTLrRoTDy9xNQwneZAC7.zv/Ph7lKi', NULL, '2025-12-13 08:56:29', '2025-12-13 08:56:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogs_createdby_foreign` (`createdBy`),
  ADD KEY `blogs_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `blog_category_maps`
--
ALTER TABLE `blog_category_maps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_category_maps_blog_id_foreign` (`blog_id`),
  ADD KEY `blog_category_maps_blog_category_id_foreign` (`blog_category_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `category_maps`
--
ALTER TABLE `category_maps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_maps_post_id_foreign` (`post_id`),
  ADD KEY `category_maps_category_id_foreign` (`category_id`);

--
-- Indexes for table `committee_members`
--
ALTER TABLE `committee_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD KEY `events_event_category_id_foreign` (`event_category_id`),
  ADD KEY `events_createdby_foreign` (`createdBy`),
  ADD KEY `events_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_categories_parent_id_foreign` (`parent_id`),
  ADD KEY `event_categories_createdby_foreign` (`createdBy`),
  ADD KEY `event_categories_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_details`
--
ALTER TABLE `gallery_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_details_gallery_id_foreign` (`gallery_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_category_id_foreign` (`category_id`),
  ADD KEY `menu_items_page_id_foreign` (`page_id`),
  ADD KEY `menu_items_parent_id_foreign` (`parent_id`),
  ADD KEY `menu_items_menu_id_parent_id_order_index` (`menu_id`,`parent_id`,`order`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_createdby_foreign` (`createdBy`),
  ADD KEY `news_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `news_category_maps`
--
ALTER TABLE `news_category_maps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_category_maps_news_id_foreign` (`news_id`),
  ADD KEY `news_category_maps_news_category_id_foreign` (`news_category_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notices_slug_unique` (`slug`),
  ADD KEY `notices_createdby_foreign` (`createdBy`),
  ADD KEY `notices_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_createdby_foreign` (`createdBy`),
  ADD KEY `pages_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `players_slug_unique` (`slug`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_createdby_foreign` (`createdBy`),
  ADD KEY `posts_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `results_slug_unique` (`slug`),
  ADD KEY `results_createdby_foreign` (`createdBy`),
  ADD KEY `results_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sections_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_createdby_foreign` (`createdBy`),
  ADD KEY `settings_updatedby_foreign` (`updatedBy`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_category_maps`
--
ALTER TABLE `blog_category_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `category_maps`
--
ALTER TABLE `category_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `committee_members`
--
ALTER TABLE `committee_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `gallery_details`
--
ALTER TABLE `gallery_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=407;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news_category_maps`
--
ALTER TABLE `news_category_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `blogs_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_category_maps`
--
ALTER TABLE `blog_category_maps`
  ADD CONSTRAINT `blog_category_maps_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_category_maps_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_maps`
--
ALTER TABLE `category_maps`
  ADD CONSTRAINT `category_maps_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_maps_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `events_event_category_id_foreign` FOREIGN KEY (`event_category_id`) REFERENCES `event_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD CONSTRAINT `event_categories_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `event_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_categories_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `gallery_details`
--
ALTER TABLE `gallery_details`
  ADD CONSTRAINT `gallery_details_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_items_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `news_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD CONSTRAINT `news_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news_category_maps`
--
ALTER TABLE `news_category_maps`
  ADD CONSTRAINT `news_category_maps_news_category_id_foreign` FOREIGN KEY (`news_category_id`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_category_maps_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notices_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pages_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `results_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `settings_updatedby_foreign` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
