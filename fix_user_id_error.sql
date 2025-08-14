-- Quick Fix for "user_id column not found" Error
-- Run this script in your database to fix the immediate issue

-- 1. Add user_id column to geo_links table
ALTER TABLE `geo_links` 
ADD COLUMN `user_id` int(11) DEFAULT NULL AFTER `id`;

-- 2. Add user_id column to geo_logs table  
ALTER TABLE `geo_logs` 
ADD COLUMN `user_id` int(11) DEFAULT NULL AFTER `id`;

-- 3. Create users table if it doesn't exist
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL UNIQUE,
    `email` varchar(100) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `first_name` varchar(50) DEFAULT NULL,
    `last_name` varchar(50) DEFAULT NULL,
    `role` enum('user', 'admin') DEFAULT 'user',
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `last_login` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_username` (`username`),
    KEY `idx_email` (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 4. Insert default admin user (password: admin123)
INSERT IGNORE INTO `users` (
    `username`,
    `email`,
    `password`,
    `first_name`,
    `last_name`,
    `role`
) VALUES (
    'admin',
    'admin@keizai-tech.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Admin',
    'User',
    'admin'
);

-- 5. Assign existing links and logs to admin user (ID 1)
UPDATE `geo_links` SET `user_id` = 1 WHERE `user_id` IS NULL;
UPDATE `geo_logs` SET `user_id` = 1 WHERE `user_id` IS NULL;

-- Done! Now you should be able to create tracking links without errors.
