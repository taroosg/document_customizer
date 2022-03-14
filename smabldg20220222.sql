-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 2 月 22 日 05:43
-- サーバのバージョン： 10.4.20-MariaDB
-- PHP のバージョン: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `smabldg`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `data` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `data`
--

INSERT INTO `data` (`id`, `document_id`, `item_id`, `data`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'title', '2022-02-20 16:34:36', '2022-02-20 16:34:36'),
(2, 2, 2, '2-21', '2022-02-20 16:34:36', '2022-02-20 16:34:36'),
(3, 2, 3, 'good', '2022-02-20 16:34:36', '2022-02-20 16:34:36'),
(4, 2, 4, 'todo', '2022-02-20 16:34:36', '2022-02-20 16:34:36'),
(15, 5, 1, '解雇', '2022-02-20 16:40:28', '2022-02-20 16:40:28'),
(16, 5, 2, '2-22', '2022-02-20 16:40:28', '2022-02-20 16:40:28'),
(17, 5, 3, 'good', '2022-02-20 16:40:28', '2022-02-20 16:40:28'),
(18, 5, 4, 'todo', '2022-02-20 16:40:28', '2022-02-20 16:40:28'),
(19, 6, 1, '講義', '2022-02-20 16:44:41', '2022-02-20 16:44:41'),
(20, 6, 2, '2-23', '2022-02-20 16:44:41', '2022-02-20 16:44:41'),
(21, 6, 3, 'good', '2022-02-20 16:44:41', '2022-02-20 16:44:41'),
(22, 6, 4, 'todo', '2022-02-20 16:44:41', '2022-02-20 16:44:41'),
(23, 7, 5, '2-20', '2022-02-20 16:48:21', '2022-02-20 16:48:21'),
(24, 7, 6, 'testuser', '2022-02-20 16:48:21', '2022-02-20 16:48:21'),
(25, 7, 7, 'meta', '2022-02-20 16:48:21', '2022-02-20 16:48:21'),
(26, 7, 8, 'mit', '2022-02-20 16:48:21', '2022-02-20 16:48:21'),
(27, 7, 9, 'mba', '2022-02-20 16:48:21', '2022-02-20 16:48:21'),
(28, 8, 10, 'Google', '2022-02-20 17:47:49', '2022-02-20 17:47:49'),
(29, 8, 11, 'エリック', '2022-02-20 17:47:49', '2022-02-20 17:47:49'),
(30, 8, 12, '1000000', '2022-02-20 17:47:49', '2022-02-20 17:47:49'),
(31, 9, 13, 'ジェフ', '2022-02-22 11:37:11', '2022-02-22 11:37:11'),
(32, 9, 14, '2-22', '2022-02-22 11:37:11', '2022-02-22 11:37:11'),
(33, 9, 15, '新規事業アイデア3つ', '2022-02-22 11:37:11', '2022-02-22 11:37:11'),
(34, 9, 16, '全て完了', '2022-02-22 11:37:11', '2022-02-22 11:37:11'),
(35, 9, 17, 'なし', '2022-02-22 11:37:11', '2022-02-22 11:37:11');

-- --------------------------------------------------------

--
-- テーブルの構造 `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `format_id` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `documents`
--

INSERT INTO `documents` (`id`, `format_id`, `date`, `created_at`, `updated_at`) VALUES
(2, '10', '2022-02-20', '2022-02-20 16:34:36', '2022-02-20 16:34:36'),
(5, '10', '2022-02-21', '2022-02-20 16:40:28', '2022-02-20 16:40:28'),
(6, '10', '2022-02-25', '2022-02-20 16:44:41', '2022-02-20 16:44:41'),
(7, '11', '2022-02-20', '2022-02-20 16:48:21', '2022-02-20 16:48:21'),
(8, '12', '2022-02-20', '2022-02-20 17:47:49', '2022-02-20 17:47:49'),
(9, '13', '2022-02-22', '2022-02-22 11:37:11', '2022-02-22 11:37:11');

-- --------------------------------------------------------

--
-- テーブルの構造 `formats`
--

CREATE TABLE `formats` (
  `id` int(11) NOT NULL,
  `format_name` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `team_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `formats`
--

INSERT INTO `formats` (`id`, `format_name`, `team_id`, `created_at`, `updated_at`) VALUES
(10, '報告書', 1, '2022-02-20 15:25:51', '2022-02-20 15:25:51'),
(11, '履歴書', 1, '2022-02-20 15:28:36', '2022-02-20 15:28:36'),
(12, '契約書', 2, '2022-02-20 17:47:25', '2022-02-20 17:47:25'),
(13, '日報', 2, '2022-02-22 11:36:12', '2022-02-22 11:36:12');

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `format_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`id`, `item_name`, `format_id`, `created_at`, `updated_at`) VALUES
(1, 'タイトル', 10, '2022-02-20 15:25:51', '2022-02-20 15:25:51'),
(2, '日付', 10, '2022-02-20 15:25:51', '2022-02-20 15:25:51'),
(3, '結論', 10, '2022-02-20 15:25:51', '2022-02-20 15:25:51'),
(4, '宿題', 10, '2022-02-20 15:25:51', '2022-02-20 15:25:51'),
(5, '日付', 11, '2022-02-20 15:28:36', '2022-02-20 15:28:36'),
(6, '氏名', 11, '2022-02-20 15:28:36', '2022-02-20 15:28:36'),
(7, '職歴', 11, '2022-02-20 15:28:36', '2022-02-20 15:28:36'),
(8, '学歴', 11, '2022-02-20 15:28:36', '2022-02-20 15:28:36'),
(9, '資格', 11, '2022-02-20 15:28:36', '2022-02-20 15:28:36'),
(10, '相手企業名', 12, '2022-02-20 17:47:25', '2022-02-20 17:47:25'),
(11, '担当者', 12, '2022-02-20 17:47:25', '2022-02-20 17:47:25'),
(12, '契約金額', 12, '2022-02-20 17:47:25', '2022-02-20 17:47:25'),
(13, '担当者', 13, '2022-02-22 11:36:12', '2022-02-22 11:36:12'),
(14, '日付', 13, '2022-02-22 11:36:12', '2022-02-22 11:36:12'),
(15, '当日目標', 13, '2022-02-22 11:36:12', '2022-02-22 11:36:12'),
(16, '完了項目', 13, '2022-02-22 11:36:12', '2022-02-22 11:36:12'),
(17, '未完了項目', 13, '2022-02-22 11:36:12', '2022-02-22 11:36:12');

-- --------------------------------------------------------

--
-- テーブルの構造 `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `teams`
--

INSERT INTO `teams` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Google', '2022-02-20 13:50:42', '2022-02-20 13:50:42'),
(2, 'Amazon', '2022-02-20 13:50:42', '2022-02-20 13:50:42'),
(3, 'Meta', '2022-02-20 13:50:42', '2022-02-20 13:50:42'),
(4, 'Apple', '2022-02-20 13:50:42', '2022-02-20 13:50:42'),
(5, 'Microsoft', '2022-02-20 13:50:42', '2022-02-20 13:50:42');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `formats`
--
ALTER TABLE `formats`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- テーブルの AUTO_INCREMENT `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルの AUTO_INCREMENT `formats`
--
ALTER TABLE `formats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- テーブルの AUTO_INCREMENT `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
