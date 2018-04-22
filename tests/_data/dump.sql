-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table global_gaming_test.bets
DROP TABLE IF EXISTS `bets`;
CREATE TABLE IF NOT EXISTS `bets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `match_date` date NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `predicted_winner` int(11) NOT NULL,
  `cancelled` tinyint(4) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bets_user_id_foreign` (`user_id`),
  KEY `bets_match_id_foreign` (`match_id`),
  CONSTRAINT `bets_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`),
  CONSTRAINT `bets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table global_gaming_test.bets: ~3 rows (approximately)
DELETE FROM `bets`;
/*!40000 ALTER TABLE `bets` DISABLE KEYS */;
INSERT INTO `bets` (`id`, `match_id`, `user_id`, `match_date`, `amount`, `predicted_winner`, `cancelled`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2018-04-21', 100.00, 1, 0, NULL, NULL, NULL),
	(2, 1, 2, '2018-04-21', 59.00, 2, 0, NULL, NULL, NULL),
	(3, 2, 2, '2018-04-30', 85.00, 1, 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `bets` ENABLE KEYS */;

-- Dumping structure for table global_gaming_test.matches
DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `home_team_id` int(10) unsigned NOT NULL,
  `visiting_team_id` int(10) unsigned NOT NULL,
  `match_date` date NOT NULL,
  `cancelled` tinyint(4) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matches_home_team_id_foreign` (`home_team_id`),
  KEY `matches_visiting_team_id_foreign` (`visiting_team_id`),
  CONSTRAINT `matches_home_team_id_foreign` FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `matches_visiting_team_id_foreign` FOREIGN KEY (`visiting_team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table global_gaming_test.matches: ~2 rows (approximately)
DELETE FROM `matches`;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
INSERT INTO `matches` (`id`, `home_team_id`, `visiting_team_id`, `match_date`, `cancelled`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, '2018-04-21', 0, NULL, NULL, NULL),
	(2, 2, 1, '2018-04-30', 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;

-- Dumping structure for table global_gaming_test.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table global_gaming_test.migrations: 7 rows
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2018_04_20_171547_create_table_users', 1),
	(2, '2018_04_20_210531_create_table_books', 1),
	(3, '2018_04_20_210548_create_table_books_users', 1),
	(4, '2018_04_20_211104_create_table_teams', 1),
	(5, '2018_04_20_211118_create_table_matches', 1),
	(6, '2018_04_20_211131_create_table_bets', 1),
	(7, '2018_04_20_213119_create_table_wins', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table global_gaming_test.teams
DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teams_team_name_unique` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table global_gaming_test.teams: ~2 rows (approximately)
DELETE FROM `teams`;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` (`id`, `team_name`, `city`, `rank`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'team 1', 'safgsd', '1', 1, NULL, NULL, NULL),
	(2, 'team 2', 'sfag', '2', 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;

-- Dumping structure for table global_gaming_test.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `last_login` timestamp NULL DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table global_gaming_test.users: ~3 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `address`, `country`, `language`, `currency`, `phone`, `balance`, `last_login`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'testuser', 'testuser@test.net', '$2y$10$RTNmqFViZ8ZC9BFmS7qkMOY596orK2Z6z9aOcSDAV/U30z.lwWwrq', 'testuser', 'testuser', 'Triq something', 'Malta', 'en', 'EUR', 'testuser', 0.00, NULL, 1, NULL, '2018-04-21 18:12:36', '2018-04-21 18:12:36'),
	(2, 'testuser2', 'testuse2r@test.net', '$2y$10$RTNmqFViZ8ZC9BFmS7qkMOY596orK2Z6z9aOcSDAV/U30z.lwWwrq', 'testuser', 'testuser', 'Triq something', 'Malta', 'en', 'EUR', 'testuser', 0.00, NULL, 1, NULL, '2018-04-21 18:12:36', '2018-04-21 18:12:36'),
	(3, 'testuser3', 'testuser3@test.net', '$2y$10$RTNmqFViZ8ZC9BFmS7qkMOY596orK2Z6z9aOcSDAV/U30z.lwWwrq', 'testuser', 'testuser', 'Triq something', 'Malta', 'en', 'EUR', 'testuser', 0.00, NULL, 1, NULL, '2018-04-21 18:12:36', '2018-04-21 18:12:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table global_gaming_test.wins
DROP TABLE IF EXISTS `wins`;
CREATE TABLE IF NOT EXISTS `wins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `match_date` timestamp NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `balance` decimal(8,2) NOT NULL,
  `predicted_winner` int(11) NOT NULL,
  `cancelled` tinyint(4) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wins_user_id_foreign` (`user_id`),
  KEY `wins_match_id_foreign` (`match_id`),
  CONSTRAINT `wins_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`),
  CONSTRAINT `wins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table global_gaming_test.wins: ~0 rows (approximately)
DELETE FROM `wins`;
/*!40000 ALTER TABLE `wins` DISABLE KEYS */;
/*!40000 ALTER TABLE `wins` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
