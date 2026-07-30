-- Database schema for PHP Blog Engine
-- MySQL 8.x, InnoDB, utf8mb4_unicode_ci

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Categories table
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Articles table
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `image` VARCHAR(500),
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `content` LONGTEXT,
    `views` INT DEFAULT 0,
    `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_published_at` (`published_at`),
    INDEX `idx_views` (`views`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Article-Category junction table (many-to-many)
DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category` (
    `article_id` INT NOT NULL,
    `category_id` INT NOT NULL,
    PRIMARY KEY (`article_id`, `category_id`),
    INDEX `idx_category_id` (`category_id`),
    INDEX `idx_category_article` (`category_id`, `article_id`),
    FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;