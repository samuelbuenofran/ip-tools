-- Database Updates for IP Tools Suite MVC System
-- Run these updates to fix the "user_id column not found" error

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

-- 5. Add foreign key constraints (optional - only if you want referential integrity)
-- ALTER TABLE `geo_links` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL;
-- ALTER TABLE `geo_logs` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL;

-- 6. Update existing geo_links to assign them to admin user (assuming admin has ID 1)
UPDATE `geo_links` SET `user_id` = 1 WHERE `user_id` IS NULL;

-- 7. Update existing geo_logs to assign them to admin user (assuming admin has ID 1)
UPDATE `geo_logs` SET `user_id` = 1 WHERE `user_id` IS NULL;

-- 8. Add missing columns to geo_logs for enhanced tracking
ALTER TABLE `geo_logs` 
ADD COLUMN `location_type` enum('IP','GPS','Manual') DEFAULT 'IP' AFTER `longitude`,
ADD COLUMN `accuracy` decimal(5,2) DEFAULT NULL AFTER `location_type`,
ADD COLUMN `address` text AFTER `accuracy`,
ADD COLUMN `street` varchar(255) DEFAULT NULL AFTER `address`,
ADD COLUMN `house_number` varchar(20) DEFAULT NULL AFTER `street`,
ADD COLUMN `postcode` varchar(20) DEFAULT NULL AFTER `house_number`,
ADD COLUMN `state` varchar(100) DEFAULT NULL AFTER `postcode`;

-- 9. Update existing geo_logs to have location_type = 'IP' if it's NULL
UPDATE `geo_logs` SET `location_type` = 'IP' WHERE `location_type` IS NULL;

-- 10. Add indexes for better performance
ALTER TABLE `geo_links` ADD INDEX `idx_user_id` (`user_id`);
ALTER TABLE `geo_logs` ADD INDEX `idx_user_id` (`user_id`);
ALTER TABLE `geo_logs` ADD INDEX `idx_link_id` (`link_id`);
ALTER TABLE `geo_logs` ADD INDEX `idx_timestamp` (`timestamp`);

-- Database is now fully set up for the MVC system!